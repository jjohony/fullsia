<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inscripcion;
use App\Models\curso;
use App\Models\asignatura_mencion_pensum;


class InscripcionController extends Controller
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
    public function index($id_carrera,$id_estudiante,$id_gestion)
    {
        $inscripcion=inscripcion::inscripcion($id_carrera,$id_estudiante,$id_gestion);
        if(!empty($inscripcion))
        {
            return redirect("carrera/$id_carrera/estudiante/$id_estudiante/gestion/$id_gestion/inscripcion_concluida");    
        }
        
        $carrera=inscripcion::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $gestion=inscripcion::registros_by_tabla("gestion","and estado_gestion='activo' and id='$id_gestion' order by gestion desc, periodo_gestion desc")[0];
        $estudiante=inscripcion::registros_by_tabla("estudiante","and id='$id_estudiante'")[0];
        $asignatura_mencion_pensum=inscripcion::asignatura_mencion_pensum("and a.id_carrera='$id_carrera' order by amp.nivel_asignatura");
        //var_dump($asignatura_mencion_pensum);die;
        $nota=inscripcion::notas_by_carrera_and_estudiante($id_carrera,$id_estudiante);
        //var_dump($nota);die;

        return view("carrera.inscripcion.listar")
        ->with("carrera",$carrera)
        ->with("gestion",$gestion)
        ->with("estudiante",$estudiante)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("nota",$nota);
    }
    public function create($id_carrera)
    {        

        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera' order by gestion desc, periodo_gestion desc");
        $pensum=curso::registros_by_tabla("pensum","and estado_pensum='activo' and id_carrera='$id_carrera'");
        $mencion=curso::registros_by_tabla("mencion","and estado_mencion='activo' and id_carrera='$id_carrera'");
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        
        $where="";
        $curso=curso::cursos($id_carrera);
        //var_dump($curso);
        return view("carrera.curso.create")
        ->with("curso",$curso)
        ->with("gestion",$gestion)
        ->with("pensum",$pensum)
        ->with("mencion",$mencion)
        ->with("carrera",$carrera);
    }
    public function store(Request $request,$id_carrera,$id_estudiante,$id_gestion)
    {
        if(!empty($request->id_curso))
        {
            foreach ($request->id_curso as $key => $value) {
                if($value)
                {
                    $inscripcion=new inscripcion();
                    $inscripcion->id_estudiante=$id_estudiante;
                    $inscripcion->id_curso=$value;
                    $inscripcion->id_carrera=$id_carrera;
                    $inscripcion->retiro_adicion='regular';
                    $inscripcion->estado_inscrito='inscrito';
                    $inscripcion->estado_nota='activo';

                    $this->capturar_accion();
                    $inscripcion->save();    
                    $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
                }
                
            }
        }
        return redirect("carrera/$id_carrera/estudiante/$id_estudiante/gestion/$id_gestion/inscripcion_concluida");
        
    }
    public function concluido($id_carrera,$id_estudiante,$id_gestion)
    {
        $carrera=inscripcion::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $gestion=inscripcion::registros_by_tabla("gestion","and estado_gestion='activo' and id='$id_gestion'")[0];
        $estudiante=inscripcion::registros_by_tabla("estudiante","and id='$id_estudiante'")[0];
        
        $inscripcion=inscripcion::inscripcion($id_carrera,$id_estudiante,$id_gestion);
        //var_dump($inscripcion);die;
        
        return view("carrera.inscripcion.concluido")
        ->with("carrera",$carrera)
        ->with("gestion",$gestion)
        ->with("estudiante",$estudiante)
        ->with("inscripcion",$inscripcion);
    }
    public function show($id_carrera,$id)
    {
        $carrera=curso::registros_by_tabla("carrera","and id='$id_carrera'")[0];
        $asignatura=curso::registros_by_tabla("asignatura","and id_carrera='$id_carrera'");
        $mencion=curso::registros_by_tabla("mencion","and id_carrera='$id_carrera'");
        $pensum=curso::registros_by_tabla("pensum","and id_carrera='$id_carrera'");
        $curso=curso::find($id);
        return view("carrera.curso.ver")
        ->with("carrera",$carrera)
        ->with("asignatura",$asignatura)
        ->with("mencion",$mencion)
        ->with("pensum",$pensum)
        ->with("curso",$curso);
    }
    public function edit($id_carrera,$id)
    {
        $gestion=curso::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera'");
        $docente=curso::registros_by_tabla("docente","and estado_docente='activo'");
        
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $asignatura_mencion_pensum=asignatura_mencion_pensum::asignatura_mencion_pensum("and a.id_carrera='$id_carrera'");
        
        $curso=curso::find($id);
        //var_dump($docente);die;
        return view("carrera.curso.edit")
        ->with("curso",$curso)
        ->with("gestion",$gestion)
        ->with("docente",$docente)
        ->with("asignatura_mencion_pensum",$asignatura_mencion_pensum)
        ->with("carrera",$carrera);
    }
    public function update(Request $request,$id_carrera,$id)
    {

        $curso= curso::find($id);
        $curso->id_gestion=$request->id_gestion;
        $curso->id_asignatura_mencion_pensum=$request->id_asignatura_mencion_pensum;
        $curso->id_docente=$request->id_docente;
        $curso->paralelo=$request->paralelo;
        $curso->turno=$request->turno;
        $curso->cupo=$request->cupo;
        $curso->estado='activo';
        $this->capturar_accion();
        $curso->save();
        $this->log("descripcion","curso",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/curso/$id/edit");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/curso");
                break;
            
            default:
                return redirect("carrera/$id_carrera/curso");
                break;
        }
    }
    public function delete($id_carrera,$id_estudiante,$id_gestion,$id_inscripcion)
    {
        $inscripcion=inscripcion::find($id_inscripcion);
        $inscripcion->estado_nota='eliminado';
        $this->capturar_accion();
        $inscripcion->save();
        $this->log("descripcion","nota_inscripcion",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/estudiante/$id_estudiante/gestion/$id_gestion/inscripcion");
    }
    public function destroy(Request $request,$id_carrera,$id)
    {
        
        $curso=curso::find($id);
        $curso->estado="eliminado";
        $this->capturar_accion();
        $curso->save();
        $this->log("descripcion","curso",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/curso");
        //var_dump($curso);
    }

    public function formulario(Request $request,$id_carrera)
    {
        $carrera=inscripcion::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=inscripcion::registros_by_tabla("estudiante","and estado_estudiante='activo'");
        $gestion=inscripcion::registros_by_tabla("gestion","and estado_gestion='activo' and id_carrera='$id_carrera' order by gestion desc, periodo_gestion desc");
        return view("carrera.inscripcion.formulario")
        ->with("estudiante",$estudiante)
        ->with("carrera",$carrera)
        ->with("gestion",$gestion);
    }
    public function inscripcion_formulario(Request $request,$id_carrera)
    {
        $carrera=inscripcion::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $id_estudiante=$request->id_estudiante;
        $id_gestion=$request->id_gestion;
        return redirect("carrera/$id_carrera/estudiante/$id_estudiante/gestion/$id_gestion/inscripcion");
    }
    
}
