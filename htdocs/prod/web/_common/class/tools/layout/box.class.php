<?php   
	
	class CBox extends CObject {

		var $mStyle;
		var $mHeader;
		var $mBody;
		var $mFooter;
		
		function CBox($pBody, $pHeader,$pFooter, $pStyle) {
		  $this->mStyle = $pStyle;
		  $this->mBody = $pBody;
		  $this->mHeader = $pHeader;
		  $this->mFooter = $pFooter;
		  $this->CObject();
		}

		/** comment here */
		function display() {
		  $template = $this->mDocument->loadBoxTemplate($this->mStyle);
		  if ($template) {
			$template = str_replace("{BOX_BODY}", $this->mBody, $template);
			$template = str_replace("{BOX_HEADER}", $this->mHeader, $template);
			$template = str_replace("{BOX_FOOTER}", $this->mFooter, $template);
		  }
		  Return $template;
		}


	}


?>