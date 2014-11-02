<?php   				
/** CMetaTag
* @package html
* @since January 28
* @author cgrecu
*/


class CMetaTag extends CHtmlEntity{
  var $mTag;

  /** comment here */
  function CMetaTag($Key, $Value, $HttpEquiv = "", $Scheme = "") {
	$this->mTag = array($Key, $Value, $HttpEquiv, $Scheme);
  }

  /** comment here */
  function display() {
	$txt = '<META';
	if ($this->mTag[0]) $txt .= ' NAME="'.$this->mTag[0].'" ';
	if ($this->mTag[1]) $txt .= ' CONTENT="'.$this->mTag[1].'" ';
	if ($this->mTag[2]) $txt .= ' http-equiv="'.$this->mTag[2].'" ';
//	if ($this->mTag[3]) $txt .= ' http-equiv="'.$this->mTag[3].'" ';
	$txt .= '/>';
	Return $this->format($txt);
  }
}

?>
