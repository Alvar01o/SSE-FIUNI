<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuestas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo'
    ];

    public function preguntas() {
        return $this->hasMany(Preguntas::class, 'encuesta_id', 'id');
    }

    public function encuestaUsers() {
        return $this->hasMany(EncuestaUsers::class, 'encuesta_id', 'id');
    }
}
