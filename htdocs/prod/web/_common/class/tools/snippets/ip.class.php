<?php   
/** some function with IPs
* @package Other
* @since 6/8/2004
* @author Son Nguyen
*/
class CIPManager extends CGlobals {
	/* constructor */
	function CIPManager($pIP = "") {
		$this->CGlobals();
		if ($pIP) $this->mIP = $pIP; else $this->mIP = $_SERVER['REMOTE_ADDR'];
		
	}

	/** use ip2location db, note: when test offline, no country will be detected */
	function ip2CountryID() {
		$vIPStr = sprintf("%u",ip2long($this->mIP));
		return $this->mDatabase->getValue("cms_geo_countries c,cms_geo_ipcountry ip",'c.CountryID',"ip.countrySHORT=c.CountryCode AND ($vIPStr BETWEEN ip.ipFROM AND ip.ipTO)");
	}

	
	function getLocation2() {
		$vIPStr = $this->mIP;
		return $this->mDatabase->getRow("select c.CountryID, ip.ipCITY, ip.ipREGION FROM cms_geo_countries c, cms_geo_ipcountry ip WHERE ip.countrySHORT=c.CountryCode AND ($vIPStr BETWEEN ip.ipFROM AND ip.ipTO)");
	}
	
	/** comment here */
	function getLocation() {
		$vIPStr = sprintf("%u",ip2long($this->mIP));
		return $this->mDatabase->getRow("select c.CountryID, ip.ipCITY, ip.ipREGION FROM cms_geo_countries c, cms_geo_ipcountry ip WHERE ip.countrySHORT=c.CountryCode AND ($vIPStr BETWEEN ip.ipFROM AND ip.ipTO)");
	}

	/** country flag for this ip */
	function getFlag() {
		$vIPStr = sprintf("%u",ip2long($this->mIP));
		$vCode = $this->mDatabase->getValue("cms_geo_ipcountry ip",'countrySHORT',"$vIPStr BETWEEN ipFROM AND ipTO");
		$vCode = strtolower($vCode);
		$vHost = gethostbyaddr($pIP);
		if (strlen($vCode)==2) {
			$vImg = new CImage('images/flags/'.$vCode.'.gif');
			$vImg->mTitle = "$vHost ($pIP)";
			$vImg = $vImg->display();	
		} else {
			$vImg = '&nbsp;';
		} // else
		return $vImg;
	}

	/** comment here */
	function getCountry($pCountryID) {
	  Return $this->mDatabase->getValue("cms_geo_countries", "CountryName", "CountryID='$pCountryID'");  	
	}

	/** comment here */
	function getCountryID($pCountryName) {
	  Return $this->mDatabase->getValue("cms_geo_countries", "CountryID", "CountryName='$pCountryName'");  	
	}

}

?>
