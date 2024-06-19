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
    Schema::create('experiencias', function (Blueprint $table) {
        // Definición de las columnas
        $table->id('id_experiencia');  // Mantengo 'id' como clave primaria
        $table->string('dni_proveedor');
        $table->string('estado_experiencia');
        $table->string('titulo_experiencia');
        $table->text('descripcion_experiencia');
        $table->string('lugar_partida');
        $table->decimal('coste_estimado', 10, 2)->nullable();
        $table->date('fecha_experiencia');
        $table->bigInteger('tipo')->unsigned(); // Cambiado a 'bigInteger'
        $table->string('codigo_postal_experiencia');

        // Restricciones de clave foránea
        $table->foreign('dni_proveedor')->references('dni')->on('usuarios');
        $table->foreign('codigo_postal_experiencia')->references('codigo_postal')->on('localidades');
        $table->foreign('tipo')->references('id_tipo_experiencia')->on('tipos_experiencia');

        $table->timestamps();
    });
}



    public function down()
    {
        Schema::dropIfExists('experiencias');
    }
};
