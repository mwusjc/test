<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CPositionAdmin extends CSectionAdmin{

  /** comment here */
  function CPositionAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "CPosition");
  }


  /** comment here */
  function display() {
    STitle::set("Manage Applications");
	SAccess::enforce("manage_jobs");
	$sql = "SELECT a.*, b.Name as Store, c.Name as Position ".
			" FROM applications a, stores b, jobs c WHERE a.storeid = b.id  and a.positionid = c.id".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("applications", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 20;
	$vSmart->mDefaultOrderDir = "DESC";
	$vSmart->setIcons(array("view", "delete"));
//	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
//	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("Store", "Position", "Name", "Date"));
	$vSmart->addField("Store");
	$vSmart->addField("Position");
	$vSmart->addField("Name");
	$vSmart->addDField("TimeStamp");

//	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
//	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

//	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Add job"));
	$vSmart->mColsWidths = array("10px", "200px","200px", "200px", "110px", "90px");
	$vSmart->mColsAligns = array("center", "left", "left", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayItem($id) {
	$app = new CPosition($id);
	Return $app->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	SAccess::enforce("manage_jobs");
	  $this->nav($pItemID, "edit", "jobs");
	$vUser = new CPosition($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_jobs");
	$vUser = new CPosition($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("manage_jobs");
	  $vUser = new CPosition($pUserID);
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