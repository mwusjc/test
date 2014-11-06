<?php   
/** Measure performance
* @author Lucian Grecu
* @since 4/6/2004
* @package System
*/
class CBenchmark {

	var $mStartTimes; // array of starting time, index by str
	var $mStopTimes;

	var $mLogModules; // only log for these pages
	var $mLogAll = true;
	
	var $mLog;
	var $mStopLogging = false;
	/** constructor */
	function CBenchmark() {
		$this->timingStart();
		// have a tmp unique for this page
		$this->mUniquePageID = sprintf("%u",crc32(uniqid("")));
	}

	/** start timer */
	function timingStart($pName='default') {
		$this->mStartTimes[$pName] = explode(' ', microtime());
	}

	/** stop timer */
	function timingStop($pName='default') {
		$this->mStopTimes[$pName] = explode(' ', microtime());
	}

	/** see the diff, stop timer if needed */
	function timingElapsed($pName='default') {
		if (!isset($this->mStartTimes[$pName])) {
			return 0;
		} // if

		if (!isset($this->mStopTimes[$pName])) {
			$this->timingStop($pName);
		} // if

		// do the big numbers first so the small ones aren't lost
		$vDiff = $this->mStopTimes[$pName][1] - $this->mStartTimes[$pName][1];
		$vDiff += $this->mStopTimes[$pName][0] - $this->mStartTimes[$pName][0];
		return $vDiff;
	}

	/** get the history of this call */
	function getFileTrace() {
		$vDebug = debug_backtrace();
		$vFiles = array();
		for ($i=0;$i<count($vDebug);$i++) {
			// skip the first one, since it's always this log func
			if ($i==0) { continue; }
			$aFile = $vDebug[$i];
			$vFiles[] = '('.basename($aFile['file']).':'.$aFile['line'].')';
		} // for
		return implode(',',$vFiles);
	}

	/** just for debugging, info */
	function logQuery($pQuery,$pTook) {
		$fields = array('PageID'=>$GLOBALS["vDocument"]->mPageID,
						'QueryStr'=>$pQuery,
						'NumSecs'=>$pTook,
						'FileTrace'=>'#'.$this->getFileTrace(),
						'TimeStamp'=>time(),
		);

		$this->mLog[] = $fields;

	}
		
	/** log page stats into db */
	function logPage() {
	  Return true;;
		$vDatabase = &$GLOBALS['vDatabase'];
		$vSystem = &$GLOBALS['vSystem'];
		$vTook = $this->timingElapsed();

		//$vLoad = $vSystem->getLoadAvg(1);
		$fields = array('PageID'=>$GLOBALS["vDocument"]->mPageID,
						'Section'=>$GLOBALS["vDocument"]->mUrlObj->mModule_,
						'Operation'=>$GLOBALS["vDocument"]->mUrlObj->mOperation_,
						'MainClass'=>$GLOBALS["vDocument"]->mUrlObj->mClass,
						'ID'=>$GLOBALS["vDocument"]->mUrlObj->mID,
						'PageSize'=>strlen($GLOBALS["vDocument"]->mHtml),
						'NumSecs'=>$vTook,
						'NumQueries'=>$vDatabase->mQueryCnt,
//						'SystemLoad'=>$vLoad,
						'RemoteIP'=>$_SERVER["REMOTE_ADDR"],
						'Request'=>$_SERVER["REQUEST_URI"],
						'TimeStamp'=>time()
		);
		$vInsertQuery = $vDatabase->makeInsertQuery($fields);
		$sql = "INSERT IGNORE INTO cms_log_pages $vInsertQuery";
		$vResult = $vDatabase->query($sql,false);

		return true;
	}

	/** comment here */
	function _finalize() {
	  Return true;
	  if (!INI_ENABLE_LOG) Return false;
	  if ($this->mStopLogging) Return false;

	  #log page
	  $this->logPage();

	  #log queries
	  if (!empty($this->mLog)) {
		foreach ($this->mLog as $key=>$val) {
		  $vInsertQuery = $GLOBALS['vDatabase']->makeInsertQuery($val);
		  $sql = "INSERT IGNORE INTO cms_log_queries $vInsertQuery";
		  $vResult = $GLOBALS['vDatabase']->query($sql, false);
		}
	  }
	}
}


$vBenchmark = new CBenchmark();
?>
