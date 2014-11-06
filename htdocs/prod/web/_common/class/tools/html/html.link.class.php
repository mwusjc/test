<?php   
/** link in header
* @package HTML
* @since February 06
* @author cgrecu
*/


class CLink {
  
  var $mURL;
  var $mType;

  /** constructor */
  function CLink($pURL, $pType = "text/css") {
	$this->mURL = $pURL;
	$this->mType = $pType;
  }

  /** create html code for a link */
  function display() {
  	Return "<link rel=\"stylesheet\" type=\"$this->mType\" href=\"".$this->mURL."\"/>\n\n";
  }
}

?>
