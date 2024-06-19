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
        Schema::create('tipos_experiencia', function (Blueprint $table) {
            $table->id('id_tipo_experiencia'); // Definimos la columna id y le damos el nombre deseado
            $table->string('nombre_tipo');
            $table->string('estilo');
            $table->string('lugares_interes');

            $table->timestamps();

            
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_experiencia');
    }

};
