<?php

namespace App\Http\Controllers;
use App\Models\Carreras;
use Illuminate\Http\Request;

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
        Carreras::create([
            'carrera' => $request->input('carrera')
        ]);
        return redirect()->intended('carreras');
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
        echo "asdasd";die;
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
                'id' => 'Esta Carrera Tienes usuarios asignados. '
            ]);
        } else { //si no, elimina la carrera
            if ($carrera) {
                $carrera->delete();
            }
            return redirect()->intended('carreras');
        }
    }
}
