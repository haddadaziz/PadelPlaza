<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Affiche la liste des joueurs pour l'Admin
    public function indexAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        // On récupère TOUS les comptes qui sont des 'player', du plus récent au plus ancien
        $players = User::where('role', 'player')->latest()->get();

        return view('admin.players', compact('players'));
    }
}
