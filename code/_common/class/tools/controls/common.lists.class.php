<?php   
	
	class CCommonList extends CSelect {

	  var $mType;
	  var $mParams;
	  
	  /** comment here */
	  function CCommonList($pName, $pType, $pParam1 = "", $pParam2 = "") {
	  	$this->CSelect($pName);
		$this->mType = $pType;
		$this->mParams = array($pParam1, $pParam2);
	  }

	  /** comment here */
	  function display() {
	  	switch($this->mType) {
	  		case "cl_months": $this->getMonthList();break;
	  		case "cl_years": $this->getYearList();break;
	  		case "cl_countries": $this->getCountryList();break;
	  		case "cl_continents": $this->getContinentList();break;
	  		case "cl_states": $this->getStateList();break;
	  		case "cl_cities": $this->getCitiesList();break;
	  		case "cl_referrals": $this->getReferralList();break;
	  		case "cl_groups": $this->getGroupsList();break;
	  		case "cl_status": $this->getStatusesList();break;
	  		case "cl_languages": $this->getLanguages();break;
	  		case "cl_timezones": $this->getTimeZones();break;
	  		case "cl_currency": $this->getCurrencies();break;
	  	}
		Return CSelect::display();
	  }

	  /** comment here */
	  function getMonthList() {
	  	$this->mOptions = array();
		$vDate = new CDateTime();
	  	foreach ($vDate->mMonths as $key=>$val) {
	  		$this->mOptions[] = array($key+1, $val);
	  	}
		if (!$this->mExtraOption) $this->mExtraOption = array("", "--Month--");
	  }

	  /** comment here */
	  function getYearList() {
	  	$this->mOptions = array();
		if ($this->mParams[0] <= $this->mParams[1]) 
		  for($i=$this->mParams[0]; $i<=$this->mParams[1]; $i++) {
			  $this->mOptions[] = array($i, $i);
		  }	  	
		else 
		  for($i=$this->mParams[0]; $i>=$this->mParams[1]; $i--) {
			  $this->mOptions[] = array($i, $i);
		  }	  	

		if (!$this->mExtraOption) $this->mExtraOption = array("", "--Year--");

	  }

	  /** comment here */
	  function getCountryList() {
		$this->mOptions = array();
		$filter = "";
		if ($this->mParams[0]) {
			if ($this->mParams[0] == "us_first") $filter = " Where CountryID not in (36, 203) ";
			if ($this->mParams[0] == "us_first") $this->mOptions[] = array("203", "United States");
			if ($this->mParams[0] == "us_first") $this->mOptions[] = array("36", "Canada");

			if ($this->mParams[0] == "ca_only") $this->mOptions[] = array("36", "Canada");
			if ($this->mParams[0] == "us_ca_only") $this->mOptions[] = array("203", "United States");
			if ($this->mParams[0] == "us_ca_only") $this->mOptions[] = array("36", "Canada");
		} else {
			$this->mOptions = array_merge($this->mOptions, $this->mDatabase->getAll2("select CountryID, CountryName from cms_countries $filter"));	
		}
		
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select Country --");
	  }

	  /** comment here */
	  function getContinentList() {
		$this->mOptions = array();
//		if ($this->mParams[0] == "us_first") $filter = " Where CountryID not in (36, 203) ";
//		if ($this->mParams[0] == "us_first") $this->mOptions[] = array("203", "United States");
//		if ($this->mParams[0] == "us_first") $this->mOptions[] = array("36", "Canada");
		$this->mOptions = array_merge($this->mOptions, $this->mDatabase->getAll2("select ID, Name from cms_continents $filter"));
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select Continent --");
	  }

	  /** comment here */
	  function getStateList() {
		$this->mOptions = array();
		if ($this->mParams[0] && intval($this->mParams[0]) == $this->mParams[0]) {
  		  $this->mOptions = $this->mDatabase->getAll2("select ID, Name from cms_states where countryid = '".addslashes($this->mParams[0])."' order by Name ASC");		
		}  else {
		  $this->mOptions[] = array("United States");
		  $this->mOptions = array_merge($this->mOptions, $this->mDatabase->getAll2("select ID, Name from cms_states where countryid = 203 order by Name ASC"));
		  if ($this->mParams[0] == "us_ca") {
			$this->mOptions[] = array("Canada");
			$this->mOptions = array_merge($this->mOptions, $this->mDatabase->getAll2("select ID, Name from cms_states where countryid = 36 order by Name Asc"));
		  }
		}
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select State --");
	  }

	  /** comment here */
	  function getCitiesList() {
		$this->mOptions = array();
		$where = "";
		if ($this->mParams[1]) $where[] = "stateid = '".addslashes($this->mParams[1])."' ";
		else {
		  if ($this->mParams[0]) $where[] = "countryid = '".addslashes($this->mParams[0])."' ";	
		}
		if ($where) $where = " where ".implode(" OR ", $where);
		$this->mOptions = $this->mDatabase->getAll2("select ID, Name from cms_cities $where order by Name ASC");		
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select City --");
	  }

	  /** comment here */
	  function getReferralList() {
		$this->getOptionsFromDb("cms_referrals", "Txt", "ID", "Order by Txt ASC");
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select From List --");
	  }

	  /** comment here */
	  function getGroupsList() {
		$this->getOptionsFromDb("cms_user_groups", "Txt", "ID", "Order by Txt ASC");
		if (!$this->mExtraOption) $this->mExtraOption = array("", "-- Select From List --");
	  }

	  /** comment here */
	  function getStatusesList() {
		$this->mOptions[] = array('', "--- please select ---");
		$this->mOptions[] = array('unconfirmed', "Not Confirmed");
		$this->mOptions[] = array('active', "Active User");
		$this->mOptions[] = array('idle', "Passive User (created without registration)");
		$this->mOptions[] = array('suspended', "Suspended User");
	  }

	  /** comment here */
	  function getLanguages() {
		$this->getOptionsFromDb("cms_languages", "Name", "ID", "where status='enabled' Order by Name ASC");
	  }

	  /** comment here */
	  function getTimeZones() {
		$this->getOptionsFromDb("cms_time_zones", "concat(Name, ' ', CommonPlaces) as Name", "ID", "where status='enabled' Order by Gap ASC");
	  }

	  /** comment here */
	  function getCurrencies() {
		$this->getOptionsFromDb("cms_currencies", "Name", "ID", "where status='enabled' Order by Name ASC");
	  }

}

?>