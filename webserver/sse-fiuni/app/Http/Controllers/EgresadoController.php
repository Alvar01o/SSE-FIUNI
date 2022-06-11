<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Laboral;
use App\Models\DatosPersonales;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class EgresadoController extends Controller
{

    public function lista()
    {
        if ($this->getUser()->hasPermissionTo('Administrar Egresados')) {
            $users = User::role('egresado')->paginate(95);
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
            return view('egresado.perfil', ['carreras' => $carreras, 'user' => $user]);
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
        if ($id !== $this->getUser()->id && !$this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        } else {
            $user = User::find($id);
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|between:3,30',
                'apellido' => 'required|string|between:3,30',
                'ci' => ['required', 'numeric', 'min:500000', 'max:3000000000', Rule::unique('users')->ignore($user->id)], //'required|numeric|min:500000|max:3000000000|unique:App\Models\User,ci',
                'email' => 'required|email|between:7,100',
                'carrera_id' => 'sometimes|exists:App\Models\Carreras,id',
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.',
                'exists' => 'No se encontro la carrera seleccionada.'
            ]);
            if ($user && !$validator->fails()) {
                $user->nombre = $request->input('nombre');
                $user->apellido = $request->input('apellido');
                $user->email = $request->input('email');
                $user->ci = $request->input('ci');
                if ($request->input('carrera_id')) {
                    $user->carrera_id = $request->input('carrera_id');
                }
                $user->save();
                //validacion de datos personales
                $validator_datos_personales = Validator::make($request->all(), [
                    'telefono' => 'required|string|between:3,30',
                    'direccion' => 'required|string|between:3,300'
                ], [
                    'required' => 'Campo :attribute es requerido',
                    'string' => 'Nombre de la Carrera en formato invalido.',
                    'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.'
                ]);
                if (!$validator_datos_personales->fails()) {
                    $datosp = DatosPersonales::create(['telefono' => $request->input('telefono'), 'direccion' => $request->input('direccion'), 'user_id' => $user->id]);
                }
                return back()->withErrors($validator_datos_personales);
            } else {
                return back()->withErrors($validator);
            }
        }
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
        return redirect()->intended('/egresa\do/lista');
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

    public function add_laboral(Request $request, $id = null) {
        if (is_null($id)) {
            $id = $this->getUser()->id;
        }
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'empresa' => 'required|string|between:2,100',
            'cargo' => 'required|string|between:2,100',
            'inicio' => ['required']
        ], [
            'required' => 'Campo :attribute es requerido',
            'string' => 'Nombre de la Carrera en formato invalido.',
            'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.'
        ]);

        if (!$validator->fails()) {
            $validacion_empleador = Validator::make($request->all(), [
                'nombre' => 'required|string|between:2,100',
                'apellido' => 'required|string|between:2,100',
                'email' => 'required|email|between:7,100'
            ], [
                'required' => 'Campo :attribute es requerido',
                'string' => 'Nombre de la Carrera en formato invalido.',
                'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.'
            ]);
            $laboralUser = $user->addCargoLaboral($request->input('empresa'), $request->input('cargo'), $request->input('inicio'), $request->input('fin'));
            if (!$validacion_empleador->fails()) {
                $user = User::whereRaw('LOWER(`email`) = ?', strtolower($request->input('email')))->first();
                if (!$user) {
                    $user = User::create(['nombre' => $request->input('nombre'), 'apellido' => $request->input('apellido'), 'email' => $request->input('email'), 'password' => bcrypt($request->input('email').time())]);
                }
               $user->assignRole(User::ROLE_EMPLEADOR);
               $user->addComoEmpleador($laboralUser->laboral_id);
               return back();
            } else {
                return back()->withErrors($validacion_empleador);
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    public function get_avatar(Request $request, $id = null)
    {
        $type = 'perfil';
        $filepath = '/var/www/html/webserver/public/img/avatar.png';
        if (is_null($id)) {
            $avatar_collection = $this->getUser()->getFirstMedia('avatars');
            if (is_null($avatar_collection)) {
                $data = base64_encode(file_get_contents($filepath));
                header("Content-Type: image/jpeg");
                header("Content-Length: " . filesize($filepath));
                readfile($filepath);
            } else {
                return $avatar_collection->toInlineResponse($request);
            }
        } else {
            if ($this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
                $user = User::find($id);
                $avatar_collection = $user->getFirstMedia('avatars');

                if (is_null($avatar_collection)) {
                    $data = base64_encode(file_get_contents($filepath));
                    header("Content-Type: image/jpeg");
                    header("Content-Length: " . filesize($filepath));
                    readfile($filepath);
                    //no tiene avatar
                } else {
                    return $avatar_collection->toInlineResponse($request);
                }
            } else {
                $avatar_collection = $this->getUser()->getFirstMedia('avatars');
                if (is_null($avatar_collection)) {
                    $data = base64_encode(file_get_contents($filepath));
                    header("Content-Type: image/jpeg");
                    header("Content-Length: " . filesize($filepath));
                    readfile($filepath);
                    //no tiene avatar
                } else {
                    return $avatar_collection->toInlineResponse($request);
                }
            }
        }
    }
}
