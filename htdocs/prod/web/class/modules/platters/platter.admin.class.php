<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CPlatterAdmin extends CSectionAdmin{

  /** comment here */
  function CPlatterAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "CPlatter");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Platters");
	SAccess::enforce("manage_platters");
	$sql = "SELECT a.*, b.Name as Category  ".
			" FROM platters a, platter_categories b WHERE 1=1 and a.CategoryID = b.ID ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = true;
	$vSmart->mItemsPerPage = 20;
	$vSmart->setIcons(array("edit", "delete"));
//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("Category", "Name"));
	$vSmart->addField("Category");
	$vSmart->addField("Name");

//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add platter"));
	$vSmart->mColsWidths = array("10px", "10px", "300px","400px", "90px");
	$vSmart->mColsAligns = array("center", "center", "left", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_platters");
	  $this->nav($pItemID, "edit", "platters");
	$vUser = new CPlatter($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_platters");
	$vUser = new CPlatter($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_platters");
	  $vUser = new CPlatter($pUserID);
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