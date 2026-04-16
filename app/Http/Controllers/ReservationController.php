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
}
