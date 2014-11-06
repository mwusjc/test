<?php   
/** CRating
* @package controls
* @author cgrecu
*/

  
class CRating extends CGlobals {

  var $mCurRate;
  var $mFieldName;

  /** comment here */
  function CRating($pFldName, $pCurRate) {
	$this->CGlobals();  	
	$this->mCurRate = $pCurRate;
	$this->mFieldName = $pFldName;
  }

  /** comment here */
  function display() {
	  $vImgAry = array();
	  $vStarOff = 'images/icons/small/staroff.gif';
	  $vStarOn = 'images/icons/small/staron.gif';
	  for ($i=1;$i<=6;$i++) {
		  //$vRateIndex = $vPrefix.$i;
		  if ($i<=$this->mCurRate) {
			  $vImgAry[] = new CImage($vStarOn,15,16);
		  } else {
			  $vImgAry[] = new CImage($vStarOff,15,16);
		  } 
	  } 
	  $vImgStr = '';
	  foreach ($vImgAry AS $key=>$vImgObj) {
		  $vImgObj->setJavaScript("onMouseOver", "rateMouse('$this->mFieldName',$key);");
		  $vImgObj->setJavaScript("onMouseOut", "rateMouse('$this->mFieldName',$key);");
		  $vImgObj->mID = 'rateimg' . $this->mFieldName . $key;
		  $vImgStr .= $vImgObj->display();
	  } 
	   $this->mHtmlDoc->mHead->addScript(new CScript("","scripts/rating_simple.js"));
	  $hidRate = new CInput("rat" . $this->mFieldName, "hidden", $this->mCurRate);
	  return $hidRate->display() . $vImgStr;
  }

}

?>
