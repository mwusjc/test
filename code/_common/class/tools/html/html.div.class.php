<?php   
/** CDiv
* @package html
* @since March 31
* @author cgrecu
*/


class CDiv extends CHtmlEntity {
  
  var $mText;
  var $mID;

  /** comment here */
  function CDiv($pText, $pClass = "") {
	$this->CHtmlEntity();
	$this->mText = $pText;	
	if (!$this->mID) $this->mID = "randdiv" . rand(1,1000);
	if ($pClass) $this->setClass($pClass);
  }

  /** comment here */
  function display() {
	Return "<div " . $this->addCommonAttributes() . " >" . $this->mText . "</div>";
  }

}

?>
