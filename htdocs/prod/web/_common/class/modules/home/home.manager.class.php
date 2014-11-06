<?php   

class CHomeManager extends CSectionManager {

  /** comment here */
  function CHomeManager() {
	$this->CSectionManager();
  }

  function display() {
	return "BODY HERE";
  }


  /** comment here */
  function registerClasses() {
  $this->mClasses[] = array("events", "CEvent");
  }

  /** comment here */
  function mainSwitch() {
	switch($this->mOperation) {
		case "brand": Return "brand";
	default:
	  Return CSectionManager::mainSwitch();
	}
  }

	
}

?>