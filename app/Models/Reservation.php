<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'court_id',
        'start_time',
        'status',
        'result'
    ];

    /**
     * Permet de dire à Laravel que "start_time" est une Date (Carbon)
     */
    protected $casts = [
        'start_time' => 'datetime',
    ];

    // Une Réservation appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)
                    ->withPivot(['quantity', 'price_at_res'])
                    ->withTimestamps();
    }

    // Une Réservation appartient à un Court
    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'equipments_info' => 'array',
        ];
    }
    public function transactions()    {
        return $this->hasMany(Transaction::class);    }

}
