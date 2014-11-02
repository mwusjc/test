<?php
/** CSmartTable
* @author cgrecu
*/


class CSmartTable extends CDBObject {

  var $mTable;
  var $mSql;
  var $mFormName = "frmEdit";
  var $mFilters = array();
  var $mHeaders = array();
  var $mHeaderColumns = array();
  var $mIcons = array();
  var $mLegend = array();
  var $mActions = array();
  var $mItemsPerPage = 0;
  var $mExtraActions = array();
  var $mRows = array();
  var $mShowIndex = true;
  var $mShowToggle = true;
  var $mFields = array();
  var $mIconManager;
  var $mColsAligns = array();
  var $mColsWidths = array();
  var $mTemplates = array();
  var $mStatusOn = "enabled";
  var $mTableType = "grid";
  var $mTemplateName = "";
  var $mDrawAlternate = false;
  var $mShowSaveButton = false;
  var $mDefaultOrder = "a.ID";
  var $mDefaultOrderDir = "ASC";

  /** comment here */
  function CSmartTable($pTable, $pSql) {
  	$this->CDBObject();
	$this->mTable = $pTable;
	$this->mSql = $pSql;
	if ($_GET["reset"] == "yes") {
		$this->resetSessionVars();
		foreach ($_GET as $key=>$val) {
			if ($key != "n" && $key != "o") {
				unset($_GET[$key]);
				$this->mDocument->mUrlObj->replaceArgument($key, "");
			}
		}
	}
	if ($_SESSION["gAdminFilters"] && $_SESSION["gAdminSection"] == $this->mDocument->mUrlObj->mModule_) {
	  foreach ($_SESSION["gAdminFilters"] as $key=>$val) {
		if (!isset($_GET[$key])) $_GET[$key] = $val;
	  }
	}
	if ($_SESSION["gAdminSection"] != $this->mDocument->mUrlObj->mModule_) $this->resetSessionVars();
	$_SESSION["gAdminSection"] = $this->mDocument->mUrlObj->mModule_;
  }

  /** comment here */
  function resetSessionVars() {
	  $_SESSION["gAdminCriteria"] = "";
	  $_SESSION["gAdminOrderBy"] = "";
	  $_SESSION["gAdminOrderDir"] = "";
	  $_SESSION["gAdminCurPage"] = "";
	  $_SESSION["gAdminFilters"] = "";
  }

  /** comment here */
  function setFormName($pName) {
  	$this->mFormName = $pName;
  }

  /** comment here */
  function addTFilter($pFieldComplex, $pLabel, $pRow = 1, $pClass = "") {
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
  	$input = new CTextInput("srctxt_$pField", $_GET["srctxt_$pField"]);
  	if (!$pClass) $pClass = "admin_search"; $input->setClass($pClass);
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $input->display(), $pTable, $pField);
  }

  /** range filter */
  function addRFilter($pFieldComplex, $pLabel1, $pLabel2 = "to", $pRow = 1, $pFieldType = "text") {
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
	if ($pFieldType == "date") {
	  $input1 = new CDateTimePicker("srcfrom_$pField", $_GET["srcfrom_$pField"]);
	  $input2 = new CDateTimePicker("srcto_$pField", $_GET["srcto_$pField"]);
	} else {
	  $input1 = new CTextInput("srcfrom_$pField", $_GET["srcfrom_$pField"]);
	  $input2 = new CTextInput("srcto_$pField", $_GET["srcto_$pField"]);
	}
	$this->mFilters[$pRow-1][] = array($pLabel1 . ": " . $input1->display() . " ". $pLabel2 . " " . $input2->display(), $pTable, $pField);

  }

  /** comment here */
  function addDFilter($pFieldComplex, $pLabel, $pRow = 1) {
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
   	$input = new CDateTimePicker("srctxt_$pField", $_GET["srctxt_$pField"]);
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $input->display(), $pTable, $pField);

  }

  /** comment here */
  function addLFilter($pFieldComplex, $pLabel, $pOptions, $pRow = 1) {
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
  	$input = new CSelect("srcequal_$pField");
  	$input->mOptions = $pOptions;
  	$input->mDefault = $_GET["srcequal_$pField"];
  	$input->setExtraOption(array("", "Show All"));
	$input->setClass("admin_search");
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $input->display(), $pTable, $pField);
  }

  /** comment here */
  function addINFilter($pFieldComplex, $pLabel, $pOptions, $pRow = 1) {
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
  	$input = new CSelect("srcin_$pField");
  	$input->mOptions = $pOptions;
  	$input->mDefault = $_GET["srcequal_$pField"];
  	$input->setExtraOption(array("", "Show All"));
	$input->setClass("admin_search");
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $input->display(), $pTable, $pField);
  }

  /** comment here */
  function addLDbFilter($pFieldComplex, $pLabel, $pRow = 1) {
  	$options = $this->mDatabase->getAll2("select ID, $pField from " . $this->mTable . " order by 2 ASC");
	$this->addLFilter($pField, $pLabel, $options, $pRow);
  }

  /** comment here */
  function addRadioFilter($pFieldComplex, $pLabel, $pOptions, $pRow = 1) {
	$txt = "";
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
	foreach ($pOptions as $key=>$val) {
   	  $input = new CInputRadio("srctxt_$pField", $val[1]);
	  if ($_GET["srctxt_$pField"] == $val[1]) $input->mChecked = true;
	  $txt .= " ". $input->display() . " ". $val[0]  . "&nbsp;&nbsp;";
	}
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $txt,  $pTable, $pField);
  }

  /** comment here */
  function addChkFilter($pFieldComplex, $pLabel, $pOption, $pRow = 1) {
	$txt = "";
	$tmp = explode(".", $pFieldComplex);
	$pField = $tmp[count($tmp)-1];
	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
	if (!$pOption[2]) $pOption[2] = "equal";
	$fldName = "src".$pOption[2]."_".$pField;
	$input = new CCheckbox($fldName, $pOption[1]);
	if ($_GET[$fldName] == $pOption[1]) $input->mChecked = true;
	$txt = " ". $input->display(). " ". $pOption[0] . " " ;

	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $txt,  $pTable, $pField);
  }

  /** comment here */
  function addCompositeFilter($pField, $pFields, $pLabel, $pRow = 1, $pClass = "") {
//	$tmp = explode(".", $pFieldComplex);
//	$pField = $tmp[count($tmp)-1];
//	$pTable = $tmp[0];if (count($tmp) == 1 || !$pTable) $pTable = $this->mTable;
  	$input = new CTextInput("srccomp_$pField", $_GET["srccomp_$pField"]);
  	if (!$pClass) $input->setClass("admin_search"); else $input->setClass($pClass);
	$fields = explode(",", $pFields);
	$this->mFilters[$pRow-1][] = array($pLabel . ": " .  $input->display(), $pTable, $pField, $fields);
  }

  /** comment here */
  function addHeader($pFields) {
  	$this->mHeaders = $pFields;
  }

  /** comment here */
  function setIcons($pIcons) {
  	$this->mIconManager = new CIcons($pIcons);
  }

  /** comment here */
  function setTemplate($pName) {
  	$this->mTemplateName = $pName;
  }

  /** comment here */
  function setAlternate($alternate = true) {
  	$this->mDrawAlternate = $alternate;
  }

  /** comment here */
  function addIcon($pIcon) {
  	$this->mIconManager->mSelected[] = $pIcon;
  }

  /** comment here */
  function addExtraActions($pAction) {
	$pAction->setClass("admin");
  	$this->mExtraActions[] = $pAction->display();
  }

  /** add column field */
  function addField($pField) {
  	$this->mFields[] = array("", $pField);
  }

  /** add string field */
  function addSField($pField) {
  	$this->mFields[] = array("string", $pField);
  }

  /** add string field */
  function addIField($pField) {
  	$this->mFields[] = array("int", $pField);
  }

  /** add date field */
  function addDField($pField, $pFormat = "F d, Y") {
  	$this->mFields[] = array("date", $pField, $pFormat);
  }

  /** add currency field */
  function addCField($pField, $pDecimals = 2) {
  	$this->mFields[] = array("currency", $pField, $pDecimals);
  }

  /** add currency field */
  function addPField($pField, $pDecimals = 2) {
  	$this->mFields[] = array("percent", $pField, $pDecimals);
  }

  /** add number field */
  function addFField($pField, $pDecimals = 2) {
  	$this->mFields[] = array("float", $pField, $pDecimals);
  }

  /** add number field */
  function addStField($pField = "enabled") {
  	$this->mFields[] = array("status", $pField);
  }

  /** comment here */
  function addFuncField(&$pObject, $pFunction, $param = "") {
  	$this->mFields[] = array("function", $param, $pObject, $pFunction);
  }

  /** Field1 = URL including tag, Field2 = Tag Name, Field3 = Label including tag, Field4 = Tag name */
  function addLkField($pTxt1, $pField1, $pTxt2, $pField2) {
  	$this->mFields[] = array("link", $pTxt1, $pField1, $pTxt2, $pField2);
  }

  /** comment here */
  function getFieldValue($pField, &$pValue) {
  	switch($pField[0]) {
  		case "string": Return str_replace("##ID##", $pValue["ID"], $pField[1]);
  		case "date": if (!$pValue[$pField[1]]) Return ""; Return date($pField[2], $pValue[$pField[1]]);
  		case "currency": Return "$" . number_format($pValue[$pField[1]], $pField[2]);
  		case "float": Return number_format($pValue[$pField[1]], $pField[2]);
  		case "int": Return intval($pValue[$pField[1]]);
  		case "percent": Return number_format($pField[1], $pField[2]) . "%";
  		case "link":
		  $link = new CHref(str_replace("##".$pField[2]."##", $pValue[$pField[2]], $pField[1]), str_replace("##".$pField[4]."##", $pValue[$pField[4]], $pField[3]));
		  Return $link->display();
  		case "status":
		  if ($pValue["Status"] == $this->mStatusOn) $link = $this->mIconManager->getIcon("on");
		  else  $link = $this->mIconManager->getIcon("off");
		  if ($link) {$link->mURL = str_replace("##ID##", $pValue["ID"], $link->mURL);
			Return $link->display();
		  } else Return "&nbsp;";
  		case "function":
		  if (!$pField[1]) Return $pField[2]->$pField[3]($pValue); else Return $pField[2]->$pField[3]($pValue, $pField[1]);
		default:
		  Return str_replace("##ID##", $pValue["ID"], $pValue[$pField[1]]);
  	}
  }

  /** comment here */
  function display() {
	$filter = $this->displayFilter();
	$this->resetTemplate("_common/templates/smart/nav.html");
	$this->newBlock("MAIN");

	#filters
	if ($filter) $this->mDocument->setPiece("TOP", $filter);
	$criteria = $this->createFilter();
	$_SESSION["gAdminCriteria"] = $criteria;

	#create sql
	$this->mSql = str_replace("##CRITERIA##",$criteria,$this->mSql);
	#order by
//	print_r($_SESSION);
	if (!array_key_exists("orderby", $_GET) && array_key_exists("gAdminOrderBy", $_SESSION) && $_SESSION["gAdminOrderBy"]) {
		$_GET["orderby"] = $_SESSION["gAdminOrderBy"];
	}
	if (array_key_exists("orderby", $_GET)) {
		$this->mSql .= "ORDER BY ". $_GET["orderby"] . " ";
		$_SESSION["gAdminOrderBy"] = $_GET["orderby"];
	} else {
		if ($this->mDefaultOrder) $this->mSql .=  " ORDER BY ". $this->mDefaultOrder; else $this->mSql .= "ORDER BY 1  ";
	}
	#order direction
	if (!array_key_exists("orderdir", $_GET) && array_key_exists("gAdminOrderDir", $_SESSION) && $_SESSION["gAdminOrderDir"]) {
		$_GET["orderdir"] = $_SESSION["gAdminOrderDir"];
	}
	if (array_key_exists("orderdir", $_GET)) {
		$this->mSql .= $_GET["orderdir"];
		$_SESSION["gAdminOrderDir"] = $_GET["orderdir"];
	} else {
		if ($this->mDefaultOrderDir) $this->mSql .= " ". $this->mDefaultOrderDir; else $this->mSql .= " ASC";
	}
	$this->mSql .= ", 1 ASC";

	#icons
	$this->mIconManager->mExtraParam = $this->mExtraParam;

	#navigation
	$qs = explode("&",$_SERVER["QUERY_STRING"]);
	$url = $_SERVER["PHP_SELF"];
	$params = array();
	foreach ($qs as $key=>$val) {
	  $tmp = explode("=", $val);
	  if ($tmp[0] != "start") $params[] = $val;
	}
	if (!empty($params)) {
	  $url .= "?";
	  $url .= implode("&", $params);
	}

	if (isset($_GET["start"])) $_SESSION["gAdminCurPage"] = $_GET["start"];
	else {
		if ($_SESSION["gAdminCurPage"]) {
			$_GET["start"] = $_SESSION["gAdminCurPage"];
			$this->mDocument->mUrlObj->insertArgument("start", $_GET["start"]);
		}
	}

	$browse = new CBrowseHelp($this->mSql, $url, $_GET["start"]);
	$browse->mResultsPerPage = $this->mItemsPerPage;
	$items = $browse->getElements();
	$browse->displayNavigation();
	$rows = array();
	if (!empty($items)) {
		$this->newBlock("Navigation");
	}
	$this->selectBlock("MAIN");

	$vActions = $this->mIconManager->getIcons();
	$footer = array($this->mIconManager->displayLegend());
	//customize this array
	$header = array();
	if ($this->mShowIndex) $header[] = "#";
	if ($this->mShowToggle) $header[] = "Status";
	foreach ($this->mHeaders as $key=>$val) {
		$tmp = explode("|", $val);
		if ($tmp[1] == "false")
			$header[] = $tmp[0];
		else {
			$dir = "ASC"; $imgSort = "";
			$this->mDocument->mUrlObj->replaceArgument("orderby", $this->mFields[$key][1]);
			if ($_GET["orderdir"] && $_GET["orderby"] == $this->mFields[$key][1]) {
				if ($_GET["orderdir"] == "DESC") $dir = "ASC"; else $dir = "DESC";
				if ($dir == "DESC") $imgSort = " <img width=\"14\" src=\"http://wms.thebrandfactory.com/images/common/small/sort_ascending.png\" align=\"top\">"; else {
					$imgSort = " <img width=\"14\" src=\"http://wms.thebrandfactory.com/images/common/small/sort_descending.png\" align=\"top\">";
				}
			}
			$this->mDocument->mUrlObj->replaceArgument("orderdir", $dir);

			$href = new CHref($this->mDocument->mUrlObj->getURL(), "<nobr>".$tmp[0] . $imgSort . "</nobr>");
			$header[] = $href->display();
		}
	}
	if ($this->mIconManager) $header[] = "Actions";

	foreach ($items as $key=>$val) {
	  if ($this->mShowIndex) $rows[$key+1][] = ($key+1 + intval($_GET["start"])) . ".";
	  if ($this->mShowToggle) $rows[$key+1][] = $this->getFieldValue(array("status", $val["Status"]), $val);
	  foreach ($this->mFields as $key2=>$field) {
		$rows[$key+1][] = $this->getFieldValue($field, $val);
	  }
	  $actions = array();

	  foreach ($vActions as $key2=>$action) {
		if ($key2 == "on" || $key2 == "off") continue;

		$tmp = str_replace("##ID##", $val["ID"], $action->mURL);
		if (!strpos($tmp, "delete"))
			$href = new CHref($tmp, $action->mLabel);
		else {
			$href = new CHref("#self", $action->mLabel);
			$href->setJavaScript("onclick", "if (confirm('Are you sure you want to delete this record?')) window.location='".addslashes($tmp)."'");
		}
	  	$actions[] = $href->display();
	  }

	  if ($actions) $rows[$key+1][] = "<nobr>".implode("&nbsp;", $actions) ."</nobr>";
	}
	if (empty($rows)) $rows[][] = "No items found";

	if ($this->mTableType) {
	  $vTable = new CGrid($rows, $header, $footer, "admin");
	  $vTable->setTemplate($this->mTemplateName);
	  $vTable->mColsAligns = $this->mColsAligns ;
	  $vTable->mColsWidths = $this->mColsWidths;
	} else {
	  $vTable = new CGridTable($rows, $header, $footer, "admin");
	  foreach ($this->mTemplates as $key=>$val) {
		  foreach ($val as $key2=>$val2) {
			$vTable->mTemplates[$key][$key2] = $val2;
		  }
	  }
	  $vTable->mColsAligns = $this->mColsAligns ;
	  $vTable->mColsWidths = $this->mColsWidths;
	}
	if ($this->mDrawAlternate) $vTable->mDrawAlternate = true;

	$txt = $vTable->display();
	$txt .= implode(", ", $this->mExtraActions);
	$this->assign("MainTable", $txt);

	Return $this->flushTemplate();
  }

  /** comment here */
  function displayFilter() {
	if (!$this->mFilters) Return "";
//	error_reporting(E_ALL);
//	ini_set("display_errors", 1);
  	$vForm = new CForm("frmFilter", "index2.php");
	$vForm->resetTemplate("_common/templates/smart/main.html");
	$footer = array(SButton::get("reset", "window.location='".$_SERVER["REQUEST_URI"]."&reset=yes';") ." ". SButton::get("searh"));
	if ($this->mShowSaveButton) {
		$btReset = new CButton("Save Users List");
		$btReset->setJavaScript("onClick", "window.location='index2.php?n=Lists&o=edit&type=".$this->mDocument->mUrlObj->mModule_."';");
		$this->mFilters[count($this->mFilters)-1][] = array($btReset->display(), "", "submit");
	}

	foreach ($this->mFilters as $key=>$val) {
	  $rows[$key][0] = "<nobr>";
	  foreach ($val as $key2=>$val2) {
		$rows[$key][0] .= "&nbsp;" . $val2[0];
	  }
	  $rows[$key][0] .= "</nobr>";
	}
	$vTable = new CGrid($rows, array(), $footer);
	$vTable->setTemplate("filters");
//	$vTable->mTemplates["table"]["width"] = "100%";
//	$vTable->mTemplates["breaker"]["padding"] = "2px";
//	$vTable->mTemplates["breaker"]["font-size"] = "8pt";
//	$vTable->mTemplates["breaker"]["color"] = "#aaa";
//	$vTable->mTemplates["table"]["margin"] = "5px 0px 10px";
//	$vTable->mTemplates["header"]["background-color"] = "#fafafa";
//	$vTable->mTemplates["table"]["border"] = "1px solid #f6f6f6";
	$txt = '<div style="padding: 7px 2px 11px;  height: 22px;  border-bottom: 1px solid #ddd; " >'.STitle::get("Filters").'</div>'. $vTable->display()  . $this->addParams($this->mSection, $this->mOperation);
	$vForm->addText("Filters", $txt);
	$vForm->display(true);
	Return $this->flushTemplate();
  }

  /** comment here */
  function addParams($pName, $pOp) {
		$vName = new CHidden("n", $pName);
		$vOp = new CHidden("o", $pOp);
		$hidden = $vName->display() . $vOp->display();
		Return $hidden;
  }

  /** comment here */
  function createFilter() {
	$criteria = array();
	$_SESSION["gAdminFilters"] = array();
//	return;
//die2($this->mFilters);
  	foreach ($_GET as $key=>$val) {
	  if (!$val) continue;

  	  $cd = substr($key, 0, 3);
	  if ($cd == "src") {

		$fld = substr($key, 3);
		$tmp = explode("_",$fld);
		$fldName = $tmp[1];
		$val = addslashes($val);
		$filter = $this->getFilter($fldName);
		$tblName = $filter[1];
		switch($tmp[0]) {
			case "txt": $criteria[] = $tblName .".".$fldName ." like '%$val%' ";break;
			case "from": $criteria[] = $tblName .".".$fldName ." >= '$val' ";break;
			case "to": $criteria[] = $tblName .".".$fldName ." <= '$val' ";break;
			case "equal": $criteria[] = $tblName .".".$fldName ." = '$val' ";break;
			case "logic": $criteria[] = $tblName .".".$fldName ." > 0 ";break;
			case "in": $criteria[] = $tblName .".".$fldName ." in (select ContactID from contact_homes where TypeID = '$val') ";break;
			case "comp":
				$crit = "(";
				$crits = array();
				foreach ($filter[3] as $key2=>$val2) {
					$crits[] = $val2." like '%$val%' ";
				}
				$crit .= implode(" OR ", $crits);
				$crit .= ")";
				$criteria[] = $crit;
				break;
		}
		$_SESSION["gAdminFilters"][$key] = $val;
	  }
  	}
	if (!empty($criteria)) Return " AND (". implode(" AND ", $criteria) . ") "; else $criteria = "";
	Return $criteria;
  }

  /** comment here */
  function getFilter($pName) {
  	foreach ($this->mFilters as $key=>$val) {
	  foreach ($val as $key2=>$val2) {
  		if ($val2[2] == $pName) Return $val2;
	  }
  	}
  }


}

?>