<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CMessageAdmin extends CSectionAdmin{

  /** comment here */
  function CMessageAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Pages", "CMessage");
  }


  /** comment here */
  function display() {
	STitle::set("managetexts");
	SAccess::enforce("viewpages");

	$sql = "SELECT * from cms_messages a Where 1=1  ##CRITERIA##";
	$vSmart = new CSmartTable("cms_messages", $sql);
	$vSmart->mItemsPerPage = 20;
	$vSmart->setIcons(array("edit", "view"));
	$vSmart->addHeader(array("Title", "Subject", "Type"));
	$vSmart->addField("Title");
	$vSmart->addField("Subject");
	$vSmart->addField("ContentType");
	$vSmart->mShowToggle = false;
	$vSmart->addCompositeFilter("Content", "a.Txt, a.Title, a.Subject", "Search", 1, "input_search size400");
	$vSmart->addLFilter("a.ContentType", "Page type", array(array("cms","site pages"), array("email","email")), 1);
//	$vSmart->addSField("<input style=\"font-size:8pt; border: 1px dotted #ccc\" type=\"text\" value=\"http://" . APP_DOMAIN . "/index.php?name=Pages&op=show&id=##ID##\" style=\"width:330px;\" id=\"asdad\" name=\"asdgf\">");
	//$vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Create new page"));
	$vSmart->mColsAligns = array("10px","700px", "100px");
	$vSmart->setTemplate("admin");

	Return $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	STitle::set("editpage");
	SAccess::enforce("editpage");

	$label = "Pages ::: ";
	if ($pItemID) $label .= "Edit page"; else $label .= "Create new page";
	$this->setTitle($label);
	$vPage = new CMessage($pItemID);
	$vPage->unregisterForm();
	Return $vPage->displayEdit();
  }

  /** comment here */
  function displaySave($pItemID) {
	$vPage = new CMessage($pItemID);
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
