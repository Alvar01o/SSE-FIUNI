<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;
    const TIPO_PREGUNTA = 'pregunta';
    const TIPO_SELECCION_MULTIPLE = 'seleccion_multiple';
    const TIPO_SELECCION_MULTIPLE_JUSTIFICACION = 'seleccion_multiple_justificacion';
    const TIPO_SELECCION_SIMPLE = 'seleccion';
    const TIPO_SELECCION_SIMPLE_JUSTIFICACION = 'seleccion_justificacion';

    protected $fillable = [
        'pregunta',
        'tipo_pregunta',
        'encuesta_id',
        'justificacion',
        'requerido'
    ];

    const TIPOS = ['pregunta', 'seleccion_multiple', 'seleccion_multiple_justificacion', 'seleccion', 'seleccion_justificacion'];

    const TIPOS_TEXT = ['pregunta' => 'Pregunta', 'seleccion_multiple' => 'Selección Multiple', 'seleccion_multiple_justificacion' => 'Selección Multiple con justificación', 'seleccion' => 'Selección unica', 'seleccion_justificacion' => 'Selección unica con justificación'];


    public function getTipoText() {
        return self::TIPOS_TEXT[$this->tipo_pregunta];
    }

    public function opcionesPregunta() {
        return $this->hasMany(OpcionesPregunta::class, 'pregunta_id', 'id');
    }

}
