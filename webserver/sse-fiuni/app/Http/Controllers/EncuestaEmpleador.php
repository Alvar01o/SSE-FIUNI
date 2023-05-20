<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Encuestas;
use App\Http\Controllers\EncuestasController;
use App\Models\Preguntas;
use App\Models\RespuestaPreguntas;

class EncuestaEmpleador extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $invitacion = $request->input('invitacion');
        if ($invitacion) {
            $usuario = User::role(User::ROLE_EMPLEADOR)->select('users.*', 'encuesta_users.encuesta_id')->join('encuesta_users', 'encuesta_users.user_id', '=', 'users.id')->where('encuesta_users.invitacion_empleadores', '=', $invitacion)->first();
            $encuesta = Encuestas::find($usuario->encuesta_id)->first();
            if ($usuario) {
                if ($request->isMethod('post')) {
                    if ($usuario->asignadoA($encuesta->id)) {
                        $keys = array_keys($request->all());
                        $ks = [];
                        foreach($keys as $k) {
                            if (is_numeric($k)) {
                                $ks[] = $k;
                            }
                        }

                        $preguntas = Preguntas::where('encuesta_id', '=', $encuesta->id)->get();
                        $respuestas = RespuestaPreguntas::where('encuesta_id', '=', $encuesta->id)->where('egresado_id', '=', $usuario->id)->get();
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
                                    'egresado_id' => $usuario->id,
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
                                        'egresado_id' => $usuario->id,
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
                        // si esta completo redireccionar a mensaje
                        $status = $encuesta->status($usuario, $encuesta->id);
                        if ($status['porcentaje'] == 100) {
                            return redirect()->route('encuesta_empleador', ['invitacion' => $invitacion]);
                        }
                        return redirect()->route('encuesta_empleador', ['invitacion' => $invitacion]);
                    } else {
                        return view('error_permisos');
                    }
                }
                return view('encuestas.encuesta_empleador', ['user' => $usuario, 'encuesta' => $encuesta, 'invitacion' => $invitacion]);
            } else {
                return view('error_permisos');
            }
        } else {
            return view('error_permisos');
        }
    }
}
