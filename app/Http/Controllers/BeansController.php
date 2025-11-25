<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Badge;
use App\Models\PointsHistory;

class BeansController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $beans = $user->points ?? 0; // sigue siendo points en la tabla de usuarios
        
        // Traer badges ordenados por beans requeridos
        $badges = Badge::orderBy('required_beans')->get();

        // Badge actual (el máximo que no supere mis beans)
        $currentBadge = $badges
            ->where('required_beans', '<=', $beans)
            ->sortByDesc('required_beans')
            ->first();

        // Si está por debajo del primer badge
        if (!$currentBadge) {
            $currentBadge = (object)[
                'id' => 0,
                'icon' => '🌱',
                'name' => 'Principiante',
                'required_beans' => 0
            ];
        }

        // Badge siguiente
        $nextBadge = $badges
            ->where('required_beans', '>', $beans)
            ->sortBy('required_beans')
            ->first();

        // Nivel actual (posición del badge)
        $level = $badges->search(fn($b) => $b->id === $currentBadge->id) + 1;

        if (!$level || $level < 1) {
            $level = 1;
        }

        // Calcular progreso
        if ($nextBadge) {

            $range = $nextBadge->required_beans - $currentBadge->required_beans;

            $progress = ($beans - $currentBadge->required_beans) / $range;

            $progress = max(0, min(1, $progress));  // clamp 0–1

        } else {
            // Último nivel
            $nextBadge = null;
            $progress = 1;
        }

        // Historial real de beans
        $history = PointsHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cafemap.beans.index', compact(
            'beans',
            'level',
            'history',
            'currentBadge',
            'nextBadge',
            'progress'
        ));
    }
}