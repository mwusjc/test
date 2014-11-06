<?php 
/** form generator
* @package HTML
* @since February 06
* @author cgrecu
*/


class CForm extends CHtmlEntity {

  var $mAction = "";
  var $mTarget = "";
  var $mMethod = "POST";
  var $mValidationScript = "";
  var $mEncType;
  var $mSubmitButton = "";

  var $mElements = array(); //this array will contain all inner elements
  var $mBlocks;

  var $mHelpIDs = array();

  /** constructor */
  function CForm ($pName, $pAction = "") {
	$this->CHtmlEntity();
	$this->setName($pName);
	if ($pAction != "#" && $pAction) $this->mAction = $pAction;

  }

  function setMethod($pMethod) {
	$this->mMethod = $pMethod;
	$this->mTxt = $this->openForm();
  }

  function setEncType($pEncType = "multipart/form-data") {
	$this->mEncType = $pEncType;
  }

  function addToScript($pCode) {
  	$this->mValidationScript .= $pCode;
  }

  /** return the validation function name **/
  function setValidateCommand() {
  	Return ";".$this->mName."_validate();";
  }

  /** comment here */
  function addElement(&$pElement, $pBlock = "") {
//  	$this->mElements[] = array($pElement, $pBlock);
  	if (!isset($pElement->mType) || $pElement->mType != "hidden") $this->mElements[] = array("newfield", $pElement);
	else $this->mElements[] = array("hidden", $pElement);
	if (isset($pElement->mType) && $pElement->mType == "file") $this->setEncType();
	if (isset($pElement->mValidateMe) && $pElement->mValidateMe) $this->addToScript($pElement->getValidation());
  }

  /** comment here */
  function createBlock($pBlock) {
//  	$this->mElements[] = array("", $pBlock);
  	$this->mElements[] = array("newblock", $pBlock);
  }

  /** comment here */
  function exitBlock() {
  	$this->mElements[] = array("exitblock");
  }

  /** comment here */
  function gotoBlock($pBlock) {
  	$this->mElements[] = array("selectblock", $pBlock);
  }

  /** comment here */
  function addText($pName, $pTxt) {
  	$vText = new CText($pName, $pTxt);
	$this->addElement($vText);
  }
//
//  /** comment here */
//  function generate($pUseSimpleModel = true) {
//	  CHtmlEntity::generate();
//	  $this->generateValidationScript();
//	  if($this->mAction) $this->assign($this->mName."_ACTION", $this->mAction);
//	  if($this->mTarget) $this->assign($this->mName."_TARGET", $this->mTarget);
//	  if($this->mMethod) $this->assign($this->mName."_METHOD", $this->mMethod);
//	  if($this->mEncType) $this->assign($this->mName."_ENCTYPE", $this->mEncType);
//
//	  foreach ($this->mElements as $key=>$val) {
//		if (!$val[0]) {
//		  $this->selectBlock($val[1]);
//		  $this->newBlock($val[1]);
//		} else {
//		  echo $val[0]->mName;
//		  if ($val[1]) $this->selectBlock($val[1]);
//		  if ($pUseSimpleModel) $val[0]->display();else $val[0]->generate();
//		  if ($val[1]) $this->selectBlock($this->mName);
//		}
//	  }
//  }
//

  /** comment here */
  function generate($pUseSimpleModel = true) {
	  $this->newBlock($this->mName);
	  $this->selectBlock($this->mName);
	  $this->mBlocks[0] = $this->mName;

	  CHtmlEntity::generate();

	  $this->generateValidationScript();

	  if($this->mAction) $this->assign($this->mName."_ACTION", $this->mAction);
	  if($this->mTarget) $this->assign($this->mName."_TARGET", $this->mTarget);
	  if($this->mMethod) $this->assign($this->mName."_METHOD", $this->mMethod);
	  if($this->mEncType) $this->assign($this->mName."_ENCTYPE", $this->mEncType);

	  $hidden = "";
//	  echo count($this->mElements);die;
	  foreach ($this->mElements as $key=>$val) {
		switch($val[0]) {
			case "newfield":
			  if ($pUseSimpleModel) $val[1]->display();else $val[1]->generate();
			  break;
			case "newblock":
			  $this->mBlocks[] = $this->mName;
			  $this->newBlock($val[1]);
			  $this->selectBlock($val[1]);
			  break;
			case "exitblock":
			  array_pop($this->mBlocks);
			  $this->selectBlock($this->mBlocks[count($this->mBlocks)-1]);
			  break;
			case "hidden":
			  $hidden .= $val[1]->display();
			  break;
			default:
			  $this->error("Invalid action", 3);
		}
	  }
	  foreach ($this->mHelpIDs as $key=>$val) {
		$this->assign("Help". $val, "<img id='tooltipid".$val."' style='cursor: pointer;'  src='images/icon_help.gif' onclick=\"showHelpAlert('$val');\">");
	  }
	  $this->selectBlock($this->mName);
	  $this->assign($this->mName . "_HIDDEN", $hidden);
  }

  /** comment here */
  function display() {
	$this->generate(true);
  }

  /** comment here */
  function generateValidationScript() {
	if ($this->mValidationScript) {
	  $tmp = " function ".$this->mName."_validate() { \n ";
	  $tmp .= "\t var x = document.".$this->mName."; \n";
	  $tmp .= "\t var err_id = 0; \n";
	  $tmp .= "submitBut = document.getElementById('".$this->mName."_SUBMIT_NAME'); \n";
	  $tmp .= "if (submitBut) submitBut.disabled = true; \n";

	  $tmp .= $this->mValidationScript;

	  $tmp .= "\t if (err_id == 0 && validationErrors.length == 0) { \n";
	  $tmp .= " if (submitBut) submitBut.disabled=true; \n ";
	  $tmp .= " return true; \n} \n ";
	  $tmp .= "\t else {\n if (submitBut) submitBut.disabled = false; formFailValidation(); return false; \n }\n";
	  $tmp .="}\n";

	  $this->mValidationScript = $tmp;
	  $vScript = new CScript($this->mValidationScript);
	  $this->mDocument->mHead->addScript($vScript);
	}
  }





}

?>