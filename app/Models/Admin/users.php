<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class users extends Model
{
    protected $table='users';
    
    public static function schema()
    {
    	return MyModel::columnas_by_tabla('users');
    }
    public static function users()
    {
    	return \DB::select("SELECT * from users where estado_users='activo'");
    }
    /**
     * [todos los datos referente al usuario y grupo al que pertenece]
     * @param  [int] $id_user [id primaria de la tabla users]
     * @return [object]          [resultado de la consulta]
     */
    public static function me($id_user=null)
    {
        
    	if(!$id_user)
    	{
    		$id_user=Auth::user()->id;
    	}
    	return \DB::select("SELECT * ,ug.id id_user_group,u.id
    						from users u
    						inner join user_group ug on u.id=ug.id_user
    						inner join groups g on ug.id_group=g.id
    						where u.id='$id_user'
                            and u.estado_users='activo'
    						")[0];
    }

    public static function me_id_usuario()
    {
        
        return  Auth::user()->id;
        
    }

    public static function usuarios($tabla,$where="")
    {
        
        switch ($tabla) {
            case 'administrativo':
                $where.="and (g.nombre_grupo='administrador' or g.nombre_grupo='academico' or g.nombre_grupo='operador')";
                break;
            case 'docente':
                $where.="and g.nombre_grupo='docente'";
                break;
            case 'estudiante':
                $where.="and g.nombre_grupo='estudiante'";
                break;
            default:
                # code...
                break;
        }
        
        return \DB::select(
            "SELECT * , u.id
            from users u 
            inner join user_group ug on u.id=ug.id_user
            inner join groups g on ug.id_group=g.id
            inner join $tabla p on u.id_persona=p.id

            
            where 1=1
            $where");   
    }

    public static function registros_by_tabla($tabla,$where="")
    {

        return \DB::select("SELECT * 
                            FROM $tabla
                            where 1=1                                               
                            $where");
    }  

    public static function administrativo()
    {
        return \DB::select("SELECT * 
                            FROM administrativo a 
                            where estado_administrativo='activo'
                            and a.id not in 
                                (SELECT  p.id
                                from users u 
                                inner join user_group ug on u.id=ug.id_user
                                inner join groups g on ug.id_group=g.id
                                inner join administrativo p on u.id_persona=p.id
                                where  (g.nombre_grupo='administrador' or g.nombre_grupo='academico' or g.nombre_grupo='operador'))"); 
    }
    public static function docente()
    {
        return \DB::select("SELECT * 
                            FROM docente d 
                            where estado_docente='activo'
                            and d.id not in 
                                (SELECT  p.id
                                from users u 
                                inner join user_group ug on u.id=ug.id_user
                                inner join groups g on ug.id_group=g.id
                                inner join docente p on u.id_persona=p.id
                                where  g.nombre_grupo='docente' )"); 
    }
    public static function estudiante()
    {
        return \DB::select("SELECT * 
                            FROM estudiante e
                            where estado_estudiante='activo'
                            and e.id not in 
                                (SELECT  p.id
                                from users u 
                                inner join user_group ug on u.id=ug.id_user
                                inner join groups g on ug.id_group=g.id
                                inner join estudiante p on u.id_persona=p.id
                                where  g.nombre_grupo='estudiante' )"); 
    }
    public static function max_inc($tabla)
    {
        switch ($tabla) {
            case 'administrativo':
                $max="max(inc_administrativo) inc";
                break;
            case 'docente':
                $max="max(inc_administrativo) inc";
                break;

            case 'estudiante':
                $max="max(inc_estudiante) inc";
                break;
            
            default:
                # code...
                break;
        }
        $inc= \DB::select("SELECT $max 
                            FROM users")[0]->inc; 
        if($inc)
        {
            return $inc;
        }
        else
        {
            if($tabla=="administrativo"||$tabla=="docente")
            {
                return 100;
            }
            else
            {
                return 1000;
            }
        }
    }
    

}
