<?php
include "benchmark.class.php";
include "database.class.php";
$db = new CDatabase();
$db->connect();
$db->query("SET NAMES 'utf8'");


if ($_GET["o"] == "find-store") {
	$sql = "select *  from stores where status = 'enabled'";
	$stores = $db->getAll($sql);
	$storecodes = array();
	$storecodes[] = array( "PostCode2" => "L4K5Z2", "Latitude" => 43.829476, "Longitude"=> -79.538302);
	$storecodes[] = array("PostCode2" => "L4Z1N5","Latitude" => 43.620221,"Longitude" => -79.669361);
	$storecodes[] = array("PostCode2" => "M1E3Y3", "Latitude" => 43.767624, "Longitude" => -79.164138);
	$storecodes[] = array("PostCode2" => "M1P2W5", "Latitude" => 43.765698, "Longitude" => -79.282367);
	$storecodes[] = array("PostCode2" => "M3H5S7", "Latitude" => 43.775268, "Longitude" => -79.468503);


	$code = substr(strtoupper(str_replace(" ", "", $_GET["PostCode"])), 0, 5);// . $_GET["PostCodeB"]);
	$sql = "select Latitude, Longitude, PostCode2 from masterDB.cms_postcodes where PostCode3 = '$code' order by id asc limit 1";
	$data = $db->getAll($sql);
	$center = array($data[0]["Latitude"], $data[0]["Longitude"]);

	if (!empty($center)) {
		$distances = array();
		foreach ($storecodes as $key=>$val) {
			#calc distance
			$distances[$val["PostCode2"]] = $ret = 1.609344 * 3958.75 * acos(sin($center[0]/57.2958) * sin($val["Latitude"]/57.2958) + cos($center[0]/57.2958) * cos($val["Latitude"]/57.2958) * cos($val["Longitude"]/57.2958 - $center[1]/57.2958));
		}
	}
//			die2($distances);
	if (!empty($distances)) {
		asort($distances, SORT_NUMERIC);
		$firstCode = array();
		foreach ($distances as $key=>$val) {
			$firstCode = array($key, $val);
			break;
		}
		$store = array();
		foreach ($stores as $key=>$val) {
			if (strtoupper($val["PostCode"]) == $firstCode[0])  {
				$store = $val;
				break;
			}
		}
		
	}
		
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=320" /> 
<title>Highland Farms Mobile</title>
<link rel="stylesheet" type="text/css" href="css/mobile2.css"/>
<script type="text/javascript" src="js/main.js" ></script>
<script type="text/javascript" src="js/fsmenu.js" ></script>
<script type="text/javascript" src="_common/scripts/tools.js" ></script>
<script type="text/javascript" src="_common/scripts/misc/mm.js" ></script>
<script type="text/javascript" src="_common/scripts/misc/forms.js" ></script>
<script type="text/javascript" src="_common/scripts/overlay.js" ></script>
<script type="text/javascript" src="_common/scripts/AC_RunActiveContent.js" ></script>
<script type="text/javascript" src="_common/scripts/ajax.js" ></script>
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
		<a href="mobile.php"><img src="images/logobb.png" width="220" style="margin-top: 5px;"></a>
		<div style="clear: both; height: 0px"></div>
		<div>
		<a href="mobile-flyer.php" style="display: none;"><img src="images/bt-flyer.jpg" style="float: left; margin-top: 5px;"></a>
		
		</div>
		<div style="clear: both; height: 15px"></div>
		<a class="button" href="mobile-flyer.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This Week's Flyer</a>
		<a class="button" href="#self" onclick="showArea(1)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Find a Store</a>
		<div class="content-area" id="area1">
		<div style="padding: 20px 0 20px 20px">
		To find a Highland Farms location near you, enter your postal code:
		<br>
		<br>
		<form action="mobile.php" method="GET"><input type="hidden" name="o" value="find-store">
		<table cellpadding="0" cellspacing="0" border="0" class="">
		<tr>
			<td><input type="text" value="" size="20" maxlength="7" name="PostCode" id="PostCode"></td>
			<td width="10"></td>
			<td><a class="orange-button" href="#self" onclick="submit();">ENTER</a></td>
		</tr>
		</table>
		</form>
<?php
if ($store) {

echo "<div class='hr'></div>";
echo "<div class='store'><b>" . $store["Name"] . "</b><br>" . $store["Address"] . " " . $store["City"] . ", ". $store["PostCode"] . "<br><br>";
echo $store["Hours"];
echo "<br><br><a href='".$store["Google"]."' class='orange-button' style='width: 280px'>GET GOOGLE DRIVING DIRECTIONS</a>";
echo "</div>";
echo "<script>showArea(1);</script>";
}
?>



		</div>
		</div>
		<a class="button" href="#self" onclick="showArea(2)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Party Platters</a>
		<div class="content-area" id="area2">
		<div style="padding: 0px 0 20px 0px">
<?php
	$sql = "select a.*, b.Name as Category from platter_categories b, platters a where a.status = 'enabled' and a.CategoryID = b.ID";
	$data = $db->getAll($sql);
	foreach ($data as $key=>$val) {
			$img = str_replace(".jpg", "_tn.jpg", $val["Image"]);
		echo "<a href='#self' class='button2' title='1' onclick='toggleArea(this, \"pp\", $key)'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $val["Name"] . "</a>";
		echo "<div class='content-area2' id='inner-area-pp-".$key."'>";
			for($i=1; $i<4; $i++) {
				if ($val["Price$i"]) {
					echo $val["PriceDesc$i"] . " " . '$' . $val["Price$i"] . "<br>";
				}
			}

		echo "</div>";
	}
?>
		
		</div>
		</div>
		</div>



		<a class="button" href="#self" onclick="showArea(3)">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Country Kitchen</a>
		<div class="content-area" id="area3">
		
		<div style="padding: 0px 0 20px 0px">
<?php
	$sql = "select *  from private_labels where status = 'enabled'";
	$data = $db->getAll($sql);
	foreach ($data as $key=>$val) {
			$img = str_replace(".jpg", "_tn.jpg", $val["Image"]);
		echo "<a href='#self' class='button2' title='1' onclick='toggleArea(this, \"ck\", $key)'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $val["Name"] . "</a>";
		echo "<div class='content-area2' id='inner-area-ck-".$key."'>";
		echo $val["Description"] . "<br>";

		echo "</div>";
	}
?>
		
		</div>
		
		</div>
	
<a class="button" href="#self" onclick="showArea(4)" style="border-bottom: 2px solid #6bc95b; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact Us</a>
		<div class="content-area" id="area4">
		
		<div style="padding: 0px 0 20px 0px; text-align: left;">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="6">
    <tr>
      <td width="100" align="right">Email Address:</td>
      <td width="220"><input name="Email" type="text" class="txtfield318" id="Email" /></td>
    </tr>
    <tr>
      <td align="right">First Name:</td>
      <td><input name="FirstName" type="text" class="txtfield318" id="FirstName" /></td>
    </tr>
    <tr>
      <td align="right">Last Name:</td>
      <td><input name="LastName" type="text" class="txtfield318" id="LastName" /></td>
    </tr>
    <tr>
      <td align="right" valign="top">Question</td>
      <td><textarea name="Question" class="txtfield318" id="Question" cols="25" rows="5"></textarea></td>
    </tr>
 
    <tr>
      <td>&nbsp;</td>
      <td height="30"><div class = "or-link" style="margin:15px 5px 0 3px; "><a style="width:120px" href="#self" onclick="contactus()">SUBMIT</a></div></td>
    </tr>
  </table>
		</div>
		
		</div>
<img src="images/logo2bb.png" width="100" style="margin-top: 8px" >
<a class="button3" style="display: none;" href="#self">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THIS WEEK'S FLYER</a>
<div style="width: 100%; text-align: left; margin-top: 10px;display: none;">
<a href="mobile-flyer.php"><img src="images/flyer.jpg"></a>
</div>
		<a class="button" style="display: none;" href="#self"></a>
		<span style="padding-left: 0px; display: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This week at Highland Farms</span>
		<div style="clear: both;"></div>

		<?php
		$id = $db->getValue("flyers", "max(ID)", "Status = 'enabled'");
		$sql = "select a.*  from flyer_products a, flyer_pages b where b.flyerid = $id and b.id =a.pageid and b.orderid = 1 order by PageID ASC, RegionIndex";
		$products = $db->getAll($sql);
		$cnt = 0;
foreach ($products as $key=>$val) {
	if ($val["Name"]) $cnt ++;
}
/** comment here */
function die2($x) {
	print_r($x);die();
	
}
		?>
		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#019f4a" STYLE="DISPLAy: none;">
				<tr>
						<td width="20" height="80" valign="middle" align="left"><img src="images/arrow-left.jpg" onclick="slideLeft()" style="cursor: pointer;"></td>
						<td valign="middle" align="center" width="280"  >
							<div style="width: 280px; overflow: hidden; margin-left: 0px; text-align: left; padding: 0px; ">
								  <table cellpadding="0" cellspacing="0" id="slider" border="0" style="width: <?php echo $cnt * 280; ?>px">
										<tr>
										<?php
										foreach ($products as $key=>$val) {
											if (!$val["Name"]) continue;
											echo '<td align="center" valign="middle" style="height: 52px; text-align: center; vertical-align: middle; width: 280; padding: 0px; color: #019f4a; background-color: #fff;">
											<table cellpadding="0" cellspacing="0" width="260" height="40" style="margin: 0px 10px;"><tr><td align="left">'.$val["Name"] . '<br>' .$val["Packaging"] . "</td><td style='color: #f78f1e; font-size: 32px; line-height: 75%; text-align: right;'>" .$val["Pricing"]. '</tr></table>
											</td>';
										}
										?>
											  
										  </tr>
									</table>
							  </div>
							  <script>
							  slideLength = -<?php echo ($cnt-1) * 280 - 10; ?>;
							  </script>
						</td>
						<td width="20" valign="middle" align="right"><img src="images/arrow-right.jpg" onclick="slideRight()" style="cursor: pointer;"></td>
						</tr>
		</table>
		<div class="footer"><a href="/index.php?desktop=yes"><b>switch to desktop version</b></a><div>
		<div class="footer2">Copyright &copy; 2010 Highland Farms<div>
		<div>
	</div>
</div>

</center>
</body>
</html>
