<?php   
/** CInputEmail
* @package html
* @since May 21
* @author cgrecu
*/


class CInputEmail extends CTextInput {

  /** comment here */
  function CInputEmail($pName, $pValue = "") {
	$this->CTextInput($pName, $pValue);
	$this->mDataType = "email";
	$this->mErrorInvDataTypeMsg = "Invalid email address!";
  }

  /** comment here */
  function validate($pMsg, $pMsg2) {
  	$this->mErrorEmptyMsg = $pMsg;
  	if ($pMsg2) $this->mErrorInvDataTypeMsg = $pMsg2;
	$this->mValidateMe = true;
  }

  /** creates javascript code for input validation */
  function getValidation() {
	$txt = CTextInput::getValidation();
	$txt .= "if (!(x.".$this->mName.".disabled == true)) { ";
	$txt .= "if (!checkEmail(x.".$this->mName.".value)) {\n
					  failValidation(x.".$this->mName.", '".$this->mErrorInvDataTypeMsg."');\n
					  err_id = -1; \n
				  };\n";
	$txt .= "}\n";
	Return $txt;
  }

}

?>
