<?php   

  class CErrorManager {

	var $mErrors;

	/** comment here */
	function CErrorManager() {
	  $this->_init();
	}

	/** comment here */
	function _init() {
	  session_register("gErrorStack");
	  if (!isset($_SESSION["gErrorStack"])) $_SESSION["gErrorStack"] = array();
	  $this->mErrors = $_SESSION["gErrorStack"];
	}

	/** comment here */
	function pushError($Error, $Severity) {
	  /*
		1 = critical error - interrupt flow
		2 = standard error
		3 = notification
	  */
//		$_SESSION["gErrorStack"] = array();
//		$this->mErrors = array();
	  $pageid = "main";
	  if (array_key_exists("vDocument", $GLOBALS)) $pageid = $GLOBALS["vDocument"]->mPageID;
	  $this->mErrors[] = array($Error, $Severity, $pageid);
	  if ($Severity == 1) {
		  $url = $GLOBALS["vDocument"]->mUrlObj->getPrevUrl();
		$GLOBALS["vDocument"]->halt($url);
	  }
	}

	/** comment here */
	function popError() {
	  if (!empty($this->mErrors)) {
		$Error = array_pop($this->mErrors);
		Return $Error;
	  } else {
	  	Return "";
	  }
	}

	/** comment here */
	function _finalize() {
	  $_SESSION["gErrorStack"] = array();
	  foreach ($this->mErrors as $key=>$val) {
		if ($val[2] != $GLOBALS["vDocument"]->mPageID) continue;
		$GLOBALS["vDocument"]->mDatabase->query("insert into cms_log_errors(PageID, TimeStamp, Severity, Error) values('".$val[2]."', unix_timestamp(), ".$val[1].",'".addslashes($val[0])."')", "all");
		$_SESSION["gErrorStack"][] = $val;
	  }
	}

  }

?>