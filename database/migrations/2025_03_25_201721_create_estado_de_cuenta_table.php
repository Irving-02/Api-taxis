<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('estado_de_cuentas', function (Blueprint $table) {
            $table->id();
            $table->decimal('saldo_anterior', 10, 2);
            $table->decimal('nuevo_saldo', 10, 2);
            $table->decimal('diferencia', 10, 2)->default(0);
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estado_de_cuentas');
    }
};