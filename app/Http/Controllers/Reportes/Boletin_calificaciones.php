<?php  
namespace App\Http\Controllers\Reportes;
use App\Models\configuracion;
use App\Helpers\Funciones;
include_once "../app/Library/fpdf/fpdf.php";

class Boletin_calificaciones extends \FPDF
{
 
      var $tituloEncabezado;
    var $tamanioCampo;
    var $tituloHeader;
    var $altoCelda;
    var $tamLetra;
    var $bordeCelda;
    public function Header__() {
        
    }
    public function cabecera_general()
    {   
        $configuracion=configuracion::find(1);
        $this->SetMargins(18, 0 , 0);
        $this->AddFont('EdwardianScriptITC', 'I', 'EdwardianScriptITC.php');
        $this->AddFont('Erinal', 'I', 'Erinal.php');
        $this->AddFont('Episode', 'I', 'Episode.php');
        $this->AddFont('Splash', 'I', 'Splash.php');
        $this->AddFont('helvetica', 'I', 'helvetica.php');
        $this->SetFillColor(105, 105, 105); //Gris tenue de cada fila
        //$this->Image('../public/img/imagen.jpg', 20, 7, 25, 25);
        $this->SetTextColor(0, 0, 0); //Color del texto: Negro
        $this->Ln(-15);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 3, utf8_decode($configuracion->nombre), 0, 0, 'C');  
        $this->Ln(7);
        $this->SetFont('Arial', 'I', 9);   //TAMAÃ‘O DE LETRA     
        $this->Cell(0, 5, 'R.M. Nro. '.$configuracion->r_m, 0, 0, 'C');
        $this->Ln(3);
        $this->Cell(0, 0, '', 0, 0, 'C');       
        $this->SetFont('Arial', '', $this->tamLetra);
        $this->SetFont('Arial', 'B', 15);
        $this->Ln(8);
        $this->Cell(0,0,'BOLETIN DE CALIFICACIONES',0,0,'C');
        $this->SetFillColor(0, 0, 0); //Gris tenue de cada fila
        $this->SetFillColor(135, 206, 235);//celeste
        $this->SetFillColor(3, 149, 190);//celeste
        $this->SetTextColor(255, 255, 255); //Color del texto: Negro
       $this->Ln(2);
    }
    public function cabecera2($curso)
    {     
        $this->SetTopMargin(30);
        $this->SetLeftMargin(25);
        $this->SetRightMargin(25);
        $this->SetAutoPageBreak(1, 20);
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();
        $this->SetTitle("Acta de Calificaciones");           
        $this->SetMargins(18, 0 , 0);
        $this->SetFont('Arial', '', 9);
        $this->Ln(5);
        $this->Cell(90,5,'SIGLA: '.$curso->sigla_asignatura,0,0,'L');
        $this->Cell(60,5,utf8_decode('MATERIA: '.$curso->asignatura),0,1,'L');

        $this->Cell(90,5,utf8_decode('CARRERA: '.$curso->carrera),0,0,'L');
        
        
        $this->Cell(60,5,utf8_decode('MODALIDAD: '.strtoupper($curso->modalidad_asignatura)),0,0,'L');
        $this->Cell(60,5,utf8_decode('PARALELO: "'.$curso->paralelo_curso.'"'),0,1,'L');

        $this->Cell(90,5,utf8_decode('DOCENTE: '.$curso->grado_academico." ".$curso->nombre." ".$curso->paterno." ".$curso->materno),0,0,'L');
        
        $this->Cell(60,5,utf8_decode(/*'NIVEL: '.strtoupper($curso->modalidad_asignatura)*/""),0,0,'L');
        
        if($curso->periodo_gestion){$per=$curso->periodo_gestion.'/';}
        else{$per='';}

        $this->Cell(60,5,utf8_decode('GESTION: '.$per.''.$curso->gestion),0,1,'L');        

        
    }
    public function cabecera3()
    {    
        $evaluacion=$this->evaluacion; 
        ini_set("session.auto_start", 0);
        $this->SetTopMargin(30);
        $this->SetLeftMargin(18);
        $this->SetRightMargin(25);
        $this->SetAutoPageBreak(1, 20);
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();
        $this->SetTitle("Acta de Calificaciones");           
        $this->SetMargins(18, 0 , 0);
        $this->SetFont('Arial', 'B',6.5);

        $this->SetFont('Arial', 'B',9);
        $this->SetFont('Arial', 'B',6.5);
        
        
        $this->SetFont('Arial', '', 8);
        
        $this->SetWidths(array(9,70));
        $this->SetHeights(array( 13, 13));
        $this->SetTamanio_font(array( 11, 11));
        $data_evaluacion[]=utf8_decode('N°');
        $data_evaluacion[]=utf8_decode('APELLIDOS Y NOMBRES');        
        if(!empty($evaluacion))
        {
            $cont_evaluacion=0;
          for($i=0;$i<12;$i++){
            $campo="casilla_".($i+1);
            if($evaluacion->$campo!="")
            {
              $cont_evaluacion++;
            }    
          }
          for($i=0;$i<12;$i++){
            $campo="casilla_".($i+1);
            if($evaluacion->$campo!="")
            {
              $this->widths[]=71/$cont_evaluacion;
              $data_evaluacion[]=$evaluacion->$campo;
            }    
          }
        }

        $this->widths[]=10;

        $data_evaluacion[]=utf8_decode('Nota Final 100%');

        $this->widths[]=10;
        $data_evaluacion[]=utf8_decode('Nota Hab.  70%');

        $this->widths[]=22;
        $data_evaluacion[]=utf8_decode('OBSERVACIONES');
        $filas_dato = $data_evaluacion;
        
        
        $this->SetFont('Arial', '', 8);
        
        

        $this->Row($filas_dato, 3, 3); 
        $this->cont_evaluacion=$cont_evaluacion;
        
    }
    public function pie() {
        //$this->Ln(14);
        $this->Cell(10,10,'',0,0,'L');
        
    }
    public function reporte($curso,$notas,$evaluacion)
    {   
        $this->evaluacion=$evaluacion;
        ini_set("session.auto_start", 0); 

        $this->SetTopMargin(30);
        $this->SetLeftMargin(25);
        $this->SetRightMargin(25);
        $this->SetAutoPageBreak(1, 20);
        //$this->AddPage('P', 'Legal');
        $this->AddPage('P',array(215,329));
        $this->cabecera_general();
        $this->cabecera2($curso);
        $this->cabecera3();
        $cont=0;
        $num = 0;
        $aprovados=0;
        $reprovados=0;
        $nsp=0;
        $x=0;        
        if(!empty($notas))
        {
            foreach ($notas as $key=>$value)
            { 
                $num++;
                if($num>40)
                {
                    
                    $this->pie();
                    $this->SetTopMargin(30);
                    $this->SetLeftMargin(25);
                    $this->SetRightMargin(25);
                    //$this->SetBottomMargin(0);
                    $this->SetAutoPageBreak(1, 20);
                    $this->AddPage('P',array(215,329));
                    $this->cabecera_general();
                    $this->cabecera2($curso);
                    $this->cabecera3();
                    $num=1;
                }
                $cont++; 
                if($value->nota_final==0){
                    $resultado=utf8_decode("NO SE PRESENTÓ");
                    $nsp++;
                }
                else{
                    if($value->nota_final<66){
                        if($value->segundo_turno<70){
                            $resultado="REPROBADO";
                            $x=$value->nota_final;
                            $reprovados++;
                        }
                        else{
                            $resultado="APROBADO";
                            $x=$value->segundo_turno;
                            $aprovados++;
                        }
                    }
                    else{
                        $resultado="APROBADO";
                        $x=$value->nota_final;
                        $aprovados++;
                    }
                    if($value->nota_final==0||$value->nota_final==""){
                        $resultado=utf8_decode("NO SE PRESENTÓ");
                        $x=0;
                    }
                }
                $this->SetFont('Arial', '', 9);
                $this->Cell(9,4,$cont,1,0,'C');            

                $this->AjustaCelda(70,4,utf8_decode(strtoupper($value->paterno." ".$value->materno." ".$value->nombre)),1,0,'L');
                if(!empty($evaluacion))
                {
                 
                  for($i=0;$i<12;$i++){
                    $campo="casilla_".($i+1);
                    if($evaluacion->$campo!="")
                    {
                      $this->Cell(71/$this->cont_evaluacion,4,utf8_decode(strtoupper($value->$campo)),1,0,'C');
                    }    
                  }
                }                       
                $this->Cell(10,4,utf8_decode(strtoupper($value->nota_final)),1,0,'C');
                $this->Cell(10,4,utf8_decode(strtoupper($value->segundo_turno)),1,0,'C');
                $this->SetFont('Arial', '', 7);
                $this->Cell(22,4,$resultado,1,0,'C');
                
                
                $this->SetFont('Arial', '', 8);
                $this->Ln(4.1);
                if($num==40 && count($notas)!=40)
                {
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(22,4,'ADVERTENCIA: ',0,0,'L');
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(90,4,'Este documento queda nulo si en el hubiese hecho raspaduras, anotaciones o enmiendas.',0,0,'L');
                    $this->Ln(6);
                    $this->Cell(94,4,'',0,0,'L');
                    $this->SetFont('Arial', 'B', 11);
                    if($curso->fecha_fin_gestion!="0000-00-00"){
                        $fecha_fin_gestion=$curso->fecha_fin_gestion; 

                      }else{
                          $fecha_fin_gestion=date('Y-m-d');
                      }

                    $fecha_literal=$this->fecha_literal($fecha_fin_gestion);
                    $this->Cell(40,4,'Lugar  y  Fecha:  El Alto, '.$fecha_literal);
                    $this->Ln(8);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(22,4,  utf8_decode(''),0,0,'L');
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(37,4,  utf8_decode(''),0,0,'L');
                    $this->Ln(4);
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(22,4,'',0,0,'L');
                    $this->Cell(37,4,'',0,0,'L');
                    $this->Ln(4);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(16,4,'2da. Inst. =',0,0,'L');
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(43,4,'',0,0,'L');
                    $this->Ln(23);  
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(150,4,'',0,0,'C');
                    
                    $this->ln(5);
                    $this->Cell(80,4,'--------------------',0,0,'C');
                    $this->Cell(80,4,'--------------------',0,0,'C');
                    $this->ln();
                    $this->Cell(80,4,'DOCENTE',0,0,'C');
                    $this->Cell(80,4,'DIRECTOR(A)',0,0,'C');
                }
            }
        }
        
        $this->Cell(9,4,'xxx',1,0,'C');            
        $this->AjustaCelda(70,4,'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',1,0,'C');

        if(!empty($evaluacion))
        {
         
          for($i=0;$i<12;$i++){
            $campo="casilla_".($i+1);
            if($evaluacion->$campo!="")
            {
              $this->Cell(71/$this->cont_evaluacion,4,'xxx',1,0,'C');
            }    
          }
        }        
        
        $this->Cell(10,4,'xxx',1,0,'C');
        $this->Cell(10,4,'xxx','TB',0,'C',0);
//        $this->Cell(10,4,'xxxxxx',1,0,'L');
//        $this->Cell(10,4,'xxxxxx',1,0,'L');
        $this->Cell(22,4,'xxxxxxxxxxxx',1,0,'C');
        $this->Ln(4.1);
        
        if((39-$num)==0)
        {
            
        }
        else
        {
            for($i=1;$i<=(39-$num);$i++)
            {
                $this->Cell(9,4,'',1,0,'L');            
                $this->AjustaCelda(70,4,'',1,0,'L');
                if(!empty($evaluacion))
                {
                 
                  for($j=0;$j<12;$j++){
                    $campo="casilla_".($j+1);
                    if($evaluacion->$campo!="")
                    {
                      $this->Cell(71/$this->cont_evaluacion,4,'',1,0,'C');
                    }    
                  }
                }        
                
                $this->Cell(10,4,'',1,0,'C');
                $this->Cell(10,4,'','TB',0,'C',0);
                $this->Cell(22,4,'',1,0,'C');
                

                
                $this->Ln(4.1);
                
            }
        }

        

        $this->pieActa($aprovados,$reprovados,$nsp,$cont,$curso);
        
        $this->Output('reporte1.pdf', 'I');
    } 
    public function pieActa($aprovados,$reprovados,$nsp,$cont,$curso)
    {
        if($cont==0)
        {
            return ;
        }
        $meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'.'');
        $this->Cell(94,4,'',0,1,'L');
        $this->SetFont('Arial', 'B', 11);


        if($curso->fecha_fin_gestion!="0000-00-00"){
          $fecha_fin_gestion=$curso->fecha_fin_gestion; 
          
        }else{
            $fecha_fin_gestion=date('Y-m-d');
        }

        $fecha_literal=$this->fecha_literal($fecha_fin_gestion);
        

        $this->Cell(187,4,'Lugar  y  Fecha:  El Alto, '.$fecha_literal,0,0,'R');

        $this->Ln(8);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(22,4,  utf8_decode(''),0,0,'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(37,4,  utf8_decode(''),0,0,'L');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(35,4,'CUADRO RESUMEN',1,0,'C');
        $this->Cell(20,4,utf8_decode('N°'),1,0,'C');
        $this->Cell(20,4,'%',1,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial', '', 8);
        $this->Cell(22,4,'',0,0,'L');
        $this->Cell(37,4,'',0,0,'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(35,4,'APROBADOS',1,0,'L');
        $this->Cell(20,4,$aprovados,1,0,'C');
        $this->Cell(20,4,round($aprovados*100/$cont,1).'%',1,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(16,4,'',0,0,'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(43,4,'',0,0,'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(35,4,'REPROBADOS',1,0,'L');
        $this->Cell(20,4,$reprovados,1,0,'C');
        $this->Cell(20,4,round($reprovados*100/$cont,1).'%',1,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial', '', 8);
        $this->Cell(59,4,'',0,0,'L');
        $this->Cell(35,4,utf8_decode('NO SE PRESENTÓ'),1,0,'L');
        $this->Cell(20,4,$nsp,1,0,'C');
        $this->Cell(20,4,round($nsp*100/$cont,1).'%',1,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(59,4,'',0,0,'L');
        $this->Cell(35,4,'TOTAL DE ESTUDIANTES',1,0,'C');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20,4,$cont,1,0,'C');
        $this->Cell(20,4,'100%',1,0,'C');
        $this->Ln(5);  
        $this->SetFont('Arial', '', 7);
        $this->Cell(150,4,'',0,0,'C');
        
        $this->ln(20);
        $this->Cell(80,4,'--------------------',0,0,'C');
        $this->Cell(80,4,'--------------------',0,0,'C');
        $this->ln();
        $this->Cell(80,4,'DOCENTE',0,0,'C');
        $this->Cell(80,4,utf8_decode('DIRECTOR ACADÉMICO'),0,0,'C');

        $this->pie();
        
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
        // Select Arial italic 8
        $this->SetFont('Arial','BI',7);
        //$this->Cell(1,10,'',0,0,'L');
        // Print centered page number
        $this->Cell(100, 10, 'NOTA: El llenado del Boletin de Calificaciones debe ser computarizado sin alterar el formato de las celdas', 0, 0, 'L');
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
