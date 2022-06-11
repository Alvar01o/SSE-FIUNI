<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Laboral;
class LaboralUser extends Pivot
{
    protected $table = 'laboral_user';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function getEmpresa()
    {
        return Laboral::find($this->laboral_id)->empresa;
    }
}
