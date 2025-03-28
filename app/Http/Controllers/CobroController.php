<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\EstadoDeCuenta;
use Carbon\Carbon;
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
        $cobros = Cobro::with('taxi')->orderBy('id', 'desc')->get(); // Trae todos los cobros con la información del taxi relacionado
        return response()->json($cobros);
    }

    public function SumaIngresosSemanal()
    {
        $sumaIngresosSemanal = Cobro::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->whereNull('deleted_at')
            ->sum('monto');

        return response()->json(['total' => $sumaIngresosSemanal]);
    }
    public function SumaIngresoMensual()
    {
        $sumaIngresoMensual = Cobro::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->whereNull('deleted_at')
            ->sum('monto');

        return response()->json(['total' => $sumaIngresoMensual]);
    }

    public function IngresosMensuales()
    {
        $ingresos = Cobro::selectRaw('DATE(created_at) as fecha, SUM(monto) as total')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->whereNull('deleted_at')
            ->groupBy('fecha')
            ->orderBy('fecha', 'ASC')
            ->get();

        return response()->json($ingresos);
    }
}