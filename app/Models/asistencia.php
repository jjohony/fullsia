<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $table="asistencia";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }  
    

}
