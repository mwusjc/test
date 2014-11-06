<?php   
/** some string functions
* @package Other
* @since 5/4/2004
* @author Son Nguyen
*/
class CString {
	var $mStr;
	/** constructor */
	function CString($pStr='') {
		$this->mStr = $pStr;
	}

	/** shorten a string, anything longer, pad with ... */
    function shorten($pMaxLength=40) {
		if (strlen($this->mStr)>$pMaxLength) {
			$this->mStr = substr($this->mStr,0,$pMaxLength).'...';
		} // if
		Return $this->mStr;
    } 

	/** comment here */
	function parseSmilies($emoticons) {

	  foreach ($emoticons as $key=>$val) {
		$vImage = new CImage("images/smiles/" . $val["smile_url"]);
		$search[] = $val["code"];
		$replace[] = $vImage->display();
	  }
	  $this->mStr = str_replace($search, $replace, $this->mStr);

	}

	/** copy paste from old site .... :) */
	function replaceLinks() {
	  // pad it with a space so we can match things at the start of the 1st line.
	  $ret = " " . $this->mStr;

	  // matches an "http://yyyy" URL at the start of a line, or after a space.
	  // xxxx can only be alpha characters.
	  // yyyy is anything up to the first space, newline, or comma.
	  $ret = preg_replace("#([\n ])([a-z]+?)://([a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $ret);

	  // matches a "www.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	  // Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	  // yyyy contains either alphanum, "-", or "."
	  // zzzz is optional.. will contain everything up to the first space, newline, or comma.
	  // This is slightly restrictive - it's not going to match stuff like "forums.foo.com"
	  // This is to keep it from getting annoying and matching stuff that's not meant to be a link.
	  $ret = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $ret);

	  // matches an email@domain type address at the start of a line, or after a space.
	  // Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
	  $ret = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

	  // Remove our padding..
	  $ret = substr($ret, 1);

	  $this->mStr = $ret;
		
	}

	/** comment here */
	function parseTags() {
	  $this->mStr = str_replace("[quote]","<div style=\"float:top; margin-left:4px;border-width:0px 1px; border-color:".$this->mColText2."; border-style:solid; font-style:italic; font-size:7pt; width:97%; background-color:#f0f0f0;\">", $this->mStr); 	
	  $this->mStr = str_replace("[/quote]","</div>", $this->mStr); 	
	}

	/** return the string */
	function display($pMaxLength = 0) {
	  if ($pMaxLength) $this->shorten($pMaxLength);
	  return $this->mStr;
	}

	/** generate sound-able password */
	function mkPassword() {
        $consts='bcdgklmnprst';
        $vowels='aeiou';
        for ($x=0; $x < 6; $x++) {
			mt_srand ((double) microtime() * 1000000);
			$const[$x] = substr($consts,mt_rand(0,strlen($consts)-1),1);
			$vow[$x] = substr($vowels,mt_rand(0,strlen($vowels)-1),1);
        } // for
        $randNum = mt_rand(1000,9999); // 4 digit random number
		return $const[0].$vow[0].$const[2].$const[1].$vow[1].$const[3].$vow[3].$const[4].$randNum;
    } 

	/** comment here */
	function limited_ucfirst($min_word_len = 3, $always_cap_first = true, $exclude = array()) {
	  $text = $this->mStr;
	  if (empty($exclude)) $exclude = Array("of","a","the ","and","an",
											"or","nor","but","is",
											"if","then","else","when","up",
											"at","from","by","on",
											"off","for","in","out","over",
											"to","into", "with", "the");
	  // Allows for the specification of the minimum length 
	  //  of characters each word must be in order to be capitalized
	  // Make sure words following punctuation are capitalized
	  $text = str_replace(Array("(", "-", ".", "?", ",",":","[",";","!"), 
							Array("( ", "- ", ". ", "? ", ", ",": ","[ ","; ","! "), $text);
	  $words = explode (" ", strtolower($text));
	  $count = count($words); 
	  $num = 0; 
	  while ($num < $count) { 
		if (strlen($words[$num]) >= $min_word_len
			&& array_search($words[$num], $exclude) === false)
		  $words[$num] = ucfirst($words[$num]); 
		$num++; 
	  } 
	  $text = implode(" ", $words); 
	  $text = str_replace(
	  Array("( ", "- ", ". ", "? ", ", ",": ","[ ","; ","! "),
	  Array("(", "-", ".", "?", ",",":","[",";","!"), $text);
	  // Always capitalize first char if cap_first is true
	  if ($always_cap_first) {
		if (ctype_alpha($text[0]) && ord($text[0]) <= ord("z") 
		   && ord($text[0]) > ord("Z"))
		  $text[0] = chr(ord($text[0]) - 32);
	  }
	  $this->mStr = $text;
  }

  /** comment here */
  function getParagraph($pLength) {
	$input = trim(strip_tags($this->mStr, "<br><p><a><li>")); 
	$input2 = strtolower($input);
	$search = 0;
	$search = strpos($input2, "<p", $search);
	$thresh = 1.05 * $pLength;
	$len = 0;
	$temp = "";
	if ($search === 0 || $search) {
	  if ($search) {
		$temp = substr($input, 0 , $search);
		$len = strlen($temp);
	  } else {
	  	$posA = strpos($input2, "</p>");
		$posB = strpos($input2, "<p>");
		if ($posB && $posB < $posA) $pos = $posB; else $pos = $posA;
		$part = "";
		if ($pos) {
		  $start = strpos($input2, ">", $search+1);
		  $part = substr($input, $start+1, $pos - $start - 1); 
		} 
	    $parags[] = $part;
		$len += strlen($part);
	  }

	  while($search = strpos($input2, "<p", $search+1)) {
		if ($len > $thresh) break;
		$posA = strpos($input2, "</p>", $search + 1);
		$posB = strpos($input2, "<p>", $search + 1);
		if ($posB && $posB < $posA) {
		  //bad, means <p> tag has no corresponding </p>
		  $pos = $posB;
		} else $pos = $posA;
		$part = "";
		if ($pos) {
		  $start = strpos($input2, ">", $search+1);//end of <p> tag
		  $part = substr($input, $start + 1, $pos - $start - 1); 
		} else break;
		$partlen = strlen($part);
		if ($partlen > $thresh) {
		  $partpos = strpos($part, ".", $thresh);
		  $part = substr($part, 0 , $partpos +1);
		  $partlen = strlen($part);
		}
		
		//echo $pos. " $start " . ($pos - $start - 1) . " - " . substr($input2, $search) . "<br> - $part <p>";
		if ($partlen < 8) continue;
	    $parags[] = $part;
		$len += $partlen;
	  }
	  if (!empty($parags)) $temp .= implode("<p>", $parags) ;

	} else {
		Return substr($input, 0, min(round(1.05*$pLength), strlen($this->mStr)));
	}
  	Return $temp;
  }

  function getPiece($pLength) {
	$thresh = min(strlen($this->mStr),$pLength) - 1;
	
	$partpos = strpos($this->mStr, ".", $thresh);
	if (!$partpos) $partpos = $thresh;
	return substr($this->mStr, 0 , $partpos +1);
  }

  /** str_replace with no case sensitivity */
  function str_replaceNC($pSearch, $pReplace, $pSubject = "") {
	if ($pSubject = "") $pSubject = $this->mStr;
	if ($pSearch == "" || $pReplace == "") Return $pSubject;
	if ($pSearch == $pSubject) Return $pReplace;
	$len2 = strlen($pSearch);
	$len = strlen($pSubject);
	if ($len <= 0) Return $pSubject;
	$pUCaseSubject = strtoupper($pSubject);
	$pSearch = strtoupper($pSearch);
	$newstring = "";
  	for($i=0; $i<$len; $i++) {
		//begin search for substring  
  		if ($pUCaseSubject[$i] == $pSearch[0]) {
		  $match = true;
		  for($j=1; $j<$len2; $j++) {
			if ($i + $j > $len) $match = false;
		  	if ($pUCaseSubject[$i+$j] != $pSearch[$j]) $match = false;
			if (!$match) break;
		  }//end for
		  if ($match) { //match found
			$newstring .= $pReplace;
			$i += ($len2-1);
		  } else {
		  	$newstring .= $pSubject[$i];
		  }//end if
		} else {
			$newstring .= $pSubject[$i];
		}//end if
  	} //end for
	Return $newstring;
  }


}

?>