<?php   

class CChart {

	var $mType;

	/** comment here */
	function CChart($type = 'Column3D') {
		$this->mType = $type;
	}

	/** comment here */
  function display($dataset) {
	  require "_common/class/libs/charts/FusionCharts.php";
	  Return renderChartHTML("_common/class/libs/charts/".$this->mType.".swf", "", urlencode($dataset), "Whatever", 820, 400, false);
  }

}
?>