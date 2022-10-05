<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class EstablecerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'confirmed', 'min:8'],
            ], ['required' => 'Campo :attribute es requerido', 'confirmed' => 'Confirmacion de contraseña no coincide', 'min' => 'Longitud del campo :attribute debe ser de un minimo de :min caracteres.' ]);
            if ($validator->fails()) {
                return redirect('/acceso?invitacion='.$usuario->token_invitacion)
                        ->withErrors($validator)
                        ->withInput();
            } else {
                if ($usuario->token_invitacion) {
                    $usuario->password = bcrypt($request->input('password'));
                    $usuario->confirmado = 1;
                    $usuario->token_invitacion = '';
                    $usuario->save();
                    return redirect('/');
                } else {
                    return view('error_permisos');
                }
            }
        } else {
            return view('error_permisos');
        }
    }
}
