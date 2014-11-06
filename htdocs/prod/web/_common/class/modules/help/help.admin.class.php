<?php   
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CHelpAdmin extends CSectionAdmin{

  /** comment here */
  function CHelpAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Pages", "CHelp");
  }


  /** comment here */
  function display() {
	STitle::set("managehelpentries");
	SAccess::enforce("viewpages");

	$sql = "SELECT * from cms_help_sections a Where 1=1  ##CRITERIA##";
	$vSmart = new CSmartTable("cms_pages", $sql);
	$vSmart->mItemsPerPage = 40;
	$vSmart->setIcons(array("edit", "view"));
	$vSmart->addHeader(array("Title", "Page"));
	$vSmart->addField("Name");
	$vSmart->addField("Page");
	$vSmart->mShowToggle = false;
	$vSmart->addCompositeFilter("Content", "a.Content, a.Name, a.Page", "Search", 1, "input_search size400");
//	$vSmart->addLFilter("a.Section", "Section", $this->mDatabase->getAll2("select id, name from cms_help_main"), 1);
//	$vSmart->addSField("<input style=\"font-size:8pt; border: 1px dotted #ccc\" type=\"text\" value=\"http://" . APP_DOMAIN . "/index.php?name=Pages&op=show&id=##ID##\" style=\"width:330px;\" id=\"asdad\" name=\"asdgf\">");
	//$vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Create new page"));
	$vSmart->mColsWidths = array("10px","400px", "200px", "100px");
	$vSmart->mColsAligns = array("left","left", "center", "right");
	$vSmart->setTemplate("admin");


	Return $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	STitle::set("edithelpentry");
	SAccess::enforce("editpage");

	$label = "Pages ::: ";
	if ($pItemID) $label .= "Edit page"; else $label .= "Create new page";
	$this->setTitle($label);
	$vPage = new CHelp($pItemID);
	$vPage->unregisterForm();
	Return $vPage->displayEdit();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("editpage");

	$vPage = new CHelp($pItemID);
	$vPage->save();
	$this->redirect($this->getStdLink());
  }


/***********************************************************************************************************
****	  END OF TEMPLATE FUNCTIONS - CONTINUE WITH SPECIAL FUNCTIONS									****
***********************************************************************************************************/


  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
		default:
		  Return CSectionAdmin::mainSwitch();
	}
  }
}

?>
