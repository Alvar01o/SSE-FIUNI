<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class Encuestas extends Model
{
    use HasFactory;

    protected $_encuesta_users = [];
    protected $_id_de_usuarios_asignados = [];
    protected $_id_preguntas = [];
    protected $_encuesta_preguntas = [];

    protected $fillable = [
        'nombre',
        'tipo'
    ];

    public function preguntas() {
        return $this->_encuesta_preguntas ? $this->_encuesta_preguntas : $this->_encuesta_preguntas = $this->hasMany(Preguntas::class, 'encuesta_id', 'id');
    }

    public function getEncuestaUsers() {
        return $this->_encuesta_users;
    }

    public function getUsuariosAsignados() {
        $encuesta_users = User::join('encuesta_users', 'users.id', '=', 'encuesta_users.user_id')->where('encuesta_users.encuesta_id', '=', $this->id)->orderByDesc('encuesta_users.id')->get();
        return $encuesta_users;
    }

    public function existPregunta($pregunta_id, $devolver_pregunta = false)
    {
        if (!empty($this->_id_preguntas)) {
            if (in_array($pregunta_id, $this->_id_preguntas)) {
                return ($devolver_pregunta) ? Preguntas::find($pregunta_id) : true;
            } else {
                return false;
            }
        } else {
            $this->_id_preguntas = array_map(function($o) { return $o->id;}, $this->preguntas()->getResults()->all());
            if (in_array($pregunta_id, $this->_id_preguntas)) {
                return ($devolver_pregunta) ? Preguntas::find($pregunta_id) : true;
            } else {
                return false;
            }
        }
    }

    public function existeUsuarioAsignado($user_id, $devolver_usuario = false) {
        if (!empty($this->_id_de_usuarios_asignados)) {
            if (in_array($user_id, $this->_id_de_usuarios_asignados)) {
                return ($devolver_usuario) ? User::find($user_id) : true;
            } else {
                return false;
            }
        } else {
           $this->_id_de_usuarios_asignados = array_map(function($o) { return $o->user_id;}, $this->encuestaUsers()->getResults()->all());
            if (in_array($user_id, $this->_id_de_usuarios_asignados)) {
                return ($devolver_usuario) ? User::find($user_id) : true;
            } else {
                return false;
            }
        }
    }

    public function encuestaUsers() {
        if ($this->_encuestas_user) {
            return $this->_encuesta_users;
        } else {
            return $this->_encuesta_users = $this->hasMany(EncuestaUsers::class, 'encuesta_id', 'id');
        }
    }

}
