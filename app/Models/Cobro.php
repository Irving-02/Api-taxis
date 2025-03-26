<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto',
        'taxi_id',
        'tipo',
        'concepto'
    ];

    /**
     * Relación con el modelo Taxi
     */
    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
}