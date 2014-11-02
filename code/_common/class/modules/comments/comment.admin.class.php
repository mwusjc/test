<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CCommentAdmin extends CSectionAdmin{

  /** comment here */
  function CCommentAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
  }

  /** comment here */
  function display() {
	STitle::set("usercomments");
	SAccess::enforce("viewcomments");

	$sql = "SELECT * from cms_comments a ".
			" WHERE 1=1  ".
			" ##CRITERIA## ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mShowToggle = false;
	$vSmart->mItemsPerPage = 20;
	$vSmart->setIcons(array("view", "print", "delete"));
	$vSmart->mIconManager->mIcons["view"][2] = "View Comment";

	$vSmart->addHeader(array("Name|true", "Email|true", "Subject", "Date Received|true", "Date Replied|true"));
	$vSmart->addFuncField($this, "getName");
	$vSmart->addField("Email");
	$vSmart->addField("Subject");
	$vSmart->addDField("TimeStamp", "m/d/Y");
	$vSmart->addDField("ReplyTime", "m/d/Y");

	$vSmart->addCompositeFilter("Name", "a.Subject, a.Name, a.Email", "Search", 1);
	$vSmart->addRFilter("a.TimeStamp", "Comment date between", "and", 1, "date");

	$vSmart->mColsWidths = array("23px", "130px", "120px", "120px", "120px", "120px", "90px");
	$vSmart->mColsAligns = array("left", "left", "left", "left", "left", "left", "left", "right");
	$vSmart->setTemplate("admin");

	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function getName($data) {
	Return $data["FirstName"] . " " . $data["LastName"];
  }

  /** comment here */
  function delete($pUserID) {
	SAccess::enforce("deletecomment");
	  if ($pUserID == 1) {
		$this->mLastError = "This user cannot be deleted";
		$this->redirect($this->getBaseLink() ."main");
	  }
	  $vUser = new CComment($pUserID);
	  $vUser->delete();
	  $this->redirect($this->getBaseLink() . "main&id=$pID");
	}

/** comment here */
function displayItem($pID) {
	STitle::set("viewcomment");
	SAccess::enforce("viewcomments");

	$vContact = new CComment($pID);
	$prev = $this->mDatabase->getValue("cms_comments a","max(a.ID)", " a.ID < '$pID' ".$_SESSION["gAdminCriteria"]);
	if ($prev) {
		$prev = new CHref($this->getBaseLink(). "view&id=$prev", "<img src=\"http://wms.thebrandfactory.com/images/common/large/media_rewind.png\">");
		$prev = $prev->display();
	} else $prev = "&nbsp;";

	$next = $this->mDatabase->getValue("cms_comments a","min(ID)", " a.ID > '$pID' ".$_SESSION["gAdminCriteria"]);

	if ($next) {
		$next = new CHref($this->getBaseLink(). "view&id=$next", "<img src=\"http://wms.thebrandfactory.com/images/common/large/media_fast_forward.png\">");
		$next->setClass("nav");
		$next = $next->display();
	} else $next = "&nbsp;";

	$center = new CHref($this->getBaseLink(). "main", "<img src=\"http://wms.thebrandfactory.com/images/common/large/undo.png\">");
	$center->setClass("nav");
	$center = $center->display();

	$rows = array(array($prev, $center, $next));
	$table = new CGrid($rows);
	$table->setTemplate("simple");
	$table->setColsAligns(array("left", "center", "right"));
	$table->setColsWidths(array("25%", "50%", "25%"));
	Return $table->display() . $vContact->display();
}

///** comment here */
//function displayPrint($pID = 0) {
//	$this->mDocument->mPageTemplate = "_common/templates/print.html";
//	if ($pID) {
//		$vContact = new CComment($pID);
//		Return $vContact->display();
//	} else {
//		$sql = "select * from cms_comments a where 1=1 ".$_SESSION["gAdminCriteria"];
//		$data =$this->mDatabase->getAll($sql);
//		$vContact = new CComment(0);
//		foreach ($data as $key=>$val) {
//			$vContact->reload($val);
//			$txt .= $vContact->display();
//		}
//		Return $txt;
//	}
//}

/** comment here */
function displayReply($id) {
	STitle::set("replytocomment");
	SAccess::enforce("replycomment");
	$comment = new CComment($id);
	$comment->displayReply();
	Return $this->flushTemplate();
}

/** comment here */
function doReply($id) {
	SAccess::enforce("replycomment");

	$comment = new CComment($id);
	$comment->doReply();
    $this->redirect($this->getBaseLink() . "main&id=$pID");

}


  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
	  case "print":
		  Return $this->displayPrint($_GET["id"]);
	  case "reply":
		  Return $this->displayReply($_GET["id"]);
	  case "doreply":
		  Return $this->doReply($_GET["id"]);
	  default:
		  Return CSectionAdmin::mainSwitch();
	}
  }
}

?>