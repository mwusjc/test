<?php   
/** CMultipleSelect: displays 2 or 3 Select Objects and buttons to implement moving options between Selects
* @package Control
* @since March 08
* @author cgrecu
*/


class CMultipleSelect extends CSelectCollection {
  
  /** constructor */
  function CMultipleSelect() {
  	$this->CSelectCollection('dummy');
	$this->setLabelAlign("left","top");
  }

  /** adds another List Object to the lists collection */
  function addSelectObj($pSelectObj) {
	  $this->add($pSelectObj);
  }

  /** displays the control */
  function display() {
	
	$vIndex = $this->mHtmlDoc->mHead->getScript("multipleSelect");
	if ($vIndex == -1) {
	  $vScript = " function listMove(listFrom, listTo) {\n".
				"\t listFrom = document.getElementById(listFrom); \n".
				"\t listTo = document.getElementById(listTo); \n".
				"\t cnt1 = listFrom.options.length; \n".
				"\t cnt2 = listTo.options.length; \n".
				"\t deleteThis = new Array();j = -1; \n".
				"\t for (i=cnt1-1; i>=0; i--) {\n".
				"\t\t  if (listFrom.options[i].selected) {\n".
				"\t\t\t var newOpt = new Option(listFrom.options[i].text, listFrom.options[i].value); \n".
				"\t\t\t listTo.options[cnt2] = newOpt;\n".
				"\t\t\t cnt2++; \n".
				"\t\t\t listFrom.options[i] = null; \n".
				"\t\t	 } \n".
				"\t } \n".
				"} \n";
	  $vScript = new CScript($vScript);
	  $vScript->setName("multipleSelect");
	  $this->mHtmlDoc->mHead->addScript($vScript);
	}
	$vTable = new CTable();
	$tmp = $vTable->openTable();
	$vAttr = array("valign"=>"middle","align"=>"left");
	$tmp .= $vTable->openTR($vAttr);
	$i = 0; $vCnt = count($this->mSelectObjAry);
	foreach ($this->mSelectObjAry as $key=>$val) {
	  if ($i % 2 == 1) $tmp .= $vTable->drawTD("&nbsp;");	
	  $tmp .= $vTable->drawTD($val->displayLabel());	
	  $i ++;
	}
	$tmp .= $vTable->closeTR($vAttr);
	$vAttr = array("valign"=>"middle","align"=>"center");
	$tmp .= $vTable->openTR($vAttr);
	$vButLeft = new CInput("btLeft","button","<<");$vButLeft->setJavaScript("onClick","");
	$vButRight = new CInput("btRight","button",">>");$vButRight->setJavaScript("onClick","");
	$i = 0;
	foreach ($this->mSelectObjAry as $key=>$val) {
	  $tmp .= $vTable->drawTD($val->display());	
	  if ($i < $vCnt-1) {
	  	  $vButLeft->mJavaScript->addJavaScript("onClick", "listMove('".$this->mSelectObjAry[$i+1]->mID."','".$this->mSelectObjAry[$i]->mID."');");
		  $vButRight->mJavaScript->addJavaScript("onClick", "listMove('".$this->mSelectObjAry[$i]->mID."','".$this->mSelectObjAry[$i+1]->mID."');");
		  $tmp .= $vTable->drawTD($vButLeft->display() ."<br>". $vButRight->display());	
	  }
	  $i ++;
	}
	$tmp .= $vTable->closeTable();
	Return $tmp;	
  }
  
  /** before submit this javascript function will select all options in the Select Objects passed in the parameter */
  function getValidation($pListNames) {
	$tmp = "";
	foreach ($pListNames as $key=>$val) {
		$tmp .= " listObj = document.getElementById('$val'); cnt = listObj.options.length; for (i=0; i< cnt; i++) { listObj.options[i].selected = true;}; \n";
	}
	Return $tmp;
  }

}

?>
