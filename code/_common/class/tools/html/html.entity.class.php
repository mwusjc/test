<?php   
/** Html entities
* @package HTML
* @since February 06
* @author cgrecu
*/
class CHtmlEntity extends CObject{

  var $mID;
  var $mName;
  var $mClassName = "";
  var $mStyle;
  var $mJavaScript;
  var $mTitle;
  var $mTabIndex;
  var $mAlign;
  var $mVAlign;
  var $mElementIndex = "";
  
  /** constructor */
  function CHtmlEntity() {
	$this->CObject();
	$this->mFullLinks = $this->mFullLinksMode;

  }
  
  /** sets the name property */
  function setName($pName) {
  	$this->mName = $pName;
	if (!$this->mID) $this->mID = $pName;
  }

  /** sets the ID property */
  function setID($pID) {
  	$this->mID = $pID;
	if (!$this->mName) $this->setName($pID);
  }
  
  /** sets the style property directly*/
  function setStyle($pStyle) {
  	$this->mStyle = $pStyle;
  }

  /** comment here */
  function setClass($pClass) {
  	$this->mClassName = $pClass;
  }

  /** returns a string with common element attributes:title, class, style, javascript */
  function addCommonAttributes() {
	$tmp = "";
	if ($this->mName && !$this->mID) $this->mID = $this->mName;
	if ($this->mID)	  $tmp .= " id=\"$this->mID\" ";
	if ($this->mTabIndex)	  $tmp .= " tabindex=\"$this->mTabIndex\" ";
  	if ($this->mTitle)	  $tmp .= " title=\"$this->mTitle\" ";
	if ($this->mClassName)	  $tmp .= " class=\"$this->mClassName\" ";
	if ($this->mStyle)	  $tmp .= " style=\"$this->mStyle\" "; 
	if ($this->mAlign)	  $tmp .= " align=\"$this->mAlign\" "; 
	if ($this->mVAlign)	  $tmp .= " valign=\"$this->mVAlign\" "; 

	$tmp .= $this->displayJavaScript();

  	Return $tmp;
  }

  /** comment here */
  function generate() {
	  $this->assign($this->mName."_ID", $this->mID.$this->mElementIndex);
	  $this->assign($this->mName."_NAME", $this->mName.$this->mElementIndex);
	  if ($this->mClassName) $this->assign($this->mName."_CLASS", $this->mClassName);
	  if ($this->mStyle) $this->assign($this->mName."_STYLE", $this->mStyle);
  }

  /** comment here */
  function display() {
  	$this->error("html entity display method MUST be overwritten", 1);
  }

  /** comment here */
  function format($pTxt) {
  	Return $pTxt;
  }

  /** sets the javascript property (javascript linked to html elements) */
  function setJavaScript($pEvent, $pScript) {
	if (!(is_object($this->mJavaScript))) $this->mJavaScript = new CJavaScript();
  	$this->mJavaScript->setJavaScript($pEvent, $pScript);
  }
  
  function addJavaScript($pEvent, $pScript) {
	if (!(is_object($this->mJavaScript))) $this->mJavaScript = new CJavaScript();
	$tmp = $this->mJavaScript->addJavaScript($pEvent, $pScript);
  }

  /** comment here */
  function displayJavaScript() {
  	if (is_object($this->mJavaScript)) Return $this->mJavaScript->display();
	Return "";
  }


}

?>