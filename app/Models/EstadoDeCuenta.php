<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoDeCuenta extends Model
{
    use HasFactory;


    protected $table = 'estado_de_cuentas';

    protected $fillable = [
        'saldo_anterior',
        'nuevo_saldo',
        'diferencia',
        'tipo'
    ];

    /**
     * Obtener el saldo total hasta la última transacción
     */
    public static function getUltimoSaldo()
    {
        $ultimoRegistro = EstadoDeCuenta::latest()->first();
        return $ultimoRegistro ? $ultimoRegistro->nuevo_saldo : 0;
    }
}