<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class COrderAdmin extends CSectionAdmin{

  /** comment here */
  function COrderAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "COrder");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Orders");
	SAccess::enforce("manage_orders");
	$sql = "SELECT * FROM orders a WHERE 1=1 ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 10;
	$vSmart->setIcons(array("view", "delete"));
//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("Date", "Name", "Email", "Amount"));
	$vSmart->addDField("TimeStamp");
	$vSmart->addField("Name");
	$vSmart->addField("Email");
	$vSmart->addFuncField($this, "getTotal");

//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

//	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add platter"));
	$vSmart->mColsWidths = array("10px", "150px", "180px", "200px", "100px", "90px");
	$vSmart->mColsAligns = array("center", "left", "left", "left", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function getTotal($data) {
	$total = 0;
	$plCart = unserialize($data["OrderData"]);
	foreach ($plCart as $key=>$val) {
		$total += $val[3] * $val[1];
	}
	Return '$' . number_format($total, 2);
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_orders");
	  $this->nav($pItemID, "edit", "orders");
	$vUser = new COrder($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_orders");
	$vUser = new COrder($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

/** comment here */
function displayItem($id) {
	SAccess::enforce("manage_orders");
	$vUser = new COrder($id);
	Return $vUser->display();
}


  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_orders");
	  $vUser = new COrder($pUserID);
	  $vUser->delete();
	  $this->redirect($this->getBaseLink() . "main&id=$pID");
	}


  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
		default:
		  Return CSectionAdmin::mainSwitch();
	}
  }
}

?>