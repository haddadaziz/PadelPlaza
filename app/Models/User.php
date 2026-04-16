<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs que l'on peut remplir avec un formulaire (Mass assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'coins_balance',
        'xp_points',
        'level_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELATIONS ---

    // Un User appartient à un Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Un User a plusieurs Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Un User a plusieurs Réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
