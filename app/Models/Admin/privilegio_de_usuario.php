<?php

namespace App\Models\Admin;

use App\Models\MyModel;

class privilegio_de_usuario extends MyModel
{
    protected $table='privilegio_de_usuario';
    public static function schema()
    {
    	return MyModel::columnas_by_tabla('privilegio_de_usuario');
    }
    public static function privilegio_de_usuarios()
    {
    	return \DB::select("SELECT * from privilegio_de_usuario where estado_privilegio_de_usuario='activo'");
    }

}
