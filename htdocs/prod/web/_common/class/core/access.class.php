<?php

	class SAccess {
		/** comment here */
		function enforce($right) {
			if ($GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID >=100) Return true;
			if (in_array($right, $GLOBALS["vDocument"]->mUserObj->mRights)) Return true;
			else {
				$GLOBALS["vDocument"]->mErrorObj->pushError("You are not logged in, or you do not have enough privileges to access this resource!", 2);
//				$this->redirect($GLOBALS["vDocument"]->mUrlObj->mScript);
				$this->redirect("index.php?o=invalid_access");
			}
		}

		function check($right) {
			if ($GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID >=100 && $GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID <= 102) Return true;
			if (in_array($right, $GLOBALS["vDocument"]->mUserObj->mRights)) Return true;
			Return false;
		}

		/** comment here */
		function isAdmin() {
			if ($GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID >=100 && $GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID <= 102) Return true;
		}

		/** comment here */
		function isSA() {
			if ($GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID >=100 && $GLOBALS["vDocument"]->mUserObj->mRowObj->GroupID <= 102) Return true;
		}

	}
?>