<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosTable extends Migration
{
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 8, 2); // Monto del gasto
            $table->text('descripcion'); // Descripción del gasto
            $table->string('comprobante')->nullable(); // Ruta del archivo comprobante
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gastos');
    }
}