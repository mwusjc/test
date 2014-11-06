<?php   
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CPageAdmin extends CSectionAdmin{
   
  /** comment here */
  function CPageAdmin() {
	$this->CSectionAdmin();  
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Pages", "CPage");
  }


  /** comment here */
  function display() {
	$sql = "SELECT * from cms_pages Where Type = 'page' order by TimeStamp DESC";
	$vSmart = new CSmartTable("cms_pages", $sql);
	$vSmart->mItemsPerPage = 20;
	$vSmart->setIcons(array("edit", "view"));
	$vSmart->addHeader(array("Title"));
	$vSmart->addField("Title");
	$vSmart->mShowToggle = false;
//	$vSmart->addSField("<input style=\"font-size:8pt; border: 1px dotted #ccc\" type=\"text\" value=\"http://" . APP_DOMAIN . "/index.php?name=Pages&op=show&id=##ID##\" style=\"width:330px;\" id=\"asdad\" name=\"asdgf\">");
	//$vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Create new page"));
	$vSmart->mColsAligns = array("10px","700px", "100px");
	Return $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	$label = "Pages ::: ";
	if ($pItemID) $label .= "Edit page"; else $label .= "Create new page";
	$this->setTitle($label);
	$vPage = new CPage($pItemID);
	Return $vPage->displayEdit();
  }

  /** comment here */
  function displaySave($pItemID) {
	$vPage = new CPage($pItemID);
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
