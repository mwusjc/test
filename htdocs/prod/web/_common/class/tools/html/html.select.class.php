<?php   
/** select objects
* @package HTML
* @since February 06
* @author cgrecu
*/

class CSelect extends CFormElement {

  var $mMultiple; // boolean
  var $mOptions = array(); // array [0]->id, [1]->name
  var $mSize = 1;
  var $mDefault=-1;
  var $mExtraOption; // one extra option at the beginning
  var $mExtraText; // extra text between <select>....</select>; use for dynamic option boxes
  var $mAppendBrackets = true;
  var $mDatabase;
  var $mType = "select";
  var $mValidateMe = false;
  var $mFailureValue = -1;

  /** constructor */
  function CSelect($pName, $pMultiple = false, $pSize = "") {
	$this->CFormElement();
  	$this->setName($pName);
	$this->mMultiple = $pMultiple;
	if (!$this->mMultiple) $this->mAppendBrackets = false;
	$this->mSize = $pSize;

	if (array_key_exists($pName, $_POST)) {
	  if (is_array($_POST[$pName]) && $_POST[$pName][0]) $this->mDefault = $_POST[$pName][0]; 
	  else if ($_POST[$pName]) $this->mDefault = $_POST[$pName];
	}
	$this->mDatabase = $this->mDocument->mDatabase;

  }

  /** sets the options property (an array where the key maps to select-option-value and the value maps to select-option-text */
  function setOptions($pOptions, $pDefault = "") {
  	$this->mOptions = $pOptions;
	if ($pDefault) $this->mDefault = $pDefault;
  }

  /** set the option from xxx to xxx, stepping x */
  function setOptionsNumeric($pFrom,$pTo,$pStep=1,$pDefault="",$pFront="",$pEnd="") {
	  $vOptAry = array();

	  if ($pFrom>$pTo) {
		  for ($i=$pFrom;$i>=$pTo;$i-=$pStep) {
			$vOptAry[] = array($i,$pFront.$i.$pEnd);
		  } // for
	  } else {
		  for ($i=$pFrom;$i<=$pTo;$i+=$pStep) {
			$vOptAry[] = array($i,$pFront.$i.$pEnd);
		  } // for
	  } // else
	  $this->setOptions($vOptAry,$pDefault);
  }

  function setExtraOption($pOption) {
  	$this->mExtraOption = $pOption;
  }

	/** use to set the extra text between open/close <select> tag, used by dynamic option box */
	function setExtraText($pTextStr) {
		$this->mExtraText = $pTextStr;
	}

	/** sets the default value of the select element, input could be array or string */
	function setDefault($pDefault) {
		$this->mDefault = $pDefault;
	}

  /** connects to the database and retrieves an array of values */
  function getOptionsFromDB($pTable, $pLabelCol, $pValueCol,$pExtra="ORDER BY 1 ASC") {
	$vSQL = "SELECT $pValueCol, $pLabelCol FROM $pTable $pExtra";
//	var_dump($vSQL);
	$this->mOptions = $this->mDatabase->getAll2($vSQL);
	
  }

  /** connects to the database and retrieves an array of values */
  function getOptionsFromQuery($pQuery) {
	$this->mOptions = $this->mDatabase->getAll2($pQuery);
  }

  /** creates the options from the values of given ENUM column*/
  function getOptionsFromField($pTable, $pColumn = "") {
  	$vSql = "SHOW FIELDS FROM $pTable";
	$vFields = $this->mDatabase->getAll($vSql);
	foreach ($vFields as $key=>$val) {
		if (!(strpos($val["Type"],"enum") === false)) {
		  if ($val["Field"] == $pColumn || $pColumn == "") {
			$vValue = $val["Type"];
			break;
		  }
		}
	}
	if ($vValue != "") {
	  $vValue = str_replace("'","",$vValue);
	  $vValue = substr($vValue,5,-1);
	  $vValue = explode(",", $vValue);
	  foreach ($vValue as $key=>$val) {
	  	$this->mOptions[] = array($val,$val);
	  }
	}
  }

  /** creates html code for the select element */
  function display() {
	$this->mAlign = "";
	$name = $this->mName; if ($this->mAppendBrackets) $name .= "[]";
	$tmp = "<select  name=\"$name\" "; 
	if ($this->mMultiple) { $tmp .= " multiple=\"multiple\""; }
	if ($this->mSize > 1) { $tmp .= "size=\"$this->mSize\" "; }
	$tmp .= $this->addCommonAttributes();
	$tmp .= $this->addFormAttributes();
	$tmp .= ">\n";
	if (!empty($this->mExtraOption)) {
	  $tmp .= "\t<option value=\"".$this->mExtraOption[0]."\"";
	  if ($this->mExtraOption[0] == $this->mDefault) $tmp .= " selected=\"selected\"";			
	  $tmp .= ">".$this->mExtraOption[1]."</option>\n";
	}

	$group = 0;
	foreach ($this->mOptions AS $val) {
	  if (count($val) == 2) {
	  		$tmp .= "\t<option value=\"".$val[0]."\"";
			if (($val[0]==$this->mDefault) || (is_array($this->mDefault) && in_array($val[0],$this->mDefault))) {
				$tmp .= " selected=\"selected\"";
			} // if
			$tmp .= ">".$val[1]."</option>\n";
	  } else {
		if ($group) $tmp .= "\t</optgroup>";
	  	$tmp .= "\t<optgroup label=\"".$val[0]."\">";
		$group ++;
	  }
	} // foreach
	if ($group) $tmp .= "\t</optgroup>";

	$tmp .= $this->mExtraText;

	$tmp .= "</select>";
	if ($this->mRequiredFlag) $tmp .= "<span>*</span>";
	$this->assign($this->mName, $tmp);
	Return $tmp;
  }

  /** creates html code for the select element using a set of options provided as a paremeter */
  function displayStd($pOptions = array(), $pDefault = "") {
	if (!(empty($pOptions))) $this->mOptions = $pOptions;
	if ($pDefault != "") $this->mDefault = $pDefault;
	Return $this->display();
  }

  /** creates html code for the select element with a set options obtained by connecting to the database*/
  function displaySmart($pTable, $pLabCol, $pValCol) {
	$this->getOptionsFromDB($pTable, $pLabCol, $pValCol);
	Return $this->display();
  }

  /** creates javascript validation code, if the value is the same as failure value, die */
  function getValidation() {
	$this->mRequiredFlag = true;
	$pFailureValue = $this->mFailureValue;
	if ($pFailureValue == -1) {
	  	$ret = "\t if (x.".$this->mName.".value=='".$pFailureValue."') { failListValidation(x.".$this->mName.", '".$this->mErrorEmptyMsg."'); err_id = -1}\n";
	} else {
	  	$ret = "\t for (i=0;i < x.".$this->mName.".length;i++) {  if (x.".$this->mName."[i].selected && x." . $this->mName . "[i].value == '$pFailureValue') {  failListValidation(x.".$this->mName.", '".$this->mErrorEmptyMsg."'); err_id = -1; break; }}\n";
	}
	Return $ret;
  }


  /** comment here */
  function validate($pFailureValue=-1, $pMsg1, $pMsg2="", $pMsg3 = "") {
	$this->mErrorEmptyMsg = $pMsg1;
	$this->mErrorInvDataTypeMsg = $pMsg2;
	$this->mErrorInvDataRange = $pMsg3;
	$this->mFailureValue = $pFailureValue;

	$this->mValidateMe = true;
	Return $this->getValidation();  	
  }

}
?>
