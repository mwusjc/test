<?php   
/** CCommentManager
* @package admin
* @author cgrecu
*/


  class CCommentManager extends CSectionManager {
	/** comment here */
	function CCommentManager() {
	  $this->CSectionManager();
	}


	/** comment here */
	function display() {
		$txt = $this->mDocument->getMenu();
		$this->setPiece("LEFTBODY", $txt);
		$vComment = new CComment();
		$vComment->displayEdit();
		Return $this->flushTemplate();

	}

	/** comment here */
	function saveComment() {
		$vComment = new CComment();
		$vComment->registerForm();
		$vComment->mRowObj->TimeStamp = time();
		$vComment->mRowObj->Type = "general";
		$vComment->easySave();
		$this->error("Your comments were submitted", 4);
		$this->redirect("index.php");
	}

	/** comment here */
	function mainSwitch() {
	  switch($this->mOperation) {
		  case "main":
			  Return $this->display();
		  case "save":
			Return $this->saveComment();
	  }
	}
  }

?>
