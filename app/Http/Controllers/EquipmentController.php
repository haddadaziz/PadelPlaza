<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\Equipment::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $equipments = $query->get();
        
        return view('admin.equipments', compact('equipments'));
    }

    public function edit($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        return view('admin.equipments.edit', compact('equipment'));
    }

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
            $validated['image'] = $path;
        }

        $equipment->update($validated);

        return redirect()->route('admin.equipments')->with('success', 'Article mis à jour dans le stock !');
    }
    public function create()
    {
        return view('admin.equipments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price_coins' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('equipments', 'public');
        }

        \App\Models\Equipment::create($validated);

        return redirect()->route('admin.equipments')->with('success', 'Nouvel équipement ajouté au catalogue !');
    }
    public function destroy($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);

        if ($equipment->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('admin.equipments')->with('success', 'Article retiré avec succès !');
    }

}
