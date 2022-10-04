<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecuperarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('post')) {
            var_dump($request);die;
        } else {
            return view('recuperar');
        }
    }
}
