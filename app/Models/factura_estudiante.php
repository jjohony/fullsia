<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class factura_estudiante extends Model
{
    protected $table="factura_estudiante";

    
    public static function registros_by_tabla($tabla,$where="")
    {

    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where");
    }  
    public static function max_folio()
    {
      return \DB::select("SELECT max(folio) folio
                        from factura_estudiante
                        ")[0]->folio;
    }
    public static function facturas($where='')
    {
      return \DB::select("SELECT * ,fe.id,fe.fecha
                          from factura_estudiante fe 
                          inner join estudiante e on  fe.id_estudiante=e.id
                          inner join concepto_pago cp on fe.id_concepto_pago=cp.id 
                          inner join carrera  c on  fe.id_carrera=c.id
                          where estado_factura_estudiante='activo'
                          $where
                          order by fe.id desc");
    }
    public static function control_pago()
    {
      return \DB::select("SELECT * 
                          
                          ,(SELECT sum(fe1.cantidad) 
                            from factura_estudiante fe1
                            inner join concepto_pago cp1 on fe1.id_concepto_pago=cp1.id
                            where cp1.concepto_pago='INSCRIPCION'
                            and fe.id_estudiante=fe1.id_estudiante) cantidad_inscripcion

                          ,(SELECT sum(fe2.cantidad) 
                            from factura_estudiante fe2
                            inner join concepto_pago cp2 on fe2.id_concepto_pago=cp2.id
                            where cp2.concepto_pago='MATRICULA'
                            and fe.id_estudiante=fe2.id_estudiante) cantidad_matriculacion    


                          ,(SELECT sum(fe3.cantidad) 
                            from factura_estudiante fe3
                            inner join concepto_pago cp3 on fe3.id_concepto_pago=cp3.id
                            where cp3.concepto_pago='MENSUALIDAD'
                            and fe.id_estudiante=fe3.id_estudiante) cantidad_mensualidad
                          , sum(fe.monto) monto
                          ,fe.id
                          
                          from factura_estudiante fe 
                          inner join estudiante e on  fe.id_estudiante=e.id
                          inner join concepto_pago cp on fe.id_concepto_pago=cp.id 
                          where fe.estado_factura_estudiante='activo'
                          group by fe.id_estudiante");
    }

     public static function reporte_factura_estudiante_ingresos($id_carrera,$fecha_inicio,$fecha_fin)
    {
      $carrera="";
      $inicio="";
      $fin="";
      if($id_carrera!="")
      {
        $carrera.=" and fe.id_carrera='$id_carrera'";
      }
      if($fecha_inicio!="")
      {
        $inicio.=" and fe.fecha>='$fecha_inicio'";
      }
      if($fecha_fin!="")
      {
        $fin.=" and fe.fecha<='$fecha_fin'";
      }
      return \DB::select("SELECT *,sum(monto) total

                          from factura_estudiante fe 
                          inner join carrera c on  fe.id_carrera=c.id
                          where fe.estado_factura_estudiante='activo'
                          $carrera
                          $inicio
                          $fin
                          group by fe.id_carrera");
    }

    public static function reporte_factura_estudiante_ingresos_detalle($id_carrera,$fecha_inicio,$fecha_fin)
    {
      
      $inicio="";
      $fin="";
      
      if($fecha_inicio!="")
      {
        $inicio.=" and fe.fecha>='$fecha_inicio'";
      }
      if($fecha_fin!="")
      {
        $fin.=" and fe.fecha<='$fecha_fin'";
      }
      return \DB::select("SELECT *,sum(fe.monto) monto

                          from factura_estudiante fe 
                          inner join concepto_pago cp on fe.id_concepto_pago=cp.id 

                          where fe.estado_factura_estudiante='activo'
                          and fe.id_carrera='$id_carrera'
                          $inicio
                          $fin
                          group by fe.id_concepto_pago");
    }

    public static function reporte_detalle_de_pagos_por_estudiante($id_carrera,$fecha_inicio,$fecha_fin)
    {
      $carrera="";
      $inicio="";
      $fin="";
      if($id_carrera!="")
      {
        $carrera.=" and fe.id_carrera='$id_carrera'";
      }
      if($fecha_inicio!="")
      {
        $inicio.=" and fe.fecha>='$fecha_inicio'";
      }
      if($fecha_fin!="")
      {
        $fin.=" and fe.fecha<='$fecha_fin'";
      }
      return \DB::select("SELECT *,sum(fe.monto) monto

                          from factura_estudiante fe 
                          inner join carrera c on  fe.id_carrera=c.id
                          inner join estudiante e on fe.id_estudiante=e.id 
                          where fe.estado_factura_estudiante='activo'
                          $carrera
                          $inicio
                          $fin
                          group by fe.id_estudiante
                          order by fe.id_carrera");
    }

    public static function reporte_detalle_de_pagos_por_estudiante_detalle($id_carrera,$id_estudiante,$fecha_inicio,$fecha_fin)
    {
      
      $inicio="";
      $fin="";
      
      if($fecha_inicio!="")
      {
        $inicio.=" and fe.fecha>='$fecha_inicio'";
      }
      if($fecha_fin!="")
      {
        $fin.=" and fe.fecha<='$fecha_fin'";
      }
      return \DB::select("SELECT *,sum(fe.monto) monto

                          from factura_estudiante fe 
                          inner join concepto_pago cp on fe.id_concepto_pago=cp.id 
                          where fe.estado_factura_estudiante='activo'
                          and fe.id_carrera='$id_carrera'
                          and fe.id_estudiante='$id_estudiante'
                          $inicio
                          $fin
                          group by fe.id_concepto_pago");
    }
        

}
