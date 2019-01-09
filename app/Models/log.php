<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\users;
class log extends Model
{
    protected $table="log";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }
    public static function log_by_fechas($fecha_inicio,$fecha_fin)
    {
      
      $inicio="";
      $fin="";
      
      if($fecha_inicio!="")
      {
        $inicio.=" and l.created_at>='$fecha_inicio'";
      }
      if($fecha_fin!="")
      {
        $fin.=" and l.created_at<='$fecha_fin'";
      }
      $data["administrativo"]= \DB::select("SELECT *,l.created_at fecha

                          from log l
                          inner join users u on  l.id_usuario=u.id
                          inner join user_group ug on u.id=ug.id_user
                          inner join groups g on g.id=ug.id_group
                          inner join administrativo a on  l.id_persona=a.id and a.id=u.id_persona
                          where 
                          1=1
                          and g.nombre_grupo in ('administrador','operador','academico')
                          $inicio
                          $fin
                          order by l.created_at desc
                          ");
      $data["docente"]= \DB::select("SELECT *,l.created_at fecha

                          from log l
                          inner join users u on  l.id_usuario=u.id
                          inner join docente a on  l.id_persona=a.id and a.id=u.id_persona
                          inner join user_group ug on u.id=ug.id_user
                          inner join groups g on g.id=ug.id_group
                          where 
                          1=1
                          
                          and g.nombre_grupo = 'docente'
                          $inicio
                          $fin
                          order by l.created_at desc
                          ");
      $data["estudiante"]= \DB::select("SELECT *,l.created_at fecha

                          from log l
                          inner join users u on  l.id_usuario=u.id
                          inner join estudiante a on  l.id_persona=a.id and a.id=u.id_persona
                          inner join user_group ug on u.id=ug.id_user
                          inner join groups g on g.id=ug.id_group
                          where 
                          1=1
                          
                          and g.nombre_grupo = 'estudiante'
                          $inicio
                          $fin
                          order by l.created_at desc
                          ");
      return $data;
    }
        

}
