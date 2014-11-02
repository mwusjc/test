<?php
/** CHelp
* @package pages
* @author cgrecu
*/


class CHelp extends CDBContent {

	var $section = "Pages";
	var $parent = "CHelpAdmin";
	var $table = "cms_help_sections";

	/** comment here */
	function CHelp($pPageID) {
	  $this->CDBContent($pPageID);
	}


	/** comment here */
	function display() {
		$this->assign("TITLE", $this->mRowObj->Title);
		$this->assign("CONTENT", $this->mRowObj->Txt);
//	  Return nl2br($this->mRowObj->Txt);
	}


	/** comment here */
	function displayText() {
	  $vTagManager = $GLOBALS["vTagManager"];
	  $page = $vTagManager->replaceTags($this->mRowObj->Txt);
	  Return $page;
	}

	/** page is not filtered for tags */
	function displaySimple() {
	  Return $this->mRowObj->Txt;
	}

	function displayEdit() {
	  $this->resetTemplate("_common/templates/pages/edithelp1.html");
		$this->mDocument->mHead->addScript(new CScript("","_common/scripts/tiny_mce/tiny_mce.js"));
		$script = '	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "Content",
		content_css : "css/sf.css",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		debug : false
	});';
		$this->mDocument->mHead->addScript(new CScript($script));
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);

	  $input = new CTextInput("Name", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CComboBox("TypeID", "	cms_help_main", "id", "name");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CTextInput("Page", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CTextArea("Content", "", 40, 60);
	  $vForm->addElement($input);

	  $this->assign("frmEdit_ERROR", $this->displayError());
	  $vForm->display();
	  Return $this->flushTemplate();
	}

	/** comment here */
	function sendMail($pEmail, $pSubject, $pFrom = "") {
		if (!$pFrom) $pFrom = APP_ADMIN_EMAIL;
		$txt = $this->displayText();
		$this->sendEmailComplete($pFrom, $pEmail, $pSubject, $txt);
	}

	/** comment here */
	function save() {
	  $this->registerForm();
	  $this->easySave();
	}

  }

?>