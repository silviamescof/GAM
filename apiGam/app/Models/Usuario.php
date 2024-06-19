<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'nombre_usuario',
        'password',
        'fecha_nacimiento',
        'sobremi',
        'apellidos',
        'direccion',
        'codigo_postal_usuario',
        'telefono',
        'email', 
    ];
    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'codigo_postal_usuario', 'codigo_postal');
    }
    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'dni_proveedor', 'dni');
    }
   
}
