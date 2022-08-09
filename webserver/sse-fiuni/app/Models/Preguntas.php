<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;
    protected $fillable = [
        'pregunta',
        'tipo_pregunta',
        'encuesta_id',
        'justificacion',
        'requerido'
    ];
    const TIPOS = ['pregunta', 'seleccion_multiple', 'seleccion_multiple_justificacion', 'seleccion', 'seleccion_justificacion'];

    public function opcionesPregunta() {
        return $this->hasMany(OpcionesPregunta::class, 'pregunta_id', 'id');
    }

}
