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
        // return $request;
        // $validated = $request->validate([
        //     'numero_economico' => 'required|string',
        //     'placa' => 'required|string',
        //     'titular' => 'required|string',
        //     'tipo' => 'required|string',
        //     'marca' => 'required|string',
        //     'modelo' => 'required|string',
        //     'anio' => 'required|integer',
        //     'telefono' => 'required|string',
        // ]);
        // dd('hola');
        $taxi = new Taxi();
        $taxi->numero_economico = $request->numero_economico;
        $taxi->placa = $request->placa;
        $taxi->titular = $request->titular;
        $taxi->tipo = $request->tipo;
        $taxi->marca = $request->marca;
        $taxi->modelo = $request->modelo;
        $taxi->anio = $request->anio;
        $taxi->telefono = $request->telefono;
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