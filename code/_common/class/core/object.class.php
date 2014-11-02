<?php

	class CObject {
		var $id;
		var $version;
		var $name;
		var $type;
		var $section;
		var $parent;
		var $comment;
		var $table;

		var $mDocument;

		var $mPageID;
		var $mUserID;
		var $mUserObj;
		var $mSection;
		var $mOp; var $mOperation; #alias
		var $mClass;
		var $mAdminMode;
		var $mIE;
		var $mFullLinksMode;

		function CObject() {
		  $this->mDocument = &$GLOBALS["vDocument"];
		  $this->mPageID = &$this->mDocument->mPageID;
		  $this->mUserID = &$this->mDocument->mUserID;
		  $this->mUserObj = &$this->mDocument->mUserObj;
		  $this->mSection = &$this->mDocument->mUrlObj->mModule_;

		  $this->mOp = &$this->mDocument->mUrlObj->mOperation_;$this->mOperation = &$this->mDocument->mUrlObj->mOperation_;
		  $this->mClass = &$this->mDocument->mUrlObj->mClass;
		  $this->mAdminMode = &$this->mDocument->mAdminMode;
		  $this->mIE = &$this->mDocument->mIE;
		  $this->mFullLinksMode = &$this->mDocument->mFullLinksMode;
		  $this->register();
		}

		/** comment here */
		function _virtual() {
			die("Virtual functions need implementation");
		}
		/** comment here */
		function register() {
//		  $this->mDocument->registerObject($this->id, $this->section, $this->name, $this->parent, $this->type, $this->table);
//		  $this->mDocument->registerObject($this);
		}

		/** comment here */
		function isAdmin() {
			if ($this->mUserObj->mRowObj->GroupID== 101 || $this->mUserObj->mRowObj->GroupID== 102) Return true;
			Return false;
		}

		/** comment here */
		function isSuperAdmin() {
			if ($this->mUserObj->mRowObj->GroupID == 101) Return true;
			Return false;
		}

		/** comment here */
		function isAdminGroup($groupid) {
			if ($groupid== 101 || $groupid == 102) Return true;
			Return false;

		}
		/** comment here */
		function checkRight($pRightID) {
			if (!$this->mUserID) Return false;
			if ($this->isAdmin()) Return true;
			if ($this->isSuperAdmin()) Return true;
			if (in_array($pRightID, $this->mUserObj->mRights)) Return true;
			Return false;
		}

		/** comment here */
		function enforceRight($pRightID, $pUrl = "") {

		}

		/** comment here */
		function checkLogin() {
			if ($this->mUserID) Return true;
			else {
				$this->mDocument->mUrlObj->setCheckPoint();
				$this->error("You need to be logged to access this page!");
				$this->mFullLinksMode = true;
				$this->redirect($this->getBaseLink("Users"). "login");
			}
		}


		/** comment here */
		function getBaseLink($pSection = "") {
		  $index = "index.php"; if ($this->mAdminMode) $index = "index2.php";
		  if (!$pSection) $pSection = $this->mSection;
		  $url = "$index?n=" . $pSection . "&o=";
		  if ($this->mFullLinksMode) $url = APP_SERVER_NAME . "/".$url;
		  Return $url;
		}

		/** comment here */
		function getStdLink($pOperation = "main", $pID = "") {
		  $index = "index.php"; if ($this->mAdminMode) $index = "index2.php";
		  $url = "$index?n=" . $this->mSection . "&o=" . $pOperation . "&id=" . $pID . "&c=" . $this->mClass;
		  if ($this->mFullLinksMode) $url = APP_SERVER_NAME . "/".$url;
		  Return $url;
		}

		/** comment here */
		function getSecureLink($pSectionName = "") {
		  $url = APP_SERVER_NAME_SECURE . "/".$this->getBaseLink($pSectionName);
		  Return $url;
		}

		/** comment here */
		function getFullLink($pLink) {
			if ($pLink != "#" && $pLink && $this->mFullLinks) {
			  $vBase = substr($pLink,0,4);
			  if (strtolower($vBase) != "http") return APP_SERVER_NAME. "/".$pLink;
			}
			Return $pLink;
		}

		/** comment here */
		function redirect($pUrl) {
		  if (!$pUrl) $pUrl = $this->getBaseLink();
		  $this->mDocument->halt($pUrl);
		}

		/** comment here */
		function redirectOp($pOp) {
		  $pUrl = $this->getBaseLink() . $pOp;
		  return $this->reload($pUrl);
		}

		/** comment here */
		function goToCheckPoint() {
			$pUrl = $this->mDocument->mUrlObj->getPrevCheckpoint();
			$this->redirect($pUrl);
		}

		/** comment here */
		function error($pMsg, $pSeverity = 2) {
		  $this->mDocument->mErrorObj->pushError($pMsg, $pSeverity);
		}

		/** comment here */
		function notice($pMsg) {
		  $this->mDocument->mErrorObj->pushError($pMsg, 3);
		}

		/** comment here */
		function displayError() {
		  $error = $this->mDocument->mErrorObj->popError();
		  if ($error[1] <=2) $class = "alert"; else $class = "notify";
		  Return $this->displayDiv($error[0], $class);
		}

		/** comment here */
		function displayDiv($pTxt, $pClass) {
		  $vDiv = new CDiv($pTxt);
		  $vDiv->mClass = $pClass;
		  Return $vDiv->display();
		}

		/** comment here */
		function assign($pKey, $pValue, $pEscape = false) {
			if ($pEscape) $this->mDocument->mTemplateObj->gotoBlock("_ROOT");
			$this->mDocument->mTemplateObj->assign($pKey, $pValue);
		}

		/** comment here */
		function newBlock($pBlock) {
			$this->mDocument->mTemplateObj->newBlock($pBlock);
		}

		/** comment here */
		function selectBlock($pBlock) {
			$this->mDocument->mTemplateObj->gotoBlock($pBlock);
		}

		/** comment here */
		function assignGlobal($pKey, $pValue) {
			$this->mDocument->mTemplateObj->assignGlobal($pKey, $pValue);
		}

		/** comment here */
		function assignRow($pKey, $pValue, $pBlock) {
			$this->mDocument->mTemplateObj->newBlock($pBlock);
			$this->mDocument->mTemplateObj->assign($pKey, $pValue);
		}


		/** comment here */
		function resetTemplate($pTemplate) {
		  $this->mDocument->mTemplateObj = new TemplatePower($pTemplate);
		  $this->mDocument->mTemplateObj->prepare();
		}

		/** comment here */
		function flushTemplate() {
		  Return $this->mDocument->mTemplateObj->getOutputContent();
		}


		/** comment here */
		function isEmployee() {
			if ($this->mUserObj->mRowObj->GroupID <= 3) Return true;
			Return false;
		}

		/** comment here */
		function sendEmail($recipient, $subject, $body, $from = "", $fromemail = "") {

			if (!$from) $from = "ShareFolder.com";
			if (!$fromemail) $fromemail = "info@sharefolder.com";

//			$body = "<html><head></head><body>".
//							$body .
//							"</body></html>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= "From: $from <$fromemail>\r\n";
			$headers .= "Reply-To: $fromemail\r\n";
			mail($recipient, $subject, $body, $headers);

		}

		/** comment here */
		function sendRichEmail($recipient, $pageid, $args, $from = "", $fromemail = "") {
			$txt = file_get_contents("templates/edms/main.html");

			$page = new CPage($pageid);
			$body = $page->mRowObj->Txt;
			foreach ($args as $key=>$val) {
				$body = str_replace("{".strtoupper($key)."}", $val, $body);
			}
			$body = str_replace("{WWWCOLOR}", "<a href=\"http://www.sharefolder.com\"><span style=\"color: #ff9f00\">share</span>folder</a>", $body);
			$body = str_replace("{SEPARATOR}", '<div style="width: 100%; height: 1px; border-bottom: 1px solid #d9d9d9">&nbsp;</div>', $body);

			$title = $page->mRowObj->Title;
			$subject = $page->mRowObj->Subject;
			$txt = str_replace("{TITLE}", $title, $txt);
			$txt = str_replace("{BODY}", $body, $txt);

			$to = $data["Email"];
			$this->sendEmail($to, $subject, $txt);

			if (!$from) $from = "ShareFolder.com";
			if (!$fromemail) $fromemail = "info@sharefolder.com";

//			$body = "<html><head></head><body>".
//							$body .
//							"</body></html>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= "From: $from <$fromemail>\r\n";
			$headers .= "Reply-To: $fromemail\r\n";
			mail($recipient, $subject, $txt, $headers);
		}

		/** comment here */
		function getLangID() {
			switch($_SESSION["gLanguage"]) {
				case "english": Return "";
				case "french": Return "2";
				default: Return "";
			}
		}
	}

?>