<?php

class CSectionManager extends CDBObject {

	var $mClasses = array();

	/** comment here */
	function CSectionManager() {
	  $this->CDBObject();

	}

	/** comment here */
	function register() {
	  $this->mDocument->mSection = $this->section;
	  CDBObject::register();
	  $this->registerClasses();
	}

	/** comment here */
	function registerClasses() {
	  Return true;
	  Return $this->_virtual();
	}

	/** comment here */
	function getClass() {
	  $class = $modules[$this->mClass];
	  $obj = new $class();
	  Return $obj;
	}

	/** comment here */
	function display() {
	  Return $this->_virtual();
	}

	/** comment here */
	function displayEdit($pID) {
	  $this->_virtual();
	}

	/** comment here */
	function displaySave($pID, $pRedirect = "") {
	  Return $this->_virtual();
	}

	/** comment here */
	function displayDelete($pID, $pRedirect = "") {
	  Return $this->_virtual();
	}

	/** comment here */
	function displayPrint($pID) {
	  Return $this->_virtual();
	}

	/** comment here */
	function displayEmail($pID) {
	  Return $this->_virtual();
	}

	/** comment here */
	function displayItem() {
	  Return $this->_virtual();
	}

	/** comment here */
	function setTitle($pName) {
		$this->mDocument->mHeadObj->mTitle = $pName;
		$this->mDocument->setPiece("MODULE_TITLE", $pName);
	}

	/** comment here */
	function setPiece($pPiece, $pContent) {
		$this->mDocument->setPiece($pPiece, $pContent);
	}

	/** comment here */
	function createXML($txt) {
	  $data = htmlentities($txt, ENT_NOQUOTES);
	  $txt = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	  $txt .= '<HtmlData>' . "\n";
	  $txt .= '<Data>'.$data.'</Data>' . "\n";
  	  $txt .= '</HtmlData>' . "\n";
	  header("Content-type: application/xml");
	  echo $txt;
	  die;
	}

	/** comment here */
	function mainSwitch() {
		switch($this->mOperation) {
		  case "main":
			Return $this->display();
		  case "edit":
			$vModuleOutput = $this->displayEdit($_GET["id"]);
		  case "edit":
		  case "view":
			$vModuleOutput = $this->displayItem($_GET["id"]);
		  break;
			case "delete":
			$vModuleOutput = $this->displayDelete($_GET["id"]);
			break;
		  case "save":
			$vModuleOutput = $this->displaySave($_GET["id"]);
			break;
		  case "soon":
			Return $this->displayUnderConstruction();
		  case "show_page":
			Return $this->displayFullPage($_GET["id"]);
		  case "error":
			Return $this->displayError();
		  default:
			Return file_get_contents("templates/404.html");

		}
		Return $vModuleOutput;
	}


}

?>