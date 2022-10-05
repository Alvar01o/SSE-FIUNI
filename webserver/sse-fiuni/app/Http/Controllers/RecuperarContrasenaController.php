<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class RecuperarContrasenaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $solicitud = $request->input('solicitud');
        if ($solicitud) {
            $usuario = User::where('token_invitacion', '=', $solicitud)->first();
            if ($usuario) {
                return view('recuperar_contrasena', ['user' => $usuario]);
            } else {
                return view('error_permisos');
            }
        } else {
            return view('error_permisos');
        }
    }
}
