<?php

class CSectionAdmin extends CSectionManager {

  /** comment here */
  function CSectionAdmin($pRight = false) {
	$this->CSectionManager();
	if ($pRight) $this->checkRight($pRight);
  }

    /** comment here */
  function getClass() {
	Return $this->mClasses[intval($this->mClass)][1];
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
	$label = "Add/Edit";
	$class = $this->getClass();
	$vItem = new $class($pItemID);
	$vItem->mSectionName = $this->mSectionName;
	$vTable = new CBoxTable($vItem->displayEdit(), $label, $footer, "admin_edit");
	Return $vTable->display();
  }

  /** comment here */
  function displaySave($pItemID) {
	$class = $this->getClass();
	$vItem = new $class($pItemID);
	$vItem->mSectionName = $this->mSectionName;
	$vItem->registerForm();
	$vItem->easySave();
	$this->redirect($this->getBaseLink() . "main");
  }

  /** comment here */
  function toggle($pID) {
	$class = $this->getClass();
	$vItem = new $class($pID);
	$vItem->mSectionName = $this->mSectionName;
	$vItem->toggle();
	$this->redirect($this->getBaseLink() . "main");
  }

  /** comment here */
  function move($pID, $pDirection) {
	$class = $this->getClass();
	$vItem = new $class($pID);
	$vItem->mSectionName = $this->mSectionName;
	$vItem->move($pDirection);
	$this->redirect($this->getBaseLink() . "main");
  }

  /** comment here */
  function displayItem($pItemID) {
	$class = $this->getClass();
	$vItem = new $class($pItemID);
	$vItem->mSectionName = $this->mSectionName;
	Return $vItem->displayPreview();
  }

  /** comment here */
  function delete($pID) {
	$class = $this->getClass();
	$vItem = new $class($pID);
	$vItem->mSectionName = $this->mSectionName;
	$vItem->delete();
	$this->redirect($this->getBaseLink() . "main");
  }

  /** comment here */
  function nav($pID, $action, $table,  $pk="ID") {

	$prev = $this->mDatabase->getValue("$table a","max(a. $pk)", " a. $pk < '$pID' ".$_SESSION["gAdminCriteria"]);
	if ($prev) {
		$prev = new CHref($this->getBaseLink(). "$action&id=$prev", "<img src=\"_common/images/admin/media_rewind.png\" onmouseover=\"this.src='_common/images/admin/media_rewind_over.png'\" onmouseout=\"this.src='_common/images/admin/media_rewind.png'\" title=\"Previous item\">");
		$prev = $prev->display();
	} else $prev = "&nbsp;";

	$next = $this->mDatabase->getValue("$table a","min( $pk)", " a. $pk > '$pID' ".$_SESSION["gAdminCriteria"]);

	if ($next) {
		$next = new CHref($this->getBaseLink(). "$action&id=$next", "<img src=\"_common/images/admin/media_fast_forward.png\"  onmouseover=\"this.src='_common/images/admin/media_fast_forward_over.png'\" onmouseout=\"this.src='_common/images/admin/media_fast_forward.png'\" title=\"Next item\">");
		$next->setClass("nav");
		$next = $next->display();
	} else $next = "&nbsp;";

	$center = new CHref($this->getBaseLink(). "main", "<img src=\"_common/images/admin/undo.png\" onmouseover=\"this.src='_common/images/admin/undo_over.png'\" onmouseout=\"this.src='_common/images/admin/undo.png'\"  title=\"Back to list\">");
	$center->setClass("nav");
	$center = $center->display();

	$rows = array(array($prev, $center, $next));
	$table = new CGrid($rows);
	$table->setTemplate("simple");
	$table->setColsAligns(array("left", "center", "right"));
	$table->setColsWidths(array("25%", "50%", "25%"));
	$this->mDocument->setPiece("SECTION_TITLE", $table->display());

  }

  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
	  case "main":
	  case "":
		Return $this->display();
	  case "show":
	  case "view":
		Return $this->displayItem($_GET["id"]);
	  case "edit":
	  case "create":
		Return $this->displayEdit($_GET["id"]);
	  case "save":
		Return $this->displaySave($_GET["id"]);
	  case "toggle":
		Return $this->toggle($_GET["id"]);
	  case "move":
		Return $this->move($_GET["id"], $_GET["type"]);
	  case "delete":
		Return $this->delete($_GET["id"]);
	  default:
		Return CSectionManager::mainSwitch();
	}
  }


}

?>