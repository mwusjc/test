<?php   
/** CInputT
* @package html
* @author cgrecu
*/


class CButton extends CInput {
/** comment here */

  function CButton($pValue) {
	$pName = "bt".uniqid("button");
	$this->CInput($pName, "button", $pValue);	  
  }

  /** comment here */
  function generate() {
	CInput::generate();
  }

  /** comment here */
  function display() {
	$tmp = "";
	$tmp .= "<input type=\"".$this->mType."\" name=\"$this->mName\" value=\"".$this->mValue."\"";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= " />\n";
	$this->assign($this->mName, $tmp);
	Return $tmp;
  }

  /** comment here */
  function setAllowedValues($pValues, $pMsg = "Invalid range") {
  	$this->mAllowedValues = $pValues;
  	$this->mErrorInvDataRange = $pMsg;
  }

  /** comment here */
  function getValidation() {
	  $tmp = "if (!(x.".$this->mName.".disabled == true)) { ";
	  if ($this->mValidateForEmpty) 
		  $tmp .= "\t if (x.".$this->mName.".value == '".$this->mNullValue."') {\n 
							  failValidation(x.".$this->mName.", '".$this->mErrorEmptyMsg."');\n 
						\t\t err_id = -1; \n 
						\t};\n";
	  $tmp .= "}\n";
	  Return $tmp;
  }

  /** comment here */
  function getRangeValidation() {
	$txt = "";
	if (isset($this->mAllowedValues)) {
	  $parts = explode("-", $this->mAllowedValues);
	  if (count($parts) > 1) { //range checking
		$txt .=  "if (!x.".$this->mName.".disabled && (x.".$this->mName.".value < ".$parts[0]." || x.".$this->mName.".value > ".$parts[1].")) {
						  failValidation(x.".$this->mName.", '".$this->mErrorInvDataRange."');
						  err_id = -1; 
					};";
	  } else {
		$parts = explode(",",$this->mAllowedValues);// fixed set of values
		$checks = array();
		foreach ($parts as $key=>$val) {
		  $checks[] = " x.".$this->mName.".value != '".addslashes($val)."' ";
		}
		if (!empty($checks)) {
		  $txt .= "if (".implode(" || ", $checks).") {
						  failValidation(x.".$this->mName.", '".$this->mErrorInvDataRange."');
						  err_id = -1; 
					};";
		}
	  }//end else
	}//end if
	if ($txt)  {
		$txt = "\t if (!x.".$this->mName.".disabled) {" . $txt . " };";
	}
	Return $txt;
  }
}

?>