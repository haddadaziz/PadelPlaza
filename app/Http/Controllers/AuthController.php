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
        // 1. Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // "confirmed" oblige à avoir un champ "password_confirmation"
        ]);

        // 2. Création de l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // On crypte le mot de passe !
            'role' => 'player',
        ]);

        // 3. On le connecte direct après l'inscription
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Inscription réussie ! Bienvenue ' . Auth::user()->name . ' 👋');
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

        // 2. Tentative de connexion (Auth::attempt gère tout seul la vérification du mot de passe)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Régénère la session pour éviter les failles de sécurité (Fixation de session)

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
