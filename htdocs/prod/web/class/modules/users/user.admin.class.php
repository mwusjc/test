<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CUserAdmin extends CSectionAdmin{

  /** comment here */
  function CUserAdmin() {
	$this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Users", "CUser");
  }


  /** comment here */
  function display() {
		SAccess::enforce("manage_users");
	STitle::set("Manage Users");

	if ($_GET["AdminGroup"]) $criteria = " AND b.AdminGroup = 'yes' ";
	$sql = "SELECT a.UserID as ID, concat(a.FirstName, ' ', LastName) as Name, a.Email, a.Status, b.Txt as GroupName, b.AdminGroup, a.Username ".
			" FROM users a, cms_user_groups b WHERE a.GroupID = b.ID  ".
			" ##CRITERIA## ";
	if ($this->mUserObj->mRowObj->GroupID < 100) $sql .= " AND a.GroupID < 100 ";

	$vSmart = new CSmartTable("users", $sql);
	$vSmart->mStatusOn = 'active';
	$vSmart->mItemsPerPage = 20;
	$vSmart->mDefaultOrder = "a.FirstName";
	$vSmart->setIcons(array("edit", "delete", "on", "off"));
	$vSmart->mIconManager->mIcons["view"][2] = "View User Info";
	$vSmart->mIconManager->mIcons["on"][2] = "Active User";
	$vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

	$vSmart->addHeader(array("UserName", "Status", "Name", "User Type", "Admin"));
	$vSmart->addField("Username");
	$vSmart->addField("Status");
	$vSmart->addField("Name");
	$vSmart->addField("GroupName");
	$vSmart->addField("AdminGroup");

	$vSmart->addCompositeFilter("Username", "a.Username, a.Email, a.FirstName, a.LastName", "Search", 1, "input_search size400");
	$vSmart->addLFilter("a.GroupID", "User Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_user_groups order by Txt ASC"), 1);

	$vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Add user"));
	$vSmart->mColsWidths = array("10px", "10px", "300px", "120px", "120px", "90px", "30px");
	$vSmart->mColsAligns = array("center", "center", "left", "left", "left", "left", "left", "right");
	$vSmart->setTemplate("admin");


	Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displaySpecialUsers() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink("Users") . "save_special");
	  $this->resetTemplate("templates/users/editspecialusers.html");
	  $sql = "select UserID from users where keyuser = 'yes'";
	  $users = $this->mDatabase->getAll($sql);
	  $txtInput = new CComboBox("UserID[]","users", "UserID", "UserName", $users);
//	  $txtInput->setClass("optional size300");
	  $txtInput->mMultiple = true;
	  $txtInput->mSize = 25;
	  $vForm->addElement($txtInput);

	  $vForm->display();
	  Return $this->flushTemplate();
  }

	/** comment here */
	function saveSpecialUsers() {
		$sql = "update users set keyuser = 'no'";
		$this->mDatabase->query($sql);
		$sql = "update users set keyuser = 'yes' where userid in ('".implode("','", $_POST["UserID"])."')";
		$this->mDatabase->query($sql);
		$this->redirect($this->getBaseLink() . "special");
	}
  /** comment here */
  function displayEdit($pItemID = 0) {
		SAccess::enforce("manage_users");
	STitle::set("Edit User");

	$vUser = new CUser($pItemID);
	$vUser->unregisterForm();
	$vUser->displayEdit();
	Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
	SAccess::enforce("manage_users");
	$vUser = new CUser($pItemID);
	$vUser->save();
	$this->redirect($this->getStdLink());
//	if ($pItemID) $this->redirect($this->getStdLink());
//	else $this->redirect($this->getStdLink("edit_rights") ."&id=" . $vUser->mRowObj->UserID	);
  }

  /** comment here */
  function displayCreate() {
    STitle::set("Create User");
	SAccess::enforce("manage_users");
	$vUser = new CUser($pItemID);
	$vUser->displayEdit();
	Return $this->flushTemplate();

  }

  /** comment here */
  function manage_users() {
	SAccess::enforce("manage_users");
  	$vUser = new CUser();
	$vUser->registerForm();
	$vUser->mStatus = 'active';
	$vUser->easySave();
	$vProject = new CProject();
	$vProject->create($vUser->mRowObj->UserID);
	$vUser->mRowObj->ProjectID = $vProject->mRowObj->ID;
	$vUser->easySave();
	$this->notice("User created!");
	$this->redirect($this->getStdLink("main"));
  }

  /** comment here */
  function delete($pUserID) {
		SAccess::enforce("manage_users");
	  if ($pUserID == 1) {
		$this->mLastError = "This user cannot be deleted";
		$this->redirect($this->getBaseLink() ."main");
	  }
	  $vUser = new CUser($pUserID);
	  $vUser->delete();
	  $this->redirect($this->getBaseLink() . "main&id=$pID");
	}

	/** comment here */
	function displayLogin() {
		$this->mDocument->mHead->addScript(new CScript("", "_common/scripts/misc/md5.js"));
		$this->mDocument->mHead->addScript(new CScript("", "_common/scripts/misc/login.js"));
		$this->mDocument->mPageTemplate = "templates/main_login.html";
		$this->mDocument->mHead->addCss("css/hf.css");
  	  $this->resetTemplate("templates/users/login.html");
	  $vForm = new CForm("frmLogin", $this->getBaseLink() . "dologin");
	  $txtUser = new CTextInput("Username", "");
	  $txtUser->setClass("size270");
	  $vForm->addElement($txtUser);
	  $txtPass = new CPassword("Password", "");
	  $txtPass->setClass("size270");
	  $vForm->addElement($txtPass);
	  $vForm->display();
	  Return $this->flushTemplate();
	}

	/** comment here */
	function login() {
	  $user = $this->mDatabase->getRow("select * from users where email = '".$_POST["Username"]."' OR username = '".$_POST["Username"]."'");
	  if (empty($user)) $this->loginError($_SESSION["login_message"] = "Invalid username or password")	;
	  if ($user["Status"] != "active") $this->loginError("Your account is not active");
	  if ($user["Password"] == $_POST["Password"]) {
		$vUser = new CUser($user["UserID"]);
		$vUser->login($_POST["remember"]);
		$this->goToCheckPoint();
	  } else {
	  	$_SESSION["login_message"] = $this->loginError("Invalid username or password");
	  }
	  $this->loginError("");
	  $this->redirect("index.php?n=Users&o=login");
	}

	/** comment here */
	function ajaxLogin() {
	  $user = $this->mDatabase->getRow("select * from users where email = '".addslashes2($_GET["username"])."' OR username = '".addslashes2($_GET["username"])."'");
		$error = "";
	  if (empty($user)) $error = "Invalid username or password";
	  else {
		  if ($user["Status"] != "active") $error = "Your account is not active";
		  else {

			  if (md5($user["Password"]) == $_GET["password"]) {
				$vUser = new CUser($user["UserID"]);
				$vUser->login($_GET["remember"]);
				$url = $this->mDocument->mUrlObj->getPrevCheckpoint();
			  } else {
				$error = "Invalid username or password";
			  }
		  }
	  }

	  $xml = "<login_error>" . xmlentities($error) . "</login_error>";
	  $xml .= "<postlogin_url>" . xmlentities($url) . "</postlogin_url>";
	  xml($xml);
	}

	/** comment here */
	function loginError($msg) {
		$this->error($msg);
		$this->redirect($this->getBaseLink("Users") . "login");
	}

	/** comment here */
	function logout() {
		$this->mUserObj->logout();
		$this->redirect("index.php");
	}
  /** comment here */
	function mainSwitch() {
		switch($this->mOperation) {
			case "create":
				Return $this->displayCreate();
			case "docreate":
				Return $this->manage_users();
			case "special":
				Return $this->displaySpecialUsers();
			case "save_special":
				Return $this->saveSpecialUsers();
			case "login":
			  Return $this->displayLogin();
			case "logout":
			  Return $this->logout();
			case "dologin":
			  Return $this->login();
			case "doajaxlogin":
			  Return $this->ajaxLogin();
			default:
			  Return CSectionAdmin::mainSwitch();
		}
	}

}
?>