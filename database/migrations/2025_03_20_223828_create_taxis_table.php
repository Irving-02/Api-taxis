<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();
            $table->string('titular');
            $table->string('telefono');
            $table->string('eco');
            $table->string('placa');
            $table->string('serie');
            $table->integer('anio');
            $table->string('verificacion');
            $table->string('tipo'); // Sedan, SUV, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxis');
    }
};