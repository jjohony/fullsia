<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Models\Admin\users;
use App\Models\TableModel;
use App\Models\Admin\user_group;
use App\Models\log;
use App\Http\Controllers\Reportes\Historial_de_usuario;


class UsuarioController extends Controller
{


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
        $usuario=users::me();
        $tipo=$usuario->nombre_grupo;
        $usuarios=users::usuarios($nombre_tabla);
        //var_dump($usuarios);
        return view("usuario.listar")
        ->with("usuarios",$usuarios)
        ->with("nombre_tabla",$nombre_tabla);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nombre_tabla)
    {

        
        $usuario=users::me();
        $$nombre_tabla=users::$nombre_tabla();
        //var_dump($usuarios);
        return view("usuario.create")
        ->with($nombre_tabla,$$nombre_tabla)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("usuario",$usuario);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$nombre_tabla)
    {
        $incrementable=users::max_inc($nombre_tabla);

        //$id_persona=
        $users=new users();

        $users->id_persona=$request->id_persona;

        $$nombre_tabla=users::registros_by_tabla("$nombre_tabla","and id='".$request->id_persona."'")[0];

        

        $users->email=$request->email;
        if($nombre_tabla=="administrativo"||$nombre_tabla=="docente")
        {
            $name=($incrementable+1).substr($$nombre_tabla->nombre, 0,1);
            $users->inc_administrativo=$incrementable+1;
        }
        else
        {
            $name=$incrementable+1;
            $users->inc_estudiante=$incrementable+1;
        }
        $users->name=$name;
        $users->password=hash::make($$nombre_tabla->numero_documento);

        $this->capturar_accion();
        $users->save();
        $this->log("descripcion","users",$this->sql,$this->cadena);

        $users=users::all()->last();
        $user_group=new  user_group();
        $user_group->id_user=$users->id;
        $user_group->id_group=$request->id_grupo;
        $user_group->estado_user_group='activo';

        $this->capturar_accion();
        $user_group->save();

        $this->log("descripcion","user_group",$this->sql,$this->cadena);
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("usuario/create/$nombre_tabla");
                break;
            case 'Guardar y Listar':
                return redirect("usuario/$nombre_tabla");
                break;
            
            default:
                return redirect("usuario/$nombre_tabla");
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nombre_tabla,$id_usuario)
    {
        $usuario=users::me();
        $$nombre_tabla=users::registros_by_tabla($nombre_tabla,"and estado_$nombre_tabla='activo'");

        $users=users::usuarios($nombre_tabla,"and u.id='$id_usuario'")[0];
        //var_dump($usuarios);
        return view("usuario.ver")
        ->with($nombre_tabla,$$nombre_tabla)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("usuario",$usuario)
        ->with("users",$users);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nombre_tabla,$id_usuario)
    {
        $usuario=users::me();
        $$nombre_tabla=users::registros_by_tabla($nombre_tabla,"and estado_$nombre_tabla='activo'");

        $users=users::usuarios($nombre_tabla,"and u.id='$id_usuario'")[0];
        //var_dump($usuarios);
        return view("usuario.edit")
        ->with($nombre_tabla,$$nombre_tabla)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("usuario",$usuario)
        ->with("users",$users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$nombre_tabla, $id_usuario)
    {
        
        $users_1=users::usuarios($nombre_tabla,"and u.id='$id_usuario'")[0];
        
        $users= users::find($id_usuario);

        $users->id_persona=$request->id_persona;

        $$nombre_tabla=users::registros_by_tabla("$nombre_tabla","and id='".$request->id_persona."'")[0];
        //en caso de foto diferente de null se sube y se guarda el nombre de la foto
        

        if($nombre_tabla=="administrativo"||$nombre_tabla=="docente")
        {
            $users->name=$users->inc_administrativo.substr($$nombre_tabla->nombre, 0,1);
            
        }

        $users->email=$request->email;
        $users->estado_users=$request->estado_users;
        
        if($request->password)
        {
            $users->password=hash::make($request->password);
        }        
        
        $this->capturar_accion();

        if($users->save())
        {
            $this->log("descripcion","users",$this->sql,$this->cadena);    
        }
        
        
        
        $id_user_group=users::registros_by_tabla("user_group","and id_user='".$users->id."' and id_group='".$users_1->id_group."'")[0]->id;
        
        
        $user_group= user_group::find($id_user_group);
        
        $user_group->id_user=$users->id;
        $user_group->id_group=$request->id_grupo;
        $user_group->save();
        
        
        switch ($request->guardar) {
            case 'Guardar':
                return redirect("usuario/$nombre_tabla/$id_usuario/edit");
                break;
            case 'Guardar y Listar':
                return redirect("usuario/$nombre_tabla");
                break;
            
            default:
                return redirect("usuario/$nombre_tabla");
                break;
        }   
    }
    public function delete($nombre_tabla,$id_usuario)
    {
        $usuario=users::me();
        $$nombre_tabla=users::registros_by_tabla($nombre_tabla,"and estado_$nombre_tabla='activo'");

        $users=users::usuarios($nombre_tabla,"and u.id='$id_usuario'")[0];
        //var_dump($usuarios);
        return view("usuario.delete")
        ->with($nombre_tabla,$$nombre_tabla)
        ->with("nombre_tabla",$nombre_tabla)
        ->with("usuario",$usuario)
        ->with("users",$users);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($nombre_tabla,$id_usuario)
    {
        $users=users::find($id_usuario);
        $users->estado_users="eliminado";

        $this->capturar_accion();
        $users->save();
        $this->log("descripcion","users",$this->sql,$this->cadena);
        return redirect("usuario/$nombre_tabla");
    }

    public function usuario_inicio()
    {
        $usuario=users::me();

        return view("usuario.usuario_inicio")
        ->with("usuario",$usuario);
    }

    public function ajustes_usuario_edit()
    {
        return view("usuario.ajuste_usuario");        
    }
    public function ajustes_usuario_save(Request $request)
    {
        $tabla=users::find(Auth::user()->id);
        if($request->foto)
        {
            $imagen=$request->foto;

            $nombre_imagen=time()."_".$imagen->getClientOriginalName();
            
            Storage::disk("img")->put($nombre_imagen,file_get_contents($imagen->getRealPath()));
            
            $usuario=users::me();
            $id_persona=$usuario->id_persona;

            $this->capturar_accion();
            switch ($usuario->nombre_grupo) {
                case 'administrador':
                    \DB::select("update administrativo set foto_imagen='$nombre_imagen' where id='$id_persona'");
                    $this->log("descripcion","administrativo",$this->sql,$this->cadena);                    
                    break;
                case 'academico':
                    
                    \DB::select("update administrativo set foto_imagen='$nombre_imagen' where id='$id_persona'");
                    $this->log("descripcion","administrativo",$this->sql,"");
                    //var_dump($persona_usuario);die;

                    //var_dump($persona_usuario->foto_imagen);die;
                    break;
                case 'docente':
                    
                    \DB::select("update docente set foto_imagen='$nombre_imagen' where id='$id_persona'");
                    $this->log("descripcion","docente",$this->sql,"");
                    break;
                case 'estudiante':
                    \DB::select("update estudiante set foto_imagen='$nombre_imagen' where id='$id_persona'");
                    $this->log("descripcion","estudiante",$this->sql,"");

                    break;
                case 'operador':
                    
                    \DB::select("update administrativo set foto_imagen='$nombre_imagen' where id='$id_persona'");
                    $this->log("descripcion","administrativo",$this->sql,"");
                    break;
                default:
                    # code...
                    break;
            }

        }
        if($request->password!="")
        {
            $tabla->password=hash::make($request->password);    
            $this->capturar_accion();
            $tabla->save();
            $this->log("descripcion","users",$this->sql,$this->cadena);
        }    
        
        return redirect("ajustes_usuario_edit");
    }

    public function index_reporte_historial_de_usuario()
    {
        
        return view("carrera.reportes.reporte_historial_de_usuario");
    }
    public function reporte_historial_de_usuario()
    {
        $fecha_inicio=$_GET["fecha_inicio"];
        $fecha_fin=$_GET["fecha_fin"];
        $log=log::log_by_fechas($fecha_inicio,$fecha_fin);
        
        $reporte=new Historial_de_usuario();
        $reporte->reporte($log["administrativo"],$log["docente"]);
    }
}
