<?php

namespace App\Services;

use App\Models\User;
use App\Models\PointsHistory;
use App\Models\Badge;

class PointService
{
    /**
     * Sumar puntos al usuario.
     */
    public function addPoints(User $user, int $beans, string $action)
    {
        // 1) Sumar puntos
        $user->beans += $beans;
        
        // 2) Actualizar nivel automáticamente
        $user->level = $this->calculateLevel($user->beans);
        
        $user->save();

        // 3) Registrar historial
        PointsHistory::create([
            'user_id' => $user->id,
            'action' => $action,
            'beans' => $beans
        ]);

        // 4) Check de Badges (Próxima etapa)
        $this->checkBadges($user);

        return true;
    }

    /**
     * Determinar nivel según beans acumulados.
     */
    private function calculateLevel($beans)
    {
        if ($beans >= 5000) return 'master';
        if ($beans >= 2500) return 'gold';
        if ($beans >= 1000) return 'silver';
        return 'bronze';
    }

    /**
     * Asignación automática de badges.
     */
    private function checkBadges(User $user)
    {
        $badges = Badge::all();

        foreach ($badges as $badge) {
            // Si cumple los beans requeridos y no lo tiene aún
            if ($user->beans >= $badge->required_beans &&
                !$user->badges->contains($badge->id)) 
            {
                $user->badges()->attach($badge->id);
            }
        }
    }
}