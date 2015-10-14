<?php
	class COrder extends CDBContent {

	  var $section = "Orders";
	  var $parent = "COrderManager";
	  var $table = "orders";


	  function COrder ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function display() {
		$this->resetTemplate("templates/platters/print_admin.html");

		$sql = "select a.* from platters a where a.status = 'enabled'";
		$platters = $this->mDatabase->getAllAssoc($sql);

		$plCart = unserialize($this->mRowObj->OrderData);
		foreach ($plCart as $key=>$val) {
			$this->newBlock("ITEM");
			$this->assign("Name", $platters[$val[0]]["Name"]);
			$this->assign("Quantity", $val[1]);
			$this->assign("Price", '$' . number_format($val[3], 2));
			$this->assign("Cost", '$' . number_format($val[1] * $val[3], 2));
			$total += $val[1] * $val[3];
		}
		$this->newBlock("TOTALS");
		$this->assign("SubTotal", '$' . number_format($total, 2));
		$this->assign("Tax", '$' . number_format(0.05 * $total, 2));
		$this->assign("Total", '$' . number_format(1.05 * $total, 2));

		$this->assign("Name", $this->mRowObj->Name);
		$this->assign("Address", $this->mRowObj->Address);
		$this->assign("PostalCode", $this->mRowObj->PostalCode);
		$this->assign("Phone", $this->mRowObj->Phone);
		$this->assign("Email", $this->mRowObj->Email);

		Return $this->flushTemplate();
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
			$this->mDocument->mFileObj->resize($path, 600);
			$this->mRowObj->Image = $path;
			$this->mDocument->mFileObj->thumbnail($path, 96);
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