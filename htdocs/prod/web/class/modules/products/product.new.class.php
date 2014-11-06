<?php
	class CProductNew extends CDBContent {

	  var $section = "DocTypes";
	  var $parent = "CProductManager";
	  var $table = "new_products";


	  function CProductNew ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save_new&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/products/edit_new.html");

	  $txtInput = new CSelect("Month");
	  $sql = "select distinct Month, from_unixtime(Month, '%M %Y') as MY from new_products order by Month ASC";
	  $data = $this->mDatabase->getAll($sql);
	  $months = array();
	  $months2 = array();
	  foreach ($data as $key=>$val) {
			$months[] = array($val["Month"],$val["MY"]);
			$months2[] = $val["Month"];
	  }
	  $d = strtotime("1 ". date("F") . " ". date("Y"));
	if (!in_array($d, $months2)) $months[] = array($d, date("F Y"));
	  $d = strtotime("1 ". date("F", time()+ 86400 * 31) . " ". date("Y", time()+ 86400 * 31));
	if (!in_array(date("F", time()+ 86400 * 31), $months2)) $months[] = array($d, date("F Y", time()+ 86400 * 31));
	$txtInput->mOptions = $months;

	  $txtInput->setClass("required size300");
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

//	  $this->mRowObj->Month = strtotime("1 ", $_POST["Month"], date("Y"));
	  $this->easySave();
	}


	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from products where id = '".$this->mRowObj->ID."'");
	}


}
?>