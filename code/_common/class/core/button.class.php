<?php   

	class SButton {
		/** comment here */
		function get($type, $action = "") {
			if ($action) {
				$txt = 	"<img border=\"0\" style=\"cursor: pointer;\" onclick=\"$action\" src=\"_common/images/admin/btn_{$type}.png\" onmouseover=\"this.src='_common/images/admin/btn_{$type}_hover.png';\" onmouseout=\"this.src='_common/images/admin/btn_{$type}.png';\">";
			} else {
				$txt = 	"<input type=\"image\" style=\"border: 0px; background-color: transparent;\" src=\"_common/images/admin/btn_{$type}.png\" onmouseover=\"this.src='_common/images/admin/btn_{$type}_hover.png';\" onmouseout=\"this.src='_common/images/admin/btn_{$type}.png';\">";
			}
			Return $txt;
		}
	}
?>