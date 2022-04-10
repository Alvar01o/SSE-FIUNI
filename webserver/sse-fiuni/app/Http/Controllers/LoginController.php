<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->hasRole(User::ROLE_ADMINISTRADOR)) {
                return redirect()->intended('admin');
            }
            if ($user->hasRole(User::ROLE_ADMINISTRADOR)) {
                return redirect()->intended('egresado');
            }
            if ($user->hasRole(User::ROLE_ADMINISTRADOR)) {
                return redirect()->intended('empleador');
            }
        }

        return back()->withErrors([
            'email' => 'Credenciales no autorizadas.'
        ]);
    }
}
