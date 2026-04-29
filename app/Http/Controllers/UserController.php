<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    // liste des joueurs pour l'admin
    public function indexAdmin(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        $query = User::where('role', 'player')->latest();

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                else {
                    $q->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('email', 'ilike', '%' . $search . '%');
                }
            });
        }
        $players = $query->paginate(10);

        return view('admin.players', compact('players'));
    }

    public function profile()
    {
        return view('profile.edit');
    }

    public function updateProfileInfo(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($validated); // On met à jour l'utilisateur connecté

        return redirect()->back()->with('success', 'Vos informations ont bien été mises à jour !');
    }

    public function updateProfileImage(Request $request)
    {
        if (auth()->user()->role !== 'player') {
            return redirect()->back()->withErrors(['Les administrateurs n\'ont pas de photo.']);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');

            if ($user->profile_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Photo de profil mise à jour !');
    }

    public function updateProfilePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:4|confirmed',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password'])
        ]);

        return redirect()->back()->with('success', 'Mot de passe sécurisé à jour !');
    }


    // recharge par admin
    public function adminRechargeForm($id)
    {
        $player = \App\Models\User::findOrFail($id);
        return view('admin.players.recharge', compact('player'));
    }

    public function adminRechargeProcess(\Illuminate\Http\Request $request, $id)
    {
        $player = \App\Models\User::findOrFail($id);

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


        return redirect()->route('admin.players')->with('success', "Le compte de {$player->name} a bien été crédité de {$pcToAdd} PC !");
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $action = $user->is_blocked ? 'bloqué' : 'débloqué';
        return back()->with('success', "Le joueur {$user->name} a bien été {$action}.");
    }

    public function exportPlayers()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            return redirect('/home');
        }

        $players = User::where('role', 'player')->latest()->get();
        
        $filename = "padelplaza_joueurs_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nom', 'Email', 'PC Balance', 'XP Points', 'Niveau', 'Inscrit le', 'Statut'];

        $callback = function() use($players, $columns) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';');

            foreach ($players as $player) {
                fputcsv($file, [
                    $player->id,
                    $player->name,
                    $player->email,
                    $player->coins_balance,
                    $player->xp_points,
                    $player->level->level_name ?? 'ROOKIE',
                    $player->created_at->format('d/m/Y H:i'),
                    $player->is_blocked ? 'Bloqué' : 'Actif'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
