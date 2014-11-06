<?php   
/** CInputFile
* @package html
* @author cgrecu
*/


class CInputFile extends CTextInput {
/** comment here */

  function CInputFile($pName, $pValue) {
	$this->CTextInput($pName, $pValue);	  
	$this->mType = "file";
  }

  /** comment here */
  function generate() {
	CInput::generate();
  }

  /** comment here */
  function display() {
	$tmp = "";
	if ($this->mMaxLength) $tmp .= "<input type=hidden name=\"MAX_FILE_SIZE\" value=\"".$this->mMaxLength."\" />";
	$tmp .= "<input type=\"$this->mType\" name=\"$this->mName\" value=\"\"";
	if ($this->mSize)  $tmp .= " size=\"$this->mSize\" ";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= " />\n";
//	if ($this->mRequiredFlag && $this->mShowRequiredVisualIndicator) $tmp .= "<span style=\"color: ".$this->mColHead."\">*</span>";
	$this->assign($this->mName, $tmp);
  	Return $tmp;
  }

  /** comment here */
  function setAllowedValues($pValues, $pMsg = "Invalid range") {
  	$this->mAllowedValues = $pValues;
  	$this->mErrorInvDataRange = $pMsg;
  }


}

?>
