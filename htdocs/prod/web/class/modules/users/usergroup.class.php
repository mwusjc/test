<?php
	class CUserGroup extends CDBContent {

	  var $section = "Users";
	  var $parent = "CUserGroupManager";
	  var $table = "cms_user_groups";


	  function CUserGroup ($pUserID = 0){
		$this->CDBContent($pUserID);
	  }

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getBaseLink("UserGroups") . "save&id=" . $this->mRowObj->ID);
	  $this->resetTemplate("templates/users/editgroup.html");

	  $txtInput = new CTextInput("Txt","");
	  $txtInput->setClass("required size150");
	  $vForm->addElement($txtInput);

	  $vForm->addText("AdminGroup" . $this->mRowObj->AdminGroup, " SELECTED='true' checked='true' ");

	  $rights = $this->mDatabase->getAll("select rightid from cms_group_rights where groupid = '".$this->mRowObj->ID."'");
	  $tmp = $this->mDatabase->getAll("select * from cms_user_rights order by section asc, orderid asc");
	  foreach ($tmp as $key=>$val) {
		$data[$val["Section"]][] = array($val["Name"], $val["ID"]);
	  }
	  $tables = array();
	  foreach ($data as $key=>$val) {
		$txt = "<table cellspacing='2' width=\"175\" cellpadding='0'  border=0><tr><td colspan=2><b>". $key . "</b></td></tr>";
		foreach ($val as $key2=>$val2) {
			$checked = "";
			if (in_array($val2[1], $rights)) $checked = "checked='true' ";
			$txt .= "<tr><td width=15 height=20><input type='checkbox' name='Rights[]' value='".$val2[1]."' $checked></td><td style=\"vertical-align: middle; height: 18px; \" ><nobr>".$val2[0]."</nobr></td></tr>";
		}
		$txt .= "</table>";
		$tables[] = $txt;
	  }

	  $txt = "<table cellspacing='10' width='100%' cellpadding='0'><tr>";
	  foreach ($tables as $key=>$val) {
		if ($key && $key%3 == 0) $txt .= "</tr><tr>";
		$txt .= "<td>". $val . "</td>";
	  }
	  $txt .= "</tr></table>";
	  $vForm->addText("Access", $txt);

	  $vForm->display();
	}

	/** comment here */
	function save() {
	  $this->registerForm();
	  $this->easySave();

	  $sql = "delete from cms_group_rights where groupid = '".$this->mRowObj->ID."'";
	  $this->mDatabase->query($sql);
	  foreach ($_POST["Rights"] as $key=>$val) {
		$this->mDatabase->query("insert into cms_group_rights(groupid, rightid) values('".$this->mRowObj->ID."','".addslashes($val)."')");
	  }

	}

	/** comment here */
	function delete() {
		if ($this->mRowObj->DeleteFlag == "no") Return false;
		$this->mDatabase->query("delete from cms_user_groups where id = '".$this->mRowObj->ID."'");
	}


}
?>