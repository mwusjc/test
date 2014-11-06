<?php   
/** href entities
* @package HTML
* @since February 06
* @author cgrecu
*/


class CHref extends CHtmlEntity {

  var $mURL;
  var $mTarget;
  var $mTrack = false;
  var $mDoRewrite = false;


  function CHref($pURL="", $pLabel="", $pClass = "", $pTarget ="") {
	$this->CHtmlEntity();
	$this->mURL = $pURL;
	$this->mLabel = $pLabel;
	$this->mClass = $pClass;
	$this->mTarget = $pTarget;
	if (INI_MOD_REWRITE) $this->mDoRewrite = true;

  }

  function display($pWithTrack = false) {
	Return $this->displayUrl();
  }

  /** comment here */
  function displayUrl($pRewrite = true) {
  	$tmp = "";
	# if mod rewrite (APACHE ONLY) encode Url
	if ($pRewrite && $this->mDoRewrite) $this->modRewriteURL();
	if ($this->mURL != "#" && $this->mURL != "" && $this->mFullLinks) {
	  $vBase = substr($this->mURL,0,4);
	  if (strtolower($vBase) != "http") $this->mURL = "http://" . APP_DOMAIN . "/".$this->mURL;
	}
	$tmp = "<a href=\"".$this->mURL."\"";
	$tmp .= !empty($this->mTarget) ? " target=\"".$this->mTarget."\"" : "";
	$tmp .= $this->addCommonAttributes();
	$tmp .= ">".$this->mLabel."</a>";
	Return $tmp;
  }

  /** comment here */
  function modRewriteURL() {
	$anchor = strpos($this->mURL, '#');
	if ($anchor) {
	  $url = substr($this->mURL, 0, $anchor);
	  $post = substr($this->mURL, $anchor);
	} else {
	  $url = $this->mURL;
	  $post = "";
	}
	$this->mURL = base64_encode($url) . ".htm" . $post;  	
  }

  /** comment here */
  function parseUrl() {
	if ($this->mTrack) $this->mURL = "index.php?redirect=" . urlencode($this->mURL);
  }

}

?>
