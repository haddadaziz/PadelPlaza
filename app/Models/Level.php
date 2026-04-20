<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_name',
        'min_xp',
        'badge_image'
    ];

    // Un Level concerne plusieurs Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
