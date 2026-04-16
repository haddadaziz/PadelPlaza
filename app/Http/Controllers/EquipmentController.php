<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = \App\Models\Equipment::all(); // On va chercher tout le stock
        return view('admin.equipments', compact('equipments'));
    }

}
