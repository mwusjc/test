<?php
chdir( __DIR__ );
require_once( __DIR__ . "/class/include_admin.php");
$test = new CFlyerAdmin();
$sql = "select * from flyers order by id desc limit 1";
$results = $test->mDatabase->getAll($sql);
$newest_flyer_id = $results[0]['ID'];
$vNews = new CFlyer($newest_flyer_id);
$vNews->toggle('on');
?>
