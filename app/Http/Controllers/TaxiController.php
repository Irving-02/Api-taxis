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
        // Crear una nueva instancia de Taxi y asignar los valores
        $taxi = new Taxi();
        $taxi->titular = $request->titular;
        $taxi->telefono = $request->telefono;
        $taxi->eco = $request->eco;
        $taxi->placa = $request->placa;
        $taxi->serie = $request->serie;
        $taxi->anio = $request->anio;
        $taxi->verificacion = $request->verificacion;
        $taxi->tipo = $request->tipo;

        // Guardar el taxi en la base de datos
        $taxi->save();

        // Devolver el objeto taxi guardado como respuesta JSON
        // Esto incluirá el ID generado y cualquier otro atributo
        return response()->json([
            'message' => 'Taxi agregado exitosamente',
            'taxi' => $taxi,
        ], 201);
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

    public function countTaxis()
    {
        $count = Taxi::count();
        return response()->json(['total' => $count], 200);
    }

    public function countTolerados()
    {
        $count = Taxi::where('tipo', 'Tolerado')->count();
        return response()->json(['total' => $count], 200);
    }

    public function countEspeciales()
    {
        $count = Taxi::where('tipo', 'Taxi')->count();
        return response()->json(['total' => $count], 200);
    }

    public function countVerificados()
    {
        $count = Taxi::where('verificacion', 'Si')->count();
        return response()->json(['total' => $count], 200);
    }
}
