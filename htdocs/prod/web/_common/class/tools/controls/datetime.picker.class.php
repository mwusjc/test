<?php
/** Calendar Control: implements a DatePicker control displayed in a separate window
* The caller page cretes two elements, first is the textbox for the StringDate returned,
*	  the other is the hidden field that will store the IntDate value - PHP style
* The actual calendar is stored in a javascript ("calendar.js")
* @package Control
* @since March 01
* @author cgrecu
*/


class CDateTimePicker extends CInput{

	var $mIntValue;
	var $mTextValue;

	/** constructor */
	function CDateTimePicker($pName, $pValue = "") {
	  $this->CInput($pName, "datetime", $pValue);
	  $this->setName($pName);

	  if (!$pValue && isset($_POST[$pName]) && $_POST[$pName]) $pValue = $_POST[$pName];
	  #normalize time to midnight
	  if ($pValue) $pValue = strtotime(date("d", $pValue) . " " . date("F", $pValue) . " ". date("Y", $pValue));
	  $this->mIntValue = $pValue;
	  $this->mTextValue = date("M d, Y",$pValue);
	  if (!$pValue) $this->mTextValue = "";

	  if ($this->mDocument->mHead->getScript("calendar") == -1) {
		$vScript = new CScript("","_common/scripts/calendar/calendar.js");
		$vScript->mName = "calendar";
		$this->mDocument->mHead->addScript($vScript);
	  }
	}

	/** display the calendar: a hidden field, a text field and an img object that calls the calendar */
  	function display() {

	  $tmp = "";
	  $tmp .= "<input type=hidden id=\"".$this->mName."\" name=\"".$this->mName."\" value =\"".$this->mIntValue."\">";
	  $tmp .= "<input type=\"text\" id=\"txt".$this->mID."\" name=\"txt".$this->mName."\" value=\"$this->mTextValue\" size=\"12\"";
	  $tmp .= $this->addCommonAttributes();
	  $tmp .= $this->addFormAttributes();
	  $tmp .= "$vScript readonly=\"readonly\"/>\n";
	  $tmp .= "<a href=\"javascript: show_calendar('txt".$this->mName."','".$this->mName."');\"><img border=0 src=\"http://wms.thebrandfactory.com/images/common/small/calendar.png\" onmouseover=\"this.src='http://wms.thebrandfactory.com/images/common/small/calendar_up.png'\" onmouseout=\"this.src='http://wms.thebrandfactory.com/images/common/small/calendar.png'\" align=\"center\" style=\"margin-bottom:6px;\"></a>";
	  $this->assign($this->mName, $tmp);
	  Return $tmp;
	}


  /** comment here */
  function getValidation() {
	if ($this->mValidateForEmpty) {
	  if (empty($pErrorMsg)) $pErrorMsg = $this->mErrorEmptyMsg;
	  $tmp = "\t if (x.".$this->mName.".value == '' || x.txt".$this->mName.".value == 0) {\n \t\t activate_div(x.txt".$this->mName.");errors[errors.length] = '".$pErrorMsg."';x.txt".$this->mName.".select(); x.txt".$this->mName.".focus();x.txt".$this->mName.".style.backgroundColor='#F2F6E5';\n \t\t err_id=-1;\n \t};\n";
	} else {
		$tmp = "";
	}

	  $tmp = "if (!(x.".$this->mName.".disabled == true)) { ";
	  if ($this->mValidateForEmpty)
		  $tmp .= "\t if (x.".$this->mName.".value == '') {\n
							  failValidation(x.txt".$this->mName.", '".$this->mErrorEmptyMsg."');\n
						\t\t err_id = -1; \n
						\t};\n";
	  $tmp .= "}\n";
	  Return $tmp;

  }


}

?>
