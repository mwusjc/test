<?php   
/** CPageManager
* @package admin
* @author cgrecu
*/


  class CPageManager extends CSectionManager {
	/** comment here */
	function CPageManager() {
	  $this->CSectionManager();
	}

	/** comment here */
	function displayPage($id) {
		$txt = $this->mDocument->getMenu();
		$this->setPiece("LEFTBODY", $txt);

		$this->resetTemplate("templates/default.html");
		$vPage = new CPage($id);
		$vPage->display();
		Return $this->flushTemplate();

	}

	/** comment here */
	function getHelp($page) {
		$page = strtolower($page);
		$sql = "select a.ID, a.Name, b.ID as SectionID, b.Name as Section, b.Page, b.Content from cms_help_main a, cms_help_sections b where a.id = b.typeid order by a.id asc, b.id asc";
		$data = $this->mDatabase->getAll($sql);
		foreach ($data as $key=>$val) {
			if ($val["Page"] == $page && $page) {
				$mainSection = $val["ID"];
				$mainEntry = $val["SectionID"];
				break;
			}
		}
		$txt  = '<table  bgcolor="FFFFFF" width="240" border="0" cellspacing="0" cellpadding="0">';
		$mainid = 0;
		$title = "&nbsp;";
		$content = "&nbsp;";
		$id = "&nbsp;";
		foreach ($data as $key=>$val) {
			if ($mainEntry && $mainEntry == $val["SectionID"]) {
				$content = $val["Content"];
				$title = $val["Section"];
				$id = $val["SectionID"];
			}
			if ($mainid != $val["ID"]) {
				if ($key) {
					$txt.= "</table></td></tr>";
					$txt.= "<tr><td colspan='2' height='10'>&nbsp;</td></tr>";
				}
				if ($mainSection && $mainSection == $val["ID"]) {
					$display = "block";
					$icon = "minus";
				} else {
					$display = "none";
					$icon = "plus";
				}
				$txt .= '<tr>
								<td width="13" align="left" valign="middle"><a href="#self" onclick="toggleHelpSection(\''.$val["ID"].'\');"><img id="menuTableIcon'.$val["ID"].'" src="images/icon_'.$icon.'.gif" width="11" height="11" /></a></td>
								<td width="227" align="left" valign="middle"><a href="#self" onclick="toggleHelpSection(\''.$val["ID"].'\');"><strong>'.$val["Name"].'</strong></a></td>
							</tr>
							<tr><td colspan="2"><table bgcolor="FFFFFF" cellpadding="0" cellspacing="0" border="0" width="100%" id="menuTable'.$val["ID"].'" style="display: '.$display.'">';
			}
			$txt .= 		'<tr>
									  <td align="left" valign="middle" style="padding: 3px 0 3px 25px"><a href="#self" onclick="showHelpEntry(\''.$val["SectionID"].'\');">'.$val["Section"].'</a></td>
								</tr>
							';
			$mainid = $val["ID"];
		}
		$txt.= "</table></td></tr>";
		$txt.= "<tr><td colspan='2' height='10'>&nbsp;</td></tr>";
		$txt .= '</table>';
//		die($txt);
		if (!$title)  $title = "&nbsp;";
		if (!$content)  $content = "&nbsp;";
		if (!$id)  $id = "&nbsp;";
		$xml = "<leftmenu>".xmlentities($txt)."</leftmenu>";
		$xml .= "<content>".xmlentities($content)."</content>";
		$xml .= "<title>".xmlentities($title)."</title>";
		$xml .= "<id>".xmlentities($id)."</id>";
		Return xml($xml);
	}

	/** comment here */
	function getHelpEntry($id) {
		$sql = "select Name, Content, PageID from cms_help_sections where id = '".addslashes($id)."' ";
		$data = $this->mDatabase->getRow($sql);
		if ($data["PageID"]) {
			$sql = "select txt from cms_pages where id = '".$data["PageID"]."'";
			$data2 = $this->mDatabase->getRow($sql);
			$data["Content"] = "<br>".$data2["txt"];
		}
		if (!$data["Content"]) $data["Content"] = "&nbsp;";
		if (!$data["Name"]) $data["Name"] = "&nbsp;"; else $data["Name"] = $data["Name"];
		$xml .= "<content>".xmlentities($data["Content"])."</content>";
		$xml .= "<title>".xmlentities($data["Name"])."</title>";
		Return xml($xml);
	}

	/** comment here */
	function getToolTip($id) {
		$sql = "select Name, Content from cms_help_entries where id = '".addslashes($id)."' ";
		$data = $this->mDatabase->getRow($sql);
		if (!$data["Content"]) $data["Content"] = "&nbsp;";
		if (!$data["Name"]) $data["Name"] = "&nbsp;";
		$xml .= "<content>".xmlentities($data["Content"])."</content>";
		$xml .= "<title>".xmlentities(ucwords($data["Name"]))."</title>";
		Return xml($xml);

	}

	/** comment here */
	function printHelp($id) {
		$this->mDocument->mPageTemplate = "templates/popup.html";
		$this->mDocument->mUrlObj->mAddUrl= false;
		$this->mDocument->mHead->addCss("css/print.css");

		$sql = "select Name, Content, PageID from cms_help_sections where id = '".addslashes($id)."' ";
		$data = $this->mDatabase->getRow($sql);
		if ($data["PageID"]) {
			$sql = "select txt from cms_pages where id = '".$data["PageID"]."'";
			$data2 = $this->mDatabase->getRow($sql);
			$data["Content"] = "<br>".$data2["txt"];
		}
		$txt = "<h1>". $data["Name"] ."</h1>";
		$txt .= $data["Content"];
		$txt .= "<script>printit();</script>";
		Return $txt;
	}

	/** comment here */
	function mainSwitch() {
	  switch($this->mOperation) {
		  case "show":
		  case "view":
			Return $this->displayPage($_GET["id"]);
		  case "getHelp":
			  Return $this->getHelp($_GET["id"]);
		  case "getHelpEntry":
			  Return $this->getHelpEntry($_GET["id"]);
		  case "getToolTip":
			Return $this->getToolTip($_GET["id"]);
			case "print_help":
				Return $this->printHelp($_GET["id"]);
	  }
	}
  }

?>
