<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Create procedure for updating liquidation totals
    DB::unprepared('
            CREATE PROCEDURE UpdateLiquidacionTotals(IN liquidacionId INT)
            BEGIN
    DECLARE num_nominas INT;
    DECLARE ttotal_salario DECIMAL(10,2) DEFAULT 0;
    DECLARE ttotal_deducciones DECIMAL(10,2) DEFAULT 0;
    DECLARE ttotal_comisiones DECIMAL(10,2) DEFAULT 0;
    DECLARE done INT DEFAULT 0;
    DECLARE current_nomina_id INT;

    DECLARE cur_nominas CURSOR FOR
        SELECT id FROM nominas WHERE idLiquidacion = liquidacionId;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    SELECT COUNT(*) INTO num_nominas
    FROM nominas
    WHERE idLiquidacion = liquidacionId;

    IF num_nominas > 0 THEN
        OPEN cur_nominas;
        
        fetch_nomina: LOOP
            FETCH cur_nominas INTO current_nomina_id;
            IF done THEN
                LEAVE fetch_nomina;
            END IF;

            UPDATE nominas
            SET
                total_comisiones = COALESCE(( 
                    SELECT SUM(CASE
                                WHEN esporcentaje = 1 THEN monto * (salario_base)
                                ELSE monto
                            END)
                    FROM comisiones_nomina
                    WHERE nomina_id = current_nomina_id), 0),
                total_deducciones = COALESCE(( 
                    SELECT SUM(CASE
                                WHEN esporcentaje = 1 THEN monto * (salario_base + total_comisiones)
                                ELSE monto
                            END)
                    FROM deducciones_nomina
                    WHERE nomina_id = current_nomina_id), 0),
                total = salario_base + COALESCE(( 
                    SELECT SUM(CASE
                                WHEN esporcentaje = 1 THEN monto * (salario_base)
                                ELSE monto
                            END)
                    FROM comisiones_nomina
                    WHERE nomina_id = current_nomina_id), 0)
                        - COALESCE(( 
                    SELECT SUM(CASE
                                WHEN esporcentaje = 1 THEN monto * (salario_base + total_comisiones)
                                ELSE monto
                            END)
                    FROM deducciones_nomina
                    WHERE nomina_id = current_nomina_id), 0)
            WHERE id = current_nomina_id;
        END LOOP;

        CLOSE cur_nominas;

        SELECT SUM(salario_base), SUM(total_deducciones), SUM(total_comisiones)
        INTO ttotal_salario, ttotal_deducciones, ttotal_comisiones
        FROM nominas
        WHERE idLiquidacion = liquidacionId;

        UPDATE liquidaciones
        SET
            salario = ttotal_salario,
            total_deducciones = ttotal_deducciones,
            total_comisiones = ttotal_comisiones,
            total = ttotal_salario + ttotal_comisiones - ttotal_deducciones
        WHERE id = liquidacionId;
    ELSE
        UPDATE liquidaciones
        SET
            salario = 0,
            total_deducciones = 0,
            total_comisiones = 0,
            total = 0
        WHERE id = liquidacionId;
    END IF;
END        ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Drop the procedure
    DB::unprepared('DROP PROCEDURE IF EXISTS UpdateLiquidacionTotals');
  }
};
