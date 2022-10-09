<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Laboral;
use App\Models\Educacion;
use App\Models\DatosPersonales;
use App\Models\LaboralUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class EgresadoController extends Controller
{

    public function lista(Request $request)
    {
        if ($this->getUser()->hasPermissionTo('Administrar Egresados')) {
            $users = User::role('egresado')->orderByDesc('created_at');
            if ($request->input('carrera_id')) {
                $users->where('carrera_id', '=', $request->input('carrera_id'));
            }
            if ($request->input('name_email')) {
                $users->where(function($query) use ($request) {
                    $query->where('email', 'like', '%'.$request->input('name_email').'%')
                    ->orWhere('nombre', 'like', '%'.$request->input('name_email').'%')
                    ->orWhere('apellido', 'like', '%'.$request->input('name_email').'%');
                });
            }
            $users = $users->paginate(30);
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
        return view('egresado.index', ['user' => $this->getUser()]);
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
                'ingreso' => $request->input('ingreso'),
                'egreso' => $request->input('egreso'),
                'token_invitacion' => base64_encode(bcrypt($request->input('email').$request->input('ci').time())),
                'carrera_id' => $request->input('carrera_id'),
                'password' => bcrypt($password)
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
        if (!$egresado) {
            return redirect('/');
        }
        $usuario_logeado = $this->getUser();
        if ($usuario_logeado->id !== $egresado->id && !$usuario_logeado->hasRole(User::ROLE_ADMINISTRADOR))
        {
            $egresado = $usuario_logeado;
        }
        $laboral = $egresado->getEmpleos();
        $educacion = $egresado->educacion;
        $resumenHistorial = [];
        foreach($laboral as $trabajo) {
            $resumenHistorial[date('Y-m', strtotime($trabajo->inicio))][] = $trabajo;
        }
        foreach($educacion as $capacitacion) {
            $resumenHistorial[date('Y-m', strtotime($capacitacion->inicio))][] = $capacitacion;
        }
        ksort($resumenHistorial);
        return view('egresado.show', ['user' => $egresado, 'usuario_logeado' => $this->getUser(), 'historial' => $resumenHistorial]);
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
        if (intval($id) !== $this->getUser()->id && !$this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        } else {
            $user = User::find($id);
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|between:3,50',
                'apellido' => 'required|string|between:3,50',
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
        return redirect()->intended('/egresado/lista');
    }

    public function perfil($id = null){
        if (!$id) {
            $id  = $this->getUser()->id;
        }
        $egresado = User::find($id);
        if (!$egresado) {
            return redirect('/');
        }
        $laboral = $egresado->getEmpleos();
        $educacion = $egresado->educacion;
        $resumenHistorial = [];
        foreach($laboral as $trabajo) {
            $resumenHistorial[date('Y-m', strtotime($trabajo->inicio))][] = $trabajo;
        }
        foreach($educacion as $capacitacion) {
            $resumenHistorial[date('Y-m', strtotime($capacitacion->inicio))][] = $capacitacion;
        }
        ksort($resumenHistorial);
        return view('egresado.show', ['user' => $egresado, 'usuario_logeado' => $this->getUser(), 'historial' => $resumenHistorial]);
    }

    public function editar_perfil($id = null){
        if (!$id) {
            $id  = $this->getUser()->id;
        }
        $empresas = Laboral::get();
        $carreras = Carreras::get();
        $egresado = User::find($id);
        return view('egresado.perfil', ['user' => $egresado, 'carreras' => $carreras, 'empresas' => $empresas]);
    }

    public function new_pass(Request $request, $id = null) {
        $userlogued = $this->getUser();
        $user = User::find($id);
        if ($user->id != $userlogued->id && $userlogued->hasRole(User::ROLE_ADMINISTRADOR) || $user->id == $userlogued->id){
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'confirmed'],
            ], ['required' => 'Campo :attribute es requerido', 'confirmed' => 'Confirmacion de contraseña no coincide']);
            if ($validator->fails()) {
                return back()->withErrors([
                    'password' => 'Error en la validacion de contraseña.1'
                ]);
            } else {
                //SI ES ADMIN - CAMBIAR DIRECTAMETE
                if($this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
                    $user->password = bcrypt($request->input('password'));
                    $user->save();
                    return back();
                } else {
                    if (Hash::check($request->input('old_password'), $user->password)) {
                        $user->password = bcrypt($request->input('password'));
                        $user->save();
                        return back();
                    } else {
                        return back()->withErrors([
                            'password' => 'Error en la validacion de contraseña.'
                        ]);
                    }
                }
            }
        } else {
            return back()->withErrors([
                'password' => 'Error en la validacion de contraseña.'
            ]);
        }
    }

    public function add_educacion(Request $request, $id = null) {
        if (is_null($id)) {
            $id = $this->getUser()->id;
        }
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'institucion' => 'required|string|between:2,250',
            'titulo' => 'required|string|between:2,250',
            'inicio' => ['required']
        ], [
            'required' => 'Campo :attribute es requerido',
            'string' => 'Nombre de la Carrera en formato invalido.',
            'between' => 'Longitud del campo :attribute debe ser entre :min - :max caracteres.'
        ]);

        if (!$validator->fails()) {
            $nueva_certificacion = Educacion::create([
                'institucion' => $request->input('institucion'),
                'titulo' => $request->input('titulo'),
                'inicio' => $request->input('inicio'),
                'fin' => $request->input('fin'),
                'user_id' => $id,
            ]);
            return back();
        } else {
            return back()->withErrors($validator);
        }
    }

    public function elimiar_educacion($id = null)
    {
        if ($id) {
            if ($this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
                $lbuser = Educacion::where('id', '=', $id);
                $lbuser->delete();
            } else {
                $lbuser = Educacion::where('id', '=', $id);
                $lbuser->where('user_id', '=', $this->getUser()->id);
                $lbuser->delete();
            }
        }
        return back();
    }

    public function elimiar_dato_laboral($id = null)
    {
        if ($id) {
            if ($this->getUser()->hasRole(User::ROLE_ADMINISTRADOR)) {
                $lbuser = LaboralUser::where('id', '=', $id);
                $lbuser->delete();
            } else {
                $lbuser = LaboralUser::where('id', '=', $id);
                $lbuser->where('user_id', '=', $this->getUser()->id);
                $lbuser->delete();
            }
        }
        return back();
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
                return back();
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
