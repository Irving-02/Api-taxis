<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();
            $table->string('numero_economico');
            $table->string('placa');
            $table->string('titular');
            $table->string('tipo'); // Sedan, SUV, etc.
            $table->string('marca');
            $table->string('modelo');
            $table->integer('anio');
            $table->string('telefono');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxis');
    }
};