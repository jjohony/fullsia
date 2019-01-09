<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\factura_estudiante;
use App\Models\Admin\users;
use App\Models\configuracion;
use App\Http\Controllers\Generar_codigo_control;
use App\Helpers\Funciones;
use App\Http\Controllers\Reportes\Factura_estudiante_pdf;
use App\Http\Controllers\Reportes\Factura_estudiante_ingresos;
use App\Http\Controllers\Reportes\Grafico_reporte_ingreso;
use App\Http\Controllers\Reportes\Detalle_de_pagos_por_estudiante;
use App\Http\Controllers\Reportes\Historial_factura_estudiante_pdf;
class Factura_estudianteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $factura=factura_estudiante::facturas();
        return view("operador.pago_estudiante.listar")
            ->with("factura",$factura);
        
    }
    public function index_control_pagos()
    {
        $control_pago=factura_estudiante::control_pago();
        return view("operador.pago_estudiante.listar_control_pago")
            ->with("control_pago",$control_pago);
        
    }
    public function create()
    {        
        $estudiante=factura_estudiante::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $concepto_pago=factura_estudiante::registros_by_tabla("concepto_pago","and estado_concepto_pago='activo'");
        $carrera=factura_estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        //var_dump($estudiante);die;
        if(isset($_GET["id_factura_estudiante"]))
        {
            return view("operador.pago_estudiante.create")
            ->with("estudiante",$estudiante)
            ->with("concepto_pago",$concepto_pago)
            ->with("carrera",$carrera)
            ->with("id_factura_estudiante",$_GET["id_factura_estudiante"]);
        }
        else
        {
            return view("operador.pago_estudiante.create")
            ->with("estudiante",$estudiante)
            ->with("concepto_pago",$concepto_pago)
            ->with("carrera",$carrera);    
        }
        
        
    }
    public function store(Request $request)
    {
        $factura_estudiante=new factura_estudiante();
        include_once "../app/Library/ciqrcode.php";
        $configuracion=factura_estudiante::registros_by_tabla("configuracion","and id='1'")[0];
        $codigo=new Generar_codigo_control();
        $estudiante=factura_estudiante::registros_by_tabla("estudiante","and id='".$request->id_estudiante."'")[0];
        $concepto_pago=factura_estudiante::registros_by_tabla("concepto_pago","and id='".$request->id_concepto_pago."'")[0];
        $nit_cliente="";
        $monto=0.0;
        $funciones=new Funciones();
        
        $nit_cliente=$request->nit_cliente;
        
        $folio=factura_estudiante::max_folio();
        if(!$folio)
        {
            $folio=0;
        }
        
        $monto=$concepto_pago->monto*$request->cantidad;
        
        $monto=round($monto, 0, PHP_ROUND_HALF_DOWN);
        //var_dump($folio);
        $factura=new factura_estudiante();

        $factura->folio=$folio+1;
        $factura->nit=$configuracion->nit;
        $factura->id_estudiante=$request->id_estudiante;
        $factura->id_carrera=$request->id_carrera;
        $factura->id_concepto_pago=$request->id_concepto_pago;
        $factura->cantidad=$request->cantidad;
        $factura->fecha=date("Y-m-d");
        $factura->fecha_limite_emision=$configuracion->fecha_maxima_emision;
        $factura->numero_autorizacion=$configuracion->numero_autorizacion;
        $factura->nit_cliente=$request->nit_cliente;
        $factura->a_nombre_de=$request->a_nombre_de;
        $factura->llave=$configuracion->llave_dosificacion;
        
        $factura->codigo_control=$codigo->generar($factura->numero_autorizacion,$factura->folio,$factura->nit_cliente,$factura->fecha,$monto,$factura->llave);
        
        $factura->monto=$monto;
        $factura->gestion=$request->gestion;
        $factura->imagen_qr="";
        $factura->estado_factura_estudiante="activo";
        $factura->created_at=date("Y-m-d H:i:s");
        $factura->updated_at=date("Y-m-d H:i:s");

        $this->capturar_accion();
        if(!$factura->save()){
            echo "no guarda factura";
        }
        $this->log("descripcion","factura_estudiante",$this->sql,$this->cadena);
        
        $facturas=factura_estudiante::all();
        $factura=$facturas->last();
        $params['data'] = $configuracion->nit."|".$factura->folio."|".$configuracion->numero_autorizacion."|".date("d/m/Y",strtotime($factura->fecha))."|".$factura->monto."|".$factura->monto."|".$factura->codigo_control."|".$factura->nit_cliente."|0|0|0|0";
        $params['level'] = 'H';
        $params['size'] = 5;

        //decimos el directorio a guardar el codigo qr, en este
        //caso una carpeta en la raíz llamada qrcode
        $factura=factura_estudiante::find($factura->id);
        $factura->imagen_qr=time().$factura->id.".png";
        $factura->save();
        $params['savename'] =  '../public/qrcodes/'.$factura->imagen_qr;
        $ciqrcode=new \Ciqrcode();
        $ciqrcode->generate($params);   
        return redirect("factura_estudiante/create?id_factura_estudiante=".$factura->id);        

    }
    public function reporte_factura_estudiante($id_factura_estudiante)
    {
        $configuracion=configuracion::find(1);
        $factura_estudiante=factura_estudiante::facturas("and fe.id='$id_factura_estudiante'");

        $reporte=new Factura_estudiante_pdf();
        $reporte->reporte($factura_estudiante[0],$configuracion);

    }
    public function reporte_historial_factura_estudiante($id_estudiante)
    {
        $factura_estudiante=factura_estudiante::facturas("and fe.id_estudiante='$id_estudiante'");

        $reporte=new Historial_factura_estudiante_pdf();
        $reporte->reporte($factura_estudiante);

    }

    public function index_reporte_factura_estudiante_ingresos()
    {
        
        $carrera=factura_estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("operador.reportes.reporte_factura_estudiante_ingresos")        
        ->with("carrera",$carrera);

    }
    public function reporte_factura_estudiante_ingresos()
    {
        $id_carrera=$_GET["id_carrera"];
        $fecha_inicio=$_GET["fecha_inicio"];
        $fecha_fin=$_GET["fecha_fin"];
        $factura=factura_estudiante::reporte_factura_estudiante_ingresos($id_carrera,$fecha_inicio,$fecha_fin);


        $reporte=new Factura_estudiante_ingresos();
        $reporte->reporte($factura);

    }
    public function grafico_factura_estudiante_ingresos()
    {
        /*$id_carrera=$_GET["id_carrera"];
        $fecha_inicio=$_GET["fecha_inicio"];
        $fecha_fin=$_GET["fecha_fin"];
        $factura=factura_estudiante::reporte_factura_estudiante_ingresos($id_carrera,$fecha_inicio,$fecha_fin);*/
        $reporte=new Grafico_reporte_ingreso();
        $reporte->grafico();
              

    }

    public function index_reporte_detalle_de_pagos_por_estudiante()
    {
        
        $carrera=factura_estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("operador.reportes.reporte_detalle_de_pagos_por_estudiante")        
        ->with("carrera",$carrera);

    }
    public function reporte_detalle_de_pagos_por_estudiante()
    {
        $id_carrera=$_GET["id_carrera"];
        $fecha_inicio=$_GET["fecha_inicio"];
        $fecha_fin=$_GET["fecha_fin"];
        $factura=factura_estudiante::reporte_detalle_de_pagos_por_estudiante($id_carrera,$fecha_inicio,$fecha_fin);
        $reporte=new Detalle_de_pagos_por_estudiante();
        $reporte->reporte($factura);

    }

    
    
    
    
}
