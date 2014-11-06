<?php   
/** CRichTextArea
* @package html
* @since May 04
* @author cgrecu
*/


class CRichTextArea extends CTextArea {
  
  /** comment here */
  function CRichTextArea($pName, $pLines = "", $pRows = "", $pCols = "", $pEnabled = "", $pReadOnly = "", $pAccessKey = "", $pTabIndex = "") {
  	$this->CTextArea($pName, $pLines, $pRows, $pCols, $pEnabled, $pReadOnly, $pAccessKey, $pTabIndex);
	if ($this->mIE) {
	  if ($this->mHtmlDoc->mHead->getScript("editor") == -1) {
		$vScript = new CScript("","scripts/htmlarea/editor_header.js");
		$vScript->mName = "editor";
		$this->mHtmlDoc->mHead->addScript($vScript);
	  }
	  //$sql = "select ";$this->mDatabase->query($sql);
	  global $htmlEditorScript;
	  if (!is_object($htmlEditorScript)) $htmlEditorScript = new CScript("","scripts/htmlarea/editor_footer.js");

	}
  }

  /** display for rich textarea */
  function display() {
  	// enable wysiwyg for this obj
	if ($this->mIE) {
	  $tmp = "<script>globRichs[globRichs.length] = '$this->mName';</script>";
	} else {
	  foreach ($this->mLines as $key=>$val) {
		$this->mLines[$key] = strip_tags($val);
	  }
	}
	return $tmp.CTextArea::display();
  }

  /** creates javascript validation code */
  function getValidation() {
//  	return " if (x." . $this->mName . ".value == '') {\n errors[errors.length] ='".$pErrorMsg."';err_id=-1;editor_insertHTML('".$this->mName."','');\n }\n ";
	  $tmp = "if (!(x.".$this->mName.".disabled == true)) { ";
	  if ($this->mValidateForEmpty) 
		  $tmp .= "\t if (x.".$this->mName.".value == '".$this->mNullValue."') {\n 
							  failValidation(x.".$this->mName.", '".$this->mErrorEmptyMsg."');\n 
						\t\t err_id = -1; \n 
						\t};\n";
	  $tmp .= "}\n";
	  Return $tmp;

  }

}

?>
