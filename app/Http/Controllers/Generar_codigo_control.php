<?php
namespace App\Http\Controllers;

//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Helpers/Codigo_control/ControlCode.php');


class Generar_codigo_control extends \ControlCode {
  
  public function generar($numero_autorizacion,$folio,$nit_cliente,$fecha,$monto,$llave)
  {
     $count=0;        
    //genera codigo de control
    $code = $this->generate($numero_autorizacion,//Numero de autorizacion
                                   $folio,//Numero de factura
                                   $nit_cliente,//Número de Identificación Tributaria o Carnet de Identidad
                                   str_replace('-','',str_replace('/','',$fecha)),//fecha de transaccion de la forma AAAAMMDD
                                   $monto,//Monto de la transacción
                                   $llave//Llave de dosificación
            );
    return $code; 
  }
}

