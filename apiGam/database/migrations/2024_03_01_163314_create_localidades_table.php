<?php
// database/migrations/xxxx_xx_xx_xx_create_localidades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadesTable extends Migration
{
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->string('codigo_postal')->primary(); 
            $table->string('nombre_localidad');
            $table->string('provincia_localidad');
            $table->string('pais_localidad');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}

