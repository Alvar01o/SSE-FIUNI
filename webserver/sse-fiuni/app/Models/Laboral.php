<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboral extends Model
{
    use HasFactory;
    protected $table = 'laboral';

    protected $fillable = [
        'empresa',
        'cargo',
        'inicio',
        'fin'
    ];

    public function empleadores() {
        return $this->belongsToMany(User::class, 'laboral_empleador', 'empleador_id', 'laboral_id');
    }


}
