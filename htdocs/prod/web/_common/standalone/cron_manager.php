<?php   

  header("Expires: 0");
  error_reporting(E_ALL);

  $htmlEditorScript = null;
  $vMenuID = 1;
  $vMaxWidth = 530;


  require_once("class/common/globals.php");

  require_once("class/common/system.classes.php");
  $vFileManager	  = new CFileManager();
  $vBenchmark	  = new CBenchmark();
  $vDatabase	  = new CDatabase();   $vDatabase->connect();
	$vUrlManager = new CUrlManager();
	

  require_once("class/common/classes.php");
  require_once("class/content.classes.php");

  $vHtmlDoc	  = new CDocument();
  $vUserManager = new CUserManager(); 
  $vSiteManager = new CMain();

  $vCronManager = new CCronManager();
  $vCronManager->runCron($_GET["job_id"]);

?>