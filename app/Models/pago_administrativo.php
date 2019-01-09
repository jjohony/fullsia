<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pago_administrativo extends Model
{
    protected $table="pago_administrativo";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    } 
    public static function contratos($estado,$where='')
    {

    	return \DB::select("SELECT * ,ca.id
    						FROM contrato_administrativo ca
    						inner join administrativo a on ca.id_administrativo=a.id
    						inner join cargo c on ca.id_cargo=c.id
    						inner join unidad_area ua on ca.id_unidad_area=ua.id
                            inner join tipo_contrato tc on ca.id_tipo_contrato=tc.id
                            inner join banco b on ca.id_banco=b.id
    						where 1=1 					     						
    						and estado_contrato='$estado'
    						$where");
    } 
    public static function pago_extra($tipo_pago,$mes,$anio,$id_administrativo)
    {

    	return \DB::select("SELECT sum(pea.monto) monto
    						FROM pago_extra_administrativo pea
    						inner join tipo_pago tp on pea.id_tipo_pago=tp.id
    						where 1=1 					     						
    						and tp.tipo_pago='$tipo_pago'
    						and pea.mes='$mes'
    						and pea.anio='$anio'
    						and pea.id_administrativo='$id_administrativo'
    						")[0]->monto;
    } 
    public static function descuento($tipo_descuento,$mes,$anio,$id_administrativo)
    {

    	return \DB::select("SELECT sum(da.monto) monto
    						FROM descuento_administrativo da
    						inner join tipo_descuento td on da.id_tipo_descuento=td.id
    						where 1=1 					     						
    						and td.tipo_descuento='$tipo_descuento'
    						and da.mes='$mes'
    						and da.anio='$anio'
    						and da.id_administrativo='$id_administrativo'
    						")[0]->monto;
    }  

    public static function pago_administrativo($where='')
    {

    	return \DB::select("SELECT * ,pa.id
    						from pago_administrativo pa 
    						inner join contrato_administrativo ca on pa.id_contrato_administrativo=ca.id
    						inner join administrativo a on ca.id_administrativo=a.id
    						inner join cargo c on ca.id_cargo=c.id
    						inner join unidad_area ua on ca.id_unidad_area=ua.id
    						where 1=1 					     						
    						
    						$where");
    } 
    public static function pago_extra_desglosado($mes,$anio,$id_administrativo)
    {

        return \DB::select("SELECT  *,pea.created_at fecha,pea.descripcion
                            FROM pago_extra_administrativo pea
                            inner join tipo_pago tp on pea.id_tipo_pago=tp.id
                            where 1=1                                               
                            and pea.mes='$mes'
                            and pea.anio='$anio'
                            and pea.id_administrativo='$id_administrativo'
                            ");
    } 

    public static function descuento_desglosado($mes,$anio,$id_administrativo)
    {

        return \DB::select("SELECT *,da.created_at fecha,da.descripcion
                            FROM descuento_administrativo da
                            inner join tipo_descuento td on da.id_tipo_descuento=td.id
                            where 1=1                                               
                            and da.mes='$mes'
                            and da.anio='$anio'
                            and da.id_administrativo='$id_administrativo'
                            ");
    }  

    public static function reporte_planillas_sueldos_y_salarios($id_unidad_area,$mes,$anio)
    {
        $unidad_area="";
        if($id_unidad_area!="")
        {
            $unidad_area.="and ua.id='$id_unidad_area' ";
        }
        $_mes="";
        $_mes1="";
        if($mes!="")
        {
            $_mes.="and pa.mes='$mes' ";
            $_mes1.="and pea1.mes='$mes' ";


        }
        $_anio="";
        $_anio1="";
        if($anio!="")
        {
            $_anio.="and pa.anio='$anio' ";
            $_anio1.="and pea1.anio='$anio' ";
        }
        return \DB::select("SELECT * ,pa.id,
                                (select sum(monto) 
                                    from pago_extra_administrativo pea1
                                    inner join tipo_pago tp1 on pea1.id_tipo_pago=tp1.id
                                    where tp1.tipo_pago='horas extras'
                                    $_mes1
                                    $_anio1
                                    and pea1.id_administrativo=a.id ) hora_extra,
                                (select sum(monto) 
                                    from pago_extra_administrativo pea1
                                    inner join tipo_pago tp1 on pea1.id_tipo_pago=tp1.id
                                    where tp1.tipo_pago='otros'
                                    $_mes1
                                    $_anio1
                                    and pea1.id_administrativo=a.id ) otros_pagos,
                                (select sum(monto) 
                                    from descuento_administrativo pea1
                                    where 
                                    1=1
                                    $_mes1
                                    $_anio1
                                    and pea1.id_administrativo=a.id ) otros_descuentos
                            from pago_administrativo pa 
                            inner join contrato_administrativo ca on pa.id_contrato_administrativo=ca.id
                            inner join administrativo a on ca.id_administrativo=a.id
                            inner join cargo c on ca.id_cargo=c.id
                            inner join unidad_area ua on ca.id_unidad_area=ua.id
                            left join nacionalidad n on a.id_nacionalidad=n.id 
                            where 1=1                                               
                            $unidad_area
                            $_mes
                            $_anio
                            ");        
    }

}
