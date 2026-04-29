<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function dashboard()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $transactions = $user->transactions()->latest()->take(5)->get();

        $currentLevel = $user->level;
        $nextLevel = \App\Models\Level::where('min_xp', '>', $user->xp_points)
            ->orderBy('min_xp', 'asc')
            ->first();

        // initialiser les variables pour calculer la progression
        $minXp = $currentLevel ? $currentLevel->min_xp : 0;

        if ($nextLevel) {
            $targetXp = $nextLevel->min_xp; // Palier à atteindre

            $xpInLevel = $user->xp_points - $minXp;
            $xpNeededForNext = $targetXp - $minXp;

            $progress = round(($xpInLevel / $xpNeededForNext) * 100);
            $xpRemaining = $targetXp - $user->xp_points;
        }
        else {
            //rang saphir
            $progress = 100;
            $xpRemaining = 0;
            $targetXp = $user->xp_points;
        }

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
            'xpRemaining'
        ));
    }



    public function recharge()
    {
        return view('player.recharge');
    }

    public function createRechargeIntent(\Illuminate\Http\Request $request)
    {

        $requestedPC = (int)$request->amount_pc;

        if ($requestedPC < 50) {
            return response()->json(['error' => 'Le minimum de recharge est de 50 PC.']);
        }

        $priceInDh = $requestedPC;

        if ($requestedPC == 500) {
            $priceInDh = 450;
        }
        elseif ($requestedPC == 1200) {
            $priceInDh = 1000;
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $priceInDh * 100, // centimes pr stripe
            'currency' => 'mad',
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'pc' => $requestedPC
        ]);

    }

    public function rechargeProcess(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $pcToAdd = (int)$request->verified_pc;

        if ($pcToAdd > 0) {
            $user->coins_balance += $pcToAdd;
            $user->save();
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => $pcToAdd,
                'type' => 'recharge_stripe',
            ]);
        }

        return redirect('/player/dashboard')->with('success', 'Votre compte a été rechargé de ' . $pcToAdd . ' Padel Plaza Coins avec succès !');
    }
    public function transactions(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $query = $user->transactions()->with('reservation.court');

        if ($request->filled('type')) {
            if ($request->type === 'recharge') {
                $query->whereIn('type', ['recharge_admin', 'recharge_stripe']);
            }
            else {
                $query->where('type', $request->type);
            }
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $transactions = $query->latest()->get();

        return view('player.transactions', compact('transactions'));
    }

    public function matchs(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $upcomingMatches = $user->reservations()
            ->with('court')
            ->where('start_time', '>=', now())
            ->where('status', 'confirmed')
            ->orderBy('start_time', 'asc')
            ->get();

        // matchs passsées
        $query = $user->reservations()
            ->with('court')
            ->where('start_time', '<', now());


        // filtrage par mois et année
        if ($request->filled('month')) {
            $query->whereMonth('start_time', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('start_time', $request->year);
        }

        // tri du plus récent au plus ancien
        $order = $request->input('sort', 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy('start_time', $order);

        // matchs filtrés
        $pastMatches = $query->get();


        //statistiques joueur
        $allPast = $user->reservations()->where('start_time', '<', now())->get();

        $wins = $allPast->where('result', 'win')->count();
        $losses = $allPast->where('result', 'loss')->count();
        $totalRated = $wins + $losses;
        $winRate = $totalRated > 0 ? round(($wins / $totalRated) * 100) : 0;
        $totalPlayTime = $allPast->count();

        return view('player.matchs', compact('upcomingMatches', 'pastMatches', 'winRate', 'totalPlayTime'));
    }

    public function updateMatchResult($id, \Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $reservation = \App\Models\Reservation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // changer le  résultat
        if ($reservation->result === $request->result) {
            $reservation->result = null;
        }
        else {
            $reservation->result = $request->result;
        }
        $reservation->save();

        //Recalculer les statistiques apres changement
        $allPast = $user->reservations()->where('start_time', '<', now())->get();
        $wins = $allPast->where('result', 'win')->count();
        $losses = $allPast->where('result', 'loss')->count();
        $totalRated = $wins + $losses;
        $newWinRate = $totalRated > 0 ? round(($wins / $totalRated) * 100) : 0;

        return response()->json([
            'result' => $reservation->result,
            'newRate' => $newWinRate
        ]);
    }


    public function exportTransactions(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $query = $user->transactions()->with('reservation.court');

        if ($request->filled('type')) {
            if ($request->type === 'recharge') {
                $query->whereIn('type', ['recharge_admin', 'recharge_stripe']);
            } else {
                $query->where('type', $request->type);
            }
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $transactions = $query->latest()->get();
        $filename = "mes_transactions_padel_" . date('Ymd_His') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Date', 'Description', 'Type', 'Montant (PC)'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($transactions as $t) {
                $description = "";
                if ($t->type === 'reservation') {
                    $description = "Réservation Court : " . ($t->reservation->court->name ?? 'N/A');
                } elseif ($t->type === 'recharge_stripe') {
                    $description = "Recharge Carte Bancaire";
                } elseif ($t->type === 'recharge_admin') {
                    $description = "Recharge Admin (Caisse)";
                } else {
                    $description = "Bonus / Autre";
                }

                fputcsv($file, [
                    $t->created_at->format('d/m/Y H:i'),
                    $description,
                    strtoupper($t->type),
                    $t->amount
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
