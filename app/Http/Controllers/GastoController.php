<?php

namespace App\Http\Controllers;

use App\Models\EstadoDeCuenta;
use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\S3Helper;

class GastoController extends Controller
{
    /**
     * Crear un nuevo gasto
     */
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:255',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB máximo
        ]);

        // Subir el comprobante a S3 si se adjunta
        $comprobantePath = null;

        // Subir el comprobante a S3 si se adjunta
        // if ($request->hasFile('comprobante')) {
        //     $comprobantePath = S3Helper::uploadFile($request->file('comprobante'), 'comprobantes');
        // }

        // Guardar el gasto en la base de datos
        $gasto = Gasto::create([
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'comprobante' => $comprobantePath,
        ]);

        // Obtener el saldo anterior
        $saldoAnterior = EstadoDeCuenta::getUltimoSaldo();

        // Calcular el nuevo saldo (restando el gasto)
        $nuevoSaldo = $saldoAnterior - $request->monto;

        // Registrar el egreso en el estado de cuenta
        EstadoDeCuenta::create([
            'saldo_anterior' => $saldoAnterior,
            'nuevo_saldo' => $nuevoSaldo,
            'diferencia' => '-' . $request->monto,
            'tipo' => 'egreso',
        ]);

        return response()->json($gasto, 201);
    }

    /**
     * Obtener todos los gastos
     */
    public function index()
    {
        $gastos = Gasto::all();
        return response()->json($gastos);
    }
}