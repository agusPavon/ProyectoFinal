<?php
namespace App\Http\Controllers;

use App\Models\CafeSuggestion;
use App\Models\Cafe;
use Illuminate\Http\Request;

class CafeSuggestionAdminController extends Controller
{
    public function index()
    {
        $suggestions = CafeSuggestion::orderBy('created_at', 'desc')->get();
        return view('admin.cafes.suggestions.index', compact('suggestions'));
    }

    public function show($id)
    {
        $suggestion = CafeSuggestion::findOrFail($id);
        return view('admin.cafes.suggestions.show', compact('suggestion'));
    }

    public function approve($id)
    {
        $suggestion = CafeSuggestion::findOrFail($id);

        // Crear un nuevo café basado en la sugerencia
        Cafe::create([
            'name' => $suggestion->name,
            'address' => $suggestion->address,
            'website' => $suggestion->website,
            'latitude' => $suggestion->latitude,
            'longitude' => $suggestion->longitude,
            'roasting_type' => $suggestion->roasting_type,
            'attributes' => $suggestion->attributes,
        ]);

        $suggestion->update(['status' => 'aprobada']);

        return redirect()->route('admin.cafes.suggestions.index')->with('success', 'Cafetería aprobada y publicada.');
    }

    public function reject($id)
    {
        $suggestion = CafeSuggestion::findOrFail($id);
        $suggestion->update(['status' => 'rechazada']);

        return redirect()->route('admin.cafes.suggestions.index')->with('info', 'Sugerencia rechazada.');
}
}

