<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_coins',
        'is_active',
        'image'
    ];

    // Un Terrain a plusieurs Réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
