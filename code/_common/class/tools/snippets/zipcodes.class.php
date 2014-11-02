<?php   
/** CZip
* @package misc
* @since February 06
* @author cgrecu
*/


class CZip extends CGlobals{
  
  /** comment here */
  function CZip() {
	$this->CGlobals();  	
  }

  /** comment here */
  function getDistance($pZip1, $pZip2) {
	$vData = $this->mDatabase->getAll2("select lon, lat, zip from cms_geo_zipcodes where zip in ('$pZip1', '$pZip2')");  	
	Return $vDistance = $this->distance($vData[0][1], $vData[0][0],$vData[1][1], $vData[1][0],"k");
  }

  /** comment here */
  function distance($lat1, $lon1, $lat2, $lon2, $unit) { 

	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	$dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if ($unit == "K") {
	  return ($miles * 1.609344); 
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	  } else {
		  return $miles;
		}
  }

}

?>
