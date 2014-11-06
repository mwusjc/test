<?php

	class CCanadaGPS extends CDBObject {

		/** comment here */
		function CCanadaGPS() {
			$this->CDBObject();
		}

		/** comment here */
		function getDistance($from, $to) {
			$from = strtoupper(str_replace(" ", "", trim($from)));
			$to = strtoupper(str_replace(" ", "", trim($to)));
			$a = substr($from,0,3) . " ". substr($from, 3);
			$b = substr($to,0,3) . " ". substr($to, 3);
			$sql = "select PostCode as ID, Latitude, Longitude from	masterdb.cms_postcodes where postcode in ('".addslashes($a)."','".addslashes($b)."')";
			$data = $this->mDatabase->getAllAssoc($sql);
			if (empty($data)) Return 100000000;
			if (count($data) == 1 and $a != $b) Return 100000000;
			$ret = 1.609344 * 3958.75 * acos(  sin($data[$a]["Latitude"]/57.2958) * sin($data[$b]["Latitude"]/57.2958) + cos($data[$a]["Latitude"]/57.2958) * cos($data[$b]["Latitude"]/57.2958) * cos($data[$b]["Longitude"]/57.2958 - $data[$a]["Longitude"]/57.2958));
			Return $ret;
		}

		/** comment here */
		function getCoordinates($zip) {
			$zip = strtoupper(str_replace(" ", "", trim($zip)));
			$a = substr($zip,0,3) . " ". substr($zip, 3);
			$sql = "select Latitude, Longitude from	masterdb.cms_postcodes where postcode in ('".$a."','".$b."')";
			$data = $this->mDatabase->getRow($sql);
			if (empty($data)) Return "";
			Return $data["Latitude"] . ",". $data["Longitude"];
		}

	}

?>