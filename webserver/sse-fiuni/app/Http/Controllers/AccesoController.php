<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AccesoController extends Controller
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
            $usuario = User::where('token_invitacion', '=', $invitacion)->first();
            if ($usuario) {
                return view('acceso', ['user' => $usuario]);
            } else {
                return view('error_permisos');
            }
        } else {
            return view('error_permisos');
        }
    }
}
