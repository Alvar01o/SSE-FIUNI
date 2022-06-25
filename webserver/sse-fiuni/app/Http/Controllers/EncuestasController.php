<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuestas;
use Illuminate\Support\Facades\Validator;

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
    public function show($id)
    {
        $encuesta = Encuestas::find($id);
        return view('encuestas.show', ['encuesta' => $encuesta]);
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
