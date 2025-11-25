<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CheckIn;
use App\Models\PointsHistory;
use Illuminate\Support\Facades\Auth;
class CheckInController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'cafe_id' => 'nullable|exists:cafes,id',
        'comment' => 'nullable|string|max:180',
        'image'   => 'nullable|image',
        'lat'     => 'nullable|numeric',
        'lng'     => 'nullable|numeric',
    ]);

    // Guardar imagen
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath= $request->file('image')->store('checkins', 'public');
    }

    $validated['user_id'] = auth()->id();
    
    $checkIn = CheckIn::create([
        'user_id' => Auth::id(),
        'cafe_id'=>$validated['cafe_id'],
        'comment'=>$validated['comment'] ?? null,
        'image'=>$imagePath,
        'lat' =>$validated['lat'] ?? null,
        'lng' =>$validated['lng'] ?? null,
        'points_awarded' => 10 


        
    ]);

    
    // Sumamos puntos
    $user= Auth::user();
    $user->addBeans($checkIn->points_awarded);
    PointsHistory::create([
            'user_id' => $user->id,
            'action'  => 'checkin',
            'beans'   => $checkIn->points_awarded,
        ]);

return redirect()->back()->with('success', '¡Check-in publicado! ¡Has sumado Beans!');
}
}
