<?php

namespace App\Exports;

use App\Models\Encuestas;
use App\Models\Preguntas;
use App\Models\RespuestaPreguntas;
use App\Models\OpcionesPregunta;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EncuestasExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    public $_encuesta = [];
    public $_preguntas = [];
    public $_opciones = [];
    public function __construct(int $encuesta_id)
    {
        $this->encuesta_id = $encuesta_id;
    }

    public function getPreguntas(){
        return $this->_preguntas ? $this->_preguntas : $this->_preguntas = Preguntas::where('encuesta_id', '=', $this->encuesta_id)->get();
    }

    public function headings(): array
    {
        $preguntas = $this->getPreguntas();
        $return = [
            'id_usuario',
            'Nombre Egresado',
            'Apellido Egresado',
        ];
        foreach ($preguntas as $key => $pregunta) {
            if ($pregunta->justificacion) {
                $return[] = $pregunta->pregunta;
                $return[] = $pregunta->pregunta." - justificacion";
            } else {
                $return[] = $pregunta->pregunta;
            }

        }
        return $return;
    }

    public function getOpciones() {
        return $this->_opciones ? $this->_opciones : $this->_opciones = OpcionesPregunta::where('encuesta_id', '=', $this->encuesta_id)->get();
    }

    public function map($data): array
    {
        $respuestas = $data->respuestasById($data->user_id);
        $preguntas = $this->getPreguntas();
        $return = [
            $data->user_id,
            $data->nombre,
            $data->apellido,
        ];
        $opciones = $this->getOpciones();
        foreach($preguntas as $pregunta) {
            if (array_key_exists($pregunta->id, $respuestas)) {
                if ($pregunta->justificacion || in_array($pregunta->tipo_pregunta, ['seleccion_multiple', 'seleccion_multiple_justificacion', 'seleccion', 'seleccion_justificacion'])) {
                    $opciones_seleccionadas = json_decode($respuestas[$pregunta->id]->opciones);
                    $opciones_final = [];
                    foreach ($opciones_seleccionadas as $key => $value) {
                        $opciones_final[] = $opciones->find($value)->opcion;
                    }
                    $return[] = implode(',', $opciones_final);
                    $return[] = $respuestas[$pregunta->id]->respuesta;
                } else {
                    $return[] = $respuestas[$pregunta->id]->respuesta;
                }
            } else {
                $return[] = '';
            }
        }
        return $return;
    }

    public function query()
    {
        return Encuestas::select(['encuestas.id', 'encuesta_users.user_id','users.nombre as nombre', 'users.apellido as apellido', 'encuestas.id as encuesta_id', 'encuestas.nombre'])
        ->join('encuesta_users', 'encuestas.id', '=', 'encuesta_users.encuesta_id')
        ->join('users', 'users.id', '=', 'encuesta_users.user_id')
        ->where('encuestas.id', '=', $this->encuesta_id);
    }

}
