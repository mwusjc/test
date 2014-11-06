<?php   
  
  class CCurrency extends CCore {
  	
	/** comment here */
	function CCurrency() {
		
	}

  /** comment here */
  function getCurrencyRate($pFrom, $pTo) {
	  $pFrom = strtoupper($pFrom);
	  $pTo = strtoupper($pTo);
	  $countries = $this->mDatabase->getAll("select CountryCode, CountryName from cms_geo_countries where CountryCode in ('$pFrom', '$pTo')");
	  foreach ($countries as $key=>$val) {
		if ($pFrom == $val["CountryCode"]) $pFrom = strtolower($val["CountryName"]);
		if ($pTo == $val["CountryCode"]) $pTo = strtolower($val["CountryName"]);
	  }
	  $soapclient = new soapclient("http://www.xmethods.net/sd/2001/CurrencyExchangeService.wsdl", true);
	  $params = array(
		"country1" => $pFrom,
		"country2" => $pTo
	  );
	  // invoke the method
	  $result = $soapclient->call("getRate",$params);
	  Return $result;
  }

    /** comment here */
  function getCurrencyRate2($pFrom, $pTo) {
	  $pFrom = strtoupper($pFrom);
	  $pTo = strtoupper($pTo);
	  switch($pFrom) {
	  	case "CAD":$pFrom = "canada";break;
		case "USD":$pFrom = "usa";break;
	  }
	  switch($pTo) {
	  	case "CAD":$pTo = "canada";break;
		case "USD":$pTo = "usa"; break;
	  }
	  $soapclient = new soapclient("http://www.xmethods.net/sd/2001/CurrencyExchangeService.wsdl", true);
	  $params = array(
		"country1" => $pFrom,
		"country2" => $pTo
	  );

	  // invoke the method
	  $result = $soapclient->call("getRate",$params);
	  Return $result;
  }
  
  }


?>