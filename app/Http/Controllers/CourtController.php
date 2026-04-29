<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    public function indexAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->withErrors('Accès refusé. Vous devez être administrateur.');
        }

        $courts = Court::all();

        return view('admin.courts', compact('courts'));
    }
    public function edit($id)
    {
        $court = \App\Models\Court::findOrFail($id);
        return view('admin.courts.edit', compact('court'));
    }

    public function update(Request $request, $id)
    {
        $court = \App\Models\Court::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_coins' => 'required|numeric',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courts', 'public');
            $validated['image'] = $path;
        }
        $court->update($validated);

        return redirect()->route('admin.courts')->with('success', 'Terrain mis à jour avec succès !');
    }
    public function create()
    {
        return view('admin.courts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courts,name',
            'type' => 'required|string|in:indoor,outdoor',
            'price_coins' => 'required|numeric',
            'is_active' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courts', 'public');
        }

        \App\Models\Court::create($validated);

        return redirect()->route('admin.courts')->with('success', 'Nouveau terrain créé avec succès !');
    }
    public function destroy($id)
    {
        $court = \App\Models\Court::findOrFail($id);

        if ($court->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($court->image);
        }

        $court->delete();

        return redirect()->route('admin.courts')->with('success', 'Terrain supprimé définitivement !');
    }
    public function toggleStatus($id)
    {
        $court = \App\Models\Court::findOrFail($id);
        $court->is_active = !$court->is_active;
        $court->save();

        $status = $court->is_active ? 'ouvert et prêt pour les matchs !' : 'mis en maintenance.';
        return redirect()->back()->with('success', "Le terrain {$court->name} a été {$status}");
    }

}
