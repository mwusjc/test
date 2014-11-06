<?php
	class CRegistration extends CDBContent {

	  var $section = "Contacts";
	  var $parent = "CContactManager";
	  var $table = "contacts";


	  function CRegistration ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	  /** comment here */
	  function reload($data) {
		foreach ($this->mRowObj as $key=>$val) {
			$this->mRowObj->$key = "";
		}
		foreach ($data	 as $key=>$val) {
			$this->mRowObj->$key = $val;
		}
//		die2($this->mRowObj);
	  }

	  /** comment here */
	  function display() {
		$this->resetTemplate("templates/contacts/contact.html");
		$this->newBlock("CONTACT");

		$fields = array();
		$fields["Registrant ID"] = $this->mRowObj->ID;
		$fields["Registration Date"] = date("F d, Y H:i", $this->mRowObj->TimeStamp);
		$fields["Name"] = $this->mRowObj->FirstName ." ". $this->mRowObj->LastName;
		$fields["Email"] = $this->mRowObj->Email;
		$fields["PostCode"] = $this->mRowObj->PostCode;
		$fields["Subscribed to eFlyer"] = $this->mRowObj->FlyerSubscribed;
		$fields["Subscribed to Promotions"] = $this->mRowObj->Subscribed;

		foreach ($fields as $key=>$val) {
			$this->newBlock("FIELD");
			$this->assign("Left", $key);
			$this->assign("Right", $val);
		}

		Return $this->flushTemplate();
	  }


	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/contacts/edit.html");

	  $txtInput = new CTextInput("FirstName","");
	  $txtInput->setClass("required size150");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("LastName","");
	  $txtInput->setClass("required size150");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputEmail("Email","");
	  $txtInput->setClass("required size250");
	  $txtInput->validate("Email is missing", "Invalid address");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("PostCode","");
	  $txtInput->setClass("optional size100");
	  $vForm->addElement($txtInput);


	  $vForm->display();
	}

	/** comment here */
	function save() {
	  $new = false; if (!$this->mRowObj->ID) $new = true;
	  $this->registerForm();


	  $this->easySave();
	}


	/** comment here */
	function toggle() {
	  if ($this->mRowObj->Status == "suspended" || !$this->mRowObj->Status) $this->mRowObj->Status = "active"; else $this->mRowObj->Status = "suspended";
	  $this->easySave();
	}

	/** comment here */
	function delete() {
		$sql = "delete from contacts where id ='".$this->mRowObj->ID."'";
		$this->mDatabase->query($sql);
//		$sql = "delete from contact_homes where contactid ='".$this->mRowObj->ID."'";
//		$this->mDatabase->query($sql);
	}


}
?>