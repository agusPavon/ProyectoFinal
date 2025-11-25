<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Cafe;
use App\Models\PointsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $recentReviews = Review::with(['user', 'cafe'])
            ->latest()
            ->take(10)
            ->get();

        $cafes = Cafe::all();

        return view('cafemap.community', compact('recentReviews', 'cafes'));
    }

    public function create($id)
    {
        $cafe = Cafe::findOrFail($id);
        return view('cafemap.reviews.create', compact('cafe'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'cafe_id' => 'required|exists:cafes,id',
        'rating'  => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:500',
    ]);

    $user = auth()->user();

    // Chequear si ya existe reseña
    $exists = Review::where('user_id', $user->id)
        ->where('cafe_id', $validated['cafe_id'])
        ->exists();

    if ($exists) {
        return $request->expectsJson()
            ? response()->json([
                'status'  => 'error',
                'message' => 'Ya dejaste una reseña en este café ☕'
            ], 400)
            : back()->with('error', 'Ya dejaste una reseña en este café ☕');
    }

    // Crear la reseña
    $review = Review::create([
        'user_id' => $user->id,
        'cafe_id' => $validated['cafe_id'],
        'rating'  => $validated['rating'],
        'comment' => $validated['comment'],
    ]);

    // Dar puntos
    $points = 20;
    $user->addBeans($points);

    PointsHistory::create([
        'user_id' => $user->id,
        'action'  => 'review',
        'beans'   => $points,
    ]);

    // 👉 RESPUESTAS AJAX / NORMAL
    if ($request->expectsJson()) {
        return response()->json([
            'status'  => 'success',
            'message' => 'Reseña publicada con éxito.',
            'points'  => $points,
            'review'  => $review
        ]);
    }

    return redirect()
        ->route('cafemap.community')
        ->with('success', 'Reseña publicada con éxito.');
}
}