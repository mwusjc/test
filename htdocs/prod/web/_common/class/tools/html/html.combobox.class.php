<?php   
/** CComboBox
* @package html
* @since February 06
* @author cgrecu
*/


class CComboBox extends CSelect{
  
  function CComboBox($pName, $pTable, $pID, $pLabel, $pDefault="",$pClause="") {
	 $this->CSelect($pName,false,1);
	 $this->getOptionsFromDb($pTable, $pLabel, $pID, $pClause);
	 if ($pDefault) $this->setDefault($pDefault);
  }

}

?>