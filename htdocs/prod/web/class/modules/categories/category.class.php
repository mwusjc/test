<?php
	class CCategory extends CDBContent {

	  var $section = "DocTypes";
	  var $parent = "CCategoryManager";
	  var $table = "categories";


	  function CCategory ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("_common/templates/simpleedit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size150");
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
		$this->mDatabase->query("delete from categories where id = '".$this->mRowObj->ID."'");
	}


}
?>