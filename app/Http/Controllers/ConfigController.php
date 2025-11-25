<?php

namespace App\Http\Controllers;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;

class ConfigController extends Controller
{


public function index()
{
    $user = auth()->user();

    // Obtener suscripción activa si existe
    $activeSubscription = UserSubscription::where('user_id', $user->id)
                        ->where('status', 'active')
                        ->first();

    // El plan activo (si tiene suscripción)
    $activePlan = $activeSubscription
        ? SubscriptionPlan::find($activeSubscription->plan_id)
        : null;

    return view('cafemap.config.index', [
    'user'       => $user,
    'activePlan' => $activePlan,
    'activeTab'  => 'config'
]);


}
}