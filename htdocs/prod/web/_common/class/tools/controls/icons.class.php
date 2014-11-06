<?php   

	class CIcons extends CObject{

		var $mIcons = array();
		var $mSelected = array();
		var $mExtraParam = "";

		function CIcons($pIcons = array()) {
		  $this->CObject();

		  $imgs = array();
		  $imgs["edit"] = array("edit&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/contract.png\" border=\"0\">", "Edit");
		  $imgs["edit_deal"] = array("edit_deal&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/contract.png\" border=\"0\">", "Edit Deal");
		  $imgs["view"] = array("view&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/news_view.png\" border=\"0\">", "Preview");
		  $imgs["view_deal"] = array("view_deal&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/news_view.png\" border=\"0\">", "Preview");
		  $imgs["assign"] = array("assign&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/icon-edit.png\" border=\"0\">", "Complete Order");
		  $imgs["review"] = array("edit&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/icon-view.png\" border=\"0\">", "Review Complaint");
		  $imgs["on"] = array("toggle&type=off&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/document.png\" border=\"0\">", "Enabled", "Click to disable");
		  $imgs["off"] = array("toggle&type=on&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/document_dirty.png\" border=\"0\">", "Disabled", "Click to enable");
		  $imgs["delete"] = array("delete&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/delete2.png\" border=\"0\">", "Delete");
		  $imgs["up"] = array("move&type=up&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/arrow_up_blue.png\" border=\"0\">", "Move Up");
		  $imgs["down"] = array("move&type=down&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/arrow_down_blue.png\" border=\"0\">", "Move Down");
		  $imgs["archive"] = array("archive&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/icon-close.png\" border=\"0\">", "Archived");
		  $imgs["approve"] = array("approve&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/star_blue.png\" border=\"0\">", "Approve");
		  $imgs["pwd"] = array("change_pass&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/icon-reset_pass.png\" border=\"0\">", "Change Password");
		  $imgs["usr"] = array("edit_rights&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/star_blue.png\" border=\"0\">", "Assign User Rights");
		  $imgs["list"] = array("list&id=##ID##", "<img align=\"middle\" src=\"_common/images/common/small/window_view.png\" border=\"0\">", "View Elements");
		  $this->mIcons = $imgs;
		  $this->addMoreIcons();
		  $this->mSelected = $pIcons;
		}

		/** comment here */
		function addMoreIcons() {
		  $imgs = array();
		  $this->mIcons["faq"] = array("change&type=faq&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/about.png\" border=\"0\">", "Save as F.A.Q. Question");
		  $this->mIcons["testimonial"] = array("change&type=testimonial&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/address_book.png\" border=\"0\">", "Save as Testimonial Entry");
		  $this->mIcons["mail"] = array("contact&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/mail.png\" border=\"0\">", "Contact Owner");
		  $this->mIcons["book"] = array("contact&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/user1_add.png\" border=\"0\">", "Book this group");
		  $this->mIcons["spot"] = array("spotlight&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/star_blue.png\" border=\"0\">", "Add HOT DEAL");
		  $this->mIcons["apps"] = array("view_apointments&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/alarmclock.png\" border=\"0\">", "View Appointments");
		  $this->mIcons["slots"] = array("view_slots&id=##ID##", "<img  align=\"middle\" src=\"_common/images/common/small/clock.png\" border=\"0\">", "View Time Slots");
		}

  		function getIcons($pIcons = array()) {
		  if ($pIcons) $this->mSelected = $pIcons;
		  $ret = array();
		  foreach ($this->mSelected as $key2=>$val2) {
			$val = $this->mIcons[$val2];
			$url = $this->getBaseLink($this->mSection) . $val[0];
			if ($this->mExtraParam) $url .= "&". $this->mExtraParam;
			$vHref = new CHref($url, $val[1]);
			$vHref->mTitle = $val[2];
			$ret[$val2] = $vHref;
		  }
		  Return $ret;
		}

		/** comment here */
		function displayIcons($pIcons = array()) {
		  if ($pIcons) $this->mSelected = $pIcons;
		  $rows = array();
		  foreach ($this->mSelected as $key2=>$val2) {
			$val = $this->mIcons[$val2];
			$url = $GLOBALS["vSiteManager"]->getBaseLink($GLOBALS["vUrlManager"]->mSection) . $val[0];
			if ($this->mExtraParam) $url .= "&". $this->mExtraParam;
			$vHref = new CHref($url, $val[1]);

			$vHref->mTitle = $val[2];
			$rows[] = $vHref->display();
		  }
		  Return $rows;
		}

		function getIcon($pIcon) {
		  $icon = $this->mIcons[$pIcon];
		  $url = $this->getBaseLink($this->mSection) . $icon[0];
		  if ($this->mExtraParam) $url .= "&". $this->mExtraParam;
		  $vHref = new CHref($url, $icon[1]);
		  $vHref->mTitle = $icon[2];
		  Return $vHref;
		}

		function displayLegend($pIcons = array()) {
		  if ($pIcons) $this->mSelected = $pIcons;
		  $txt = "";
		  foreach ($this->mSelected as $key2=>$val2) {
			$val = $this->mIcons[$val2];
		  	$txt.= "$val[1]&nbsp;$val[2]&nbsp;&nbsp;&nbsp;&nbsp;";
		  }
		  Return $txt;
		}

	}

?>