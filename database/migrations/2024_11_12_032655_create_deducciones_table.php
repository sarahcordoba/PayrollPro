<?php

// database/migrations/xxxx_xx_xx_create_deduccion_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeduccionesTable extends Migration
{
    public function up()
    {
        Schema::create('deducciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->string('descripcion', 255);
            $table->boolean('esporcentaje')->default(false);
            $table->decimal('monto', 10, 2);
            $table->boolean('obligatorio')->default(false);;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deducciones');
    }
}

