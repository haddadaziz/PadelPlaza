<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    // Affiche la page de Gestion des Terrains pour l'Admin
    public function indexAdmin()
    {
        // 1. Sécurité : On vérifie que c'est bien l'admin qui essaie d'y accéder
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->withErrors('Accès refusé. Vous devez être administrateur.');
        }

        // 2. On récupère les terrains
        $courts = Court::all();

        // 3. On envoie vers la nouvelle vue
        return view('admin.courts', compact('courts'));
    }
    // Affiche la page d'édition
    public function edit($id)
    {
        $court = \App\Models\Court::findOrFail($id);
        return view('admin.courts.edit', compact('court'));
    }

    // Traite le formulaire de modification
    public function update(Request $request, $id)
    {
        $court = \App\Models\Court::findOrFail($id);

        // 1. Vérification des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_coins' => 'required|numeric',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2Mo Max
        ]);

        // 2. Gestion de l'upload de l'image
        if ($request->hasFile('image')) {
            // Sauvegarde l'image dans storage/app/public/courts
            $path = $request->file('image')->store('courts', 'public');
            $validated['image'] = $path; // On remplace le fichier par le chemin texte pour la BDD
        }

        // 3. Mise à jour de la BDD
        $court->update($validated);

        // 4. Redirection avec ton super système de notification !
        return redirect()->route('admin.courts')->with('success', 'Terrain mis à jour avec succès !');
    }
    // Affiche la page de création vide
    public function create()
    {
        return view('admin.courts.create');
    }

    // Traite le formulaire de création et insère dans la BDD
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courts,name', // On force un nom unique !
            'type' => 'required|string|in:indoor,outdoor',
            'price_coins' => 'required|numeric',
            'is_active' => 'nullable', // Les checkbox envoient une valeur que si cochées
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Astuce pour la checkbox : si elle est cochée, is_active vaut true, sinon false
        $validated['is_active'] = $request->has('is_active');

        // 3. Gestion de l'image (si l'admin en a mis une)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courts', 'public');
        }

        // 4. Création magique grâce au Model
        \App\Models\Court::create($validated);

        return redirect()->route('admin.courts')->with('success', 'Nouveau terrain créé avec succès ! 🚀');
    }
    // Supprime un terrain de la BDD
    public function destroy($id)
    {
        $court = \App\Models\Court::findOrFail($id);

        // Optionnel mais très pro : Supprimer aussi l'image du serveur pour libérer de la place !
        if ($court->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($court->image);
        }

        // On détruit le terrain
        $court->delete();

        // On redirige avec un message de succès (Notification Rouge/Verte)
        return redirect()->route('admin.courts')->with('success', 'Terrain supprimé définitivement ! 🗑️');
    }
    // Alterne le statut du terrain (Actif <-> Maintenance)
    public function toggleStatus($id)
    {
        $court = \App\Models\Court::findOrFail($id);
        $court->is_active = !$court->is_active;
        $court->save();

        $status = $court->is_active ? 'ouvert et prêt pour les matchs ! 🎾' : 'mis en maintenance. 🛠️';
        return redirect()->back()->with('success', "Le terrain {$court->name} a été {$status}");
    }

}
