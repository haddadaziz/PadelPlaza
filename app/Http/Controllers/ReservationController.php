<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{


    // PARTIE JOUEUR
    public function indexAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        $reservations = Reservation::with(['user', 'court'])
            ->when(!request()->hasAny(['date', 'court_id', 'time_slot']), fn($q) => $q->where('start_time', '>=', now()))
            ->when(request('date'), fn($q) => $q->whereDate('start_time', request('date')))
            ->when(request('court_id'), fn($q) => $q->where('court_id', request('court_id')))
            ->when(request('time_slot'), function ($q) {
                $slot = request('time_slot');
                if ($slot === '00-08') {
                    $q->whereTime('start_time', '>=', '00:00:00')
                      ->whereTime('start_time', '<', '08:00:00');
                } elseif ($slot === '08-16') {
                    $q->whereTime('start_time', '>=', '08:00:00')
                      ->whereTime('start_time', '<', '16:00:00');
                } elseif ($slot === '16-00') {
                    $q->whereTime('start_time', '>=', '16:00:00')
                      ->whereTime('start_time', '<', '24:00:00');
                }
            })
            ->orderBy('start_time', 'asc')
            ->get();

        $courts = \App\Models\Court::where('is_active', true)->get();

        return view('admin.reservations', compact('reservations', 'courts'));

    }
    // etape 1 pour reserver reservation
    public function create()
    {
        $courts = \App\Models\Court::all();
        return view('player.reservations.create', compact('courts'));
    }

    // etape 2 de la reservation
    public function options(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'court_id' => 'required',
            'date' => 'required',
            'time_slot' => 'required'
        ]);

        $court = \App\Models\Court::findOrFail($request->court_id);

        $equipments = \App\Models\Equipment::where('stock', '>', 0)->get();

        return view('player.reservations.options', [
            'court' => $court,
            'equipments' => $equipments,
            'date' => $request->date,
            'time_slot' => $request->time_slot
        ]);
    }
    // etape 3 affichage du recap pour payer
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

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

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

            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'court_id' => 'required',
            'date' => 'required|date'
        ]);

        $allSlots = [];
        for ($heure = 0; $heure <= 23; $heure++) {
            if ($heure < 10) {
                $allSlots[] = "0" . $heure . ":00";
            }
            else {
                $allSlots[] = $heure . ":00";
            }
        }

        $reservationsExistantes = \App\Models\Reservation::where('court_id', $request->court_id)
            ->whereDate('start_time', $request->date)
            ->where('status', '!=', 'canceled')
            ->get();

        $heuresPrises = [];

        foreach ($reservationsExistantes as $reservation) {
            // extrait l'heure de la date complète
            $heureFormatter = \Carbon\Carbon::parse($reservation->start_time)->format('H:i');
            $heuresPrises[] = $heureFormatter;
        }

        $heuresDisponibles = [];
        $dateAujourdhui = date('Y-m-d');
        $heureActuelle = (int)now()->format('H');


        foreach ($allSlots as $creneau) {

            // recuperer juste le chiffre de l'heure du creneau
            $heureDuCreneau = (int)substr($creneau, 0, 2);

            $estPasse = false;
            if ($request->date == $dateAujourdhui) {
                if ($heureDuCreneau <= $heureActuelle + 1) {
                    $estPasse = true;
                }
            }

            $estPris = false;
            if (in_array($creneau, $heuresPrises)) {
                $estPris = true;
            }

            if ($estPasse == false && $estPris == false) {
                $heuresDisponibles[] = $creneau;
            }
        }

        return response()->json([
            'available_slots' => $heuresDisponibles
        ]);
    }
    public function process(\Illuminate\Http\Request $request)
    {
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

        $user = \Illuminate\Support\Facades\Auth::user();

        if ($request->payment_method === 'coins') {
            if ($user->coins_balance < $totalPrice) {
                return redirect()->back()->withErrors(['Erreur : Vous n\'avez pas assez de Plaza Coins.']);
            }
        }

        $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time_slot);

        $reservation = new \App\Models\Reservation();
        $reservation->user_id = $user->id;
        $reservation->court_id = $court->id;
        $reservation->start_time = $start_time;
        $reservation->status = 'confirmed';
        $reservation->total_price = $totalPrice;
        $reservation->equipments_info = $equipmentsInfo;
        $reservation->save();


        if ($request->payment_method === 'coins') {
            $cashback = ceil($totalPrice * 0.05);

            $user->decrement('coins_balance', $totalPrice);
            $user->increment('coins_balance', $cashback);

            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'reservation_id' => $reservation->id,
                'amount' => -$totalPrice,
                'type' => 'reservation',
            ]);

            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'reservation_id' => $reservation->id,
                'amount' => $cashback,
                'type' => 'cashback',
            ]);
        }

        $user->xp_points += $totalPrice;
        $newLevel = \App\Models\Level::where('min_xp', '<=', $user->xp_points)->orderBy('min_xp', 'desc')->first();
        if ($newLevel) {
            $user->level_id = $newLevel->id;
        }
        $user->save();

        return redirect('/player/dashboard')->with('success', 'Ton match est confirmé !');
    }

    // PARTIE ADMIN
    public function adminCreate()
    {
        $courts = \App\Models\Court::where('is_active', true)->get();

        $equipments = \App\Models\Equipment::where('stock', '>', 0)->get();

        return view('admin.reservations.create', compact('courts', 'equipments'));
    }


    public function adminStore(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'player_identifier' => 'required',
            'court_id' => 'required',
            'date' => 'required|date',
            'time_slot' => 'required'
        ]);

        // recherche par id ou email
        $query = \App\Models\User::query();
        if (is_numeric($request->player_identifier)) {
            $query->where('id', $request->player_identifier);
        }
        else {
            $query->where('email', $request->player_identifier);
        }
        $user = $query->first();

        if (!$user) {
            return redirect()->back()->withErrors(['Aucun joueur trouvé avec cet email ou ID.']);
        }

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

        $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time_slot);

        $reservation = new \App\Models\Reservation();
        $reservation->user_id = $user->id;
        $reservation->court_id = $request->court_id;
        $reservation->start_time = $start_time;
       $reservation->status = 'confirmed';
        $reservation->total_price = $totalPrice;
        $reservation->equipments_info = $equipmentsInfo;

        $reservation->save();

        return redirect()->route('admin.reservations')->with('success', 'Réservation traitée avec succès !');
    }
}
