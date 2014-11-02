<?php   

	class CDBObject extends CObject {

	  var $mDatabase;

	  /** comment here */
	  function CDBObject() {

		$this->mDatabase = &$GLOBALS["vDatabase"];
	  	$this->CObject();

	  }


	}

?>