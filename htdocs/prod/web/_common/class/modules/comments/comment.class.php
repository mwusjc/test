<?php
	class CComment extends CDBContent {

	  var $section = "Comments";
	  var $parent = "CCommentManager";
	  var $table = "cms_comments";


	  function CComment ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	  /** comment here */
	  function reload($data) {
		foreach ($this->mRowObj as $key=>$val) {
			$this->mRowObj->$key = "";
		}
		foreach ($data	 as $key=>$val) {
			$this->mRowObj->$key = $val;
		}
//		die2($this->mRowObj);
	  }

	  /** comment here */
	  function display() {
		$this->resetTemplate("templates/comments/view.html");

		$fields = array();
		$fields["FROM"] = $this->mRowObj->FirstName . " " . $this->mRowObj->LastName . "<".$this->mRowObj->Email . ">";
//		$fields["SUBJECT"] = $this->mRowObj->Subject;
		$fields["DATET"] = date("F d, Y h:i", $this->mRowObj->TimeStamp);
		if ($this->mRowObj->ReplyTime) $fields["REPLYDATE"] = date("F d, Y h:i", $this->mRowObj->ReplyTime); else $fields["REPLYDATE"] = "<a href='index2.php?n=Comments&o=reply&id=".$this->mRowObj->ID."'>reply now</a>";
		$fields["COMMENTS"] = nl2br($this->mRowObj->Message);

		foreach ($fields as $key=>$val) {
			$this->assignGlobal($key, $val);
		}

		if ($this->mRowObj->ReplyMessage) {
			$this->newBlock("REPLY");
			$this->assign("REPLYCOMMENTS", $this->mRowObj->ReplyMessage);
		}


		Return $this->flushTemplate();
	  }

	  /** comment here */
	  function displayReply() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink("Comments") . "doreply&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("_common/templates/pages/edit.html");
		$this->mDocument->mHead->addScript(new CScript("","_common/scripts/tiny_mce/tiny_mce.js"));
			$script = '	tinyMCE.init({
			theme : "advanced",
			mode : "exact",
			elements : "Comments",
			content_css : "css/sf.css",
			extended_valid_elements : "a[href|target|name]",
			plugins : "table",
			theme_advanced_buttons3_add_before : "tablecontrols,separator",
			theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
			debug : false
		});';
		$this->mDocument->mHead->addScript(new CScript($script));

		$this->resetTemplate("templates/comments/reply.html");

		$fields = array();
		$fields["DATET"] = date("F d, Y h:i", time());
		$fields["ORIGCOMMENTS"] = nl2br($this->mRowObj->Comments);

		foreach ($fields as $key=>$val) {
			$vForm->addText($key, $val);
		}

	  $txtInput = new CInputEmail("From", APP_ADMIN_EMAIL);
	  $txtInput->mSize = 45;
	  $txtInput->validate("From email is missing");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("To",$this->mRowObj->Email);
	  $txtInput->mSize = 60;
	  $txtInput->validate("Recipient is missing");
	  $vForm->addElement($txtInput);
//
  	  $txtInput = new CTextInput("Subject","Re: ". $this->mRowObj->Subject);
	  $txtInput->mSize = 60;
	  $txtInput->validate("Subject is missing");
	  $vForm->addElement($txtInput);

	  $input = new CTextArea("Comments", "", 20, 70);
  	  $vForm->addElement($input);


	  $vForm->display();
	  }

	  /** comment here */
	  function doReply() {
		 $this->mRowObj->ReplyMessage = $_POST["Comments"];
		 $this->mRowObj->ReplyTime = time();
		 $this->mRowObj->ReplySubject = $_POST["Subject"];
		 $this->mRowObj->ReplyTo = $_POST["To"];
		 $this->mRowObj->ReplyFrom = $_POST["From"];
		 $this->easySave();

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: '.$_POST["From"].'' . "\r\n";

		mail($_POST["To"], $_POST["Subject"],  $_POST["Comments"], $headers);
	  }


	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink("Comments") . "save&id=" . $this->mRowObj->ID);
		$this->resetTemplate("templates/users/contact.html");

	  $txtInput = new CTextInput("Name",$this->mUserObj->mRowObj->FirstName . " " . $this->mUserObj->mRowObj->LastName);
	  $txtInput->mSize = 45;
	  $txtInput->validate("Name is missing");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputEmail("Email", $this->mUserObj->mRowObj->Email);
	  $txtInput->mSize = 45;
	  $txtInput->validate("Email is missing");
	  $vForm->addElement($txtInput);

  	  $txtInput = new CTextInput("Subject","");
	  $txtInput->mSize = 60;
	  $txtInput->validate("Subject is missing");
	  $vForm->addElement($txtInput);

	  $input = new CTextArea("Comments", "", 12, 52);
  	  $vForm->addElement($input);

	  $vForm->display();
	}

	/** comment here */
	function save() {
//	  mail("lgrecu@thebrandfactory.com", "New website comment",  implode("\n", $_GET));
//	  if (!$_GET["Subject"] && !$_GET["Comments"]) Return true;;
	  $this->easySave();
	  mail("customerservice@highlandfarms.on.ca", "New website comment",  $_GET["Message"], "From: " .$_GET["Name"]  . "<".$_GET["Email"].">");
//	  mail("lgrecu@thebrandfactory.com", "New website comment",  $_GET["Message"], "From: " .$_GET["Name"]  . "<".$_GET["Email"].">");
	  mail($_GET["Email"], "Your comments have been received",  "Dear ". $_GET["Name"] . "\n\n Thank you for your interest. Your message has been sent to our customer service department.", "From: Highland Farms <info@highlandfarms.ca>");
	}


	/** comment here */
	function toggle() {
	  if ($this->mRowObj->Status == "suspended" || !$this->mRowObj->Status) $this->mRowObj->Status = "active"; else $this->mRowObj->Status = "suspended";
	  $this->easySave();
	}

	/** comment here */
	function delete() {
		$sql = "delete from cms_comments where id ='".$this->mRowObj->ID."'";
		$this->mDatabase->query($sql);
	}


}
?>