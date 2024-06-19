<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Experiencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Elimina los registros existentes en la tabla
        DB::table('experiencias')->truncate();

        // Inserta registros en la tabla experiencias
        DB::table('experiencias')->insert([
            'dni_proveedor' => '53598060X',
            'estado_experiencia' => 'activa',
            'titulo_experiencia' => 'Tour gastronimico por andujar',
            'descripcion_experiencia' => 'Iremos a probar el autoctono flamenquin a "el flamenco" y a las perolas a por unas tapas tipicas',
            'lugar_partida' => 'Plaza del ayuntamiento',
            'coste_estimado' => 20,
            'fecha_experiencia' => '2024-04-05',
            'tipo' => 3, 
            'codigo_postal_experiencia' => '23740',
        ]);

        DB::table('experiencias')->insert([
            'dni_proveedor' => '53598061B',
            'estado_experiencia' => 'activa',
            'titulo_experiencia' => 'Subida al santuario por el camino viejo',
            'descripcion_experiencia' => 'Subiremos al santuario por el historico camino viejo, ruta de perigrinos y caballos',
            'lugar_partida' => 'cementerio de andujar',
            'coste_estimado' => 0,
            'fecha_experiencia' => '2024-04-10',
            'tipo' => 4, 
            'codigo_postal_experiencia' => '23740',
        ]);
        Schema::enableForeignKeyConstraints();

    }
}
