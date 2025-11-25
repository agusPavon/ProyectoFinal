<?php

namespace App\Http\Controllers;
use App\Models\Cafe;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use App\Models\CafeSuggestion;
class CafeAdminController extends Controller
{
    public function index()
    {
        $mapboxKey = config('services.mapbox.key');

        $cafes = Cafe::all();

        return view('admin.cafes.index', [
        'cafes'   =>$cafes,
        'mapboxKey' =>$mapboxKey,
    ]);
    }

    public function create()
    {
        return view('admin.cafes.create');
    }



    public function edit($id)
    {
        // Buscar el café por su ID o lanzar error 404 si no existe
        $cafe = Cafe::findOrFail($id);

        $mapboxKey = env('MAPBOX_KEY');

        // Enviar datos a la vista
        return view('admin.cafes.edit', compact('cafe', 'mapboxKey'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'address'         => 'required|string|max:255',
        'lat'             => 'nullable|numeric|between:-90,90',
        'lng'             => 'nullable|numeric|between:-180,180',
        'description'     => 'nullable|string',
        'average_rating'  => 'nullable|numeric|min:0|max:5',
        'website'         => 'nullable|string|max:255',
        'roasting_type'   => 'nullable|string|max:255',
        'origin'          => 'nullable|string|max:255',
        'milk'            => 'nullable|string|max:255',
        'opening_hours' => 'nullable|json',
        'coffee_types'    => 'nullable|array',
        'milk_options'    => 'nullable|array',
        'features'        => 'nullable|array',
        'attributes'      => 'nullable|array',
    ]);

    $cafe = Cafe::findOrFail($id);

    // Update normales
    $cafe->fill($validated);

    // JSON fields
    $cafe->coffee_types = json_encode($request->input('coffee_types', []));
    $cafe->milk_options = json_encode($request->input('milk_options', []));
    $cafe->features     = json_encode($request->input('features', []));
    $cafe->attributes   = json_encode($request->input('attributes', []));
    $cafe->opening_hours = $request->opening_hours;

    // Guardar
    $cafe->save();

    return redirect()->route('admin.cafes.index')
        ->with('success', 'Cafetería actualizada correctamente.');
}


        public function destroy($id)
        {
            // Buscar la cafetería
            $cafe = Cafe::findOrFail($id);

            // Eliminarla
            $cafe->delete();

            // Redirigir con mensaje de éxito
            return redirect()
                ->route('admin.cafes.index')
                ->with('success', 'La cafetería fue eliminada correctamente.');
        }

        public function show($id)
            {
                $cafe = Cafe::findOrFail($id);
                
                return view('admin.cafes.show', [
                'cafe' => $cafe,
                'openingHours' => json_decode($cafe->opening_hours, true),
            ]);

            }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'average_rating' => 'nullable|numeric|min:0|max:5',
            'opening_hours' => 'nullable|json',
            'coffee_types' => 'nullable|array',
            'milk_options' => 'nullable|array',
            'features' => 'nullable|array',
            'roasting_type' => 'nullable|string|max:255',
            'origin' => 'nullable|string|max:255',
            'milk' => 'nullable|string|max:255',
            'attributes' => 'nullable|array',

            
        ]);

        $cafe = new Cafe();
        $cafe->fill($validated);
        $cafe->coffee_types = json_encode($request->input('coffee_types', []));
        $cafe->milk_options = json_encode($request->input('milk_options', []));
        $cafe->features = json_encode($request->input('features', []));
        $cafe->opening_hours = $request->input('opening_hours');
        $cafe->roasting_type = $request->roasting_type;
        $cafe->origin = $request->origin;
        $cafe->milk = $request->milk;
        $cafe->attributes = json_encode($request->input('attributes', []));
        $cafe->save();



        return redirect()->route('admin.cafes.index')->with('success', 'Cafetería creada correctamente.');
    }
}



