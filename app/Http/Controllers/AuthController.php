<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register'); // On va créer cette vue à l'étape suivante
    }

    // Traite le formulaire d'inscription
    public function register(Request $request)
    {
        // 1. Validation STRICTE des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. On récupère le niveau de base (Bois)
        $defaultLevel = \App\Models\Level::where('min_xp', 0)->first();

        // 3. Création de l'utilisateur avec son niveau
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'player',
            'coins_balance' => 0,
            'xp_points' => 0,
            'level_id' => $defaultLevel ? $defaultLevel->id : null,
        ]);

        // 4. Connexion et redirection
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/player/dashboard')->with('success', 'Bienvenue au Club !');
    }



    // Affiche le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }

    // Traite la connexion
    public function login(Request $request)
    {
        // 1. Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Tentative de connexion
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); 

            return redirect()->route('home')->with('success', 'Connexion réussie ! Bon retour parmis nous, ' . Auth::user()->name . '');
        }

        // 3. Si échec
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->onlyInput('email'); // Garde l'email tapé dans l'input
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // On détruit la session actuelle
        $request->session()->regenerateToken(); // On détruit le Token CSRF

        return redirect()->route('welcome')
            ->with('success', 'Déconnexion réussie. À très vite !');
    }
}
