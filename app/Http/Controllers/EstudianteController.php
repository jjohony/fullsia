<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nota;
use App\Models\curso;
use App\Models\cuota;
use App\Models\asistencia;
use App\Models\estudiante;
use App\Models\asignatura_mencion_pensum;
use App\Http\Controllers\Reportes\Asistencia_de_estudiantes;


class EstudianteController extends Controller
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
    public function index_estudiante($id_carrera)
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=estudiante::estudiante_by_carrera($id_carrera);   
        return view("carrera.estudiante.listar")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    
    public function index_nota($id_carrera,$id_estudiante)
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        
        $estudiante=estudiante::find($id_estudiante);

        $nota=estudiante::nota_by_carrera_and_estudiante($id_carrera,$id_estudiante);       
               
        return view("carrera.estudiante.listar_nota")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("nota",$nota);
    }
    public function index_nota_actuales($id_carrera,$id_estudiante)
    {
        $carrera=estudiante::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        
        $estudiante=estudiante::find($id_estudiante);

        $nota=estudiante::nota_actuales_by_carrera_and_estudiante($id_carrera,$id_estudiante);       
               
        return view("carrera.estudiante.listar_nota")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("nota",$nota);
    }

    public function index_cuota($id_carrera,$id_estudiante)
    {
        $carrera=cuota::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        
        $estudiante=estudiante::find($id_estudiante);

        $cuota=cuota::cuotas_by_carrera_and_estudiante($id_carrera,$id_estudiante);
        
        
        //var_dump($curso);die;
        return view("carrera.cuota.listar")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("cuota",$cuota);
    }
    public function create_cuota($id_carrera,$id_estudiante)
    {        
        
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=estudiante::find($id_estudiante);
        
        
        //var_dump($curso);
        return view("carrera.cuota.create")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante);
    }
    public function store_cuota(Request $request,$id_carrera,$id_estudiante)
    {
        $cuota=new cuota();
        $cuota->id_carrera=$id_carrera;
        $cuota->id_estudiante=$id_estudiante;
        $cuota->mes=$request->mes;
        $cuota->anio=$request->anio;
        $cuota->monto=$request->monto;
        $cuota->fecha_registro=$request->fecha_registro;
        $cuota->estado_cuota="activo";
        
        $this->capturar_accion();
        $cuota->save();
        $this->log("descripcion","cuota",$this->sql,$this->cadena);

        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/create/cuota");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota");
                break;
            
            default:
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota");
                break;
        }

    }
    public function show_cuota($id_carrera,$id_estudiante,$id_cuota)
    {
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=estudiante::find($id_estudiante);
        $cuota=cuota::find($id_cuota);
        
        //var_dump($curso);
        return view("carrera.cuota.ver")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("cuota",$cuota);
    }
    public function edit_cuota($id_carrera,$id_estudiante,$id_cuota)
    {
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=estudiante::find($id_estudiante);
        $cuota=cuota::find($id_cuota);
        
        //var_dump($curso);
        return view("carrera.cuota.editar")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("cuota",$cuota);
    }
    public function update_cuota(Request $request,$id_carrera,$id_estudiante,$id_cuota)
    {

        $cuota= cuota::find($id_cuota);
        $cuota->mes=$request->mes;
        $cuota->anio=$request->anio;
        $cuota->monto=$request->monto;
        $cuota->fecha_registro=$request->fecha_registro;

        $this->capturar_accion();
        $cuota->save();
        $this->log("descripcion","cuota",$this->sql,$this->cadena);

        switch ($request->guardar) {
            case 'Guardar':
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota/$id_cuota/edit");
                break;
            case 'Guardar y Listar':
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota");
                break;
            
            default:
                return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota");
                break;
        }
    }
    public function delete_cuota($id_carrera,$id_estudiante,$id_cuota)
    {
        $carrera=curso::registros_by_tabla("carrera","and estado_carrera='activo' and id='$id_carrera'")[0];
        $estudiante=estudiante::find($id_estudiante);
        $cuota=cuota::find($id_cuota);
        
        //var_dump($curso);
        return view("carrera.cuota.delete")
        ->with("carrera",$carrera)
        ->with("estudiante",$estudiante)
        ->with("cuota",$cuota);
    }
    public function destroy_cuota(Request $request,$id_carrera,$id_estudiante,$id_cuota)
    {
        
        $cuota=cuota::find($id_cuota);
        $cuota->estado_cuota="eliminado";

        $this->capturar_accion();
        $cuota->save();
        $this->log("descripcion","cuota",$this->sql,$this->cadena);
        return redirect("carrera/$id_carrera/estudiante/$id_estudiante/cuota");
        //var_dump($curso);
    }

    public function reporte_asistencia_de_estudiantes($id_curso)
    {

        $curso=nota::curso_by_id($id_curso);
        $fecha=estudiante::reporte_asistencia_de_estudiantes_fechas($id_curso);
        $estudiante=estudiante::reporte_asistencia_de_estudiantes_estudiantes($id_curso);
        $reporte=new Asistencia_de_estudiantes();
        $reporte->reporte($curso,$fecha,$estudiante);
    }

    
}
