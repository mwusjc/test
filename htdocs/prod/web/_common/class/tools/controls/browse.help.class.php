<?php 
/** CBrowseHelp
* @package controls
* @since March 26
* @author cgrecu
*/


class CBrowseHelp extends CDBObject {

  var $mBaseUrl;
  var $mQuery;
  var $mResultsPerPage = 10;
  var $mResultsTotal;
  var $mTotalPages;
  var $mCurrentPage;
  var $mStartIndex = 0;

  var $mFirstLimit;
  var $mPrevLimit;
  var $mNextLimit;
  var $mPrev100Limit;
  var $mNext100Limit;
  var $mLastLimit;

  var $mFirstLink;
  var $mPrevLink;
  var $mNextLink;
  var $mPrev100Link;
  var $mNext100Link;
  var $mLastLink;
  var $mStatus;

  var $mStartName = "start";

  var $mLimitResults = 0;

  /** comment here */
  function CBrowseHelp($pQuery) {
	$this->CDBObject();
  	$this->mQuery = $pQuery;
//	$this->mBaseUrl = $pBaseUrl;
//	if ($pStartIndex != "") $this->mStartIndex = $pStartIndex;
  }

  /** comment here */
  function setResultsPerPage($pCount) {
  	$this->mResultsPerPage = $pCount;
  }

  /** comment here */
  function getElements() {
	if (array_key_exists($this->mStartName, $_GET)) $this->mStartIndex = intval($this->mDocument->mUrlObj->mArgs[$this->mStartName]); else $this->mStartIndex = 0;

	$this->mDocument->mUrlObj->removeArgument($this->mStartName);
	$vUrl = $this->mDocument->mUrlObj->getURL();
	$this->mBaseUrl = $vUrl;

//	$vUrl = $this->mBaseUrl . "&".$this->mStartName."=";
	if ($this->mLimitResults) {
		if ($this->mLimitResults < $this->mStartIndex + $this->mResultsPerPage) {
			$this->mStartIndex = $this->mStartIndex - $this->mResultsPerPage;
		}
	}
	$vQuery = str_replace("SELECT ", "SELECT SQL_CALC_FOUND_ROWS ",$this->mQuery) . " LIMIT " . $this->mStartIndex . ", " . $this->mResultsPerPage;
	$rows = $this->mDatabase->getAllTrue($vQuery);

	#calculate number of results / pages
	$tmp = $this->mDatabase->getRow("select FOUND_ROWS() as cnt");
	$this->mResultsTotal = $tmp["cnt"];
	if ($this->mLimitResults) $this->mResultsTotal = min($this->mResultsTotal, 1000);
	$this->mTotalPages = ceil($this->mResultsTotal/$this->mResultsPerPage);

	$this->mCurrentPage = floor($this->mStartIndex/$this->mResultsPerPage) + 1;

	# generate navigation links
	$vNextLimit = $this->mStartIndex + $this->mResultsPerPage;
	$vNext100Limit = $this->mStartIndex + 100;
	$vPrevLimit = $this->mResultsPerPage * (round($this->mStartIndex / $this->mResultsPerPage) - 1);
	$vPrev100Limit = 100 * (round($this->mStartIndex / 100) - 1);
	$vImage = new CImage("images/arrows/browse-arrow-left-on.gif");

	/* go back links */
	$vHref = new CHref($vUrl . "&start=$vPrevLimit"," Previous ".$this->mResultsPerPage." ");$vHref->setClass("navigation");
	$this->mPrevLink = $vHref->display();
	$this->mPrevLink = $vHref->mURL;
	$vHref = new CHref($vUrl . "&start=$vPrev100Limit"," Previous 100 ");$vHref->setClass("navigation");
//	$this->mPrev100Link = $vHref->display();
	$this->mPrevLink100 = $vHref->mURL;

	$vImage = new CImage("images/arrows/browse-arrow-left-off.gif");
	$vLabel = "<span class=\"disabled\"> Previous ".$this->mResultsPerPage."</span>";
	$vLabel2 = "<span class=\"disabled\"> Previous 100</span>";
	if ($this->mCurrentPage <= 1) {
//	  $this->mPrevLink = $vLabel;
	  $this->mPrevLink = "#self";
	  $this->mPrevLimit = 0;
	} else {
		$this->mPrevLimit = $vPrevLimit;
	}
	if ($this->mStartIndex - 100 < 0) {
//	  $this->mPrev100Link = $vLabel2;
	  $this->mPrev100Link = "#self";
	  $this->mPrev100Limit = 0;
	} else {
		$this->mPrev100Limit = $vPrev100Limit;
	}


	/* go fwd links */
	$vImage = new CImage("images/arrows/browse-arrow-right-on.gif");
	$vNextLimit = $this->mStartIndex + $this->mResultsPerPage;
	$vNext100Limit = $this->mStartIndex + 100;
	$vHref = new CHref($vUrl . "&start=$vNextLimit","Next ".$this->mResultsPerPage." ");$vHref->setClass("navigation");
//	$this->mNextLink = $vHref->display();
	$this->mNextLink = $vHref->mURL;
	$vHref = new CHref($vUrl . "&start=$vNext100Limit"," Next 100 ");$vHref->setClass("navigation");
//	$this->mNext100Link = $vHref->display();
	$this->mNext100Link = $vHref->mURL;

	$vImage = new CImage("images/arrows/browse-arrow-right-off.gif");
	$vLabel = "<span class=\"disabled\">Next ".$this->mResultsPerPage."</span>";
	$vLabel2 = "<span class=\"disabled\">Next 100</span>";
	if ($this->mCurrentPage >= $this->mTotalPages) {
	  $this->mNextLink = "#self";
	  $this->mNext100Link = "#self";
	  $this->mNextLimit = 0;
	} else {
		$this->mNextLimit = $vNextLimit;
	}

	if ($vNext100Limit >= $this->mResultsTotal) {
	  $this->mNext100Link = $vLabel2;
	  $this->mNext100Limit = 0;
	} else {
		$this->mNext100Limit = $vNext100Limit;
	}

	$vLabel = "<span style=\"color: #3300FF;\">Displaying " . (min($this->mResultsTotal,$this->mStartIndex + 1)) . " - " . min($this->mResultsTotal, $vNextLimit) . ' of ' . $this->mResultsTotal . "</span>";
	$this->mStatus = $vLabel;
	Return $rows;
  }


  /** comment here */
  function displayNavigation($position = "") {

	$this->newBlock("NAVIGATION$position");
	$this->assign("PREV_PAGE", $this->mPrevLink);
	$this->assign("PREV_PAGE100", $this->mPrev100Link);
	$this->assign("CURRENT_PAGE", $this->mCurrentPage);
	$this->assign("TOTAL_PAGES", intval($this->mTotalPages));
	$this->assign("NEXT_PAGE100", $this->mNext100Link);
	$this->assign("NEXT_PAGE", $this->mNextLink);
	$this->assign("RESULTS_PER_PAGE", $this->mResultsPerPage);
	$this->assign("TOTAL_RESULTS", $this->mResultsTotal);
//echo urlencode($this->mBaseUrl) . "&start=' + (".$this->mResultsPerPage . " * ";die;
	$this->assign("JUMPTO", $this->mBaseUrl . "&start=' + (".$this->mResultsPerPage . " * ");

	//if ($this->mResultsTotal < $this->mResultsPerPage) Return "";
	$start = max(1, $this->mCurrentPage - 3);
	$end = min($start + 5, $this->mTotalPages);
	for($i=$start; $i<=$end; $i++) {
		$this->newBlock("NAV_PAGE_$position");
		if ($i == $this->mCurrentPage) {
			$href = "<span style='color: #ff6600'>$i&nbsp;</span>";
		} else {
			$href = "<a href=\"".$this->mBaseUrl . "&start=".(($i-1) * $this->mResultsPerPage)."\">$i&nbsp;</a>";
		}
		$this->assign("PAGEID", $href);
	}


	$rows[0] = array($this->mPrev100Link, $this->mPrevLink, $this->mStatus, $this->mNextLink, $this->mNext100Link);
	$vTable = new CGridTable($rows);
	$vTable->loadTemplate("emptyGrid");
	$vTable->mTemplates["table"]["width"] = "100%";
	//$vTable->mTemplates["body"]["background-color"] = $this->mColLinkHover;
	$vTable->mTemplates["body"]["background-color"] = "#fafafa";
	$vTable->mTemplates["body"]["border-bottom"] = "#f6f6f6";
	$vTable->mTemplates["body"]["padding"] = "1px 4px 2px";
	$vTable->mTemplates["table"]["margin"] = "0px 0px 10px";
	$vTable->mTemplates["table"]["text-align"] = "center";
	$vTable->setColsAligns(array("left","left", "center", "right", "right"));
	$vTable->setColsWidths(array("15%","15%", "40%", "15%", "15%"));
	Return $vTable->display();
  }

  /** comment here */
  function displayAjaxNavigation($position = "") {

	$this->newBlock("NAVIGATION$position");
	$this->assign("PREV_PAGE", intval($this->mPrevLimit));
	$this->assign("PREV_PAGE100", intval($this->mPrev100Limit));
	$this->assign("CURRENT_PAGE", intval($this->mCurrentPage));
	$this->assign("TOTAL_PAGES", intval($this->mTotalPages));
	$this->assign("NEXT_PAGE100", intval($this->mNext100Limit));
	$this->assign("NEXT_PAGE", intval($this->mNextLimit));
	$this->assign("RESULTS_PER_PAGE", intval($this->mResultsPerPage));
	$this->assign("TOTAL_RESULTS", intval($this->mResultsTotal));

	$this->assign("JUMPTO", xmlentities($this->mBaseUrl . "&start=' + (".$this->mResultsPerPage . " * "));

	$start = max(1, $this->mCurrentPage - 3);
	$end = min($start + 5, $this->mTotalPages);
	for($i=$start; $i<=$end; $i++) {
		$this->newBlock("NAV_PAGE_$position");
		if ($i == $this->mCurrentPage) {
			$href = "<span style='color: #ff6600'>$i&nbsp;</span>";
		} else {
			$href = "<a href=\"".$this->mBaseUrl . "&start=".(($i-1) * $this->mResultsPerPage)."\">$i&nbsp;</a>";
		}
		$this->assign("PAGEID", ($i-1) * $this->mResultsPerPage);
		$this->assign("PAGELABEL", $i);
	}
//	$this->selectBlock("NAVIGTIONTOP");
  }

  /** comment here */
  function displayFastNavigation() {
	$vUrl = $this->mBaseUrl . "&".$this->mStartName."=";

	$vPageCount = 1 + floor(max($this->mResultsTotal - 1,0) / $this->mResultsPerPage);
	if ($vPageCount == 1) Return "";
	$vStartIndex = round($this->mStartIndex / $this->mResultsPerPage) + 1;

	$vStart = max($vStartIndex - 5, 1);
	$vEnd = min($vStartIndex + 5, $vPageCount);

	for($i=$vStart; $i <= $vEnd; $i++) {
	  if ($i != $vStartIndex) {
		$vNextLimit = ($i - 1) * $this->mResultsPerPage;
		$vHref = new CHref($vUrl . $vNextLimit, $i);
		$vHref->mTemplates["link"]["font-size"] = "8pt";
	  } else {
	  	$vHref = new CLabel($i);
		$vHref->mTemplates["label"]["font-size"] = "8pt";
		$vHref->mTemplates["label"]["font-weight"] = "bold";
		$vHref->mTemplates["label"]["color"] = "#000";
	  }
	  $vLinks[] = $vHref->display();
	}

	$vLastPage = new CHref($vUrl . ($this->mResultsPerPage * ($vPageCount-1)), $vPageCount);
	$vLastPage->setClass("smallBlack");
	$rows[0] = array(implode(",", $vLinks));
	if ($vEnd != $vPageCount) $rows[0][0] .= " ... " . $vLastPage->display();
	$vTable = new CGridTable($rows);
	$vTable->mTemplates["table"]["width"] = "100%";
	$vTable->mTemplates["table"]["text-align"] = "right";
	$vTable->mTemplates["breaker"]["padding"] = "5px 5px 5px 0";
	$vTable->mTemplates["breaker"]["font-weight"] = "normal";
	$vTable->mTemplates["breaker"]["font-size"] = "8pt";

	Return $vTable->display();
  }

}

?>
