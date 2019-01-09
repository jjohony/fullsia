<?php

namespace App\Models\Admin;

use App\Models\MyModel;

class user_group extends MyModel
{
    protected $table='user_group';
    public static function schema()
    {
    	return MyModel::columnas_by_tabla('user_group');
    }
    public static function user_groups()
    {
    	return \DB::select("SELECT * from user_group where estado_user_group='activo'");
    }

}
