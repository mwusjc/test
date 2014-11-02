<?php 

  class CDBContent extends CDBObject {

	var $table;
	var $pk = "ID";
	var $mRowObj;
	var $mContentLabField = "Name";
	var $mToggleStates = array("enabled", "disabled");

	/** comment here */
	function CDBContent($pID = "") {
	  $this->CDBObject();
	  if (!$pID || is_numeric($pID)) $this->init($pID);
	}

	/** call this for every content class to init mrowobj */
	function init($pContentID) {
	  if (!$pContentID) $pContentID = intval($pContentID);
	  if ($pContentID) {
		  $vSql = "SELECT * FROM ".$this->table." WHERE ".$this->pk."='$pContentID'";
		  $this->mRowObj = $this->mDatabase->getRowObj($vSql);
	  } else {
		  $this->mRowObj = $this->mDatabase->getFieldsObject($this->table);
	  }
	}

	/** comment here */
	function initData($pVal) {
		foreach ($this->mRowObj as $key=>$val) {
			$this->mRowObj->$key = "";
			if (isset($this->mRowObj->$key)) $this->mRowObj->$key = $pVal[$key];

		}

	}

	/** comment here */
	function resetData() {
		foreach ($this->mRowObj as $key=>$val) {
			$this->mRowObj->$key = "";
		}
	}

	/** call this to register POST variables that match the RowObj object's properties */
	function registerForm($pArray = array()) {
	  if (empty($pArray)) $pArray = $_POST;
	  foreach (get_object_vars($this->mRowObj) AS $key=>$val) {
		  if (isset($pArray["$key"]))
			/* if variable is an array( coming from a select element) then
			**  if the array only has one element then the array is destroyed and the element is registered directly
			**	else, if the array has more than one element then the whole array will be passed as a variable
			**  WARNING: in the last case, the RowObj object cannont be saved directly to the database !! */
			if (is_array($pArray["$key"])) {
			  if (count($pArray["$key"])==1) {
				$this->mRowObj->{$key} = $pArray["$key"][0];
			  } else {
				$this->mRowObj->{$key} = $pArray["$key"];
			  }

			} else {
			  $this->mRowObj->{$key} = $pArray["$key"];
			}
	  }
//	  foreach ($this->mRowObj as $key=>$val) {
//		if (is_numeric($val)) $this->mRowObj->$key=$val * 1;
//	  }

	}


	/** call this to register POST variables that match the RowObj object's properties */
	function unregisterForm() {
	  foreach (get_object_vars($this->mRowObj) AS $key=>$val) {
		$_POST["$key"] = $this->mRowObj->{$key};
	  }
	}

	/** comment here */
	function loadPostData() {
	  $_POST = $_SESSION["gPOST"];
	  foreach (get_object_vars($this->mRowObj) AS $key=>$val) {
		if (!$_POST[$key] && $val) $_POST[$key] = $val;
	  }
	  unset($_SESSION["gPOST"]);
	}

	/** save function */
	function save($pType = "single") {
		$vFields = get_object_vars($this->mRowObj);
		if ($this->mRowObj->{$this->pk}) {
			// update
			$vUpdateQuery = $this->mDatabase->makeUpdateQuery($vFields);
			$vSql = "UPDATE ".$this->table." SET $vUpdateQuery WHERE ".$this->pk."='".$this->mRowObj->{$this->pk}."'";
			$vResult = $this->mDatabase->query($vSql, $pType);
		} else {
			//insert
		  if(!$vFields["TimeStamp"]&&array_key_exists("TimeStamp",$vFields)) $vFields["TimeStamp"] = time();

		  $vInsertQuery = $this->mDatabase->makeInsertQuery($vFields);
		  $vSql = "INSERT INTO ".$this->table." $vInsertQuery";
		  $vResult = $this->mDatabase->query($vSql, $pType);
		  $this->init($this->mDatabase->getLastID());
		}
		Return $vResult;
	}

	/** save function */
	function easySave($pType = "single") {

		$vFields = get_object_vars($this->mRowObj);
		if ($this->mRowObj->{$this->pk}) {
			// update
			$vUpdateQuery = $this->mDatabase->makeUpdateQuery($vFields);
			$vSql = "UPDATE ".$this->table." SET $vUpdateQuery WHERE ".$this->pk."='".$this->mRowObj->{$this->pk}."'";
			$vResult = $this->mDatabase->query($vSql, $pType);
//			die($vSql);
		} else {
			//insert
		  if(!$vFields["Timestamp"]&&array_key_exists("Timestamp",$vFields)) $vFields["Timestamp"] = time();
		  $vInsertQuery = $this->mDatabase->makeInsertQuery($vFields);
		  $vSql = "INSERT INTO ".$this->table." $vInsertQuery";
		  $vResult = $this->mDatabase->query($vSql, $pType);
		  $this->init($this->mDatabase->getLastID());
		}
		Return $vResult;
	}

	function delete($pType = "single") {
	  $vSql = "DELETE FROM ".$this->table." WHERE ".$this->pk."='".$this->mRowObj->{$this->pk}."'";
	  Return $this->mDatabase->query($vSql, $pType);
	}

	/** check name for uniqueness */
	function checkName() {
	  $vCount = $this->mDatabase->getValue($this->table,"count(*)","upper(".$this->mContentLabField.") = upper('".$this->mRowObj->{$this->mContentLabField}."') and " . $this->pk . " <> '" . $this->mRowObj->{$this->pk} . "'");
	  if ($vCount > 0) Return false;
	  Return true;
	}

	/** comment here */
	function toggle() {
	  if ($this->mRowObj->Status == "disabled" || !$this->mRowObj->Status) $this->mRowObj->Status = "enabled"; else $this->mRowObj->Status = "disabled";
	  $this->easySave();
	}

	/** comment here */
	function move($pDirection, $pType = "single") {
	  $info = $this->mDatabase->getRow("select max(OrderID) as mx, min(OrderID) as mn from ". $this->table ." where OrderID < 999999 and OrderID >0");
	  if ($pDirection == "up" && $info["mn"] == $this->mRowObj->OrderID) {
		$this->mLastError = "Item is already in first position!";
		Return false;
	  }
	  if ($pDirection == "down" && $info["mx"] == $this->mRowObj->OrderID) {
		$this->mLastError = "Item is already in last position!";
		Return false;
	  }
	  if ($pDirection == "up")
		$pos = $this->mDatabase->getValue($this->table, "max(OrderID)", "OrderID < ". $this->mRowObj->OrderID);
	  else
		$pos = $this->mDatabase->getValue($this->table, "min(OrderID)", "OrderID > ". $this->mRowObj->OrderID . " and OrderID < 999999");
	  if ($pos == "999999" && $this->mRowObj->OrderID == 999999) $this->mRowObj->OrderID = 999998;
	  $this->mDatabase->query("update " . $this->table . " set OrderID = '".$this->mRowObj->OrderID."' where OrderID = $pos", $pType);
	  $this->mRowObj->OrderID = $pos;
	  $this->easySave();
	}

	/** comment here */
	function checkOwner() {
	  if (!$this->isAdmin() || !$this->mRowObj->ID || !$this->mRowObj->UserID || $this->mRowObj->UserID == $this->mUserID) Return true;
	  else {
		$this->error("You don't have the right to edit this page", 3);
	  }
	}

	/** comment here */
	function displayEdit() {
	  $vForm = new CForm("frmEdit", $this->getStdLink("save", $this->mRowObj->ID));

	  $txtSubject = new CInputT("Name", $this->mRowObj->Name);
	  $txtSubject->seta("width","385px");
	  $vForm->add($txtSubject->validate('The field is empty!'));
	  $rows[] = array("Label: ", $txtSubject->display());
	  $btOk = new CSubmit("Save");
	  $vTable = new CGridTable($rows, array(), array($btOk->display()), "stdedit");
	  $vTable->mTemplates["table"]["width"] = "100%";
	  Return $vForm->display($vTable->display());

	}

  }
?>