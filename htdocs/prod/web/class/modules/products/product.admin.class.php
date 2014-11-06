<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CProductAdmin extends CSectionAdmin{

  /** comment here */
  function CProductAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Products", "CProduct");
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
	$vUser = new CProduct($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_products");
	$vUser = new CProduct($pItemID);
	$vUser->save();
	$this->redirect($this->getBaseLink() . "edit");
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_products");
	  $vUser = new CProduct($pUserID);
	  $vUser->delete();
	  $this->redirect($this->getBaseLink() . "main&id=$pID");
	}

	/** comment here */
	function displayNewProducts() {
			STitle::set("Manage New Products");
			SAccess::enforce("manage_products");
			$sql = "SELECT ID, from_unixtime(Month, '%M %Y') as Month, Name ".
					" FROM new_products a WHERE 1=1 ".
					" ##CRITERIA## ";

			$vSmart = new CSmartTable("users", $sql);
			$vSmart->mShowToggle = false;
			$vSmart->mItemsPerPage = 30;
			$vSmart->setIcons(array("edit_new", "view_new", "delete_new"));
			$vSmart->mDefaultOrder = "Month";
			$vSmart->mDefaultOrderDir = "Desc";
		//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
		//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
		//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

			$vSmart->addHeader(array("Month", "Name"));
			$vSmart->addField("Month");
			$vSmart->addField("Name");

		//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
		//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
		//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

			$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit_new", "Add product"));
			$vSmart->mColsWidths = array("10px", "200px","400px", "90px");
			$vSmart->mColsAligns = array("center", "left","left", "right");
			$vSmart->setTemplate("admin");

			Return $this->displayError() . $vSmart->display();		
	}

  /** comment here */
  function displayEditProduct($pItemID = 0) {
	SAccess::enforce("manage_products");
	$this->nav($pItemID, "edit", "new_products");
	$vUser = new CProduct($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEditProduct();
	Return $this->flushTemplate();
  }


  /** comment here */
  function displayEditNew($pItemID = 0) {
	SAccess::enforce("manage_products");
	  $this->nav($pItemID, "edit", "new_products");
	$vUser = new CProductNew($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function saveNew($pItemID) {
	SAccess::enforce("manage_products");
	$vUser = new CProductNew($pItemID);
	$vUser->save();
	$this->redirect($this->getBaseLink() . "new_products");
  }

  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
		case "new_products":Return $this->displayNewProducts();
		case "edit_new":Return $this->displayEditNew();
		case "save_new":Return $this->saveNew();
		default:
		  Return CSectionAdmin::mainSwitch();
	}
  }
}

?>