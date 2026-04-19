<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- NOUVEAU: Obligatoire pour utiliser Auth::user()
use App\Http\Controllers\AuthController;

// --- ROUTES GUEST (Utilisateurs NON connectés) --- //
Route::middleware('guest')->group(function () {

    // Page d'inscription (GET pour voir la page, POST pour soumettre le formulaire)
    Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class , 'register']);

    // Page de connexion
    Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class , 'login']);

});


// --- ROUTES AUTH (Utilisateurs connectés uniquement) --- //
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

    // Notre nouvel "Aiguilleur" : Il lit le rôle et envoie la bonne vue
    Route::get('/home', function () {
            $user = Auth::user();
            $courts = \App\Models\Court::all();

            // 1. Si c'est l'Admin
            if ($user->role === 'admin') {
                return view('admin.dashboard', compact('courts'));
            }

            // 2. Si c'est le Joueur
            return view('player.dashboard', compact('courts'));

        }
        )->name('home');
        Route::get('/admin/courts', [\App\Http\Controllers\CourtController::class , 'indexAdmin'])->name('admin.courts');
    });

Route::get('/admin/courts', [\App\Http\Controllers\CourtController::class , 'indexAdmin'])->name('admin.courts');

// --> LA NOUVELLE LIGNE :
Route::get('/admin/reservations', [\App\Http\Controllers\ReservationController::class , 'indexAdmin'])->name('admin.reservations');
// LA NOUVELLE LIGNE : Gestion des Joueurs (Admin)
Route::get('/admin/players', [\App\Http\Controllers\UserController::class , 'indexAdmin'])->name('admin.players');

// --- LA VITRINE DU SITE (Accessible par tous) --- //
Route::get('/', function () {
    // 1. On va chercher tous les terrains dans la base de données
    $courts = \App\Models\Court::all();

    // 2. On envoie ces terrains à la vue welcome grâce à compact()
    return view('welcome', compact('courts'));


})->name('welcome');

// 1. Pour afficher le formulaire (GET)
Route::get('/admin/courts/{id}/edit', [\App\Http\Controllers\CourtController::class , 'edit'])->name('admin.courts.edit');

// 2. Pour sauvegarder les modifications (PUT)
Route::put('/admin/courts/{id}', [\App\Http\Controllers\CourtController::class , 'update'])->name('admin.courts.update');

// 3. Pour afficher le formulaire de création
Route::get('/admin/courts/create', [\App\Http\Controllers\CourtController::class , 'create'])->name('admin.courts.create');

// 4. Pour sauvegarder le nouveau terrain en base de données (POST)
Route::post('/admin/courts', [\App\Http\Controllers\CourtController::class , 'store'])->name('admin.courts.store');
Route::delete('/admin/courts/{id}', [\App\Http\Controllers\CourtController::class , 'destroy'])->name('admin.courts.destroy');
Route::get('/admin/equipments', [\App\Http\Controllers\EquipmentController::class , 'index'])->name('admin.equipments');

// Pour afficher et modifier l'équipement
Route::get('/admin/equipments/{id}/edit', [\App\Http\Controllers\EquipmentController::class , 'edit'])->name('admin.equipments.edit');
Route::put('/admin/equipments/{id}', [\App\Http\Controllers\EquipmentController::class , 'update'])->name('admin.equipments.update');

// Pour afficher la page d'ajout vide
Route::get('/admin/equipments/create', [\App\Http\Controllers\EquipmentController::class , 'create'])->name('admin.equipments.create');

// Pour sauvegarder dans la BDD (POST)
Route::post('/admin/equipments', [\App\Http\Controllers\EquipmentController::class , 'store'])->name('admin.equipments.store');

Route::delete('/admin/equipments/{id}', [\App\Http\Controllers\EquipmentController::class , 'destroy'])->name('admin.equipments.destroy');

// Afficher le formulaire manuel
Route::get('/admin/reservations/create', [\App\Http\Controllers\ReservationController::class, 'adminCreate'])->name('admin.reservations.create');

// Sauvegarder la réservation manuelle
Route::post('/admin/reservations', [\App\Http\Controllers\ReservationController::class, 'adminStore'])->name('admin.reservations.store');

// --- GESTION DU PROFIL ---
Route::get('/profile', [\App\Http\Controllers\UserController::class , 'profile'])->name('profile');
Route::put('/profile/info', [\App\Http\Controllers\UserController::class , 'updateProfileInfo'])->name('profile.info');
Route::put('/profile/password', [\App\Http\Controllers\UserController::class , 'updateProfilePassword'])->name('profile.password');
// --- ESPACE JOUEUR ---
Route::get('/player/dashboard', [\App\Http\Controllers\PlayerController::class , 'dashboard'])->name('player.dashboard');

// Les Réservations du Joueur
Route::get('/player/reservations/create', [\App\Http\Controllers\ReservationController::class , 'create'])->name('player.reservations.create');
Route::get('/player/reservations/options', [\App\Http\Controllers\ReservationController::class , 'options'])->name('player.reservations.options');

Route::get('/player/reservations/checkout', [\App\Http\Controllers\ReservationController::class , 'checkout'])->name('player.reservations.checkout');
// Enregistrement de la commande
Route::post('/player/reservations/process', [\App\Http\Controllers\ReservationController::class, 'process'])->name('player.reservations.process');

// AJAX pour charger les créneaux disponibles
Route::get('/api/available-slots', [\App\Http\Controllers\ReservationController::class, 'getAvailableSlots'])->name('api.available-slots');
