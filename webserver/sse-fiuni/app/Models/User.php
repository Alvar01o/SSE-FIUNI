<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;
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
        'token_invitacion'
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

    public function laboral()
    {
        return $this->hasMany(Laboral::class);
    }

    public function datosPersonales()
    {
        return $this->hasMany(DatosPersonales::class);
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

    public function getNombreCompleto()
    {
        if ($this->apellido !== '') {
            return $this->nombre.", ".$this->apellido;
        } else {
            return $this->nombre;
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl('/img/avatar.png')
            ->useFallbackPath(public_path('/img/avatar.png'))
            ->acceptsMimeTypes(['image/jpeg', 'image/gif', 'image/bmp', 'image/png'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('perfil')
            ->width(154)
            ->height(154)
            ->sharpen(10);

        $this->addMediaConversion('small_avatar')
            ->width(32)
            ->height(32)
            ->sharpen(10);
    }
}
