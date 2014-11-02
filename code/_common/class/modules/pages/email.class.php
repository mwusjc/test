<?php   
/** CEmail
* @package pages
* @author cgrecu
*/


class CEmail extends CDBContent {

	var $section = "Templates";
	var $parent = "CEmailAdmin";
	var $table = "cms_newsletters";

	/** comment here */
	function CEmail($pPageID) {
	  $this->CDBContent($pPageID);
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
	  $vForm = new CForm("frmEdit", $this->getBaseLink("Templates") . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("D:/inetpub/wwwroot/_common/templates/mailing/template.html");

	  $txtInput = new CTextInput("FromName","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("FromAddress","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Subject","");
	  $txtInput->setClass("required size500");
	  $vForm->addElement($txtInput);

	  $input = new CCheckbox("Shared");
	  $input->setValues("yes", "no");
	  $input->setLabel(" allow other users to view this newsletter");
  	  $vForm->addElement($input);

	  $input = new CCheckbox("Status");
	  $input->setValues("enabled", "disabled");
	  $input->setLabel(" enable newsletter");
  	  $vForm->addElement($input);

	  $txtInput = new CInputFile("Path","");
	  $txtInput->setClass("required size500");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("HtmlVersion","", 30, 60);
	  $txtInput->setClass("required size450");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("TxtVersion","", 30, 60);
	  $txtInput->setClass("required size450");
	  $vForm->addElement($txtInput);


	  $vForm->display();
	 Return $this->flushTemplate();
	}

	/** comment here */
	function save() {
  	  $new = false; if (!$this->mRowObj->ID) $new = true;
	  $this->registerForm();

	  $check = $this->checkHTML();
	  if (!$check) {
		$this->error("Invalid HTML Code");
		Return false;
	  }
	  if ($new) {
		$this->mRowObj->UserID = $this->mUserID;
		$this->mRowObj->TimeStamp = time();
	  }

	  if ($_FILES["Path"]["name"]) {
		  $tmp = explode(".", $_FILES["Path"]["name"]);
		  $ext = array_pop($tmp);
		  $filename = implode(".", $tmp);
		  for($i=0; $i<100; $i++) {
			if (!$i) $i = "";
			$name = "media/attachments/". $filename . $i . ".". $ext;
			if (!file_exists($name)) break;
		  }
		  if (file_exists($name)) $name = uniqid("attachment");
		move_uploaded_file($_FILES["Path"]["tmp_name"], $name);
		$this->mRowObj->Attachment = $name;
	  }
	  $this->easySave();
//	  die();
	  Return true;
	}

	/** comment here */
	function checkHTML() {
//		return true;
		if (!strpos($this->mRowObj->HtmlVersion, "<body")) Return false;
		if (!strpos($this->mRowObj->HtmlVersion, "</body>")) Return false;
		if (!strpos($this->mRowObj->HtmlVersion, "</html>")) Return false;
		if (strpos($this->mRowObj->HtmlVersion, "<html>") === false) Return false;
		Return true;
	}

  }

?>