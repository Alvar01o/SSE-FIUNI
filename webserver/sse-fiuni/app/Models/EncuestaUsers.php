<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'encuesta_id',
        'notificado',
        'invitacion_empleadores',
        'created_at',
        'updated_at'
    ];

    public function encuesta()
    {
        return $this->belongsTo(Encuestas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
