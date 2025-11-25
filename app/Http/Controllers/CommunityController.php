<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\CheckIn;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cafes = Cafe::all();

        $reviewsCount = $user
            ? Review::where('user_id', $user->id)->count()
            : 0;

        // Últimos 20 check-ins
        $checkins = CheckIn::with(['user', 'cafe'])
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($c) {
                return [
                    'type' => 'checkin',
                    'user' => $c->user->name,
                    'cafe' => $c->cafe->name ?? 'Cafetería',
                    'image' => $c->image ?? null,
                    'time' => $c->created_at->diffForHumans(),
                    'created_at' => $c->created_at,
                    'user_id' => $c->user->id,
                ];
            });

        // Últimos 20 reviews
        $reviews = Review::with(['user', 'cafe'])
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($r) {
                return [
                    'type' => 'review',
                    'user' => $r->user->name,
                    'cafe' => $r->cafe->name ?? 'Cafetería',
                    'avatar' => $r->user->avatar ?? null,
                    'rating' => $r->rating,
                    'comment' => $r->comment,
                    'time' => $r->created_at->diffForHumans(),
                    'created_at' => $r->created_at,
                    'user_id' => $r->user->id,
                ];
            });

        // Mezclar y ordenar
        $posts = $checkins
            ->merge($reviews)
            ->sortByDesc('created_at')
            ->values();

   

        return view('cafemap.community.index', [
            'user' => $user,
            'reviewsCount' => $reviewsCount,
            'cafes' => $cafes,
            'activeTab' => 'comunidad',
            'posts' => $posts
        ]);
    }
}