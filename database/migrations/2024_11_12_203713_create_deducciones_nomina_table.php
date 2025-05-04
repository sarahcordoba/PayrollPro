<?php
// database/migrations/xxxx_xx_xx_create_deducciones_nomina_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeduccionesNominaTable extends Migration
{
    public function up()
    {
        Schema::create('deducciones_nomina', function (Blueprint $table) {
            $table->unsignedBigInteger('nomina_id');
            $table->unsignedBigInteger('deduccion_id');

            $table->primary(['nomina_id', 'deduccion_id']);
            $table->foreign('nomina_id')->references('id')->on('nominas')->onDelete('cascade');
            $table->foreign('deduccion_id')->references('id')->on('deducciones')->onDelete('cascade');

            $table->boolean('esporcentaje')->default(false);
            $table->decimal('monto', 10, 2)->default(null);
        });
    }

    public function down()
    {
        Schema::dropIfExists('deducciones_nomina');
    }
}
