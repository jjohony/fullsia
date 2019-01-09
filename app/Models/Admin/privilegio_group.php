<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class privilegio_group extends Model
{
    protected $table='privilegio_group';
    
    public static function privilegio_groups()
    {
    	return \DB::select("SELECT * from privilegio_group where estado_privilegio_group='activo'");
    }

}
