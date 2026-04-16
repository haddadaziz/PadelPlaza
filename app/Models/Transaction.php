<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type'
    ];

    // Une Transaction appartient à un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
