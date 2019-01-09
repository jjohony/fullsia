<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Admin\users;
use App\Models\log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public  $sql;
    public  $cadena="";
    public function log($descripcion,$tabla,$consulta,$datos)
    {
    	
    	$usuario=users::me();
    	$log=new log();
    	$log->log=$descripcion;
    	$log->tabla=$tabla;
    	$log->consulta=$consulta;
    	$log->datos=$datos;
    	$log->id_usuario=$usuario->id;
    	$log->id_persona=$usuario->id_persona;
    	$log->save();
    }

    public function capturar_accion()
    {
    	\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
            $this->cadena=json_encode($query->bindings);            
            $this->sql=$query->sql;     
                
        });
        

    }
}
