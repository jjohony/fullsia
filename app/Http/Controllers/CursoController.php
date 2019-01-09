<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\curso;
use App\Models\asignatura_mencion_pensum;
use App\Models\Admin\users;

class CursoController extends Controller
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
    public function index_curso($id_carrera)
    {
        
        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera' order by gestion desc,periodo_gestion desc ");
        $pensum=curso::registros_by_tabla("pensum","and estado_pensum='activo' and id_carrera='$id_carrera'");
        $mencion=curso::registros_by_tabla("mencion","and estado_mencion='activo' and id_carrera='$id_carrera'");
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        
        $where="and c.id_carrera='$id_carrera'";
        /*$curso=curso::cursos($id_carrera);
        
        if(!empty($curso)){
            $data=array();
            foreach ($curso as $key => $value) {
                $data[$key]=(array)$value;
            }
            foreach ($curso as $key=>$value) {

                //$notas=$curso->notasByCurso($key["id_curso"]);
                $notas=false;
                if(!$notas){
                    $data[$key]["eliminar"]=1;
                }
                else{
                    $data[$key]["eliminar"]=0;  
                }
                $curso[$key]=(object) $data[$key];
            }   
        }*/
        //var_dump($curso);die;
        return view("carrera.curso.listar")
        //->with("curso",$curso)
        ->with("gestion",$gestion)
        ->with("pensum",$pensum)
        ->with("mencion",$mencion)
        ->with("carrera",$carrera);
    }
    public function create_curso($id_carrera)
    {        
        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera' order by gestion desc, periodo_gestion desc");
        $pensum=curso::registros_by_tabla("pensum","and estado_pensum='activo' and id_carrera='$id_carrera'");
        $mencion=curso::registros_by_tabla("mencion","and estado_mencion='activo' and id_carrera='$id_carrera'");
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $evaluacion=curso::registros_by_tabla("evaluacion","and estado_evaluacion='activo'");
        
        
        
        $where="";
        $curso=curso::cursos($id_carrera);
        //var_dump($curso);
        return view("carrera.curso.create")
        ->with("curso",$curso)
        ->with("evaluacion",$evaluacion)
        ->with("gestion",$gestion)
        ->with("pensum",$pensum)
        ->with("mencion",$mencion)
        ->with("carrera",$carrera);
    }
    public function store_curso(Request $request,$id_carrera)
    {
        $id_asignatura_mencion_pensum=$request->id_asignatura_mencion_pensum;
        $paralelo=$request->paralelo;
        $id_mencion=$request->id_mencion;
        $id_pensum=$request->id_pensum;
        $id_gestion=$request->id_gestion;
        $id_evaluacion=$request->id_evaluacion;
        $turno_curso=$request->turno_curso;
        $cupo=$request->cupo;
        /*var_dump($id_asignatura_mencion);
        var_dump($paralelo);*/
        if(!empty($paralelo)){
            foreach ($paralelo as $key=>$value) {
                if(!empty($id_asignatura_mencion_pensum)){
                    foreach ($id_asignatura_mencion_pensum as $key1=>$value1) {
                        $curso=new curso();
                        $curso->id_docente=null;
                        $curso->id_carrera=$id_carrera;
                        $curso->id_asignatura_mencion_pensum=$value1;
                        $curso->id_evaluacion=$id_evaluacion;
                        $curso->id_gestion=$id_gestion;
                        $curso->turno_curso=$turno_curso;
                        $curso->paralelo_curso=$value;
                        $curso->estado_curso='activo';
                        $curso->cupo_curso=$cupo;
                        $this->capturar_accion();
                        $curso->save();             
                        $this->log("descripcion","curso",$this->sql,$this->cadena);
                    }   
                }
                
            }
        }  

        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/create/curso");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/curso");
                break;
            
            default:
                return redirect("carrera/$id_carrera/curso");
                break;
        }

    }
    public function show_curso($id_carrera,$id_curso)
    {
        $carrera=curso::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=curso::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=curso::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=curso::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        $evaluacion=curso::registros_by_tabla("evaluacion","and estado_evaluacion='activo'");
        $curso=curso::find($id_curso);
        return view("carrera.curso.ver")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("evaluacion",$evaluacion)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum)
        ->with("curso",$curso);
    }
    public function edit_curso($id_carrera,$id_curso)
    {
        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera'");
        $docente=curso::registros_by_tabla("docente","and estado_docente='activo'");
        $evaluacion=curso::registros_by_tabla("evaluacion","and estado_evaluacion='activo'");
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $asignatura_mencion_pensum=asignatura_mencion_pensum::asignatura_mencion_pensum("and a.id_carrera='$id_carrera'");

        
        $curso=curso::find($id_curso);
        //var_dump($docente);die;
        return view("carrera.curso.edit")
        ->with("curso",$curso)
        ->with("gestion",$gestion)
        ->with("evaluacion",$evaluacion)
        ->with("docente",$docente)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("carrera",$carrera);
    }
    public function update_curso(Request $request,$id_carrera,$id_curso)
    {

        $curso= curso::find($id_curso);
        $curso->id_gestion=$request->id_gestion;
        $curso->id_asignatura_mencion_pensum=$request->id_asignatura_mencion_pensum;
        $curso->id_docente=$request->id_docente;
        $curso->paralelo_curso=$request->paralelo_curso;
        $curso->turno_curso=$request->turno_curso;
        $curso->cupo_curso=$request->cupo_curso;
        $curso->id_evaluacion=$request->id_evaluacion;
        $curso->estado_curso='activo';
        
        $this->capturar_accion();
        $curso->save();
        $this->log("descripcion","curso",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/curso/$id_curso/edit");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/curso");
                break;
            
            default:
                return redirect("carrera/$id_carrera/curso");
                break;
        }
    }
    public function delete_curso($id_carrera,$id_curso)
    {
        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera'");
        $docente=curso::registros_by_tabla("docente","and estado_docente='activo'");
        
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $asignatura_mencion_pensum=asignatura_mencion_pensum::asignatura_mencion_pensum("and a.id_carrera='$id_carrera'");
        
        $curso=curso::find($id_curso);
        //var_dump($docente);die;
        return view("carrera.curso.delete")
        ->with("curso",$curso)
        ->with("gestion",$gestion)
        ->with("docente",$docente)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("carrera",$carrera);
    }
    public function destroy_curso(Request $request,$id_carrera,$id_curso)
    {
        
        $curso=curso::find($id_curso);
        $curso->estado_curso="eliminado";

        $this->capturar_accion();
        $curso->save();
        $this->log("descripcion","curso",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/curso");
        //var_dump($curso);
    }

    public function curso_by_parametros(Request $request,$id_carrera)
    {
        $id_gestion=$request->id_gestion;
        $id_pensum=$request->id_pensum;
        $id_mencion=$request->id_mencion;
        $nivel_asignatura=$request->nivel;
        $cursos=curso::curso_by_parametros($id_carrera,$id_gestion,$id_pensum,$id_mencion,$nivel_asignatura);
        
        if(!empty($cursos))
        {
            $data=array();
            foreach ($cursos as $key => $value) {
                $data[$key]=(array)$value;
            }
            $cursos=$data;

            $usuario=users::me();
            foreach ($cursos as $key=>$value) {
                
                $cursos[$key]["notas"]=url('')."/carrera/".$id_carrera."/".$value["id"]."/nota";
                $cursos[$key]["listado"]=url('')."/reporte_lista_de_estudiantes/".$value["id"]."/nota";
                $cursos[$key]["boletin"]=url('')."/reporte_boletin_calificacion/".$value["id"]."/nota";

                
                switch ($usuario->nombre_grupo) {
                    case 'academico':
                        if($cursos[$key]["modalidad_asignatura"]=="anual")
                        {
                            $cursos[$key]["boletin_anual"]=url('')."/reporte/reporte_boleta_de_calificaciones_dividido_por_semestre/$id_carrera/".$value["id"];
                        }
                        $cursos[$key]["editar"]=url('')."/carrera/".$id_carrera."/curso/".$value["id"]."/edit";
                        
                        $cursos[$key]["eliminar"]=url('')."/carrera/".$id_carrera."/curso/".$value["id"]."/delete";
                        break;
                    case 'docente':
                        $cursos[$key]["asistencia"]=url('')."/carrera/".$id_carrera."/".$value["id"]."/asistencia";
                        
                        
                        break;
                    
                    default:
                        # code...
                        break;
                }
                
                
                
            }
        }
        
        echo json_encode($cursos);
    }    
    public function buscar_asignaturas_nivel_mencion_pensum(Request $request,$id_carrera){
        
        
        $nivel = $request->nivel;
        $id_mencion = $request->id_mencion;
        $id_pensum = $request->id_pensum;
        

        $asignaturas = curso::buscar_asignaturas_nivel_mencion_pensum($id_carrera,$nivel,$id_mencion,$id_pensum);
        
        echo json_encode($asignaturas);   
    }
    
    
}
