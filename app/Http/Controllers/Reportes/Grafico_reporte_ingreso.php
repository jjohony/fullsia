<?php // content="text/plain; charset=utf-8"
namespace App\Http\Controllers\Reportes;

require_once ('../app/Library/jpgraph/src/jpgraph.php');
require_once ('../app/Library/jpgraph/src/jpgraph_pie.php');
require_once ('../app/Library/jpgraph/src/jpgraph_pie3d.php');

class Grafico_reporte_ingreso{
	public function grafico($data,$data_legend)
	{

		header('Content-type: image/png');
		// Some data
		//$data = array(40,60,21);

		// Create the Pie Graph. 
		$graph = new \PieGraph(350,250);

		$theme_class= new \VividTheme;
		$graph->SetTheme($theme_class);

		// Set A title for the plot
		$graph->title->SetFont(FF_VERDANA,FS_BOLD,18); 
		$graph->title->Set("INGRESOS");
		$graph->legend->SetFont(FF_VERDANA,FS_BOLD,10);



		$graph->img->SetImgFormat('png');
		// Create
		$p1 = new \PiePlot3D($data);
		$p1->SetSize(0.32);
		//$p1->SetLabels(array("Jan\n%.1f%%","Feb\n%.1f%%","Mar\n%.1f%%","Apr\n%.1f%%"),1);
		$graph->Add($p1);

		$p1->ShowBorder();
		$p1->SetColor('black');
		$p1->SetLegends($data_legend); 
		$p1->ExplodeSlice(1);

		$graph->Stroke(_IMG_HANDLER);

		$fileName = "tmp/".str_replace("0.","",microtime())."reporte_ingreso.png";
		$graph->img->Stream($fileName);

		// Mandarlo al navegador
		/*$graph->img->Headers();
		$graph->img->Stream();*/
		//$graph->Stroke();
		return $fileName;		
		  
	}
	
}


?>