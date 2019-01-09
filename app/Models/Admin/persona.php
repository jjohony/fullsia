<?php

namespace App\Models\Admin;

use App\Models\MyModel;

class persona extends MyModel
{
    protected $table='persona';
     public static function schema()
    {
    	return MyModel::columnas_by_tabla('persona');
    }
    public static function persona()
    {
    	return \DB::select("SELECT * from persona where estado_persona='activo'");
    }
}
