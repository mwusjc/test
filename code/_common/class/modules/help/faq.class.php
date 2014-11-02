<?php
/** CFaq
* @package pages
* @author cgrecu
*/


class CFaq extends CDBContent {

	var $section = "Faq";
	var $parent = "CFaqAdmin";
	var $table = "cms_help_entries";
	var $mDefaultType = "page";
	var $mMimeType = "html";

	/** comment here */
	function CFaq($pPageID) {
	  $this->CDBContent($pPageID);
//	  if ((string)intval($pPageID) == $pPageID) {
//		$this->CContent("Pages", "cms_pages", "ID", $pPageID);
//	  } else {
//		$this->CContent("Pages", "cms_pages", "Name", $pPageID);
//	  }
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
	  $this->resetTemplate("_common/templates/pages/edithelp2.html");
		$this->mDocument->mHead->addScript(new CScript("","_common/scripts/tiny_mce/tiny_mce.js"));
		$script = '	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "Content",
		content_css : "css/sf.css",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
		debug : false
	});';
		$this->mDocument->mHead->addScript(new CScript($script));
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);

	  $input = new CTextInput("Name", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CTextArea("Content", "", 20, 60);
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