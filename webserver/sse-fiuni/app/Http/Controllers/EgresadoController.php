<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carreras;
use Illuminate\Support\Facades\Validator;
class EgresadoController extends Controller
{

    public function lista()
    {
        if ($this->getUser()->hasPermissionTo('Administrar Egresados')) {
            $users = User::role('egresado')->paginate(25);
            $carreras = Carreras::get();
            return view('egresado.lista', ['egresados' => $users, 'carreras' => $carreras]);
        } else {
            return view('error_permisos');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('egresado.index', [
            1, 2, 3
        ]);
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
                'carrera_id' => 'exists:App\Models\Carreras,id',
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
                'email' => 'required|email|between:7,100',
                'carrera_id' => 'exists:App\Models\Carreras,id',
                'password' => 'required|confirmed|min:8'
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.'
            ]);
            $password = $request->input('password');
        }


        if($validator->fails()) {
            return redirect('/egresado/lista')
                        ->withErrors($validator);
        } else {
            $usuario_nuevo = User::create([
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'ci' => $request->input('ci'),
                'email' => $request->input('email'),
                'token_invitacion' => base64_encode(bcrypt($request->input('email').time())),
                'carrera_id' => $request->input('carrera_id'),
                'password' => bcrypt($password),
            ]);
            $usuario_nuevo->assignRole(User::ROLE_EGRESADO);
            return redirect()->intended('/egresado/lista');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $egresado = User::find($id);
        return view('egresado.show', ['user' => $egresado]);
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
            return view('egresado.editar', ['carreras' => $carreras, 'user' => $user]);
        } else {
            return redirect('/egresado/lista')
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
        $egresado = User::find($id);
        if ($egresado) {
            $egresado->removeRole(User::ROLE_EGRESADO);
            $egresado->delete();
        }
        return redirect()->intended('/egresado/lista');
    }

    public function perfil($id = null){
        if (!$id) {
            $id  = $this->getUser()->id;
        }
        $egresado = User::find($id);
        return view('egresado.show', ['user' => $egresado]);
    }

    public function editar_perfil($id = null){
        if (!$id) {
            $id  = $this->getUser()->id;
        }
        $egresado = User::find($id);
        return view('egresado.perfil', ['user' => $egresado]);
    }
}
