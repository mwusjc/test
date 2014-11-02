<?php
/** comment here */
function dienice($pMsg) {
echo "<div class=\"warning\">$pMsg</div>";die;
}
/** comment here */
function die2($errs) {
 print_r($errs);
 die();
}

/** comment here */
function die3() {
 print_r($_REQUEST);
 print_r($_GET);
 print_r($_POST);
 die();
}

/** comment here */
function debug() {
	ini_set("display_errors", "on");
	error_reporting(E_ALL);
}

/** comment here */
function xmlentities($txt) {

//	$in = array(chr(147), chr(148), chr(146), chr(96));
//	$out = array('"','"',"'","'","'");
//	$txt = str_replace($in, $out, $txt);
//	Return $txt;
	Return htmlspecialchars(trim($txt), ENT_QUOTES,"UTF-8");
}

/** comment here */
function xml($txt) {
	$txt2 = ob_get_contents();
	ob_end_clean();
  	$txt = '<?xml version="1.0" encoding="utf-8" ?><data>'.$txt.'</data>';
	header("Content-type: application/xml");
	echo $txt;
//	echo $txt2;
	exit;

}


/** comment here */
function addslashes2($txt) {
  $check = ini_get("magic_quotes_gpc");
  if ($check) Return $txt;
  Return addslashes($txt);
}

/** comment here */
function filterApos($txt) {
  Return  str_replace(array("&apos;", "&acirc;"), "'", $txt);

}

// overwrite the default error handler
//set_error_handler("userErrorHandler");

/** user defined error handling function */
function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {
	// timestamp for the error entry
	$dt = date("Y-m-d H:i:s (T)");

	$vDebug = debug_backtrace();
	$vFiles = array();
	for ($i=0;$i<count($vDebug);$i++) {
		// skip the first one, since it's always this log func
		if ($i==0) { continue; }
		$aFile = $vDebug[$i];
		$vFiles[] = '('.basename($aFile['file']).':'.$aFile['line'].')';
	} // for
	$vTrace = implode(',',$vFiles);

	$err = "<errorentry>\n";
	$err .= "\t<scriptname>".$filename."</scriptname>\n";
	$err .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\n";
	$err .= "\t<errormsg>".htmlspecialchars($errmsg)."</errormsg>\n";
	$err .= "\t<datetime>".$dt."</datetime>\n";
	$err .= "\t<referer>".htmlspecialchars(getenv("HTTP_REFERER"))."</referer>\n";
	$err .= "\t<uri>".htmlspecialchars(getenv("REQUEST_URI"))."</uri>\n";
	$err .= "\t<ip>".htmlspecialchars(getenv("REMOTE_ADDR"))."</ip>\n";
	$err .= "\t<backtrace>".$vTrace."</backtrace>\n";
	$err .= "</errorentry>\n\n";

	// save to the error log
	$vLogFile = 'errors.xml';
	if (file_exists($vLogFile) && false) {
		error_log($err, 3,$vLogFile);
	} else {
		echo("<pre>$err</pre>");
	} // else
}

/** user defined error handling function */
function objOnDemand($errno, $errmsg, $filename, $linenum, $vars) {
	echo('ok');
//	if ($filename == 'c:\work\newsite\class\content\jobs\job.manager.class.php') {
		var_dump($errno,$errmsg,$filename,$linenum);die;
//	}
}


/** comment here */
function set_cookie($pVar, $pVal, $pTime = '') {
  if (!$pTime) $pTime = time() + INI_COOKIE_EXPIRATION;
  Return setcookie($pVar, $pVal, $pTime, '/',"." . APP_DOMAIN);
}

  function randStringGen() {
	$len = 12;
	$chars = " ABCD EFGH IJKL MNOP QRST UVWX YZabcd efgh ijkl mnopq rstuv wxyz0 1234 5678 9";
	$num = strlen($chars);
	$txt = "";
	$i = 0;
	while ($i < $len) {
	  $pos = rand(1, $num);
	  $buff = substr($chars, $pos, 1);
	  $txt .= $buff;
	  $i++;
	}
	return $txt;
  }

  /** calculate the percentage */
  function getPercentage($pOne,$pTotal) {
	  $vPercent = ($pTotal!=0)?($pOne/$pTotal)*100:0;
	  return number_format($vPercent,2).'%';
  }

	/** get the history of this call */
	function getFileTrace() {
		$vDebug = debug_backtrace();
		$vFiles = array();
		for ($i=0;$i<count($vDebug);$i++) {
			// skip the first one, since it's always this log func
			if ($i==0) { continue; }
			$aFile = $vDebug[$i];
			$vFiles[] = '('.basename($aFile['file']).':'.$aFile['line'].')';
		} // for
		return implode(',',$vFiles);
	}

	/** comment here */
	function paragraph($txt, $len) {
		$temp = explode(" ", $txt);
		$ret = "";
		foreach ($temp as $key=>$val) {
			if ((strlen($ret) + strlen($val) + 1) < ($len - 4)) $ret .= " " . $val;
		}
		if ($ret != $txt) $ret .= " ...";
		Return $ret;
	}

	/** comment here */
	function br2nl($text)
	{
		return  preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
?>
