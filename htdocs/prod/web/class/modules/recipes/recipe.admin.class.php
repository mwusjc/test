<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CRecipeAdmin extends CSectionAdmin{

  /** comment here */
  function CRecipeAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "CRecipe");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Recipes");
	SAccess::enforce("manage_recipes");
	$sql = "SELECT a.*, b.Name as Category  ".
			" FROM recipes a, recipes_categories b WHERE 1=1 and a.CategoryID = b.ID ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = true;
	$vSmart->mItemsPerPage = 25;
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

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add recipe"));
	$vSmart->mColsWidths = array("10px", "10px", "200px", "500px", "90px");
	$vSmart->mColsAligns = array("center","center", "left", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_recipes");
	  $this->nav($pItemID, "edit", "recipes");
	$vUser = new CRecipe($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_recipes");
	$vUser = new CRecipe($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_recipes");
	  $vUser = new CRecipe($pUserID);
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