<?php   
/** 
* @package html
* @since May 21
* @author cgrecu
*/


class CInputInt extends CTextInput {
  
  /** comment here */
  function CInputInt($pName, $pValue = "") {
	$this->CTextInput($pName, $pValue);	
	$this->mDataType = "int";
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
	  $txt .= "if (x.".$this->mName.".value && parseInt(x.".$this->mName.".value) != x.".$this->mName.".value)  {
					  failValidation(x.".$this->mName.", '".$this->mErrorInvDataTypeMsg."');\n 
					  err_id = -1; \n 
				  }";
	  $txt .= $this->getRangeValidation();
	  Return $txt;
	}


}

?>
