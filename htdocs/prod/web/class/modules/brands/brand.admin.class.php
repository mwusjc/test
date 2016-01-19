<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CBrandAdmin extends CSectionAdmin{

  /** comment here */
  function CBrandAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Brands", "CBrand");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Brands");
	SAccess::enforce("manage_brands");
	$sql = "SELECT *  ".
			" FROM brands a WHERE 1=1 ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 10;
	$vSmart->setIcons(array("edit", "delete"));

	$vSmart->addHeader(array("Brand Name"));
	$vSmart->addField("Name");

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add brand"));
	$vSmart->mColsWidths = array("10px", "700px", "90px");
	$vSmart->mColsAligns = array("center", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_brands");
	  $this->nav($pItemID, "edit", "brands");
	$vUser = new CBrand($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_brands");
	$vUser = new CBrand($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_brands");
	  $vUser = new CBrand($pUserID);
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