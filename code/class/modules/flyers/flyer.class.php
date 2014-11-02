<?php
/** CFlyer
* @package pages
* @author cgrecu
*/


class CFlyer extends CDBContent {

	var $section = "Flyers";
	var $parent = "CFlyerAdmin";
	var $table = "flyers";

	/** comment here */
	function CFlyer($pID) {
		$this->CDBContent($pID);
	}

	/** comment here */
	function display() {
	  Return nl2br($this->mRowObj->Txt);
	}

	function displayEdit() {
		$pages = "";
		if ($this->mRowObj->ID) {
		  $sql = "select * from flyer_pages where flyerid = '".$this->mRowObj->ID."'";
		  $data = $this->mDatabase->getAll($sql);
		  $txt = "";
		  $this->resetTemplate("templates/flyers/flyer_pages.html");
		  foreach ($data as $key=>$val) {
				$this->newBlock("PAGE");
				$this->assign("FlyerID", $val["FlyerID"]);
				$this->assign("ID", $val["ID"]);
				$this->assign("Name", "Page #" . $val["OrderID"]);
		  }
			$pages = $this->flushTemplate();
		}
	  $vForm = new CForm("frmEdit", $this->getBaseLink() . "save&id=" . $this->mRowObj->ID);
	  $vForm->resetTemplate("templates/flyers/editflyer.html");

	  $input = new CDateTimePicker("Week", "");
	  $input->validate("Enter week");
	  $input->setClass("required size100");
	  $vForm->addElement($input);

	  $input = new CDateTimePicker("WeekEnds", "");
	  $input->validate("Enter last day of the flyer");
	  $input->setClass("required size100");
	  $vForm->addElement($input);

	  
	  $input = new CTextInput("Pages", "");
	  $input->setClass("required size50");
	  $vForm->addElement($input);

	  $input = new CInputFile("PDFPath");
	  $input->setClass("required size300");
	  $vForm->addElement($input);

	  if ($this->mRowObj->PDF) {
			$vForm->addText("Download", '<a href="'.$this->mRowObj->PDF.'" target="_blank">download existing</a>');
	  }

		if ($this->mRowObj->ID) {
			$vForm->createBlock("PAGE");
			$vForm->addText("ID", $this->mRowObj->ID);
			$vForm->addText("PageList", $pages);
		}

	  $vForm->display();
	  Return $this->flushTemplate();
	}


	/** comment here */
	function save() {
//		die2($_FILES);
		$this->registerForm();
		$new = false;
		if (!$this->mRowObj->ID) {
			$this->mRowObj->TimeStamp = time();
			$this->mRowObj->UserID = $this->mUserID;
			$new = !$new;
		}

		if ($_FILES["PDFPath"]["name"]) {
			$newsrc = "Highland Farms Flyer " . date("F d Y");
			$path = $this->mDocument->mFileObj->upload2("PDFPath", "any", "media/flyers/flyer_" . $this->mRowObj->ID . "/" . $newsrc);
		  if ($path) {
			$this->mRowObj->PDF = $path;
		  }
	  	}
		if ($new) {
			$this->mRowObj->Status = "disabled";
		}
		$this->easySave();
		if ($new) {
			$this->mRowObj->Status = "disabled";
			mkdir("media/flyers/flyer_" . $this->mRowObj->ID);
			mkdir("media/flyers/flyer_" . $this->mRowObj->ID . "/products");
			mkdir("media/flyers/flyer_" . $this->mRowObj->ID . "/pages");
		}
	}

	/** comment here */
	function toggle($pType) {
		$ret = 0;
		if ($pType == "off") $this->mRowObj->Status = "disabled"; else {
			$sql = "update flyers set status = 'disabled'";
			$this->mDatabase->query($sql);
			$this->mRowObj->Status = "enabled";
			$this->mRowObj->ActivationDate = time();
			$this->easySave();
			$this->enableBanners();
			$page = $this->mDatabase->getAll("select PageLocation from flyer_pages where flyerid = '".addslashes($this->mRowObj->ID)."' and orderid = 1");
			$cmd = "copy \"" . str_replace("/","\\",$page[0]) ."\" \"media\\flyers\\flyer_" . $this->mRowObj->ID . "\\mainpage.jpg\"";
			exec($cmd);
//			die('a');
			$ret = $this->emailFlyer();
		}
		$this->easySave();
		Return true;
	}

	/** comment here */
	function delete() {
		$sql = "delete from flyers where id = '".$this->mRowObj->ID."'";
		$this->mDatabase->query($sql);
	}

	/** comment here */
	function emailFlyer() {
		#select all users
//		die();
		if ($this->mRowObj->EmailsSent > 0)  Return true;
		$this->mRowObj->EmailsSent = 1;
		$this->easySave();

		$sql = "select ID, FirstName, Email from contacts where subscribedflyer = 'yes' and email like '%lgrecu%'";
		$sql = "select ID, FirstName, Email from contacts where subscribedflyer = 'yes'";
		$data = $this->mDatabase->getAll($sql);
//die2($data);
		#create flyer email
//		$mail = new PHPMailer();
//		$mail->From = "info@highlandfarms.ca";
//		$mail->FromName = "Highland Farms";
//		$mail->AddReplyTo($_POST["Email"], $_POST["Name"]);
//		$mail->Priority = 3;
//		$mail->WordWrap = 250;  // set word wrap to 50 characters
//		$mail->IsHTML(true);
////		$attachment = $this->mRowObj->PDF;
////		$mail->AddAttachment($attachment);
//		$mail->Subject = "This week's flyer";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: Highland Farms <customerservice@highlandfarms.on.ca>' . "\r\n";

//		die2($this->mRowObj);
		$base = file_get_contents("media/emails/hfemail.html");
		$base = str_replace("[Image]", "media/flyers/flyer_".$this->mRowObj->ID."/mainpage.jpg", $base);
//die($base);	
		foreach ($data as $key=>$val) {
			$cleverid =  base64_encode(str_pad(date("Hi"), "6", "0", STR_PAD_RIGHT) .  rand(100000,999999) . $val["ID"]);
			$message = str_replace(array("[Name]", "[ID]","[UnsubscribeID]"), array($val["FirstName"], $val["ID"], $cleverid), $base);
//			die($message);
//			echo $message . "<hr>";
//			$mail->AddAddress($val["Email"], $val["FirstName"] . " " . $val["LastName"]);
//			$mail->Body    = $message;
//			$mail->AltBody    = $message;
			mail($val["Email"], "This week's flyer", $message, $headers);
//			$mail->ClearAddresses();					
		}
		$this->mRowObj->EmailsSent = count($data);
		$this->easySave();
		Return count($data);
	}
	

	/** comment here */
	function enableBanners() {
		$sql = "select * from flyer_images where flyerid = '".addslashes($this->mRowObj->ID)."' order by ID DESC";
		$data = $this->mDatabase->getAll($sql);

		$d = dir("media/current_banner");
		while (false !== ($entry = $d->read())) {
			if ($entry == "." || $entry == "..") continue;
			unlink("media/current_banner/" . $entry);
		}
		$d->close();

		foreach ($data as $key=>$val) {
			copy($val["ImagePath"], "media/current_banner/banner" . date("yw") . ($key+1) . ".jpg");
		}
//		die("ok");
	}
  }

?>