<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Encuestas;
use App\Exports\EncuestasExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getUser();
        if (!$user->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        } else {
            $encuestas_egresados = Encuestas::where('tipo', '=', 'egresado')->get();
            $encuestas_empleador = Encuestas::where('tipo', '=', 'empleador')->get();
            return view('reportes.index', ['encuesta_egresados' => $encuestas_egresados, 'encuestas_empleador' => $encuestas_empleador]);
        }
    }

    public function encuesta($id, Request $request) {
        $user = $this->getUser();
        if (!$user->hasRole(User::ROLE_ADMINISTRADOR)) {
            return view('error_permisos');
        } else {
            $encuesta = Encuestas::find($id);
            return view('reportes.encuesta', ['encuesta'=> $encuesta]);
        }
    }


    public function reporte_pregutna($id, Request $request) {
        $pregunta = Preguntas::find($id);
        if ($pregunta) {
            $todas_las_respuestas = RespuestaPreguntas::where('pregunta_id', '=', $id)->where('encuesta_id', '=', $pregunta->encuesta_id)->get();
            $data = [];
            if ($pregunta->tipo_pregunta == '' ) {

            }

            foreach($todas_las_respuestas as $respuesta) {

            }

            return response()->json([
                'status' => 'success',
                'msg' => 'Encuesta Actualizada correctamente'
            ]);
        } else {
            //error
        }
    }

    public function reporte_encuesta($id, Request $request) {
        $encuesta = Encuestas::find($id);
        return (new EncuestasExport($id))->download($encuesta->nombre.' - '.date('d-m-Y:h').'.xlsx');
    }

    public function reporte_encuestas_completas($id, Request $request) {
        $encuesta = Encuestas::find($id);
        return (new EncuestasExport($id, 1))->download($encuesta->nombre.' - '.date('d-m-Y:h').'.xlsx');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
