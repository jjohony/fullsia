<?php  
namespace App\Http\Controllers\Reportes;
use App\Models\configuracion;
include_once "../app/Library/fpdf/fpdf.php";

class Detalle_boleta_pago extends \FPDF
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
        
        
        



        
        
    }
    public function cabecera2()
    {     
        
        
    }
    public function cabecera3()
    {     
        
    }
    public function pie() {
        
        
    }
    public function reporte($pago,$pago_extra,$descuento)
    {   
        ini_set("session.auto_start", 0); 
        $this->configuracion=configuracion::find(1);

        $this->SetTopMargin(20);
        $this->SetLeftMargin(15);
        $this->SetRightMargin(15);
        $this->SetAutoPageBreak(1, 20);
        //$this->AddPage('P', 'Legal');
        $this->AddPage('P',"LETTER");
        $this->Image('../public/img/'.$this->configuracion->logo_reporte_imagen, 20, 7, 25, 25);
        $this->SetFont('Arial', 'B', 11);
        
        $this->SetY(15);
        $this->SetX(120);
        $this->Cell(35, 6, utf8_decode('NIT:'), 0, 0, 'L'); 
        $this->Cell(60, 6, utf8_decode($this->configuracion->nit), 0, 1, 'L'); 
        $this->SetX(120);
        $this->Cell(35, 6, utf8_decode('N° PATRONAL:'), 0, 0, 'L'); 
        $this->Cell(60, 6, utf8_decode($this->configuracion->numero_patronal), 0, 1, 'L'); 

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(185, 6, utf8_decode('BOLETA DE PAGO'), 0, 1, 'C'); 
        
        $this->Ln(5);

        $this->SetFont('Arial', '', 9);
        $this->Cell(33, 6, utf8_decode('NOMBRE:'), 0, 0, 'L'); 
        $this->Cell(70, 6, utf8_decode($pago->nombre." ".$pago->paterno." ".$pago->materno." "), 0, 0, 'L');
        $this->Cell(33, 6, utf8_decode('FECHA INGRESO:'), 0, 0, 'L'); 
        $this->Cell(50, 6, utf8_decode(date("d-m-Y",strtotime($pago->fecha_ingreso))), 0, 1, 'R');

        $this->Cell(33, 6, utf8_decode('CARGO:'), 0, 0, 'L'); 
        $this->Cell(70, 6, utf8_decode($pago->cargo), 0, 0, 'L');
        $this->Cell(33, 6, utf8_decode('CEDULA:'), 0, 0, 'L'); 
        $this->Cell(50, 6, utf8_decode($pago->numero_documento." ".$pago->expedido), 0, 1, 'R');

        $this->Cell(33, 6, utf8_decode('UNIDAD / AREA:'), 0, 0, 'L'); 
        $this->Cell(70, 6, utf8_decode(strtoupper($pago->unidad_area)), 0, 0, 'L');
        $this->Cell(33, 6, utf8_decode('NUMERO ASEGURADO:'), 0, 0, 'L'); 
        $this->Cell(50, 6, utf8_decode($pago->numero_seguro_salud), 0, 1, 'R');

        $this->SetFillColor(0,0,0);
        $this->SetDrawColor(0,0,0);
        $this->Line(15,$this->GetY(),200,$this->GetY());

        $this->Cell(185, 6, utf8_decode('CORRESPONDIENTE AL MES DE '.$pago->mes.'  DE 2017'), 0, 1, 'C'); 
        $this->Line(15,$this->GetY(),200,$this->GetY());

        $this->Ln(1);
        $this->Cell(93, 6, utf8_decode('INGRESOS:'), 1, 0, 'C'); 
        $this->Cell(92, 6, utf8_decode('DESCUENTOS'), 1, 1, 'C');


        $y=$this->GetY();

        $this->Cell(33, 5, utf8_decode('DIAS TRABAJADOS'), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode($pago->dias_trabajado), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("AFP'S 10%"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago->afp,2)), 0, 1, 'R');

        $this->Cell(33, 5, utf8_decode('HABER BASICO'), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode(number_format($pago->haber_basico,2)), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("COMISION AFP 0.5%"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago->comision_afp,2)), 0, 1, 'R');

        $this->Cell(33, 5, utf8_decode('BONO ANTIGUEDAD'), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode(number_format($pago->bono_antiguedad,2)), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("FONDO SOLIDARIO 0.5%"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago->fondo_solidario,2)), 0, 1, 'R');

        $this->Cell(33, 5, utf8_decode('HORAS EXTRAS'), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode(number_format($pago->horas_extras,2)), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("RIESGO COMUN 1.71%"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago ->riesgo_comun,2)), 0, 1, 'R');

        $this->Cell(33, 5, utf8_decode('OTROS'), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode(number_format($pago ->otros_ingresos,2)), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("ANTICIPOS"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago ->anticipos,2)), 0, 1, 'R');

        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'L'); 
        $this->Cell(60, 5, utf8_decode(''), 0, 0, 'R');
        $this->Cell(40, 5, utf8_decode("OTROS"), 0, 0, 'L'); 
        $this->Cell(52, 5, utf8_decode(number_format($pago ->otros_descuentos,2)), 0, 1, 'R');

        $this->Line(15,$this->GetY(),200,$this->GetY());

        $y1=$this->GetY();
        
        
        $this->Cell(60, 5, utf8_decode("TOTALES"), 0, 0, 'R'); 
        $this->Cell(32, 5, utf8_decode(number_format($pago ->total_ingresos,2)), 0, 0, 'R');
        $this->Cell(60, 5, utf8_decode("TOTALES"), 0, 0, 'R'); 
        $this->Cell(32, 5, utf8_decode(number_format($pago ->total_descuento,2)), 0, 1, 'R');

        $this->Line(15,$this->GetY(),200,$this->GetY());
        $this->Line(15,$y,15,$this->GetY());
        


        $this->Cell(60, 5, utf8_decode(''), 0, 0, 'R');
        $this->Cell(33, 5, utf8_decode(''), 0, 0, 'L'); 
        
        $this->Cell(60, 5, utf8_decode("LIQUIDO PAGABLE"), 0, 0, 'R'); 
        $this->Cell(32, 5, utf8_decode(number_format($pago->total_liquido_pagable,2)), 0, 1, 'R');

        $this->Line(108,$y,108,$this->GetY());
        $this->Line(200,$y,200,$this->GetY());
        $this->Line(108,$this->GetY(),200,$this->GetY());

        $this->Ln(5);

        $this->Line(15,$this->GetY(),200,$this->GetY());        
        $this->Cell(185, 6, utf8_decode("OTROS INGRESOS EXTRAS"), 0, 1, 'C'); 
        $this->Line(15,$this->GetY(),200,$this->GetY());        

        $this->Cell(40, 5, utf8_decode('TIPO DE INGRESO'), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode('MONTO'), 0, 0, 'C');
        $this->Cell(85, 5, utf8_decode("DESCRIPCION"), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode("FECHA"), 0, 1, 'C');
        $this->Line(15,$this->GetY(),200,$this->GetY());   
        $total=0;
        if(!empty($pago_extra))
        {
            foreach ($pago_extra as $key => $value) {
                $this->Cell(40, 7, utf8_decode($value->tipo_pago), 0, 0, 'C'); 
                $this->Cell(30, 7, utf8_decode(number_format($value->monto,2)), 0, 0, 'C');
                $this->Cell(85, 7, utf8_decode($value->descripcion), 0, 0, 'C'); 
                $this->Cell(30, 7, utf8_decode(date("d-m-Y",strtotime($value->fecha))), 0, 1, 'C');
                $this->Line(15,$this->GetY(),200,$this->GetY());        
                $total=$total+$value->monto;
            }    
        }
        $this->Cell(40, 5, utf8_decode('TOTAL'), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode(number_format($total,2)), 0, 1, 'C');
        

        $this->Ln(10);
        
        $this->Line(15,$this->GetY(),200,$this->GetY());        
        $this->Cell(185, 6, utf8_decode("OTROS DESCUENTOS EXTRAS"), 0, 1, 'C'); 
        $this->Line(15,$this->GetY(),200,$this->GetY());        

        $this->Cell(40, 5, utf8_decode('TIPO DE DESCUENTO'), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode('MONTO'), 0, 0, 'C');
        $this->Cell(85, 5, utf8_decode("DESCRIPCION"), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode("FECHA"), 0, 1, 'C');
        $this->Line(15,$this->GetY(),200,$this->GetY());   
        $total=0;

        if(!empty($descuento))
        {
            foreach ($descuento as $key => $value) {
                $this->Cell(40, 7, utf8_decode($value->tipo_descuento), 0, 0, 'C'); 
                $this->Cell(30, 7, utf8_decode(number_format($value->monto,2)), 0, 0, 'C');
                $this->Cell(85, 7, utf8_decode($value->descripcion), 0, 0, 'C'); 
                $this->Cell(30, 7, utf8_decode(date("d-m-Y",strtotime($value->fecha))), 0, 1, 'C');
                $this->Line(15,$this->GetY(),200,$this->GetY());        
                $total=$total+$value->monto;
            }    
        }
        $this->Cell(40, 5, utf8_decode('TOTAL'), 0, 0, 'C'); 
        $this->Cell(30, 5, utf8_decode(number_format($total,2)), 0, 1, 'C');

        $this->cabecera_general();
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
            
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetX(17);
        
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

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
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
            $this->MultiCell($w, $interlineado, $data[$i], 0, $a);
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
