<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- LA LIGNE MANQUANTE EST ICI

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price_coins',
        'stock',
        'image'
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class)
                    ->withPivot(['quantity', 'price_at_res'])
                    ->withTimestamps();
    }
}
