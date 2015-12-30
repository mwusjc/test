<?php

  class CUserManager extends CSectionManager {

	var $section = "Users";
	var $parent = "";
	var $table = "";

	/** comment here */
	function CUserManager() {
	  $this->CSectionManager();
	}

	/** comment here */
	function registerClasses() {
	  $this->mClasses[] = array("Users", "CUser");
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
	function forgot() {
		$data = $this->mDatabase->getRow("select * from users where email = '".addslashes($_POST["Email"])."'");
		if (empty($data)) {
			$this->loginError("Invalid email address");
			$this->redirect("index.php?n=Users&o=forgot");
		} else {
			$args = array("username"=>$data["Username"], "password" => $data["Password"]);
			$this->sendRichEmail($data["Email"], "forgot-password", $args);
			$this->redirect("index.php?n=Users&o=passsent&email=" . urlencode($_POST["Email"]));
		}
	}

	/** comment here */
	function sendPassword($email) {
		$data = $this->mDatabase->getRow("select * from users where email = '".addslashes2($email)."'");

		if (empty($data)) {
			  $xml = "<result>not found</result>";
			  xml($xml);
		} else {

			$mailer = new CEmailer();
			$subject= "Your Digital Studio password";
			$email = $data["Password"];
			$pdfs = array();
			$mailer->send2(array($data["Email"]), $subject, $email, $pdfs);

			  $xml = "<result>ok</result>";
			  xml($xml);
		}
	}

	/** comment here */
	function displayLogin() {
		$this->mDocument->mHead->addScript(new CScript("", "_common/scripts/misc/md5.js"));
		$this->mDocument->mHead->addScript(new CScript("", "_common/scripts/misc/login.js"));
		$this->mDocument->mPageTemplate = "templates/main_login.html";
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
	function displayForgot() {
		$txt = $this->mDocument->getMenu();
		$this->setPiece("LEFTBODY", $txt);

  	  $this->resetTemplate("templates/users/forgot.html");
	  $vForm = new CForm("frmLogin", $this->getBaseLink() . "doforgot");
	  $txtUser = new CTextInput("Email", "");
	  $txtUser->setClass("size270");
	  $vForm->addElement($txtUser);
	  $vForm->display();
	  Return $this->flushTemplate();
	}

	/** comment here */
	function passwordSent($email) {
		$txt = $this->mDocument->getMenu();
		$this->setPiece("LEFTBODY", $txt);

		$this->resetTemplate("templates/users/passsent.html");
		$this->assign("Email", $email);
		Return $this->flushTemplate();
	}

	/** comment here */
	function displayContact() {
	  $this->mDocument->setTemplate("blank");
  	  $this->resetTemplate("templates/users/contact.html");
	  $vForm = new CForm("frmLogin", $this->getBaseLink() . "docontact");
	  $txtUser = new CTextInput("Username", "");
	  $txtUser->setClass("optional size300");
	  $vForm->addElement($txtUser);

	  $txtUser = new CTextInput("EmailAddress", "");
	  $txtUser->setClass("required size300");
	  $vForm->addElement($txtUser);

	  $txtUser = new CTextInput("Subject", "");
	  $txtUser->setClass("required size300");
	  $vForm->addElement($txtUser);

	  $txtUser = new CTextArea("Comments", "", 8, 60);
	  $txtUser->setClass("required size300");
	  $vForm->addElement($txtUser);

	  $vForm->display();
	  Return $this->flushTemplate();
	}

	/** comment here */
	function contact() {
	  $this->mDocument->setTemplate("blank");
		mail(APP_ADMIN_EMAIL, "Enquiry from ShareFolders", "Email Address: ".$_POST["EmailAddress"] . "\n"."Username: ".$_POST["Username"] . "\n"."Subject: ". $_POST["Subject"]."\n". "Comments: ".$_POST["Comments"] );
		$_SESSION["login_message"] = "Your comments have been received, someone from The Brand Factory will contact you shortly!";
		$this->redirect("index.php?n=Users&o=login");
	}


	/** comment here */
	function logout() {
		$this->mUserObj->logout();
		$this->redirect("index.php");
	}

	/** comment here */
	function displaySave($pID) {
		$vUser = new CUser($pID);
		$vUser->registerForm();

		$this->mDatabase->begin("all");
		$ret = $vUser->save();
		$this->mDatabase->verify($ret, "all");

		$this->redirect($this->getBaseLink() . "profile");
	}


	/** comment here */
	function mainSwitch() {
		error_reporting(0);
	  switch($this->mOperation) {
		case "login":
		  Return $this->displayLogin();
		case "logout":
		  Return $this->logout();
		case "enquiry":
		  Return $this->displayEnquiry();
		case "save_enquiry":
		  Return $this->saveEnquiry();
		case "dologin":
		  Return $this->login();
		case "doajaxlogin":
		  Return $this->ajaxLogin();
		case "forgot":
		  Return $this->displayForgot();
		case "doforgot":
		  Return $this->forgot();
		case "send_password":
			Return $this->sendPassword($_GET["email"]);
		case "passsent":
		Return $this->passwordSent($_GET["email"]);
		case "contact":
		  Return $this->displayContact();
		case "docontact":
		  Return $this->contact();
		default:
		  Return CSectionManager::mainSwitch();
	  }
	}
  }

?>