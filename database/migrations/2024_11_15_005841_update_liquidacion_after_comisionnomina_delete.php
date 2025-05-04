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
    // Trigger para AFTER UPDATE en deduccionnominas
    DB::unprepared('
    CREATE TRIGGER UpdateLiquidacionAfterComisionNominaDelete
    AFTER DELETE ON comisiones_nomina
    FOR EACH ROW
    BEGIN
        DECLARE liquidacionID INT;
    
        -- Obtener el idLiquidacion a partir de la nómina borrada
        SELECT idLiquidacion INTO liquidacionID
        FROM nominas
        WHERE id = OLD.nomina_id;
    
        -- Llamar al procedimiento almacenado para actualizar la liquidación
        CALL UpdateLiquidacionTotals(liquidacionID);
    END;
    
        ');
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Eliminar el trigger
    DB::unprepared('DROP TRIGGER IF EXISTS UpdateLiquidacionAfterComisionNominaDelete');
  }
};
