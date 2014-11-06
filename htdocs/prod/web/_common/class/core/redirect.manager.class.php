<?php   
/** some function with redirect
* @package Other
* @since 6/18/2004
* @author Son Nguyen
*/
class CRedirectManager {
	
	var $mLinks; // array

	/* constructor */
	function CRedirectManager() {
		$this->_init();
	}
	
	/** init the array */
	function _init() {
	  if (!isset($_SESSION["gRedirect"])) $_SESSION["gRedirect"] = array();
	  $this->mLinks = $_SESSION["gRedirect"];
	}
	
	/** init the array */
	function reset() {
	  $_SESSION["gRedirect"] = array();
	  $this->mLinks = array();
	}
	
	/** save it */
	function _finalize() {
	  $_SESSION["gRedirect"] = $this->mLinks;
	}

	/** push redirect */
	function push($pLink) {
	  $this->mLinks[] = $pLink;
	}

	/** pop redirect */
	function pop() {
	  return array_pop($this->mLinks);
	}

	/** comment here */
	function read() {
		Return $this->mLinks[count($this->mLinks)-1];
	}
}

?>