<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin\users;
use Session;
class Pago_estudiante
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $usuario=users::me();
        switch ($usuario->nombre_grupo) {
            case 'academico':
                break;
            case 'docente':
                
                
                break;
            case 'estudiante':
                $id_persona=$usuario->id_persona;            
                $estudiante=users::registros_by_tabla("estudiante","and id='$id_persona'");
                
                if(!empty($estudiante))
                {
                    $estudiante=$estudiante[0];

                    if($estudiante->estado_deudas=="con deuda")
                    {
                        Auth::guard()->logout();

                        $request->session()->flush();

                        $request->session()->regenerate();
                        Session::flash('message', 'Estimado usuario, es necesario que regularice lo antes posible los pagos en mora que tiene acumulado.');


                        return redirect('/');
                        
                    }
                }

                break;
            default:
                # code...
                break;
        }
        /*if(==)
        {
            return redirect("calala");
        }*/

        return $next($request);
    }
}
