<?php

  /** comment here */
  class CDocument {

	#variables
	var $mAdminMode;
	var $mPageID;
	var $mIE;
	var $mFullLinksMode;
	var $mPageTemplate = "_common/templates/main.html";
	var $mCss = "_common/css/style.css";
	var $mSection;
	var $mClass;

	#objects
	var $mUserObj;
	var $mErrorObj;
	var $mUrlObj;
	var $mFileObj;
	var $mTemplateObj;
	var $mDatabase;
	var $mHead;
	var $mBody;
	var $mTools;

	#structures
	var $mModules;
	var $mObjects;
	var $mFragments;
	var $mTemplates;

	var $mHtml;


	/** comment here */
	function CDocument() {
	  session_start();
	  if (array_key_exists("QUERY_STRING", $_SERVER)) $_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"]  . "?".$_SERVER["QUERY_STRING"]; else $_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];
//	  $this->mUserObj = 0;
  	  $this->createPageID();
	  $this->mDatabase = &$GLOBALS["vDatabase"];

	  $this->mUserID = $this->_getUserID();
  	  if (class_exists("CUser")) $this->mUserObj = new CUser($this->mUserID); else $this->mUserObj = 0;
	  if ($this->mUserID && $this->mUserObj && !$_SESSION["gUserID"]) $this->mUserObj->login();

	  $this->mUrlObj = new CUrlManager();
	  $this->mErrorObj = new CErrorManager();
	  $this->mRedirectObj = new CRedirectManager();
	  $this->mFileObj = new CFileManager();
	  $this->mTemplateObj = new TemplatePower();
	  $this->mToolsObj = new CTools();
	  $this->mHead = new CHead();
	  $this->mBody = new CBody();
	  $this->mObjects = array();
	  $this->mModules = array();
	  $this->loadModules();
	  $this->mTemplates = array();


	  $this->construct();
	}

	/** comment here */
	function construct() {
	  # virtual function, this is used by chidren to do additional stuff at contruction time
	}

	/** comment here */
	function createPageID() {
	  $x = explode(" ", microtime());
	  $this->mPageID = rand(0,9) . substr(10000 * $x[0] + 10000 * $x[1], 1);
	}

	/** comment here */
	function main() {

	  $this->mHead->addMeta(new CMetaTag('','text/html; charset=UTF-8','Content-Type'));

	  $this->mHead->addScript(new CScript("", "_common/scripts/tools.js"));
	  $this->mHead->addScript(new CScript("", "_common/scripts/misc/mm.js"));
	  $this->mHead->addScript(new CScript("", "_common/scripts/misc/forms.js"));
	  $this->mHead->addScript(new CScript("", "_common/scripts/overlay.js"));
	  $this->mHead->addScript(new CScript("", "_common/scripts/AC_RunActiveContent.js"));
	  $this->mHead->addScript(new CScript("", "_common/scripts/ajax.js"));

	  $this->constructBody();
	  $this->mHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
	  $this->mHtml .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
	  $this->mHtml .= $this->mHead->display();
	  $this->mHtml .= $this->mBody->display();
	  $this->mHtml .= "</html>";
	  $this->_finalize();
	  echo $this->mHtml;
	}

	/** comment here */
	function constructBody() {
	  $objName = $this->mModules[$this->mUrlObj->mModule_];
	  if (class_exists($objName)) $vObj = new $objName();
	  $this->mTags["LAYOUT_BANNER"] = $this->displayBanner();
	  $this->mTags["LAYOUT_NAVIGATION"] = $this->displayNavigation();
	  $this->mTags["LAYOUT_MENU"] = $this->displayMenu();
	  $this->mTags["LAYOUT_SITE_MENU"] = $this->displaySiteMenu();
	  $this->mTags["LAYOUT_FOOTER"] = $this->displayFooter();
	  $this->mTags["LAYOUT_COPYRIGHT"] = $this->displayCopyright();
	  $this->mTags["LAYOUT_ERROR"] = $this->displayError();
	  if (isset($vObj)) $this->mTags["LAYOUT_BODY"] = $vObj->mainSwitch();

	  $this->customPieces();

	  $template = file_get_contents($this->mPageTemplate);

	  foreach ($this->mTags as $key=>$val) {
		$template = str_replace("{" . $key . "}", $val, $template);
	  }

	  $this->mBody->mText = $template;
	}

	/** comment here */
	function displayMenu() {
		Return "";
	}

	/** comment here */
	function displaySiteMenu() {
		Return "Site menu here";
	}

	/** comment here */
	function displayBanner() {
		Return "Banner here";
	}

	/** comment here */
	function displayFooter() {
	  Return "Footer here";
	}

	/** comment here */
	function displayCopyright() {
	  Return "Copyright here";
	}

	/** comment here */
	function displayNavigation() {
	  Return "Navigation here";
	}

	/** comment here */
	function loadModules() {
	  foreach ($GLOBALS["modules"] as $key=>$val) {
		$this->mModules[$key] = $val[0];
	  }
	}

	/** comment here */
	function registerObject(&$pObject) {
		$check = $this->isRegistered($pObject->id);
		if (!$check || !$pObject->parent) {
		  if (!$check) $this->mObjects[$pObject->id] = array("id"=>$pObject->id, "section"=>$pObject->section, "name"=>$pObject->name, "table"=>$pObject->table, "parent"=>$pObject->parent, "type"=>$pObject->type, "children"=>array());
		  else {
			$this->mObjects[$pObject->id]["id"] = $pObject->id;
			$this->mObjects[$pObject->id]["section"] = $pObject->section;
			$this->mObjects[$pObject->id]["name"] = $pObject->name;
			$this->mObjects[$pObject->id]["table"] = $pObject->table;
			$this->mObjects[$pObject->id]["parent"] = $pObject->parent;
			$this->mObjects[$pObject->id]["type"] = $pObject->type;
		  }
//		  if ($pObject->parent) {
//			if (!in_array($pObject->id, $this->mObjects[$pObject->parent]["childrens"])) $this->mObjects[$pObject->parent]["childrens"][] = $pObject->id;
//		  }
		}

	}

	/** comment here */
	function setPiece($pPiece, $pContent) {
	  if (!array_key_exists("LAYOUT_".$pPiece, $this->mTags)) $this->mTags["LAYOUT_".$pPiece] = "";
		$this->mTags["LAYOUT_".$pPiece] .= $pContent;
	}

	/** comment here */
	function isRegistered($pID) {
	  if (in_array($pID, $this->mObjects)) Return true;
	  Return false;
	}

	/** comment here */
	function _getUserID() {
	  $vUserID = 0;
	  if (isset($_SESSION["gUserID"])) $vUserID = $_SESSION["gUserID"];
	  if (!$vUserID && isset($_COOKIE["UserID"])) {
		  $check = $this->mDatabase->getValue("users", "status", "UserID = '".$_COOKIE["UserID"]."'");
		  if ($check) $vUserID = $_COOKIE["UserID"];
	  }
	  if (!$vUserID) $vUserID = 0;
	  Return $vUserID;
	}

	/** comment here */
	function loadBoxTemplate($pStyle) {
		if (!isset($this->mTemplates[$pStyle]) || !$this->mTemplates[$pStyle]) $this->mTemplates[$pStyle] = file_get_contents("_common/templates/box/$pStyle.html");
		Return $this->mTemplates[$pStyle];
	}

	/** comment here */
	function _finalize() {
	  #save page & queries
		$GLOBALS["vBenchmark"]->_finalize();
	  #save errors
		$this->mErrorObj->_finalize();
		$this->mUrlObj->_finalize();
	}

	/** comment here */
	function halt($pUrl) {
		$this->mUrlObj->mAddUrl = false;
		  $this->_finalize();
		  $vScript = new CScript("document.location='$pUrl'");
		  echo $vScript->display();die;
	}

	/** comment here */
	function customPieces() {

	}


	/** comment here */
  function displayError() {
	$error = $this->mErrorObj->popError();
	if (!empty($error)) {
		if ($error[1] == 3) Return "<script> addEvent(window, 'load', new Function('message(\"".addslashes($error[0])."\")')); </script>";
		if ($error[1] == 2) Return "<script> addEvent(window, 'load', new Function('showError(\"".addslashes($error[0])."\")')); </script>";;
		if ($error[1] == 1) Return "<script> addEvent(window, 'load', new Function('message(\"".addslashes($error[0])."\")')); </script>";
		if ($error[1] == 4) Return "<script> addEvent(window, 'load', new Function('message(\"".addslashes($error[0])."\")')); </script>";
	}
  }

  /** comment here */
  function setTemplate($tpl) {
	  switch($tpl) {
		case "blank":
			$this->mPageTemplate = "_common/templates/bare.html";
		}
  }


  }

?>