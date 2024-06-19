<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('dni')->primary();
            $table->string('nombre_usuario');
            $table->string('password');
            $table->date('fecha_nacimiento');
            $table->text('sobremi')->nullable();
            $table->string('apellidos');
            $table->string('direccion');
            $table->string('codigo_postal_usuario');
            $table->string('telefono');
            $table->string('email');
            
            // Añade la clave foránea a la tabla localidades
            $table->foreign('codigo_postal_usuario')->references('codigo_postal')->on('localidades');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
