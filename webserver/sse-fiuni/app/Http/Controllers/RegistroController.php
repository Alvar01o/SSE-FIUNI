<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Carreras;
class RegistroController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($user = $this->getUser()) {
                if ($user->hasRole(User::ROLE_ADMINISTRADOR)) {
                    return redirect()->intended('admin');
                }
                if ($user->hasRole(User::ROLE_EGRESADO)) {
                    return redirect()->intended('egresado');
                }
                if ($user->hasRole(User::ROLE_EMPLEADOR)) {
                    return redirect()->intended('empleador');
                }
            } else {
                $carreras = Carreras::get();
                return view('registro', ['carreras' => $carreras]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => ['required', 'confirmed'],
                'name' => ['required']
            ], ['email' => 'Correo Invalido', 'required' => 'Campo :attribute es requerido', 'confirmed' => 'Confirmacion de contraseña no coincide']);

            if ($validator->fails()) {
                return redirect('/registro')
                        ->withErrors($validator)
                        ->withInput();
            } else {
                $datos_usuario = $validator->validate();
                $user = User::create([
                    'name' => $datos_usuario['name'],
                    'email' => $datos_usuario['email'],
                    'password' => bcrypt($datos_usuario['password'])
                ]);
                $user->assignRole(User::ROLE_EGRESADO);
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    $user = Auth::user();
                    if ($user->hasRole(User::ROLE_EGRESADO)) {
                        return redirect()->intended('egresado');
                    }
                    return redirect()->intended('egresado');
                }
            }
        }
        return back()->withErrors([
            'email' => 'Credenciales no autorizadas.'
        ]);
    }
}
