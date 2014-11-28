<?php
	
//	fix for bug # HF-22
if (isset($_GET['n']) && $_GET['n'] == 'flyers') {
	$_GET['n'] = 'Flyers';
}
	
if ($_GET["desktop"]) setcookie("SiteVer", "desktop");

require("mobilelib.php");
if (!$_GET["desktop"] && !$_COOKIE["SiteVer"] && mobile_device_detect(true,true,true,true,true,true,true,false,false)) {
	session_start();
	if (mobile_device_detect(false,false,false,false,true,false,false,false,false)) {
		$_SESSION["gBB"] = 1;
		echo "<script>window.location='mobileBB.php';</script>";
	} else {
		$_SESSION["gBB"] = 0;
		echo "<script>window.location='mobile.php';</script>";
	}
	die();
}


  ini_set("display_errors",0);
  error_reporting (E_ALL);
  ini_set("magic_quotes", "on");
  require_once("class/include.php");

  $vDocument = new CTbf();
  $vDocument->main();

?>