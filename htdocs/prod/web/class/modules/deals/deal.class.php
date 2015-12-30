<?php
	class CDeal extends CDBContent {

	  var $section = "Flyers";
	  var $parent = "CDealManager";
	  var $table = "online_deals";


	  function CDeal ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function display() {
		$this->resetTemplate("templates/products/coupon.html");
		$this->assign("Name", $this->mRowObj->Name);
		$this->assign("Pricing", $this->mRowObj->Pricing);
		$this->assign("Image", $this->mRowObj->Thumbnail);
		$this->assign("Description", $this->mRowObj->Description);
		Return $this->flushTemplate();
	}
	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save_deal&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/products/deal.html");

	  $txtInput = new CHidden("FlyerID",  $this->mRowObj->FlyerID);
	  $vForm->addElement($txtInput);

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
//	  die();
	}

	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from online_deals where id = '".$this->mRowObj->ID."'");
	}


}
?>