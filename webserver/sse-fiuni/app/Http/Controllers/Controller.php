<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Funcion para obtener usuario logeado
     *
     */
    public function __construct()
    {
        if (!$this->getUser()) {
            return redirect('/');
        }
    }
    public function getUser()
    {
        $user = Auth::user();
//        if (is_null($user)) {
//            return redirect('/');
//        } else {
            return $user;
//        }

    }

}
