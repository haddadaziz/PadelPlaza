<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // On prépare la récupération du stock
        $query = \App\Models\Equipment::query();

        // Si l'URL contient un filtre "?type=raquette" par exemple, on filtre !
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // On exécute la requête
        $equipments = $query->get();
        
        return view('admin.equipments', compact('equipments'));
    }

    // Affiche la page HTML d'édition
    public function edit($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        return view('admin.equipments.edit', compact('equipment'));
    }

    // Traite et sauvegarde les données modifiées dans la Base de Données
    public function update(Request $request, $id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_coins' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('equipments', 'public');
            $validated['image'] = $path; // On enregistre l'image dans storage/app/public/equipments
        }

        $equipment->update($validated);

        return redirect()->route('admin.equipments')->with('success', 'Article mis à jour dans le stock !');
    }
    // Affiche la page de création
    public function create()
    {
        return view('admin.equipments.create');
    }

    // Traite le formulaire de création et insère dans la BDD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string', // Nos 3 boutons radio !
            'price_coins' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('equipments', 'public');
        }

        \App\Models\Equipment::create($validated);

        return redirect()->route('admin.equipments')->with('success', 'Nouvel équipement ajouté au catalogue ! 🎾');
    }
    // Supprime un équipement du catalogue
    public function destroy($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);

        // On libère la place sur le serveur en supprimant sa photo !
        if ($equipment->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('admin.equipments')->with('success', 'Article retiré avec succès !');
    }

}
