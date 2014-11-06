<?php   
/** CHTMLList
* @package html
* @since January 07
* @author cgrecu
*/


class CHTMLList extends CHtmlEntity {

  /** comment here */
  function CHTMLList($pElements, $pType = "ul") {
	$this->CHtmlEntity();
	$this->mElements = $pElements;
	$this->mType = $pType;
  }

  /** comment here */
  function display() {
	$text = "<ul>";
	foreach ($this->mElements as $key=>$val) {
	  $text .= "<li>" . $val . "</li>";		
	}	
	$text .= "</ul>";
	Return $text;
  }


}

?>
