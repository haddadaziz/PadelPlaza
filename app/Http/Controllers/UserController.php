<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Affiche la liste des joueurs pour l'Admin
    public function indexAdmin(\Illuminate\Http\Request $request)
    {
        // 1. Sécurité anti-intrus
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        // 2. On prépare la base de notre requête (tous les joueurs)
        $query = User::where('role', 'player')->latest();

        // 3. LA RECHERCHE MAGIQUE 🔍
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                // Si l'admin a tapé un numéro, on cherche la correspondance parfaite sur l'ID
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                else {
                    // Sinon, on cherche dans le nom et l'email (ILIKE évite les soucis Majuscule/Minuscule sur PostgreSQL !)
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('email', 'ilike', '%' . $search . '%');
                }
            });
        }

        // 4. On paginate, et le petit "appends" permet de conserver ta recherche quand tu passes à la page 2 !
        $players = $query->paginate(10)->appends($request->query());

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

    public function updateProfileImage(Request $request)
    {
        // 1. Sécurité : Seuls les joueurs ont la permission
        if (auth()->user()->role !== 'player') {
            return redirect()->back()->withErrors(['Les administrateurs n\'ont pas de photo.']);
        }

        // 2. Validation poussée (image, extension, 2Mo max)
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = auth()->user();

        // 3. Téléversement intelligent
        if ($request->hasFile('image')) {
            // On la stocke dans storage/app/public/profiles
            $path = $request->file('image')->store('profiles', 'public');

            // 4. Si le joueur avait déjà une photo, on la supprime du disque pour économiser de la place
            if ($user->profile_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_image);
            }

            // 5. Sauvegarde en BDD
            $user->profile_image = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Photo de profil mise à jour ! 📸');
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
    // ==========================================
    // GESTION ADMIN : RECHARGE MANUELLE
    // ==========================================

    public function adminRechargeForm($id)
    {
        // On récupère le joueur sélectionné
        $player = \App\Models\User::findOrFail($id);
        return view('admin.players.recharge', compact('player'));
    }

    public function adminRechargeProcess(\Illuminate\Http\Request $request, $id)
    {
        $player = \App\Models\User::findOrFail($id);

        // On regarde si l'admin a tapé un montant libre, sinon on prend le pack radio
        $pcToAdd = $request->custom_amount ? (int)$request->custom_amount : (int)$request->amount;

        if ($pcToAdd > 0) {
            $player->coins_balance += $pcToAdd;
            $player->save();

            \App\Models\Transaction::create([
                'user_id' => $player->id,
                'amount' => $pcToAdd,
                'type' => 'recharge_admin',
            ]);
        }


        return redirect()->route('admin.players')->with('success', "Le compte de {$player->name} a bien été crédité de {$pcToAdd} PC en caisse !");
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $action = $user->is_blocked ? 'bloqué' : 'débloqué';
        return back()->with('success', "Le joueur {$user->name} a bien été {$action}.");
    }
}
