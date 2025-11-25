<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CafeSuggestionController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CafeAdminController;
use App\Http\Controllers\CafeSuggestionAdminController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\SubscriptionController;



Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/cafes/create', [CafeAdminController::class, 'create'])->name('admin.cafes.create');
    Route::get('/cafes/{id}/edit', [CafeAdminController::class, 'edit'])->name('admin.cafes.edit');
    Route::put('/cafes/{cafe}', [CafeAdminController::class, 'update'])->name('admin.cafes.update');
    Route::post('/cafes', [CafeAdminController::class, 'store'])->name('admin.cafes.store');
    Route::delete('/cafes/{id}/eliminar', [CafeAdminController::class, 'destroy'])->name('admin.cafes.destroy');
    Route::get('/cafes/{cafe}/', [CafeAdminController::class, 'show'])->name('admin.cafes.show');


});

Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/cafes', [CafeAdminController::class, 'index'])->name('admin.cafes.index');

    Route::get('suggestions', [CafeSuggestionAdminController::class, 'index'])->name('admin.cafes.suggestions.index');
    Route::get('suggestions/{id}', [CafeSuggestionAdminController::class, 'show'])->name('admin.cafes.suggestions.show');
    Route::post('suggestions/{id}/approve', [CafeSuggestionAdminController::class, 'approve'])->name('admin.cafes.suggestions.approve');
    Route::post('suggestions/{id}/reject', [CafeSuggestionAdminController::class, 'reject'])->name('admin.cafes.suggestions.reject');
    
});



Route::prefix('admin')->middleware(['auth', IsAdmin::class])->name('admin.')->group(function () {
    Route::resource('cafes', CafeAdminController::class);
});


Route::get('/', function () {
    if (auth()->check()) {
        // Si el usuario ya está logueado, ir directo al mapa
        return redirect()->route('cafemap.mapa');
    }
    // Si no está logueado, mostrar el splash
    return view('splash');
})->name('splash');


Route::prefix('comunidad')
    ->name('cafemap.community.')->middleware('auth')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])
        ->name('index');    
});




Route::get('/inicio', function () {
    if (auth()->check()) {
        return redirect()->route('cafemap.mapa');
    }
    return redirect()->route('login');
})->name('inicio');

Route::middleware(['auth'])->group(function () {
    Route::get('/mapa', [MapaController::class, 'index'])
        ->name('cafemap.mapa');
    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store'); 
    Route::get('/suggest-new', [MapaController::class, 'suggestNew'])
        ->name('cafemap.suggest-new');
    Route::post('/checkins', [CheckInController::class, 'store'])
        ->name('checkins.store');
    Route::get('/cafes/{id}/review', [ReviewController::class, 'create'])
        ->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
    Route::post('/checkin', [CheckInController::class, 'store'])
        ->name('checkin.store');
    Route::post('/cafes/suggest', [CafeSuggestionController::class, 'store'])
        ->name('cafes.suggest.store');    
    Route::get('/home', [HomeController::class, 'index'])
        ->name('cafemap.home.index');
    Route::get('/beans', [App\Http\Controllers\BeansController::class, 'index'])
    ->name('cafemap.beans.index');
    Route::get('/configuracion', [ConfigController::class, 'index'])
        ->name('cafemap.config.index');
    Route::get('/suscripcion/planes', [SubscriptionController::class, 'plans'])
        ->name('cafemap.config.subscriptions.plans');
    Route::get('/suscripcion', [SubscriptionController::class, 'manage'])
        ->name('cafemap.config.subscriptions.manage');
        
    Route::post('/logout', function () {
        Auth::logout(); // Cierra la sesión del usuario
        request()->session()->invalidate(); // Invalida la sesión
        request()->session()->regenerateToken(); // Evita ataques CSRF reutilizando tokens
        return redirect()->route('inicio'); // Redirige a tu página principal o login
    })->name('logout');

});



   