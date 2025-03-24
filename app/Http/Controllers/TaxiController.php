<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taxi;

class TaxiController extends Controller
{
    public function index()
    {
        return response()->json(Taxi::all(), 200);
    }

    public function store(Request $request)
    {
        $taxi = new Taxi();
        $taxi->titular = $request->titular;
        $taxi->telefono = $request->telefono;
        $taxi->eco = $request->eco;
        $taxi->placa = $request->placa;
        $taxi->serie = $request->serie;
        $taxi->anio = $request->anio;
        $taxi->verificacion = $request->verificacion;
        $taxi->tipo = $request->tipo;
        $taxi->save();

        // dd($taxi);

        return response()->json($taxi, 201);
    }

    public function show($id)
    {
        $taxi = Taxi::find($id);
        if (!$taxi) {
            return response()->json(['message' => 'Taxi no encontrado'], 404);
        }
        return response()->json($taxi, 200);
    }

    public function update(Request $request, $id)
    {
        $taxi = Taxi::find($id);
        if (!$taxi) {
            return response()->json(['message' => 'Taxi no encontrado'], 404);
        }

        $validated = $request->validate([
            'numero_economico' => 'string|unique:taxis,numero_economico,' . $id,
            'placa' => 'string|unique:taxis,placa,' . $id,
            'titular' => 'string',
            'tipo' => 'string',
        ]);

        $taxi->update($validated);

        return response()->json($taxi, 200);
    }

    public function destroy($id)
    {
        $taxi = Taxi::find($id);
        if (!$taxi) {
            return response()->json(['message' => 'Taxi no encontrado'], 404);
        }

        $taxi->delete();

        return response()->json(['message' => 'Taxi eliminado correctamente'], 200);
    }
}