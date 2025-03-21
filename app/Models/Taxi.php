<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_economico',
        'placa',
        'titular',
        'tipo',
        'marca',
        'modelo',
        'anio',
        'telefono',
    ];
}