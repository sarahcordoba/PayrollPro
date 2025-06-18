<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominasTable extends Migration
{
    public function up()
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('idLiquidacion');
            // $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('idLiquidacion')->references('id')->on('liquidaciones');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');


            $table->string('metodopago', 15);
            $table->string('estado', 15);

            $table->decimal('salario_base', 20, 2);
            $table->decimal('total_deducciones', 20, 2)->default(0);
            $table->decimal('total_comisiones', 20, 2)->default(0);
            $table->decimal('total', 20, 2); // Salario neto después de deducciones y comisiones
        });
    }

    public function down()
    {
        Schema::dropIfExists('nominas');
    }
}
