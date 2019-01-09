<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estudiante extends Model
{
    protected $table="estudiante";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }  

    public static function estudiante_and_usuario($id_estudiante)
    {
        $estudiante=\DB::select("SELECT * 
            from estudiante e 
            left join users u on e.id=u.id_persona and inc_estudiante!='' 
            where e.id='$id_estudiante'");        
        
        return $estudiante;
    }

    public static function carreras_by_estudiante($id_estudiante)
    {
        $carrera=\DB::select("SELECT * ,c.id
            from nota_inscripcion n 
            inner join carrera c on n.id_carrera=c.id
            where n.id_estudiante='$id_estudiante'
            and c.estado_carrera='activo'
            and n.estado_nota='activo'
            group by c.id");        
        
        return $carrera;
    }
    public static function estudiante_by_carrera($id_carrera)
    {

        return \DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            where                            
                            n.id_carrera='$id_carrera'
                            and n.estado_nota='activo'
                            and e.estado_estudiante='activo'
                            group by e.id");
    }  
    public static function nota_by_carrera_and_estudiante($id_carrera,$id_estudiante)
    {
        return \DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            where                            
                            n.id_carrera='$id_carrera'
                            and e.id='$id_estudiante'
                            and n.estado_nota='activo'
                            and n.estado_inscrito='nota'"); 
    }
    public static function nota_actuales_by_carrera_and_estudiante($id_carrera,$id_estudiante)
    {
        return \DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            where                            
                            n.id_carrera='$id_carrera'
                            and e.id='$id_estudiante'
                            and n.estado_nota='activo'
                            and n.estado_inscrito='inscrito'"); 
    }

    public static function reporte_estudiantes_por_carrera($id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        return \DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            where                            
                            n.id_carrera='$id_carrera'
                            $ges
                            $per
                            and n.estado_nota='activo'

                            group by e.id
                            order by e.paterno,e.materno,e.nombre"); 
    }

    public static function reporte_estadisticas_de_estudiantes($id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        return \DB::select("SELECT count(*) total, 
                                (SELECT count(*)
                                FROM estudiante e 
                                where e.id in 
                                    (
                                    SELECT n.id_estudiante
                                    from nota_inscripcion n 
                                    inner join curso c on n.id_curso=c.id
                                    inner join gestion g on c.id_gestion=g.id
                                    where n.id_carrera='$id_carrera'
                                    $ges
                                    $per 
                                    group by n.id_estudiante 
                                    )
                                and e.sexo='MASCULINO'
                                ) varones,
                                (SELECT count(*)
                                FROM estudiante e 
                                where e.id in 
                                    (
                                    SELECT n.id_estudiante
                                    from nota_inscripcion n 
                                    inner join curso c on n.id_curso=c.id
                                    inner join gestion g on c.id_gestion=g.id
                                    where n.id_carrera='$id_carrera'
                                    $ges
                                    $per 
                                    group by n.id_estudiante 
                                    )
                                and e.sexo='FEMENINO'
                                ) mujeres
                            FROM estudiante e1 
                            where e1.id in 
                                (
                                SELECT n.id_estudiante
                                from nota_inscripcion n 
                                inner join curso c on n.id_curso=c.id
                                inner join gestion g on c.id_gestion=g.id
                                where n.id_carrera='$id_carrera'
                                $ges
                                $per 
                                group by n.id_estudiante 
                                )"); 
    }

    public static function reporte_estadisticas_de_estudiantes_detalle($id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $ges1=($gestion!="")?" and g1.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        $per1=($periodo_gestion!="")?" and g1.periodo_gestion='$periodo_gestion'":"";

        $nivel_asignatura=\DB::select("SELECT amp.nivel_asignatura from asignatura_mencion_pensum amp inner join asignatura a on amp.id_asignatura=a.id where id_carrera='$id_carrera' group by amp.nivel_asignatura");
        $estudiante=array();

        if(!empty($nivel_asignatura))
        {
            foreach ($nivel_asignatura as $key => $value) {
                $nivel=$value->nivel_asignatura;
                $estudiante[$value->nivel_asignatura]=
                \DB::select("SELECT count(*) total, 
                                (SELECT count(*)
                                FROM estudiante e 
                                where e.id in 
                                    (
                                    SELECT n.id_estudiante
                                    from nota_inscripcion n 
                                    inner join curso c on n.id_curso=c.id
                                    inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                                    inner join gestion g on c.id_gestion=g.id
                                    where n.id_carrera='$id_carrera'
                                    and amp.nivel_asignatura='$nivel'
                                    $ges
                                    $per 
                                    group by n.id_estudiante 
                                    )
                                and e.sexo='MASCULINO'
                                ) varones,
                                (SELECT count(*)
                                FROM estudiante e 
                                where e.id in 
                                    (
                                    SELECT n.id_estudiante
                                    from nota_inscripcion n 
                                    inner join curso c on n.id_curso=c.id
                                    inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                                    inner join gestion g on c.id_gestion=g.id
                                    where n.id_carrera='$id_carrera'
                                    and amp.nivel_asignatura='$nivel'
                                    $ges
                                    $per 
                                    group by n.id_estudiante 
                                    )
                                and e.sexo='FEMENINO'
                                ) mujeres
                            FROM estudiante e1 
                            where e1.id in 
                                (
                                SELECT n.id_estudiante
                                from nota_inscripcion n 
                                inner join curso c on n.id_curso=c.id
                                inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                                inner join gestion g on c.id_gestion=g.id
                                where n.id_carrera='$id_carrera'
                                and amp.nivel_asignatura='$nivel'
                                $ges
                                $per 
                                group by n.id_estudiante 
                                )")[0]; 
            }
        }

        return $estudiante;
    }


    public static function reporte_cantidad_de_estudiantes($id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";

        $ges1=($gestion!="")?" and g1.gestion='$gestion'":"";
        $per1=($periodo_gestion!="")?" and g1.periodo_gestion='$periodo_gestion'":"";

        $estudiante=
                    \DB::select("SELECT * ,count(*) total,
                                    (SELECT count(*)
                                     from nota_inscripcion n1 
                                     inner join estudiante e on n1.id_estudiante=e.id
                                     inner join curso c1 on n1.id_curso=c1.id
                                     inner join asignatura_mencion_pensum amp1 on c1.id_asignatura_mencion_pensum=amp1.id
                                     inner join asignatura a1 on amp1.id_asignatura=a1.id
                                     inner join gestion g1 on c1.id_gestion=g1.id
                                     where 
                                     n1.id_carrera='$id_carrera'
                                     $ges1
                                     $per1
                                    and n1.estado_nota='activo'
                                    and e.sexo='MASCULINO'
                                    and a.id=a1.id
                                    group by a.id) varones,
                                    (SELECT count(*)
                                     from nota_inscripcion n1 
                                     inner join estudiante e on n1.id_estudiante=e.id
                                     inner join curso c1 on n1.id_curso=c1.id
                                     inner join asignatura_mencion_pensum amp1 on c1.id_asignatura_mencion_pensum=amp1.id
                                     inner join asignatura a1 on amp1.id_asignatura=a1.id
                                     inner join gestion g1 on c1.id_gestion=g1.id
                                     where 
                                     n1.id_carrera='$id_carrera'
                                     $ges1
                                     $per1
                                    and n1.estado_nota='activo'
                                    and e.sexo='FEMENINO'
                                    and a.id=a1.id
                                    group by a.id) mujeres
                                 from nota_inscripcion n 
                                 inner join curso c on n.id_curso=c.id
                                 inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                                 inner join asignatura a on amp.id_asignatura=a.id
                                 inner join gestion g on c.id_gestion=g.id
                                 where 
                                 n.id_carrera='$id_carrera'
                                 $ges
                                 $per
                                and n.estado_nota='activo'
                                group by a.id
                                "); 
                
            
        

        return $estudiante;
    }

    public static function reporte_estadisticas_de_estudiantes_por_carreras($gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";

        $carrera=\DB::select("SELECT * from carrera where estado_carrera='activo'");
        $estudiante=array();

        if(!empty($carrera))
        {
            foreach ($carrera as $key => $value) {
                //var_dump($value);die;
                $id_carrera=$value->id;
                $estudiante[]=
                    \DB::select("SELECT carrera,count(*) total, 
                                    (SELECT count(*)
                                    FROM estudiante e 
                                    where e.id in 
                                        (
                                        SELECT n.id_estudiante
                                        from nota_inscripcion n 
                                        inner join curso c on n.id_curso=c.id
                                        inner join gestion g on c.id_gestion=g.id
                                        where n.id_carrera='$id_carrera'
                                        $ges
                                        $per 
                                        group by n.id_estudiante 
                                        )
                                    and e.sexo='MASCULINO'
                                    ) varones,
                                    (SELECT count(*)
                                    FROM estudiante e 
                                    where e.id in 
                                        (
                                        SELECT n.id_estudiante
                                        from nota_inscripcion n 
                                        inner join curso c on n.id_curso=c.id
                                        inner join gestion g on c.id_gestion=g.id
                                        where n.id_carrera='$id_carrera'
                                        $ges
                                        $per 
                                        group by n.id_estudiante 
                                        )
                                    and e.sexo='FEMENINO'
                                    ) mujeres
                                FROM estudiante e1 
                                inner join carrera c1 on c1.id='$id_carrera'
                                where e1.id in 
                                    (
                                    SELECT n.id_estudiante
                                    from nota_inscripcion n 
                                    inner join curso c on n.id_curso=c.id
                                    inner join gestion g on c.id_gestion=g.id
                                    where n.id_carrera='$id_carrera'
                                    $ges
                                    $per 
                                    group by n.id_estudiante 
                                    )")[0]; 
                
            }
        }

        return $estudiante;
    }

    public static function reporte_historial_academico($id_carrera,$id_estudiante)
    {
        return \DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            left join users u on e.id=u.id_persona and u.inc_estudiante!=''
                            where                            
                            n.id_carrera='$id_carrera'
                            and e.id='$id_estudiante'
                            and n.estado_nota='activo'
                            and n.estado_inscrito='nota'
                            order by g.periodo_gestion,g.gestion");   
    }
    
     public static function reporte_centralizador_de_calificaciones($id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        

        $nivel_asignatura=\DB::select("SELECT amp.nivel_asignatura from asignatura_mencion_pensum amp inner join asignatura a on amp.id_asignatura=a.id where id_carrera='$id_carrera' group by amp.nivel_asignatura");

        
        return $nivel_asignatura;
    }

    public static function estudiante_by_nivel_carrera_gestion_periodo($nivel_asignatura,$id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        

        $estudiante=\DB::select("SELECT * ,e.id
                            FROM estudiante e
                            inner join nota_inscripcion n on e.id=n.id_estudiante
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join gestion g on c.id_gestion=g.id
                            where                            
                            n.id_carrera='$id_carrera'
                            $ges
                            $per
                            and amp.nivel_asignatura='$nivel_asignatura'
                            and n.estado_nota='activo'
                            and n.estado_inscrito='nota'
                            group by e.id
                            order by e.paterno,e.materno,e.nombre
                            ");        
        
        return $estudiante;
    }

    public static function nota_by_estudiante_carrera_asignatura_gestion_periodo_gestion($id_estudiante,$id_carrera,$id_asignatura,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";
        return \DB::select("SELECT *
                            from nota_inscripcion n
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            where                  
                            n.id_estudiante='$id_estudiante'          
                            and n.id_carrera='$id_carrera'
                            and a.id='$id_asignatura'
                            
                            $ges
                            $per
                            and n.estado_nota='activo'
                            ");   

    }

    public static function asignatura_by_nivel_and_id_carrera($nivel_asignatura,$id_carrera)
    {
        $asignatura=\DB::select("SELECT * 
            from asignatura_mencion_pensum amp 
            inner join asignatura a on amp.id_asignatura=a.id 
            where id_carrera='$id_carrera' and amp.nivel_asignatura='$nivel_asignatura'");        
        
        return $asignatura;
    }





    public static function reporte_boleta_inscripcion($id_estudiante,$id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";

        return \DB::select("SELECT *,e.created_at fecha
                            from nota_inscripcion n
                            inner join estudiante e on n.id_estudiante=e.id
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join pensum p on amp.id_pensum=p.id
                            inner join mencion m on amp.id_mencion=m.id
                            inner join gestion g on c.id_gestion=g.id
                            inner join carrera ca on n.id_carrera=ca.id
                            left join users u on u.id_persona=e.id and u.inc_estudiante!=''
                            where                  
                            n.id_estudiante='$id_estudiante'          
                            and n.id_carrera='$id_carrera'
                            
                            
                            $ges
                            $per
                            and n.estado_nota='activo'
                            group by e.id
                            order by amp.nivel_asignatura desc");   

    }

    public static function reporte_boleta_de_asignacion_de_materias($id_estudiante,$id_carrera,$gestion,$periodo_gestion)
    {

        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";

        return \DB::select("SELECT *,e.created_at fecha
                            from nota_inscripcion n
                            inner join estudiante e on n.id_estudiante=e.id
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join pensum p on amp.id_pensum=p.id
                            inner join mencion m on amp.id_mencion=m.id
                            inner join gestion g on c.id_gestion=g.id
                            inner join carrera ca on n.id_carrera=ca.id
                            left join users u on e.id=u.id_persona and u.inc_estudiante!=''
                            where                  
                            n.id_estudiante='$id_estudiante'          
                            and n.id_carrera='$id_carrera'
                            
                            
                            $ges
                            $per
                            and n.estado_nota='activo'
                            ");   

    }

    public static function reporte_boleta_de_calificaciones_dividido_por_semestre($id_curso)
    {
        return \DB::select("SELECT *
                            from nota_inscripcion n
                            inner join estudiante e on n.id_estudiante=e.id
                            inner join curso c on n.id_curso=c.id
                            inner join asignatura_mencion_pensum amp on c.id_asignatura_mencion_pensum=amp.id
                            inner join asignatura a on amp.id_asignatura=a.id
                            inner join gestion g on c.id_gestion=g.id
                            where                  
                            c.id='$id_curso'
                            and n.estado_nota='activo'
                            and n.estado_inscrito='nota'
                            ");   

    }

    public static function reporte_asistencia_de_estudiantes_fechas($id_curso)
    {
        return \DB::select("SELECT *
                            from asistencia a
                            where id_curso='$id_curso'
                            and estado_asistencia='activo'
                            group by fecha
                            order by fecha desc
                            ");   

    }
    public static function reporte_asistencia_de_estudiantes_estudiantes($id_curso)
    {
        return \DB::select("SELECT *
                            from nota_inscripcion n
                            inner join estudiante e on n.id_estudiante=e.id
                            where n.id_curso='$id_curso'
                            and estado_nota='activo'
                            ");   

    }
    public static function reporte_asistencia_de_estudiantes_asistencia($id_curso,$fecha,$id_estudiante)
    {
        return \DB::select("SELECT *
                            from asistencia a
                            inner join estudiante e on a.id_estudiante=e.id
                            where a.id_curso='$id_curso'
                            and a.estado_asistencia='activo'
                            and a.id_estudiante='$id_estudiante'
                            and a.fecha='$fecha'
                            ");   

    }
}
