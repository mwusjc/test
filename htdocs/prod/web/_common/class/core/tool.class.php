<?php   
	
	class CTools  {

		/** comment here */
		function CTools() {
			
		}

		function formatFileSize($size)
		{
		  $count = 0;
		  $format = array("B","KB","MB","GB","TB","PB","EB","ZB","YB");
		  while(($size/1024)>1 && $count<8)
		  {
		  $size=$size/1024;
		  $count++;
		  }
		  $return = number_format($size,0,'','.')." ".$format[$count];
		  return $return;
		}

	}

?>