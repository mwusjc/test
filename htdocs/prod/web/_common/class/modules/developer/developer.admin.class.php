<?php   
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CDeveloperAdmin extends CSectionAdmin{
   
  /** comment here */
  function CDeveloperAdmin() {
	$this->CSectionAdmin();  
  }

  /** comment here */
  function registerClasses() {
	$this->mClasses[] = array("Developers", "");
  }


  /** comment here */
  function display() {

	$sql = "select cast(a.PageID as char(20)) as ID, PageSize, NumSecs, NumQueries, Request, RemoteIP, TimeStamp ".
			  "	 from cms_log_pages a where 1=1  ".
			  "	 ORDER BY a.TimeStamp DESC";
	$vSmart = new CSmartTable("", $sql);
	$vSmart->mItemsPerPage = 10;
	$vSmart->setIcons(array("view","list"));
	$vSmart->mShowToggle = false;

	$vSmart->addHeader(array("TimeStamp", "Request", "NumSecs", "PageSize", "RemoteIP"));
	$vSmart->addDField("TimeStamp", "M.d.Y H:i");
	$vSmart->addLkField($this->getBaseLink() . "view&id=##ID##", "ID", "##Request##", "Request");
	$vSmart->addField("NumSecs");
	$vSmart->addField("PageSize");
	$vSmart->addField("RemoteIP");

//	$vSmart->addTFilter("a.Name", "Search", 1);
////	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "Developer Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_Developer_groups order by Txt ASC"), 1);

	$vSmart->mColsWidths = array("10px", "110px", "400px", "50px", "50px", "70px", "50px");
	$vSmart->mColsAligns = array("center", "left", "left", "left", "left", "left", "right");
	Return $vSmart->display();
  }

  /** comment here */
  function displayItem($pID) {
	$sql = "select a.QueryID as ID, a.QueryStr, NumSecs, FileTrace, TimeStamp ".
			  "	 from cms_log_queries a where PageID = '$pID' ".
			  "	 ORDER BY a.TimeStamp DESC";
	$vSmart = new CSmartTable("", $sql);
	$vSmart->mItemsPerPage = 100;
	$vSmart->setIcons(array("view"));
	$vSmart->mShowToggle = false;

	$vSmart->addHeader(array("TimeStamp", "Query", "NumSecs"));
	$vSmart->addDField("TimeStamp", "H:i:s");
//	$vSmart->addLkField($this->getBaseLink() . "view&id=##ID##", "ID", "##Request##", "Request");
	$vSmart->addField("QueryStr");
	$vSmart->addField("NumSecs");
//	$vSmart->addField("RemoteIP");

//	$vSmart->addTFilter("a.Name", "Search", 1);
////	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "Developer Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_Developer_groups order by Txt ASC"), 1);

	$vSmart->mColsWidths = array("10px", "110px", "550px", "50px", "30px");
	$vSmart->mColsAligns = array("center", "left", "left",  "left", "right");
	Return $this->display() . $vSmart->display();
  }

  /** comment here */
  function displayErrors($pID) {
	$sql = "select a.ID as ID, a.Error, Severity,  TimeStamp ".
			  "	 from cms_log_errors a where PageID = '$pID' ".
			  "	 ORDER BY a.TimeStamp DESC";
	$vSmart = new CSmartTable("", $sql);
	$vSmart->mItemsPerPage = 100;
	$vSmart->setIcons(array("view"));
	$vSmart->mShowToggle = false;

	$vSmart->addHeader(array("TimeStamp", "Error", "Severity"));
	$vSmart->addDField("TimeStamp", "H:i:s");
//	$vSmart->addLkField($this->getBaseLink() . "view&id=##ID##", "ID", "##Request##", "Request");
	$vSmart->addField("Error");
	$vSmart->addField("Severity");
//	$vSmart->addField("RemoteIP");

//	$vSmart->addTFilter("a.Name", "Search", 1);
////	$vSmart->addTFilter("ProductCode", "Product Code", 1);
//	$vSmart->addLFilter("a.GroupID", "Developer Group", $this->mDatabase->getAll2("select ID, Txt AS Category from cms_Developer_groups order by Txt ASC"), 1);

	$vSmart->mColsWidths = array("10px", "110px", "550px", "50px", "30px");
	$vSmart->mColsAligns = array("center", "left", "left",  "left", "right");
	Return $this->display() . $vSmart->display();  	
  }




/***********************************************************************************************************
****	  END OF TEMPLATE FUNCTIONS - CONTINUE WITH SPECIAL FUNCTIONS									****
***********************************************************************************************************/


  /** comment here */
  function mainSwitch() {
	$GLOBALS["vBenchmark"]->mStopLogging = true;
	switch($this->mOperation) {
	  case "list":
		Return $this->displayErrors($pID);
		default:
		  Return CSectionAdmin::mainSwitch();
	}  	
  }
}

?>
