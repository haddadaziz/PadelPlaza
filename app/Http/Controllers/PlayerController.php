<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function dashboard()
    {
        // On récupère les 5 dernières transactions du joueur
        $transactions = \Illuminate\Support\Facades\Auth::user()->transactions()->latest()->take(5)->get();
        return view('player.dashboard', compact('transactions'));
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
            // Jackpot, on ajoute l'argent !            $user->coins_balance += $pcToAdd;
            $user->save();
            // On sauvegarde la transaction dans l'historique
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'amount' => $pcToAdd,
                'type' => 'recharge_stripe',
                'description' => 'Via Stripe'
            ]);
        }

        return redirect('/player/dashboard')->with('success', 'Votre compte a été rechargé de ' . $pcToAdd . ' Plaza Coins avec succès !');
    }
    public function transactions()
    {
        // On demande toutes les transactions classées de la plus récente à la plus ancienne !
        $transactions = \Illuminate\Support\Facades\Auth::user()->transactions()->latest()->get();
        return view('player.transactions', compact('transactions'));
    }

}
