<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pago_administrativo;
use App\Models\pago_docente;
use App\Models\Admin\users;
use App\Http\Controllers\Reportes\Boleta_pago;
use App\Http\Controllers\Reportes\Detalle_boleta_pago;
use App\Http\Controllers\Reportes\Planillas_sueldos_y_salarios;
use App\Http\Controllers\Reportes\Personal_de_la_institucion;

use Illuminate\Database\Events\QueryExecuted as mi_query;
class Pago_administrativoController extends Controller
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
        $contratos=pago_administrativo::contratos("vigente"," and estado_contrato_administrativo='activo'");
        return view("operador.pago_administrativo.listar")
        ->with("contratos",$contratos);
        
    }
    public function create()
    {        
        $id_contrato_administrativo=$_GET["id_contrato_administrativo"];
        $mes=$_GET["mes"];
        $anio=$_GET["anio"];
        $pago_administrativo=pago_administrativo::registros_by_tabla("pago_administrativo","and id_contrato_administrativo='$id_contrato_administrativo' and mes='$mes' and anio='$anio'");
        //var_dump($pago_administrativo);die;
        
        if(!empty($pago_administrativo))
        {
            $pago_administrativo=pago_administrativo::pago_administrativo("and pa.id_contrato_administrativo='$id_contrato_administrativo'")[0];
            return view("operador.pago_administrativo.ver")
            ->with("pago_administrativo",$pago_administrativo);
        }
        else
        {
            $contrato=pago_administrativo::contratos("vigente","and ca.id='$id_contrato_administrativo'")[0];
            $hora_extra=pago_administrativo::pago_extra("HORAS EXTRAS",$mes,$anio,$contrato->id_administrativo);
            $pago_otros=pago_administrativo::pago_extra("otros",$mes,$anio,$contrato->id_administrativo);
            $anticipos=pago_administrativo::descuento("anticipos",$mes,$anio,$contrato->id_administrativo);
            $descuento_otros=pago_administrativo::descuento("otros",$mes,$anio,$contrato->id_administrativo);
            //var_dump($hora_extra);die;
            return view("operador.pago_administrativo.create")
            ->with("contrato",$contrato)
            ->with("mes",$mes)
            ->with("anio",$anio)
            ->with("hora_extra",round($hora_extra,2))
            ->with("pago_otros",round($pago_otros,2))
            ->with("anticipos",round($anticipos,2))
            ->with("descuento_otros",round($descuento_otros,2));    
        }
        
    }
    public function store(Request $request)
    {
        
        $pago_administrativo=new pago_administrativo();
        $id_contrato_administrativo=$request->id_contrato_administrativo;
        $mes=$request->mes;
        $anio=$request->anio;

        
        foreach ($_POST as $key => $value) {
            if($key!="_token"&&$key!="guardar")
            {
                $pago_administrativo->$key=$value;    
            }        
        }
        
        $this->capturar_accion();
        $pago_administrativo->save();

        
        $this->log("descripcion","pago_administrativo",$this->sql,$this->cadena);

        switch ($request->guardar) {
            case 'Confirmar pago y ver':
                return redirect("pago_administrativo/create?id_contrato_administrativo=$id_contrato_administrativo&mes=$mes&anio=$anio");
                break;
            case 'Confirmar pago y volver a lista':
                return redirect("pago_administrativo");
                break;
            
            default:
                return redirect("pago_administrativo");
                break;
        }

    }
    public function reporte_boleta_pago($id_pago_administrativo)
    {
        $pago_administrativo=pago_administrativo::pago_administrativo("and pa.id='$id_pago_administrativo'");
        $reporte=new Boleta_pago();
        $reporte->reporte($pago_administrativo[0]);
    }

    public function reporte_detalle_boleta_pago($id_pago_administrativo)
    {
        $pago_administrativo=pago_administrativo::pago_administrativo("and pa.id='$id_pago_administrativo'");
        $mes=$pago_administrativo[0]->mes;
        $anio=$pago_administrativo[0]->anio;
        $id_administrativo=$pago_administrativo[0]->id_administrativo;
        $pago_extra=pago_administrativo::pago_extra_desglosado($mes,$anio,$id_administrativo);
        $descuento=pago_administrativo::descuento_desglosado($mes,$anio,$id_administrativo);
        $reporte=new Detalle_boleta_pago();
        $reporte->reporte($pago_administrativo[0],$pago_extra,$descuento);
    }
    public function index_reporte_planillas_sueldos_y_salarios()
    {
        $unidad_area=pago_administrativo::registros_by_tabla("unidad_area","and estado_unidad_area='activo'");
        return view("operador/reportes/reporte_planillas_sueldos_y_salarios")
        ->with("unidad_area",$unidad_area);
    }
    public function reporte_planillas_sueldos_y_salarios()
    {
        $id_unidad_area=$_GET["id_unidad_area"];
        $mes=$_GET["mes"];
        $anio=$_GET["anio"];
                
        $pago_administrativo=pago_administrativo::reporte_planillas_sueldos_y_salarios($id_unidad_area,$mes,$anio);
        $pago_docente=pago_docente::reporte_planillas_sueldos_y_salarios($id_unidad_area,$mes,$anio);

        $reporte=new Planillas_sueldos_y_salarios();
        $reporte->reporte($pago_administrativo,$pago_docente);
    }

    public function reporte_personal_de_la_institucion()
    {
                
        $administrativo=pago_administrativo::contratos("vigente");
        $docente=pago_docente::contratos("vigente");

        $reporte=new Personal_de_la_institucion();
        $reporte->reporte($administrativo,$docente);
    }

    
    
    
    
}
