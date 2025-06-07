<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacidadesTable extends Migration
{
    public function up()
    {
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id(); // id: bigint (auto-incremental)
            $table->unsignedBigInteger('id_empleado'); // Relación con empleado
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->integer('dias_incapacidad')->nullable();
            $table->date('fecha_registro');
            $table->string('tipo_incapacidad', 100);
            $table->string('descripcion', 1000)->nullable();
            $table->string('soporte', 500)->nullable();
            $table->string('estado', 50)->nullable();
            $table->date('fecha_revision')->nullable();
            $table->unsignedBigInteger('id_rrhh')->nullable(); // Relación con usuario RRHH
            $table->string('observaciones_rrhh', 1000)->nullable();

            // Relaciones (si existen las tablas correspondientes)
            $table->foreign('id_empleado')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('id_rrhh')->references('id')->on('users')->onDelete('set null'); // Asumiendo RRHH es un user
        });
    }

    public function down()
    {
        Schema::dropIfExists('incapacidades');
    }
}
