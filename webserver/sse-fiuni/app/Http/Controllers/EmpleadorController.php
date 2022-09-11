<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Laboral;
class EmpleadorController extends Controller
{

    public function lista(Request $request)
    {
        if ($this->getUser()->hasPermissionTo('Administrar Empleador')) {
            $users = User::role('empleador');
            if ($request->input('name_email')) {
                $users->where('email', 'like', '%'.$request->input('name_email').'%');
                $users->orWhere('nombre', 'like', '%'.$request->input('name_email').'%');
                $users->orWhere('apellido', 'like', '%'.$request->input('name_email').'%');
            }

            $users->orderByDesc('id');
            $users = $users->paginate(30);
            return view('empleador.lista', ['empleadores' => $users]);
        } else {
            return view('error_permisos');
        }
    }

    public function json($query = null)
    {
        if ($this->getUser()->hasPermissionTo('Ver Empresas')) {
            $empresas = Laboral::whereRaw("lower(empresa) like '%".strtolower($query)."%'");
            $empresas = $empresas->get();
            return response()->json($empresas);
        } else {
            return view('error_permisos');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $password = null;
        if (is_null($request->input('password'))) {
            $validator = Validator::make($request->only(['nombre', 'apellido', 'ci', 'email', 'empresa']), [
                'nombre' => 'required|string|between:3,30',
                'apellido' => 'required|string|between:3,30',
                'email' => 'required|email|between:7,100|unique:App\Models\User,email',
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.',
                'unique' => 'Ya existe un usuario con :attribute = :input'
            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|between:3,30',
                'apellido' => 'required|string|between:3,30',
                'email' => 'required|email|between:7,100'
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.'
            ]);
        }


        if($validator->fails()) {
            return redirect('/empleador/lista')
                        ->withErrors($validator);
        } else {
            $usuario_nuevo = User::create([
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('email').time()),
                'token_invitacion' => base64_encode(bcrypt($request->input('email').time()))
            ]);
            $usuario_nuevo->assignRole(User::ROLE_EMPLEADOR);
            return redirect()->intended('/empleador/lista');
        }
    }

    public function edit($id)
    {
        $carreras = Carreras::get();
        $user = User::find($id);
        if ($user) {
            return view('egresado.perfil', ['carreras' => $carreras, 'user' => $user]);
        } else {
            return redirect('/empleadores/lista')
                        ->withErrors("Usuario no encontrado.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleador = User::find($id);
        if ($empleador) {
            $empleador->removeRole(User::ROLE_EMPLEADOR);
            $empleador->delete();
        }
        return redirect()->intended('/empleador/lista');
    }
}
