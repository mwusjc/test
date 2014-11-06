<?php

	class STitle {
		/** comment here */
		function get($type, $css = "section_title") {
////			$txt = 	"<img border=\"0\" src=\"_common/images/admin/{$type}.jpg\" >";
			$txt = 	"<span class=\"$css\">$type</span>";
			Return $txt;
		}

		function set($type, $css = "section_title") {
			$txt = STitle::get($type, $css);
			$GLOBALS["vDocument"]->setPiece("SECTION_TITLE", $txt);
		}
	}
?>