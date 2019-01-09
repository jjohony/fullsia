<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pago_docente extends Model
{
    protected $table="pago_docente";

    
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
    						FROM contrato_docente ca
    						inner join docente a on ca.id_docente=a.id
    						inner join cargo c on ca.id_cargo=c.id
    						inner join unidad_area ua on ca.id_unidad_area=ua.id
    						where 1=1 					     						
    						and estado_contrato='$estado'
    						$where");
    } 
    public static function pago_extra($tipo_pago,$mes,$anio,$id_docente)
    {

    	return \DB::select("SELECT sum(pea.monto) monto
    						FROM pago_extra_docente pea
    						inner join tipo_pago tp on pea.id_tipo_pago=tp.id
    						where 1=1 					     						
    						and tp.tipo_pago='$tipo_pago'
    						and pea.mes='$mes'
    						and pea.anio='$anio'
    						and pea.id_docente='$id_docente'
    						")[0]->monto;
    } 
    public static function descuento($tipo_descuento,$mes,$anio,$id_docente)
    {

    	return \DB::select("SELECT sum(da.monto) monto
    						FROM descuento_docente da
    						inner join tipo_descuento td on da.id_tipo_descuento=td.id
    						where 1=1 					     						
    						and td.tipo_descuento='$tipo_descuento'
    						and da.mes='$mes'
    						and da.anio='$anio'
    						and da.id_docente='$id_docente'
    						")[0]->monto;
    }  

    public static function pago_docente($where='')
    {

    	return \DB::select("SELECT * ,pd.id
    						from pago_docente pd 
    						inner join contrato_docente ca on pd.id_contrato_docente=ca.id
    						inner join docente a on ca.id_docente=a.id
    						inner join cargo c on ca.id_cargo=c.id
    						inner join unidad_area ua on ca.id_unidad_area=ua.id
    						where 1=1 					     						
    						
    						$where");
    } 

    public static function pago_extra_desglosado($mes,$anio,$id_docente)
    {

        return \DB::select("SELECT  *,pea.created_at fecha,pea.descripcion
                            FROM pago_extra_docente pea
                            inner join tipo_pago tp on pea.id_tipo_pago=tp.id
                            where 1=1                                               
                            and pea.mes='$mes'
                            and pea.anio='$anio'
                            and pea.id_docente='$id_docente'
                            ");
    } 

    public static function descuento_desglosado($mes,$anio,$id_docente)
    {

        return \DB::select("SELECT *,da.created_at fecha,da.descripcion
                            FROM descuento_docente da
                            inner join tipo_descuento td on da.id_tipo_descuento=td.id
                            where 1=1                                               
                            and da.mes='$mes'
                            and da.anio='$anio'
                            and da.id_docente='$id_docente'
                            ");
    }  
    
    public static function reporte_asignacion_de_docente($gestion,$periodo_gestion)
    {
        $ges=($gestion!="")?" and g.gestion='$gestion'":"";
        $per=($periodo_gestion!="")?" and g.periodo_gestion='$periodo_gestion'":"";

        

        
        return \DB::select("SELECT *
                            FROM docente d
                            inner join  curso c  on d.id=c.id_docente
                            inner join  asignatura_mencion_pensum amp  on c.id_asignatura_mencion_pensum=amp.id
                            inner join  asignatura a  on amp.id_asignatura=a.id
                            inner join  pensum p  on amp.id_pensum=p.id
                            inner join carrera ca on c.id_carrera=ca.id
                            inner join gestion g on c.id_gestion=g.id
                            where 1=1                                               
                            $ges
                            $per

                            order by d.id
                            ");
    }

    public static function reporte_asistencia_de_docente($id_docente,$fecha_inicio,$fecha_fin)
    {
        $inicio=($fecha_inicio!="")?" and ad.fecha>='$fecha_inicio'":"";
        $fin=($fecha_fin!="")?" and ad.fecha<='$fecha_fin'":"";

        

        
        return \DB::select("SELECT *
                        from asistencia_docente ad
                        inner join docente d on ad.id_docente=d.id
                        where 
                        d.estado_docente='activo'
                        and ad.estado_asistencia_docente='activo'
                        
                        $inicio
                        $fin
                        order by d.id, ad.fecha,ad.hora,ad.minuto,ad.segundo
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
                                    from pago_extra_docente pea1
                                    inner join tipo_pago tp1 on pea1.id_tipo_pago=tp1.id
                                    where tp1.tipo_pago='horas extras'
                                    $_mes1
                                    $_anio1
                                    and pea1.id_docente=a.id ) hora_extra,
                                (select sum(monto) 
                                    from pago_extra_docente pea1
                                    inner join tipo_pago tp1 on pea1.id_tipo_pago=tp1.id
                                    where tp1.tipo_pago='otros'
                                    $_mes1
                                    $_anio1
                                    and pea1.id_docente=a.id ) otros_pagos,
                                (select sum(monto) 
                                    from descuento_docente pea1
                                    where 
                                    1=1
                                    $_mes1
                                    $_anio1
                                    and pea1.id_docente=a.id ) otros_descuentos
                            from pago_docente pa 
                            inner join contrato_docente ca on pa.id_contrato_docente=ca.id
                            inner join docente a on ca.id_docente=a.id
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
