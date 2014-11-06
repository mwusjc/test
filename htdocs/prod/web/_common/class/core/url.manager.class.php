<?php   

	class CUrlManager {

		var $mScript;
		var $mModule_;
		var $mOperation_;
		var $mClass;
		var $mID;
		var $mArgs;
		var $mHistory;
		var $mAddUrl = true;

		/** comment here */
		function CUrlManager() {
		  $this->_init();
		}

		/** comment here */
		function _init() {
		  $this->mClass = "";
		  $this->mID = "";
		  if (isset($_GET["n"])) $this->mModule_ = $_GET["n"]; if (!$this->mModule_) $this->mModule_ = "Home";
		  if (isset($_GET["o"])) $this->mOperation_ = $_GET["o"]; if (!$this->mOperation_) $this->mOperation_ = "main";
		  if (isset($_GET["i"])) $this->mID = $_GET["i"];
		  if (isset($_GET["c"])) $this->mClass = $_GET["c"];
		  $this->parseURL();
		  $this->mHistory = $_SESSION["gUrlStack"];
		}

		/** comment here */
	  function parseURL() {
		  $this->mScript = $_SERVER["SCRIPT_NAME"];
		foreach ($_GET as $key=>$val) {
		  $this->mArgs[$key]	 = $val;
		}
	  }

		/** comment here */
	  function removeArgument($pArg) {
		unset($this->mArgs[$pArg]);
	  }

	  /** comment here */
	function replaceArgument($pArg, $pVal) {
	  $this->mArgs[$pArg] = $pVal;
	}

	  /** comment here */
	function insertArgument($pArg, $pVal) {
	  $this->mArgs[$pArg] = $pVal;
	}

	/** comment here */
	function getURL() {
	  $txt = array();
	  foreach ($this->mArgs as $key=>$val) {
	  	$txt[] = "$key=$val";
	  }
	  if ($_SERVER["SERVER_PORT"] == 443) $base = "https://"; else $base = "http://";
	  $base .= $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"]."?";
	  Return $base . implode("&", $txt);
	}

	/** comment here */
	function getPrevUrl($howfar = 1) {
		if (count($this->mHistory) == 0) Return "index.php";
		$index = max(0, count($this->mHistory) - 1 - $howfar);
		Return $this->mHistory[$index][0];
	}

	/** comment here */
	function getPrevCheckpoint() {
		if (count($this->mHistory) == 0) Return "index.php";
		for($i=count($this->mHistory) -1; $i>=0; $i--) {
			if ($this->mHistory[$i][1] == 1) Return $this->mHistory[$i][0];
		}
		Return "index.php";
	}

	/** comment here */
	function setCheckPoint() {
		$this->mHistory[] = array($this->getURL(), 1);
	}

	/** comment here */
	function _finalize() {
		if ($this->mAddUrl) $this->mHistory[] = array($this->getURL(), 0);
		$_SESSION["gUrlStack"] = $this->mHistory;
	}
	}

?>