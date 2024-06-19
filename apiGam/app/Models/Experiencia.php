<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'id_experiencia',
        'dni_proveedor',
        'estado_experiencia',
        'titulo_experiencia',
        'descripcion_experiencia',
        'lugar_partida',
        'coste_estimado',
        'fecha_experiencia',
        'categoria',
        'codigo_postal_experiencia',
    ];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'codigo_postal_experiencia', 'codigo_postal');
    }
    public function proveedor()
    {
        return $this->belongsTo(Usuario::class, 'dni_proveedor', 'dni');
    }
    public function tipoExperiencia()
    {
        return $this->belongsTo(TipoDeExperiencia::class, 'categoria', 'id_tipo_experiencia');
    }
}
