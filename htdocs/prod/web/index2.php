<?php
  ini_set("display_errors", 0);
  error_reporting(E_ALL & ~E_NOTICE);
//  error_reporting(E_ALL);

  require_once("class/include_admin.php");

//  if ($_SESSION["gSecretCode"]<> INI_SECRET_CODE && $_POST["secret_code"] <> INI_SECRET_CODE) {
//	die('Access denied');
//  }

  $vDocument = new CAdminDocument();

  $vDocument->main();

?>