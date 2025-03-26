<?php
namespace App\Http\Controllers;



use App\Models\EstadoDeCuenta;
use Illuminate\Http\Request;
use App\Models\EstadoCuenta;
use App\Models\Cobro;
use App\Models\Gasto;


class EstadoDeCuentaController extends Controller
{
    public function registrarMovimiento($monto, $tipo)
    {
        $ultimoMovimiento = EstadoDeCuenta::latest()->first();
        $saldo_anterior = $ultimoMovimiento ? $ultimoMovimiento->nuevo_saldo : 0;

        if ($tipo === 'ingreso') {
            $nuevo_saldo = $saldo_anterior + $monto;
            $diferencia = $monto; // La diferencia es el monto del cobro
        } else {
            $nuevo_saldo = $saldo_anterior - $monto;
            $diferencia = -$monto; // La diferencia es negativa en caso de gasto
        }

        return EstadoCuenta::create([
            'saldo_anterior' => $saldo_anterior,
            'nuevo_saldo' => $nuevo_saldo,
            'diferencia' => $diferencia,
            'tipo' => $tipo
        ]);
    }

    public function registrarCobro(Cobro $cobro)
    {
        return $this->registrarMovimiento($cobro->monto, 'ingreso');
    }

    public function registrarGasto(Gasto $gasto)
    {
        return $this->registrarMovimiento($gasto->monto, 'egreso');
    }



    /**
     * Obtener todas las transacciones
     */
    public function index()
    {
        $estadoDeCuenta = EstadoDeCuenta::all();
        return response()->json($estadoDeCuenta);
    }
}