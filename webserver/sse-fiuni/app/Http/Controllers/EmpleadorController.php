<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Laboral;
class EmpleadorController extends Controller
{

    public function lista()
    {
        if ($this->getUser()->hasPermissionTo('Administrar Empleador')) {
            $users = User::role('empleador')->paginate(15);
            return view('empleador.lista', ['empleadores' => $users]);
        } else {
            return view('error_permisos');
        }
    }

    public function json($query = null)
    {
        if ($this->getUser()->hasPermissionTo('Ver Empresas')) {
            $empresas = Laboral::whereRaw("lower(empresa) like '%".strtolower($query)."%'");
            $empresas = $empresas->get();
            return response()->json($empresas);
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
        return view('empleador.index', [
            1, 2, 3
        ]);
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
