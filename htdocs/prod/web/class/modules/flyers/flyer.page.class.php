<?php
/** CEvent
* @package pages
* @author cgrecu
*/


class CFlyerPage extends CDBContent {

	var $section = "Flyers";
	var $parent = "CFlyerAdmin";
	var $table = "flyer_pages";

	/** comment here */
	function CFlyerPage($pID) {
		$this->CDBContent($pID);
	}

	/** comment here */
	function display() {
	  Return nl2br($this->mRowObj->Txt);
	}

	function displayEdit() {

		$region = "";
		if ($this->mRowObj->ID) {
			$this->resetTemplate("templates/flyers/page.html");
			$this->assign("Image", $this->mRowObj->PageLocation);
			$x = GetImageSize($this->mRowObj->PageLocation);
			$this->assign("Width", $x[0]);
			$this->assign("Height", $x[1]);
			$region = $this->flushTemplate();
			$this->mDocument->mHead->addScript(new CScript("", "js/flyer.js"));
		}

	  $this->resetTemplate("templates/flyers/flyer_page.html");
		$sql = "select * from flyer_pages WHERE flyerid = '".$this->mRowObj->FlyerID."' order by OrderID ASC";
		$data = $this->mDatabase->getAll($sql);
		foreach ($data as $key=>$val) {
			$this->newBlock("PAGE");
			$this->assign("FlyerID", $val["FlyerID"]);
			$this->assign("PageID", $val["OrderID"]);
			$this->assign("ID", $val["ID"]);
		}

	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save_page&id=" . $this->mRowObj->ID);

  	  $input = new CSelect("OrderID");
	  $fl = new CFlyer($this->mRowObj->FlyerID);
	  for($i=1; $i<= $fl->mRowObj->Pages; $i++) {
			$input->mOptions[] = array($i, $i);
	  }
	  $input->mDefault =  $this->mRowObj->OrderID;
	  $input->setClass("required size50");
	  $vForm->addElement($input);

  	  $input = new CHidden("FlyerID", $this->mRowObj->FlyerID);
	  $vForm->addElement($input);
  	  $input = new CHidden("PageID", $this->mRowObj->ID);
	  $vForm->addElement($input);
	  $vForm->addText("sFlyerID", $this->mRowObj->FlyerID);

		$week = $this->mDatabase->getValue("flyers", "Week", "ID = '".$this->mRowObj->FlyerID."'");
		$vForm->addText("Week", date("l, F d", $week));

		if ($this->mRowObj->PageLocation) {
			$vForm->addText("Thumbnail", "<a href=\"".$this->mRowObj->PageLocation."\" target=\"blank\"><img width=150 src='".$this->mRowObj->PageLocation."'></a>");
		}
  	  $input = new CInputFile("Path", "");
	  $input->setClass("required size300");
	  $vForm->addElement($input);


		$sql = "select * from categories where status = 'enabled' order by id asc";
		$data = $this->mDatabase->getAll($sql);

		$script = "<script>";
		if ($this->mRowObj->ID) {
			$vForm->createBlock("REGIONS");
//			$vForm->addText("ID", $this->mRowObj->ID);
			$vForm->addText("Regions", $region);
			$txt = "<select name='rpCategoryID' id='rpCategoryID'>";
			foreach ($data as $key=>$val) {
				$txt .= "<option value='" . $val["ID"] . "'>".addslashes($val["Name"])."</option>";
			}
			$txt .= "</select>";
			$vForm->addText("rpCategoryID", $txt);
			$sql  = "select * from brands where status = 'enabled' ORDER by Name ASC";
			$brands = $this->mDatabase->getAll($sql);
			$txt = "<select name='rpBrandID' id='rpBrandID'>";
			$txt .= "<option value='0'> -- no brand -- </option>";
			foreach ($brands as $key=>$val) {
				$txt .= "<option value='" . $val["ID"] . "'>".str_replace("\"",'\"', $val["Name"])."</option>";
			}
			$txt .= "</select>";
			$vForm->addText("rpBrandID", $txt);

			$sql = "select * from flyer_products where pageid = '".$this->mRowObj->ID."'";
			$slices = $this->mDatabase->getAll($sql);
			foreach ($slices as $key=>$val) {
				if (!$val["RegionIndex"]) continue;
				$tmp = explode(",", $val["Coordinates"]);
				$script .= ' slices['.($key+1).'] = {id: "region_'.($key+1).'", top: "'.$tmp[0].'", left: "'.$tmp[1].'", width: "'.$tmp[2].'", height: "'.$tmp[3].'", selected:false, index: "'.$val["RegionIndex"].'", productid: "'.($key+1).'"}; ';
				$script .= ' products['.($key+1).'] = {id: "'.$val["ProductID"].'", name: "'.$val["Name"].'", summary: "'.jsEncode($val["Summary"]).'", category: "'.$val["CategoryID"].'", brand: "'.$val["BrandID"].'", pricing: "'.jsEncode($val["Pricing"]).'", packaging: "'.jsEncode($val["Packaging"]).'", comments: "'.jsEncode($val["Comments"]).'", image:"'.trim($val["Image"]).'"}; ';
			}
			if (!empty($slices)) $this->mDocument->mBody->mJavaScript = "  onload='loadRegions(); '";
			$vForm->addText("sFlyerID", $this->mRowObj->FlyerID);
			$vForm->addText("sPageID", $this->mRowObj->ID);
		}
//die($script);
		foreach ($data as $key=>$val) {
			$script .= " categories['".$val["ID"]."'] = '" .addslashes($val["Name"]). "';";
		}
		$script .= "</script>";
	  $vForm->display();
	  Return $this->flushTemplate() . $script;
	}

	/**
		@comment
  		i'd like to know why these image variants all have the same height. is that an oversight?
  		_sean.
	*/
	function save() {

		$this->registerForm();
		if ($_FILES["Path"]["name"]) {
			$newsrc = "page_bg_" . date("YmdHis")  ;
		  $path = $this->mDocument->mFileObj->upload2("Path", "any", "media/flyers/flyer_" . $this->mRowObj->FlyerID . "/pages/" . $newsrc);
		  // die($path);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 600, 3000);
			$halfsize = str_replace(".", "_hf.", $path);
			$this->mDocument->mFileObj->resize2($path, $halfsize, 300, 5000);
			$this->mRowObj->PageLocation = $path;
			//	these are the original values which seem wrong
			//	$this->mRowObj->Thumbnail = $this->mDocument->mFileObj->thumbnail($path, 150, 5000);
			//	these are the actual dimension observed on the live site
			$this->mRowObj->Thumbnail = $this->mDocument->mFileObj->thumbnail($path, 150, 185);
		  }
	  	}

		$regions = array();
		if (trim($_POST["pageData"])) $regions = explode("#####", trim($_POST["pageData"]));
		$sql = "delete from flyer_products where pageid = '".$this->mRowObj->ID."'";
		$this->mDatabase->query($sql);

		foreach ($regions as $key=>$val) {
			$region = explode("^^^^", $val);
			#region: id, top, left, width, height, index, productid, name, summary, category, brand, pricing, packaging, comments, image
				$fields = array();
			$fields["PageID"] = $this->mRowObj->ID;
			$fields["Coordinates"] = $region[1] . ",". $region[2]  . ",". $region[3]  . ",". $region[4];
			$fields["RegionIndex"] = $region[5];
			$fields["ProductID"] = $region[6];
			$fields["Name"] = $region[7];
			$fields["Summary"] = $region[8];
			$fields["CategoryID"] = $region[9];
			$fields["BrandID"] = $region[10];
			$fields["Pricing"] = $region[11];
			$fields["Packaging"] = $region[12];
			$fields["Comments"] = $region[13];
			$fields["Image"] = $region[14];
			$sql = "insert into flyer_products" . $this->mDatabase->makeInsertQuery($fields);
			$this->updateProduct($fields);
//echo $sql;
			$this->mDatabase->query($sql);
//			die();
		}
		$this->easySave();

	}

	/** comment here */
	function updateProduct($data) {
		unset($data["PageID"]);
		unset($data["Coordinates"]);
		unset($data["RegionIndex"]);
		unset($data["ProductID"]);
		if (!$data["Name"])  Return true;
		$check = intval($this->mDatabase->getValue("products", "max(ID)", "Name = '".addslashes($data["Name"]) ."' and CategoryID = '".intval($data["CategoryID"])."' and BrandID = '".intval($data["BrandID"])."'"));
		if (!$check) {
			$sql = "insert into products" . $this->mDatabase->makeInsertQuery($data);
		} else {
			$sql = "update products set  " . $this->mDatabase->makeUpdateQuery($data) . " Where ID = '".intval($check)."'" ;
		}
		$this->mDatabase->query($sql);
	}

	/** comment here */
	function toggle($pType) {
		if ($pType == "off") $this->mRowObj->Status = "disabled"; else $this->mRowObj->Status = "enabled";
		$this->easySave();
	}

	/** comment here */
	function delete() {
		$sql = "delete from cms_events where id = '".$this->mRowObj->ID."'";
		$this->mDatabase->query($sql);
	}

  }

	/** comment here */
	function jsEncode($txt) {
		Return str_replace(array("\n", "\r"), array('\n\\' . "\n", ""), $txt);
//		$tmp = explode("\n", $txt);
//		$txt = array();
//		foreach ($tmp as $key=>$val) {
//			$txt[] =
//		}
	}
?>