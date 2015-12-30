<?php
	class CProduct extends CDBContent {

	  var $section = "DocTypes";
	  var $parent = "CProductManager";
	  var $table = "products";


	  function CProduct ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/products/edit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Description","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Packaging","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Pricing","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Comments","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CComboBox("BrandID","brands", "ID", "Name");
	  $txtInput->mExtraOption = array("0", " -- no brand -- ");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CComboBox("CategoryID","categories", "ID", "Name");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

		if ($this->mRowObj->Image) {
			$vForm->addText("Image", "<img src='".$this->mRowObj->Thumbnail."'>");
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
			$newsrc = "product_image_" . date("YmdHis") ;
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/products/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 600);
			$this->mRowObj->Image = $path;
			$this->mRowObj->Thumbnail = $this->mDocument->mFileObj->thumbnail($path, 96);
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
		$this->mDatabase->query("delete from products where id = '".$this->mRowObj->ID."'");
	}


}
?>