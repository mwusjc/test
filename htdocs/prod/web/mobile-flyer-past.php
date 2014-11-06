<?php
include "_common/class/tools/functions.php";
include "benchmark.class.php";
include "database.class.php";
$db = new CDatabase();
$db->connect();
$db->query("SET NAMES 'utf8'");


			$activeflyer = $db->getRow("select * from flyers where Status = 'enabled' order by id desc limit 1");
			$previousflyer = $db->getRow("select * from flyers where Status = 'disabled' and id < ".intval($activeflyer["ID"])." order by id desc limit 1");
			if (date("w") == 3 || date("w") == 4) {
				if ($activeflyer["Week"] >= time()) $id = $previousflyer["ID"];
			} else {
				die("<script>location='mobile-flyer.php';</script>");
			}


//		$id = $db->getValue("flyers", "max(ID)", "Status = 'enabled'");
		$sql = "select a.*  from flyer_products a, flyer_pages b where b.flyerid = " . intval($id) . " and b.id =a.pageid order by PageID ASC, RegionIndex";
		$products = $db->getAll($sql);
		$categories = $db->getAll("select c.ID, c.Name, count(*) from categories c, flyer_products a, flyer_pages b where b.flyerid = ".intval($id) . " and b.id =a.pageid  and c.id = a.categoryid group by c.id having count(*) > 0 ");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=320" /> 
<title>Highland Farms Mobile</title>
<link rel="stylesheet" type="text/css" href="css/mobile.css"/>
<script type="text/javascript" src="js/tools.js" ></script>
<script type="text/javascript" src="js/overlay.js" ></script>
<script type="text/javascript" src="js/main.js" ></script>
<script type="text/javascript" src="js/ajax.js" ></script>
<script type="text/javascript" src="js/forms.js" ></script>
<script type="text/javascript" src="js/mobile.js" ></script>
<script type="text/JavaScript"> 
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>

 
</head>
<body>
<center>

<div style=" height: 100%; ">
	<div style="width: 100%; text-align: center;">
		<a href="mobile.php"><img src="images/logo_hf.gif" style="margin-top: 5px;"></a>
		<div style="clear: both; height: 0px"></div>
		<div>
		<a href="mobile-flyer.php" style="display: none;"><img src="images/bt-flyer.jpg" style="float: left; margin-top: 5px;"></a>
		
		</div>
		<div style="clear: both; height: 25px"></div>
		<div>
<?php
	foreach ($categories as $key2=>$val2) {
	echo '<a class="button" href="#self" onclick="showArea('.$key2.')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val2["Name"].'</a>';
	echo '<div class="content-area" id="area'.$key2.'">
	<div style="padding: 0px 0 20px 0px">
	';

	foreach ($products as $key=>$val) {
		if (!$val["Name"]) continue;

		if ($val["CategoryID"] == $val2["ID"]) {
			echo "<a href='#self' class='button2' onclick='toggleArea(this, \"pp\", $key)'>" . $val["Name"]  . "</a>";
			echo "<div class='content-area2' id='inner-area-pp-".$key."'>";
			echo $val["Summary"] . "<br><b> " . '$' . $val["Pricing"] . "</b><br> " . $val["Packaging"]."";
			echo "</div>";
		}
	}
	echo '</div>';
	echo '</div>';

	}
?>
		</div>
<img src="images/hf-slogan.jpg" style="margin-top: 60px" >

		<div class="footer"><a href="/index.php?desktop=yes">switch to desktop version</a><div>
		<div class="footer2">Copyright &copy; 2010 Highland Farms<div>
	

	</div>
</div>

</center>
</body>
</html>
