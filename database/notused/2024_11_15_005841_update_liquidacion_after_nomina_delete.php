<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Trigger para AFTER DELETE en nominas
    DB::unprepared('
        CREATE TRIGGER UpdateLiquidacionAfterNominaDelete
        AFTER DELETE ON nominas
        FOR EACH ROW
        BEGIN
          CALL UpdateLiquidacionTotals(OLD.idLiquidacion);
        END
        ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Eliminar el trigger
    DB::unprepared('DROP TRIGGER IF EXISTS UpdateLiquidacionAfterNominaDelete');
  }
};
