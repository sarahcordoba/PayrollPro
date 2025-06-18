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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->foreign('employeeId')->references('id')->on('empleados')->onDelete('cascade');
            $table->string('name');
            $table->enum('role', ['admin', 'rrhh', 'employee'])->default('employee');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_time')->default(true);
            // $table->string('nit')->unique(); // Agregado: Campo NIT único
            // $table->string('nombre_empresa'); // Agregado: Campo Nombre de la empresa
            // $table->string('role')->default('user')->after('email'); // Or use an enum: $table->enum('role', ['admin', 'editor', 'user'])->default('user')->after('email');
            $table->rememberToken();
            $table->timestamps();
        });
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
