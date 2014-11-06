<?php   
/** CSubmit
* @package html
* @since February 06
* @author cgrecu
*/


class CSubmit extends CButton {
	
	/** comment here */
	function CSubmit($pValue = "Save", $pFrmName = "frmEdit") {
	  $this->CButton("btSubmit" . uniqid("ptc"), $pValue);
	  $this->setJavaScript("onClick", $pFrmName . "_validate();");
	  $this->mClassName = "submit";
	}

}

?>
