<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nota;
use App\Models\curso;
use App\Models\asistencia;
use App\Models\Admin\users;
use App\Models\asignatura_mencion_pensum;
use App\Http\Controllers\Reportes\Boletin_calificaciones;
use App\Http\Controllers\Reportes\Lista_de_estudiantes;

class NotaController extends Controller
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
    public function index_nota($id_carrera,$id_curso)
    {
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];

        $curso=curso::find($id_curso);
        $id_evaluacion=$curso->id_evaluacion;
        $evaluacion=nota::registros_by_tabla("evaluacion","and estado_evaluacion='activo' and id='$id_evaluacion'")[0];

        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($curso->id_asignatura_mencion_pensum);
        $mencion=nota::registros_by_tabla("mencion","and id='".$asignatura_mencion_pensum->id_mencion."'")[0];

        $where="AND a.id_carrera='$id_carrera' 
                AND a.id='".$asignatura_mencion_pensum->id_asignatura."'
                AND p.id='".$asignatura_mencion_pensum->id_pensum."'";        
        
        
        $asignatura=asignatura_mencion_pensum::asignatura_mencion_pensum($where)[0];
        $nota=nota::notas($id_carrera,$id_curso,"and n.estado_nota='activo'");
        
        
        
        return view("carrera.nota.listar")
        ->with("carrera",$carrera)
        ->with("mencion",$mencion)
        ->with("evaluacion",$evaluacion)
        ->with("asignatura",$asignatura)
        ->with("notas",$nota)
        ->with("curso",$curso);
    }
    public function create_nota($id_carrera,$id_curso)
    {        
        $estudiante=nota::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo'")[0];
        $curso=curso::find($id_curso);
        //var_dump($nota);
        return view("carrera.nota.create")
        ->with("estudiante",$estudiante)
        ->with("carrera",$carrera)
        ->with("curso",$curso);
    }
    public function store_nota(Request $request,$id_carrera,$id_curso)
    {
        
        $nota=new nota();
        $nota->id_estudiante=$request->id_estudiante;
        $nota->id_curso=$id_curso;
        $nota->id_carrera=$id_carrera;
        $nota->nota_final=$request->nota_final;
        $nota->segundo_turno=$request->segundo_turno;
        $nota->observacion_estudiante=$request->observacion_estudiante;
        $nota->retiro_adicion=$request->retiro_adicion;
        $nota->estado_inscrito=$request->estado_inscrito;
        $nota->estado_nota=$request->estado_nota;
        
        $this->capturar_accion();
        $nota->save();
        $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);

        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/$id_curso/create/nota");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/$id_curso/nota");
                break;
            
            default:
                return redirect("carrera/$id_carrera/$id_curso/nota");
                break;
        }

    }
    public function show_nota($id_carrera,$id_curso,$id_nota)
    {
        $estudiante=nota::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo'")[0];
        $curso=curso::find($id_curso);
        $nota=nota::find($id_nota);
        //var_dump($nota);
        return view("carrera.nota.ver")
        ->with("estudiante",$estudiante)
        ->with("carrera",$carrera)
        ->with("curso",$curso)
        ->with("nota",$nota);
    }
    public function edit_nota($id_carrera,$id_curso,$id_nota)
    {
        $estudiante=nota::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo'")[0];
        $curso=curso::find($id_curso);
        $nota=nota::find($id_nota);
        //var_dump($nota);
        return view("carrera.nota.edit")
        ->with("estudiante",$estudiante)
        ->with("carrera",$carrera)
        ->with("curso",$curso)
        ->with("nota",$nota);
    }
    public function update_nota(Request $request,$id_carrera,$id_curso,$id_nota)
    {
        $nota=nota::find($id_nota);
        $nota->id_estudiante=$request->id_estudiante;
        $nota->id_curso=$id_curso;
        $nota->id_carrera=$id_carrera;
        
        $nota->observacion_estudiante=$request->observacion_estudiante;
        $nota->retiro_adicion=$request->retiro_adicion;
        $nota->estado_inscrito=$request->estado_inscrito;
        $nota->estado_nota=$request->estado_nota;
        
        $this->capturar_accion();
        $nota->save();
        $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/$id_curso/nota/$id_nota/edit");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/$id_curso/nota");
                break;
            
            default:
                return redirect("carrera/$id_carrera/$id_curso/nota");
                break;
        }
        
    }
    public function delete_nota($id_carrera,$id_curso,$id_nota)
    {
        $estudiante=nota::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo'")[0];
        $curso=curso::find($id_curso);
        $nota=nota::find($id_nota);
        //var_dump($nota);
        return view("carrera.nota.delete")
        ->with("estudiante",$estudiante)
        ->with("carrera",$carrera)
        ->with("curso",$curso)
        ->with("nota",$nota);
    }
    public function destroy_nota(Request $request,$id_carrera,$id_curso,$id_nota)
    {
        
        $nota=nota::find($id_nota);
        $nota->estado_nota="eliminado";
        
        $this->capturar_accion();
        $nota->save();
        $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/$id_curso/nota");
        //var_dump($nota);
    }

    public function guardar_nota(Request $request)
    {
        $usuario=users::me();
        if($usuario->nombre_grupo!="docente")
        {
            echo json_encode(array("status"=>200));
            return;
        }
        //var_dump($request->id_nota);die;
        $nota=nota::find($request->id_nota);  
        $curso=curso::find ($nota->id_curso);
        $id_evaluacion=$curso->id_evaluacion;
        $evaluacion=nota::registros_by_tabla("evaluacion","and estado_evaluacion='activo' and id='$id_evaluacion'")[0];


        if($nota->estado_inscrito=="inscrito")
        {
            if(!empty($_POST))
            {
                $nota_total=0;
                foreach ($_POST as $key => $value) {
                    if($key!="_token"&&$key!="id_nota"&&$key!="nota_final"&&$key!="segundo_turno")
                    {
                        $nota->$key=$value;            
                        $nota_total=$nota_total+$value;
                    }
                    
                }
            }
            if($nota_total!=0&&$evaluacion->evaluacion=="ANUAL")
            {
                $nota_total=floor($nota_total/2);
            }
            $nota->nota_final=$nota_total;
            $nota->segundo_turno=$request->segundo_turno;    

            $this->capturar_accion();
            $nota->save();    
            $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
        }
        
        $nota=nota::find($nota->id);
        echo json_encode(array("status"=>200,"nota"=>$nota));
        
    }    
    public function index_asistencia($id_carrera,$id_curso)
    {
        $carrera=nota::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $curso=curso::find($id_curso);
        $asignatura_mencion_pensum=asignatura_mencion_pensum::find($curso->id_asignatura_mencion_pensum);
        $mencion=nota::registros_by_tabla("mencion","and id='".$asignatura_mencion_pensum->id_mencion."'")[0];

        $where="AND a.id_carrera='$id_carrera' 
                AND a.id='".$asignatura_mencion_pensum->id_asignatura."'
                AND p.id='".$asignatura_mencion_pensum->id_pensum."'";        
        
        
        $asignatura=asignatura_mencion_pensum::asignatura_mencion_pensum($where)[0];
        $nota=nota::notas($id_carrera,$id_curso,"and n.estado_nota='activo'");
        
        
        
        return view("carrera.asistencia.listar")
        ->with("carrera",$carrera)
        ->with("mencion",$mencion)
        ->with("asignatura",$asignatura)
        ->with("notas",$nota)
        ->with("curso",$curso);
    }

    public function guardar_asistencia(Request $request)
    {
        $where="and id_curso='".$request->id_curso."' and id_estudiante='".$request->id_estudiante."' and fecha='".date("Y-m-d")."'";
        $asistencia=asistencia::registros_by_tabla("asistencia",$where);       
        if(!empty($asistencia))
        {
            $asistencia=asistencia::find($asistencia[0]->id);
            $asistencia->estado_asistencia=($asistencia->estado_asistencia=="activo")?"eliminado":"activo";
            $this->capturar_accion();
            $asistencia->save();
            $this->log("descripcion","asistencia",$this->sql,$this->cadena);
        }
        else
        {
            $asistencia=new asistencia();
            $asistencia->id_curso=$request->id_curso;
            $asistencia->id_estudiante=$request->id_estudiante;
            $asistencia->fecha=date("Y-m-d");
            $asistencia->estado_asistencia="activo";
            $this->capturar_accion();
            $asistencia->save();   
            $this->log("descripcion","asistencia",$this->sql,$this->cadena);
        }
        echo json_encode(array("status"=>200));   
    }
    public function estado_inscrito($id_carrera,$id_curso,$estado)
    {
        $nota=nota::registros_by_tabla("nota_inscripcion","and id_curso='$id_curso' and estado_nota='activo'");
        if(!empty($nota))
        {
            foreach ($nota as $key => $value) {
                $nota_inscripcion=nota::find($value->id);
                $nota_inscripcion->estado_inscrito=$estado;
                $this->capturar_accion();
                $nota_inscripcion->save();
                $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
                
            }    
        }
        return redirect("carrera/$id_carrera/$id_curso/nota");
        
    }
    public function reporte_boletin_calificacion($id_curso)
    {
        $curso=nota::curso_by_id($id_curso);
        $id_evaluacion=$curso->id_evaluacion;
        $evaluacion=nota::registros_by_tabla("evaluacion","and estado_evaluacion='activo' and id='$id_evaluacion'")[0];        
        $notas=nota::notas($curso->id_carrera,$id_curso,"and n.estado_nota='activo' and n.estado_inscrito='nota'");
        $reporte=new Boletin_calificaciones();
        $reporte->reporte($curso,$notas,$evaluacion);
    }

    public function reporte_lista_de_estudiantes($id_curso)
    {
        $curso=nota::curso_by_id($id_curso);
        $notas=nota::notas($curso->id_carrera,$id_curso,"and n.estado_nota='activo'");
        $reporte=new Lista_de_estudiantes();
        $reporte->reporte($curso,$notas);
    }

    
}
