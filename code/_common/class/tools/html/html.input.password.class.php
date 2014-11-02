<?php   
/** CInputT
* @package html
* @author cgrecu
*/


class CPassword extends CTextInput {
/** comment here */

  function CPassword($pName, $pValue) {
	$this->CTextInput($pName, $pValue);
	$this->mType = "password";
  }

  /** comment here */
  function display() {
	$tmp = "";
	$tmp .= "<input type=\"password\" name=\"".$this->mName.$this->mElementIndex."\" value=\"".htmlentities($this->mValue)."\"";
	if ($this->mSize)  $tmp .= " size=\"$this->mSize\"";
	if ($this->mMaxLength) $tmp .= " maxlength=\"$this->mMaxLength\" ";
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= " />\n";
//	if ($this->mRequiredFlag && $this->mShowRequiredVisualIndicator) $tmp .= "<span style=\"color: ".$this->mColHead."\">*</span>";
	$this->assign($this->mName, $tmp);
	Return $tmp;
  }

}

?>