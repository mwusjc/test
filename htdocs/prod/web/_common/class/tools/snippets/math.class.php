<?php   
/** some math functions
* @package Other
* @since 4/16/2004
* @author Son Nguyen
*/
class CMath {
	/* constructor */
	function CMath() {
	}

	/** calculate the percentage */
	function getPercentage($pOne,$pTotal) {
		$vPercent = ($pTotal!=0)?($pOne/$pTotal)*100:0;
		return number_format($vPercent,2).'%';
	}


}

?>
