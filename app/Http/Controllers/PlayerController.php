<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function dashboard()
    {
        return view('player.dashboard');
    }

}
