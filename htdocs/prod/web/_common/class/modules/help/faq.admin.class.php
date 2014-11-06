<?php   
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CFaqAdmin extends CSectionAdmin{

  /** comment here */
  function CFaqAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Pages", "CFaq");
  }


  /** comment here */
  function display() {
	STitle::set("managetooltips");
	SAccess::enforce("viewpages");

	$sql = "SELECT * from cms_help_entries a Where 1=1  ##CRITERIA##";
	$vSmart = new CSmartTable("cms_pages", $sql);
	$vSmart->mItemsPerPage = 40;
	$vSmart->setIcons(array("edit", "view"));
	$vSmart->addHeader(array("Title"));
	$vSmart->addField("Name");
	$vSmart->mOrderID = "a.OrderID";
	$vSmart->mShowToggle = false;
	$vSmart->addCompositeFilter("Content", "a.Content, a.Name", "Search", 1, "input_search size400");
//	$vSmart->addSField("<input style=\"font-size:8pt; border: 1px dotted #ccc\" type=\"text\" value=\"http://" . APP_DOMAIN . "/index.php?name=Pages&op=show&id=##ID##\" style=\"width:330px;\" id=\"asdad\" name=\"asdgf\">");
	//$vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Create new page"));
	$vSmart->mColsWidths = array("10px","700px", "100px");
	$vSmart->mColsAligns = array("left","left", "right");
	$vSmart->setTemplate("admin");


	Return $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	STitle::set("edittooltip");
	SAccess::enforce("editpage");

	$label = "Pages ::: ";
	if ($pItemID) $label .= "Edit page"; else $label .= "Create new page";
	$this->setTitle($label);
	$vPage = new CFaq($pItemID);
	$vPage->unregisterForm();
	Return $vPage->displayEdit();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("editpage");
	$vPage = new CFaq($pItemID);
	$vPage->save();
	$this->redirect($this->getStdLink());
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
