<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentosTable extends Migration
{
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->integer('idDepartamento', 10)->unsigned()->primary();
            $table->string('nombre', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}
