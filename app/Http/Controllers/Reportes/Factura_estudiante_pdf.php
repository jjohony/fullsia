<?php
namespace App\Http\Controllers\Reportes;
use App\Helpers\NumberToLetterConverter;
use App\Helpers\EnLetras;
use App\Helpers\Funciones;

//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Library/fpdf/fpdf.php');

class Factura_estudiante_pdf extends \FPDF {
    public $configuracion;
    public $factura;
    public function Header(){
    
    
    }
 
    public function pdf()
    {
        $this->SetFillColor(255, 255, 255); 
        $this->SetTextColor(6, 6, 6);
        $this->SetDrawColor(0, 0,0 );

        $folio=Funciones::serear_numero_dinamico($this->factura->folio,5);
        $this->Image('img/'.$this->configuracion->logo_reporte_imagen, 15,$this->GetY()+5, 25,20);
        
        
        
        $this->SetX(10);
        

        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $tam=3;
        
        $this->SetX(100);
        $this->Cell(35, $tam, utf8_decode('NIT:'), 0, 0, 'R',true);
        $this->Cell(40, $tam, utf8_decode(''.$this->configuracion->nit), 0, 0, 'R',true);
        $this->Cell(10, $tam, utf8_decode(''), 0, 1, 'R',true);
        $this->SetX(100);
        $this->Cell(35, $tam, utf8_decode('FACTURA Nº:'), 0, 0, 'R',true);
        

        
        $this->Cell(40, $tam, utf8_decode(''.$folio), 0, 0, 'R',true);
        $this->Cell(10, $tam, utf8_decode(''), 0, 1, 'R',true);
        $this->SetX(100);
        $this->Cell(35, $tam, utf8_decode('AUTORIZACION Nº:'), 0, 0, 'R',true);
        $this->Cell(40, $tam, utf8_decode(''.$this->configuracion->numero_autorizacion), 0, 0, 'R',true);
        $this->Cell(10, $tam, utf8_decode(''), 0, 1, 'R',true);
        $this->SetX(100);
        

        $this->Ln(2);
        $this->SetX(100);
        $this->SetFont('Arial', 'B', 11);
        
        $this->Ln(2);
        $this->SetFont('Arial', 'B', 8);
        $this->SetX(100);
        $this->Ln(1);
        
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(185, 5, utf8_decode('FACTURA'), 0,1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(185, 4, utf8_decode('ORIGINAL'), 0,1, 'C');
        $this->AliasNbPages();
        $this->SetFont('Arial', 'B', 8);
        
        $this->Ln();

        $this->SetDrawColor(209, 206,204 );
        
        
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 5, utf8_decode('A nombre de:'), 0,0, 'L',true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(58, 5, utf8_decode(''.$this->factura->a_nombre_de), 0,0, 'L',true);
        
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 5, utf8_decode('NIT/CI:'), 0,0, 'L',true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30,5, utf8_decode(''.$this->factura->nit_cliente), 0,0, 'L',true);
        
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 5, utf8_decode('Fecha: '), 0,0, 'L',true);
        $this->SetFont('Arial', '', 9);
        $funciones=new Funciones();
        $fecha=$funciones->fecha_literal($this->factura->fecha,4);
        $this->Cell(93, 5, utf8_decode($fecha." ".date("H:i:s",strtotime($this->factura->created_at))), 0,1, 'L',true);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 5, utf8_decode('Estudiante'), 0,0, 'L',true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(58, 5, utf8_decode($this->factura->paterno.' '.$this->factura->materno.' '.$this->factura->nombre), 0,0, 'L',true);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 5, utf8_decode('Gestion:'), 0,0, 'L',true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30,5, utf8_decode(''.$this->factura->gestion), 0,1, 'L',true);

        
        
        $this->SetFillColor(153, 180, 209);
        $this->SetTextColor(6, 6, 6);
        $this->SetDrawColor(193, 193, 193);

        $this->SetFont('Arial', '', 7);
        $tam=5;
        $rec=1;

        $this->Cell(30, $tam, utf8_decode('CANTIDAD'), $rec, 0, 'C', true);     
        $this->Cell(105, $tam, utf8_decode('CONCEPTO'), $rec, 0, 'C', true);         
        $this->Cell(30, $tam, utf8_decode('PRECIO/UNITARIO'), $rec, 0, 'C', true);
        $this->Cell(30, $tam, utf8_decode('TOTAL'), $rec, 1, 'C', true);

        $this->Cell(30, 10, utf8_decode($this->factura->cantidad), 1, 0, 'C');     
        $this->Cell(105, 10, utf8_decode($this->factura->concepto_pago), 1, 0, 'C');         
        $this->Cell(30, 10, utf8_decode(number_format($this->factura->monto,2)), 1, 0, 'C');
        $this->Cell(30, 10, utf8_decode(number_format($this->factura->monto*$this->factura->cantidad,2)), 1, 1, 'C');

        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 9);
        
        $tam=4;
        $bandera = false; 
        $numero=0;
        $SumaTotal=0;
        
         
        $this->SetFillColor(153, 180, 209); 
        $this->SetTextColor(6, 6, 6); 
        $this->Cell(165, $tam, utf8_decode('TOTAL'), $rec, 0, 'C', true);
        $this->SetFillColor(255, 255, 255); 
        $this->SetTextColor(3, 3, 3); 
        $this->Cell(30, $tam, utf8_decode(number_format($this->factura->monto*$this->factura->cantidad,2,".",",")), $rec, 0, 'C', true);
        $this->Ln();
        $this->SetFont('Arial', '', 9); 
        $convetidor=new EnLetras();
        $SumaTotal_literal=$convetidor->ValorEnLetras($this->factura->monto*$this->factura->cantidad,"");

        $this->Cell(195, $tam, utf8_decode("SON: ".strtoupper($SumaTotal_literal)), $rec, 1, 'L', true);
        $this->Ln(5);
        $this->SetFont("Arial","B",8);
        $this->SetX(10);
        $this->Cell(50, 3, utf8_decode("CODIGO DE CONTROL: "), 0, 0, 'L', true);
        $this->SetFont("Arial","",8);
        $this->Cell(50, 3, utf8_decode("".$this->factura->codigo_control), 0, 0, 'L', true);
        $this->Image('qrcodes/'.$this->factura->imagen_qr, 180,$this->GetY(), 15,15);
        $this->Ln();
        $this->SetFont("Arial","B",8);
        $this->Cell(50, 3, utf8_decode("Fecha Limite de Emisión: "), 0, 0, 'L', true);
        $this->SetFont("Arial","",8);
        $this->Cell(50, 3, utf8_decode("".date("d / m / Y",strtotime($this->configuracion->fecha_maxima_emision))), 0, 0, 'L', true);
        $this->Ln(5);
        $this->SetFont("Arial","I",6);
        $this->Cell(185, 3, utf8_decode("ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS, EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LA LEY."), 0, 1, 'C');
        $this->Ln(15);
    }



    public function reporte($factura,$configuracion)
    {
        $this->factura=$factura;
        $this->configuracion=$configuracion;

        
        
        $this->SetTopMargin(10);
        //$this->SetLeftMargin(20);
        $this->SetRightMargin(10);
        $this->SetLeftMargin(10);
        $this->AddPage('P',"LETTER");   
        

        $this->SetTopMargin(15); //apartir del Header
        
        $this->SetAutoPageBreak(1, 0);
        
        
        $this->pdf();
        $this->pdf();
        $this->pdf();
        
        
        $id='Factura';
        $nombre=$id.' .pdf';          
        $this->Output($nombre, 'I');//$this->Output();
        exit;
    }


    public static function pdf_por_dia(request $request)
    {
        $dato=$request->get('fecha');    
        $row=Factura::venta_porDia_pdf($request, $dato);
        $row2=Factura::producto_factura();
        //$row=$producto;
        $this->SetTopMargin(15); //apartir del Header
        $this->SetLeftMargin(20);
        $this->SetRightMargin(19);
        $this->SetAutoPageBreak(1, 20);
        $this->AddPage();
        //$this->Image('img/Logo2.jpg', 10, 8, 40);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 9);

        $tam=6;
        $rec=1;
        $this->Cell(185, $tam, utf8_decode('REPORTE DE VENTAS'), 0, 1, 'C');$this->Ln(0);
        $this->Cell(185, $tam, utf8_decode(''.date("d - m - Y H:i:s")), 0, 1, 'C');
        $this->Ln(5);

        foreach ($row2 as $key => $value2) {
            $tam=6;
            $rec=1;
            $this->Cell(80, $tam, utf8_decode('N° Factura : '.$value2->folio.''), 0, 0, 'L');
            $this->Cell(80, $tam, utf8_decode('NIT : '.$value2->nit.''), 0, 1, 'L');
            $this->Cell(80, $tam, utf8_decode('Cliente: '.$value2->nombre_completo.''), 0, 0, 'L');
            $this->Cell(80, $tam, utf8_decode('CI.: '.$value2->ci.' - '.$value2->expedido), 0, 1, 'L');$this->Ln(5);
            $this->SetFillColor(239, 237, 237); 
            $this->SetTextColor(6, 6, 6);
            $this->SetDrawColor(193, 193, 193);
        //$this->SetTextColor(3, 3, 3); 
            $this->SetFont('Arial', '', 7);
            $tam=8;
            $rec=1;
            $this->Cell(10, $tam, utf8_decode('Nº'), $rec, 0, 'C', true);
        //$this->SetDrawColor(255, 255, 255);
            $this->Cell(55, $tam, utf8_decode('PRODUCTO'), $rec, 0, 'C', true);         
            $this->Cell(30, $tam, utf8_decode('CODIGO_PRODUCTO'), $rec, 0, 'C', true);    
            $this->Cell(25, $tam, utf8_decode('CANTIDAD'), $rec, 0, 'C', true);     
            $this->Cell(25, $tam, utf8_decode('PRECIO/UNITARIO'), $rec, 0, 'C', true);
            $this->Cell(25, $tam, utf8_decode('TOTAL'), $rec, 0, 'C', true);
            $this->Ln();
            $tam=6;
            $bandera = false; 
            $numero=0;
            $SumaTotal=0;
            

            foreach ($row as $key => $value) 
            {
                if($value2->id_fac==$value->id_fac)
                {
            $this->SetFillColor(255, 255, 255);//celeste claro
            $this->SetDrawColor(193, 193, 193);
            $this->SetTextColor(3, 3, 3); 
            $this->SetFont('Arial', '', 7); 
            $numero=$numero+1;
            $cant = $value->cantidad;
            $precio = $value->precio_unitario;
            $total = $cant * $precio;
            $SumaTotal = $SumaTotal+$total;
            $this->Cell(10, $tam, utf8_decode($numero), $rec, 0, 'C', $bandera);
            $this->Cell(55, $tam, utf8_decode($value->descripcion), $rec, 0, 'C', $bandera); 
            $this->Cell(30, $tam, utf8_decode($value->codigo_producto), $rec, 0, 'C', $bandera);  
            $this->Cell(25, $tam, utf8_decode($value->cantidad), $rec, 0, 'C', $bandera);         
            $this->Cell(25, $tam, utf8_decode("Bs ".$value->precio_unitario), $rec, 0, 'C', $bandera);
            $this->Cell(25, $tam, utf8_decode("Bs ".$total), $rec, 0, 'C', $bandera);
            $this->SetFont('Arial', '', 6); 
            $this->SetFont('Arial', '', 7); 
            $this->Ln();
            $bandera = !$bandera;
        }
    } 
    $this->SetFillColor(239, 237, 237); 
    $this->SetTextColor(6, 6, 6); 
    $this->Cell(145, $tam, utf8_decode('TOTALES'), $rec, 0, 'C', true);
    $this->SetFillColor(255, 255, 255); 
    $this->SetTextColor(3, 3, 3); 
    $this->Cell(25, $tam, utf8_decode("Bs ".$SumaTotal), $rec, 0, 'C', true);
    $this->Ln();
    $this->Ln(15);
}
        //
/*$this->SetY(-50);
$this->SetFont('Arial', '', 8);
$this->SetTextColor(0, 0, 0); 
$this->Cell(100, $tam, '--------------------------------------------------', 0, 0, 'C');        
$this->Cell(100, $tam, '--------------------------------------------------', 0, 0, 'C'); 
$this->Ln(3);
$this->Cell(100, $tam, utf8_decode('RECIBI CONFORME'), 0, 0, 'C');       
$this->Cell(100, $tam, utf8_decode('ENTREGUE CONFORME'), 0, 0, 'C');
$this->Ln(12);
$this->SetTextColor(0, 0, 0); 
$this->Cell(0, 0, utf8_decode('Nota.-'), 0, 0, 'L');        
$this->Ln();
$this->Cell(0, 8, utf8_decode('Queda nula el acta, si cuenta con enmiendas o rasaduras.'), 0, 0, 'L');$this->Ln(3);
$this->Cell(0, 8, utf8_decode('Debe llevar las firmas correspondientes y sellos.'), 0, 0, 'L');$this->Ln(3);
$this->Cell(0, 8, utf8_decode('Las copias originales deben ser remitidas a la Administracion con dos copias.'), 0, 0, 'L');
$this->Ln(9);
$this->SetTextColor(0, 0, 0);
$this->SetFont('Arial', 'B', 9);*/
        //foreach ($data as $key => $value) {}
$id='Acta de Ingrso';
$nombre='Reporte '.$id.' .pdf';          
        $this->Output($nombre, 'I');//$this->Output();
        exit;
    }
    public function Footer()
    {
        
        
    }
}

