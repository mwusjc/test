<?php   
/** Database Operations
* @package System
* @author Lucian Grecu
*/


class CDatabase {

	var $mHost = "localhost";
	var $mUser = "";
	var $mDb = "";
	var $mPass = "";
	var $mConnection;
	var $mQueryCnt = 0;
	var $mLogging = false;
	var $mLastInserted;
	var $mAffectedRows;
	var $mNewCols;
	var $mBenchmark;
	var $mLastQueryTime;

	function CDatabase() {
		$this->mHost = INI_DB_SERVER;
		$this->mUser = INI_DB_USER;
		$this->mPass = INI_DB_PWD;
		$this->mDb = INI_DB_DB;
		if (INI_ENABLE_LOG) $this->mLogging = true;
		$this->mBenchmark = &$GLOBALS['vBenchmark'];
	}

	/** connect to the DB server */
	function connect() {
		$con = mysql_connect($this->mHost,$this->mUser,$this->mPass);
		if (!$con) $this->dbError();
		if (!mysql_select_db($this->mDb)) {
			$this->dbError();
		} // if
		$this->mConnection = $con;
		return $this->mConnection;
	}

	/** comment here */
	function dbError() {
		if (INI_TEST_MODE)  die(mysql_error()); else die(file_get_contents("static/db_error.html"));
	}


	/** run this query on the server */
	function query($pSql, $log = true) {
		// measure the speed of query, need benchmark class
		$ret = $this->execute($pSql);
//		echo mysql_error();
		if (!$ret) {
	  		$vErrMsg = mysql_error();
			$msg = "Cannot query the database. <p><b>$pSql </b><p>Error:<br>$vErrMsg<br>Trace: ".getFileTrace();
			echo $msg;
//			$GLOBALS["vDocument"]->mErrorObj->pushError($msg, 1);
		} else {

		  if ($this->mLogging && $log) {
			$this->mBenchmark->logQuery($pSql, $this->mLastQueryTime);
			$this->mQueryCnt++;
		  }
		  return $ret;
		} // else
	}

	/** comment here */
	function execute($pSql) {
		if (!isset($vDiff)){
			$vDiff = NULL;
		}
		if ($this->mLogging) $this->mBenchmark->timingStart('mysql');
		$vResult = mysql_query($pSql,$this->mConnection);
		if ($this->mLogging) $this->mBenchmark->timingStop('mysql');
		$this->mLastInserted = mysql_insert_id($this->mConnection);
		$this->mAffectedRows = mysql_affected_rows($this->mConnection);
		if ($this->mLogging) $vDiff = $this->mBenchmark->timingElapsed('mysql');
		$this->mLastQueryTime = $vDiff;
		Return $vResult;
	}

	/** get one row/array from this query */
	function getRow($pSql) {
		$vResult = $this->query($pSql);
		if ($vRow = mysql_fetch_assoc($vResult)) {
			return $vRow;
		} // if
		return array();
	}

	/** get one row as object from this query */
	function getRowObj($pSql) {
		$vResult = $this->query($pSql);
		if ($vRow = mysql_fetch_object($vResult)) {
		   $fields = mysql_num_fields($vResult);
		   for ($i=0; $i < $fields; $i++) {
			   $type  = mysql_field_type($vResult, $i);
			   $name  = mysql_field_name($vResult, $i);
			   switch($type) {
				  case "int":
					settype($vRow->{$name}, "int");
					break;
				  case "float":
					settype($vRow->{$name}, "float");
					break;
				  default:
					settype($vRow->{$name}, "string");
					break;
			   }
	  	   }
			return $vRow;
		} // if
		return null;
	}

	/** get all rows, return a 2D array - string-indexed = column names */
	function getAll($pSql) {
		$vReturnHash = array();
		$vResult = $this->query($pSql);
		while ($vRow = mysql_fetch_assoc($vResult)) {
			if (count($vRow)==1) {
				reset($vRow);
				$vReturnHash[] = current($vRow);
			} else {
				$vReturnHash[] = $vRow;
			} // else
		} // while
		return $vReturnHash;
	}

	/** get all rows, ALWAYS return a 2D array - string-indexed = column names */
	function getAllTrue($pSql) {
		$vReturnHash = array();
		$vResult = $this->query($pSql);
		while ($vRow = mysql_fetch_assoc($vResult)) {
			$vReturnHash[] = $vRow;
		} // while
		return $vReturnHash;
	}

	/** comment here */
	function getAllAssoc($pSql) {
		$vReturnHash = array();
		$vResult = $this->query($pSql);
		while ($vRow = mysql_fetch_assoc($vResult)) {
			if (count($vRow)==1) {
				reset($vRow);
				$vReturnHash[$vRow["ID"]] = current($vRow);
			} else {
				$vReturnHash[$vRow["ID"]] = $vRow;
			} // else
		} // while
		return $vReturnHash;
	}

	function getAllExtended($pSql) {
		$vReturnHash = array();
		$vResult = $this->query($pSql);

		$mNewCols=array();
		for($i=0;$i<mysql_num_fields($vResult);$i++) {
			$mNewCols+=array($i => mysql_field_table($vResult, $i).".".mysql_field_name($vResult, $i));

		}

		while ($vRow = mysql_fetch_assoc($vResult)) {
			if (count($vRow)==1) {
				reset($vRow);
				$vReturnHash[] = current($vRow);
			} else {
				$vReturnHash[] = $vRow;
			} // else
		} // while

		return $mNewCols;
	}

	/** get all rows, return a 2D array - number-indexed starting from 0 */
	function getAll2($pSql) {
		$vReturnHash = array();
		$vResult = $this->query($pSql);
		while ($vRow = mysql_fetch_row($vResult)) {
			if (count($vRow)==1) {
				reset($vRow);
				$vReturnHash[] = current($vRow);
			} else {
				$vReturnHash[] = $vRow;
			} // else
		} // while
		return $vReturnHash;
	}

	function getAll3($pTable, $pLabelCol, $pValCol = "") {
		$vSql = "SELECT $pLabelCol as lab";
		if ($pValCol) $vSql .= ",$pValCol as val";
		$vSql .= " FROM $pTable ORDER BY 1 ASC";
		Return $this->getAll($vSql);
	}

	/** 2 fields only, get all rows, simpler, return an array_key is ids, array_value is value */
	function getAll4($pSql) {
		$vReturnAry = array();
		$rows = $this->getAll2($pSql);
		foreach ($rows AS $row) {
			$vReturnAry[$row[0]] = $row[1];
		} // for
		return $vReturnAry;
	}


	/** if there is any row, return bool */
	function getRowExisted($pTableName,$pCondQuery="") {
		if ($pCondQuery!="") {
			$vCond = "WHERE $pCondQuery";
		} // if
		$vSql = "SELECT * FROM $pTableName $vCond";
		$vRow = $this->getAll($vSql);
		return (count($vRow)>=1);
	}

	/** get one value from the DB */
	function getValue($pTableName,$pField,$pCondQuery="") {
		$vCond = "";
		if ($pCondQuery!="") {
			$vCond = "WHERE $pCondQuery";
		} // if
		$vSql = "SELECT $pField FROM $pTableName $vCond";
		$vResult = $this->query($vSql);
		$vRow = mysql_fetch_row($vResult);
		Return $vRow[0];
	}

	/** get count(something) from the DB */
	function getCount($pTableName,$pField="*",$pCondQuery="") {
		if ($pCondQuery!="") {
			$vCond = "WHERE $pCondQuery";
		} // if
		$vSql = "SELECT COUNT($pField) AS cnt FROM $pTableName $vCond";
		$vRow = $this->getRow($vSql);
		if (count($vRow)==0) {
			return 0;
		} // if
		return intval($vRow['cnt']);
	}

	/** get sum(something) from the DB */
	function getSum($pTableName,$pField,$pCondQuery="") {
		if ($pCondQuery!="") {
			$vCond = "WHERE $pCondQuery";
		} // if
		$vSql = "SELECT SUM($pField) AS total FROM $pTableName $vCond";
		$vRow = $this->getRow($vSql);
		return $vRow['total'];
	}

	/** get a row but with all empty fields */
	function clearValues($vRow) {
		$vReturnHash = array();
		foreach ($vRow AS $vKey=>$vValue) {
			$vReturnHash[$vKey] = "";
		} // foreach
		return $vReturnHash;
	}

	/** generate update query faster */
	function makeUpdateQuery($pDataAry) {
		$vUpdateAry = array();
		foreach ($pDataAry AS $vField=>$vValue) {
			$vUpdateAry[] = addslashes2($vField)."='".addslashes2($vValue)."'";
		} // for
		return implode(",",$vUpdateAry);
	}

	/** generate insert query */
	function makeInsertQuery($pDataAry) {
		$vFieldAry = array();
		$vValueAry = array();
		foreach ($pDataAry AS $vField=>$vValue) {
			if ($vValue) {
			  $vFieldAry[] = addslashes2($vField);
			  $vValueAry[] = "'".addslashes2($vValue)."'";
			}
		} // foreach
		$vFields = implode(",",$vFieldAry);
		$vValues = implode(",",$vValueAry);
		return "($vFields) VALUES ($vValues)";
	}

	/** make one insert query with multiple sets of value */
	function makeMultInsert($vFieldAry,&$vDataAry) {
		$vTmpAry = array();
		foreach ($vDataAry AS $vValueAry) {
			$vTmpAry2 = array();
			foreach ($vValueAry AS $vValue) {
				$vTmpAry2[] = "'".addslashes2($vValue)."'";
			} // for
			$vTmpAry[] = '('.implode(',',$vTmpAry2).')';
		} // foreach
		$vFields = implode(',',$vFieldAry);
		$vValues = implode(',',$vTmpAry);
		unset($vTmpAry);
		return "($vFields) VALUES $vValues";
	}

	/** add slashes to multiple vars */
	function addSlashAry($pFieldAry) {
		foreach ($pFieldAry AS $vField=>$vValue) {
			$pFieldAry[$vField] = addslashes2($vValue);
		} // foreach
		return $pFieldAry;
	}

	function getMax($pTable, $pField, $pCond){
		$vTmp = mysql_list_fields($this->mDb,$pTable,$this->mConnection);
		$vSql = "select max($pField) as max from $pTable where $pCond";
		$vMax = $this->getRow($vSql);
		return $vMax["max"];
	}

	function getMin($pTable, $pField, $pCond){
		$vTmp = mysql_list_fields($this->mDb,$pTable,$this->mConnection);
		$vSql = "select max($pField) as min from $pTable where $pCond";
		$vMax = $this->getRow($vSql);
		return $vMax["max"];
	}

	function getFieldsObject($pTable) {
		if (strpos($pTable, ".")) {
			$tmp = explode(".", $pTable);
			$vTmp = mysql_list_fields($tmp[0],$tmp[1],$this->mConnection);
			mysql_select_db($this->mDb);
		} else
			$vTmp = mysql_list_fields($this->mDb,$pTable,$this->mConnection);
		$vColumns = mysql_num_fields($vTmp);
		for($i = 0; $i < $vColumns; $i++)  {
			$vFieldName = mysql_field_name($vTmp,$i);
			$type = mysql_field_type($vTmp,$i);
			$vObject->{$vFieldName} = "";
			   switch($type) {
				  case "int":
					settype($vObject->{$vFieldName}, "int");
					break;
				  case "float":
					settype($vObject->{$vFieldName}, "float");
					break;
				  default:
					settype($vObject->{$vFieldName}, "string");
					break;
			   }
  		}
		Return $vObject;
	}

	function getLastID() {
		return $this->mLastInserted;
	}

	function getAffectedRows() {
		return mysql_affected_rows($this->mConnection);
	}

	function getRandValue($pTable, $pField) {
		$vSql = "SELECT $pField FROM $pTable ORDER BY RAND() LIMIT 1";
		$vResult = $this->getRow($vSql);
		Return $vResult[$pField];
	}


	function getFulltextKey($table){
		/* grab all keys of db.table */
		$indices=mysql_query("SHOW INDEX FROM $table")
			 or die(mysql_error());
		$indices_rows=mysql_num_rows($indices);

		/* grab only fulltext keys */
		for($nth=0;$nth<$indices_rows;$nth++){
			$nth_index=mysql_result($indices,$nth,'Index_type');
			if($nth_index=='FULLTEXT'){
				$match_a[].=mysql_result($indices,$nth,'Column_name');
			}
		}

		/* delimit with commas */
		$match=implode(',',$match_a);

		return $match;
	}

}

$vDatabase	  = new CDatabase();
$vDatabase->connect();
$vDatabase->query("SET NAMES 'utf8'");


?>
