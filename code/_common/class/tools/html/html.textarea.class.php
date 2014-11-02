<?php   
/** text area, plain text
* @package HTML
* @since February 06
* @author cgrecu
*/


class CTextArea extends CFormElement{

  var $mLines;
  var $mRows;
  var $mCols;
  var $mSizeLimit;

  /** constructor */
  function CTextArea($pName, $pLines = "", $pRows = "", $pCols = "") {
	$this->CFormElement();
  	$this->setName($pName);
	if (!$this->mLines && isset($_POST[$pName])) $pLines = $_POST[$pName];
	$this->setLines($pLines);
	$this->mRows	  = $pRows;
	$this->mCols	  = $pCols;
  }

  /** creates html code for textarea element */
  function display() {
	$tmp = "<textarea name=\"$this->mName\"";
	if ($this->mRows) $tmp .= " rows=\"$this->mRows\" ";
	if ($this->mCols) $tmp .= " cols=\"$this->mCols\" ";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= ">\n";
	foreach ($this->mLines as $key=>$val) {
		$tmp .= $val;
	}
	$tmp .= "</textarea>\n";
	$this->assign($this->mName, $tmp);
	Return $tmp;
  }

  /** comment here */
  function setSizeLimit($pSize) {
	if (!$this->mSizeLimit) {
	  $this->mSizeLimit = $pSize;
	  $this->setJavaScript("onChange","checkLen_".$this->mName."(this);");
	  $this->setJavaScript("onBlur","checkLen_".$this->mName."(this);");
	  $this->setJavaScript("onFocus","checkLen_".$this->mName."(this);");
	  $this->setJavaScript("onKeyup","checkLen_".$this->mName."(this);");
	  $this->setJavaScript("onKeydown","checkLen_".$this->mName."(this);");

	  $script = "\n\t function checkLen_".$this->mName."(target) { \n".
				"\t\t	len = target.value.length; \n".
				"\t\t	if (len == 1 && target.value.substring(0, 1) == ' ' ) { target.value = ' '; len = 0;}; \n".
				"\t\t	if (len > ".$this->mSizeLimit.") { target.value = target.value.substring(0, ".$this->mSizeLimit.");}; \n".
				"\t\t  }\n\n";
	  $this->mHtmlDoc->mHead->addScript(new CScript($script));
	}
  }

  /** sets the lines property (used for preinitialization of textarea element) */
  function setLines($pLines) {
	$this->mLines = array();
	if (is_array($pLines)) {
	  foreach ($pLines as $key=>$val) {
		$this->mLines[] = $val . "\n";
	  }

	} else {
	  if ($pLines != "") $this->mLines[0] = $pLines;
	}
  }

  /** comment here */
  function setValue($pValue) {
  	$this->setLines($pValue);
  }

  /** sets the rows property */
  function setRows($pRows) {
  	$this->mRows = $pRows;
  }

  /** sets the cols property */
  function setCols($pCols) {
  	$this->mCols = $pCols;
  }

  /** comment here */
  function validate($pMsg) {
  	$this->mErrorEmptyMsg = $pMsg;
	$this->mValidateMe = true;
  }

  /** creates javascript validation code */
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

}

?>