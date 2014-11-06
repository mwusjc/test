<?php   
/** html input types
* @package HTML
* @since February 09
* @author cgrecu
*/
class CInput extends CFormElement{

  var $mType;
  var $mValue;
  var $mSize;
  var $mMaxLength;
  var $mDataType;//values are: string; integer; float; email; url; 
  var $mRequiredFlag = false; 
  var $mShowRequiredVisualIndicator = true; 

  /** constructor */
  function CInput($pName, $pType, $pValue = "") {
	$this->CFormElement();
  	$this->setName($pName);
	$this->setType($pType);
	$this->setValue($pValue);
  }

  /** comment here */
  function setValue($pValue) {
	$this->mValue = $pValue;
	$pName = $this->mName;
	if (!$this->mValue && isset($_POST[$pName]) && $_POST[$pName] && $this->mType != 'file') $this->mValue = $_POST[$pName];
  }

  /** comment here */
  function setType($pType) {
  	$this->mType = $pType;
  }

  /** comment here */
  function validate($pMsg) {
  	$this->mErrorEmptyMsg = $pMsg;
	$this->mValidateMe = true;
  }

  /** comment here */
  function generate() {
	CFormElement::generate();
	if ($this->mValue) $this->assign($this->mName."_VALUE", htmlentities($this->mValue));
  }

  /** comment here */
  function display() {
  	$this->error("input display method MUST be overwritten", 1);
  }

}

?>