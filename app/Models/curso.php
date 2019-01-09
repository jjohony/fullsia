<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\users;
class curso extends Model
{
    protected $table="curso";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }
    public static function cursos($id_carrera,$limit=20)
    {
        return \DB::select("SELECT * , c.id
                from curso c 
                inner join gestion g on g.id=c.id_gestion  
                inner join asignatura_mencion_pensum amp on amp.id=c.id_asignatura_mencion_pensum 
                inner join mencion m on m.id=amp.id_mencion 
                inner join pensum p on p.id=amp.id_pensum
                inner join asignatura a on a.id=amp.id_asignatura 
                where c.id_carrera='$id_carrera'
                and c.estado_curso='activo'
                order by g.gestion desc,g.periodo_gestion desc 
                    limit $limit");
    }

    public static function curso($id_carrera,$id_curso)
    {
        return \DB::select("SELECT * , c.id
                from curso c 
                inner join gestion g on g.id=c.id_gestion  
                inner join asignatura_mencion_pensum amp on amp.id=c.id_asignatura_mencion_pensum 
                inner join mencion m on m.id=amp.id_mencion 
                inner join pensum p on p.id=amp.id_pensum
                inner join asignatura a on a.id=amp.id_asignatura 
                left join docente d on c.id_docente=d.id
                where c.id_carrera='$id_carrera'
                and c.id='$id_curso'
                ")[0];
    }

    public static function curso_by_parametros($id_carrera,$id_gestion,$id_pensum,$id_mencion,$nivel_asignatura)
    {
        $where="";
        $usuario=users::me();
        switch ($usuario->nombre_grupo) {
            case 'academico':
                $where="";
                break;
            case 'docente':
                $where="and c.id_docente='".$usuario->id_persona."'";
                break;
            
            default:
                # code...
                break;
        }
        return \DB::select("SELECT *,c.id
                from curso c 
                inner join gestion g on g.id=c.id_gestion  
                inner join asignatura_mencion_pensum amp on amp.id=c.id_asignatura_mencion_pensum 
                inner join mencion m on m.id=amp.id_mencion 
                inner join pensum p on p.id=amp.id_pensum 
                inner join asignatura a on a.id=amp.id_asignatura 
                inner join carrera ca on c.id_carrera=ca.id
                where ca.id='$id_carrera'
                and amp.nivel_asignatura='$nivel_asignatura'
                and g.id='$id_gestion'
                and p.id='$id_pensum'
                and m.id='$id_mencion'
                and c.estado_curso='activo'
                $where
                order by g.gestion desc,g.periodo_gestion desc");   
    }
    public static function buscar_asignaturas_nivel_mencion_pensum($id_carrera,$nivel,$id_mencion,$id_pensum){
        
       return \DB::select("SELECT * ,amp.id
                from asignatura a
                inner join asignatura_mencion_pensum amp on amp.id_asignatura=a.id
                where a.id_carrera='$id_carrera' 
                and amp.nivel_asignatura='$nivel'
                and amp.id_mencion='$id_mencion'
                and amp.id_pensum='$id_pensum'
                and amp.estado_asignatura_mencion_pensum='activo'");
        
    }
    

}
