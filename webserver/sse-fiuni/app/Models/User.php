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
use App\Models\Laboral;
use App\Models\Educacion;
use App\Models\LaboralUser;
use App\Models\LaboralEmpleador;
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
        'ingreso',
        'egreso',
        'token_invitacion'
    ];

    private $_empleos = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'token_invitacion',
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

    public function getEncuestasAsignadas() {
        $encuestas = EncuestaUsers::select(['encuestas.nombre', 'encuesta_users.*'])
        ->where('user_id', '=', $this->id)->join('encuestas', 'encuestas.id', '=', 'encuesta_users.encuesta_id')->get();
        return $encuestas;
    }

    public function asignadoA($encuesta_id){
        $encuesta_user = EncuestaUsers::where('encuesta_id', '=', $encuesta_id)->where('user_id', '=', $this->id)->first();
        return $encuesta_user;
    }

    public function getEmpresaDeEmpleador()
    {
        $datos_empleador = LaboralEmpleador::where('empleador_id', '=', $this->id)
        ->join('laboral', 'laboral.id', '=', 'laboral_empleador.laboral_id')->first();
        if ($datos_empleador) {
            return $datos_empleador->empresa;
        } else {
            return '';
        }
    }

    public function getEmpleos()
    {

        if (!empty($this->_empleos)) {
            return $this->_empleos;
        } else {
            return $this->_empleos = LaboralUser::where('user_id', '=', $this->id)->get();
        }
    }

    public function addCargoLaboral($empresa, $cargo, $inicio, $fin = null)
    {
        $empresa_data = Laboral::whereRaw('lower(empresa) = ?', strtolower($empresa))->first();
        if ($empresa_data) {
           return LaboralUser::create(['user_id' => $this->id, 'laboral_id' => $empresa_data->id, 'cargo' => $cargo, 'inicio' => $inicio, 'fin' => $fin]);
        }
        $laboral = Laboral::create(['empresa' => $empresa]);
        return LaboralUser::create(['user_id' => $this->id, 'laboral_id' => $laboral->id, 'cargo' => $cargo, 'inicio' => $inicio, 'fin' => $fin]);
    }

    public function addComoEmpleador($laboral_id)
    {
        return LaboralEmpleador::create(['empleador_id' => $this->id, 'laboral_id' => $laboral_id]);
    }

    public function datosPersonales()
    {
        return $this->hasMany(DatosPersonales::class);
    }

    public function educacion()
    {
        return $this->hasMany(Educacion::class);
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
