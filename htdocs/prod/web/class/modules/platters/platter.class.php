<?php
	class CPlatter extends CDBContent {

	  var $section = "DocTypes";
	  var $parent = "CPlatterManager";
	  var $table = "platters";


	  function CPlatter ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/platters/edit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Price1","");
	  $txtInput->setClass("required size50");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Price2","");
	  $txtInput->setClass("required size50");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Price3","");
	  $txtInput->setClass("required size50");
	  $vForm->addElement($txtInput);

	  $txtInput = new CComboBox("CategoryID","platter_categories", "ID", "Name");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

		if ($this->mRowObj->Image) {
			$vForm->addText("Image", "<img src='".str_replace(".jpg", "_tn.jpg", $this->mRowObj->Image)."'>");
		}

	  $txtInput = new CInputFile("Path","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $vForm->display();
	}

	/** comment here */
	function save() {
	  $new = !$this->mRowObj->ID;
	  $this->registerForm();
		if ($_FILES["Path"]["name"]) {
			$newsrc = "product_image_" . date("YmdHi") ;
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/platters/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 420, 420);
			$this->mRowObj->Image = $path;
			$this->mDocument->mFileObj->thumbnail($path, 110, 110);
		  }
		}

	  if ($new) {
			$this->mRowObj->UserID = $this->mUserID;
			$this->mRowObj->TimeStamp = time();
	  }
	  $this->easySave();
	}

	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from platters where id = '".$this->mRowObj->ID."'");
	}


}
?>