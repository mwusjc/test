<?php   
/** CHidden
* @package html
* @author cgrecu
*/


class CHidden extends CInput {
/** comment here */

  function CHidden($pName, $pValue) {
	$this->CInput($pName, "hidden", $pValue);	  
  }

  /** comment here */
  function display() {
	$tmp = "";
	$tmp .= "<input type=\"hidden\" name=\"$this->mName\" value=\"".htmlentities($this->mValue)."\"";
	$tmp .= $this->addCommonAttributes();
	$tmp .= " />\n";
	$this->assign($this->mName, $tmp);
	Return $tmp;
  }

}

?>
