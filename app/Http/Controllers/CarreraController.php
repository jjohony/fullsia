<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asignatura_mencion_pensum;
use App\Models\pre_requisito;
use App\Models\estudiante;
use App\Models\curso;
use App\Http\Controllers\Reportes\Estudiantes_por_carrera;
use App\Http\Controllers\Reportes\Cantidad_de_estudiantes;
use App\Http\Controllers\Reportes\Estadisticas_de_estudiantes;
use App\Http\Controllers\Reportes\Estadisticas_de_estudiantes_por_carrera;
use App\Http\Controllers\Reportes\Historial_academico;
use App\Http\Controllers\Reportes\Centralizador_de_calificaciones;
use App\Http\Controllers\Reportes\Boleta_inscripcion;
use App\Http\Controllers\Reportes\Boleta_de_asignacion_de_materias;
use App\Http\Controllers\Reportes\Boleta_de_calificaciones_dividido_por_semestre;
class CarreraController extends Controller
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
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carreras")
        ->with("carrera",$carrera);
    }
    public function index_asignatura_mencion_pensum($id_carrera)
    {
        $where="and a.id_carrera='$id_carrera'";
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura_mencion_pensum=asignatura_mencion_pensum::asignatura_mencion_pensum($where);
        //var_dump($asignatura_mencion_pensum);
        return view("carrera.asignatura_mencion_pensum.listar")
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("carrera",$carrera);
    }
    public function create_asignatura_mencion_pensum($id_carrera)
    {
        
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=asignatura_mencion_pensum::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=asignatura_mencion_pensum::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=asignatura_mencion_pensum::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        
        return view("carrera.asignatura_mencion_pensum.create")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum);
    }
    public function store_asignatura_mencion_pensum(Request $request,$id_carrera)
    {
        $asignatura_mencion_pensum=new asignatura_mencion_pensum();
        $asignatura_mencion_pensum->id_asignatura=$request->id_asignatura;
        $asignatura_mencion_pensum->id_mencion=$request->id_mencion;
        $asignatura_mencion_pensum->id_pensum=$request->id_pensum;
        $asignatura_mencion_pensum->nivel_asignatura=$request->nivel_asignatura;
        $asignatura_mencion_pensum->modalidad_asignatura=$request->modalidad_asignatura;
        $asignatura_mencion_pensum->horas=$request->horas;
        $asignatura_mencion_pensum->label_prerequisito=$request->label_prerequisito; 
        $asignatura_mencion_pensum->estado_asignatura_mencion_pensum='activo';
        $this->capturar_accion();
        $asignatura_mencion_pensum->save();
        $this->log("descripcion","asignatura_mencion_pensum",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/create/plan_estudio");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/plan_estudio");
                break;
            
            default:
                return redirect("carrera/$id_carrera/plan_estudio");
                break;
        }

    }
    public function show_asignatura_mencion_pensum($id_carrera,$id_asignatura_mencion_pensum)
    {
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=asignatura_mencion_pensum::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=asignatura_mencion_pensum::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=asignatura_mencion_pensum::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($id_asignatura_mencion_pensum);
        return view("carrera.asignatura_mencion_pensum.ver")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum);
    }
    public function edit_asignatura_mencion_pensum($id_carrera,$id_asignatura_mencion_pensum)
    {
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=asignatura_mencion_pensum::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=asignatura_mencion_pensum::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=asignatura_mencion_pensum::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($id_asignatura_mencion_pensum);
        return view("carrera.asignatura_mencion_pensum.edit")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum);
    }
    public function update_asignatura_mencion_pensum(Request $request,$id_carrera,$id_asignatura_mencion_pensum)
    {
        $asignatura_mencion_pensum= asignatura_mencion_pensum::find($id_asignatura_mencion_pensum);
        $asignatura_mencion_pensum->id_asignatura=$request->id_asignatura;
        $asignatura_mencion_pensum->id_mencion=$request->id_mencion;
        $asignatura_mencion_pensum->id_pensum=$request->id_pensum;
        $asignatura_mencion_pensum->nivel_asignatura=$request->nivel_asignatura;
        $asignatura_mencion_pensum->modalidad_asignatura=$request->modalidad_asignatura;
        $asignatura_mencion_pensum->horas=$request->horas;
        $asignatura_mencion_pensum->label_prerequisito=$request->label_prerequisito; 
        $asignatura_mencion_pensum->estado_asignatura_mencion_pensum='activo';
        
        $this->capturar_accion();
        $asignatura_mencion_pensum->save();
        $this->log("descripcion","asignatura_mencion_pensum",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/plan_estudio/$id_asignatura_mencion_pensum/edit");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/plan_estudio");
                break;
            
            default:
                return redirect("carrera/$id_carrera/plan_estudio");
                break;
        }
    }
    public function delete_asignatura_mencion_pensum($id_carrera,$id_asignatura_mencion_pensum)
    {
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=asignatura_mencion_pensum::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=asignatura_mencion_pensum::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=asignatura_mencion_pensum::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($id_asignatura_mencion_pensum);
        return view("carrera.asignatura_mencion_pensum.delete")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum);
    }
    public function destroy_asignatura_mencion_pensum(Request $request,$id_carrera,$id_asignatura_mencion_pensum)
    {
        
        
        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($id_asignatura_mencion_pensum);
        $asignatura_mencion_pensum->estado_asignatura_mencion_pensum="eliminado";
        $this->capturar_accion();
        $asignatura_mencion_pensum->save();
        $this->log("descripcion","asignatura_mencion_pensum",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/plan_estudio");
        //var_dump($asignatura_mencion_pensum);
        
    }

    /*pre_requisito*/
    public function index_pre_requisito($id_carrera,$id_asignatura_mencion_pensum)
    {
        
        $carrera=asignatura_mencion_pensum::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        
        $asignatura=asignatura_mencion_pensum::asignatura_by_id_asignatura_mencion_pensum($id_asignatura_mencion_pensum)[0];
        $nivel_asignatura=$asignatura->nivel_asignatura;
        //var_dump($nivel_asignatura);die;
        $mencion=asignatura_mencion_pensum::registros_by_tabla("mencion","and id='".$asignatura->id_mencion."'")[0];

        if($mencion->mencion!="REGULAR")
        {
            $where="AND a.id_carrera='$id_carrera' 
                    AND p.id='".$asignatura->id_pensum."'
                    AND amp.nivel_asignatura<$nivel_asignatura 
                    and (m.mencion='REGULAR' OR m.id='".$mencion->id."') ";        
        }
        else
        {
            $where="AND a.id_carrera='$id_carrera' 
                    AND p.id='".$asignatura->id_pensum."'
                    AND amp.nivel_asignatura<$nivel_asignatura ";        
        }
        
        $asignatura_mencion_pensum=asignatura_mencion_pensum::asignatura_mencion_pensum($where);
        //var_dump($asignatura_mencion_pensum); die;
        return view("carrera.pre_requisito.listar")
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("carrera",$carrera);
    }

    public function guardar_pre_requisito($id_pre_requisito_amp,$id_amp)
    {
        $pre_requisito=pre_requisito::verificar_pre_requisito($id_pre_requisito_amp,$id_amp);
        if(!empty($pre_requisito))
        {
            $pre_requisito=pre_requisito::find($pre_requisito[0]->id);

            $this->capturar_accion();
            $pre_requisito->delete();
            $this->log("descripcion","pre_requisito",$this->sql,$this->cadena);
        }
        else
        {
            $pre_requisito=new pre_requisito();
            $pre_requisito->id_pre_requisito_asignatura_mencion_pensum=$id_pre_requisito_amp;
            $pre_requisito->id_asignatura_mencion_pensum=$id_amp;

            $this->capturar_accion();
            $pre_requisito->save();
            $this->log("descripcion","pre_requisito",$this->sql,$this->cadena);
        }
        echo json_encode(array("estatus"=>"202"));
    }

    public function index_reporte_estudiantes_por_carrera()
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_estudiantes_por_carrera")
        ->with("carrera",$carrera);
    }
    public function reporte_estudiantes_por_carrera()
    {
        $id_carrera=$_GET["id_carrera"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $estudiante=estudiante::reporte_estudiantes_por_carrera($id_carrera,$gestion,$periodo_gestion);
        $reporte=new Estudiantes_por_carrera();
        $reporte->reporte($estudiante,$carrera);
    }

    public function index_reporte_cantidad_de_estudiantes()
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_cantidad_de_estudiantes")
        ->with("carrera",$carrera);
    }
    public function reporte_cantidad_de_estudiantes()
    {
        $id_carrera=$_GET["id_carrera"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $estudiante=estudiante::reporte_cantidad_de_estudiantes($id_carrera,$gestion,$periodo_gestion);
        $reporte=new Cantidad_de_estudiantes();
        $reporte->reporte($estudiante,$carrera);
    }
    
    public function index_reporte_estadisticas_de_estudiantes()
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_estadisticas_de_estudiantes")
        ->with("carrera",$carrera);
    }
    public function reporte_estadisticas_de_estudiantes()
    {
        $id_carrera=$_GET["id_carrera"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $estudiante=estudiante::reporte_estadisticas_de_estudiantes($id_carrera,$gestion,$periodo_gestion);
        $estudiante_detalle=estudiante::reporte_estadisticas_de_estudiantes_detalle($id_carrera,$gestion,$periodo_gestion);
        $reporte=new Estadisticas_de_estudiantes();
        $reporte->reporte($estudiante,$estudiante_detalle,$carrera);
    }

    public function index_reporte_estadisticas_de_estudiantes_por_carreras()
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_estadisticas_de_estudiantes_por_carrera")
        ->with("carrera",$carrera);
    }
    public function reporte_estadisticas_de_estudiantes_por_carreras()
    {
        
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];

        
        $estudiante=estudiante::reporte_estadisticas_de_estudiantes_por_carreras($gestion,$periodo_gestion);
        $reporte=new Estadisticas_de_estudiantes_por_carrera();
        $reporte->reporte($estudiante);
    }

    public function index_reporte_historial_academico()
    {
        $estudiante=estudiante::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_historial_academico")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    public function reporte_historial_academico()
    {
        
        $id_carrera=$_GET["id_carrera"];
        $id_estudiante=$_GET["id_estudiante"];
        
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $estudiante=estudiante::estudiante_and_usuario($id_estudiante)[0];

        $nota=estudiante::reporte_historial_academico($id_carrera,$id_estudiante);
        $reporte=new Historial_academico();
        $reporte->reporte($carrera,$estudiante,$nota);
    }


    public function index_reporte_centralizador_de_calificaciones()
    {
        $estudiante=estudiante::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_centralizador_de_calificaciones")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    public function reporte_centralizador_de_calificaciones()
    {
        
        $id_carrera=$_GET["id_carrera"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];
        
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        

        $nivel_asignatura=estudiante::reporte_centralizador_de_calificaciones($id_carrera,$gestion,$periodo_gestion);

        $reporte=new Centralizador_de_calificaciones();
        $reporte->reporte($carrera,$nivel_asignatura);
    }

    public function index_reporte_boleta_inscripcion()
    {
        $estudiante=estudiante::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_boleta_inscripcion")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    public function reporte_boleta_inscripcion()
    {
        
        $id_carrera=$_GET["id_carrera"];
        $id_estudiante=$_GET["id_estudiante"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];

        $estudiante=estudiante::reporte_boleta_inscripcion($id_estudiante,$id_carrera,$gestion,$periodo_gestion);
        $reporte=new Boleta_inscripcion();
        $reporte->reporte($estudiante);
    }

    public function index_reporte_boleta_de_asignacion_de_materias()
    {
        $estudiante=estudiante::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo'");
        return view("carrera.reportes.reporte_boleta_de_asignacion_de_materias")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    public function reporte_boleta_de_asignacion_de_materias()
    {
        
        $id_carrera=$_GET["id_carrera"];
        $id_estudiante=$_GET["id_estudiante"];
        $gestion=$_GET["gestion"];
        $periodo_gestion=$_GET["periodo_gestion"];

        $estudiante=estudiante::reporte_boleta_de_asignacion_de_materias($id_estudiante,$id_carrera,$gestion,$periodo_gestion);
        $reporte=new Boleta_de_asignacion_de_materias();
        $reporte->reporte($estudiante);
    }

    
    public function reporte_boleta_de_calificaciones_dividido_por_semestre($id_carrera,$id_curso)
    {
        $carrera=estudiante::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $curso=curso::curso($id_carrera,$id_curso);

        $id_evaluacion=$curso->id_evaluacion;


        $evaluacion=estudiante::registros_by_tabla("evaluacion","and id='$id_evaluacion'");
        if(empty($evaluacion))
        {
            return redirect("carrera/$id_carrera/curso/$id_curso/edit");    
        }
        $evaluacion=$evaluacion[0];
        $notas=estudiante::reporte_boleta_de_calificaciones_dividido_por_semestre($id_curso);
        $reporte=new Boleta_de_calificaciones_dividido_por_semestre();
        $reporte->reporte($carrera,$curso,$notas,$evaluacion);
    }

}
