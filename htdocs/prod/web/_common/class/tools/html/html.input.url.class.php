<?php   
/** CInputUrl
* @package html
* @since May 25
* @author cgrecu
*/


class CInputUrl extends CTextInput {

  /** comment here */
  function CInputUrl($pName, $pValue = "") {
	$this->CTextInput($pName, "text", $pValue);	
	$this->mDataType = "url";
	$this->mErrorInvDataTypeMsg = "Invalid web address!";
	if (!$pValue) $this->mValue = "";
  }

  /** comment here */
  function validate($pMsg, $pMsg2) {
  	$this->mErrorEmptyMsg = $pMsg;
  	$this->mErrorInvDataTypeMsg = $pMsg2;
	$this->mValidateMe = true;
  }

  /** creates javascript code for input validation */
  function getValidation() {
	$txt = CTextInput::getValidation();
	Return $txt;
  }

}

?>
