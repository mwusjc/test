<?php   
/** element in a form, a base class to be extended
* @package HTML
* @since February 06
* @author cgrecu
*/


class CFormElement extends CHtmlEntity {

  var $mEnabled;
  var $mReadOnly;
  var $mAccessKey;
  var $mTabIndex;
  var $mLabel;
  var $mLabelAlign;
  var $mLabelAttach;
  var $mAlign;
  var $mExample;
  var $mValidateMe = false;//by default all fields are NOT validated;
  var $mValidateForEmpty = true;
  var $mValidateType = true;
  var $mValidationScript = "";
  var $mAllowedValues;
  var $mNullValue = "";
  var $mRequiredFlag = false;

  var $mErrorEmptyMsg = "Please fill all required fields!"; //error to be displayed if field is empty (at submit time)
  var $mErrorInvDataTypeMsg = "Not a numberic value"; // error to be displayed if field has invalid datatype
  var $mErrorInvDataRange = "Input value not in range!";

  /** constructor */
  function CFormElement() {
	 $this->CHtmlEntity();
  }
  
  /** sets the disabled property (if parameter is not null then actually the element will be disabled) */
  function setEnabled($pEnabled) {
  	$this->mEnabled = $pEnabled;
  }
  
  /** sets the read only property */
  function setReadOnly($pReadOnly) {
  	$this->mReadOnly = $pReadOnly;
  }
  
  /** sets the access key property */
  function setAccessKey($pAccessKey) {
  	$this->mAccessKey = $pAccessKey;
  }

  /** sets the tab index property */
  function setTabIndex($pTabIndex) {
  	$this->mTabIndex = $pTabIndex;
  }

  /** sets the label property */
  function setLabel($pLabel) {
  	$this->mLabel = $pLabel;
  }

  /** comment here */
  function generate() {
	CHtmlEntity::generate();
  	if ($this->mEnabled) $this->assign($this->mName."_ENABLED", " disabled=\"disabled\" ");
	if ($this->mReadOnly) $this->assign($this->mName."_READONLY", " readonly=\"readonly\" ");
	if ($this->mAccessKey) $this->assign($this->mName."_ACCESSKEY", " accesskey=\"$this->mAccessKey\" "); 
  }

  /** comment here */
  function display() {
  	$this->error("form element display method MUST be overwritten", 1);
  }
  
  /** comment here */
  function setAllowedValues($pValues) {
	$this->mAllowedValues = $pValues;
  }

  /** creates a string with all set attributes for appending to the form element */
  function addFormAttributes() {
	$tmp = "";
  	if ($this->mEnabled) 	$tmp .= " disabled=\"disabled\" ";
	if ($this->mReadOnly) $tmp .= " readonly=\"readonly\" ";
	if ($this->mAccessKey) $tmp .= " accesskey=\"$this->mAccessKey\" "; 
	if ($this->mTabIndex) $tmp .= " tabindex=\"$this->mTabIndex\" ";
  	Return $tmp;
  }

}

?>
