<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cuota extends Model
{
    protected $table="cuota";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }

    public static function cuotas_by_carrera_and_estudiante($id_carrera,$id_estudiante)
    {
        return \DB::select("SELECT *
                            FROM cuota
                            where                                               
                            estado_cuota='activo'
                            and id_carrera='$id_carrera'
                            and id_estudiante='$id_estudiante'");
    }    
    
    

}
