<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Encuestas;
class EncuestaEmpleador extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $invitacion = $request->input('invitacion');
        if ($invitacion) {
            $usuario = User::role(User::ROLE_EMPLEADOR)->join('encuesta_users', 'encuesta_users.user_id', '=', 'users.id')->where('encuesta_users.invitacion_empleadores', '=', $invitacion)->first();
            $encuesta = Encuestas::find($usuario->encuesta_id);
            if ($usuario) {
                return view('encuestas.encuesta_empleador', ['user' => $usuario, 'encuesta' => $encuesta]);
            } else {
                return view('error_permisos');
            }
        } else {
            return view('error_permisos');
        }
    }
}
