<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CStoreAdmin extends CSectionAdmin{

  /** comment here */
  function CStoreAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "CStore");
  }


  /** comment here */
  function display() {
    STitle::set("ManageStores");
	SAccess::enforce("manage_stores");
	$sql = "SELECT *  ".
			" FROM stores a WHERE 1=1 ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 10;
	$vSmart->setIcons(array("edit", "delete"));
//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("Document Type"));
	$vSmart->addField("Name");

//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add store"));
	$vSmart->mColsWidths = array("10px", "700px", "90px");
	$vSmart->mColsAligns = array("center", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_stores");
	  $this->nav($pItemID, "edit", "stores");
	$vUser = new CStore($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_stores");
	$vUser = new CStore($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_stores");
	  $vUser = new CStore($pUserID);
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