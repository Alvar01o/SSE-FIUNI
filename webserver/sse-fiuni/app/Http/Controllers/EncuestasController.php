<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuestas;
use App\Models\Preguntas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\OpcionesPregunta;
use App\Models\User;
use App\Models\Carreras;
use App\Models\EncuestaUsers;
class EncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestas = Encuestas::get();
        return view('encuestas.index', ['encuestas' => $encuestas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|between:9,100',
            'tipo' => 'required|string|between:6,10'
        ], ['required' => 'Campo :attribute es requerido', 'string' => 'Nombre de la Encuesta en formato invalido.', 'between' => 'Longitud requerida entre 9-100 caracteres.']);
        if($validator->fails()) {
            return redirect('encuestas')
                        ->withErrors($validator);
        } else {
            Encuestas::create([
                'nombre' => $request->input('nombre'),
                'tipo' => $request->input('tipo')
            ]);
            return redirect()->intended('encuestas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $encuesta = Encuestas::find($id);
        if (!$encuesta) {
            return redirect('/encuestas');
        }
        $users = [];
        $carreras = [];
        if ($this->getUser()->hasPermissionTo('Administrar Egresados')) {
            $users = User::role('egresado');
            if ($request->input('carrera_id')) {
                $users->where('carrera_id', '=', $request->input('carrera_id'));
            }
            if ($request->input('name_email')) {
                $users->where('email', 'like', '%'.$request->input('name_email').'%');
                $users->orWhere('nombre', 'like', '%'.$request->input('name_email').'%');
                $users->orWhere('apellido', 'like', '%'.$request->input('name_email').'%');
            }
            $asignados = $encuesta->getUsuariosAsignados();
            $users = $users->paginate(30);
            $carreras = Carreras::get();
        }
        return view('encuestas.show', ['encuesta' => $encuesta, 'egresados' => $users, 'carreras' => $carreras, 'asignados' => $asignados]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
    public function addUsuarios(Request $request, $id)
    {
        $validator = Validator::make($request->only(['users']), [
            'users' => 'required|array'
        ]);
        $encuesta = Encuestas::find($id);
        //add validation
        if (!$validator->fails()) {
            $users = $request->input('users');
            //traer usuarios asignados a  la encuesta
            $usuarios = $encuesta->encuestaUsers();
            $usuarios_assignados = [];
            foreach($usuarios as $usuario) {
                $usuarios_assignados[$usuario->user_id] = $usuario;
            }
            $agregar_usuarios = [];
            foreach ($users as $key => $value) {
                // si existe en encuesta pasar
                if (!\array_key_exists($value, $usuarios_assignados)) {
                    $agregar_usuarios[] = ['user_id' => $value, 'encuesta_id' => $encuesta->id, 'created_at' => date('Y-m-d H:i:s', time()), 'updated_at' => date('Y-m-d H:i:s', time())];
                }
            }
            EncuestaUsers::insert($agregar_usuarios);
            return redirect("/encuestas/{$id}?seccion=asignados");
        } else {
            return redirect("/encuestas/{$id}")
                ->withErrors($validator);
        }
    }

    public function asignados() {
        $user = $this->getUser();
        $encuestas = Encuestas::join('encuesta_users', 'encuestas.id', '=', 'encuesta_users.encuesta_id')->where('encuesta_users.user_id', '=', $user->id)->get();
       return view('encuestas.asignados', ['encuestas' => $encuestas ? $encuestas : []]);
    }

    public function addPregunta(Request $request)
    {
        $validator = Validator::make($request->only(['pregunta', 'tipo_pregunta', 'encuesta_id', 'requerido']), [
            'pregunta' => 'required|string',
            'tipo_pregunta' => [
                    'required',
                    Rule::in(['seleccion_justificacion', 'seleccion', 'seleccion_multiple_justificacion', 'seleccion_multiple', 'pregunta']),
            ],
            'encuesta_id' => 'required|integer'
        ]);
        $pregunta = NULL;
        if ($validator->fails()) {
            return redirect("/encuestas/{$request->input('encuesta_id')}")
                        ->withErrors($validator);
        } else {
            if ($request->input('tipo_pregunta') !== 'pregunta') {
                $validadorOpciones = Validator::make($request->only(['opcion']),
                    [
                        'opcion' => 'array',
                        'justificacion' => 'sometimes|required|array'
                    ]);
                if ($validadorOpciones->fails()) {
                    return redirect("/encuestas/{$request->input('encuesta_id')}")
                                ->withErrors($validadorOpciones);
                } else {
                    $justificacion = false;
                    $opciones = $request->input('opcion');
                    if ($request->has('justificacion')) {
                        $justificacion = true;
                    }
                    $datos_para_nueva_pregunta = [
                        'pregunta' => $request->input('pregunta'),
                        'tipo_pregunta' => $request->input('tipo_pregunta'),
                        'encuesta_id' => $request->input('encuesta_id'),
                        'requerido' => $request->input('requerido') == 'on' ? 1 : 0
                    ];
                    if ($justificacion) {
                        $datos_para_nueva_pregunta['justificacion'] = true;
                    }
                    $pregunta = Preguntas::create($datos_para_nueva_pregunta);
                    foreach($opciones as $key => $opcion) {
                        OpcionesPregunta::create([
                            'pregunta_id' => $pregunta->id,
                            'encuesta_id' => $pregunta->encuesta_id,
                            'opcion' => $opcion
                        ]);
                    }
                    return redirect()->intended("/encuestas/{$pregunta->encuesta_id}");
                }
            } else {
                $pregunta = Preguntas::create([
                    'pregunta' => $request->input('pregunta'),
                    'tipo_pregunta' => $request->input('tipo_pregunta'),
                    'encuesta_id' => $request->input('encuesta_id'),
                    'requerido' => $request->input('requerido') == 'on' ? 1 : 0
                ]);
                return redirect()->intended("/encuestas/{$pregunta->encuesta_id}");
            }

        }
    }
}
