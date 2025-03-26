<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 8, 2); // Monto del cobro
            $table->foreignId('taxi_id')->constrained('taxis')->onDelete('cascade'); // Relación con la tabla taxis
            $table->enum('tipo', ['pago_administracion', 'multa']); // Tipo de cobro
            $table->string('concepto');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobros');
    }
}