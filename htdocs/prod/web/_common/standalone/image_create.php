<?php   

	require_once "class/modules/jpgraph/src/jpgraph.php";
	require_once "class/modules/jpgraph/src/jpgraph_pie.php";
	require_once "class/modules/jpgraph/src/jpgraph_pie3d.php";

	  $graph = new PieGraph(740,400,"auto");
	  $graph->SetShadow();

	  // Set A title for the plot
	  $graph->title->Set(base64_decode($_GET["q3"]));
	  $graph->title->SetFont(FF_FONT1,FS_BOLD,14); 
	  $graph->title->SetColor("brown");

	  // Create pie plot
	  $p1 = new PiePlot3d(unserialize(base64_decode($_GET["q1"])));
	  $p1->SetTheme("sand");
	  $p1->SetCenter(0.4);
	  $p1->SetAngle(40);
	  $p1->value->SetFont(FF_FONT1,FS_NORMAL,12);
	  $p1->SetLegends(unserialize(base64_decode($_GET["q2"])));
	  $p1->SetHeight(10); 

	  $graph->Add($p1);
	  $graph->Stroke();
?>