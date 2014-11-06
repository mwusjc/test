<?php   

	class CHomeAdmin extends CSectionManager {

	  var $section = "Home";
	  var $parent = "";

	  /** comment here */
	  function CHomeManager() {
		$this->CSectionManager();
	  }

	  function display() {
		return "as";
	  }


	  /** comment here */
	  function setMenuItems() {
		$this->mMenuItems = array();
		$this->mMenuItems["Site Pages & Messages"]["access"] = 1;
		$this->mMenuItems["Site Pages & Messages"]["items"][] = array($this->getBaseLink("Home") . "schedule", "Manage Schedule", 1);
//		$this->mMenuItems["Site Pages & Messages"]["items"][] = array($this->getBaseLink("Users") . "bookings", "View bookings", 1);
//		$this->mMenuItems["Site Pages & Messages"]["items"][] = array($this->getBaseLink("Home") . "slots", "Customize Time Slots", 1);
		$this->mMenuItems["Site Pages & Messages"]["items"][] = array($this->getBaseLink("Pages") . "main", "Manage Emails & Texts", 1);

	  }

	  /** comment here */
	  function displaySiteMenu() {

		  $this->setMenuItems();
//		  if (!$this->mUserID && INI_ADMIN_REQUIRES_LOGIN == "yes") Return "";

		  $style="style=\"background-color: #fafafa; color: #989da5; padding: 1px 2px 1px 12px; border-bottom: 1px solid #f0f0f0;\"";
		  $style3="style=\"border: 1px solid #fff; background-color: #666600; font-size: 8pt; color: #fff; padding: 2px 2px; font-weight: bold;\"";
		  $style2="style=\"border: 1px solid #bbb;background-color: #888; font-size: 8pt; color: #fff; padding: 2px 2px; font-weight: bold;\"";
		  $style1="style=\"border: 1px solid #810114;background-color: #CC3300; font-size: 8pt; color: #fff; padding: 2px 2px; font-weight: bold;\"";
		  $style0="style=\"border: 1px solid #000000;background-color: #333333; font-size: 8pt; color: #fff; padding: 2px 2px; font-weight: bold;\"";
		  
		  $txt = "<table cellpadding=0 cellspacing=0 border=0 width=224>";
		  foreach ($this->mMenuItems as $key=>$val) {
//			if (!$this->checkRight($val["access"])) continue;
			$stylex = "style" . $val["access"];
			$txt .= "<tr><td ".$$stylex.">$key</td></tr>";
			foreach ($val["items"] as $key=>$val) {
//			  if ($this->checkRight($val[2])) {
				$vHref = new CHref($val[0], $val[1]);$vHref->loadTemplate("admin_menu");
				$txt .= "<tr><td $style>".$vHref->display()."</td></tr>";
//			  }
			}
		  }
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