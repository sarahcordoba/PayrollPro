<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialPagosTable extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('nomina_id');
            $table->decimal('total_devengado', 10, 2);
            $table->decimal('total_deducciones', 10, 2);
            $table->decimal('total_pagado', 10, 2);
            $table->date('fecha_pago');
            $table->string('estado_pago')->default('pendiente');
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('nomina_id')->references('id')->on('nominas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
