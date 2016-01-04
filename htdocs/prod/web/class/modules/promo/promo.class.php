<?php
	class CPromo extends CDBContent {

	  var $section = "Promos";
	  var $parent = "CPromoManager";
	  var $table = "flyer_images";


	  function CPromo ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/flyers/image_upload.html");

	  $txtInput = new CHidden("FlyerID",  $_GET["id"]);
	  $vForm->addElement($txtInput);
	  $flyer = new CFlyer($_GET["id"]);
	  $vForm->addText("Week", date("F d, Y", $flyer->mRowObj->Week));
	
	$slides = $this->mDatabase->getAll("select * from flyer_images where flyerid = '".$_GET["id"]."'");
	foreach ($slides as $k=>$v) {
		$vForm->createBlock("SLIDEB");
		$vForm->addText("Slide", $v["ImagePath"]);
		$vForm->addText("FlyerID", $_GET["id"]);
	}
	if (empty($slides)) {
		$vForm->createBlock("NOSLIDES");
	}
	$vForm->exitBlock();
	  $txtInput = new CInputFile("Path1","");
	  $txtInput->setClass("required size250");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputFile("Path2","");
	  $txtInput->setClass("required size250");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputFile("Path3","");
	  $txtInput->setClass("required size250");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputFile("Path4","");
	  $txtInput->setClass("required size250");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputFile("Path5","");
	  $txtInput->setClass("required size250");
	  $vForm->addElement($txtInput);
	  
	  $vForm->display();
	}

	/** comment here */
	function save() {
		$id = $_POST["FlyerID"];
	  for ($i=1; $i <=5; $i++) {
			if ($_FILES["Path$i"]["name"]) {
				  $newsrc = "homeimage_$id_" . uniqid("") ;
				  $path = $this->mDocument->mFileObj->upload2("Path$i", "any", "media/flyers/flyer_" . $id . "/" . $newsrc);
				  if ($path) {
					  $sql = "insert into flyer_images(FlyerID, ImagePath) values('".addslashes($id)."','".addslashes($path)."')";
					  $this->mDatabase->query($sql);
				  }
			}
		}
	}

	/** comment here */
	function delete() {
		$this->mDatabase->query("delete from brands where id = '".$this->mRowObj->ID."'");
	}


}
?>