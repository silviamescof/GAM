<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeExperiencia extends Model
{
    protected $table = 'tipos_experiencia';
    use HasFactory;

    protected $fillable = [
        'id_tipo_experiencia',
        'nombre_tipo',
        'estilo',
        'lugares_interes',
    ];

    // Relación con Experiencia
    public function experiencias()
    {
        return $this->hasMany(Experiencia::class, 'categoria', 'id_tipo_experiencia');
    }

}
