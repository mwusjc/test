<?php

	class CDynTab {

		var $mPrefix = "DYNTAB";
		var $mTabs = array();
		var $mClass = "DYNTAB";

		/** comment here */
		function CDynTab($pName = "") {
			if ($pName) $this->mPrefix = $pName;
		}

		/** comment here */
		function addTab($pMenu, $pTxt) {
		  $this->mTabs[] = array($pMenu, $pTxt);
		}

		/** comment here */
		function display() {
		  $GLOBALS["vDocument"]->mHead->addScript(new CScript("", "_common/scripts/misc/dynamic_tab.js"));
		  $cnt = count($this->mTabs)	;
		  if (!$cnt)  {
			$this->error("Tab has no elements", 1);
			Return "";
		  }

		  $txt  = '<table id="table_'.$this->mPrefix . '" class="'.$this->mClass.'" cellpadding="0" cellspacing="0" border="0"><tr>';
		  $script = " tabs.".$this->mPrefix." = new Array();";
		  foreach ($this->mTabs as $key=>$val) {
			$txt .= "<td class=\"".$this->mPrefix . "_menuoff\" id=\"".$this->mPrefix . "_menu_" . $key."\"onmouseover=\"if (this.id != selectedMenu) this.className='DYNTAB_menuhover';\" onmouseout=\"if (this.id != selectedMenu) this.className='DYNTAB_menuoff';\" onclick=\"dtab_selectMenu($key, '" . $this->mPrefix . "');\">" . $val[0] . "</td>";
			$script .= " tabs.".$this->mPrefix."[$key] = '".str_replace("'","\'",$val[1])."';\n";
		  }
		  $txt .= "</tr>";
		  $txt .= '<tr><td colspan="'.count($this->mTabs).'"><div id="'.$this->mPrefix.'_maindiv" style="vertical-align: top;"></div></td></tr></table>';
//		  $script .= "\n dtab_selectMenu(0,'".$this->mPrefix."');\n";

		  $GLOBALS["vDocument"]->mHead->addScript(new CScript($script));

		  Return $txt;

	}

}
?>