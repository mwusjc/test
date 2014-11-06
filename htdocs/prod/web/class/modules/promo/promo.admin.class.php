<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CPromoAdmin extends CSectionAdmin{

  /** comment here */
  function CPromoAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Promos", "CPromo");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Promos");
	SAccess::enforce("manage_brands");
	$sql = "SELECT *  ".
			" FROM flyers a WHERE 1=1 ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 10;
	$vSmart->mDefaultOrder = "ID";
	$vSmart->mDefaultOrderDir = "DESC";
	$vSmart->setIcons(array("edit", "delete"));

	$vSmart->addHeader(array("Week"));
	$vSmart->addDField("Week", "F d, Y");

//	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Upload Images"));
	$vSmart->mColsWidths = array("10px", "700px", "90px");
	$vSmart->mColsAligns = array("center", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_brands");
	  $this->nav($pItemID, "edit", "brands");
	$vUser = new CPromo($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_brands");
	$vUser = new CPromo($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_brands");
	  $vUser = new CPromo($pUserID);
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