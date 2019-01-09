<?php

namespace App\Models\Admin;

use App\Models\MyModel;

class configuracion extends MyModel
{
    protected $table='configuracion';
    public static function schema()
    {
    	return MyModel::columnas_by_tabla('configuracion');
    }
}
