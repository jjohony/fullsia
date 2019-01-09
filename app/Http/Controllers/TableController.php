<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableModel;
use Storage;
class TableController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nombre_tabla)
    {
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        $registros=TableModel::registros_by_tabla($nombre_tabla,"and estado_".$nombre_tabla."='activo'");
        return view("table.listar")
        ->with("columnas",$columnas)
        ->with("registros",$registros)
        ->with("nombre_tabla",$nombre_tabla);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nombre_tabla)
    {
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        return view('table.create')
        ->with("columnas",$columnas)
        ->with("nombre_tabla",$nombre_tabla);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$nombre_tabla)
    {
        $registro=(object) array();
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        foreach ($columnas as $key => $value) {
            $nombre_campo=$value->COLUMN_NAME;
            if($nombre_campo=="id")
            {
                $registro->$nombre_campo=TableModel::max_id_by_tabla($nombre_tabla)+1;    
            }
            else if(strpos($nombre_campo,"_imagen")!==false)
            {
                if($request->$nombre_campo)
                {
                    $imagen_=$request->$nombre_campo;
                    $nombre_imagen=time()."_".$imagen_->getClientOriginalName();            
                    Storage::disk("img")->put($nombre_imagen,file_get_contents($imagen_->getRealPath()));            
                    $registro->$nombre_campo=$nombre_imagen;    
                }
                
                
            }
            else
            {
                $registro->$nombre_campo=($request->$nombre_campo!='')?$request->$nombre_campo:null;    
            }            
        }
        
        $registro->created_at=date("Y-m-d H:i:s");
        $registro->updated_at=date("Y-m-d H:i:s");
        TableModel::insertar($nombre_tabla,$registro);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("table/create/".$nombre_tabla);
                break;
            case 'Guardar y Listar':
                return redirect("table/".$nombre_tabla);
                break;
            
            default:
                return redirect("table/".$nombre_tabla);
                break;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nombre_tabla,$id)
    {
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        $registro=TableModel::registros_by_tabla($nombre_tabla,"and id='$id'");
        return view('table.show')
        ->with("columnas",$columnas)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("registro",$registro[0])
        ->with("id",$id);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nombre_tabla,$id)
    {
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        $registro=TableModel::registros_by_tabla($nombre_tabla,"and id='$id'");
        return view('table.edit')
        ->with("columnas",$columnas)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("registro",$registro[0])
        ->with("id",$id);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nombre_tabla,$id)
    {

        $registro=(object) array();
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        foreach ($columnas as $key => $value) {
            $nombre_campo=$value->COLUMN_NAME;
            if($nombre_campo!="id"&&$nombre_campo!="created_at")
            {

                if(strpos($nombre_campo,"_imagen")!==false)
                {
                    
                    if($request->$nombre_campo)
                    {
                        $imagen_=$request->$nombre_campo;
                        $nombre_imagen=time()."_".$imagen_->getClientOriginalName();            
                        Storage::disk("img")->put($nombre_imagen,file_get_contents($imagen_->getRealPath()));            
                        $registro->$nombre_campo=$nombre_imagen;    
                    }
                    
                    
                }
                else
                {
                    $registro->$nombre_campo=$request->$nombre_campo;        
                }
                
            }

        }
        $registro->updated_at=date("Y-m-d H:i:s");
        TableModel::actualizar($nombre_tabla,$registro,'id',$id);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("table/".$nombre_tabla."/".$id."/edit");
                break;
            case 'Guardar y Listar':
                return redirect("table/".$nombre_tabla);
                break;
            
            default:
                return redirect("table/".$nombre_tabla);
                break;
        }
    }

    public function delete($nombre_tabla,$id)
    {
        $columnas=TableModel::columnas_by_tabla($nombre_tabla);
        $registro=TableModel::registros_by_tabla($nombre_tabla,"and id='$id'");
        return view('table.delete')
        ->with("columnas",$columnas)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("registro",$registro[0])
        ->with("id",$id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$nombre_tabla,$id)
    {
        $registro=(object) array();
        
        $estado="estado_".$nombre_tabla;
        $registro->$estado="eliminado";
        $registro->updated_at=date("Y-m-d H:i:s");
        TableModel::actualizar($nombre_tabla,$registro,'id',$id);
        switch ($request->eliminar) {
            case 'Eliminar':
                return redirect("table/".$nombre_tabla);
                break;
            
            default:
                return redirect("table/".$nombre_tabla);
                break;
        }
    }

    
}
