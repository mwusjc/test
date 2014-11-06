<?php   

	 class CAjaxScripts extends CSectionManager {

			function CAjaxScripts() {
				$this->CSectionManager();
			}

		  /** comment here */
		  function loadStates($pCountryID) {
			$states = $this->mDatabase->getAll("select ID, Name from cms_states where CountryID = '".addslashes($pCountryID)."'");
			$txt = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$txt .= '<data>' . "\n";
			foreach ($states as $key=>$val) {
				$txt .= '<option>' . "\n";
				$txt .= '<id>'.$val["ID"].'</id>' . "\n";
				$txt .= '<name>'.htmlspecialchars($val["Name"], ENT_NOQUOTES, "utf-8").'</name>' . "\n";
				$txt .= '</option>' . "\n";
			}
			$txt .= '</data>' . "\n";
			header("Content-type: application/xml");
			echo $txt;
			die;

		  }


			/** comment here */
			function checkUserName($name) {
				$forbidden = array("admin", "webmaster", "superadmin");
				$check = $this->mDatabase->getValue("users", "count(*)", "Username='".addslashes($name)."'");
				if (!$check && in_array($name, $forbidden)) $xml = "This username is not allowed!";
				if (!$check) $xml = "ok";else $xml = "This username is already taken";

			$txt = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$txt .= '<data>' . "\n";
			$txt .= '<content>'.$xml.'</content>' . "\n";
			$txt .= '</data>' . "\n";
			header("Content-type: application/xml");
			echo $txt;
			die;

			}

				/** comment here */
			function checkPwd($pwd) {
				$check = $this->mDatabase->getValue("users", "Password", "UserID='".$this->mUserID."'");
				if ($check == $pwd) $xml = "ok";else $xml = "Invalid password";

			$txt = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$txt .= '<data>' . "\n";
			$txt .= '<content>'.$xml.'</content>' . "\n";
			$txt .= '</data>' . "\n";
			header("Content-type: application/xml");
			echo $txt;
			die;

			}

			/** comment here */
			function checkEmail($name) {
				$check = $this->mDatabase->getValue("users", "count(*)", "Email='".addslashes($name)."'");
				if (!$check) $xml = "ok";else $xml = "This email addrss is not unique!";

			$txt = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$txt .= '<data>' . "\n";
			$txt .= '<content>'.$xml.'</content>' . "\n";
			$txt .= '</data>' . "\n";
			header("Content-type: application/xml");
			echo $txt;
			die;

			}

	  function mainSwitch() {
			switch($this->mOperation) {
				case "getStates":
				  Return $this->loadStates($_GET["id"]);
				case "checkName":
				  Return $this->checkUserName($_GET["name"]);
				case "checkEmail":
				  Return $this->checkEmail($_GET["name"]);
				case "checkPassword":
				  Return $this->checkPwd($_GET["pwd"]);
			}
		  }

  }

?>