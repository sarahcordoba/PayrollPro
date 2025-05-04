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
    // Trigger para AFTER UPDATE en nominas
    DB::unprepared('
        CREATE TRIGGER UpdateLiquidacionAfterNominaUpdate
        AFTER UPDATE ON nominas
        FOR EACH ROW
        BEGIN
            CALL UpdateLiquidacionTotals(NEW.id);
        END
    ');
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Eliminar el trigger
    DB::unprepared('DROP TRIGGER IF EXISTS UpdateLiquidacionAfterNominaUpdate');
  }
};
