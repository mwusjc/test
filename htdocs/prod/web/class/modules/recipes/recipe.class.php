<?php
	class CRecipe extends CDBContent {

	  var $section = "Recipes";
	  var $parent = "CRecipeManager";
	  var $table = "recipes";


	  function CRecipe ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/recipes/edit.html");

	  $txtInput = new CTextInput("Name","");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Ingredients","", 10, 60);
	  $txtInput->setClass("required");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Directions","", 10, 60);
	  $txtInput->setClass("required");
	  $vForm->addElement($txtInput);

	  $txtInput = new CComboBox("CategoryID","recipes_categories", "ID", "Name");
	  $txtInput->setClass("required size300");
	  $vForm->addElement($txtInput);

		if ($this->mRowObj->Image) {
			$vForm->addText("Image", "<img src='". $this->mRowObj->Image."'>");
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
			$newsrc = "recipe_image_" . date("YmdHi") ;
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/recipes/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 142, 83);
			$this->mRowObj->Image = $path;
//			$this->mDocument->mFileObj->thumbnail($path, 96);
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
		$this->mDatabase->query("delete from recipes where id = '".$this->mRowObj->ID."'");
	}


}
?>