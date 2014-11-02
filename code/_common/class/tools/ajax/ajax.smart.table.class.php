<?php   

	class CAjaxSmartTable extends CSmartTable {


	  function CAjaxSmartTable ($pTable, $pSql){
		$this->CSmartTable($pTable, $pSql);
	  }

	    /** comment here */
  function display() {
	$filter = $this->displayFilter();
	$this->resetTemplate("_common/templates/smart/ajax_nav.xml");
	$this->newBlock("MAIN");

	#filters
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
	$browse->displayAjaxNavigation("TOP");
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
	$this->assign("MainTable", xmlentities($txt));

	xml($this->flushTemplate());
  }



}
?>