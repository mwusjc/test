<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CEmailAdmin extends CSectionAdmin{

  /** comment here */
  function CEmailAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Templates", "CEmail");
  }


  /** comment here */
  function display() {
//	 debug();
	$this->enforceRight("view_newsletter");
	$sql = "SELECT * from cms_newsletters Where (userid = '".$this->mUserID."' OR Shared ='yes')  ##CRITERIA##";
	$vSmart = new CSmartTable("cms_newletters", $sql);
	$vSmart->mItemsPerPage = 20;
	$vSmart->setIcons(array("edit", "clone", "view", "email"));
	$vSmart->addHeader(array("Subject|true", "Created|true"));
	$vSmart->addField("Subject");
	$vSmart->addDField("TimeStamp", "F d, Y");
	$vSmart->mShowToggle = true;
//	$vSmart->addSField("<input style=\"font-size:8pt; border: 1px dotted #ccc\" type=\"text\" value=\"http://" . APP_DOMAIN . "/index.php?name=Pages&op=show&id=##ID##\" style=\"width:330px;\" id=\"asdad\" name=\"asdgf\">");
	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "edit", "Create new email template"));
	$vSmart->mColsAligns = array("10px","300px", "120px", "100px");
	$vSmart->setTemplate("admin");
	Return $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	  if ($pItemID) $this->enforceRight("edit_newsletter"); else $this->enforceRight("create_newsletter");
	$label = "Templates ::: ";
	if ($pItemID) $label .= "Edit email template"; else $label .= "Create new email template";
	$this->setTitle($label);
	$vPage = new CEmail($pItemID);
	$vPage->mRowObj->ContentType = 'email';
	if (!$pItemID) {
		$vPage->mRowObj->FromName = EMAIL_FROM_NAME;
		$vPage->mRowObj->FromAddress = EMAIL_FROM_ADDRESS;
	}
	$vPage->unregisterForm();
	Return $vPage->displayEdit();
  }

  /** comment here */
  function displaySave($pItemID) {
	$this->enforceRight("edit_newsletter");
	$vPage = new CEmail($pItemID);
	$vPage->mRowObj->ContentType = 'email';
	$ret = $vPage->save();
	if (!$ret) $this->redirect($this->getBaseLink() . "edit&id=". $vPage->mRowObj->ID) ;

	$this->redirect($this->getStdLink());
  }

/** comment here */
function displayEmail($pID = 0) {
	$this->enforceRight("view_newsletter");
	$vPage = new CEmail($pID);
	$vPage->unregisterForm();

	$this->resetTemplate("D:/inetpub/wwwroot/_common/templates/mailing/testmail.html");
	$form = new CForm("frmEdit", $this->getBaseLink(). "doemail&id=$pID");
	if ($pID) $sql = "select email from contacts where id = '".addslashes($pID)."' and subscribed = 'yes' and email <> ''";
	else {
		$sql = "select email from contacts a where 1=1 and subscribed = 'yes' and email <> '' ".$_SESSION["gAdminCriteria"];
	}
	$data  = $this->mDatabase->getAll($sql);
	$emails = implode("; ", $data);

	$input = new CTextInput("FromName", "");
	$input->setClass("size400");
	$form->addElement($input);

	$input = new CTextInput("FromAddress", "");
	$input->setClass("size400");
	$form->addElement($input);

	$input = new CTextArea("To", APP_ADMIN_EMAIL, 4, 60);
	$form->addElement($input);

//	$this->mDocument->mHead->addScript(new CScript("", "_common/scripts/newsletter.js"));
//	$input = new CComboBox("TemplateID", "cms_newsletters", "ID", "Subject", "", "where status = 'enabled' and (userid = '".$this->mUserID."' or Shared = 'yes')");
//	$input->setExtraOption(array("", " -- select newsletter -- "));
//	$input->setJavaScript("onchange", "if (this.value) getNewsletter(this.value);");
//	$form->addElement($input);

	$input = new CTextInput("Subject", "");
	$input->setClass("size400");
	$form->addElement($input);

//	$input = new CTextArea("Message", "", 27, 60);
//	$form->addElement($input);

	$form->display();
	Return $form->flushTemplate();
}

/** comment here */
function email($pID) {
	$this->enforceRight("view_newsletter");
	$vEdm = new CEDM();
	$vEdm->registerForm();
	$vEdm->mRowObj->EmailID = $pID;
	$vEdm->mRowObj->TimeStamp  = time();

	$emails = explode("\n", $_POST["To"]);
	foreach ($emails as $key=>$val) {
		$ret = $vEdm->sendTest($val);
	}
	Return $this->displayEmailResults($ret);
}

	/** comment here */
	function displayEmailResults($result) {
		$this->enforceRight("view_newsletter");
		$center = new CHref($this->getBaseLink(). "main", "<img src=\"http://wms.thebrandfactory.com/images/common/large/undo.png\">");
		$center->setClass("nav");
		$txt = "<p>".$center->display()."</p>";

		if ($result) $txt .= "<p>EDM was successfully dispatched to ".$_POST["To"]."</p>";
		else $txt .= "<p>EDM was NOT dispatched to ".$_POST["To"]." to to an unknow problem</p>";
		Return $txt;
	}

/** comment here */
function displayItem($pID = 0) {
	$this->enforceRight("view_newsletter");
	$vPage = new CEmail($pID);
	$center = new CHref($this->getBaseLink(). "main", "<img src=\"http://wms.thebrandfactory.com/images/common/large/undo.png\">");
	$center->setClass("nav");
	$txt = "<p>".$center->display()."</p>";
	$txt .= "<h5>HTML Version</h5><div style=\"border: 1px dotted #000; width: 100%;\">". $vPage->mRowObj->HtmlVersion . "</div>";
	$txt .= "<h5>Txt Version</h5><div style=\"border: 1px dotted #000; width: 100%;\">". nl2br($vPage->mRowObj->TxtVersion) . "</div>";
	Return $txt;

}

/** comment here */
function clonePage($id) {
	$this->enforceRight("edit_newsletter");
	$vPage = new CEmail($id);
	$vPage2 = new CEmail();
	$vPage2->mRowObj = $vPage->mRowObj;
	$vPage2->mRowObj->ID = 0;
	$vPage2->mRowObj->Subject = $vPage2->mRowObj->Subject . " copy";
	$vPage2->easySave();
	$this->redirect();
}
/***********************************************************************************************************
****	  END OF TEMPLATE FUNCTIONS - CONTINUE WITH SPECIAL FUNCTIONS									****
***********************************************************************************************************/


  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
	  case "view":
		  Return $this->displayItem($_GET["id"]);
	  case "email":
		  Return $this->displayEmail($_GET["id"]);
	  case "doemail":
		  Return $this->email($_GET["id"]);
	  case "clone":
		  Return $this->clonePage($_GET["id"]);
		default:
		  Return CSectionAdmin::mainSwitch();
	}
  }
}

?>
