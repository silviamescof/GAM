<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;



class LocalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // Elimina los registros existentes en la tabla
        DB::table('localidades')->truncate();

        // Inserta tres registros en la tabla localidades
        DB::table('localidades')->insert([
            'codigo_postal' => '23740',
            'nombre_localidad' => 'Andujar',
            'provincia_localidad' => 'Jaen',
            'pais_localidad' => 'Espana',
        ]);

        DB::table('localidades')->insert([
            'codigo_postal' => '23770',
            'nombre_localidad' => 'Marmolejo',
            'provincia_localidad' => 'Jaen',
            'pais_localidad' => 'Espana',
        ]);

        DB::table('localidades')->insert([
            'codigo_postal' => '45710',
            'nombre_localidad' => 'Madridejos',
            'provincia_localidad' => 'Toledo',
            'pais_localidad' => 'Espana',
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
