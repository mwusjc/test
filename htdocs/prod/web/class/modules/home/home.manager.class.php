<?php

class CHomeManager extends CSectionManager
{
  /** comment here */
  function CHomeManager() {
	$this->CSectionManager();
  }

  function display() {
		$this->mDocument->displayBottomBanners();
		$this->resetTemplate("templates/home.html");

		if ($_GET["q"]) {
//			die('a');
			$tmp = explode("-", $_GET["q"]);
			$userid = $tmp[0];
			$sql = "update contacts set consent  = 'yes', consenttime = unix_timestamp(), consentip = '" . $_SERVER["REMOTE_ADDR"] . "'  where id=" .intval($userid). "";
			$this->mDatabase->query($sql);

			$this->newBlock("CASL");
		}

		$activeflyer = $this->mDatabase->getRow("select * from flyers where Status = 'enabled' order by id desc limit 1");
		$this->assign("EffectiveDate", date("l, F jS", $activeflyer["Week"]) . " to " . date("l, F jS", $activeflyer["WeekEnds"]));

//		if ($_GET["test"] ==1) ;$this->resetTemplate("templates/home-xmas.html");
//
//		$sql = "select * from recipes where status = 'enabled' order by id desc limit 6";
//		$recipes = $this->mDatabase->getAll($sql);
//		foreach ($recipes as $key=>$val) {
//			$this->newBlock("RECIPE");
//			$this->assign("Name", $val["Name"]);
//			$this->assign("ID", $val["ID"]);
//		}


		$dir = new DirectoryIterator( $_SERVER['DOCUMENT_ROOT'] . '/media/current_banner');
		$fylez = array();
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {
				$fylez[] = 'media/current_banner/' . $fileinfo->getFilename();
			}
		}
		sort($fylez);
		foreach ($fylez as $fyle) {
			$this->newBlock("BANNER");
			$this->assign("Image", $fyle);
		}

	/*
	$d = dir("media/current_banner");
	while (false !== ($entry = $d->read())) {
		if ($entry == "." || $entry == "..") continue;
		$this->newBlock("BANNER");
		$this->assign("Image", "media/current_banner/" . $entry);
	}
	$d->close();
	*/



		Return $this->flushTemplate();
  }

  /** comment here */
  function registerClasses() {
  $this->mClasses[] = array("", "");
  }

  /** comment here */
  function displayFullPage($pID) {
	  $vPage = new CPage($pID);
	  Return $vPage->display();
  }

  /** comment here */
  function getBack() {
	  $url = $this->mDocument->mUrlObj->getPrevUrl();
	  $this->redirect($url);
  }

  /** comment here */
  function showHistory() {
	echo "<table cellpadding=2 cellspacing=0 border=1 bordercolor='#dddddd' style='border-collapse: collapse; font-family: verdana; font-size: 9pt;' width = 100%>";
	foreach ($this->mDocument->mUrlObj->mHistory as $key=>$val) {
		echo "<tr>";
		echo "<td>".($key+1)."</td>";
		foreach ($val as $key2=>$val2) {
			echo "<td>".$val2."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	die();
  }

  /** comment here */
  function displayBuilderHome() {
	 return "home";
  }

  /** different type of user = different home page & mode */
  function displayHome() {
	switch($_SESSION["gSiteMode"]) {
		case "construction": return $this->displayBuilderHome();
		case "owner": return $this->displayOwnerHome();
		case "green": return $this->displayGreenHome();

	}
  }

  /** comment here */
  function displayPage($id) {
		$langID = $this->getLangID();
		$page = new CPage($id);
		$this->setTitle($page->mRowObj->{"Title$langID"});
		Return $page->display();
  }

  /** comment here */
  function displayContact() {
		$this->resetTemplate("templates/contact.html");
		Return $this->flushTemplate();
  }

  /** comment here */
  function displaySitemap() {
		$this->resetTemplate("templates/sitemap.html");
		$plans = $this->getPlans();
		$lots = array(1 => "Townhomes >", 2 => "Semi-detached >", 3 => "36 ft. singles >", 4 => "43 ft. singles >", 5 => "47 ft. singles >", 6 => "50 ft. singles >");
		for($i=6; $i>=1; $i--) {
			if (empty($plans[$i])) continue ;
			$this->newBlock("LOT");
			$this->assign("LotType", $lots[$i]);
			$val = $plans[$i];
			foreach ($val as $key2=>$val2) {
				$this->newBlock("MODEL");
				$this->assign("Name", $val2[1]);
				$this->assign("ID", $val2[0]);
			}
		}
		Return $this->flushTemplate();

  }

    /** comment here */
  function displayPrivacy() {
		$this->resetTemplate("templates/privacy.html");
		Return $this->flushTemplate();

  }

//  /** comment here */
//  function recipes() {
//		$d = dir("temp");
//		$cats = array(8 =>"dessert", 7 => "international", 2=>"meat",5=>"pasta",3=>"poultry",4=>"seafood",1=>"soups",6=>"vegetarian");
//		while (false !== ($entry = $d->read())) {
//		  if ($entry == ".")  continue;
//		  if ($entry == "..")  continue;
//			$d2 = dir("temp/" . $entry);
//			while (false !== ($entry2 = $d2->read())) {
//			  if ($entry2 == ".")  continue;
//			  if ($entry2 == "..")  continue;
//				$buf = file_get_contents("temp/" . $entry . "/" . $entry2);
//				$x1 = strpos($buf, "recipeheading");
//				$x1 = strpos($buf, "<b>", $x1+1);
//				$x2 = strpos($buf, "</b>", $x1+1);
//				$name = strip_tags(substr($buf, $x1, $x2-$x1));
//				$name = str_replace(chr(32), " ", $name);
//				$name = explode(" ", $name);
//
//				$tmp = array();
//				foreach ($name as $key=>$val) {
//					if (trim(str_replace("\t", "", $val))) $tmp[$key] = trim(str_replace("\t", "", $val));
//				}
//				$name = implode(" ", $tmp);
//				$x1 = strpos($buf, '<font class="recipecopy"', $x2);
//				 $x2 = strpos($buf, "</font>", $x1 + 1);
//				 $ing =  strip_tags(substr($buf, $x1, $x2-$x1));
//
//				 $x1 = strpos($buf, '<font class="recipecopy"', $x2);
//				 $x2 = strpos($buf, "</font>", $x1 + 1);
//				 $directions =  strip_tags(substr($buf, $x1, $x2-$x1));
//
//
//				$fields = array();
//				foreach ($cats as $key=>$val) {
//					if ($val == $entry) $fields["CategoryID"] = $key;
//				}
//				$fields["Name"] = $name;
//				$fields["Ingredients"] = $ing;
////				for($i=0; $i<strlen($directions); $i++) {
////					echo "chr".$directions[$i] . ": x" . ord($directions[$i]) . "__";
////				}
////				die();
//
//				$directions= explode(" ", str_replace(chr(176), "&deg;", $directions));
//
//				$tmp = array();
//				foreach ($directions as $key=>$val) {
//					if (trim(str_replace("\t", "", $val))) $tmp[$key] = trim(str_replace("\t", "", $val));
//				}
//
//				$fields["Directions"] = implode(" ", $tmp);
//				$sql = "insert into recipes" . $this->mDatabase->makeInsertQuery($fields);
//				$this->mDatabase->query($sql);
//			}
//			$d2->close();
//		}
//		$d->close();
//die();
//  }

function getBanners() {
	$txt = '<select>';
	$d = dir("media/current_banner");
	while (false !== ($entry = $d->read())) {
		if ($entry == "." || $entry == "..") continue;
		$x = explode(".", $entry) ;
		$p = array_pop($x);
		if ($p != "jpg") continue;
		$x = implode(".", $x);
		$x = substr($x, 0, -1);
		$txt .= '<option filepath ="/media/current_banner/" image="'.$x.'"/>';
	}
	$d->close();
	$txt .= '</select>';
	header("Content-type: application/xml");
	die($txt);
}

/** comment here */
function apply() {
	if (!$_POST["Email"]) {
		$this->redirect("index.php?n=Main&o=careers");
	}
	$attachment = "";
//		print_r($_POST);
		if ($_FILES["Resume"]["name"]) {
			$newsrc = "resume_" . date("YmdHis");
			$attachment = $this->mDocument->mFileObj->upload2("Resume", "any", "media/resumes/" . $newsrc);
		}
		$store = $this->mDatabase->getValue("stores", "Name", " ID = '".addslashes($_POST["StoreID"])."'");
		$position = $this->mDatabase->getValue("jobs", "Name", " ID = '".addslashes($_POST["PositionID"])."'");

		$mail = new PHPMailer();
		$mail->From = $_POST["Email"];
		$mail->FromName = $_POST["Name"];
		$mail->AddAddress("jobs@highlandfarms.on.ca", "Highland Farms");
		$mail->AddReplyTo($_POST["Email"], $_POST["Name"]);

		$mail->Priority = 3;
		$toName.": ".$toMail."<br>";

		$mail->WordWrap = 250;  // set word wrap to 50 characters
		$mail->IsHTML(true);
		if ($attachment) {
			$mail->AddAttachment($attachment);
		}
		$mail->Subject = "Job Application - " . $store;

		$message = "Store: " . $store . "<br>";
		$message .= "Position: " . $position . "<br>";
		$message .= "Name: " . $_POST["Name"] . "<br>";
		$message .= "Email: " . $_POST["Email"] . "<br>";
		$message .= "<hr>";
		$message .= $_POST["Message"];
		$mail->Body    = $message;
		$mail->AltBody    = $message;
		$ret = $mail->Send();
		$mail->ClearAddresses();
		if ($ret) {
			$obj = new CContent("applications");
			$obj->registerForm();
			$obj->mRowObj->ResumePath = $attachment;
			$obj->mRowObj->TimeStamp = time();
			$obj->easySave();
			$this->error("Your application was received!");
		} else {
			$this->error("There was an error submitting your application, please try again. If the error persists, please email your resume to <a href='mailto: jobs@highlandfarms.on.ca'>jobs@highlandfarms.on.ca</a>!");			
		}
		
		$this->redirect("index.php?n=Main&o=careers");

}

/** comment here */
function unsubscribe($cleverid) {
	$tmp = explode("-", $_GET["id"]);
	if (count($tmp) > 1) {
			$id = $tmp[0];
	} else {
		$tmp = base64_decode($cleverid);
	//	$tmp2 = explode("-", $tmp);
		$id = substr($tmp,12);
	}
//		die2($id);
	$sql = "update contacts set subscribed = 'no', subscribedflyer = 'no' where id = '" . intval($id) ."'";
	$this->mDatabase->query($sql);
	$this->error("You have been unsubscribed succesfully!");
	$this->redirect("index.php");
}

/** operation switch for Home Manager */
  function mainSwitch() {
	switch($this->mOperation) {
		case "full_page":
		    return $this->displayFullPage($_GET["id"]);
		case "home":
			return $this->displayHome();
		case "get_history":
			$this->showHistory();
		case "back":
			return $this->getBack();
        case "page":
            return $this->displayPage($_GET["id"]);
		case "contact":
			return $this->displayContact();
		case "sitemap":
			return $this->displaySitemap();
		case "privacy":
			return $this->displayPrivacy();
		case "recipes": return $this->recipes();
		case "get_banners": Return $this->getBanners();
		case "apply": Return $this->apply();
		case "unsunscribe":
		case "unsubscribe":
		case "unsubscribe": Return $this->unsubscribe($_GET["id"]);
	    default:
	        return CSectionManager::mainSwitch();
	}
  }


}

?>