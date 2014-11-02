<?php   
/** Generate a 3 combo boxes for date (Month, Date, Year), a hidden field which has the epoch for saving
* @package Control
* @since March 1,2004
* @author Son Nguyen
*/
class CDateBox extends CSelectCollection {
	var $mCurDate;

	var $mDateName;
	var $mMonthName;
	var $mYearName;

	/** constructor */
	function CDateBox($pName,$pCurDate) {
		$this->CSelectCollection($pName);
		$this->mCurDate = $pCurDate;
		$this->mDateName = $this->mName."_DateBoxDate";
		$this->mMonthName = $this->mName."_DateBoxMonth";
		$this->mYearName = $this->mName."_DateBoxYear";
	}
	
	/** displays the control */
	function display() {
		$vShared = "updateNumDays(); updateTimeStamp();";
		$vYear = new CSelect($this->mYearName);
		$vYear->setExtraOption(array('-1','----'));
		$vYear->setOptionsNumeric(1900,date('Y')+2); // anything before 1970 on win32 will die!
		$vYear->setJavaScript("onChange",$vShared);
		if ($this->mCurDate) { $vYear->setDefault(date('Y',$this->mCurDate)); }

		$vMonth = new CSelect($this->mMonthName);
		$vMonth->setOptions($this->_getMonthOptions());
		$vMonth->setExtraOption(array('-1','----'));
		$vMonth->setJavaScript("onChange",$vShared);
		if ($this->mCurDate) { $vMonth->setDefault(date('m',$this->mCurDate)); }
		
		$vDate = new CSelect($this->mDateName);
		$vDate->setExtraOption(array('-1','----'));
		$vDate->setJavaScript('onChange',"updateTimeStamp();");

		$this->add($vYear);
		$this->add($vMonth);
		$this->add($vDate);

		$vHiddenDate = new CInput($this->mName,'hidden');
		$vScript0 = "var Yr = document.getElementById('".$this->mYearName."').value; ";
		$vScript0 .= "var Mo = document.getElementById('".$this->mMonthName."').value;";
		$vScript0 .= "var dateBox = document.getElementById('".$this->mDateName."'); var Dy = dateBox.selectedIndex; ";

		$vScript1 = "function updateNumDays() { ".$vScript0." if (Yr==-1||Mo==-1) return; var tmpDateObj = new Date(); tmpDateObj.setYear(Yr); tmpDateObj.setMonth(Mo); tmpDateObj.setDate(0); tmpDateObj.getDate(); var oldDate = dateBox.selectedIndex; dateBox.options.length=0; var numDays = tmpDateObj.getDate(); for (i=0;i<numDays;i++) { dateBox.options[i] = new Option(i+1); if (oldDate==i) {dateBox.selectedIndex=i;}}}";
		$vScript2 = "function updateTimeStamp() { ".$vScript0." var tmpDateObj = new Date(Yr,Mo-1,Dy+1); document.getElementById('".$this->mName."').value=parseInt(Math.max(tmpDateObj.getTime()/1000,0)); }";
		$vScript3 = "updateNumDays(); ";
		if ($this->mCurDate) { 
			$vScript3 .= "var dateBox = document.getElementById('".$this->mDateName."'); dateBox.selectedIndex=".intval(date('j',$this->mCurDate)-1)."; updateTimeStamp();"; 
		} // if

		$vScript = new CScript($vScript1.$vScript2.$vScript3);
		return $vHiddenDate->display().CSelectCollection::display().$vScript->display();
	}
	
	/** creates javascript for validation purposes */
	function getValidation($pErrorMsg) {
		return "if (x.".$this->mDateName.".value==-1 || x.".$this->mMonthName.".value==-1 || x.".$this->mYearName.".value==-1) { alert('".$pErrorMsg."'); return false; }";
	}
	
	/** returns a list of months(strings+ values) */
	function _getMonthOptions() {
		$vAry = array();
		for ($i=1;$i<=12;$i++) {
			$vAry[] = array($i,date('F',mktime(0,0,0,$i)));
		} // for
		return $vAry;

	}
}


?>
