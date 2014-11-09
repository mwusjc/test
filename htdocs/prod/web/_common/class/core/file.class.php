<?php
/** File Manager
* @package System
* @author Lucian Grecu
*/

include_once('function.sizeify.php');

class CFileManager {
	var $mBaseDir;
	var $mUploadDir = 'media';
	var $mLastError;

	/** constructor */
	function CFileManager() {
		$this->mBaseDir = $_SERVER['DOCUMENT_ROOT']."/";
	}

	/** comment here */
	function error($Error, $Severity = 2) {
		$GLOBALS["vDocument"]->mErrorObj->pushError($Error, $Severity);
	}

	/** get file, whatever is put in */
	function getFile($pFile) {
		return file_get_contents($pFile);
	}

	/** copy content of one file to another */
	function moveTmpFile($pSrc,$pDest) {
		$vOutput = file_get_contents($pSrc);
		if (!$vHandle = fopen($pDest,"w")) {
			dienice("Cannot open destination file [$pDest] for writing");
		} // if

		if (!fwrite($vHandle, $vOutput)) {
			dienice("Cannnot write to destination file [$pDest]");
		} // if
		fclose($vHandle);
	}

	function makeThumbNail($pFile,$thumbNailPath) {

	}

	function resizeImg($pFile,$pSize){
		system("convert.exe  ".$pFile." -resize \"".$pSize."x".$pSize.">\" ".$pFile);
	}

	function makeFolderThumbNail($pFile, $pBackGround, $pthumbNailPath) {
		system("composite $pFile -resize 80x70 $pBackGround -compose bumpmap -gravity center $pthumbNailPath");
	}

	function makeLogo($pFile, $pBackGround, $pOut, $pDimensinons, $pPosition){

		system("composite ".$pFile." ".$pDimensinons." ".$pBackGround." ".$pPosition." ".$pOut);
	}

	/** upload file to the server */
	function uploadFile($pFile,$pUploadPath) {

		//	create the dir if it doesn't exist
		$dir_bits = explode('/',$pUploadPath);
		array_pop($dir_bits);
		$the_dir = implode('/',$dir_bits);
		if (!file_exists($the_dir)) {
			mkdir($the_dir,0777,true);
		}

		//die($pUploadPath);
		if($ret = move_uploaded_file($pFile,$pUploadPath)) {
			Return true;
		} else {
			$this->error("Upload failed because of a system problem. It looks like you don't have permission to write in the movie directory!");
			return false;
		}
	}

	/** comment here */
	function downloadFile($pUrl, $pDownloadPath, $pMaxSize = 2048) {
		$vHandle = @fopen($pUrl,'rb');
		if (!$vHandle) {
			$this->error("Path not found");
			return false;
		}
		$vBuffer = "";
		$vFileTooBig = true;
		for($i=0; $i<$pMaxSize; $i++) {
			$vTmp = fread($vHandle, 8192);
			if ($vTmp) $vBuffer .= $vTmp;
			else {
				$vFileTooBig = false;
				break;
			}
		}
		if ($vFileTooBig) {
			$this->error("File is too big! Maximum size for uploads limited to 16MB");
			return false;
		}
		fclose($vHandle);

		$vHandle = @fopen($pDownloadPath, 'w');
		if ($vHandle) {
			$vReturn = fwrite($vHandle, $vBuffer);
			fclose($vHandle);
			$vSize =  filesize($pDownloadPath);
			if ($vSize <= 10) {
			  $this->error("Download failed to complete");
				return false;
			}
		} else {
			$this->error("Download failed because you don't have rights to write in this directory!");
			return false;
		}
		if ($vReturn) return true;
		Return false;
	}

	function verifyExt($exr,$pMediaType="image"){

		$vAllowedDocExt = array("doc","txt","html","rtf","pdf","ppt","xls","csv");
		$vAllowedImgExt = array("bmp","gif","png","jpg","jpeg","swf","mov","wav");

		switch ($pMediaType) {
			case 'image':
			$vAllowedExt = $vAllowedImgExt;
			break;
			case 'document':
			$vAllowedExt = $vAllowedDocExt;
			break;
			case 'movie':
			case "any":
			$vAllowedExt = array_merge($vAllowedDocExt,$vAllowedImgExt);
			break;
			default:
			$vAllowedExt = array();
			break;
		} // switch


		if ($pMediaType != 'any' && !in_array($ext,$vAllowedExt)) {
			$this->error("Invalid extension: <b>$ext</b>!<p>Allowed extensions are ".implode(', ',$vAllowedExt));
			Return false;
		} // if

		if ($pMediaType == 'image') {
		  if (!getimagesize($pFile)) {
			$this->error("Invalid image file, the document you specified is not a valid image!");
			Return false;
		  }
		}
		return true;
	}

	/** comment here */
	function getDestinationPath($pOriginalName, $pMediaType, $pUserID) {
		$pOriginalName = pathinfo($pOriginalName);
		$pOriginalName = $pOriginalName["basename"];
		$pOriginalName = addslashes($pOriginalName);
		if (preg_match("/\.([^\.]*?)$/",$pOriginalName,$matches)) {
			$ext = strtolower($matches[1]);
		} else {
			$ext = "";
		} // else



		$vAllowedDocExt = array("doc","txt","html","rtf","pdf","");
		$vAllowedImgExt = array("bmp","gif","png","jpg","jpeg", "swf", "wav","");

		switch ($pMediaType) {
			case 'image':
			  $vAllowedExt = $vAllowedImgExt;
			break;
			case 'document':
			  $vAllowedExt = $vAllowedDocExt;
			break;
			case "any":
			  $vAllowedExt = array_merge($vAllowedDocExt,$vAllowedImgExt);
			case 'movie':
			$vAllowedExt = array_merge($vAllowedDocExt,$vAllowedImgExt);
			break;
			default:
			$vAllowedExt = array();
			break;
		} // switch

		// check extension
		if (!in_array($ext,$vAllowedExt)) {
			$this->error("Invalid extension: <b>$ext</b>!<p>Allowed extensions are ".implode(', ',$vAllowedExt));
			Return false;
		} // if

	$newFileName = md5(uniqid(rand(), true));
	$vFullPath = $this->mUploadDir . "/fullimages/$newFileName";

		Return $vFullPath;
	}

	/** comment here */
	function upload($pName, $pType, $pDir) {

		$file = $_FILES[$pName];
		if (!$file["name"]) Return false;
		$fileparts = explode(".", $file["name"]);
		$ext = array_pop($fileparts);
		$check = $this->verifyExt($ext, $pType);
		if ($check) {
			$vName = uniqid(implode("_", $fileparts)) . "." . $ext;
			$vName = $pDir . "/" . $vName;
			if ($this->uploadFile($file["tmp_name"], $vName)) Return $vName;
			else Return false;
		} else {
			Return false;
		}
	}

	/** comment here */
	function upload2($pName, $pType, $pFileName) {

		$file = $_FILES[$pName];
		if (!$file["name"]) Return false;
		$fileparts = explode(".", $file["name"]);
		$ext = array_pop($fileparts);
		$check = $this->verifyExt($ext, $pType);
		if ($check) {
			$vName = $pFileName . "." . $ext;
			if ($this->uploadFile($file["tmp_name"], APP_BASE_PATH . $vName)) Return $vName;
			else Return false;
		} else {
			Return false;
		}
	}

	/** comment here */
	function simpleUpload($pDir = "media/uploads") {

		foreach ($_FILES as $key=>$val) {
			$pName = $key;
		}
		$file = $_FILES[$pName];
		if (!$file["name"]) Return false;
		$fileparts = explode(".", $file["name"]);
		$ext = array_pop($fileparts);
		$vName = uniqid(implode("_", $fileparts)) . "." . $ext;
		$vName = $pDir . "/" . $vName;
		if ($this->uploadFile($file["tmp_name"], $vName)) Return $vName;
		else Return false;
	}

	/** comment here */
	function thumbnail($src, $width, $height = 0) {
		if (!$height) $height = $width;
		/*
		$tmp = explode(".", $src);
		$ext = array_pop($tmp);
		$newsrc = implode("_", $tmp) . "_tn." . $ext;
		passthru("convert.exe  \"".$src."\" -thumbnail \"".$width."x".$height.">\" \"".$newsrc."\"");
		Return $newsrc;
		*/
		$sizeify_args = $width . 'x' . $height;
		$r = sizeify(APP_SERVER_NAME.$src, $sizeify_args);
		return $r;
	}

	/** comment here */
	function thumbnail2($src, $newsrc, $width, $height = "") {
		if (!$height) $height = $width;
		copy(APP_BASE_PATH.$src, APP_BASE_PATH.$newsrc);
		/*
		passthru("convert.exe  \"".$newsrc."\" -thumbnail \"".$width."x".$height.">\" \"".$newsrc."\"");
		Return $newsrc;
		*/
		$sizeify_args = 'w' . $width . 'x' . $height;
		$r = sizeify(APP_SERVER_NAME.$newsrc, $sizeify_args);
		return $r;
	}

	/** comment here */
	function resize($src, $width, $height = 0) {
		if (!$height) {
			$x = getimagesize(APP_BASE_PATH.$src);
			$height = $x[1] * ($width / $x[0]);
		}

		try {
			$img = new Imagick();
			$img->readImage(APP_BASE_PATH.$src);
			$img->thumbnailImage($width,$height,true);
			unlink(APP_BASE_PATH.$src);
			$img->writeImage(APP_BASE_PATH.$src);
			return true;
		} catch (Exception $e) {
			error_log( $e->getMessage() );
			$this->error( $e->getMessage() );
			return false;
		}

		/*
		$sizeify_args = 'w' . $width . 'x' . $height;
		$s = sizeify(APP_SERVER_NAME.$src, $sizeify_args);

		if(!@copy($s, APP_BASE_PATH.$src.'.NEW')) {
			$errors = error_get_last();
			error_log( json_encode($errors) );
			return false;
		} else {
			unlink(APP_BASE_PATH.$src);
			rename(APP_BASE_PATH.$src.'.NEW',APP_BASE_PATH.$src);
			return true;
		}
		*/

		/*
		copy(APP_BASE_PATH.$src, APP_BASE_PATH.$src . ".old");
		unlink(APP_BASE_PATH.$src);
		passthru("convert.exe  \"".addslashes($src).".old\" -thumbnail \"".$width."x".$height.">\" \"".addslashes($src)."\"");
		unlink($src . ".old");
		Return true;
		*/
	}

	/** comment here */
	function resize2($src, $newsrc, $width, $height) {
		if (!$height) $height = $width;
		copy($src, $src . ".old");
		unlink($src);
		passthru("convert.exe  \"".$src.".old\" -thumbnail \"".$width."x".$height.">\" \"".$newsrc."\"");
		copy($src . ".old", $src);
		unlink($src . ".old");
		Return $newsrc;
	}

function download($fpath) {
//die($fpath);
		if (!file_exists($fpath)) {
			$o = new CObject();
			$o->redirect("index.php?o=error_page&id=404");
		}

			$tmp = explode("/", $fpath);
			$fname = array_pop($tmp);
			$tmp2 = explode(" ", $fname);
			$fname = implode("-", $tmp2);
			$fsize = filesize($fpath);
			$bufsize = 20000;
			if(isset($_SERVER['HTTP_RANGE']))  {//Partial download
				if(preg_match("/^bytes=(\\d+)-(\\d*)$/", $_SERVER['HTTP_RANGE'], $matches)) { //parsing Range header
					$from = $matches[1];
					$to = $matches[2];
					if(empty($to))
					{
						$to = $fsize - 1;  // -1  because end byte is included
						  //(From HTTP protocol:
						// 'The last-byte-pos value gives the byte-offset of the last byte in the range; that is, the byte positions specified are inclusive')
					}
					$content_size = $to - $from + 1;
					header("HTTP/1.1 206 Partial Content");
					header("Content-Range: $from-$to/$fsize");
					header("Content-Length: $content_size");
					header("Content-Type: application/force-download");
					header("Content-Disposition: attachment; filename=$fname");
					header("Content-Transfer-Encoding: binary");
					header("Cache-Control: max-age=120");
					if(file_exists($fpath) && $fh = fopen($fpath, "rb"))
					{
						fseek($fh, $from);
						$cur_pos = ftell($fh);
						while($cur_pos !== FALSE && ftell($fh) + $bufsize < $to+1)
						{
							$buffer = fread($fh, $bufsize);
							print $buffer;
							$cur_pos = ftell($fh);
						}
						$buffer = fread($fh, $to+1 - $cur_pos);
						print $buffer;
						fclose($fh);
					} else {
						header("HTTP/1.1 404 Not Found");
						exit;
					}
				} else {
					header("HTTP/1.1 500 Internal Server Error");
					exit;
				}
			} else {// Usual download
				header("HTTP/1.1 200 OK");
				header("Cache-Control: maxage=3600");
				header("Pragma: private");
				header("Content-Length: $fsize");
				header("Content-Type: application/octet-stream");
				header("Content-Disposition: attachment; filename=$fname");
				header("Content-Transfer-Encoding: binary");
				if(file_exists($fpath) && $fh = fopen($fpath, "rb")){
					while($buf = fread($fh, $bufsize))
					print $buf;
					fclose($fh);
				}
				else
				{
					header("HTTP/1.1 404 Not Found");
				}
			}
	}
}
?>