<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertar_tabla(/*Request $request,*/$nombre_tabla)
    {
        $tabla= (object) array();
        $tabla->nombre_carrera="hola";
        var_dump($tabla->nombre_carrera);
    }
}
