<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\EstadoDeCuenta;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    /**
     * Crear un nuevo cobro
     */
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'taxi_id' => 'required|exists:taxis,id',
            'concepto' => 'required|string',
            'tipo' => 'required|in:pago_administracion,multa',
        ]);

        // Guardar el cobro
        $cobro = Cobro::create($request->all());

        // Obtener el saldo anterior
        $saldoAnterior = EstadoDeCuenta::getUltimoSaldo();

        // Calcular el nuevo saldo (sumando el cobro)
        $nuevoSaldo = $saldoAnterior + $request->monto;

        // Registrar el ingreso en el estado de cuenta
        EstadoDeCuenta::create([
            'saldo_anterior' => $saldoAnterior,
            'nuevo_saldo' => $nuevoSaldo,
            'diferencia' => '+' . $request->monto,
            'tipo' => 'ingreso',
        ]);


        return response()->json($cobro, 201);
    }

    /**
     * Obtener todos los cobros
     */
    public function index()
    {
        $cobros = Cobro::with('taxi')->get(); // Trae todos los cobros con la información del taxi relacionado
        return response()->json($cobros);
    }
}