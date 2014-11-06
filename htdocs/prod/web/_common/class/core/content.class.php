<?php   
  
  class CContent extends CDBContent {
	
	/** comment here */
	function CContent($pTable, $pID = "") {
		$this->table = $pTable;
		$this->CDBContent($pID);
	}

  }

?>