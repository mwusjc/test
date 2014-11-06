<?php   
/** CInputT
* @package html
* @author cgrecu
*/


class CInputRadio extends CInput {
/** comment here */
  var $mChecked = false;

  function CInputRadio($pName, $pValue, $pIndex = 1) {
	$this->CInput($pName, "radio", $pValue);	  
	$this->mIndex = $pIndex;
  }

  /** set the check boolean */
  function setChecked($pIsChecked = true) {
	  $this->mChecked = $pIsChecked;
  }

  /** comment here */
  function generate() {
	CFormElement::generate();
	if ($this->mValue) $this->assign($this->mName.$this->mIndex."_VALUE", htmlentities($this->mValue));
	if ($this->mChecked) $this->assign($this->mName.$this->mIndex."_CHECKED", "checked=\"checked\"");
  }

  /** creates the html code for the input element */
  function display() {
	$tmp = "";

	$tmp .= "<input type=\"$this->mType\" name=\"$this->mName\" value=\"".htmlentities($this->mValue)."\"";
	if ($this->mChecked) $tmp .= " checked=\"checked\" ";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= "/>\n";
//	if ($this->mRequiredFlag && $this->mShowRequiredVisualIndicator) $tmp .= "<span style=\"color: ".$this->mColHead."\">*</span>";
	$this->assign($this->mName.$this->mIndex, $tmp);
	Return $tmp;
  }

  /** comment here */
  function validate($pMsg) {
  	$this->mErrorEmptyMsg = $pMsg;
	$this->mValidateMe = true;
  }

  /** comment here */
  function getValidation() {
	  $tmp = "if (!(x.".$this->mName.".disabled == true)) { ";
	  if ($this->mValidateForEmpty) 
		$tmp .= " var i; 
					  var radios = x.".$this->mName."; 
					  var isPass = false; 
					  if (radios[0]) { 
						for (i=0;i<radios.length;i++) { 
						  if (radios[i].checked) isPass = true; 
						} 
					  } else {
						if (radios.checked)  isPass=true; 
						if (isPass == false) { 
						  failRadioValidation(x.".$this->mName.", i, '".$this->mErrorInvDataTypeMsg."');\n 
						  err_id = -1; 
						 }
					  }";
	  Return $tmp;
  }

}

?>
