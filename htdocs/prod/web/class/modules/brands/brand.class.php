<?php
	class CBrand extends CDBContent {

	  var $section = "Brands";
	  var $parent = "CBrandManager";
	  var $table = "brands";


	  function CBrand ($pUserID = 0){
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
		$this->mDatabase->query("delete from brands where id = '".$this->mRowObj->ID."'");
	}


}
?>