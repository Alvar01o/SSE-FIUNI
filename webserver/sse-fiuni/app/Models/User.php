<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    const ROLE_EGRESADO = 'egresado';
    const ROLE_ADMINISTRADOR = 'administrador';
    const ROLE_EMPLEADOR = 'empleador';
    const ROLE_VISITANTE = 'visitante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'carrera_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carreras::class);
    }

    public function getName()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIniciales()
    {
        $n = $this->nombre[0];
        $a = $this->apellido[0];
        return strtoupper("{$n}{$a}");
    }
}
