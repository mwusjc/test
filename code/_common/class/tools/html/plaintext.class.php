<?php   
/** CText
* @package html
* @since May 25
* @author cgrecu
*/


class CText extends CObject{
	
	var $mTxt;
	var $mName;

  /** comment here */
  function CText($pName, $pTxt) {
	  $this->CObject();
	  $this->mName = $pName;
	  $this->mTxt = $pTxt;
  }

  /** comment here */
  function generate() {
  	$this->assign($this->mName, $this->mTxt);
  }

  /** comment here */
  function display() {
	$this->generate();
  	Return $this->mTxt;
  }

}

?>
