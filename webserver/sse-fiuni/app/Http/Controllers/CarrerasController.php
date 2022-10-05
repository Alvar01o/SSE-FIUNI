<?php

namespace App\Http\Controllers;
use App\Models\Carreras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CarrerasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras = Carreras::get();
        //obtener las carreras de la base de datos
        return view('carreras.index', ['carreras' => $carreras]);
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
            'carrera' => 'required|string|between:9,100'
        ], ['required' => 'Campo :attribute es requerido', 'string' => 'Nombre de la Carrera en formato invalido.', 'between' => 'Longitud requerida entre 9-100 caracteres.']);
        if($validator->fails()) {
            return redirect('carreras')
                        ->withErrors($validator);
        } else {
            Carreras::create([
                'carrera' => $request->input('carrera')
            ]);
            return redirect()->intended('carreras');
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
        $carrera = Carreras::find($id);
        $validator = Validator::make($request->all(), [
                'carrera' => 'required|string|between:9,100'
            ], ['required' => 'Campo :attribute es requerido', 'string' => 'Nombre de la Carrera en formato invalido.', 'between' => 'Longitud requerida entre 9-100 caracteres.']);
        if($validator->fails()) {
            return redirect('carreras')
                        ->withErrors($validator);
        }
        if ($carrera && !empty($request->input('carrera'))) {
            $carrera->carrera = $request->input('carrera');
            $carrera->save();
        }
        return redirect()->intended('carreras');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrera = Carreras::find($id);
        if ($carrera->tieneUsuarios()) { //verifica si existen usuarios
            return back()->withErrors([
                'mensaje' => 'Esta Carrera Tienes usuarios asignados. '
            ]);
        } else { //si no, elimina la carrera
            if ($carrera) {
                $carrera->delete();
            }
            return redirect()->intended('carreras');
        }
    }
}
