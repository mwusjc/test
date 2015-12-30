<?php
	class CPrivateLabel extends CDBContent {

	  var $section = "PrivateLabels";
	  var $parent = "CPrivateLabelManager";
	  var $table = "private_labels";


	  function CPrivateLabel ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/private_label/edit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Description","");
	  $txtInput->setClass("required ");
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
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/private_label/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 207);
			$this->mRowObj->Image = $path;
			$this->mDocument->mFileObj->thumbnail($path, 104);
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
		$this->mDatabase->query("delete from private_labels where id = '".$this->mRowObj->ID."'");
	}


}
?>