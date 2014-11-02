<?php   
/** CJavaScript
* @package Other
* @since March 12
* @author cgrecu
*/


class CJavaScript {
  
  var $mJavaScript;

  /** sets the javascript property (javascript linked to html elements) */
  function setJavaScript($pEvent, $pScript) {
  	$this->mJavaScript[$pEvent][] = $pScript;
  }
  
  function addJavaScript($pEvent, $pScript) {
	$pEvent = strtolower($pEvent);
	$tmp = isset($this->mJavaScript[$pEvent])?$this->mJavaScript[$pEvent]:array();
  	$this->mJavaScript[$pEvent] = array();
	$this->mJavaScript[$pEvent][] = $pScript;
	if (empty($tmp)) Return 1;
	foreach ($tmp as $key=>$val) {
	  $this->mJavaScript[$pEvent][] = $val;
	}
  }

  function display() {
	$tmp = "";
	if (!(empty($this->mJavaScript))) {
	  foreach ($this->mJavaScript as $key=>$val) {
		$tmp .= " $key=\"";
		foreach ($val as $key2=>$val2) {
			$tmp .= $val2;
		}
		$tmp .= "\"";
	  }
	}
	$tmp .= " ";
	Return $tmp;
  }

}

?>
