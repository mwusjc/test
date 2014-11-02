<?php
/** CPage
* @package pages
* @author cgrecu
*/


class CPage extends CDBContent {

	var $section = "Pages";
	var $parent = "CPageAdmin";
	var $table = "cms_pages";
	var $mDefaultType = "page";
	var $mMimeType = "html";
	var $mContentType = "cms";

	function CPage($pPageID) {
	  if (!$pPageID) $this->CDBContent($pPageID);
	  else {
		  $this->CDBObject();
		  if ((string)intval($pPageID) == $pPageID) {
			$this->mRowObj = $this->mDatabase->getRowObj("select * from cms_pages where id ='$pPageID'");
		  } else {
			$this->mRowObj = $this->mDatabase->getRowObj("select * from cms_pages where name ='".addslashes($pPageID)."'");
		  }
	  }
	}


	/** comment here */
	function display() {
		$langID = $this->getLangID();
//		$this->assign("TITLE", $this->mRowObj->Title);
		$this->resetTemplate("templates/common/page.html");
		$this->assign("CONTENT", $this->mRowObj->{"Txt$langID"});
		Return $this->flushTemplate();
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
	  $this->resetTemplate("_common/templates/pages/edit.html");
		$this->mDocument->mHead->addScript(new CScript("","_common/scripts/tiny_mce/tiny_mce.js"));
		$script = '	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "Txt",
		content_css : "css/sf.css",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
		debug : false
	});';
		$this->mDocument->mHead->addScript(new CScript($script));
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);

	  $vForm->addText("ContentType". $this->mRowObj->ContentType, "CHECKED");

	  $input = new CTextInput("Title", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CTextInput("Subject", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  $input = new CTextArea("Txt", "", 20, 60);
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
	  $this->mRowObj->ContentType = $this->mContentType;
	  $this->easySave();
	}

  }

?>