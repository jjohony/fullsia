<?php  
namespace App\Http\Controllers\Reportes;
use App\Models\configuracion;
use App\Models\estudiante;
use App\Helpers\Funciones;
include_once "../app/Library/fpdf/fpdf.php";

class PDF extends \FPDF
{
    var $angle=0;
    function cabeceraHorizontal($cabecera,$w=30,$h=10){
        //$this->SetXY(10, 10);
        $this->SetFont('Arial','B',10);
        //$this->SetFillColor(2,157,116);//Fondo verde de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $ejeX = 10;
        foreach($cabecera as $fila)
        {
            $this->RoundedRect($this->GetX(),$this->GetY(), $w, $h, 2, 'FD');
            $this->CellFitSpace($w,$h, utf8_decode($fila),0, 0 , 'C');
            //$ejeX = $ejeX + 30;
        }
    }
 
    function datosHorizontal($datos){
        $this->SetXY(10,17);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = false; //Para alternar el relleno
        $ejeY = 17; //Aquí se encuentra la primer CellFitSpace e irá incrementando
        $letra = 'D'; //'D' Dibuja borde de cada CellFitSpace -- 'FD' Dibuja borde y rellena
        foreach($datos as $fila)
        {
            //Por cada 3 CellFitSpace se crea un RoundedRect encimado
            //El parámetro $letra de RoundedRect cambiará en cada iteración
            //para colocar FD y D, la primera iteración es D
            //Solo la celda de enmedio llevará bordes, izquierda y derecha
            //Las celdas laterales colocarlas sin borde
            $this->RoundedRect(10, $ejeY, 90, 7, 2, $letra);
            $this->CellFitSpace(30,7, utf8_decode($fila['nombre']),0, 0 , 'L' );
            $this->CellFitSpace(30,7, utf8_decode($fila['apellido']),'LR', 0 , 'L' );
            $this->CellFitSpace(30,7, utf8_decode($fila['matricula']),0, 0 , 'L' );
 
            $this->Ln();
            //Condición ternaria que cambia el valor de $letra
            ($letra == 'D') ? $letra = 'FD' : $letra = 'D';
            //Aumenta la siguiente posición de Y (recordar que X es fijo)
            //Se suma 7 porque cada celda tiene esa altura
            $ejeY = $ejeY + 7;
        }
    }
 
    function tablaHorizontal($cabeceraHorizontal, $datosHorizontal){
        $this->cabeceraHorizontal($cabeceraHorizontal);
        $this->datosHorizontal($datosHorizontal);
    }
 
    //**************************************************************************************************************
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true){
        //Get string width
        $str_width=$this->GetStringWidth($txt);
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
 
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
 
    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s){
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }
//**********************************************************************************************
 
 function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234'){
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x+$r)*$k, ($hp-$y)*$k ));
 
        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
 
        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
 
        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
 
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l', ($x+$r)*$k, ($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }
 
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3){
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;

        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        //parent::_endpage();
    }
}
class Boleta_de_calificaciones_dividido_por_semestre extends PDF
{
 
    var $tituloEncabezado;
    var $tamanioCampo;
    var $tituloHeader;
    var $altoCelda;
    var $tamLetra;
    var $bordeCelda;
    var $configuracion;
    public function Header() {
        $configuracion=$this->configuracion;
        //$carrera=$this->carrera;
        $ancho=$this->ancho;
        $altura=$this->altura;
        $this->Image('../public/img/'.$this->configuracion->logo_reporte_imagen, -200, -700, 25, 25);
        
        $this->SetFont('Arial', '', 8);        
        

        
        $this->SetFillColor(255,255,255);
        $this->SetDrawColor(0,0,0);
        
        
        

        
    }
    public function cabecera_general()
    {   
        
        

        
        
    }
    public function cabecera2()
    {     
        $carrera=$this->carrera;
        $nivel_asignatura=$this->curso->nivel_asignatura;

        

        $ancho=$this->ancho;
        $altura=$this->altura;
        switch ($carrera->tipo_gestion) {
            case 'semestral':
                $modalidad="SEMESTRAL";
                $modalidad_aux="Semestre";
                break;
            case 'anual':
                $modalidad="ANUAL";
                $modalidad_aux="Año";
                break;
            case 'modular':
                $modalidad="MODULAR";
                $modalidad_aux="MODULAR";
                break;
            default:
                $modalidad="SEMESTRAL";
                $modalidad="Semestre";
                break;
        }
        $this->SetY($altura*0.1515);
        $this->SetX($ancho*0.0421);

        $this->SetFont('Arial', 'B', 9); 
        $this->Cell($ancho*0.2666, $altura*0.0909, utf8_decode("CARRERA: ".$carrera->carrera), 1, 1, 'L');         
        $this->SetX($ancho*0.0421);
        $this->Cell($ancho*0.2666, $altura*0.0909, utf8_decode("ASIGNATURA: ".$this->curso->asignatura), 1, 1, 'L');         
        $this->SetX($ancho*0.0421);
        $this->Cell($ancho*0.2666, $altura*0.0909, utf8_decode("CURSO: ".Funciones::numero_cardinal($nivel_asignatura)." ".$modalidad), 1, 1, 'L');         

        $this->SetX($ancho*0.0421);

        $this->SetFont('Arial', 'B', 9);        
        $this->Cell($ancho*0.03, $altura*0.0424, utf8_decode("N°"), 1, 0, 'C');         
        $this->Cell($ancho*0.2366, $altura*0.0424, utf8_decode("NOMINA"), 1, 0, 'C');                  

        $y=$this->GetY()+$altura*0.0424;
        $this->SetXY($this->GetX(),$altura*0.1515);
        
        $this->x_1=$this->GetX();
        $this->Cell($ancho*0.18, $altura*0.0424, utf8_decode("1er. Semestre"), 1, 0, 'C');                 
        $this->Cell($ancho*0.18, $altura*0.0424, utf8_decode("2do. Semestre"), 1, 0, 'C');                  
        $x=$this->GetX();
        $this->SetY($y);
        $this->y_1=$this->GetY();
        $this->SetX($x);        
        $this->Rotate(90);
        $this->Cell($ancho*0.2040, $ancho*0.0424, utf8_decode("PROMEDIO ANUAL"), 1, 0, 'C');    
        $this->Rotate(0);
        
        $this->SetY($y);
        
        $this->SetX($x+$ancho*0.0424);
        $this->Rotate(90);

        $this->Cell($ancho*0.2040, $ancho*0.0424, utf8_decode("2 da. INSTANCIA"), 1, 0, 'C'); 

        $this->Rotate(0);
        
        $this->SetY($y);
        
        $this->SetX($x+$ancho*0.0424*2);
        $this->Rotate(90);

        $this->Cell($ancho*0.2040, $ancho*0.0424, utf8_decode("NOTA FINAL"), 1, 0, 'C');  
        $this->Rotate(0);                

        $this->SetY($altura*0.1515);
        $this->SetX($x+$ancho*0.0424*3);
        $this->Cell($ancho*0.1616, $ancho*0.2040, utf8_decode("OBSERVACIONES"), 1, 0, 'C');  
         

        

        


    }
    public function cabecera3()
    {     
        $ancho=$this->ancho;
        $altura=$this->altura;

        $evaluacion=$this->evaluacion;
        $cont=0;
        for ($i=1; $i <12 ; $i++) { 
            $campo="casilla_".$i;
            if($evaluacion->$campo!="")
            {
                $data[$i]=$campo;
                $cont++;
            }
        }
        $this->data_evaluacion=$data;

        $numero_columnas=$cont/2+1;
        $columna_ancho=$ancho*0.18/$numero_columnas;

        $this->numero_columnas=$numero_columnas;
        $this->columna_ancho=$columna_ancho;
        $this->cont_evaluacion=$cont;

        $num=0;
        $semestre=0;

        $this->SetY($this->y_1);
        $this->SetX($this->x_1);
        if(!empty($data))
        {
            foreach ($data as $key => $value) {
                $num++;
                $this->Rotate(90);
                $this->Cell($ancho*0.176, $columna_ancho, utf8_decode($evaluacion->$value), 1, 0, 'C');
                if($key%($cont/2)==0)
                {
                    $semestre++;

                    $this->SetY($this->y_1);
                    $this->SetX($this->x_1+$columna_ancho*($num));
                    $this->Rotate(90);
                    $this->Cell($ancho*0.176, $columna_ancho, utf8_decode("NOTA ".Funciones::numero_cardinal($semestre)." SEMESTRE"), 1, 0, 'C');
                    $num++;
                }
                $this->SetY($this->y_1);
                $this->SetX($this->x_1+$columna_ancho*($num));
            }    
        }
        
        
          

        $this->Rotate(0);
        
    }
    public function pie() {
        
        
    }
    public function reporte($carrera,$curso,$notas,$evaluacion)
    {   
        $this->carrera=$carrera;
        $this->curso=$curso;
        $this->evaluacion=$evaluacion;


        $ancho=340;
        $altura=220;
        $this->ancho=340;
        $this->altura=220;
        /*$this->estudiante=$estudiante;
        $this->carrera=$carrera;*/
        ini_set("session.auto_start", 0); 
        $this->configuracion=configuracion::find(1);
        
        

        $this->SetTopMargin(5);
        $this->SetLeftMargin(15);
        $this->SetRightMargin(15);
        $this->SetAutoPageBreak(1, 20);
        $this->AliasNbPages();
        //$this->AddPage('P', 'Legal');
        $this->AddPage('L',array($altura,$ancho));
        
        
        
        $this->cabecera2();

        $this->cabecera3();
        
        $this->SetY($this->y_1);
        $this->SetX($ancho*0.0421);
        
        $this->SetFont("Arial","",9);
        $cont=0;
        $num = 0;
        $numero_columnas=$this->numero_columnas;
        $columna_ancho=$this->columna_ancho;
        if(!empty($notas))
        {
            //for ($ivan=0; $ivan <100 ; $ivan++) { 
                
            
            foreach ($notas as $key => $value) {
                $cont++;
                $num++;
                if($num==15)
                {
                    $this->AddPage('L',array($ancho,$altura));
                    $this->cabecera2();
                    $this->cabecera3();
                    $this->SetFont("Arial","",9);    
                    $num=1;
                }
                $this->SetX($ancho*0.0421);
                $this->Cell($ancho*0.03, 6, utf8_decode($cont), 1, 0, 'C');         
                $this->Cell($ancho*0.2366, 6, utf8_decode($value->paterno." ".$value->materno." ".$value->nombre ), 1, 0, 'L');
                
                if(!empty($this->data_evaluacion))
                {
                    
                    $num_evaluacion=0;
                    $nota=0;
                    $nota_total=0;
                    foreach ($this->data_evaluacion as $key1 => $value1) {
                        $num_evaluacion++;
                        
                        $this->Cell($columna_ancho,6,  utf8_decode($value->$value1), 1, 0, 'C');
                        $nota=($value->$value1!="")?$nota+$value->$value1:$nota;
                        if($key1%($this->cont_evaluacion/2)==0)
                        {
                            $nota_aux=($nota>0)?$nota:"";
                            $this->Cell($columna_ancho,6 , utf8_decode($nota_aux), 1, 0, 'C');
                            $nota_total=$nota_total+$nota;
                            $nota=0;
                            $num_evaluacion++;

                        }
                        
                    }    
                }

                $promedio=($nota_total>0)?$nota_total/2:"";
                $promedio=floor($promedio);
                $promedio_aux=($promedio>0)?$promedio:"";
                $this->Cell($ancho*0.0424, 6, utf8_decode($promedio_aux), 1, 0, 'C');         
                $this->Cell($ancho*0.0424, 6, utf8_decode($value->segundo_turno ), 1, 0, 'C');

                if($value->nota_final!="")
                {
                    if($value->nota_final>=61)
                    {
                        $nota_final=$value->nota_final;
                        $observacion="APROBADÓ";
                    }
                    else if($value->segundo_turno!="")
                    {
                        $nota_final=$value->segundo_turno;   
                        $observacion="APROBADÓ";
                    }
                    else
                    {
                        $nota_final=$value->nota_final;
                        $observacion="REPROBADÓ";
                    }

                }
                else
                {
                    $nota_final="";
                    $observacion="ABANDONÓ";
                }
                
                $this->Cell($ancho*0.0424, 6, utf8_decode($nota_final ), 1, 0, 'C');
                $this->Cell($ancho*0.1616, 6, utf8_decode($observacion), 1, 1, 'C');  
                /*$this->Cell($ancho*0.0424, $altura*0.0424, utf8_decode("2 da. INSTANCIA"), 1, 0, 'C'); */



                
                
            }
        }
        //}
        if((14-$num)==0)
        {
            
        }
        else
        {
            for($i=1;$i<=(14-$num);$i++)
            {
                $this->SetX($ancho*0.0421);
                $this->Cell($ancho*0.03, 6, utf8_decode(""), 1, 0, 'C');         
                $this->Cell($ancho*0.2366, 6, utf8_decode(""), 1, 0, 'C');
                $num_evaluacion=0;
                foreach ($this->data_evaluacion as $key1 => $value1) {
                        $num_evaluacion++;
                    $this->Cell($columna_ancho,6,  utf8_decode(""), 1, 0, 'C');
                    
                    if($key1%($this->cont_evaluacion/2)==0)
                    {
                        
                        $this->Cell($columna_ancho,6 , utf8_decode(""), 1, 0, 'C');
                        
                        $num_evaluacion++;

                    }
                    
                }    
                $this->Cell($ancho*0.0424, 6, utf8_decode(""), 1, 0, 'C');        
                $this->Cell($ancho*0.0424, 6, utf8_decode(""), 1, 0, 'C');
                $this->Cell($ancho*0.0424, 6, utf8_decode("" ), 1, 0, 'C');
                $this->Cell($ancho*0.1616, 6, utf8_decode(""), 1, 1, 'C');  
                
            }
        }
        
        
        
             

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
        $ancho=$this->ancho;
        $altura=$this->altura;
        $this->SetY(-25);
        $this->SetX($ancho*0.1754);

        $this->SetFont("Arial","B",8);
        $this->Cell($ancho*0.1403, 3, utf8_decode("......................................................"), 0, 0, 'C');     
        $this->Cell($ancho*0.3684, 3, utf8_decode(""), 0, 0, 'C');  
        $this->Cell($ancho*0.1578, 3, utf8_decode("......................................................"), 0, 1, 'C');        
        $this->SetX($ancho*0.1754);

        $this->SetFont("Arial","",8);
        $this->Cell($ancho*0.1403, 3, utf8_decode("JEFE ACADEMICO"), 0, 0, 'C');     
        $this->Cell($ancho*0.3684, 3, utf8_decode(""), 0, 0, 'C');  
        $this->Cell($ancho*0.1578, 3, utf8_decode("RECTOR O DIRECTOR"), 0, 1, 'C');        

        $this->SetX($ancho*0);
        $this->SetFont("Arial","",8);
        $this->Cell($ancho,3, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');      

        
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
