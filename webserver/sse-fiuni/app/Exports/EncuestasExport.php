<?php

namespace App\Exports;

use App\Models\Encuestas;
use App\Models\Preguntas;
use App\Models\RespuestaPreguntas;
use App\Models\OpcionesPregunta;
use App\Models\User;
use App\Models\Carreras;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class EncuestasExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public $_encuesta = [];
    public $_preguntas = [];
    public $_opciones = [];
    public $_carreras = [];
    public function __construct(int $encuesta_id, int $soloCompletados = 0)
    {
        $this->encuesta_id = $encuesta_id;
        $this->soloCompletados = $soloCompletados;
        $this->_carreras = Carreras::get();
    }

    public function getPreguntas(){
        return $this->_preguntas ? $this->_preguntas : $this->_preguntas = Preguntas::where('encuesta_id', '=', $this->encuesta_id)->get();
    }

    public function headings(): array
    {

        $preguntas = $this->getPreguntas();

        $return = [
            'Completado en Fecha',
            'Nombre Egresado',
            'Apellido Egresado',
            'Correo Electronico',
            'C.I.',
            'Carrera',
            'Año de Ingreso',
            'Año de Egreso',
        ];


        foreach ($preguntas as $key => $pregunta) {
            if ($pregunta->justificacion) {
                $return[] = $pregunta->pregunta;
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
        if ($this->soloCompletados) {
            if (!$respuestas) {
                return [];
            }
        }
        $alguna_respuesta = current($respuestas);
        $return = [
            ($alguna_respuesta) ? $alguna_respuesta->updated_at : '-',
            $data->nombre,
            $data->apellido,
            $data->email,
            $data->ci,
            $this->_carreras->find($data->carrera_id)->carrera,
            $data->ingreso,
            $data->egreso
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
                    if ($respuestas[$pregunta->id]->respuesta) {
                        $opciones_final[] = $respuestas[$pregunta->id]->respuesta;
                    }
                    $return[] = implode(',', $opciones_final);
                } else {
                    $return[] = $respuestas[$pregunta->id]->respuesta;
                }
            } else {
                $return[] = '';
            }
        }
        return $return;
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1    => ['font' => ['bold' => true]]
        ];

        return $styles;
    }


    public function query()
    {
        return Encuestas::select([
            'encuestas.id',  'encuestas.id as encuesta_id', 'encuestas.nombre','encuesta_users.user_id',
            'users.nombre as nombre', 'users.apellido as apellido', 'users.ci', 'users.email', 'users.ingreso', 'users.egreso', 'users.carrera_id'])
        ->join('encuesta_users', 'encuestas.id', '=', 'encuesta_users.encuesta_id')
        ->join('users', 'users.id', '=', 'encuesta_users.user_id')
        ->where('encuestas.id', '=', $this->encuesta_id);
    }

}
