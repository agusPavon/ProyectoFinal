<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CafeSuggestion;

class CafeSuggestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'roasting_type' => 'nullable|string|max:50',
            'attributes' => 'nullable|array'
        ]);

        CafeSuggestion::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'website' => $validated['website'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'roasting_type' => $validated['roasting_type'] ?? null,
            'attributes' => isset($validated['attributes']) ? json_encode($validated['attributes']) : null,
            'status' => 'pendiente'
        ]);

        return response()->json(['success' => true]);
    }
}
