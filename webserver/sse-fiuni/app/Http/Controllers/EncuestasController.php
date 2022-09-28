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
use App\Models\RespuestaPreguntas;
use App\Models\EncuestaUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class EncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tipo = 'egresado', Request $request)
    {
        if ($encuesta_id_duplicar = $request->get('duplicar')) {
            $encuesta = Encuestas::find($encuesta_id_duplicar);
            if ($encuesta) {
                DB::beginTransaction();
                try {
                    //duplicar encuesta
                    $nuevaEncuesta = $encuesta->replicate()->fill(['nombre' => $encuesta->nombre." - Copia ".date('d/m/Y')]);
                    $nuevaEncuesta->save();
                    //duplicar preguntas
                    foreach($encuesta->preguntas as $pregunta) {
                        $nueva_pregunta = $pregunta->replicate()->fill([
                            'encuesta_id' => $nuevaEncuesta->id
                        ]);
                        $nueva_pregunta->save();
                        //duplicar opciones
                        foreach($pregunta->opcionesPregunta as $opcion) {
                            $nueva_opcion_pregunta = $opcion->replicate()->fill(['pregunta_id' => $nueva_pregunta->id, 'encuesta_id' => $nuevaEncuesta->id]);
                            $nueva_opcion_pregunta->save();
                        }
                    }
                    DB::commit();
                } catch(\Exception $e) {
                    DB::rollBack();
                }
                return redirect('encuestas');
            }
        }
        $encuestas = Encuestas::where('tipo', '=', $tipo)->get();
        return view('encuestas.index', ['encuestas' => $encuestas, 'tipo' => $tipo]);
    }

    public function duplicar($id_pregunta){
        if (is_numeric($id_pregunta)) {
            $pregunta = Preguntas::find($id_pregunta);
            if ($pregunta) {
                $nueva_pregunta = $pregunta->replicate()->fill(['pregunta' => $pregunta->pregunta." - Copia"]);
                $nueva_pregunta->save();
                foreach($pregunta->opcionesPregunta as $opcion) {
                    $nueva_opcion_pregunta = $opcion->replicate()->fill(['pregunta_id' => $nueva_pregunta->id, 'encuesta_id' => $nueva_pregunta->encuesta_id]);
                    $nueva_opcion_pregunta->save();
                }
                return redirect('encuestas/'.$pregunta->encuesta_id);
            } else {
               return redirect('encuestas')->withErrors(['pregunta'=> 'Pregunta no existe.']);
            }
        } else {
            return redirect('encuestas')->withErrors(['pregunta'=> 'No se pudo encontrar la pregunta.']);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->only(['nombre']), [
            'nombre' => 'required|string'
        ]);
        if (!$validator->fails()) {
            $encuesta = Encuestas::find($id);
            if ($encuesta) {
                $encuesta->nombre = $request->input('nombre');
                $encuesta->save();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Encuesta Actualizada correctamente'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Error al encontrar la Encuesta'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Nombre de Encuesta invalido.'
            ]);
        }
    }

    public function guardarRespuestas($id, Request $request)
    {
        $encuesta = Encuestas::find($id);
        if ($this->getUser()->asignadoA($encuesta->id)) {
            $keys = array_keys($request->all());
            $ks = [];
            foreach($keys as $k) {
                if (is_numeric($k)) {
                    $ks[] = $k;
                }
            }

            $preguntas = Preguntas::where('encuesta_id', '=', $encuesta->id)->get();
            $respuestas = RespuestaPreguntas::where('encuesta_id', '=', $encuesta->id)->where('egresado_id', '=', $this->getUser()->id)->get();
            $parsed = [];
            foreach($respuestas as $resp) {
                $parsed[$resp->pregunta_id] = $resp;
            }
            foreach ($preguntas  as $pregunta) {
                if ($pregunta->tipo_pregunta == Preguntas::TIPO_PREGUNTA) {
                    if (!$request->input($pregunta->id)) {
                        continue;
                    }
                    $data = [
                        'pregunta_id' => $pregunta->id,
                        'encuesta_id' => $encuesta->id,
                        'egresado_id' => $this->getUser()->id,
                        'respuesta' => $request->input($pregunta->id) ? $request->input($pregunta->id) : '',
                        'opciones' => '[]'
                    ];
                    // error por aca al guardar - se duplica
                    if (isset($parsed[$pregunta->id])) {
                        $respuesta_existente = $parsed[$pregunta->id];
                        $respuesta_existente->update($data);
                    } else {
                        $respuesta_nueva = RespuestaPreguntas::create($data);
                    }
                } else {
                    $respuesta = $request->input($pregunta->id);
                    if ($respuesta) {
                        $justificacion = (isset($respuesta['justificacion']) && !is_null($respuesta['justificacion'])) ? $respuesta['justificacion'] : '';
                        if(array_key_exists('justificacion', $respuesta)) {
                            unset($respuesta['justificacion']);
                        }
                        if (!$justificacion && empty($respuesta)) {
                            continue;
                        }
                        $opciones = $respuesta;
                        if (!is_array($respuesta)) {
                            $opciones = [$respuesta];
                        }
                        $data = [
                            'pregunta_id' => $pregunta->id,
                            'encuesta_id' => $encuesta->id,
                            'egresado_id' => $this->getUser()->id,
                            'opciones' => json_encode($opciones),
                            'respuesta' => $justificacion  ?  $justificacion : ''
                        ];
                        if (isset($parsed[$pregunta->id])) {
                            $respuesta_existente = $parsed[$pregunta->id];
                            $respuesta_existente->update($data);
                        } else {
                            $respuesta_nueva = RespuestaPreguntas::create($data);
                        }
                    }
                }
            }
            return redirect('/encuestas/completar/'.$encuesta->id);
        } else {
            return view('error_permisos');
        }
    }

    public function completar($id, Request $request)
    {
        $encuesta = Encuestas::find($id);

        if ($this->getUser()->asignadoA($encuesta->id)) {
            return view('encuestas.completar', ['encuesta' => $encuesta, 'user' => $this->getUser()]);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|between:9,100',
            'tipo' => 'required|string|between:6,10'
        ], ['required' => 'Campo :attribute es requerido', 'string' => 'Nombre de la Encuesta en formato invalido.', 'between' => 'Longitud requerida entre 9-100 caracteres.']);
        if($validator->fails()) {
            return redirect('encuestas')
                        ->withErrors($validator);
        } else {
            $encuesta = Encuestas::create([
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
        $name = Route::currentRouteName(); // RouteName
        $encuesta = Encuestas::find($id);
        if (!$encuesta) {
            return redirect('/encuestas');
        }
        $users = [];
        $carreras = [];
        if ($this->getUser()->hasPermissionTo('Administrar Egresados')) {
            $users = [];
            if ($name == 'encuestas_empleador') {
                $users = User::role('empleador');
            } else {
                $users = User::role('egresado');
            }

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
        return view('encuestas.show', ['encuesta' => $encuesta, 'egresados' => $users, 'carreras' => $carreras, 'asignados' => $asignados, 'estado' => $encuesta->statusEgresados()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizarPregunta(Request $request, $id)
    {
        $validator = Validator::make($request->only(['pregunta']), [
            'pregunta' => 'required|string'
        ]);
        if (!$validator->fails()) {
            $pregunta = Preguntas::find($id);
            if ($pregunta) {
                $pregunta->pregunta = $request->input('pregunta');
                $pregunta->save();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Pregunta Actualizada correctamente'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Error al encontrar la pregunta'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Nombre de pregunta invalido.'
            ]);
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
        $encuesta = Encuestas::find($id);
        if ($encuesta) {
            $encuesta->delete();
            return response()->json([
                'status' => 'success',
                'msg' => 'Encuesta Eliminada Correctamente'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error al encontrar la encuesta'
            ]);
        }
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
       return view('encuestas.asignados', ['encuestas' => $encuestas ? $encuestas : [], 'user' => $this->getUser()]);
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

    public function eliminarPregunta($encuesta_id, $pregunta_id) {
        $encuesta = Encuestas::find($encuesta_id);
        if ($encuesta) {
            $pregunta = $encuesta->existPregunta($pregunta_id, true);
            if ($pregunta) {
                $pregunta->delete();
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Pregunta Eliminada Correctamente'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Error al encontrar la pregunta'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error al encontrar la encuesta'
            ]);
        }
    }

}
