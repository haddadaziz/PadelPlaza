<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Affiche la page de Gestion des Réservations pour l'Admin
    public function indexAdmin()
    {
        // Sécurité
        if (Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        // On récupère toutes les réservations en base de données.
        // Le "with" est une astuce Laravel pour charger rapidement le nom du Terrain et du Joueur liés.
        $reservations = Reservation::with(['user', 'court'])->latest()->get();

        return view('admin.reservations', compact('reservations'));
    }
    // Etape 1 : Afficher le choix du terrain et de l'heure
    public function create()
    {
        // On va chercher uniquement les terrains qui sont ouverts
        $courts = \App\Models\Court::where('is_active', true)->get();
        return view('player.reservations.create', compact('courts'));
    }

    // Etape 2 : Gère quand le joueur clique sur "Suivant"
    // Etape 2 : Choix des options (Equipements)
    public function options(\Illuminate\Http\Request $request)
    {
        // 1. On vérifie que le joueur n'a rien oublié dans l'étape 1
        $request->validate([
            'court_id' => 'required',
            'date' => 'required',
            'time_slot' => 'required'
        ]);

        // 2. On récupère le terrain choisi pour l'afficher
        $court = \App\Models\Court::findOrFail($request->court_id);

        // 3. On va chercher tous les équipements où le stock est supérieur à 0
        $equipments = \App\Models\Equipment::where('stock', '>', 0)->get();

        // 4. On transmet tout ça à la nouvelle vue
        return view('player.reservations.options', [
            'court' => $court,
            'equipments' => $equipments,
            'date' => $request->date,
            'time_slot' => $request->time_slot
        ]);
    }
    // Etape 3 : Affichage du récapitulatif final et du Bouton "Payer"
    public function checkout(\Illuminate\Http\Request $request)
    {
        $court = \App\Models\Court::findOrFail($request->court_id);

        $equipmentTotal = 0;
        $selectedEquipments = [];

        if ($request->has('equipments')) {
            foreach ($request->equipments as $id => $qty) {
                if ((int)$qty > 0) {
                    $equipment = \App\Models\Equipment::findOrFail($id);
                    $equipmentTotal += ($equipment->price_coins * $qty);
                    $selectedEquipments[$id] = ['item' => $equipment, 'qty' => $qty];
                }
            }
        }

        $totalPrice = $court->price_coins + $equipmentTotal;

        // ---- CONNECTER STRIPE ----
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // On crée l'intention et le "secret bancaire" (Stripe calcule en centimes, on fait donc * 100)
        // On part du principe que 1 PC = 1 EUR.
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $totalPrice * 100,
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return view('player.reservations.checkout', [
            'court' => $court,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'selectedEquipments' => $selectedEquipments,
            'totalPrice' => $totalPrice,
            // C'est ce code secret qui autorisera la carte bancaire via ton Javascript
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        // 1. On vérifie la requête
        $request->validate([
            'court_id' => 'required',
            'date' => 'required|date'
        ]);

        // 2. On crée "à la main" nos 24 créneaux de la journée
        $allSlots = [];
        for ($heure = 0; $heure <= 23; $heure++) {
            // Si l'heure est plus petite que 10, on ajoute un 0 (ex: "08:00") sinon on l'écrit normalement (ex: "14:00")
            if ($heure < 10) {
                $allSlots[] = "0" . $heure . ":00";
            }
            else {
                $allSlots[] = $heure . ":00";
            }
        }

        // 3. On demande la liste complète des réservations de ce terrain, à cette date
        $reservationsExistantes = \App\Models\Reservation::where('court_id', $request->court_id)
            ->whereDate('start_time', $request->date)
            ->where('status', '!=', 'canceled')
            ->get();

        // 4. On crée une liste vide, qu'on va remplir avec les "heures" seulement
        $heuresPrises = [];

        foreach ($reservationsExistantes as $reservation) {
            // On extrait juste "14:00" à partir de la date complète "2026-04-18 14:00:00"
            $heureFormatter = \Carbon\Carbon::parse($reservation->start_time)->format('H:i');

            // On ajoute cette heure dans notre liste des Heures Prises
            $heuresPrises[] = $heureFormatter;
        }

        // 5. On crée notre liste finale des heures libres ET non passées
        $heuresDisponibles = [];

        // On récupère la date d'aujourd'hui (ex: "2026-04-19")
        $dateAujourdhui = date('Y-m-d');





        
// On utilise 'now()' pour être certain d'avoir la bonne heure du fuseau local de l'application        $heureActuelle = (int)now()->format('H');


        // On passe une à une sur les 24 heures de la journée
        foreach ($allSlots as $creneau) {

            // On récupère juste le chiffre de l'heure du créneau (on transforme "08:00" en 8)
            $heureDuCreneau = (int)substr($creneau, 0, 2);

            // Règle A : Est-ce que le créneau est dans le passé ?
            $estPasse = false;
            if ($request->date == $dateAujourdhui) {
                // Si c'est pour aujourd'hui, et que l'heure du créneau est avant (ou égale à) l'heure actuelle
                if ($heureDuCreneau <= $heureActuelle + 1) {
                    $estPasse = true; // Trop tard !
                }
            }

            // Règle B : Est-ce que ce créneau est déjà réservé en base de données ?
            $estPris = false;
            if (in_array($creneau, $heuresPrises)) {
                $estPris = true; // Déjà réservé !
            }

            // VERDICT : Si le créneau n'est PAS passé (false) ET n'est PAS pris (false)...
            if ($estPasse == false && $estPris == false) {
                // ... Alors il est parfaitement disponible !
                $heuresDisponibles[] = $creneau;
            }
        }

        // 6. On renvoie enfin nos heures disponibles au navigateur web !
        return response()->json([
            'available_slots' => $heuresDisponibles
        ]);
    }
    public function process(\Illuminate\Http\Request $request)
    {
        // 1. On recalcule le montant (règle de sécurité : ne jamais faire confiance au Javascript pour les prix)
        $court = \App\Models\Court::findOrFail($request->court_id);
        $totalPrice = $court->price_coins;

        $equipmentsInfo = []; // <--- Le chariot virtuel de l'admin

        if ($request->has('equipments')) {
            foreach ($request->equipments as $id => $qty) {
                if ((int)$qty > 0) {
                    $equipment = \App\Models\Equipment::findOrFail($id);
                    $totalPrice += ($equipment->price_coins * $qty);

                    // On enregistre ce qu'il a pris pour l'Affichage Admin !
                    $equipmentsInfo[] = [
                        'name' => $equipment->name,
                        'qty' => (int)$qty,
                    ];
                }
            }
        }


        $user = \Illuminate\Support\Facades\Auth::user();

        // 2. Traitement des Plaza Coins et du CASHBACK
        if ($request->payment_method === 'coins') {
            if ($user->coins_balance < $totalPrice) {
                return redirect()->back()->withErrors(['Erreur : Vous n\'avez pas assez de Plaza Coins.']);
            }

            // Calcul du cashback (5% de la réservation)
            $cashback = ceil($totalPrice * 0.05);

            // 3. Mise à jour instantanée et ultra-sécurisée du solde en BDD
            $user->decrement('coins_balance', $totalPrice);
            $user->increment('coins_balance', $cashback);


            // 1) Ligne Historique de la Dépense
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => -$totalPrice,
                'type' => 'reservation',
                'description' => $court->name
            ]);

            // 2) Ligne Historique du Gain (Cashback)
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => $cashback,
                'type' => 'cashback',
                'description' => 'Cashback de réservation'
            ]);
        }

        // 3. Conversion de la date pour la BDD (ex: "2026-04-19" + "18:30" => "2026-04-19 18:30:00")
        $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time_slot);

        // 4. Enregistrement du terrain ! 🎾
        $reservation = new \App\Models\Reservation();
        $reservation->user_id = $user->id;
        $reservation->court_id = $court->id;
        $reservation->start_time = $start_time;
        $reservation->status = 'confirmed'; // Confirmé d'office car payé !

        // --- ON AJOUTE LES DÉTAILS ICI ---
        $reservation->total_price = $totalPrice;
        $reservation->equipments_info = $equipmentsInfo;
        $reservation->save();

        // --- MISE A JOUR DE L'XP (GAMIFICATION) ---
        // Le prix total payé en Plaza Coins = L'XP gagnée !
        $user->xp_points += $totalPrice;
        
        // On vérifie immédiatement si ce nouvel XP permet de débloquer le rang supérieur
        $newLevel = \App\Models\Level::where('min_xp', '<=', $user->xp_points)->orderBy('min_xp', 'desc')->first();
        if ($newLevel) {
            $user->level_id = $newLevel->id;
        }
        $user->save();

        // 5. On termine en l'envoyant sur son Dashboard avec un message Flash de gloire
        return redirect('/player/dashboard')->with('success', 'Ton match est confirmé ! Prépare tes balles !');
    }
    // ==========================================
    // SECTION ADMINISTRATEUR
    // ==========================================

    public function adminCreate()
    {
        // On récupère les terrains ouverts
        $courts = \App\Models\Court::where('is_active', true)->get();

        // On récupère les équipements en stock
        $equipments = \App\Models\Equipment::where('stock', '>', 0)->get();

        return view('admin.reservations.create', compact('courts', 'equipments'));
    }


    public function adminStore(\Illuminate\Http\Request $request)
    {
        // 1. Validation (On utilise player_identifier au lieu de user_id)
        $request->validate([
            'player_identifier' => 'required',
            'court_id' => 'required',
            'date' => 'required|date',
            'time_slot' => 'required'
        ]);

        // 2. Recherche Intelligente du Joueur 🦸‍♂️
        // Si c'est un chiffre, on cherche par ID, sinon on cherche par Email
        $query = \App\Models\User::query();
        if (is_numeric($request->player_identifier)) {
            $query->where('id', $request->player_identifier);
        } else {
            $query->where('email', $request->player_identifier);
        }
        $user = $query->first();

        // Sécurité : si on n'a trouvé personne
        if (!$user) {
            return redirect()->back()->withErrors(['Aucun joueur trouvé avec cet email ou ID.']);
        }

        // 3. Calculs des Prix et Equipements (Comme pour le joueur !)
        $court = \App\Models\Court::findOrFail($request->court_id);
        $totalPrice = $court->price_coins;
        $equipmentsInfo = [];

        if ($request->has('equipments')) {
            foreach ($request->equipments as $id => $qty) {
                if ((int)$qty > 0) {
                    $equipment = \App\Models\Equipment::findOrFail($id);
                    $totalPrice += ($equipment->price_coins * $qty);

                    $equipmentsInfo[] = [
                        'name' => $equipment->name,
                        'qty' => (int)$qty,
                    ];
                }
            }
        }

        // 4. Formatage de la date
        $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time_slot);

        // 5. Enregistrement en Base de Données
        $reservation = new \App\Models\Reservation();
        $reservation->user_id = $user->id; // On met le vrai ID trouvé !
        $reservation->court_id = $request->court_id;
        $reservation->start_time = $start_time;

        // Le statut dépend de la sélection de l'admin (Encaissé = confirmed, Attente = pending)
$reservation->status = 'confirmed';        
        $reservation->total_price = $totalPrice;
        $reservation->equipments_info = $equipmentsInfo;

        $reservation->save();

        // --- MISE A JOUR DE L'XP (SI ADMIN PAYE) ---
        $user->xp_points += $totalPrice;
        
        $newLevel = \App\Models\Level::where('min_xp', '<=', $user->xp_points)->orderBy('min_xp', 'desc')->first();
        if ($newLevel) {
            $user->level_id = $newLevel->id;
        }
        $user->save();

        // 6. Succès ! Retour à la liste
        return redirect()->route('admin.reservations')->with('success', 'Réservation traitée avec succès !');
    }
}
