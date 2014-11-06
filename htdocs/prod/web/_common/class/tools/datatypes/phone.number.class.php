<?php   
/** 
* @author cgrecu
*/


class CPhoneNumber {
  
  var $pNumber;

  /** comment here */
  function CPhoneNumber($pNumber) {
  	$this->mPhoneNumber = $pNumber;
  }

  /** comment here */
  function convertToPhone($pPhoneIn) {
	$txt = "";
	for($i=0; $i<strlen($pPhoneIn); $i++) {
	  $x = substr($pPhoneIn, $i, 1);
	  if (is_numeric($x)) $txt .= $x;
	}  	
	if (strlen($txt) == 10) Return ereg_replace("([0-9]{3})([0-9]{3})([0-9]{4})", "(\\1) \\2-\\3", $txt);   
	if (strlen($txt) == 11 && substr($txt,0,1) == 1) Return ereg_replace("([0-9]{3})([0-9]{3})([0-9]{4})", "(\\1) \\2-\\3", substr($txt, 1, 10));   
	Return $txt;
  }

  function formatPhoneNumber($sPhone, $sCountry = 'US', $bInternationalFormat = false)  {
	 if (empty($sPhone)
		 || !trim($sPhone)) {
		return $sPhone;
	 }

	 // Supported list of country phone format
	 // Country code => International phone code
	 $aCountries = array(
		'CA' => '1',      // Canada
		'FR' => '33',     // France
		'AI' => '1-264',  // Anguilla
		'AG' => '1-268',  // Antigua/Barbuda
		'BS' => '1-242',  // Bahamas
		'BB' => '1-246',  // Barbados
		'BM' => '1-441',  // Bermuda
		'CA' => '1',      // Canada
		'KY' => '1-345',  // Cayman Islands
		'DM' => '1-767',  // Dominica
		'DO' => '1-809',  // Dominican Republic
		'GD' => '1-473',  // Grenada
		'GU' => '1-671',  // Guam
		'JM' => '1-876',  // Jamaica
		'MS' => '1-664',  // Montserrat
		'MP' => '1-670',  // Northern Mariana Islands
		'PR' => array('1-787', '1-939'),  // Puerto Rico
		'KN' => '1-869',  // Saint Kitts and Nevis
		'LC' => '1-758',  // Saint Lucia
		'VC' => '1-784',  // Saint Vincent and the Grenadines
		'TT' => '1-868',  // Trinidad and Tobago
		'TC' => '1-649',  // Turks and Caicos Islands
		'US' => '1',      // United States of America
		'VG' => '1-284',  // Virgin Islands (British)
		'VI' => '1-340'   // Virgin Islands (U.S.)
	   );

	 if (!isset($aCountries[$sCountry])) {
		return $sPhone;
	 }

	 // Get rid of parenthesis, dashes, plus and dot signs,
	 // then remove any spaces before numbers,
	 // and remove duplicate "white spaces".
	 $sFormatted = str_replace(array('+', '(', ')', '-', '.', '/'), '', trim($sPhone));
	 $sFormatted = preg_replace(array('/\s+([0-9])/', '/\s+/'), array('\1', ' '), $sFormatted);
	 list($sFormatted, $sExt) = explode(' ', $sFormatted, 2);

	 $iLen = strlen($sFormatted);
	 $iCountryCode = $aCountries[$sCountry];

	 // Deal with the primary phone number part based on the country
	 switch ($sCountry) {
  /*    case 'CA': See 'US'  */

		case 'FR':
		   // International format: +33 (0)1 23 45 67 89
		   // National format: (0)1 23 45 67 89
		   // Toll number format: 0800 12 34 56
		   //                     08 36 12 34 56
		   switch ($iLen) {
			  case 10:
				 // Numeros Vert, Azur & Indigo
				 $aNumerosSpeciaux = array('0800', '0801', '0802', '0803');
				 $sIndicatif = substr($sFormatted, 0, 4);
				 if (in_array($sIndicatif, $aNumerosSpeciaux)) {
					// Appels internationaux impossible (?)
					$bInternationalFormat = false;
					$sFormatted = $sIndicatif . ' ' . substr($sFormatted, 4, 2) . ' ' . substr($sFormatted, 6, 2) . ' ' . substr($sFormatted, -2);

				 } elseif ($sIndicatif == '0836' && !$bInternationalFormat) {
					// Numeros Kiosque sont traites normalement a
					// l'international, mais en France the zero n'est pas mis
					// entre parentheses
					$sFormatted = substr($sFormatted, 0, 2) . ' ' . substr($sFormatted, 2, 2) . ' ' . substr($sFormatted, 4, 2) . ' ' . substr($sFormatted, 6, 2) . ' ' . substr($sFormatted, -2);

				 } else {
					$sFormatted = '(' . substr($sFormatted, 0, 1) . ')' . substr($sFormatted, 1, 1) . ' ' . substr($sFormatted, 2, 2) . ' ' . substr($sFormatted, 4, 2) . ' ' . substr($sFormatted, 6, 2) . ' ' . substr($sFormatted, -2);
				 }
				 break;

			  case 9:
				 $sFormatted = '(0)' . substr($sFormatted, 0, 1) . ' ' . substr($sFormatted, 1, 2) . ' ' . substr($sFormatted, 3, 2) . ' ' . substr($sFormatted, 5, 2) . ' ' . substr($sFormatted, -2);

			  default:
				 // Any other unrecognized phone numbers are return as
				 // they were passed.
				 return $sPhone;
		   }
		   break;
		   // End [CASE] FR / France

		// The following countries are folded into the US numbering plan
		case 'AI':  // Anguilla
		case 'AG':  // Antigua/Barbuda
		case 'BS':  // Bahamas
		case 'BB':  // Barbados
		case 'BM':  // Bermuda
		case 'CA':  // Canada
		case 'KY':  // Cayman Islands
		case 'DM':  // Dominica
		case 'DO':  // Dominican Republic
		case 'GD':  // Grenada
		case 'GU':  // Guam
		case 'JM':  // Jamaica
		case 'MS':  // Montserrat
		case 'MP':  // Northern Mariana Islands
		case 'PR':  // Puerto Rico
		case 'KN':  // Saint Kitts and Nevis
		case 'LC':  // Saint Lucia
		case 'VC':  // Saint Vincent and the Grenadines
		case 'TT':  // Trinidad and Tobago
		case 'TC':  // Turks and Caicos Islands
		case 'VG':  // Virgin Islands (British)
		case 'VI':  // Virgin Islands (U.S.)

		case 'US':  // United States of America
		   // National format: (123) 456-7890
		   // International format: +1 (1) 123-456-7890
		   // Toll number format: 1-800-123-4567
		   if ($iLen == 11) {
			  $sFormatted = substr($sFormatted, 1);
			  $iLen = 10;
		   }
		   switch ($iLen) {
			  case 7:
				 // Local number
				 // Note: International number format cannot
				 //       be used for US and Canada
				 $sFormatted = substr($sFormatted, 0, 3) . '-' . substr($sFormatted, -4);
				 $bInternationalFormat &= ($sCountry != 'US' && $sCountry != 'CA');
				 break;

			  case 10:
				 // Full number
				 // Toll phone area codes
				 $aTollAreaCodes = array(800, 866, 877, 888, 855, 844, 833, 822, 900, 880, 881, 882, 883);
				 $sAreaCode = substr($sFormatted, 0, 3);

				 // Countries using the US phone numbering system
				 // use the code area as country code, so we "reset"
				 // the country code to "1" for phone numbers already including
				 // the area code.
				 $iCountryCode = '1';

				 if (in_array((int) $sAreaCode, $aTollAreaCodes)) {
					// Note: International format cannot be supported here
					//       for toll numbers.
					$sFormatted = '1-' . $sAreaCode . '-' . substr($sFormatted, 3, 3) . '-' . substr($sFormatted, -4);
					$bInternationalFormat = false;

				 } elseif ($bInternationalFormat) {
					$sFormatted = '(1) ' . $sAreaCode . '-' . substr($sFormatted, 3, 3) . '-' . substr($sFormatted, -4);

				 } else {
					$sFormatted = '(' . $sAreaCode . ') ' . substr($sFormatted, 3, 3) . '-' . substr($sFormatted, -4);
				 }
				 break;

			  default:
				 // Any other unrecognized phone numbers are return as
				 // they were passed.
				 return $sPhone;

		   } // End [SWITCH] on length of number
		   break;
		   // End [CASE] US & Canada (CA)

	 } // End [SWITCH] on country code


	 // Prepend with the country code and append extension if needed.
	 return (($bInternationalFormat) ? '+' . $iCountryCode . ' ' : '') . $sFormatted . (($sExt) ? ' ' . $sExt : '');

  }

}

?>