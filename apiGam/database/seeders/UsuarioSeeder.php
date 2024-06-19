<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // Elimina los registros existentes en la tabla
        DB::table('usuarios')->truncate();

        // Inserta registros en la tabla usuarios
        DB::table('usuarios')->insert([
            'dni' => '53598060X',
            'nombre_usuario' => 'Silvia',
            'password' => '1234',
            'fecha_nacimiento' => '1992-04-25',
            'sobremi' => 'Me gusta la cultura general, dar paseos y aportar datos',
            'apellidos' => 'Mesa Cofrades',
            'direccion' => 'Calle San nicolas 16, 23740 andujar, Jaen',
            'codigo_postal_usuario' => '23740',
            'telefono' => '620739843',
            'email' => 'smesacofrades@gmail.com',
        ]);

        DB::table('usuarios')->insert([
            'dni' => '53598061B',
            'nombre_usuario' => 'Patricia',
            'password' => '',
            'fecha_nacimiento' => '1996-11-03',
            'sobremi' => 'Me gusta hablar sobre la actualidad del mundo e ir a fiestas tipicas de los lugares',
            'apellidos' => 'Mesa Cofrades',
            'direccion' => 'Calle aguilas 13 23740 Vegas de Triana , Andujar Jaen',
            'codigo_postal_usuario' => '23740',
            'telefono' => '650986806',
            'email' => 'patriciamesa@gmail.com',
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
