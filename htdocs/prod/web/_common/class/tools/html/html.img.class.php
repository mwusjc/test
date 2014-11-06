<?php   
/** html image class
* @package HTML
* @since February 06
* @author cgrecu
*/


class CImage extends CHtmlEntity {
  
  var $mSrc;
  var $mBorder = 0;
  var $mHeight;
  var $mWidth;
  
  function CImage($pSrc, $pWidth="", $pHeight="") {
	$this->CHtmlEntity();
  	$this->setSrc($pSrc);
	$this->setHeight($pHeight);
	$this->setWidth($pWidth);
  }

  function display() {
	$tmp = "";
	$this->mSrc = $this->getFullLink($this->mSrc);
	if ($this->mSrc) $tmp = "<img  " .  $this->addCommonAttributes() . " src=\"".$this->mSrc."\"/>";
	else $tmp = "noimage";
	Return $tmp;
  }

  function displayExtended() {
  	$tmp = "";
	if ($this->mSrc != "") {
	  $tmp = "<img src=\"".$this->mSrc."\"";
	  $tmp .= (($this->mHeight) ? " height=\"".$this->mHeight."\"" : "");
	  $tmp .= (($this->mWidth) ? " width=\"".$this->mWidth . "\"" : "");
	  $tmp .= (($this->mBorder) ? " border=\"".$this->mBorder . "\"" : "");
	  $tmp .= $this->addCommonAttributes();
	  $tmp .= "/>";
	  Return $tmp;
	} else {
		Return "noimage";
	}
  }

  function setHeight($pHeight) {
  	$this->mHeight = $pHeight;
  }

  function setWidth($pWidth) {
  	$this->mWidth = $pWidth;
  }


  function setSrc($pSrc) {
  	$this->mSrc = $pSrc;
  }

  /** comment here */
  function fitImage($pWidth) {

	$vImgAttr = @getimagesize($this->mSrc);
	if (!empty($vImgAttr)) {
	  $this->mWidth = $vImgAttr[0];
	  $this->mHeight = $vImgAttr[1];
	  $vMax = max($this->mWidth, $this->mHeight);
	  if ($vMax >= $pWidth) {
		$vFactor = $pWidth/$vMax;
		$this->mWidth = round($this->mWidth * $vFactor) ."px";
		$this->mHeight = round($this->mHeight * $vFactor) ."px";
	  }
	  Return $this->display();  	
	}	
	Return "noimage";
  }

}

?>