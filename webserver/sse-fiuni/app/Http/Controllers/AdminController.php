<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Encuestas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        }
        $carreras = Carreras::all();
        $encuestas = Encuestas::where('tipo', '=', 'egresado')->limit(5)->get();
        return view('admin.index', ['carreras' => $carreras, 'user' => $this->getUser(), 'total_users' => User::role('egresado')->count(), 'encuestas' => $encuestas]);
    }

    public function lista(Request $request)
    {
        if ($this->getUser()->hasPermissionTo('Administrar Administradores')) {
            $users = User::role(User::ROLE_ADMINISTRADOR);
            if ($request->input('name_email')) {
                $users->where(function($query) use ($request) {
                    $query->where('email', 'like', '%'.$request->input('name_email').'%')
                    ->orWhere('nombre', 'like', '%'.$request->input('name_email').'%')
                    ->orWhere('apellido', 'like', '%'.$request->input('name_email').'%');
                });
            }
            $users->orderByDesc('id');
            $users = $users->paginate(30);
            return view('admin.lista', ['administradores' => $users]);
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
            $validator = Validator::make($request->only(['nombre', 'apellido', 'ci', 'email', 'carrera_id']), [
                'nombre' => 'required|string|between:3,30',
                'apellido' => 'required|string|between:3,30',
                'ci' => 'required|numeric|min:500000|max:3000000000|unique:App\Models\User,ci',
                'email' => 'required|email|between:7,100|unique:App\Models\User,email',
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.',
                'unique' => 'Ya existe un usuario con :attribute = :input'
            ]);
            $password = $request->input('email').time();
        } else {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|between:3,30',
                'apellido' => 'required|string|between:3,30',
                'ci' => 'required|numeric|min:500000|max:3000000000|unique:App\Models\User,ci',
                'email' => 'required|email|between:7,100'
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.'
            ]);
            $password = $request->input('password');
        }


        if($validator->fails()) {
            return redirect('/admin/lista')
                        ->withErrors($validator);
        } else {
            $usuario_nuevo = User::create([
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'ci' => $request->input('ci'),
                'email' => $request->input('email'),
                'token_invitacion' => base64_encode(bcrypt($request->input('email').time())),
                'password' => bcrypt($password)
            ]);
            $usuario_nuevo->assignRole(User::ROLE_ADMINISTRADOR);
            return redirect()->intended('/admin/lista');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carreras = Carreras::get();
        $user = User::find($id);
        if ($user) {
            return view('egresado.perfil', ['carreras' => $carreras, 'user' => $user]);
        } else {
            return redirect('/admin/lista')
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
        $admin = User::find($id);
        if ($admin->hasRole(User::ROLE_ADMINISTRADOR)) {
            $admin->removeRole(User::ROLE_ADMINISTRADOR);
            $admin->delete();
        } else {
            return view('error_permisos');
        }
        return redirect()->intended('/admin/lista');
    }
}
