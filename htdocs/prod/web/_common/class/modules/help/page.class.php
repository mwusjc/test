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
	
	/** comment here */
	function CDBContent($pPageID) {
	  $this->CDBContent($pPageID);
//	  if ((string)intval($pPageID) == $pPageID) {
//		$this->CContent("Pages", "cms_pages", "ID", $pPageID);
//	  } else {
//		$this->CContent("Pages", "cms_pages", "Name", $pPageID);	  	
//	  }
	}

	/** comment here */
	function display() {
	  Return nl2br($this->mRowObj->Txt);
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
	  $btOk = new CInput("btSubmit", "submit", "Save");
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $txtUrl = new CInput("Title", "text", $this->mRowObj->Title);
	  $txtUrl->loadTemplate("required");
	  $txtUrl->seta("width", "430px");
	  $vForm->add($txtUrl->validate("Enter a title for the page"));
	  $txtComment = new CRichTextArea("Txt", $this->mRowObj->Txt, 20,85);
	  $rows[] = array("Page Title: ", $txtUrl->display());
	  $rows[] = array("Page Content:");
	  $rows[] = array($txtComment->display());

	  $vUserID = $this->mRowObj->UserID; if (!$vUserID) $vUserID = $this->mUserID;
	  $hidUser = new CHidden("UserID", $vUserID);
	  $vTime = $this->mRowObj->TimeStamp; if (!$vTime) $vTime = time();
	  $hidTime = new CHidden("TimeStamp", $vTime);
	  $vType = $this->mRowObj->Type; if (!$vType) $vType = $this->mDefaultType;
	  $hidType = new CHidden("Type", $vType);

	  $vTable = new CGridTable($rows,array(),array($btOk->display()), "stdedit");
	  $vTable->setColsWidths(array("15%","85%"));
	  return $vForm->display($vTable->display(). $hidTime->display() . $hidUser->display() . $hidType->display());
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