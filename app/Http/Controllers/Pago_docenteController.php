<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pago_docente;
use App\Models\Admin\users;
use App\Models\TableModel;
use App\Http\Controllers\Reportes\Boleta_pago;
use App\Http\Controllers\Reportes\Detalle_boleta_pago;
use App\Http\Controllers\Reportes\Asignacion_de_docentes;
use App\Http\Controllers\Reportes\Asistencia_de_docente;

class Pago_docenteController extends Controller
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
        
        $contratos=pago_docente::contratos("vigente"," and estado_contrato_docente='activo'");
        return view("operador.pago_docente.listar")
        ->with("contratos",$contratos);
        
    }
    public function create()
    {        
        $id_contrato_docente=$_GET["id_contrato_docente"];
        $mes=$_GET["mes"];
        $anio=$_GET["anio"];
        $pago_docente=pago_docente::registros_by_tabla("pago_docente","and id_contrato_docente='$id_contrato_docente' and mes='$mes' and anio='$anio'");
        
        if(!empty($pago_docente))
        {
            $id=$pago_docente[0]->id;
            $pago_docente=pago_docente::pago_docente("and pd.id='$id'")[0];
            return view("operador.pago_docente.ver")
            ->with("pago_docente",$pago_docente);
        }
        else
        {
            $contrato=pago_docente::contratos("vigente","and ca.id='$id_contrato_docente'")[0];
            $hora_extra=pago_docente::pago_extra("HORAS EXTRAS",$mes,$anio,$contrato->id_docente);
            $pago_otros=pago_docente::pago_extra("otros",$mes,$anio,$contrato->id_docente);
            $anticipos=pago_docente::descuento("anticipos",$mes,$anio,$contrato->id_docente);
            $descuento_otros=pago_docente::descuento("otros",$mes,$anio,$contrato->id_docente);
            //var_dump($hora_extra);die;
            return view("operador.pago_docente.create")
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
        $pago_docente=new pago_docente();
        $id_contrato_docente=$request->id_contrato_docente;
        $mes=$request->mes;
        $anio=$request->anio;

        
        foreach ($_POST as $key => $value) {
            if($key!="_token"&&$key!="guardar")
            {
                $pago_docente->$key=$value;    
            }        
        }
        $this->capturar_accion();
        $pago_docente->save();
        $this->log("descripcion","pago_docente",$this->sql,$this->cadena);
        
        switch ($request->guardar) {
            case 'Confirmar pago y ver':
                return redirect("pago_docente/create?id_contrato_docente=$id_contrato_docente&mes=$mes&anio=$anio");
                break;
            case 'Confirmar pago y volver a lista':
                return redirect("pago_docente");
                break;
            
            default:
                return redirect("pago_docente");
                break;
        }

    }
    public function reporte($id_pago_docente)
    {

    }
    public function reporte_boleta_pago($id_pago_docente)
    {
        $pago_docente=pago_docente::pago_docente("and pd.id='$id_pago_docente'");
        $reporte=new Boleta_pago();
        $reporte->reporte($pago_docente[0]);
    }

    public function reporte_detalle_boleta_pago($id_pago_docente)
    {
        $pago_docente=pago_docente::pago_docente("and pd.id='$id_pago_docente'");
        $mes=$pago_docente[0]->mes;
        $anio=$pago_docente[0]->anio;
        $id_docente=$pago_docente[0]->id_docente;
        $pago_extra=pago_docente::pago_extra_desglosado($mes,$anio,$id_docente);
        $descuento=pago_docente::descuento_desglosado($mes,$anio,$id_docente);
        $reporte=new Detalle_boleta_pago();
        $reporte->reporte($pago_docente[0],$pago_extra,$descuento);
    }
    
    public function index_reporte_asignacion_de_docente()
    {
        return view("operador.reportes.reporte_asignacion_de_docente");

    }

    public function reporte_asignacion_de_docente()
    {
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];
        
        $asignacion=pago_docente::reporte_asignacion_de_docente($gestion,$periodo_gestion);
        //var_dump($asignacion);

        $reporte=new Asignacion_de_docentes();
        $reporte->reporte($asignacion);
    }
    
    public function index_notificacion()
    {
        $usuario=users::me();
        $id_persona=$usuario->id_persona;
        $notificacion=pago_docente::registros_by_tabla("notificacion_docente","and id_docente='$id_persona' and estado_notificacion_docente='activo' order by updated_at desc");
        
        return view("docente.listar_notificacion")
        ->with("notificacion",$notificacion);
        
    }    

    public function create_notificacion()
    {
        
        $docente=pago_docente::registros_by_tabla("docente","and estado_docente='activo'");
        
        
        return view("docente.create_notificacion")
        ->with("docente",$docente);
        
    }    
    public function store_notificacion(Request $request)
    {
        if($request->id_docente!="")
        {
            $datos=array();
            $datos["notificacion_docente"]=$request->notificacion_docente;
            $datos["id_docente"]=$request->id_docente;
            $datos["created_at"]=date("Y-m-d H:i:s");
            $datos["updated_at"]=date("Y-m-d H:i:s");
            $datos["estado_notificacion_docente"]="activo";
            $datos["estado_revisado"]="no revisado";
            TableModel::insertar("notificacion_docente",$datos);
        }
        else
        {
            $docente=pago_docente::registros_by_tabla("docente","and estado_docente='activo'");
            if(!empty($docente))
            {
                foreach ($docente as $key => $value) {
                    $datos=array();
                    $datos["notificacion_docente"]=$request->notificacion_docente;
                    $datos["id_docente"]=$value->id;
                    $datos["created_at"]=date("Y-m-d H:i:s");
                    $datos["updated_at"]=date("Y-m-d H:i:s");
                    $datos["estado_notificacion_docente"]="activo";
                    $datos["estado_revisado"]="no revisado";
                    TableModel::insertar("notificacion_docente",$datos);           
                }
            }    
        }
        return redirect("docente/create/notificacion");
        
    }    
    public function show_notificacion($id_notificacion)
    {
        
        $notificacion=pago_docente::registros_by_tabla("notificacion_docente","and id='$id_notificacion'");
        if(!empty($notificacion))
        {
            $notificacion=$notificacion[0];
        }
        \DB::select("update notificacion_docente set estado_revisado='revisado' where id='$id_notificacion'");
        return view("docente.ver_notificacion")
        ->with("notificacion",$notificacion);
        
    }   

    public function index_reporte_asistencia_de_docente()
    {
        

        $docente=users::registros_by_tabla("docente","and estado_docente='activo'");
        return view('carrera.reportes.reporte_asistencia_de_docente')
        ->with("docente",$docente);
    }

    public function reporte_asistencia_de_docente()
    {
        $fecha_inicio=$_GET["fecha_inicio"];
        $fecha_fin=$_GET["fecha_fin"];
        $id_docente=$_GET["id_docente"];

        $docente=pago_docente::reporte_asistencia_de_docente($id_docente,$fecha_inicio,$fecha_fin);
        
        $reporte=new Asistencia_de_docente();
        $reporte->reporte($docente,$fecha_inicio,$fecha_fin);
    } 
    
}
