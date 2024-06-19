<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            TipoDeExperienciaSeeder::class,
            
        ]);
        $this->call([
            LocalidadesTableSeeder::class,
            
        ]);
        $this->call([
            UsuarioSeeder::class,
            
        ]);
        $this->call([
            ExperienciaSeeder::class,
            
        ]);
    }
}
