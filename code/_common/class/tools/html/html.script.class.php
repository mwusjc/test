<?php   
/** script (javascript) objects
* @package HTML
* @since February 06
* @author cgrecu
*/


class CScript {
  
  var $mContent;
  var $mSrc;
  var $mName;
  
  /** constructor */
  function CScript($pContent, $pSrc = "") {
	$this->mContent = $pContent;
	$this->mSrc = $pSrc;

  }

  /** creates html code for javascript */
  function display() {
  	Return "<script type=\"text/javascript\" ".
		(($this->mSrc!="")? "src=\"$this->mSrc\" ":"").">".
		(($this->mContent!="")?"\n$this->mContent\n":"")."</script>\n";
  }

  /** gives a script an identification name */
  function setName($pName) {
  	$this->mName = $pName;
  }

  /** add a piece of code to the mContent */
  function addCode($pCode) {
  	$this->mContent .= $pCode;
  }
}

?>
