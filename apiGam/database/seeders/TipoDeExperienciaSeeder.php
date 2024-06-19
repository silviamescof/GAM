<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoDeExperiencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class TipoDeExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // Elimina los registros existentes en la tabla
        DB::table('tipos_experiencia')->truncate();


        // Inserta registros en la tabla tipo_de_experiencias
        DB::table('tipos_experiencia')->insert([
            'nombre_tipo' => 'Artistica',
            'estilo' => 'Todo tipo de arte',
            'lugares_interes' => 'Museos, arte callejero, monumentos',
        ]);

        DB::table('tipos_experiencia')->insert([
            'nombre_tipo' => 'Cultural',
            'estilo' => 'Cultura antigua y moderna',
            'lugares_interes' => 'lugares de la ciudad, antiguedades, monumentos, museos',
        ]);

        DB::table('tipos_experiencia')->insert([
            'nombre_tipo' => 'Gastronomía',
            'estilo' => 'Gastronomia nacional y multinacional',
            'lugares_interes' => 'restaurantes, bares, clubs, asociaciones, vivienda, privada',
        ]);

        DB::table('tipos_experiencia')->insert([
            'nombre_tipo' => 'Deportiva',
            'estilo' => 'Deporte interior, exterior, acuatico, aereo y terrestre',
            'lugares_interes' => 'rutas, senderos, centros privados, publicos, asociaciones',
        ]);

        DB::table('tipos_experiencia')->insert([
            'nombre_tipo' => 'Religioso',
            'estilo' => 'Historia de la religion, lugares de culto, arte sacro',
            'lugares_interes' => 'iglesias, monumentos, procesiones, festividades',
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
