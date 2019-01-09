<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    protected $table="nota_inscripcion";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }
    public static function notas($id_carrera,$id_curso,$where='')
    {
        return \DB::select("SELECT *,n.id
                    FROM nota_inscripcion n
                    inner join estudiante e on n.id_estudiante=e.id
                    WHERE n.id_curso='$id_curso'
                    and n.id_carrera='$id_carrera'
                    $where
                    ORDER BY e.paterno,e.materno,e.nombre");
    }

    public static function curso_by_id($id_curso)
    {
        return \DB::select("SELECT *,c.id id_curso,ca.tipo_gestion tipo_modalidad,g.gestion
                            from curso c 
                            inner join carrera ca on c.id_carrera=ca.id
                            inner join gestion g on c.id_gestion=g.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join mencion m on amp.id_mencion=m.id
                            inner join pensum p on amp.id_pensum=p.id
                            left join docente d on c.id_docente=d.id
                            where c.id='$id_curso'")[0];
    }
    
    
    

}
