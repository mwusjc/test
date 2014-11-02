<?php   
/** html head section
* @package HTML
* @since February 06
* @author cgrecu
*/


class CHead extends CHtmlEntity{

  var $mCSS;
  var $mScripts = array();
  var $mLinks = array();
  var $mMetas = array();
  var $mObjects = array();
  var $mEmbeddedStyles;
  
  /** constructor */
  function CHead () {
	$this->mTitle = APP_TITLE;
	if (!(isset($mEmbeddedStyles))) {
	  $this->mEmbeddedStyles = array();
	}
  }

  /** comment here */
  function addCss($pLink) {
	$this->mLinks[] = new CLink($pLink, "text/css");
  }

  /** adds new javascript script to header*/
  function addScript($pScriptObj) {
  	$this->mScripts[] = $pScriptObj;
  }


  /** adds new meta element to header*/
  function addMeta($pMetaObj) {
  	$this->mMetas[] = $pMetaObj;
  }

  /** adds new link element to header*/
  function addLink($pLinkObj) {
  	$this->mLinks[] = $pLinkObj;
  }

  /** adds new object to header*/
  function addObject($pObject) {
  	$this->mObjects[] = $pObject;
  }
  

  function addToStyle(&$pName, $pLine, $pExtra = "") {
	$key = array_search($pLine, $this->mEmbeddedStyles);
	if ($key && ($pExtra == "" || strpos($key, $pExtra) == 0)) {
	  $pName = $key;
	  Return false;	
	} else {
	  if ($pExtra != "") $key = "$pName:$pExtra"; else $key = $pName;
	  $this->mEmbeddedStyles[$key] = $pLine;
	  Return true;
	}
  }

  /** create header for use in email (no script, only style) */
  function displayEmail() {
  	$tmp  = "<head>\n";
	$tmp .= '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />';
	$tmp .= '<link rel="stylesheet" type="text/css" href="http://'.$_SERVER["HTTP_HOST"].'/css/style.css"/>';
	$tmp .= "<title>$this->mTitle</title>\n";
	$tmp .= "\n";
	
	if (!(empty($this->mEmbeddedStyles))) {
	  $tmp .= '<style type="text/css">'."\n";
	  foreach ($this->mEmbeddedStyles as $key=>$val) {
	  	$tmp .= "\t " . $key . " {" . $val . "} \n";
	  } 
	  $tmp .= "</style>\n";
	}
	
	$tmp .= "</head>\n\n";
	Return $tmp;
  }

  /** FUNCTION */
  function displayStyles() {
	$tmp = '';
	if (!(empty($this->mEmbeddedStyles))) {
	  $tmp .= '<style type="text/css">'."\n";
	  foreach ($this->mEmbeddedStyles as $key=>$val) {
	  	$tmp .= "\t " . $key . " {" . $val . "} \n";
	  } 
	  $tmp .= "</style>\n";
	}
	return $tmp;
  	
  }

  /** FUNCTION */
  function displayScripts() {
	$tmp = '';
	foreach ($this->mScripts as $key=>$val) $tmp .= $val->display();
	$tmp .= "\n";
	return $tmp;
  }

  /** FUNCTION */
  function displayLinks() {
	$tmp = '';
	foreach ($this->mLinks as $key=>$val) $tmp .= $val->display();
	$tmp .= "\n";
	return $tmp;
  }

  /** comment here */
  function displayObjects() {
	$tmp = '';
	foreach ($this->mObjects as $key=>$val) $tmp .= $val->display();
	$tmp .= "\n";
	return $tmp;
  }

  /** comment here */
  function displayMetas() {
	$tmp = '';
	foreach ($this->mMetas as $key=>$val) $tmp .= $val->display();
	$tmp .= "\n";
	return $tmp;
  }

  /** creates and display the <head> tag */
  function display() {
	
	$tmp  = "<head>\n";
	$tmp .= "<title>$this->mTitle</title>\n";
	$tmp .= '<meta name="verify-v1" content="jjRkPLTPiAl8hc7vJo+LkAPpz9yKQqUKmvv/O7g3gMM=" />'."\n";
	$tmp .= "\n";
  
	$tmp .= $this->displayMetas();
	$tmp .= $this->displayScripts();
	$tmp .= $this->displayLinks();
	$tmp .= $this->displayObjects();
	$tmp .= $this->displayStyles();
	
	$tmp .= '<script language="JavaScript" type="text/javascript">

var requiredMajorVersion = 8;
var requiredMinorVersion = 0;
var requiredRevision = 0;
var jsVersion = 1.0;

</script>
<script language="VBScript" type="text/vbscript">

Function VBGetSwfVer(i)
  on error resume next
  Dim swControl, swVersion
  swVersion = 0
  
  set swControl = CreateObject("ShockwaveFlash.ShockwaveFlash." + CStr(i))
  if (IsObject(swControl)) then
    swVersion = swControl.GetVariable("$version")
  end if
  VBGetSwfVer = swVersion
End Function

</script>
<script language="JavaScript1.1" type="text/javascript">

var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;
jsVersion = 1.1;
function JSGetSwfVer(i){
	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
      		var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			descArray = flashDescription.split(" ");
			tempArrayMajor = descArray[2].split(".");
			versionMajor = tempArrayMajor[0];
			versionMinor = tempArrayMajor[1];
			if ( descArray[3] != "" ) {
				tempArrayMinor = descArray[3].split("r");
			} else {
				tempArrayMinor = descArray[4].split("r");
			}
      		versionRevision = tempArrayMinor[1] > 0 ? tempArrayMinor[1] : 0;
            flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
      	} else {
			flashVer = -1;
		}
	}
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else {
		
		flashVer = -1;
	}
	return flashVer;
} 
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision) 
{
 	reqVer = parseFloat(reqMajorVer + "." + reqRevision);
	for (i=25;i>0;i--) {	
		if (isIE && isWin && !isOpera) {
			versionStr = VBGetSwfVer(i);
		} else {
			versionStr = JSGetSwfVer(i);		
		}
		if (versionStr == -1 ) { 
			return false;
		} else if (versionStr != 0) {
			if(isIE && isWin && !isOpera) {
				tempArray         = versionStr.split(" ");
				tempString        = tempArray[1];
				versionArray      = tempString .split(",");				
			} else {
				versionArray      = versionStr.split(".");
			}
			versionMajor      = versionArray[0];
			versionMinor      = versionArray[1];
			versionRevision   = versionArray[2];
			
			versionString     = versionMajor + "." + versionRevision;   // 7.0r24 == 7.24
			versionNum        = parseFloat(versionString);
			if ( (versionMajor > reqMajorVer) && (versionNum >= reqVer) ) {
				return true;
			} else {
				return ((versionNum >= reqVer && versionMinor >= reqMinorVer) ? true : false );	
			}
		}
	}	
	return (reqVer ? false : 0.0);
}
</script>';
	$tmp .= "</head>\n\n";
	Return $tmp;
  }
  

  function getScript($pName) {
  	foreach ($this->mScripts as $key=>$val) {
  		if ($val->mName == $pName) 
		  Return $key;
  	}
	Return -1;
  }



}

?>
