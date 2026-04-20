<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

// --- LA VITRINE DU SITE (Accessible par tous) --- //
Route::get('/', function () {
    $courts = \App\Models\Court::all();
    return view('welcome', compact('courts'));
})->name('welcome');

// --- ROUTES GUEST (Utilisateurs NON connectés) --- //
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class , 'register']);

    Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class , 'login']);
});

// --- ROUTES AUTH (Le vigile : Utilisateurs connectés uniquement) --- //
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

    Route::get('/home', function () {
            $user = Auth::user();

            // Si c'est un Administrateur, l'aiguilleur l'envoie sur son portail
            if ($user->role === 'admin') {
                // Puisque tu n'as pas de route admin.dashboard nommée, on va lui servir la vue comme avant, 
                // mais l'idéal pour plus tard sera de créer une vraie route "/admin/dashboard" !
                $courts = \App\Models\Court::all();
                return view('admin.dashboard', compact('courts'));
            }

            // Magie Laravel : Si c'est un Joueur, on le redirige ! 
            // L'URL dans le navigateur va donc changer en "/player/dashboard" !
            return redirect()->route('player.dashboard');
        }
        )->name('home');


        // --- GESTION DU PROFIL ---
        Route::get('/profile', [\App\Http\Controllers\UserController::class , 'profile'])->name('profile');
        Route::put('/profile/info', [\App\Http\Controllers\UserController::class , 'updateProfileInfo'])->name('profile.info');
        Route::put('/profile/password', [\App\Http\Controllers\UserController::class , 'updateProfilePassword'])->name('profile.password');

        // --- ESPACE JOUEUR ---
        Route::get('/player/dashboard', [\App\Http\Controllers\PlayerController::class , 'dashboard'])->name('player.dashboard');
        Route::get('/player/reservations/create', [\App\Http\Controllers\ReservationController::class , 'create'])->name('player.reservations.create');
        Route::get('/player/reservations/options', [\App\Http\Controllers\ReservationController::class , 'options'])->name('player.reservations.options');
        Route::get('/player/reservations/checkout', [\App\Http\Controllers\ReservationController::class , 'checkout'])->name('player.reservations.checkout');
        Route::post('/player/reservations/process', [\App\Http\Controllers\ReservationController::class , 'process'])->name('player.reservations.process');
        // Afficher la page
        Route::get('/player/recharge', [\App\Http\Controllers\PlayerController::class , 'recharge'])->name('player.recharge');
        // Le "Serveur Magique" pour Stripe (c'est lui qui calcule le vrai prix au lieu du JS !)
        Route::post('/api/create-recharge-intent', [\App\Http\Controllers\PlayerController::class , 'createRechargeIntent'])->name('api.create-recharge-intent');
        // Valiadation finale du paiement
        Route::post('/player/recharge/process', [\App\Http\Controllers\PlayerController::class , 'rechargeProcess'])->name('player.recharge.process');
        Route::get('/player/transactions', [\App\Http\Controllers\PlayerController::class, 'transactions'])->name('player.transactions');


        // --- ESPACE ADMINISTRATEUR ---
    
        // Terrains
        Route::get('/admin/courts', [\App\Http\Controllers\CourtController::class , 'indexAdmin'])->name('admin.courts');
        Route::get('/admin/courts/create', [\App\Http\Controllers\CourtController::class , 'create'])->name('admin.courts.create');
        Route::post('/admin/courts', [\App\Http\Controllers\CourtController::class , 'store'])->name('admin.courts.store');
        Route::get('/admin/courts/{id}/edit', [\App\Http\Controllers\CourtController::class , 'edit'])->name('admin.courts.edit');
        Route::put('/admin/courts/{id}', [\App\Http\Controllers\CourtController::class , 'update'])->name('admin.courts.update');
        Route::delete('/admin/courts/{id}', [\App\Http\Controllers\CourtController::class , 'destroy'])->name('admin.courts.destroy');

        // Equipements
        Route::get('/admin/equipments', [\App\Http\Controllers\EquipmentController::class , 'index'])->name('admin.equipments');
        Route::get('/admin/equipments/create', [\App\Http\Controllers\EquipmentController::class , 'create'])->name('admin.equipments.create');
        Route::post('/admin/equipments', [\App\Http\Controllers\EquipmentController::class , 'store'])->name('admin.equipments.store');
        Route::get('/admin/equipments/{id}/edit', [\App\Http\Controllers\EquipmentController::class , 'edit'])->name('admin.equipments.edit');
        Route::put('/admin/equipments/{id}', [\App\Http\Controllers\EquipmentController::class , 'update'])->name('admin.equipments.update');
        Route::delete('/admin/equipments/{id}', [\App\Http\Controllers\EquipmentController::class , 'destroy'])->name('admin.equipments.destroy');

        // Réservations
        Route::get('/admin/reservations', [\App\Http\Controllers\ReservationController::class , 'indexAdmin'])->name('admin.reservations');
        Route::get('/admin/reservations/create', [\App\Http\Controllers\ReservationController::class , 'adminCreate'])->name('admin.reservations.create');
        Route::post('/admin/reservations', [\App\Http\Controllers\ReservationController::class , 'adminStore'])->name('admin.reservations.store');

        // Joueurs / Utilisateurs
        Route::get('/admin/players', [\App\Http\Controllers\UserController::class , 'indexAdmin'])->name('admin.players');
        // Recharge manuelle par l'Admin
        Route::get('/admin/players/{id}/recharge', [\App\Http\Controllers\UserController::class , 'adminRechargeForm'])->name('admin.players.recharge');
        Route::post('/admin/players/{id}/recharge', [\App\Http\Controllers\UserController::class , 'adminRechargeProcess'])->name('admin.players.recharge.process');


        // --- API / AJAX ---
        Route::get('/api/available-slots', [\App\Http\Controllers\ReservationController::class , 'getAvailableSlots'])->name('api.available-slots');
    }); // <-- C'est ici que les portes du vigile se ferment !
