<?php   
/** CPageManager
* @package admin
* @author cgrecu
*/


  class CPageManager extends CSectionManager {
	/** comment here */
	function CPageManager() {
	  $this->CSectionManager();		
	}

	/** comment here */
	function mainSwitch() {
	  switch($this->mOperation) {
		  case "show":
		  case "view":
			$vPage = new CPage($_GET["id"]);
			$vTable = new CBoxTable($vPage->display(), $vPage->mRowObj->Title, "", "standard");
			Return $vTable->display();
	  }
	}
  }

?>
