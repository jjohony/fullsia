<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contrato_administrativo extends Model
{
    protected $table="contrato_administrativo";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }  
    

}
