<?php

namespace App\Http\Controllers;

use App\Models\Equipment;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Equipment::count();
        $disponibles = Equipment::where('status', 'available')->count();
        $enAlquiler = Equipment::where('status', 'rented')->count();
        $enMantenimiento = Equipment::where('status', 'maintenance')->count();

        return view('admin.dashboard', compact(
            'total', 'disponibles', 'enAlquiler', 'enMantenimiento'
        ));
    }
}