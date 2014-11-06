<?php   
/** CDateTime
* @package misc
* @since May 11
* @author cgrecu
*/


class CDateTime {
  
  var $mDaysDiff;
  var $mHrsDiff;
  var $mMinsDiff;
  var $mSecsDiff;
  var $mDiff;
  var $mMonths = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

  /** comment here */
  function dateDiff($pStart, $pEnd = 0) {
  	if ($pEnd == 0) $pEnd = time();
	$vTimeRemain = max(0,$pEnd - $pStart);
	$this->mDiff = $vTimeRemain;
	if ($vTimeRemain < 0) Return "Time expired";
	$vDays = floor($vTimeRemain / 84600); $vTimeRemain = ($vTimeRemain - $vDays * 84600); 
	$vHours = floor($vTimeRemain / 3600); $vTimeRemain = ($vTimeRemain - $vHours * 3600); 
	$vMins = floor($vTimeRemain / 60); $vSeconds = ($vTimeRemain - $vMins * 60); 
	$vTimeString = "$vDays days, $vHours hours, $vMins minutes, $vSeconds seconds";
	$this->mDaysDiff = $vDays;
	$this->mHrsDiff = $vHours;
	$this->mMinsDiff = $vMins;
	$this->mSecsDiff = $vSeconds;
	Return $vTimeString;

  }

  function dateDiffShort($pStart, $pEnd = 0) {
  	if ($pEnd == 0) $pEnd = time();
	$vTimeRemain = max(0,$pEnd - $pStart);
	$this->mDiff = $vTimeRemain;
	if ($vTimeRemain < 0) Return "Time expired";
	$vDays = floor($vTimeRemain / 84600); $vTimeRemain = ($vTimeRemain - $vDays * 84600); 
	$vHours = floor($vTimeRemain / 3600); $vTimeRemain = ($vTimeRemain - $vHours * 3600); 
	$vMins = floor($vTimeRemain / 60);
	
	$vTimeString1 = $vDays."d ". $vHours ."h ".$vMins."m";
	$vTimeString2 = $vDays."d, ". $vHours ."h ";
	$vTimeString3 = $vHours ."h, ".$vMins."m";

	$this->mDaysDiff = $vDays;
	$this->mHrsDiff = $vHours;
	$this->mMinsDiff = $vMins;
	if ($vDays) Return $vTimeString2; else Return $vTimeString3;
	Return $vTimeString;
  }

  /** comment here */
  function makeDate($pDay, $pMonth, $pYear) {
	Return strtotime($pYear . "-" . $pMonth . "-".$pDay);		
  }


  /** comment here */
  function getStringTime($pSeconds) {
	if ($pSeconds < 3600) Return floor($pSeconds/60) . " minutes";
	if ($pSeconds < 86400) {
	  $vHrs = floor($pSeconds/3600);
	  $vMins = floor(($pSeconds - 3600*$vHrs)/60);
	  Return str_pad($vHrs,2, "0", STR_PAD_LEFT) . ":" . str_pad($vMins,2, "0", STR_PAD_LEFT);
	}
	$vDays = floor($pSeconds/86400);
	Return "$vDays days";
	$vHours = floor(($pSeconds - $vDays * 86400)/3600);
	Return "$vDays days $vHours hours";
  }

}

?>
