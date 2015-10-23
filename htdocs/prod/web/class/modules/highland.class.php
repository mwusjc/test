<?php

class CHighland extends CSectionManager
{
  /** comment here */
  function CHighland() {
	$this->CSectionManager();
  }

  function display() {
//	  if ($_GET["test"] == 1) 
//		$this->resetTemplate("templates/home-xmas.html");
//	  else
		$this->resetTemplate("templates/home.html");
		Return $this->flushTemplate();
  }

  /** comment here */
  function registerClasses() {
  $this->mClasses[] = array("", "");
  }


function displayRecipes() {
	STitle::set(APP_TITLE_SHORT . " - Tasty Recipes");
	$this->mDocument->displayBottomBanners();
	$sql = "";
	$this->resetTemplate("templates/recipes/recipes.html");

	/*
	$sql = "select * from recipes where status = 'enabled' order by rand() limit 2";
	*/

	//	bug # HF-30
	//	choose a recipes randomly, but make them the same for the whole day.
	$sql = "
		select *,(((ID*2) + ".date('z').") % 55) AS xid
		from recipes 
		WHERE status = 'enabled'
		ORDER BY xid
		LIMIT 2
	";

	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RECIPE");
		$this->assign("ID", $val["ID"]);
		$this->assign("NAME", $val["Name"]);
		$this->assign("SUMMARY", paragraph($val["Directions"], 150));
		$this->assign("IMAGE", $val["Image"]);
	}
	Return $this->flushTemplate();
}

/** comment here */
function displayScratch() {
	STitle::set(APP_TITLE_SHORT . " - Scratch and Win");
	$this->mDocument->displayBottomBanners();

	$this->resetTemplate("templates/pages/scratch.html");
	Return $this->flushTemplate();

}

/** comment here */
function displayRecipesList($id) {
	$this->mDocument->displayBottomBanners();
	$this->resetTemplate("templates/recipes/recipes_list.html");
	$this->newBlock("RECDETAIL");
	$sql = "select * from recipes_categories where status = 'enabled' ORDER BY Name ASC ";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("CATEGORY");
		$this->assign("CategoryID", $val["ID"]);
		$this->assign("CategoryName", $val["Name"]);
		if ($val["ID"] == $id) $categName = $val["Name"];
	}
	$this->selectBlock("RECDETAIL");
	if ($categName) $this->assign("Name", $categName); else $this->assign("Name", "Search results");

	if ($id)
		$sql = "select * from recipes where status = 'enabled' and categoryid = '".addslashes2($id)."'";
	else {
		$criteria = "";
		if ($_GET["textfield"]) {
			$pieces = explode(" ", $_GET["textfield"]);
			$criteria = array();
			foreach ($pieces as $key=>$val) {
				$search  ="'%".addslashes2($val)."%'";
				$criteria[] = " (Name like $search OR Ingredients like $search OR Directions like $search) ";
			}
			$criteria = " and (" . implode(" OR ", $criteria) . ") ";
		}
		$sql = "select * from recipes where status = 'enabled' $criteria";
	}
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RECIPE");
		$this->assign("ID", $val["ID"]);
		$this->assign("RecipeName", $val["Name"]);
		$this->assign("Summary",  paragraph($val["Directions"], 150));
		$this->assign("Image", $val["Image"]);
	}
	Return $this->flushTemplate();}

/** comment here */
function displayRecipe($id) {
	$this->mDocument->displayBottomBanners();
	if ($_GET["mode"] == "print") {
		$this->mDocument->mPageTemplate = "_common/templates/print.html";
		$this->resetTemplate("templates/recipes/print.html");
	} else $this->resetTemplate("templates/recipes/recipe_detail.html");
	$this->newBlock("RECDETAIL");
	$sql = "select * from recipes_categories where status = 'enabled' ORDER BY Name ASC ";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("CATEGORY");
		$this->assign("CategoryID", $val["ID"]);
		$this->assign("CategoryName", $val["Name"]);
	}
	$this->selectBlock("RECDETAIL");

	$sql = "select * from recipes where status = 'enabled' and id = '".addslashes2($id)."'";
	$data = $this->mDatabase->getRow($sql);
	$this->assign("ID", $data["ID"]);
	$this->assign("Name", $data["Name"]);
	$tmp = explode("\n", $data["Directions"]);
	$txt = "<ul><li>" . implode("</li><li>", $tmp) . "</li></ul>";
	$this->assign("Directions", nl2br($txt));
	$this->assign("Ingredients", nl2br($data["Ingredients"]));
	$this->assign("Image", $data["Image"]);
	Return $this->flushTemplate();
}

/** comment here */
function displayPlatters() {
	STitle::set(APP_TITLE_SHORT . " - Large selection of party platters and gifts at affordable prices");
	$this->mDocument->displayBottomBanners();
	$sql = "";
	$this->resetTemplate("templates/platters/platters.html");
	$sql = "select a.*, b.Name as Category from platter_categories b, platters a where a.status = 'enabled' and a.CategoryID = b.ID order by b.OrderID, a.Name";
	$data = $this->mDatabase->getAll($sql);
	$platters = array();
	foreach ($data as $key=>$val) {
		$platters[$val["Category"]][] = $val;
	}

	$script = "<script>";
	foreach ($platters as $key=>$val) {
		$this->newBlock("CATEGORY");
		$this->assign("CategoryName", $key);
		$x= 0;
		foreach ($val as $key2=>$platter) {
			if ($x % 3 == 0)  $this->newBlock("CAT_ROW");
			$x ++;
			$this->newBlock("PLATTER");
			$this->assign("ID", $platter["ID"]);
			$this->assign("Name", $platter["Name"]);
			$this->assign("Description", $platter["Description"]);
//			$this->assign("Price1", $platter["Price1"]);
//			$this->assign("Price2", $platter["Price2"]);
//			$this->assign("Price3", $platter["Price3"]);
			$this->assign("Image", str_replace(".jpg", "_tn.jpg", $platter["Image"]));
			$hasprice = false;
			for($i=1; $i<4; $i++) {
				if ($platter["Price$i"]) {
					$hasprice = true;
					$this->newBlock("PRICE");
					$this->assign("Row", $i);
					$this->assign("Price", '$' . $platter["Price$i"]);
					$this->assign("PriceDesc", $platter["PriceDesc$i"]);
				}
			}
			if ($hasprice) $this->newBlock("PRICEHEADER");

			$script .= " platters[platters.length] = " . $platter["ID"] . ";";
		}
	}
	$script .= "</script>";
	Return $this->flushTemplate() ;
}

/** comment here */
function getPlatterQty($id) {
	$this->resetTemplate("templates/platters/platter_popup.html");
	$sql = "select * from platters  where status = 'enabled' and ID = '"  . addslashes2($id) . "'";
	$data = $this->mDatabase->getRow($sql);
	$this->newBlock("POPUP");
	$this->assign("Name", $data["Name"]);

	for($i=1; $i<4; $i++) {
		if ($data["Price$i"]) {
			$this->newBlock("PRICE");
			$this->assign("Row", $i);
			$this->assign("Price", '$' . $data["Price$i"]);
			$this->assign("PriceDesc", $data["PriceDesc$i"]);
		}
	}
	$this->selectBlock("POPUP");
	$this->assign("ID", $data["ID"]);
	$this->assign("Image", $data["Image"]);

	xml("<htm>" . xmlentities($this->flushTemplate()) . "</htm>");
}
/** comment here */
function displayPlattersOrderForm() {
	$this->mDocument->mTags["LAYOUT_BOTTOM_BANNERS"] = "";
	$sql = "";
//die2($_COOKIE);
	$txt = $_COOKIE["plShoppingCart"];
	if ($txt)
	{
		$tmp = explode("_____", $txt);
		$plCart = array();
		foreach ($tmp as $key=>$val) {
			$tmp2 = explode("***", $val);
			$plCart[$key] = array($tmp2[0], $tmp2[1], $tmp2[2]);
		}
	}

	if (empty($plCart)) {
		$this->error("Your shopping cart is empty");
		$this->redirect($this->getBaseLink() . "platters");
	}

	$this->resetTemplate("templates/platters/orderpage.html");
//	$sql = "select a.*, b.Name as Category from platter_categories b, platters a where a.status = 'enabled' and a.CategoryID = b.ID";
//	$data = $this->mDatabase->getAll($sql);
//	$platters = array(); $categs = array();
//	foreach ($data as $key=>$val) {
//		$platters[$val["Category"]][] = $val;
//		$categs[$val["CategoryID"]] = $val["Category"];
//	}
//
//	foreach ($categs as $key=>$val) {
//		$this->newBlock("CATEG");
//		$this->assign("CategoryName", $val);
//		$this->assign("CategoryID", $key);
//	}

	$sql = "select a.* from platters a where a.status = 'enabled'";
	$platters = $this->mDatabase->getAllAssoc($sql);

	$script = "<script>";
	foreach ($platters as $key=>$val) {
		$script .= " platters[".$val["ID"]."] = " . $val["ID"] . ";";
	}

	$total = 0;
	foreach ($plCart as $key=>$val) {
		$script .= " plCart[".$key."] = ['".addslashes($val[0])."', '".addslashes($val[1])."', '".addslashes($val[2])."'];";
		$this->newBlock("ITEM");
		$this->assign("Name", $platters[$val[0]]["Name"]);
		$this->assign("Descr", $platters[$val[0]]["PriceDesc" . $val[2]]);
		$this->assign("Price", $platters[$val[0]]["Price" . $val[2]]);
		$this->assign("Quantity", $val[1]);
		$this->assign("CartID", $key);
		$this->assign("Cost", '$' . number_format($val[1] * $platters[$val[0]]["Price" . $val[2]],2));
		$total += $val[1] * $platters[$val[0]]["Price" . $val[2]];
	}
	$this->newBlock("TOTALS");
	$this->assign("SubTotal", '$' . number_format($total, 2));
	$this->assign("Tax", '$' . number_format(0.05 * $total, 2));
	$this->assign("Total", '$' . number_format(1.05 * $total, 2));

	$script .= "</script>";
//	$this->mDocument->mBody->mJavaScript = "onload='initOrderForm();'";
	Return $this->flushTemplate() . $script;
}

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

/** comment here */
function displayPrivateLabels() {
	STitle::set(APP_TITLE_SHORT . " - Country Kitchen, Highland Farms' Private Label");
	$this->mDocument->mTags["LAYOUT_BOTTOM_BANNERS"] = "";
	$sql = "";
	$this->resetTemplate("templates/private_label/private_label.html");
	$sql = "select *  from private_labels where status = 'enabled'";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("PRODUCT");
		$this->assign("ID", $val["ID"]);
		$this->assign("Name", addslashes($val["Name"]));
		$this->assign("Summary", addslashes(str_replace(array("\n", "\r"), array("<br>", ""), $val["Description"])));
		$this->assign("Image", str_replace(".jpg", "_tn.jpg", $val["Image"]));
	}
	//return $this->flushTemplate();
	return $this->get_include_contents( $_SERVER['DOCUMENT_ROOT'] . '/templates/private_label/private_label.php');
}

/** comment here */
function displayStores($id) {
//	ini_set("display_errors", 1);
//	error_reporting(E_ALL);
	STitle::set("You can find a Highland Farms supermarket anywhere in the GTA - we have locations in Toronto, North York , Vaughan, Missisauga, Scarborourgh");
	$this->mDocument->displayBottomBanners();
	$sql = "";
	$this->resetTemplate("templates/stores/stores.html");
	$sql = "select *  from stores where status = 'enabled'";
	$stores = $this->mDatabase->getAll($sql);
	$script = "<script>";
	$codes = array();
	foreach ($stores as $key=>$val) {
		$script .= " stores[stores.length] = {id: ".$val["ID"].", name:'".$val["Name"]."', hours:'".addslashes(str_replace(array("\n", "\r"), "", nl2br($val["Hours"])))."'};";
		$this->newBlock("STORE");
		$this->assign("ID", $val["ID"]);
		$this->assign("Name", addslashes($val["Name"]));
		$this->assign("Map", addslashes($val["Map"]));
		$this->assign("Hours", addslashes($val["Hours"]));
		$this->assign("Phone", addslashes($val["Phone"]));
		$this->assign("Google", addslashes($val["Google"]));
		$this->assign("President", addslashes($val["President"]) . "<br>");
		$this->assign("Address", addslashes($val["Address"]));
		$this->assign("City", addslashes($val["City"]));
		$this->assign("PostCode", addslashes($val["PostCode"]) . "<br>");
		$codes[] = str_replace(" ", "", $val["PostCode"]);
	}

	if ($id) {
		$script .= " showStore($id); ";
	} else {
		if ($_GET["PostCode"]) {
			$storecodes = array();
			$storecodes[] = array( "PostCode2" => "L4K5Z2", "Latitude" => 43.829476, "Longitude"=> -79.538302);
			$storecodes[] = array("PostCode2" => "L4Z1N5","Latitude" => 43.620221,"Longitude" => -79.669361);
			$storecodes[] = array("PostCode2" => "M1E3Y3", "Latitude" => 43.767624, "Longitude" => -79.164138);
			$storecodes[] = array("PostCode2" => "M1P2W5", "Latitude" => 43.765698, "Longitude" => -79.282367);
			$storecodes[] = array("PostCode2" => "M3H5S7", "Latitude" => 43.775268, "Longitude" => -79.468503);

			$code = substr(strtoupper(str_replace(" ", "", $_GET["PostCode"])), 0, 5);// . $_GET["PostCodeB"]);
			$sql = "select Latitude, Longitude, PostCode2 from masterDB.cms_postcodes where PostCode3 = '$code' order by id asc limit 1";
			$data = $this->mDatabase->getAll($sql);
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
				$storeID = 0;
				foreach ($stores as $key=>$val) {
					if (strtoupper($val["PostCode"]) == $firstCode[0])  $storeID = $val["ID"];
				}
				if ($storeID) $script .= " showStore($storeID); ";
			}
		}
	}
	$script .= "</script>";
	Return $this->flushTemplate() . $script;
}

/** comment here */
function displayCareers($id) {
	STitle::set(APP_TITLE_SHORT . " - Careers at Highland Farms");
	$this->mDocument->displayBottomBanners();
//	if ($_GET["test"] == 1) 
		$this->resetTemplate("templates/pages/careers_new.html");
//	else
//		$this->resetTemplate("templates/pages/careers.html");
	if ($id)  $x = " and storeid = '".addslashes($id)."' ";
	else {
		if (isset($_GET["id"])) $x = ""; else {
			$x = " and 1= 2";
		}
	}
	$sql = "select a.*, b.Name as Store from jobs a, stores b where a.status = 'enabled' and a.storeid = b.id and b.status = 'enabled'  $x order by id desc";
	$jobs = $this->mDatabase->getAll($sql);

	if (!empty($jobs)) {
			$job = array();
			foreach ($jobs as $key=>$val) {
				$this->newBlock("JOB");
				$this->assign("ID", $val["StoreID"]);
				$this->assign("PositionID", $val["ID"]);
				$this->assign("Position", $val["Name"]);
				$this->assign("Store", $val["Store"]);
				$this->assign("Store2", str_replace('&', 'and', $val["Store"]));
				$this->assign("Date", date("F d, Y", $val["TimeStamp"]));
				$this->assign("Description", str_replace(array("'","•", "\r", "\n"), array("\\'", "<li>", "", ""), nl2br($val["Responsibilities"])));
			}
	} else {
		if (isset($_GET["id"])) $this->newBlock("JOB2"); else {
			$this->assign("disp", "display: none;");
		}
	}

	Return $this->flushTemplate();

}

/** comment here */
function template($name) {
		$this->mDocument->displayBottomBanners();
		$this->resetTemplate("templates/pages/". $name . ".html");
		Return $this->flushTemplate();

}

/** comment here */
function doContact() {
	$comment = new CComment();
	$comment->registerForm($_GET);
	$comment->mRowObj->TimeStamp = time();
	$comment->save();
	xml("<result>ok</result>");
}

function doRegister() {
	$comment = new CContent("contacts");
	$comment->registerForm($_GET);
	$comment->mRowObj->TimeStamp = time();
	$comment->mRowObj->Consent = "yes";
	$comment->mRowObj->ConsentTime = time();
	$comment->mRowObj->ConsentIP= $_SERVER["REMOTE_ADDR"];
	$comment->easySave();
	@mail($_GET["Email"], "Registration completed",  "Dear ". $_GET["FirstName"] . "\n\n Thank you for your registration. You will start receiving our weekly E-Flyer beginning with the next issue. \n\n", "From: Highland Farms <info@highlandfarms.ca>");
	xml("<result>ok</result>");
}

/** comment here */
function displayResults() {
	$this->mDocument->displayBottomBanners();
	$this->resetTemplate("templates/search/results.html");

	$pieces = explode(" ", $_GET["txtSearch"]);
	$categories = "<ul>";
	$categories .= ' <li><a href="#self" onclick="showResultsCategory();"><b>All Results</b></a></li>';
	#products
  	$flyerid = $this->mDatabase->getValue("flyers", "max(ID)", "status='enabled'");
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (a.Name like $search OR a.Pricing like $search OR a.Packaging like $search OR a.Pricing like $search OR a.Comments like $search) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select a.pageid, a.id, a.name, a.summary from flyer_products a, flyer_pages b where a.pageid = b.id and b.flyerid = '".$flyerid."' $criteria order by a.pageid asc, a.regionindex asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Weekly Flyer");
		$this->assign("Name", $val["name"]);
		$this->assign("Txt", paragraph($val["txt"], 200));
		$this->assign("Url", $this->getBaseLink("Flyers") . "main&id=" . $val["ID"]);
	}
	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Weekly\');">Weekly Flyer</a></li>';


	#recipes
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (Name like $search OR Ingredients like $search OR Directions like $search) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select * from recipes where 1=1 $criteria order by Name asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Recipes");
		$this->assign("Name", $val["Name"]);
		$this->assign("Txt", paragraph($val["Directions"], 200));
		$this->assign("Url", $this->getBaseLink() . "recipe&id=" . $val["ID"]);
	}
	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Recipes\');">Recipes</a></li>';

	#private labels
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (Name like $search OR Description like $search ) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select * from private_labels  where status = 'enabled' $criteria order by Name asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Country Kitchen");
		$this->assign("Name", $val["Name"]);
		$this->assign("Txt", paragraph($val["Description"], 200));
		$this->assign("Url", $this->getBaseLink() . "private_labels&id=" . $val["ID"]);
	}
	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Country\');">Country Kitchen</a></li>';


	#platters
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (Name like $search) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select * from platters where status = 'enabled' $criteria order by Name asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Party Flavours");
		$this->assign("Name", $val["Name"]);
		$this->assign("Url", $this->getBaseLink() . "platters&id=" . $val["ID"]);
	}
	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Party\');">Party Flavours</a></li>';


	#jobs
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (Name like $search OR Skills like $search OR Responsibilities like $search) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select * from jobs  where status = 'enabled' $criteria order by Name asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Careers");
		$this->assign("Name", $val["Name"]);
		$this->assign("Txt", paragraph($val["Responsibilities"], 200));
		$this->assign("Url", $this->getBaseLink() . "careers&id=" . $val["StoreID"] );
	}
	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Careers\');">Careers</a></li>';


	#pages
	$criteria = array();
	foreach ($pieces as $key=>$val) {
		$search  ="'%".addslashes2($val)."%'";
		$criteria[] = " (Txt like $search) ";
	}
	$criteria = " and (" . implode(" OR ", $criteria) . ") ";
	$sql = "select * from cms_pages where status = 'enabled' $criteria order by Name asc";
	$data = $this->mDatabase->getAll($sql);
	foreach ($data as $key=>$val) {
		$this->newBlock("RESULT");
		$this->assign("Category", "Miscellaneous");
		$this->assign("Name", $val["Name"]);
		$this->assign("Txt", paragraph(strip_tags($val["Txt"]), 200));
		$this->assign("Url", $this->getBaseLink() . "template&id=" . $val["Name"]);
	}
	$morepages = array("recipes" => "recipes", "platters"=>"party platters", "private_labels"=>"country kitchen", "jobs"=>"jobs", "flyer"=>"flyer", "e-register"=>"eflyer");
	foreach ($morepages as $key=>$val) {
		if (strpos($val, $_GET["txtSearch"]) !== false) {
			$this->newBlock("RESULT");
			$this->assign("Category", "Miscellaneous");
			$this->assign("Name", ucwords($val));
			$this->assign("Txt", ucwords($val));
			$this->assign("Url", $this->getBaseLink()  . $key);

		}
	}


	if (!empty($data)) $categories .= ' <li><a href="#self" onclick="showResultsCategory(\'Miscellaneous\');">Miscellaneous</a></li>';

	$categories .= "</ul>";

	$this->newBlock("CATEG_LIST");
	$this->assign("Categories", $categories);
	Return $this->flushTemplate();
}

/** comment here */
function deleteOrder() {
	$txt = $_COOKIE["plShoppingCart"];
	$elements = array();
	if ($txt)
	{
		$tmp = explode("_____", $txt);
		$plCart = array();
		foreach ($tmp as $key=>$val) {
			$tmp2 = explode("***", $val);
			if (!in_array($key, $_GET["Delete"])) $elements[] = $val;//$plCart[$key] = array($tmp2[0], $tmp2[1], $tmp2[2]);
		}
	}
	$txt = implode("_____", $elements);
	setcookie("plShoppingCart", $txt);
	$_COOKIE["plShoppingCart"] = $txt;
	$this->error("Selected items have been removed from the cart!");
	$this->redirect($this->getBaseLink() . "order_form");
}

/** comment here */
function saveOrder() {
	$txt = $_COOKIE["plShoppingCart"];
	$elements = array();
	$sql = "select a.* from platters a where a.status = 'enabled'";
	$platters = $this->mDatabase->getAllAssoc($sql);
	if ($txt)
	{
		$tmp = explode("_____", $txt);
		$plCart = array();
		foreach ($tmp as $key=>$val) {
			$tmp2 = explode("***", $val);
			if (!in_array($key, $_GET["Delete"])) $plCart[$key] = array($tmp2[0], $tmp2[1], $tmp2[2], $platters[$tmp2[0]]["Price" . $tmp2[2]]);
		}
	}

	$fields = array();
	$fields["Name"] = $_GET["Name"];
	$fields["Address"] = $_GET["Address"];
	$fields["Email"] = $_GET["Email"];
	$fields["Phone"] = $_GET["Phone"];
	$fields["PostalCode"] = $_GET["PostalCode"];
	$fields["OrderData"] = serialize($plCart);
	$fields["TimeStamp"] = time();
	$sql = "insert into orders" . $this->mDatabase->makeInsertQuery($fields);
	$this->mDatabase->query($sql);

	$this->error("Your order has been saved", 3);
	setcookie("plShoppingCart", "", time() - 1000);
	unset($_COOKIE["plShoppingCart"]);
//	$this->resetTemplate("templates/platters/confirm.html");
//	Return $this->flushTemplate();
	$this->redirect($this->getBaseLink() . "platters");
}

/** comment here */
function printOrder() {
	$this->mDocument->mTags["LAYOUT_BOTTOM_BANNERS"] = "";
	$this->mDocument->mPageTemplate = "_common/templates/print.html";
	$sql = "";
	$txt = $_COOKIE["plShoppingCart"];
	if ($txt)
	{
		$tmp = explode("_____", $txt);
		$plCart = array();
		foreach ($tmp as $key=>$val) {
			$tmp2 = explode("***", $val);
			$plCart[$key] = array($tmp2[0], $tmp2[1], $tmp2[2]);
		}
	}

	if (empty($plCart)) {
		$this->error("Your shopping cart is empty");
		$this->redirect($this->getBaseLink() . "platters");
	}

	$this->resetTemplate("templates/platters/print.html");
	$sql = "select a.* from platters a where a.status = 'enabled'";
	$platters = $this->mDatabase->getAllAssoc($sql);

	$total = 0;
	foreach ($plCart as $key=>$val) {
		$this->newBlock("ITEM");
		$this->assign("Name", $platters[$val[0]]["Name"]);
		$this->assign("Descr", $platters[$val[0]]["PriceDesc" . $val[2]]);
		$this->assign("Price", $platters[$val[0]]["Price" . $val[2]]);
		$this->assign("Quantity", $val[1]);
		$this->assign("CartID", $key);
		$this->assign("Cost", '$' . number_format($val[1] * $platters[$val[0]]["Price" . $val[2]],2));
		$total += $val[1] * $platters[$val[0]]["Price" . $val[2]];
	}
	$this->newBlock("TOTALS");
	$this->assign("SubTotal", '$' . number_format($total, 2));
	$this->assign("Tax", '$' . number_format(0.05 * $total, 2));
	$this->assign("Total", '$' . number_format(1.05 * $total, 2));
//	$this->mDocument->mBody->mJavaScript = "onload='initOrderForm();'";
	Return $this->flushTemplate();
}

/** comment here */
function displayAbout() {
	STitle::set(APP_TITLE_SHORT . " - About Highland Farms");
	$this->mDocument->mTags["LAYOUT_BOTTOM_BANNERS"] = "";
	$this->resetTemplate("templates/about.html");
	Return $this->flushTemplate();
}


function displayProductCategories() {
	STitle::set(APP_TITLE_SHORT . " - Browse our product categories, from bakery, dairy and deli , to fresh produce, organic or prepared foods");
	//	$this->mDocument->mTags["LAYOUT_BOTTOM_BANNERS"] = "";
	$this->mDocument->displayBottomBanners();
	$this->resetTemplate("templates/categories.html");
	Return $this->flushTemplate();
}

/** comment here */
function sendInvite() {
	$obj = new CContent("invitations");
	$obj->mRowObj->Email = $_GET["email"];
	$obj->mRowObj->FromEmail = $_GET["fromemail"];
	$obj->mRowObj->TimeStamp = time();
	$obj->mRowObj->ProductID = $_GET["id"];
	$obj->easySave();
	
	$product = new CContent("flyer_products", $_GET["id"]);
	$page = $this->mDatabase->getValue("flyer_pages", "OrderID", "ID='".addslashes($product->mRowObj->PageID)."'");

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$_GET["fromemail"].'' . "\r\n";


	$txt = "<div style='width: 400px; font-family: Arial; color: #444; font-size: 12px; text-align: left;'><p><img src='".APP_SERVER_NAME.$product->mRowObj->Image."' style=' margin: 0x 10px 10px 0px'><br><br> I think you will appreciate this " . $product->mRowObj->Name . " at ".$product->mRowObj->Pricing."</p>";
	$txt .= "<p>Follow <a href='".APP_SERVER_NAME."/index.php?n=Flyers&o=main&id=".$page."'>this link</a> to view this and other great deals in their online flyer</p></div>";
	mail($obj->mRowObj->Email, "Highland Farm deals and special offers", $txt, $headers);
	xml("<result>ok</result>");
}
/** operation switch for Home Manager */
  function mainSwitch() {
	switch($this->mOperation) {
		case "recipes":
			return $this->displayRecipes();
		case "recipe":
			return $this->displayRecipe($_GET["id"]);
		case "recipes_list":
			return $this->displayRecipesList($_GET["id"]);
		case "recipe_search":
			return $this->displayRecipesList();
		case "platters":
			return $this->displayPlatters();
		case "get_platter_qty":
			return $this->getPlatterQty($_GET["id"]);
		case "order_form":
			Return $this->displayPlattersOrderForm();
		case "submit_order":
			Return $this->saveOrder();
		case "delete_order":
			Return $this->deleteOrder();
		case "print_order":
			Return $this->printOrder();
		case "private_labels":return $this->displayPrivateLabels();
		case "scratch":return $this->displayScratch();
		case "stores":
			Return $this->displayStores($_GET["id"]);
		case "e-register": Return $this->template("register");
		case "template":
			return $this->template($_GET["id"]);
		case "careers":
		case "jobs":Return $this->displayCareers($_GET["id"]);
		case "flyer":Return $this->redirect("index.php?n=Flyers");
		case "docontact":
			Return $this->doContact();
		case "results":
			Return $this->displayResults();
		case "register": Return $this->doRegister();
		case "save_order":Return $this->saveOrder();
		case "about": Return $this->displayAbout();
		case "prodcat": Return $this->displayProductCategories();
		case "send_invite": Return $this->sendInvite();
	    default:
	        return CSectionManager::mainSwitch();
	}
  }


}

?>