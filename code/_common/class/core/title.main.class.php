<?php

	class STitle {
		function set($title) {
			$GLOBALS["vDocument"]->mHead->mTitle = $title;
		}
	}
?>