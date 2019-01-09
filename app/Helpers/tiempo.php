<?php
namespace App\Helpers;
class tiempo{ 
    /**
     * Calcula tiempo entre dos fechas
     * @param String $fechaInicio 
     * @param String $fechaActual 
     * @return array || null
     */
    public static function calcular_tiempo($fechaInicio,$fechaActual){
        $diaActual = substr($fechaActual, 0, 2);
        $mesActual = substr($fechaActual, 3, 2);
        $anioActual = substr($fechaActual, 6, 10);
        $diaInicio = substr($fechaInicio, 0, 2);
        $mesInicio = substr($fechaInicio, 3, 2);
        $anioInicio = substr($fechaInicio, 6, 10);
        $b = 0;
        $mes = $mesInicio-1;
        if($mes==2){
            if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0){
                $b = 29;
            }
            else{
                $b = 28;
            }
        }
        else if($mes<=7){
            if($mes==0){
                $b = 31;
            }
            else if($mes%2==0){
                $b = 30;
            }
            else{
                $b = 31;
            }
        }
        else if($mes>7){
            if($mes%2==0){
                $b = 31;
            }
            else{
                $b = 30;
            }
        }
        if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) || 
            ($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual)){
                echo "La fecha de inicio ha de ser anterior a la fecha Actual";
        }
        else{
            if($mesInicio <= $mesActual){
                $anios = $anioActual - $anioInicio;
                if($diaInicio <= $diaActual){
                    $meses = $mesActual - $mesInicio;
                    $dies = $diaActual - $diaInicio;
                }
                else{
                    if($mesActual == $mesInicio){
                        $anios = $anios - 1;
                    }
                    $meses = ($mesActual - $mesInicio - 1 + 12) % 12;
                    $dies = $b-($diaInicio-$diaActual);
                }
            }
            else{
                $anios = $anioActual - $anioInicio - 1; 
                if($diaInicio > $diaActual){
                $meses = $mesActual - $mesInicio -1 +12;
                $dies = $b - ($diaInicio-$diaActual);
                }
                else{
                    $meses = $mesActual - $mesInicio + 12;
                    $dies = $diaActual - $diaInicio;
                }
            } 
            return array("anios"=>$anios,"meses"=>$meses,"dias"=>$dies);
        }
    }
}