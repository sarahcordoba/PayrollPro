<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id(); // Clave primaria
        
            $table->date('fecha_inicio'); // Fecha de inicio del período de liquidación
            $table->date('fecha_fin'); // Fecha de fin del período de liquidación
            $table->string('estado', 15); // Estado de la liquidación, por ejemplo: "Pendiente", "Completado"
        
            $table->decimal('salario', 10, 2); // Salario base del empleado para el período
            $table->decimal('total_deducciones', 10, 2)->default(0); // Total de deducciones aplicadas
            $table->decimal('total_comisiones', 10, 2)->default(0); // Total de comisiones aplicadas
            $table->decimal('total', 10, 2); // Salario neto después de deducciones y comisiones
        
            $table->timestamps(); // Timestamps de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidaciones');
    }
};
