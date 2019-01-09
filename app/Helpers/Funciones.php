<?php
namespace App\Helpers;

class Funciones
{
	public function serear_numero($numero)
	{
		if($numero<10)
		{
			$numero='000'.$numero;
		}
		else if($numero>=10&&$numero<100)
		{
			$numero='00'.$numero;	
		}
		else if($numero>=100&&$numero<1000)
		{
			$numero='0'.$numero;	
		}
		return $numero;
	}
    public static function serear_numero_dinamico($numero,$max_digito)
    {
        $numero_de_digitos=strlen($numero);
        if($numero_de_digitos>=$max_digito)
        {
            return $numero;
        }
        else
        {
            $digito_faltante=$max_digito-$numero_de_digitos;
            $cadena="";
            for ($i=0; $i <$digito_faltante ; $i++) { 
                $cadena=$cadena."0";
            }
            return $cadena.$numero;
        }
    }
    
	function fecha_literal($Fecha, $Formato = 2) {
        $dias = array(0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Mièrcoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sàbado');
        $meses = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
            7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');
        $aux = date_parse($Fecha);
        switch ($Formato) {
            case 1:  // 04/10/10
                return date('d/m/y', strtotime($Fecha));
            case 2:  //04/oct/10
                return sprintf('%02d/%s/%02d', $aux['day'], substr($meses[$aux['month']], 0, 3), $aux['year'] % 100);
            case 3:   //octubre 4, 2010
                return $meses[$aux['month']] . ' ' . sprintf('%.2d', $aux['day']) . ', ' . $aux['year'];
            case 4:   // 4 de octubre de 2010
                return $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
            case 5:   //lunes 4 de octubre de 2010
                $numeroDia= date('w', strtotime($Fecha));
                return $dias[$numeroDia].' '.$aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
            case 6:
                return date('d/m/Y', strtotime($Fecha));
            default:
                return date('d/m/Y', strtotime($Fecha));
        }
    }
    public static function  numero_cardinal($numero)
    {
        $cardinal[1]="PRIMER";
        $cardinal[2]="SEGUNDO";
        $cardinal[3]="TERCER";
        $cardinal[4]="CUARTO";
        $cardinal[5]="QUINTO";
        $cardinal[6]="SEXTO";
        $cardinal[7]="SEPTIMO";
        $cardinal[8]="OCTAVO";
        $cardinal[9]="NOVENO";
        $cardinal[10]="DECIMO";
        return $cardinal[$numero];
    }
}