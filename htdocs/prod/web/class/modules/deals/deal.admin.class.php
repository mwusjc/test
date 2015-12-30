<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CDealAdmin extends CSectionAdmin{

  /** comment here */
  function CDealAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Products", "CDeal");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Products");
	SAccess::enforce("manage_products");
	$sql = "SELECT *  ".
			" FROM products a WHERE 1=1 ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 30;
	$vSmart->setIcons(array("edit", "delete"));
	$vSmart->mDefaultOrder = "ID";
	$vSmart->mDefaultOrderDir = "Desc";
//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("Document Type"));
	$vSmart->addField("Name");

//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add product"));
	$vSmart->mColsWidths = array("10px", "700px", "90px");
	$vSmart->mColsAligns = array("center", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_products");
	  $this->nav($pItemID, "edit", "products");
	$vUser = new CDeal($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_products");
	$vUser = new CDeal($pItemID);
	$vUser->save();
	$this->redirect($this->getBaseLink() . "edit");
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_products");
	  $vUser = new CDeal($pUserID);
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