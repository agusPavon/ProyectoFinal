<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;

class MapaController extends Controller
{
  public function index()
{
    $cafes = Cafe::select(
        'id',
         'name',
        'address',
        'lat',
        'lng',
        'description',
        'average_rating',
        'website',
        'roasting_type',
        'origin',
        'milk',
        'coffee_types',
        'milk_options',
        'features',
        'attributes',
        'opening_hours'
    )->get();

    return view('cafemap.mapa', [
        'cafes' => $cafes,
        'mapboxKey' => config('services.mapbox.key'),
        'activeTab' => 'mapa'

    ]);
}

        

    public function suggestNew() {
         $mapboxKey = config('services.mapbox.key');
    return view('cafemap.suggest-new', [
        'activeTab' => 'cafemap',
    'mapboxKey' => $mapboxKey,]);
    }
    public function getCafesApi()
    {
        $cafes = Cafe::select(
            'id',
            'name',
            'address',
            'lat',
            'lng',
            'description',
            'average_rating',
            'website',
            'roasting_type',
            'origin',
            'milk',
            'coffee_types',
            'milk_options',
            'features',
            'attributes',
            'opening_hours'
        )->get();

        return response()->json($cafes);
    }
}
