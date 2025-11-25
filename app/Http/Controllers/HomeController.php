<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckIn;

class HomeController extends Controller
{
    public function index()
    {
        // Trae últimos 10 check-ins reales
        $checkins = CheckIn::with(['user', 'cafe'])
            ->latest()
            ->take(10)
            ->get();

        return view('cafemap.home.index', [
            'checkins'  => $checkins,
            'activeTab' => 'inicio',
        ]);
    }
}