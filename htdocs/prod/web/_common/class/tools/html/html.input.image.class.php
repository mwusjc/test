<?php   
/** html input types
* @package HTML
* @since February 09
* @author cgrecu
*/
class CInputImg extends CInput{

  var $mType;
  var $mSrc;
  var $mValue;
  var $mChecked;
  var $mSize;
  var $mMaxLength;
  var $mDataType;//values are: string; integer; float; email; url; 
  

  /** constructor */
  function CInputImg($pName, $pSrc = "") {
	$this->CInput($pName, "image", "");
	$this->mSrc = $pSrc;
  }

  /** comment here */
  function generate() {
	CInput::generate();
	if ($this->mSrc) $this->assign($this->mName."_SRC", $this->mSrc);
  }

}

?>