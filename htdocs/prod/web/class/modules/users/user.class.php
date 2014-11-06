<?php
	class CUser extends CDBContent {

	  var $section = "Users";
	  var $parent = "CUserManager";
	  var $table = "users";
	  var $pk = "UserID";

	  var $mSettings = array();
	  var $mRights = array();

	  function CUser ($pUserID = 0){
		$this->CDBContent($pUserID);
		if ($pUserID) {
		  $this->mSettings = $this->mDatabase->getRowObj("select * from user_settings where userid = '".$pUserID."'");
		  $this->mRights = $this->mDatabase->getAll("select rightid from cms_group_rights where groupid = '".$this->mRowObj->GroupID."'");
		}
	  }

	  /** comment here */
	  function registerEvent($eventtype, $timestamp = 0, $comment = "") {
		  if (!$timestamp) $timestamp = time();
			$sql  = "insert into history_user_events	(userid, timestamp, eventtype, comment) value('".$this->mRowObj->UserID."', $timestamp,'$eventtype', '".addslashes($comment)."')";
			$this->mDatabase->query($sql, "master");
	  }

	  /** comment here */
	  function login($remember = true) {
	  	$this->mUserID = $this->mRowObj->UserID;
		$this->mUserObj = &$this;
		$_SESSION["gUserID"] = $this->mUserID;
		if ($remember) setcookie("UserID", $this->mUserID, time() + 86400 * 91);

		$this->registerEvent("login");
	  }

	  /** comment here */
	  function logout() {
		$this->registerEvent("logout");
	  	$this->mUserID = 0;
		$this->mUserObj = 0;
		$_SESSION["gUserID"] = 0;
		session_unregister("gUserID");
		setcookie("UserID", 0, time() - 1000, '/', '.'. APP_DOMAIN);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink("Users") . "save&id=" . $this->mRowObj->UserID);
	  $this->resetTemplate("templates/users/edituser.html");

	  $txtInput = new CTextInput("Username","");
	  $txtInput->setClass("required size150");
	  $txtInput->validate("Username is missing");
	  $vForm->addElement($txtInput);

	  $txtInput = new CInputEmail("Email","");
	  $txtInput->setClass("required size250");
	  $txtInput->validate("Email is missing", "Invalid address");
	  $vForm->addElement($txtInput);


	  $vForm->createBlock("NEWUSER");
	  $txtInput = new CPassword("Password","");
	  $txtInput->setClass("required size150");
	  if ($this->mRowObj->UserID) $txtInput->mEnabled = "DISABLED";
	  $txtInput->validate("password is missing");
	  $vForm->addElement($txtInput);
	  $txtInput = new CCheckbox("ChangePass","");
	  $txtInput->setJavaScript("onclick", "el=document.getElementById('Password'); if (!this.checked) {el.disabled=true; el.className='disabled'; el.value='xxxxxx';} else { el.disabled=false; el.className='required'; el.value='';};");
	  $vForm->addElement($txtInput);
	  $vForm->addText("ChangeText", "change password");
	  $vForm->exitBlock();

	  $vForm->createBlock("ADMIN");

	  $filter = ""; if ($this->mDocument->mUserObj->mRowObj->GroupID != 1) $filter = " where ID >= 1";
	  $txtInput = new CComboBox("GroupID","cms_user_groups", "ID", "Txt", $this->mRowObj->GroupID, $filter);
	  $txtInput->setClass("optional size300");
	  $txtInput->mDefault = $this->mRowObj->GroupID;
	  $vForm->addElement($txtInput);


	  $txtInput = new CSelect("Status");
	  $txtInput->getOptionsFromField("users", "Status");
	  $txtInput->setClass("optional size300");
	  $txtInput->mDefault = $this->mRowObj->Status;
	  $vForm->addElement($txtInput);

	  $vForm->exitBlock();


	  $txtInput = new CTextInput("FirstName","");
	  $txtInput->setClass("required size150");
	  $txtInput->validate("First Name is missing");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("LastName","");
	  $txtInput->setClass("required size150");
	  $txtInput->validate("Last Name is missing");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("HomePhone","");
	  $txtInput->setClass("required size150");
	  $txtInput->validate("Phone number is required");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("WorkPhone","");
	  $txtInput->setClass("optional size150");
	  $vForm->addElement($txtInput);

//	  $txtInput = new CComboBox("OfficeID","offices", "ID", "Name", $this->mRowObj->OfficeID);
////	  $txtInput->setClass("optional size300");
//	  $txtInput->mDefault = $this->mRowObj->OfficeID;
//	  $vForm->addElement($txtInput);

	  $txtInput = new CTextArea("Address","", 3, 60);
	  $txtInput->setClass("optional size250");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("City","");
	  $txtInput->setClass("optional size150");
	  $vForm->addElement($txtInput);

	  $txtInput = new CTextInput("Zip","");
	  $txtInput->setClass("optional size50");
	  $vForm->addElement($txtInput);

	 if (!$this->mRowObj->CountryID) $this->mRowObj->CountryID = 36;
	  $txtInput = new CCommonList("CountryID","cl_countries", "ca_only");
	  $txtInput->setClass("optional size150");
	  $txtInput->mDefault = $this->mRowObj->CountryID;
	  $txtInput->setJavaScript("onChange","populateStates(this.value);");
	  $vForm->addElement($txtInput);

	  $txtInput = new CSelect("StateID");
	  $txtInput->getOptionsFromDb("cms_states","Name", "ID","where CountryID = '".$this->mRowObj->CountryID."'");
	  $txtInput->mExtraOption = array("", " -- Select State -- ");
	  $txtInput->setClass("optional size150");
	  $vForm->addElement($txtInput);

	  $vForm->display();
	}

	/** comment here */
	function save() {
	  $new = false; if (!$this->mRowObj->UserID) $new = true;
	  $this->registerForm();
	  $ret = $this->easySave("all");
	  if (!$ret) Return false;
	  if ($new) $ret = $this->createSettings();
	}


	/** comment here */
	function toggle() {
	  if ($this->mRowObj->Status == "suspended" || !$this->mRowObj->Status) $this->mRowObj->Status = "active"; else $this->mRowObj->Status = "suspended";
	  Return $this->easySave("all");
	}

	/** comment here */
	function getName() {
		Return $this->mRowObj->FirstName . " ". $this->mRowObj->LastName;
	}

	/** comment here */
  function saveSettings() {
	if (!$this->mRowObj->UserID) Return true;
	$vFields = array();
	foreach ($this->mSettings as $key=>$val) {
		$vFields[$key] = $val;
	}
	$sql = "update user_settings set ".$this->mDatabase->makeUpdateQuery($vFields) . " where ID = '".$this->mSettings->ID."'";
	Return $this->mDatabase->query($sql, "all");
  }

  /** comment here */
	function createSettings() {
		$vFields = array();
		$vFields["UserID"] = $this->mRowObj->UserID;
		$sql = "insert into user_settings ".$this->mDatabase->makeInsertQuery($vFields);
		Return $this->mDatabase->query($sql, "all");
	}


}
?>