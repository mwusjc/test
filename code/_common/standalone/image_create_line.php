<?php   
		
        include ("class/modules/jpgraph/src/jpgraph.php");
        include ("class/modules/jpgraph/src/jpgraph_line.php");

        // Create the graph.
        $graph = new Graph(530,300,"auto");
        $graph->SetScale("textlin");
        $graph->SetMargin(60,40,20,40);
        $graph->SetFrame(true, "#cccccc",1);
        $graph->SetShadow();
        $graph->SetMarginColor("#eeeeee@0.1");
        $graph->xaxis->SetTickLabels(unserialize(base64_decode($_GET["q2"])));
        $graph->SetAlphaBlending(true);
        $graph->title->Hide();
        $graph->legend->SetPos(0.02,0.01);

        // Create the linear error plot
        $l1plot=new LinePlot(unserialize(base64_decode($_GET["q1"])));
        $l1plot->SetColor("red");
        $l1plot->SetWeight(2);
        //$l1plot->SetLegend(base64_decode($_GET["q4"]));

        //Center the line plot in the center of the bars
        $graph->Add($l1plot);


        $graph->title->Set(base64_decode($_GET["q4"]));
        $graph->xaxis->title->Show();
        $graph->yaxis->title->Set(base64_decode($_GET["q3"]));
        $graph->yaxis->SetTitleMargin(40);
        //$graph->yaxis->title->SetLabelAlign("left");

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

     // Display the graph
        $graph->Stroke();


?>