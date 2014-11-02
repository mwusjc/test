<?php   
/** CInputT
* @package html
* @author cgrecu
*/


class CCheckbox extends CInput {
/** comment here */
  var $mChecked = false;

  function CCheckbox($pName, $pValue, $pChecked = false) {
	$this->CInput($pName, "checkbox", "on");	  
	$this->mValue = $pValue;
	$this->setChecked($pChecked);
  }

  /** set the check boolean */
  function setChecked($pIsChecked = true) {
	  $this->mChecked = $pIsChecked;
  }

  /** comment here */
  function generate() {
	CInput::generate();
	if ($this->mChecked) $this->assign($this->mName."_CHECKED", "checked=\"checked\"");
  }

  /** creates the html code for the input element */
  function display() {
	$tmp = "";

	$tmp .= "<input type=\"checkbox\" name=\"$this->mName\" value=\"".htmlentities($this->mValue)."\"";
	if ($this->mChecked) $tmp .= " checked=\"checked\" ";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= "/>\n";
//	if ($this->mRequiredFlag && $this->mShowRequiredVisualIndicator) $tmp .= "<span style=\"color: ".$this->mColHead."\">*</span>";
	$this->assign($this->mName, $tmp);
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
		  $tmp .= "\t if (!x.".$this->mName.".checked) {\n 
							  failValidation(x.".$this->mName.", '".$this->mErrorEmptyMsg."');\n 
						\t\t err_id = -1; \n 
						\t};\n";
	  $tmp .= "}\n";
	  Return $tmp;
  }

}

?>
