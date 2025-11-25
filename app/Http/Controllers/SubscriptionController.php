<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;

class SubscriptionController extends Controller
{
    /**
     * Mostrar lista de planes disponibles
     */
    public function plans()
    {
        $plans = SubscriptionPlan::orderBy('price', 'asc')->get();

        return view('cafemap.config.subscriptions.plans', [
            'plans' => $plans,
            'activeTab' => 'config',
        ]);
    }

    /**
     * Mostrar vista de detalles del plan
     */
    public function showPlan($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        return view('cafemap.subscription.plan-detail', [
            'plan' => $plan,
            'activeTab' => 'config',
        ]);
    }

    /**
     * Activar la suscripción del usuario
     */
    public function subscribe(Request $request, $planId)
    {
        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($planId);

        // Si ya tiene una suscripción activa, reemplazarla
        UserSubscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan_id' => $plan->id,
                'status'  => 'active',
                'renews_at' => now()->addMonth(),
            ]
        );

        return redirect()
            ->route('cafemap.config.index')
            ->with('success', "Suscripción al plan {$plan->name} activada con éxito.");
    }

    /**
     * Cancelar la suscripción
     */
    public function cancel()
    {
        $subscription = UserSubscription::where('user_id', Auth::id())->first();

        if (!$subscription) {
            return back()->with('error', 'No tenés ninguna suscripción activa.');
        }

        $subscription->update(['status' => 'cancelled']);

        return back()->with('success', 'Cancelaste tu suscripción exitosamente.');
    }
}