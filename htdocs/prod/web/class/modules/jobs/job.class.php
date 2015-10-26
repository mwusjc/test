<?php
	class CJob extends CDBContent {

	  var $section = "Jobs";
	  var $parent = "CJobManager";
	  var $table = "jobs";


	  function CJob ($pUserID = 0){
		$this->CDBContent($pUserID);
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

	  $txtInput = new CDateTimePicker("TimeStamp","");
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