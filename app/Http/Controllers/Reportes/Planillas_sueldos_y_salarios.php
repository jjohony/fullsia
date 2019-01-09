<?php  
namespace App\Http\Controllers\Reportes;
use App\Models\configuracion;
include_once "../app/Library/fpdf/fpdf.php";

class Planillas_sueldos_y_salarios extends \FPDF
{
 
    var $tituloEncabezado;
    var $tamanioCampo;
    var $tituloHeader;
    var $altoCelda;
    var $tamLetra;
    var $bordeCelda;
    var $configuracion;
    public function Header__() {
        
    }
    public function cabecera_general()
    {   
        
        $this->SetFont('Arial', '', 9);
        
        $this->SetY(15);
        $this->SetX(10);
        $this->Cell(50, 6, utf8_decode('NOMBRE O RAZON SOCIAL'), 0, 0, 'L'); 
        $this->Cell(130, 6, utf8_decode($this->configuracion->nombre), 1, 0, 'L'); 
        $this->SetX(205);
        $this->Cell(35, 6, utf8_decode('N° DE NIT:'), 0, 0, 'L'); 
        $this->Cell(35, 6, utf8_decode($this->configuracion->nit), 1, 1, 'L');

        $this->Ln(1);
        $this->SetX(10);
        $this->Cell(140, 6, utf8_decode('N° IDENTIFICADOR DEL EMPLEADOR ANTE EL MINISTERIO DE TRABAJO'), 0, 0, 'L');

        $this->Cell(40, 6, utf8_decode($this->configuracion->numero_identificador_ministerio_trabajo), 1, 0, 'L'); 
        $this->SetX(205);
        $this->Cell(35, 6, utf8_decode('N° DE EMPLEADOR:'), 0, 0, 'L'); 
        $this->Cell(35, 6, utf8_decode($this->configuracion->numero_empleador), 1, 1, 'L'); 

        $this->Ln(3);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(331, 5, utf8_decode('PLANILLA DE SUELDOS Y SALARIOS'), 0, 1, 'C'); 

        $this->SetFont('Arial', '', 12);
        $this->Cell(331, 5, utf8_decode('(En Bolivianos)'), 0, 1, 'C'); 

        $this->Cell(331, 5, utf8_decode('CORRESPONDIENTE AL MES DE '.$_GET["mes"]), 0, 1, 'C'); 

        $this->SetWidths(array( 10, 18, 45, 10, 15,8,15, 15, 10, 10, 10, 10,10, 15, 15, 10, 15, 10,10, 10, 10, 13, 25));
        $this->SetHeights(array( 12, null, 12, null, null, null,null, null, null, null, null,null, null, null, null, null,null, null, null, null, null,null,12));
          $this->SetTamanio_font(array( 12,8.5, 12, null, null, null,null, null, null, null, null,null, null, null, null, null,null, null, null, null, null,null,12));
        //$this->SetAligns(array( "C", "C", "C", "C", "C", "C"));
        $this->SetFont('Arial', '', 6);
        
        $filas_dato = array(
            utf8_decode('Nro.'),
            utf8_decode('Documento de Identidad'),
            utf8_decode('Apellidos y Nombres'),
            utf8_decode('Pais de Nacionalidad'),
            utf8_decode('Fecha de Nacimiento'),
            utf8_decode('Sexo (V/M)'),
            utf8_decode('Ocupación que desempeña'),
            utf8_decode('Fecha de Ingreso'),
            utf8_decode('Horas Pagadas (Dia)'),
            utf8_decode('Dias Pagados (Mes)'),
            utf8_decode('(1) Haber Basico'),
            utf8_decode('(2) Bono de Antiguedad'),
            utf8_decode('(3) Bono de Produccion'),
            utf8_decode('(4) Trabajo extraordinario y nocturno'),
            utf8_decode('(5) Pago Dominical y domingos Trabajados'),
            utf8_decode('(6) Otros Bonos'),
            utf8_decode('(7) TOTAL GANADO suma de (1-6)'),
            utf8_decode('(8) Aporte a las AFPs'),
            utf8_decode('(9) RC-IVA'),
            utf8_decode('(10) Otros Descuentos'),
            utf8_decode('(11) TOTAL DESCUENTOS'),
            utf8_decode('(12) LIQUIDO PAGABLE (7-11)'),
            utf8_decode('(13) Firma'),

        );
        $this->SetFont('Arial', '', 6);
        
        $y=$this->GetY();

        $this->Row($filas_dato, 3, 3); 
        



        
        
    }
    public function cabecera2()
    {     
        
        
    }
    public function cabecera3()
    {     
        
    }
    public function pie() {
        
        
    }
    public function reporte($administrativo,$docente)
    {   
        //ini_set("session.auto_start", 0); 
        $this->configuracion=configuracion::find(1);

        $this->SetTopMargin(20);
        $this->SetLeftMargin(10);
        $this->SetRightMargin(15);
        $this->SetAutoPageBreak(1, 20);
        $this->AliasNbPages();
        //$this->AddPage('P', 'Legal');
        $this->AddPage('L',array(216,340));
        $this->Image('../public/img/'.$this->configuracion->logo_reporte_imagen, -200, -70, 25, 25);
        
        $this->cabecera_general();
        $cont=0;
        $this->SetFont("Arial","",8);
        $num=1;
        if(!empty($administrativo)){
            $num=1;
            //for($ivan=0;$ivan<=100;$ivan++){
            foreach ($administrativo as $key => $value) {
                $num++;
                if($num>16)
                {
                    
                    $this->pie();
                    $this->SetTopMargin(30);
                    $this->SetLeftMargin(10);
                    $this->SetRightMargin(10);
                    //$this->SetBottomMargin(0);
                    $this->SetAutoPageBreak(1, 20);
                    $this->AddPage('L',array(215,340));
                    $this->cabecera_general();
                    $this->cabecera2();
                    $this->cabecera3();
                    $num=1;
                }
                $cont++;
                $this->SetFont("Arial","",8);
                $this->Cell(10,7,utf8_decode($cont),1,0,'C');
                $this->AjustaCelda(18,7,utf8_decode($value->numero_documento." ".$value->expedido),1,0,'C');
                $this->AjustaCelda(45,7,utf8_decode($value->paterno." ".$value->materno." ".$value->nombre),1,0,'L');                
                $this->AjustaCelda(10,7,utf8_decode($value->nacionalidad),1,0,'C');
                $this->SetFont("Arial","",7);
                $this->Cell(15,7,utf8_decode(date("d-m-Y",strtotime($value->fecha_nacimiento))),1,0,'C');
                $sexo=($value->sexo=="masculino")?"V":"M";
                $this->AjustaCelda(8,7,utf8_decode($sexo),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode($value->cargo),1,0,'C');
                $this->SetFont("Arial","",7);
                $this->Cell(15,7,utf8_decode(date("d-m-Y",strtotime($value->fecha_ingreso))),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(0),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode($value->dias_trabajado),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode($value->haber_basico),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(number_format($value->hora_extra,2)),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->otros_pagos,2)),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(number_format($value->total_ingresos,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->afp,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->otros_descuentos,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->total_descuento,2)),1,0,'C');
                $this->AjustaCelda(13,7,utf8_decode(number_format($value->total_liquido_pagable,2)),1,0,'C');
                $this->AjustaCelda(25,7,utf8_decode(""),1,0,'C');

                $this->Ln();
            }
            //}
        }

        if(!empty($docente)){
            
            //for($ivan=0;$ivan<=100;$ivan++){
            foreach ($docente as $key => $value) {
                $num++;
                if($num>16)
                {
                    
                    $this->pie();
                    $this->SetTopMargin(30);
                    $this->SetLeftMargin(10);
                    $this->SetRightMargin(10);
                    //$this->SetBottomMargin(0);
                    $this->SetAutoPageBreak(1, 20);
                    $this->AddPage('L',array(215,340));
                    $this->cabecera_general();
                    $this->cabecera2();
                    $this->cabecera3();
                    $num=1;
                }
                $cont++;
                $this->SetFont("Arial","",8);
                $this->Cell(10,7,utf8_decode($cont),1,0,'C');
                $this->AjustaCelda(18,7,utf8_decode($value->numero_documento." ".$value->expedido),1,0,'C');
                $this->AjustaCelda(45,7,utf8_decode($value->paterno." ".$value->materno." ".$value->nombre),1,0,'L');                
                $this->AjustaCelda(10,7,utf8_decode($value->nacionalidad),1,0,'C');
                $this->SetFont("Arial","",7);
                $this->Cell(15,7,utf8_decode(date("d-m-Y",strtotime($value->fecha_nacimiento))),1,0,'C');
                $sexo=($value->sexo=="masculino")?"V":"M";
                $this->AjustaCelda(8,7,utf8_decode($sexo),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode($value->cargo),1,0,'C');
                $this->SetFont("Arial","",7);
                $this->Cell(15,7,utf8_decode(date("d-m-Y",strtotime($value->fecha_ingreso))),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(0),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode($value->dias_trabajado),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode($value->haber_basico),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(number_format($value->hora_extra,2)),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->otros_pagos,2)),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(number_format($value->total_ingresos,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->afp,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode("0.00"),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->otros_descuentos,2)),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(number_format($value->total_descuento,2)),1,0,'C');
                $this->AjustaCelda(13,7,utf8_decode(number_format($value->total_liquido_pagable,2)),1,0,'C');
                $this->AjustaCelda(25,7,utf8_decode(""),1,0,'C');

                $this->Ln();
            }
            //}
        }

        if((15-$num)==0)
        {
            
        }
        else
        {
            for($i=1;$i<=(15-$num);$i++)
            {
                $this->Cell(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(18,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(45,7,utf8_decode(""),1,0,'L');                
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->Cell(15,7,utf8_decode(""),1,0,'C');
                
                $this->AjustaCelda(8,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(""),1,0,'C');
                $this->SetFont("Arial","",7);
                $this->Cell(15,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(15,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(10,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(13,7,utf8_decode(""),1,0,'C');
                $this->AjustaCelda(25,7,utf8_decode(""),1,1,'C');
                
            }
        }

        $this->cabecera2();
        $this->cabecera3();
        $cont=0;
        $num = 0;
        $aprovados=0;
        $reprovados=0;
        $nsp=0;
        $x=0;        

        $this->Output('reporte1.pdf', 'I');
    } 
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-30);
        $this->SetX(17);
        $this->SetFont("Arial","",7);
        $this->Cell(80,3,utf8_decode("==================================="),0,0,'C');
        $this->Cell(80,3,utf8_decode("==================================="),0,0,'C');
        $this->Cell(60,3,utf8_decode("============================="),0,0,'C');
        $this->Cell(60,3,utf8_decode(date("d-m-Y")),0,1,'C');
        $this->SetX(17);
        $this->Cell(80,3,utf8_decode("NOMBRE DEL REPRESENTANTE LEGAL"),0,0,'C');
        $this->Cell(80,3,utf8_decode("N° DE DOCUMENTO DE IDENTIDAD"),0,0,'C');
        $this->Cell(60,3,utf8_decode("FIRMA "),0,0,'C');
        $this->Cell(60,3,utf8_decode("FECHA "),0,1,'C');
        $this->SetFont("Arial","I",8);
        $this->Ln(5);
        $this->Cell(331,5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
    function SetFontSize($size) {
           // Set font size in points
           if ($this->FontSizePt == $size)
               return;
           $this->FontSizePt = $size;
           $this->FontSize = $size / $this->k;
           if ($this->page > 0)
               $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
       }
    function AjustaCelda($ancho, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true) {
     $TamanoInicial = $this->FontSizePt;
     $TamanoLetra = $this->FontSizePt;
     $Decremento = 0.8;
     while($this->GetStringWidth($txt) > $ancho)
       $this->SetFontSize($TamanoLetra -= $Decremento);
     $this->Cell($ancho, $h, $txt, $border, $ln, $align, $fill, $link, $scale, $force);
     $this->SetFontSize($TamanoInicial);
    }
    function numtoletras($xcifra)
    {
    $xarray = array(0 => "Cero",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIEN", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }
 
    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el lÃ­mite a 6 dÃ­gitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegÃ³ al lÃ­mite mÃ¡ximo de enteros
                break; // termina el ciclo
            }
 
            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dÃ­gitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dÃ­gitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                             
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es nÃºmero redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (MillÃ³n, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquÃ­ si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lÃ³gica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                             
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                             
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = $this->subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO
 
        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        // ----------- esta lÃ­nea la puedes cambiar de acuerdo a tus necesidades o a tu paÃ­s -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= ""; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para MÃ©xico se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}
 
    // END FUNCTION
     
    function subfijo($xx)
    { // esta funciÃ³n regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }
    function fecha_literal($Fecha, $Formato = 4) {
        $dias = array(0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'MiÃ¨rcoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'SÃ bado');
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
            
    
    //  TABULACION DE TEXTO //////////////////////////////////////


    public function getAlto($description, $column_width)
    {
        $total_string_width = $this->GetStringWidth($description);
        $number_of_lines = $total_string_width / ($column_width - 1);
        $number_of_lines = ceil($number_of_lines);  // Round it up.
        $line_height = 5;                             // Whatever your line height is.

        $height_of_cell = $number_of_lines * $line_height;

        $height_of_cell = ceil($height_of_cell);    // Round it up.
        return $height_of_cell;
    }

    var $widths;
    var $aligns;
    var $heights;
    var $tamanio_font;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetHeights($h)
    {
        //Set the array of column widths
        $this->heights = $h;
    }

    function SetTamanio_font($t)
    {
        //Set the array of column widths
        $this->tamanio_font = $t;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $alto_celda, $interlineado)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        // $alto_celda=3;//// alto de las celdas
        $h = $alto_celda * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            //$interlineado=3; // interlineado 
            if(isset($this->tamanio_font[$i]))
            {
                $this->SetFont("Arial","",$this->tamanio_font[$i]);
            }
            else
            {
                $this->SetFont("Arial","",6);   
            }
            if(isset($this->heights[$i]))
            {
                $this->Cell($w,$this->heights[$i] , $data[$i], 0, 0, $a); 
            }
            else
            {
                $this->MultiCell($w, $interlineado, $data[$i], 0, $a);    
            }
            
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {



        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
        {
            //$this->AddPage($this->CurOrientation);
            $this->AddPage('P',array(215,329));
        }
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb)
        {
            $c = $s[$i];
            if ($c == "\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax)
            {
                if ($sep == -1)
                {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    //  TABULACION DE TEXTO //////////////////////////////////////
}
