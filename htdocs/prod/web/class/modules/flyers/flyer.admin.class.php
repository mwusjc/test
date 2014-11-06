<?php
/** CFlyerAdmin
* @package admin
* @author cgrecu
*/


  class CFlyerAdmin extends CSectionAdmin {

	/** comment here */
	function CFlyerAdmin() {
	  $this->CSectionAdmin();
	}

	/** comment here */
	function display() {
		STitle::set("Manage Flyers");
		SAccess::enforce("manage_content");
	  $sql = "SELECT *  ".
			  " FROM flyers a WHERE 1=1  ".
			  " ##CRITERIA## ";
//			  " ORDER BY timestamp deSC";

	  $vSmart = new CSmartTable("users", $sql);
	  $vSmart->mTableType = "grid";
	  $vSmart->mItemsPerPage = 20;
	  $vSmart->mDefaultOrder = "TimeStamp";
	  $vSmart->mDefaultOrderDir = "DESC";
	  $vSmart->setIcons(array("edit", "delete", "view", "on"));

	  $vSmart->addDField("Week", "l, F d");


	  $vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Create new flyer"));
	  $vSmart->mColsWidths = array("10px", "10px", "500px", "70px");
	  $vSmart->mColsAligns = array("center", "center", "left", "right");
//	  $vSmart->setColsClass("center", "center", "left", "left",  "left", "right");
	  $vSmart->setTemplate("admin");
	  Return $this->displayError() . $vSmart->display();
	}



  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_content");
	$this->nav($pItemID, "edit", "cms_events");
	$vNews = new CFlyer($pItemID);
	$vNews->unregisterForm();
	Return $vNews->displayEdit();
  }

  /** comment here */
  function displayFlyer($id, $page = 0) {
		$this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
		$sql = "select * from flyer_pages where flyerid = '$id' order by orderid asc";
		$data = $this->mDatabase->getAll($sql);
        $this->resetTemplate("templates/flyers/flyer.html");
		$image =  "";
		foreach ($data as $key=>$val) {
			$this->newBlock("PAGE");
			$this->assign("FlyerID", $id);
			$this->assign("PageID", $val["ID"]);
			$this->assign("Thumb", $val["Thumbnail"]);
			if (!$key && !$page) $page = $val["ID"];
			if ($page == $val["ID"]) $image = $val["PageLocation"];
		}

		$this->newBlock("FLYER");
		$this->assign("Image", $image);
		$x = GetImageSize($image);
		$this->assign("Width", $x[0]);
		$this->assign("Height", $x[1]);
		$script = "<script>";
			$sql = "select * from flyer_products where pageid = '".$page."'";
			$slices = $this->mDatabase->getAll($sql);
			foreach ($slices as $key=>$val) {
				$tmp = explode(",", $val["Coordinates"]);
				$script .= ' slices['.($key+1).'] = {id: "region_'.($key+1).'", top: "'.$tmp[0].'", left: "'.$tmp[1].'", width: "'.$tmp[2].'", height: "'.$tmp[3].'", selected:false, index: "'.$val["RegionIndex"].'", productid: "'.($key+1).'"}; ';
				$script .= ' products['.($key+1).'] = {id: "'.$val["ProductID"].'", name: "'.$val["Name"].'", summary: "'.$val["Summary"].'", category: "'.$val["CategoryID"].'", brand: "'.$val["BrandID"].'", pricing: "'.$val["Pricing"].'", packaging: "'.$val["Packaging"].'", comments: "'.$val["Comments"].'", image:"'.trim($val["Image"]).'"}; ';
			}
		$script .= "</script>";
	  $this->mDocument->mBody->mJavaScript = " onload=\"initFlyer();\" ";
	  Return $this->flushTemplate() . $script;

  }

	/** comment here */
	function displaySave($pID) {
		SAccess::enforce("manage_content");
		$vNews = new CFlyer($pID);
		$vNews->save();
		$this->redirect($this->getBaseLink() . "main");
	}

	/** comment here */
	function toggle($pID) {
//		die("Sorry, this operation is not permitted anymore. Only the automatic scheduler is allowed to publish flyers. If this is an emergency, please contact The Brand Factory for assistance.");
		SAccess::enforce("manage_content");
		$vNews = new CFlyer($pID);
		$vNews->toggle($_GET["type"]);
		$this->redirect($this->getBaseLink() . "main");
	}

	/** comment here */
	function delete($id) {
		SAccess::enforce("manage_content");
		$vNews = new CFlyer($id);
		$vNews->delete();
		$this->redirect($this->getBaseLink() . "main");
	}

	/** comment here */
	function displayEditPage($id, $flyerid) {
		$page = new CFlyerPage($id);
		if ($flyerid && !$page->mRowObj->FlyerID) $page->mRowObj->FlyerID = $flyerid;
		Return $page->displayEdit();
	}

	/** comment here */
	function savePage($id) {
		$page = new CFlyerPage($id);
		$page->save();
		$this->redirect($this->getBaseLink() . "edit_page&id=" . $page->mRowObj->ID . "&flyer_id=" . $page->mRowObj->FlyerID);

	}

	/** comment here */
	function getProducts($id) {
		$sql = "select * from products where categoryid = '$id' and status = 'enabled' order by name asc";
		$data = $this->mDatabase->getAll($sql);
		$xml = "";
		foreach ($data as $key=>$val) {
			$xml .= "<ProductID>" . xmlentities($val["ID"]) . "</ProductID>";
			$xml .= "<ProductName>" . xmlentities($val["Name"]) . "</ProductName>";
		}
		xml($xml);
	}

	/** comment here */
	function getProductInfo($id) {
		$sql = "select * from products where id = '$id' and status = 'enabled'";
		$val = $this->mDatabase->getRow($sql);
		$xml = "";
		$xml .= "<ID>" . xmlentities($val["ID"]) . "</ID>";
		$xml .= "<Name>" . xmlentities($val["Name"]) . "</Name>";
		$xml .= "<Packaging>" . xmlentities($val["Packaging"]) . "</Packaging>";
		$xml .= "<Pricing>" . xmlentities($val["Pricing"]) . "</Pricing>";
		$xml .= "<Description>" . xmlentities($val["Description"]) . "</Description>";
		$xml .= "<CategoryID>" . xmlentities($val["CategoryID"]) . "</CategoryID>";
		$xml .= "<BrandID>" . xmlentities($val["BrandID"]) . "</BrandID>";
		$xml .= "<Image>" . xmlentities($val["Image"]) . "</Image>";
		$xml .= "<Thumbnail>" . xmlentities($val["Thumbnail"]) . "</Thumbnail>";
		xml($xml);
	}

	/** comment here */
	function uploadImage() {
		if ($_FILES["Filename"]["name"]) {
			$newsrc = "page_"  . $_GET["pageid"] . "_" . date("YmdHis");
			$path = $this->mDocument->mFileObj->upload2("Filename", "any", "media/flyers/flyer_" . $_GET["flyerid"] . "/products/" . $newsrc);
		  if ($path) {
			$this->mDocument->mFileObj->resize($path, 600);
			$this->mDocument->mFileObj->thumbnail($path, 120, 80);
			die("<script>top.completeUpload('$path');</script>");
		  }
	  	}
		die;
		die("<script>top.uploadFailed();</script>");
	}

	/** comment here */
	function emailFlyer($id) {
		if (!$id) $id = $this->mDatabase->getValue("flyers", "max(ID)", "status = 'enabled'");
		die2($id);
		$flyer = new CFlyer($id);
		$ret = $flyer->emailFlyer();
//		die("ok : $ret");
		
	}

	/** comment here */
	function enableBanners($id) {
		$flyer = new CFlyer($id);
		$flyer->enableBanners();
	
	}

	/** comment here */
	function enableFlyer() {
		die();
		$id = $this->mDatabase->getValue("flyers", "max(ID)");
		$flyer = new CFlyer($id);
		$ret = $flyer->emailFlyer();
//		if ($flyer->mRowObj->Status == "disabled") {
//			$flyer->toggle("on");
//			$ret = $flyer->emailFlyer();
//		}
		Return $ret;
	}

/** comment here */
	function displayDeals($id) {
		STitle::set("Manage Online Deals");
		SAccess::enforce("manage_content");
	  $sql = "SELECT *  ".
			  " FROM online_deals a WHERE a.FlyerID = '".addslashes($id)."'  ".
			  " ##CRITERIA## ";
//			  " ORDER BY timestamp deSC";

	  $vSmart = new CSmartTable("users", $sql);
	  $vSmart->mTableType = "grid";
	  $vSmart->mShowStatus = false;
	  $vSmart->mItemsPerPage = 20;
	  $vSmart->mDefaultOrder = "Name";
	  $vSmart->mDefaultOrderDir = "ASC";
	  $vSmart->setIcons(array("edit_deal", "view_deal",  "delete_deal"));

		$vSmart->addHeader(array("Product", "Pricing"));
		$vSmart->addField("Name");
		$vSmart->addField("Pricing");


	  $vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit_deal&flyer_id=" . $id, "Add deal"));
	  $vSmart->addExtraActions(new CHref($this->getBaseLink() . "alldeals&flyer_id=" . $id, "Print all deals"));
	  $vSmart->mColsWidths = array("10px", "10px", "300px", "200px", "70px");
	  $vSmart->mColsAligns = array("center", "center", "left",  "left", "right");
//	  $vSmart->setColsClass("center", "center", "left", "left",  "left", "right");
	  $vSmart->setTemplate("admin");
	  Return $this->displayError() . $vSmart->display();
	}

	/** comment here */
	function displayEditDeal($id, $flyerid) {
//		die2($_GET);
		SAccess::enforce("manage_products");
		$this->nav($pItemID, "edit", "products");
		$obj = new CDeal($id);
		if (!$obj->mRowObj->FlyerID) $obj->mRowObj->FlyerID = $flyerid;
		$obj->unregisterForm();
		$obj->displayEdit();
		Return $this->flushTemplate();
		
	}

	/** comment here */
	function saveDeal($id) {
			SAccess::enforce("manage_products");
			$obj = new CDeal($id);
			$obj->save();
			$this->redirect($this->getBaseLink() . "deals&id=" . $obj->mRowObj->FlyerID);
		
	}

	/** comment here */
	function displayDeal($id) {
		$obj = new CDeal($id);
		Return $obj->display();
	}

	/** comment here */
	function displayDealsSheet($id) {
		$sql = "select * from online_deals where FlyerID = '".addslashes($id)."' order by name asc";
		$data = $this->mDatabase->getAll($sql);
		$txt = "<table cellspacing=20 cellpadding=0>";
		foreach ($data as $key=>$val) {
			$obj = new CDeal($val["ID"]);
			if ($key%2==0 &&$key) $txt .= "</tr>";
			if ($key%2==0) $txt .= "<tr>";
			$txt .= "<td>" . $obj->display() . "</td>";
		}
		$txt .= "</tr></table>";
		Return $txt;
	}
	
	/** comment here */
	function mainSwitch() {
	  switch($this->mOp) {
		case "edit":
			Return $this->displayEdit($_GET["id"]);
		case "view":Return $this->displayFlyer($_GET["id"], $_GET["pageid"]);
		case "deals":Return $this->displayDeals($_GET["id"]);
		case "edit_deal":Return $this->displayEditDeal($_GET["id"], $_GET["flyer_id"]);
		case "save_deal":Return $this->saveDeal($_GET["id"]);
		case "view_deal":Return $this->displayDeal($_GET["id"]);
		case "alldeals":Return $this->displayDealsSheet($_GET["flyer_id"]);
		case "save":
			Return $this->displaySave($_GET["id"]);
		case "delete":
			Return $this->delete($_GET["id"]);
		case "toggle":
			Return $this->toggle($_GET["id"]);
		case "edit_page":
			Return $this->displayEditPage($_GET["id"], $_GET["flyer_id"]);
		case "save_page":
			Return $this->savePage($_GET["id"]);
		case "get_products":
			Return $this->getProducts($_GET["id"]);
		case "get_product_info":
			Return $this->getProductInfo($_GET["id"]);
		case "doupload":			Return $this->uploadImage();
		case "email_flyer":			Return $this->emailFlyer($_GET["id"]);
		case "enable_banners":			Return $this->enableBanners($_GET["id"]);
		case "enable_new_flyer":			Return $this->enableFlyer();
		default:
		  Return CSectionManager::mainSwitch();
	  }
	}
  }

?>
