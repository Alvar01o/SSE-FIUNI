<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Carreras extends Model
{
    use HasFactory;
    protected $fillable = [
        'carrera'
    ];

    public function usuariosCount()
    {
        $users = User::where('carrera_id', $this->id)->get();
        return $users->count();
    }

    public function tieneUsuarios() {
        $siEncuentraAlmenosUno = false;
        $users = User::where('carrera_id', $this->id)->get();
        return $users->count() == 0 ? false : true;
    }
}
