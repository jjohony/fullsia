<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $table="nota_inscripcion";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }

    public static function asignatura_mencion_pensum($where="")
    {
        
        return \DB::select("SELECT * ,amp.id
                            FROM asignatura_mencion_pensum amp
                            inner join asignatura a on amp.id_asignatura =a.id
                            inner join mencion m on amp.id_mencion= m.id and a.id_carrera=m.id_carrera 
                            inner join pensum p on amp.id_pensum=p.id and m.id_carrera=p.id_carrera and a.id_carrera=p.id_carrera
                            where 1=1 
                            and amp.estado_asignatura_mencion_pensum='activo'
                            $where
                            ");
    }
    public static function notas_by_carrera_and_estudiante($id_carrera,$id_estudiante)
    {

        return \DB::select("SELECT *
                            from curso c
                            inner join nota_inscripcion n on c.id=n.id_curso
                            where n.id_carrera='$id_carrera' and n.id_estudiante='$id_estudiante'
                            and n.estado_nota='activo'
                            and (n.nota_final>60 or n.segundo_turno>51)");
    }

    public static function pre_requisito_by_id_p_amp($id_pre_requisito_asignatura_mencion_pensum)
    {

        return \DB::select("SELECT *
                            from pre_requisito
                            WHERE id_pre_requisito_asignatura_mencion_pensum='$id_pre_requisito_asignatura_mencion_pensum'");
    }
    public static function inscripcion($id_carrera,$id_estudiante,$id_gestion)
    {
        
        return \DB::select("SELECT * ,n.id
                            from nota_inscripcion n 
                            inner join curso c on n.id_curso=c.id 
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join mencion m on amp.id_mencion=m.id
                            inner join gestion g on c.id_gestion=g.id
                            WHERE n.id_carrera='$id_carrera'
                            and n.id_estudiante='$id_estudiante'
                            and c.id_gestion='$id_gestion'
                            and n.estado_nota='activo'");
    }
}
