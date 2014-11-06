<?php
/*
@author: Evgeni Brukson
@purpose: All site pages related to Events section will be handles here
*/
class CFlyerManager extends CSectionManager
{

	var $mFlyerMode = "standard";
	var $mCurrentFlyer = 0;
	var $mPastFlyer = 0;
	var $mShowOption = false;

    function __construct() {
        $this->CSectionManager();

		
		$activeflyer = $this->mDatabase->getRow("select * from flyers where Status = 'enabled' order by id desc limit 1");
		$previousflyer = $this->mDatabase->getRow("select * from flyers where Status = 'disabled' and id < ".intval($activeflyer["ID"])." order by id desc limit 1");
		$this->mShowOption = false;
		if ($_GET["mode"]) {
			$this->mFlyerMode = $_GET["mode"];
			$_SESSION["FlyerMode"] = $_GET["mode"];
		}
		if ($_SESSION["FlyerMode"]) $this->mFlyerMode = $_SESSION["FlyerMode"];



			/*
				As the new flyer becomes active and until Thursday at midnight, show both flyers with an option to choose and toggle. Conditions for this to happen are:
				1. an active flyer with a date in the future exists
				2. day is wed after 10pm or thursday all day

				if the active flyer has a date in the past, do NOT show option, just show active flyer
			*/

			if (date("w") == 3 || date("w") == 4) {
				if ($activeflyer["Week"] >= time()) $this->mShowOption = true;
			}
			$this->mCurrentFlyer = $activeflyer["ID"];
			$this->mPastFlyer = $previousflyer["ID"];
//		die2($activeflyer);
//		die2(date("F d, Y H:i", $activeflyer["Week"]));
		if ($activeflyer["Week"] >= time() + 2 * 86400) $this->sendAlert("Flyer from the future is activated too early!");


    }

	/** comment here */
	function sendAlert($type) {
//		mail("lgrecu@thebrandfactory", "HF Flyer problem", "Problem: " . $type);
	}

	/** comment here */
	function getID() {

		if ($this->mFlyerMode == "standard") Return $this->mCurrentFlyer; else Return $this->mPastFlyer;
		Return $this->mCurrentFlyer;
		$id = $this->mDatabase->getValue("flyers", "max(ID)", "Status = 'enabled'");
		if ($this->mFlyerMode == "standard" || !$this->mShowOption) Return intval($id);
		else {
			$id = $this->mDatabase->getValue("flyers", "max(ID)", "Status = 'disabled' and id < ". intval($id));
			Return intval($id);
		}
	}

  // shows a list of available countries
    function display($pageid) {

	STitle::set(APP_TITLE_SHORT . " - Browse Our Online Flyer, updated every Thursday");
	 $this->mDocument->mPageTemplate = "templates/flyer.html";
	 $this->mDocument->setPiece("BOTTOM_BANNERS", "");
//	  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
	  $this->mDocument->mHead->addCss("css/listmenu_h.css");
	  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");




		$this->resetTemplate("templates/flyers/flyer_container.html");
		$id = $this->getID();
//die2($id);

		$this->loadBrands($id);
		
		if ($this->mShowOption) {

		  $pics = $this->mDatabase->getAllAssoc("select a.PageLocation, b.Week, b.WeekEnds, b.ID, b.PDF from flyer_pages a, flyers b where a.flyerid in (".intval($this->mCurrentFlyer).",".intval($this->mPastFlyer).") and a.OrderID = 1 and a.FlyerID = b.ID order by a.FlyerID");
			
			$boxflyer = $pics[$this->mPastFlyer];	
			$boxflyer2 = $pics[$this->mCurrentFlyer];	

			if (!$_GET["mode"]) {
				$this->mDocument->mHead->addScript(new CScript("", "js/flyer_popup.js"));
				 $this->mDocument->mHead->addScript(new CScript(" var flyerpics = ['','']; flyerpics[0] = '".APP_SERVER_NAME.$pics[$this->mPastFlyer]["PageLocation"]."';  flyerpics[1] = '".APP_SERVER_NAME.$pics[$this->mCurrentFlyer]["PageLocation"]."'; var flyerdates = []; flyerdates[0] = '".date("F d, Y", $pics[$this->mPastFlyer]["Week"]+ 12000)." <br>to ".date("F d, Y", $pics[$this->mPastFlyer]["WeekEnds"]+ 12000)."';flyerdates[1] = '".date("F d, Y", $pics[$this->mCurrentFlyer]["Week"]+ 12000)." <br>to ".date("F d, Y", $pics[$this->mCurrentFlyer]["WeekEnds"]+ 12000)."';"));
			}

			$this->newBlock("COMINGBOX");
			$this->assign("Title", "VIEW CURRENT FLYER"); 
			$this->assign("Mode", "previous"); 
			$this->assign("FlyerImage", APP_SERVER_NAME.$boxflyer["PageLocation"]);
			$this->assign("FlyerPDF", APP_SERVER_NAME.$boxflyer["PDF"]);
			$this->assign("Effective", "Effective ".date("F d, Y", $boxflyer["Week"]+12000) . " to " . date("F d, Y", $boxflyer["WeekEnds"]+12000));


			$this->newBlock("COMINGBOX");
			$this->assign("Title", "VIEW UPCOMING FLYER"); 
			$this->assign("Mode", "standard"); 
			$this->assign("FlyerImage", APP_SERVER_NAME.$boxflyer2["PageLocation"]);
			$this->assign("FlyerPDF", APP_SERVER_NAME.$boxflyer2["PDF"]);
			$this->assign("Effective", "Effective ".date("F d, Y", $boxflyer2["Week"]+12000) . " to " . date("F d, Y", $boxflyer2["WeekEnds"]+12000));

		}		 else {
				$this->newBlock("CURRENT");
			$pdf =$this->mDatabase->getValue("flyers", "PDF", "ID = " . intval($this->mCurrentFlyer));
			
			$this->assign("FlyerPDF", APP_SERVER_NAME.$pdf);

		}

		$this->newBlock("MAINPAGE");
		$sql = "select * from flyer_pages where flyerid = $id order by orderid asc";
		$pages = $this->mDatabase->getAll($sql);
		$this->assign("Pages", count($pages));
		if (!$pageid) $pageid = 0;
		$this->assign("PageID", $pageid);

		$script = "<script>";
		foreach ($pages as $key=>$val) {
			$x = GetImageSize($val["PageLocation"]);
			$script .= ' pages['.$key.'] = {id:'.$val["ID"].',image: "'.$val["PageLocation"].'", thumb: "'.$val["Thumbnail"].'", width:'.$x[0].', height:'.$x[1].'}; ';
		}

		$script .= $this->loadProducts($id);
		$script .= " addEvent(window, 'load', new Function('initFlyer(";
		if ($pageid) $script.= $pageid - 1;
		$script .= ")')); ";
		$script .= "</script>";
	  Return $this->flushTemplate() . $script;
    }

	/** comment here */
	function loadBrands($id) {
		$sql = "select distinct c.Name, a.CategoryID from flyer_products a, flyer_pages b, categories c where a.PageID = b.ID and b.FlyeriD = '".$id."' and a.CategoryID = c.ID order by 1 asc";
		$data = $this->mDatabase->getAll($sql);
		foreach ($data as $key=>$val) {
			$this->newBlock("CATEGORY");
			$this->assign("CategoryName", $val["Name"]);
			$this->assign("CategoryID", $val["CategoryID"]);
		}

		$sql = "select distinct c.Name, a.BrandID from flyer_products a, flyer_pages b, brands c where a.PageID = b.ID and b.FlyeriD = '".$id."' and a.BrandID = c.ID order by 1 asc";
		$data = $this->mDatabase->getAll($sql);
		foreach ($data as $key=>$val) {
			$this->newBlock("BRAND");
			$this->assign("BrandName", $val["Name"]);
			$this->assign("BrandID", $val["BrandID"]);
		}
	}

	/** comment here */
	function loadProducts($id) {
		$sql = "select a.* from flyer_products a, flyer_pages b where b.flyerid = $id and b.id =a.pageid order by PageID ASC, RegionIndex";
		$products = $this->mDatabase->getAll($sql);
		$txt = "";
		foreach ($products as $key=>$val) {
				$tmp = explode(",", $val["Coordinates"]);
				$txt .= ' slices['.($key+1).'] = {pageid:'.$val["PageID"].',id: "region_'.($key+1).'", top: "'.$tmp[0].'", left: "'.$tmp[1].'", width: "'.$tmp[2].'", height: "'.$tmp[3].'", selected:false, index: "'.$val["RegionIndex"].'", productid: "'.($key+1).'"}; ';
				$txt .= ' products['.($key+1).'] = {pageid:'.$val["PageID"].',id: "'.$val["ID"].'", name: "'.$val["Name"].'", summary: "'.nl2brX($val["Summary"]).'", category: "'.$val["CategoryID"].'", brand: "'.$val["BrandID"].'", pricing: "'.nl2brX($val["Pricing"]).'", packaging: "'.nl2brX($val["Packaging"]).'", comments: "'.$val["Comments"].'", image:"'.trim($val["Image"]).'"}; ';
		}
		Return $txt;
	}
	/** comment here */
	function displayBrands($brandid) {
		STitle::set(APP_TITLE_SHORT . " - Browse all brands in current flyer");
		 $this->mDocument->mPageTemplate = "templates/flyer.html";
//		  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
		  $this->mDocument->mHead->addCss("css/listmenu_h.css");
		  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

			$this->resetTemplate("templates/flyers/flyer_list.html");
			$id = $this->getID();

			$this->loadBrands($id);
		$sql = "select distinct a.* from flyer_products a, flyer_pages b where a.PageID = b.ID and b.FlyeriD = '".$id."' and a.BrandID = '".$brandid."'order by a.PageID asc, a.RegionIndex ASC";
		$data = $this->mDatabase->getAll($sql);
		$this->newBlock("ITEMCOUNT");
		$this->assign("Items", count($data));
		$pageIndex = 0; $prevPage = "";
		foreach ($data as $key=>$val) {
			if ($prevPage != $val["PageID"]) $pageIndex ++;
			$this->newBlock("PRODUCT");
			$this->assign("Name", $val["Name"]);
			$this->assign("Image", str_replace(".", "_tn.", $val["Image"]));
			$this->assign("Pricing", $val["Pricing"]);
			$this->assign("Summary", $val["Summary"]);
			$this->assign("PageID", $pageIndex);
			$this->assign("Qty", 1);
			$this->assign("ProductID", $val["ID"]);
			$prevPage = $val["PageID"];
		}

		$script = "<script>";
		$script .= $this->loadProducts($id);
		$script .= " addEvent(window, 'load', new Function('loadCart(true)')); ";
		$script .= "</script>";
	  Return $this->flushTemplate() . $script;
	}

	/** comment here */
	function displayCategories($categoryid) {
		STitle::set(APP_TITLE_SHORT . " - Browse all categories in current flyer");
		 $this->mDocument->mPageTemplate = "templates/flyer.html";
//		  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
		  $this->mDocument->mHead->addCss("css/listmenu_h.css");
		  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

			$this->resetTemplate("templates/flyers/flyer_list.html");
			$id = $this->getID();

			$this->loadBrands($id);
		$sql = "select distinct a.*, b.OrderID from flyer_products a, flyer_pages b where a.PageID = b.ID and b.FlyeriD = '".$id."' and a.CategoryID = '".$categoryid."'order by a.PageID asc, a.RegionIndex ASC";
		$data = $this->mDatabase->getAll($sql);
		$this->newBlock("ITEMCOUNT");
		$this->assign("Items", count($data));
		$pageIndex = 0; $prevPage = "";
		foreach ($data as $key=>$val) {
//			if ($prevPage != $val["PageID"]) $pageIndex ++;
			$pageIndex = $val["OrderID"];
			$this->newBlock("PRODUCT");
			$this->assign("Name", $val["Name"]);
			$this->assign("Image", str_replace(".", "_tn.", $val["Image"]));
			$this->assign("Pricing", $val["Pricing"]);
			$this->assign("Summary", $val["Summary"]);
			$this->assign("PageID", $pageIndex);
			$this->assign("Qty", 1);
			$this->assign("ProductID", $val["ID"]);
			$prevPage = $val["PageID"];
		}
		$script = "<script>";
		$script .= $this->loadProducts($id);
		$script .= " addEvent(window, 'load', new Function('loadCart(true)')); ";
		$script .= "</script>";
	  Return $this->flushTemplate() . $script;

	}


	/** comment here */
	function displayShoppingList() {
		STitle::set(APP_TITLE_SHORT . " - View shopping list");
		 $this->mDocument->mPageTemplate = "templates/flyer.html";
//		  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
		  $this->mDocument->mHead->addCss("css/listmenu_h.css");
		  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

			$this->resetTemplate("templates/flyers/flyer_list.html");
			$id = $this->getID();

			$this->loadBrands($id);
			$tmp = explode("_____", $_COOKIE["shoppingCart"]);
			$cart = array();
			$items = array();
			foreach ($tmp as $key=>$val) {
				$tmp2 = explode("%%%", $val);
				$cart[$tmp2[0]] = $tmp2[2];
				$items[] = $tmp2[0];
			}
		if (!empty($cart)) {
			$sql = "select distinct a.* from flyer_products a where a.ID in ('".implode("','", $items)."')  order by a.PageID asc, a.RegionIndex ASC";
			$data = $this->mDatabase->getAll($sql);
			$this->newBlock("ITEMCOUNT");
			$this->assign("Items", count($data));
			$pageIndex = 0; $prevPage = "";
			foreach ($data as $key=>$val) {
				if ($prevPage != $val["PageID"]) $pageIndex ++;
				$this->newBlock("PRODUCT");
				$this->assign("Name", $val["Name"]);
				$this->assign("Image", str_replace(".", "_tn.", $val["Image"]));
				$this->assign("Pricing", $val["Pricing"]);
				$this->assign("Summary", $val["Summary"]);
				$this->assign("PageID", $pageIndex);
				$this->assign("ProductID", $val["ID"]);
				$this->assign("Qty", $cart[$val["ID"]]);
				$this->assign("extraAction", "window.location.reload();");
				$prevPage = $val["PageID"];
			}
		}
		$script = "<script>";
		$script .= $this->loadProducts($id);
		$script .= " addEvent(window, 'load', new Function('loadCart(true)')); ";
		$script .= "</script>";
	  Return $this->flushTemplate() . $script;

	}

	/** comment here */
	function printList() {
		 $this->mDocument->mPageTemplate = "_common/templates/print.html";
//		  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
		  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
		  $this->mDocument->mHead->addCss("css/listmenu_h.css");
		  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

			$this->resetTemplate("templates/flyers/print.html");
			$id = $this->getID();

			$this->loadBrands($id);
			$tmp = explode("_____", $_COOKIE["shoppingCart"]);
			$cart = array();
			$items = array();
			foreach ($tmp as $key=>$val) {
				$tmp2 = explode("%%%", $val);
				$cart[$tmp2[0]] = $tmp2[2];
				$items[] = $tmp2[0];
			}
		if (!empty($cart)) {
			$sql = "select distinct a.* from flyer_products a where a.ID in ('".implode("','", $items)."')  order by a.PageID asc, a.RegionIndex ASC";
			$data = $this->mDatabase->getAll($sql);
			$this->newBlock("ITEMCOUNT");
			$this->assign("Items", count($data));
			$pageIndex = 0; $prevPage = "";
			foreach ($data as $key=>$val) {
				if ($prevPage != $val["PageID"]) $pageIndex ++;
				$this->newBlock("PRODUCT");
				$this->assign("Name", $val["Name"]);
//				$this->assign("Image", str_replace(".", "_tn.", $val["Image"]));
				$this->assign("Pricing", $val["Pricing"]);
				$this->assign("Summary", $val["Summary"]);
				$this->assign("PageID", $pageIndex);
				$this->assign("ProductID", $val["ID"]);
				$this->assign("Qty", $cart[$val["ID"]]);
				$this->assign("extraAction", "window.location.reload();");
				$prevPage = $val["PageID"];
			}
		}
//		$script = "<script>";
//		$script .= $this->loadProducts($id);
//		$script .= " addEvent(window, 'load', new Function('loadCart(true)')); ";
//		$script .= "</script>";
	  Return $this->flushTemplate() . $script;
	}

	/** comment here */
	function displayAllPages() {
		STitle::set(APP_TITLE_SHORT . " - View all flyer pages");
	 $this->mDocument->mPageTemplate = "templates/flyer.html";
	 $this->mDocument->setPiece("BOTTOM_BANNERS", "");
//	  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
	  $this->mDocument->mHead->addCss("css/listmenu_h.css");
	  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

        $this->resetTemplate("templates/flyers/full.html");
		$id = $this->getID();

		$this->loadBrands($id);
		$this->newBlock("MAINPAGE");
		$sql = "select * from flyer_pages where flyerid = $id order by orderid";
		$pages = $this->mDatabase->getAll($sql);
		$this->assign("Pages", count($pages));

		$script = "<script>";
		$txt = "";
		foreach ($pages as $key=>$val) {
			$x = GetImageSize($val["PageLocation"]);
			$script .= ' pages['.$key.'] = {id:'.$val["ID"].',image: "'.$val["PageLocation"].'", thumb: "'.$val["Thumbnail"].'", width:'.$x[0].', height:'.$x[1].'}; ';
			$txt .= "<a href='index.php?n=Flyers&o=main&id=".($key+1)."'><img border='0' style='margin: 5px;' src='".$val["Thumbnail"]."' width=150></a>";
		}
		$this->assign("PageList", $txt);

		$script .= $this->loadProducts($id);
		$script .= "</script>";
	  Return $this->flushTemplate() . $script;

	}

	/** comment here */
	function displayFacing($pageid) {
		STitle::set(APP_TITLE_SHORT . " - View facing flyer pages ");
	 $this->mDocument->mPageTemplate = "templates/flyer.html";
	 $this->mDocument->setPiece("BOTTOM_BANNERS", "");
//	  $this->mDocument->mHead->addScript(new CScript("", "js/fsmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/hfmenu.js"));
	  $this->mDocument->mHead->addScript(new CScript("", "js/flyer_main.js"));
	  $this->mDocument->mHead->addCss("css/listmenu_h.css");
	  $this->mDocument->mHead->addCss("css/listmenu_hHF.css");

        $this->resetTemplate("templates/flyers/facing.html");
		$id = $this->getID();

		$this->loadBrands($id);
		$this->newBlock("MAINPAGE");
		$sql = "select * from flyer_pages where flyerid = $id order by orderid";
		$pages = $this->mDatabase->getAll($sql);
		$this->assign("Pages", count($pages));
		if (!$pageid) $pageid = 0;
		$this->assign("PageID1", $pageid);
		$this->assign("PageID2", $pageid + 1);

		$script = "<script>";
		foreach ($pages as $key=>$val) {
			$x = GetImageSize($val["PageLocation"]);
			$script .= ' pages['.$key.'] = {id:'.$val["ID"].',image: "'.str_replace(".", "_hf.", $val["PageLocation"]).'", thumb: "'.$val["Thumbnail"].'", width:'.$x[0].', height:'.$x[1].'}; ';
		}

		$script .= $this->loadProducts($id);
		$script .= " addEvent(window, 'load', new Function('initFlyer(";
		if ($pageid) $script.= $pageid - 1;
		$script .= ")')); ";
		$script .= " flyerMode = 'facing';</script>";
	  Return $this->flushTemplate() . $script;

	}

	/** comment here */
	function displayHelp() {
		$this->resetTemplate("templates/flyers/help.html");
		 Return $this->flushTemplate();
	}


	/** comment here */
	function displayPrint() {
		$this->mDocument->mPageTemplate = "templates/blank.html";
		$id = $this->getID();
		$sql = "SELECT a.*, c.Name AS Brand, d.Name AS Category 
FROM flyer_products a LEFT OUTER JOIN brands c ON a.BrandID = c.ID LEFT OUTER JOIN categories d ON a.CategoryID = d.ID,flyer_pages b 
WHERE b.flyerid = '".addslashes($id)."' AND b.id =a.pageid  AND regionindex <> 0
ORDER BY d.Name ASC";
		$data = $this->mDatabase->getAll($sql);
		$products = array();
		foreach ($data as $key=>$val) {
			$products[$val["Category"]][] = $val;
		}

		$this->resetTemplate("templates/flyers/print-all.html");
		foreach ($products as $key=>$val) {
			$this->newBlock("CATEGORY");
			$this->assign("Name", $key);
			foreach ($val as $key2=>$val2) {
				$this->newBlock("PRODUCT");
				$this->assign("Name", $val2["Name"]);
				$this->assign("Brand", $val2["Brand"]);
				$this->assign("Summary", $val2["Summary"]);
				$this->assign("Price", $val2["Pricing"]);
			}
		}
		 Return $this->flushTemplate();
	}

	/** comment here */
	function download() {
		$id = $this->getID();
//		$id = 15;
		require("class/modules/flyers/flyer.class.php");
		$flyer = new CFlyer($id);
		if (file_exists($flyer->mRowObj->PDF)) {
			CFileManager::download($flyer->mRowObj->PDF);
			$this->redirect("index.php");
		} else {
			$this->redirect(APP_SERVER_NAME."/index.php?n=Flyers&o=main");
		}
	}

	/** comment here */
	function downloadLast() {
		$id = $this->getID();
		$id = $this->mDatabase->getValue("flyers", "Max(ID)", "ID < " . intval($id));
//		$id = 15;
		require("class/modules/flyers/flyer.class.php");
		$flyer = new CFlyer($id);
		if (file_exists($flyer->mRowObj->PDF)) {
			CFileManager::download($flyer->mRowObj->PDF);
			$this->redirect("index.php");
		} else {
			$this->redirect(APP_SERVER_NAME."/index.php?n=Flyers&o=main");
		}
		
	}


	/** comment here */
	function displayNewsletter() {
	 $this->mDocument->mPageTemplate = "templates/flyer.html";
        $this->resetTemplate("templates/newsletter.html");
	  Return $this->flushTemplate() ;
		
	}

	  /** comment here */
	function mainSwitch()
    {
		switch($this->mOperation) {
            case "":
            case "main":
                return $this->display($_GET["id"]);
	         case "categories":
                return $this->displayCategories($_GET["id"]);
	         case "brands":
                return $this->displayBrands($_GET["id"]);
	         case "cart":
                return $this->displayShoppingList();
	         case "all_pages":
                return $this->displayAllPages();
	         case "facing":
                return $this->displayFacing();
	         case "print":
                return $this->printList();
	         case "help": return $this->displayHelp();
	         case "print-all": return $this->displayPrint();
	         case "download_flyer": return $this->download();
	         case "newsletter": return $this->displayNewsletter();
	         case "last-flyer": return $this->downloadLast();
		    default:
		      return CSectionManager::mainSwitch();
		}
	}


}

/** comment here */
function nl2brX($txt) {
	Return str_replace(array("\n", "\r"), array("<br>", ""), $txt);
}
?>