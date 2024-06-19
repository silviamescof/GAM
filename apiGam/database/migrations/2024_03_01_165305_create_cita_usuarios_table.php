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
        Schema::create('cita_usuarios', function (Blueprint $table) {
            $table->id('id_cita'); // Llave primaria
            $table->string('dni_consumidor');  // Llave foránea de la tabla experiencias
            $table->unsignedBigInteger('id_experiencia'); // Llave foránea de la tabla experiencias

            // Definición de las relaciones
            $table->foreign('dni_consumidor')->references('dni')->on('usuarios');
            $table->foreign('id_experiencia')->references('id_experiencia')->on('experiencias');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita_usuarios');
    }
};
