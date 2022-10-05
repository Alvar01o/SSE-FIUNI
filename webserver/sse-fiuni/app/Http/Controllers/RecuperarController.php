<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class RecuperarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|between:7,100'
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.'
            ]);
            if ($validator->fails()) {
                return redirect('recuperar')
                        ->withErrors($validator)
                        ->withInput();
            } else {
                $user = User::where('email', '=', $request->input('email'))->first();
                $user->recuperar = true;
                $user->token_invitacion = base64_encode(bcrypt($user->email.$user->ci.time()));
                $user->save();
                return view('recuperar_envio', ['user' => $user]);
            }

        } else {
            return view('recuperar');
        }
    }
}
