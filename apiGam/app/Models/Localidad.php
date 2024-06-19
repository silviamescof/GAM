<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';
    
    use HasFactory;

    protected $fillable = [
        'codigo_postal',
        'nombre_localidad', 
        'provincia_localidad', 
        'pais_localidad',
     ];
     
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }
}
