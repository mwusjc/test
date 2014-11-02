<?php   
/** CDialog: implements a dialog box (inline dialog) control
* @package Control
* @since February 19
* @author cgrecu
*/


class CDialog extends CApplication{

  var $mTitle;
  var $mText;
  var $mButtonYes;
  var $mButtonNo;
  var $mButtonCancel;
  var $mRedirect;
  
  /**  constructor: $pRedirect is the page shown if the user presses Yes */
  function CDialog($pTitle, $pText, $pRedirect, $pYes, $pNo = "", $pCancel = "") {
	$this->CApplication();
  	$this->mTitle = $pTitle;
	$this->mText = $pText;
	$this->mButtonYes = $pYes;
	$this->mRedirect = $pRedirect;
	$this->mNo = $pButtonNo;
	$this->mButtonCancel = $pCancel;
  }

  /** displays the control */
  function msgBox() {
	
  	$vForm = new CForm("frm".rand(1,10000), $this->mRedirect);
	$btOk = new CInput("btOk", "button", $this->mButtonYes);
	$btOk->mTemplates["input"]["border-width"] = "1px";
	$btOk->mTemplates["input"]["border-style"] = "normal";
	$btOk->mTemplates["input"]["border-color"] = $this->mColHead;
	$btOk->mTemplates["input"]["padding"] = "3px 8px";
	$btOk->mTemplates["input"]["text-family"] = "georgia";
	$btOk->mTemplates["input"]["font-weight"] = "bold";
	$btOk->mTemplates["input"]["font-size"] = "12pt";
	$btOk->mTemplates["input"]["cursor"] = "hand;cursor:pointer";
	$btOk->setJavaScript("onClick","window.location='".$this->mRedirect."'");
	$vTable = new CBoxTable($this->mText, $this->mTitle, $btOk->display());
	$vTable->loadTemplate("emptyBox");
	$vTable->mTemplates["table"]["width"] = $this->mNetworkObj->BodyWidth;
	$vTable->mTemplates["table"]["padding"] = "8px";
	$vTable->mTemplates["table"]["margin"] = "50px 0 0 0";
	$vTable->mTemplates["table"]["text-align"] = "center";
	$vTable->mTemplates["table"]["text-family"] = "georgia";
	$vTable->mTemplates["header"]["font-size"] = "12pt";
	$vTable->mTemplates["body"]["font-size"] = "12pt";
	$vTable->mTemplates["body"]["font-weight"] = "normal";
	$vTable->mTemplates["body"]["padding"] = "8px 20px 30px 20px";
	$vTable->mTemplates["body"]["text-align"] = "justify";
	Return $vTable->display();
	$tmp = $vForm->openForm() . $vTable->display() . $vForm->closeForm();
	Return $tmp;
  }

	/** displays the control, not form, use normal link*/
	function msgBox2() {
		$vLink = new CHref($this->mRedirect,$this->mButtonYes);
		$vLayout = new CBoxTable($this->mText, $this->mTitle, $vLink->display());
		$vLayout->loadTemplate("dialog_box");
		return $vLayout->display();
	}
  
}

?>
