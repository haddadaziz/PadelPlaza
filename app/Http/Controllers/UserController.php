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
    // Afficher la page Profil
    public function profile()
    {
        return view('profile.edit');
    }

    // Mettre à jour Nom & Email
    public function updateProfileInfo(Request $request)
    {
        // Sécurité : Seul l'admin a le bouton de sauvegarde selon ton design !
        if (auth()->user()->role !== 'admin') {
            return redirect()->back(); // Les joueurs ne peuvent pas modifier ici
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), // L'admin peut garder le même email sans que Laravel crie au doublon
        ]);

        auth()->user()->update($validated); // On met à jour l'utilisateur connecté

        return redirect()->back()->with('success', 'Vos informations ont bien été mises à jour !');
    }

    // Changer de mot de passe
    public function updateProfilePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:4|confirmed', // 'confirmed' vérifie automatiquement le champ "password_confirmation" !
        ]);

        // Hachage du mot de passe (Indispensable)
        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password'])
        ]);

        return redirect()->back()->with('success', 'Mot de passe sécurisé à jour ! 🔒');
    }

}
