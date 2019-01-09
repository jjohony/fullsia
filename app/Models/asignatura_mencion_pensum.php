<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asignatura_mencion_pensum extends Model
{
    protected $table="asignatura_mencion_pensum";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }
    public static function asignatura_mencion_pensum($where)
    {

        return \DB::select("SELECT * ,amp.id
                            FROM asignatura_mencion_pensum amp
                            inner join asignatura a on amp.id_asignatura =a.id
                            inner join mencion m on amp.id_mencion= m.id and a.id_carrera=m.id_carrera 
                            inner join pensum p on amp.id_pensum=p.id and m.id_carrera=p.id_carrera and a.id_carrera=p.id_carrera
                            where 1=1 
                            and amp.estado_asignatura_mencion_pensum='activo'
                            $where");
    }
    public static function asignatura_by_id_asignatura_mencion_pensum($id_asignatura_mencion_pensum,$where="")
    {

        return \DB::select("SELECT * ,amp.id
                            FROM asignatura_mencion_pensum amp
                            inner join asignatura a on amp.id_asignatura =a.id
                            where 1=1 
                            and amp.id='$id_asignatura_mencion_pensum'
                            and amp.estado_asignatura_mencion_pensum='activo'
                            $where");
    }

    

}
