<?php

	class CHomeAdmin extends CSectionManager {

	  var $section = "Home";
	  var $parent = "";

	  /** comment here */
	  function CHomeAdmin() {
		$this->CSectionManager();
		$this->checkLogin();
	  }

	  function display() {
		 Return "Welcome to the admin interface";
		$sql = "select timestamp from user_logins where userid = '".$this->mUserID."' order by timestamp desc limit 5";
		$data = $this->mDatabase->getAll($sql);
		$txt = "<h5>Last 5 logins: </h5><p style='margin-left: 20px; line-height: 150%; font-family: verdana; color: #333; font-size: 12px;'>";
		foreach ($data as $key=>$val) {
			$txt .= date("F d, Y H:i", $val) . "<br>";
		}
		$txt .= "</p>";

		$sql = "select approved, filetype, count(*) as cnt from work_records where userid = '".$this->mUserID."' and year = ".date("Y")." and month = ".date("m")." and day = ".date("d")." group by approved, filetype";
		$data = $this->mDatabase->getAll($sql);
		$units = 0; $new = 0; $approved = 0; $updates = 0; $changes = 0;
		foreach ($data as $key=>$val) {
			if ($val["filetype"] == "new") $new += $val["cnt"];
			if ($val["filetype"] == "update") $updates += $val["cnt"];
			if ($val["approved"] == "yes") $approved += $val["cnt"];
			if ($val["approved"] == "no") $changes += $val["cnt"];
			$units += $val["cnt"];
		}
		$required = 100;
		if ($units <= $required) $color = "#ff0000"; else $color = "#00ff00";
		$txt .= "<h5>Work report: </h5>";
		$txt .= "<p style='margin-left: 20px; line-height: 150%; font-family: verdana; color: #333; font-size: 12px;'><span style='color: $color'>$units processed today ($required required)</span><br>";
		$txt .= "$new new files processed today <br>";
		$txt .= "$updates files updated today <br>";
		$txt .= "$approved changes approved today <br>";
		$txt .= "$changes changes rejected today <br>";
		$txt .= "</p>";

		Return $txt;
	  }


	  /** comment here */
	  function setMenuItems() {
		$this->mMenuItems = array();
		$this->mMenuItems["users & access"]["access"] = 1;
		$this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("Home") . "main", "Home", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("Users") . "main", "Manage Users", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("UserGroups") . "main", "Manage User Groups", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["users & access"]["items"][] = array($this->getBaseLink("Users") . "special", "Manage Email Notifications", 1);

		$this->mMenuItems["Projects"]["access"] = 1;
		if (SAccess::check("manage_users")) $this->mMenuItems["Projects"]["items"][] = array($this->getBaseLink("Projects") . "main", "Manage Projects", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["Projects"]["items"][] = array($this->getBaseLink("Brands") . "main", "Manage Brands", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["Projects"]["items"][] = array($this->getBaseLink("Offices") . "main", "Manage Offices", 1);
		if (SAccess::check("manage_users")) $this->mMenuItems["Projects"]["items"][] = array($this->getBaseLink("RSSs") . "main", "Manage RSS", 1);
//		if (SAccess::check("manage_users")) $this->mMenuItems["metadata"]["items"][] = array($this->getBaseLink("UserGroups") . "main", "Manage User Groups", 1);

//		$this->mMenuItems["site management"]["access"] = 1;
//		if ($this->checkRight("viewpages")) $this->mMenuItems["site management"]["items"][] = array($this->getBaseLink("Pages") . "main", "Manage Pages", 1);
//		if ($this->checkRight("viewpages")) $this->mMenuItems["site management"]["items"][] = array($this->getBaseLink("Help") . "main", "Manage Help Entries", 1);
//		if ($this->checkRight("viewpages")) $this->mMenuItems["site management"]["items"][] = array($this->getBaseLink("Faq") . "main", "Manage Tooltips", 1);
//
//		$this->mMenuItems["files management"]["access"] = 3;
//		if ($this->checkRight("viewfiles")) $this->mMenuItems["files management"]["items"][] = array($this->getBaseLink("Files") . "main", "Manage Files", 1);
//		if ($this->checkRight("queue")) $this->mMenuItems["files management"]["items"][] = array($this->getBaseLink("Files") . "queue", "My Files Queue", 1);
//
//		$this->mMenuItems["orders & payments"]["access"] = 1;
//		if ($this->checkRight("vieworders")) $this->mMenuItems["orders & payments"]["items"][] = array($this->getBaseLink("Orders") . "main", "View Orders", 1);
//		if ($this->checkRight("viewlinks")) $this->mMenuItems["orders & payments"]["items"][] = array($this->getBaseLink("Orders") . "files", "File Links", 1);
//		if ($this->checkRight("viewpayouts")) $this->mMenuItems["orders & payments"]["items"][] = array($this->getBaseLink("Payouts") . "main", "Payout Requests", 1);
//
//		$this->mMenuItems["reports & statistics"]["access"] = 1;
//		if ($this->checkRight("viewperformancereports")) $this->mMenuItems["reports & statistics"]["items"][] = array($this->getBaseLink("Reports") . "files", "Report Interface", 1);
////		if ($this->checkRight("viewsalesreports")) $this->mMenuItems["reports & statistics"]["items"][] = array($this->getBaseLink("Home") . "main", "Sales Reports", 1);
////		if ($this->checkRight("viewactivityreports")) $this->mMenuItems["reports & statistics"]["items"][] = array($this->getBaseLink("Home") . "main", "User Reports", 1);
//
//		$this->mMenuItems["comments & enquiries"]["access"] = 1;
//		if ($this->checkRight("viewcomments")) $this->mMenuItems["comments & enquiries"]["items"][] = array($this->getBaseLink("Comments") . "main", "User comments", 1);


	  }

	  /** comment here */
	  function displaySiteMenu() {

		  $this->setMenuItems();
//		  if (!$this->mUserID && INI_ADMIN_REQUIRES_LOGIN == "yes") Return "";
		  $style="style=\"background-color: #fff; color: #666666; padding: 3px 2px 3px 0px; font-weight: bold ; font-size: 11px; text-align: left;\"";
		  $style1="style=\"background-color: #fff; color: #666666; padding: 3px 2px 3px 12px; cursor: pointer;font-size: 11px; text-align: left;\"";

		  $txt = "<table cellpadding=0 cellspacing=0 border=0 width=160>";
		  foreach ($this->mMenuItems as $key=>$val) {
//			if (!$this->checkRight($val["access"])) continue;
			if (empty($val["items"])) continue;
			$txt .= "<tr><td ".$style.">$key</td></tr>";
			foreach ($val["items"] as $key=>$val) {
//			  if ($this->checkRight($val[2])) {
				$vHref = new CHref($val[0], $val[1]);//$vHref->setClass("admin_menu");
				$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#dddddd';this.style.color='#000000';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='".$val[0]."';\">".$val[1]."</td></tr>";
//			  }
			}
		  }
			$txt .= "<tr><td ".$style.">Miscellaneous</td></tr>";
				$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#dddddd';this.style.color='#000000';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='index2.php?n=Users&o=logout';\">logout</td></tr>";
				$txt .= "<tr><td $style1 onmouseover=\"this.style.backgroundColor='#dddddd';this.style.color='#000000';\" onmouseout=\"this.style.backgroundColor='#ffffff'; this.style.color='#666666';\" onclick=\"window.location='index.php';\">".APP_SITE_NAME."</td></tr>";
		  $txt .= "</table>";
		  Return $txt;
	  }


	  function displayMenu($pTitle = "", $pItems = array()) {
			Return $this->displaySiteMenu();
	  }

	  /** comment here */
	  function registerClasses() {
		$this->mClasses[] = array("events", "CEvent");
	  }

	  /** comment here */
	  function mainSwitch() {
		switch($this->mOperation) {
			case "brand": Return "brand";
		default:
		  Return CSectionManager::mainSwitch();
		}
	  }
	}

?>