<?php
	class CPosition extends CDBContent {

	  var $section = "Applications";
	  var $parent = "CPositionManager";
	  var $table = "applications";


	  function CPosition ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function display() {
		$store = $this->mDatabase->getValue("stores", "Name", " ID = '".addslashes($this->mRowObj->StoreID)."'");
		$position = $this->mDatabase->getValue("jobs", "Name", " ID = '".addslashes($this->mRowObj->PositionID)."'");

		$message = "Store: " . $store . "<br>";
		$message .= "Position: " . $position . "<br>";
		$message .= "Name: " . $this->mRowObj->Name . "<br>";
		$message .= "Email: " . $this->mRowObj->Email . "<br>";
		if ($this->mRowObj->ResumePath) $message .= "Resume: <a target='_blank' href=" . $this->mRowObj->ResumePath . ">" . $this->mRowObj->ResumePath . "</a><br>";
		$message .= "<hr>";
		$message .= $this->mRowObj->Message;

		Return $message;
		
	}
	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/jobs/edit.html");

	  $txtInput = new CComboBox("StoreID","stores", "ID", "Name", $this->mRowObj->StoreID);
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size500");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Responsibilities","", 20, 60);
	  $txtInput->setClass("required size500");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Skills","", 20, 60);
	  $txtInput->setClass("required size500");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("ContactName","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("ContactPhone","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("ContactEmail","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);
	  $vForm->display();
	}

	/** comment here */
	function save() {
	  $new = !$this->mRowObj->ID;
	  $this->registerForm();

	  if ($new) {
			$this->mRowObj->UserID = $this->mUserID;
			$this->mRowObj->TimeStamp = time();
	  }
	  $this->easySave();
	}

	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from jobs where id = '".$this->mRowObj->ID."'");
	}


}
?>