<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function dashboard()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $transactions = $user->transactions()->latest()->take(5)->get();

        // 1. On récupère le niveau actuel et le niveau suivant
        $currentLevel = $user->level; // Le niveau que le joueur a déjà atteint
        $nextLevel = \App\Models\Level::where('min_xp', '>', $user->xp_points)
            ->orderBy('min_xp', 'asc')
            ->first();

        // 2. Initialisation des variables de progression
        $minXp = $currentLevel ? $currentLevel->min_xp : 0; // Palier du niveau actuel (ex: 500)

        if ($nextLevel) {
            $targetXp = $nextLevel->min_xp; // Palier à atteindre (ex: 1000)

            // Calcul relatif : (XP actuel - Min du niveau) / (Cible - Min du niveau)
            $xpInLevel = $user->xp_points - $minXp;
            $xpNeededForNext = $targetXp - $minXp;

            $progress = min(100, round(($xpInLevel / $xpNeededForNext) * 100));
            $xpRemaining = $targetXp - $user->xp_points;
        }
        else {
            // Si le joueur est au niveau maximum
            $progress = 100;
            $xpRemaining = 0;
            $targetXp = $user->xp_points;
        }

        // --- On récupère les prochains matchs ---
        $upcomingReservations = $user->reservations()
            ->with('court')
            ->where('start_time', '>=', now())
            ->where('status', '!=', 'canceled')
            ->orderBy('start_time', 'asc')
            ->get();

        $nextMatch = $upcomingReservations->first();

        return view('player.dashboard', compact(
            'transactions',
            'nextLevel',
            'progress',
            'targetXp',
            'upcomingReservations',
            'nextMatch',
            'xpRemaining' // On passe aussi les points restants, c'est plus sympa à afficher
        ));
    }



    public function recharge()
    {
        return view('player.recharge');
    }

    public function createRechargeIntent(\Illuminate\Http\Request $request)
    {
        // On récupère le nombre de crédits demandés depuis le Javascript
        $requestedPC = (int)$request->amount_pc;

        if ($requestedPC < 50) {
            return response()->json(['error' => 'Le minimum de recharge est de 50 PC.']);
        }

        // --- Cerveau anti-triche : C'est le back-end qui fixe les prix ! ---
        $priceInDh = $requestedPC; // Tarif de base (1 PC = 1 DH)

        if ($requestedPC == 500) {
            $priceInDh = 450; // Promo 500 PC
        }
        elseif ($requestedPC == 1200) {
            $priceInDh = 1000; // Promo 1200 PC
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $priceInDh * 100, // Stripe veut systématiquement l'argent en centimes
            'currency' => 'mad', // Dirham Marocain
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'pc' => $requestedPC // On renvoie à JS la vraie valeur pour la garder intacte !
        ]);

    }

    public function rechargeProcess(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // On récupère le montant sécurisé que notre API avait validé et renvoyé
        $pcToAdd = (int)$request->verified_pc;

        if ($pcToAdd > 0) {
            // Jackpot, on ajoute l'argent !
            $user->coins_balance += $pcToAdd;
            $user->save();
            // On sauvegarde la transaction dans l'historique
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => $pcToAdd,
                'type' => 'recharge_stripe',
            ]);
        }

        return redirect('/player/dashboard')->with('success', 'Votre compte a été rechargé de ' . $pcToAdd . ' Plaza Coins avec succès !');
    }
    public function transactions(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // On prépare la requête
        $query = $user->transactions()->with('reservation.court');

        // 1. Filtre par TYPE (réservation, recharge, cashback)
        if ($request->filled('type')) {
            // Pour les recharges, on gère les deux types possibles (admin ou stripe)
            if ($request->type === 'recharge') {
                $query->whereIn('type', ['recharge_admin', 'recharge_stripe']);
            }
            else {
                $query->where('type', $request->type);
            }
        }

        // 2. Filtre par MOIS
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filtre par ANNÉE
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // On récupère le tout classé par date
        $transactions = $query->latest()->get();

        return view('player.transactions', compact('transactions'));
    }

    public function matchs(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // 1. Prochains matchs (aujourd'hui et après, statut confirmé)
        $upcomingMatches = $user->reservations()
            ->with('court')
            ->where('start_time', '>=', now())
            ->where('status', 'confirmed')
            ->orderBy('start_time', 'asc')
            ->get();

        // 2. Préparation de la requête pour l'Historique (matchs passés)
        $query = $user->reservations()
            ->with('court')
            ->where('start_time', '<', now());

        // Filtrage optionnel par mois et année
        if ($request->filled('month')) {
            $query->whereMonth('start_time', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('start_time', $request->year);
        }

        // Tri (par défaut du plus récent au plus ancien)
        $order = $request->input('sort', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy('start_time', $order);

        // Cette variable contient les matchs filtrés pour l'affichage de la liste
        $pastMatches = $query->get();

        // --- 3. Calcul des statistiques GLOBALES (pour le footer) ---

        // On récupère tous les matchs passés sans les filtres de recherche
        $allPast = $user->reservations()->where('start_time', '<', now())->get();

        // Ratio Victoire : (Wins / (Wins + Losses)) * 100
        $wins = $allPast->where('result', 'win')->count();
        $losses = $allPast->where('result', 'loss')->count();
        $totalRated = $wins + $losses;
        $winRate = $totalRated > 0 ? round(($wins / $totalRated) * 100) : 0;

        // Temps de jeu : 1 match = 1 heure (count simple)
        $totalPlayTime = $allPast->count();

        return view('player.matchs', compact('upcomingMatches', 'pastMatches', 'winRate', 'totalPlayTime'));
    }

    public function updateMatchResult($id, \Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $reservation = \App\Models\Reservation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // On change le résultat
        if ($reservation->result === $request->result) {
            $reservation->result = null;
        }
        else {
            $reservation->result = $request->result;
        }
        $reservation->save();

        // --- NOUVEAU : On recalcule le ratio global pour le renvoyer à la vue ---
        $allPast = $user->reservations()->where('start_time', '<', now())->get();
        $wins = $allPast->where('result', 'win')->count();
        $losses = $allPast->where('result', 'loss')->count();
        $totalRated = $wins + $losses;
        $newWinRate = $totalRated > 0 ? round(($wins / $totalRated) * 100) : 0;

        // On renvoie le résultat ET le nouveau ratio
        return response()->json([
            'result' => $reservation->result,
            'newRate' => $newWinRate
        ]);
    }


}
