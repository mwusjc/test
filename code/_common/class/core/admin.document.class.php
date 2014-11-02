<?php

	class CAdminDocument extends CDocument {

	  var $mPageTemplate = "_common/templates/admin.html";
	  var $mCss =  "_common/css/admin.css";
	  var $mMenuItems = array();

	  function CAdminDocument() {
		  $this->CDocument();
		  $this->mAdminMode = true;
	  	  $this->mHead->addCss("_common/css/style.css");
	  	  $this->mHead->addCss("_common/css/admin.css");
	  	  $this->mHead->addCss("css/coupons.css");
//	  	  $this->mHead->addScript(new CScript("", "_common/scripts/ajax.js"));
	  }

	  /** comment here */
	  function loadModules() {
		foreach ($GLOBALS["modules"] as $key=>$val) {
		  $this->mModules[$key] = $val[1];
		}
	  }


	  function displayError() {
		$error = $this->mErrorObj->popError();
		if (!empty($error)) {
			if ($error[1] == 3) Return "<script>showAlert('info', '','".addslashes($error[0])."', 0, btClose);</script>";
			if ($error[1] == 2) Return "<script>showAlert('error', '','".addslashes($error[0])."', 0, btClose);</script>";
			if ($error[1] == 1) Return "<script>showAlert('alert', '','".addslashes($error[0])."', 0, btClose);</script>";
			if ($error[1] == 4) Return "<script>showAlert('alert', '','".addslashes($error[0])."', 0, btClose);</script>";
		}
	  }

	  /** comment here */
	  function customPieces() {
//	  	$this->setPiece("MENU", $this->displaySiteMenu());
	  	$this->setPiece("MENU_TITLE", "Control Panel");
	  	$this->setPiece("DATE", date("l, F d, Y H:i"));
	  	if (!isset($this->mTags["LAYOUT_SECTION_TITLE"])) $this->setPiece("SECTION_TITLE", "Control Panel");
		if (!isset($this->mTags["LAYOUT_SITENAME"])) $this->mTags["LAYOUT_SITENAME"] = APP_SITE_NAME;
		if (!isset($this->mTags["LAYOUT_FILTERS"])) $this->mTags["LAYOUT_FILTERS"] = "";
		$this->mTags["LAYOUT_LOGO"] = "<center><div><img src='images/admin_logo2.gif' border='0'></div></center>";
		if (!isset($this->mTags["LAYOUT_TOP"])) $this->mTags["LAYOUT_TOP"] = ""; else {
			$this->mTags["LAYOUT_TOP"] =  '<div style="padding: 0px 2px 11px;  margin-bottom: 7px; border-bottom: 1px solid #ddd;  ">'.$this->mTags["LAYOUT_TOP"] .'</div>';
		}

	  }

		/** comment here */
		function getBaseLink($pSection = "") {
		  $index = "index.php"; if ($this->mAdminMode) $index = "index2.php";
		  if (!$pSection) $pSection = $this->mSection;
		  $url = "$index?n=" . $pSection . "&o=";
		  if ($this->mFullLinksMode) $url = APP_SERVER_NAME . "/".$url;
		  Return $url;
		}


	  /** comment here */
	  function setMenuItems() {
		$this->mMenuItems = array();
		$this->mMenuItems["users & access"]["access"] = 1;
		if (SAccess::check("manage_users")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("Users") . "main", "Users", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("UserGroups") . "main", "User Groups", 1);
//		if (SAccess::check("staff")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("StaffDocuments") . "main", "Documents Repository", 1);

		$this->mMenuItems["Weekly Flyers"]["access"] = 1;
		if (SAccess::check("manage_flyers")) $this->mMenuItems["Weekly Flyers"]["items"][] = array($this->getBaseLink("Flyers") . "main", "Manage Flyers", 1);
		if (SAccess::check("manage_flyers")) $this->mMenuItems["Weekly Flyers"]["items"][] = array($this->getBaseLink("Promos") . "main", "Manage Home page images", 1);
		if (SAccess::check("manage_flyers")) $this->mMenuItems["Weekly Flyers"]["items"][] = array($this->getBaseLink("Brands") . "main", "Manage Brands", 1);
		if (SAccess::check("manage_flyers")) $this->mMenuItems["Weekly Flyers"]["items"][] = array($this->getBaseLink("Categories") . "main", "Manage Categories", 1);
		if (SAccess::check("manage_flyers")) $this->mMenuItems["Weekly Flyers"]["items"][] = array($this->getBaseLink("Products") . "main", "Manage Products", 1);


		$this->mMenuItems["Highland Farms Content"]["access"] = 1;
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Stores") . "main", "Manage Stores", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Recipes") . "main", "Manage Recipes", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Platters") . "main", "Manage Platters", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Orders") . "main", "Manage Orders", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("PrivateLabel") . "main", "Manage Private Labels", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Jobs") . "main", "Manage Jobs", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Highland Farms"]["items"][] = array($this->getBaseLink("Applications") . "main", "View Applications", 1);

		$this->mMenuItems["Site Content"]["access"] = 1;
		if (SAccess::check("manage_content")) $this->mMenuItems["Site Content"]["items"][] = array($this->getBaseLink("Pages") . "main", "Site Pages", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Site Content"]["items"][] = array($this->getBaseLink("Emails") . "main", "Email Notifications", 1);
		if (SAccess::check("manage_content")) $this->mMenuItems["Site Content"]["items"][] = array($this->getBaseLink("Messages") . "main", "Messages & Alerts", 1);

		$this->mMenuItems["Feedback"]["access"] = 1;
//		if (SAccess::check("manage_user_feedback")) $this->mMenuItems["Feedback"]["items"][] = array($this->getBaseLink("Registrations") . "main", "Registrations", 1);
		if (SAccess::check("manage_user_feedback")) $this->mMenuItems["Feedback"]["items"][] = array($this->getBaseLink("Comments") . "main", "User Feedback", 1);



	  }

	  /** comment here */
	  function displaySiteMenu() {

			$this->setMenuItems();
			$style="style=\"background-color: #6C9C31; color: #fff; padding: 3px 2px 3px 3px; font-weight: bold ; font-size: 11px; text-align: left;\"";
			$style1="style=\"background-color: #fff; color: #666666; padding: 3px 2px 3px 12px; cursor: pointer;font-size: 11px; text-align: left;\"";

			$txt = "<table cellpadding=0 cellspacing=0 border=0 width=160 style='padding-top: 0px; background-color: #fff; border-bottom: 1px solid  #b8de82 '>";
			foreach ($this->mMenuItems as $key=>$val) {
				if (empty($val["items"])) continue;
				$txt .= "<tr><td ".$style.">$key</td></tr>";
				foreach ($val["items"] as $key=>$val) {
					$vHref = new CHref($val[0], $val[1]);
					$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#b8de82';this.style.color='#ffffff';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='".$val[0]."';\">".$val[1]."</td></tr>";
				}
			}
			$txt .= "<tr><td ".$style.">Miscellaneous</td></tr>";
				$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#b8de82';this.style.color='#ffffff';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='index2.php?n=Users&o=logout';\">logout</td></tr>";
				$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#b8de82';this.style.color='#ffffff';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='index.php';\">".APP_SITE_NAME."</td></tr>";
			$txt .= "</table>";
			Return $txt;
	  }


	  function displayMenu($pTitle = "", $pItems = array()) {
			Return $this->displaySiteMenu();
	  }

}

?>