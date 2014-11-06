<?php
/** html <Body>
* @package HTML
* @since February 06
* @author cgrecu
*/


class CBody extends CHtmlEntity{

  var $mText;
  var $mEmailText;
  var $mLink;
  var $mVLink;
  var $mALink;
  var $mStyle;
  var $mTemplates;
  var $mClass = "";
  /** constructor */

  function CBody() {
	$this->mText = "";
  }

  /** comment here */
  function setText($Text) {
  	$this->mText = $Text;
  }


  /** comment here */
  function display($pEmail = false) {
//	  $this->mJavaScript .= " onload=\"loadMenu2();\" ";
  	$txt = "<body ";
	if ($this->mClass) $txt .= " class=\"".$this->mClass."\" ";
	 $txt .= "id=\"body\" " . $this->mJavaScript . " >\n\n" . $this->mText . "</body>";
	Return $txt;
  }



}

?>
