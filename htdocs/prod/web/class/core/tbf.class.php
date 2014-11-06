<?php
  class CTBF extends CDocument
  {
	/** comment here */
	function CTBF() {
	  $this->CDocument();
	}

	/** comment here */
	function construct() {
		$this->mPageTemplate = "templates/main.html";
//		if ($_GET["test"] ==1) ;$this->mPageTemplate = "templates/main-xmas.html";
//  	  if ($_GET["print"] == "yes") $this->mPageTemplate = "templates/print.html";
//		if ($_GET["print"] == "yes")   $this->mHead->addCss("css/print.css"); else   $this->mHead->addCss("css/aspen.css");


	  $this->mHead->addScript(new CScript("", "js/main.js"));
	  $this->mHead->addScript(new CScript("", "js/fsmenu.js"));
	  $this->mHead->addScript(new CScript("", "http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"));
	  $this->mHead->addScript(new CScript("", "/plugins/galleria/galleria-1.2.9.min.js"));
	  $this->mHead->addCss("/plugins/shadowbox/shadowbox.css");
	  $this->mHead->addScript(new CScript("", "/plugins/shadowbox/shadowbox.js"));

	  $this->mHead->addScript(new CScript("", "js/tools/alerts.js"));

	  $this->mHead->addCss("css/sizes.css");
	  $this->mHead->addCss("css/hf.css");

	}

	/** comment here */
	function displayMenu() {
		$this->setPiece("BANNERS", $this->displayBanner());
		$tpl = new TemplatePower("templates/menu.html");
		$tpl->prepare();
		$txt = "";
		$menus = array();
			$menus["about"] = array("about", "About");
			$menus["prodcat"] = array("inside", "Inside the Store");
			$menus["recipes"] = array("fresh", "Recipes");
			$menus["platters"] = array("party", "Party Platters & More");
			$menus["private_labels"] = array("ck", "Country Kitchen");
			$menus["careers"] = array("jobs", "Jobs");
			foreach ($menus as $key=>$val) {
				if ($key == $_GET["o"])  $txt .= '<img src="images/mbttn_'.$val[0].'_dwn.gif" alt="'.$val[1].'" name="mbttn'.$key.'" border="0" id="mbttn'.$key.'"/></a>';
				else $txt .= '<a href="index.php?n=Main&o='.$key.'"><img src="images/mbttn_'.$val[0].'_up.gif" alt="'.$val[1].'" name="mbttn'.$key.'" border="0" id="mbttn'.$key.'" onmouseover="MM_swapImage(\'mbttn'.$key.'\',\'\',\'images/mbttn_'.$val[0].'_over.gif\',1)" onmouseout="MM_swapImgRestore()" /></a>';
			}
		$tpl->assign("Menu", $txt);
		Return $tpl->getOutputContent();
	}


	/** comment here */
	function displaySiteMenu() {
	}

	/** comment here */
	function getMenu() {
	}

	/** comment here */
	function displayBanner() {
		$tpl = new TemplatePower("templates/banners.html");
		$tpl->prepare();
		$activeflyer = $this->mDatabase->getRow("select * from flyers where Status = 'enabled' order by id desc limit 1");
//		die2($activeflyer);
		$tpl->assign("EffectiveDate", date("D., M. jS", $activeflyer["Week"]) . " <br>to " . date("D., M. jS", $activeflyer["WeekEnds"]));
		Return $tpl->getOutputContent();
	}

	/** comment here */
	function displayBottomBanners() {
		if (!$_GET["o"]) {
		$tpl = new TemplatePower("templates/banners_bottom.html");
		$tpl->prepare();
		$this->mTags["LAYOUT_BOTTOM_BANNERS"] =  $tpl->getOutputContent();
		} else $this->mTags["LAYOUT_BOTTOM_BANNERS"] =  "";
	}


	/** comment here */
	function displayFooter() {
		$tpl = new TemplatePower("templates/footer.html");
		$tpl->prepare();
		Return $tpl->getOutputContent();
	}

	/** comment here */
	function displayCopyright() {
	  Return "Copyright here";
	}

	/** comment here */
	function displayNavigation() {
	}

	/** comment here */
	function customPieces() {
	}

  /** comment here */
  function setSectionTitle($pImage) {
  }




}


?>