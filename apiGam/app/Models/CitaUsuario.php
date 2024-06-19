<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cita',
        'dni_consumidor',
        'id_experiencia',
    ];

    // Relación con Usuario (consumidor)
    public function consumidor()
    {
        return $this->belongsTo(Usuario::class, 'dni_consumidor', 'dni');
    }

    // Relación con Experiencia
    public function experiencia()
    {
        return $this->belongsTo(Experiencia::class, 'id_experiencia')
            ->where('dni_proveedor', $this->dni_proveedor);
    }
}
