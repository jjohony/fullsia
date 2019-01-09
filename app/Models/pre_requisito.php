<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pre_requisito extends Model
{
    protected $table="pre_requisito";

    
    public static function verificar_pre_requisito($id_pre_requisito_amp,$id_amp)
    {
        $consulta=\DB::select("SELECT * from pre_requisito 
                    where id_pre_requisito_asignatura_mencion_pensum='$id_pre_requisito_amp'
                    and id_asignatura_mencion_pensum='$id_amp'");
        if(!empty($consulta))
        {
            return $consulta;
        }
        else
        {
            return false;
        }
    }

}
