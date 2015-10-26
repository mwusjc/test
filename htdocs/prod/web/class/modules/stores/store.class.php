<?php
	class CStore extends CDBContent {

	  var $section = "DocTypes";
	  var $parent = "CStoreManager";
	  var $table = "stores";


	  function CStore ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/stores/edit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Address","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("City","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("PostCode","");
	  $txtInput->setClass("required size50");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Google","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("President","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Phone","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

		$_POST["Hours"] = br2nl($this->mRowObj->Hours);
	  $txtInput = new CTextArea("Hours","", 6, 60);
	  $txtInput->setClass("required size500");
//	  $txtInput->mText = br2nl($this->mRowObj->Hours);
	  $vForm->addElement($txtInput);

		if ($this->mRowObj->Map) {
			$vForm->addText("Image", "<img src='".$this->mRowObj->Map."'>");
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
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/stores/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 400);
			$this->mRowObj->Map = $path;
//			$this->mRowObj->Thumbnail = $this->mDocument->mFileObj->thumbnail($path, 96);
		  }
		}

	  if ($new) {
			$this->mRowObj->UserID = $this->mUserID;
			$this->mRowObj->TimeStamp = time();
	  }
	  $this->mRowObj->Hours = nl2br($this->mRowObj->Hours);
	  $this->easySave();
	}

	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from stores where id = '".$this->mRowObj->ID."'");
	}


}
?>