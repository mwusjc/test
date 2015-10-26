var stores = [];
function showPlatter(obj) {
	tmp = obj.id.split("_");
	el = document.getElementById("tooltip_" + tmp[1]);
	if (el)
	{
		el.style.display = "block";
		el.style.backgroundColor = "#FFFFFF";
	}
}

function hidePlatter(obj) {
	tmp = obj.id.split("_");
	el = document.getElementById("tooltip_" + tmp[1]);
	if (el)
	{
		el.style.display = "none";
	}
}

function openPlatter(obj, name) {
	tmp = obj.id.split("_");
	el = document.getElementById("platter_image_" + tmp[tmp.length-1]);
//	txt = '<div style=" width:500px; border: 9px solid #f8f9ee;"><div style=" height:25px;margin:10px 10px 10px 10px; padding:10px;"><div class="greentitle16" style=" float:left; text-align:left; margin:0 0 0 0;">'+name+'</div><div style=" float:right; "><a href="#self" onclick="closeWait();"><img src="images/bttn_x.gif" alt="Close" name="bttnx" border="0" id="bttnx" onmouseover="MM_swapImage(\'bttnx\',\'\',\'images/bttn_x_over.gif\',1)" onmouseout="MM_swapImgRestore()" /></a></div><div style="text-align:left; padding-left:100px; width:200px; margin-top:28px;"></div></div><img src="'+el.src.replace("_tn", "")+'" width="500" height="498" /></div>';
//	showWait(txt);
	url = "index.php?n=Main&o=get_platter_qty&id=" + encode(tmp[tmp.length-1]);
	showWait();
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_openPlatter;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	txt = "";
}


function _openPlatter() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("htm");
		txt = getXMLNode(x);
		showWait(txt);
	}
}



function showPrivateLabel(name, summary, image) {
	txt = '<div style=" width:500px; border: 9px solid #f8f9ee;"><div style=" height:25px;margin:10px 10px 10px 10px; padding:10px;"><div class="greentitle16" style=" float:left; margin:0 0 0 0; text-align:left; font-size:16px;"><b> '+name+'</b></div><div style=" float:right; "><a href="#self" onclick="closeWait();"><img src="images/bttn_x.gif" alt="Close" name="bttnx" border="0" id="bttnx" onmouseover="MM_swapImage(\'bttnx\',\'\',\'images/bttn_x_over.gif\',1)" onmouseout="MM_swapImgRestore()" /></a></div><div style="text-align:left; padding-left:100px; width:200px; margin-top:28px;"></div></div><div><img src="'+image.replace("_tn", "")+'" /></div><div style="margin:10px 10px 10px 10px; padding:10px; text-align:left;">'+summary+'</div><div style="margin:10px 10px 10px 10px; padding:10px; text-align:left;"><img src="images/logo_hf_horizontal.gif" /></div></div>';
	showWait(txt);
}

function showStore(id) {
//	for (i in stores)
//	{
//		el = document.getElementById("StoreHours_" + stores[i].id);
//		el.style.display = "none";
//		el = document.getElementById("StoreMap_" + stores[i].id);
//		el.style.display = "none";
//	}
	el1 = document.getElementById("StoreHours_0"); 
	el = document.getElementById("StoreHours_" + id);
	el1.innerHTML = el.innerHTML;
	el1.style.visibility = "visible";
	el1 = document.getElementById("StoreMap_0"); 
	el = document.getElementById("StoreMap_" + id);
	el1.innerHTML = el.innerHTML;
	el1.style.visibility = "visible";
	
	el1 = document.getElementById("StoreAddress_0"); 
	el = document.getElementById("StoreAddress_" + id);
	el1.innerHTML = el.innerHTML;
	el1.style.visibility = "visible";
};

function contactus() {

	txt = "index.php?n=Main&o=docontact";
	error = "";
	el = document.getElementById("Email");	if (!checkEmail(el.value)) error += "<br>Invalid Email Address";  txt += "&Email=" + encode(el.value); el.value="";
	el = document.getElementById("FirstName");	if (!el.value) error += "<br>First Name is required";  txt += "&FirstName=" + encode(el.value);el.value="";
	el = document.getElementById("LastName");	if (!el.value) error += "<br>Last Name is required";  txt += "&LastName=" + encode(el.value);el.value="";
	el = document.getElementById("Question"); if (el.value == "") error += "<br>Your question is missing"; txt += "&Message=" + encode(el.value);el.value="";

	if (error)
	{
		showError("<b>The following errors were encountered: </b><br><br>" + error);
		return false;
	}
	showWait();
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_contactus;
	  xmlhttp.open("GET",txt,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	txt = "";
}


function _contactus() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("table");
		message("Your question was submitted. You will receive a reply shortly");;
	}
}


function register() {
	txt = "index.php?n=Main&o=register";
	error = "";
	el = document.getElementById("Email");	if (!checkEmail(el.value)) error += "<br>Invalid Email Address";  txt += "&Email=" + encode(el.value); el.value="";
	el = document.getElementById("FirstName");	if (!el.value) error += "<br>First Name is required";  txt += "&FirstName=" + encode(el.value);el.value="";
	el = document.getElementById("LastName");	if (!el.value) error += "<br>Last Name is required";  txt += "&LastName=" + encode(el.value);el.value="";
	el = document.getElementById("PostCode");	if (!el.value) error += "<br>Post Code is required";  txt += "&PostCode=" + encode(el.value);el.value="";
	el = document.getElementById("Subscribe"); if (!el.checked) txt += "&Subscribed=no"; else txt += "&Subscribed=yes" ;
	if (error)
	{
		showError("<b>The following errors were encountered: </b><br><br>" + error);
		return false;
	}
	showWait();
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_register;
	  xmlhttp.open("GET",txt,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	txt = "";
}

function _register() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("table");
		message("You have been registered to our weekly flyer distribution list. You will be receiving the flyer via email starting the next week.");;
	}
}


function showResultsCategory(cat) {
	cats = ["Weekly","Recipes","Country","Party","Careers","Miscellaneous"];
	if (!cat)
	{
		for (i in cats)
		{
			el = document.getElementsByName("result_" + cats[i]);
			if (el.length > 0)
			{
				for (k=0; k<el.length; k++)
				{
					el[k].style.display = "block";
				}
			}
		}
	} else {
		for (i in cats)
		{
			el = document.getElementsByName("result_" + cats[i]);
			if (el.length > 0)
			{
				for (k=0; k<el.length; k++)
				{
					if (cat == cats[i]) el[k].style.display = "block"; else el[k].style.display = "none"; 
				}
			}
		}
	}
}

function updatePlatterPrice(obj, id) {
	el = document.getElementById("curPrice_" + id);
	if (obj.options[obj.selectedIndex].value)
	{
		el.innerHTML = '<b>Price: </b>$' + obj.options[obj.selectedIndex].value;
	} else el.innerHTML = 'N/A';
	
}


var plCart = [];
function plAddToCart(id) {
////	if (plCart.length == 0) plLoadCart();
//	el = document.getElementById("curPrice_" + id);
//	el4 = document.getElementById("platterSizes_" + id);
//	el2 = document.getElementById("Qty_" + id);
//	el3 = document.getElementById("Name_" + id);
//	str = el.innerHTML.toUpperCase();
//	if (parseInt(el2.value) != el2.value)
//	{
//		message("Please enter a numeric quantity!");
//		return false;
//	}
//	str = str.replace('<B>PRICE: </B>$', "")
//	if (parseFloat(str) != str)
//	{
//		message("Please select platter size!");
//		el4.selectedIndex = 0;
//		return false;
//	}
//	plCart[id] = [parseFloat(str), parseInt(el2.value), el3.innerHTML];
//	plSaveCart();
//	customMessage("Your cart has been updated. To view the contents of your cart, click on the 'Show My Order' button on the left side menu. To complete your order, please click on the 'Submit Order' button at the bottom of the page.", "width: 400px; font-weight: normal; ");
//	plUpdateCart();
//	if (plCart.length == 0) plLoadCart();
	for (i = 1; i<=3; i++)
	{
		el = document.getElementById("Quantity" + i);
		el2 = document.getElementById("Include" + i);
		if (el && el2 && el2.checked && parseInt(el.value) != 0)
		{
			plCart[plCart.length] = [id, parseInt(el.value), i];
		}
	}
	plSaveCart();
	closeWait();
	customMessage("Your cart has been updated. To view the contents of your cart or to check out, click on the 'Show My Order' button on the left side menu. ", "width: 400px; font-weight: normal; ");

}


function plRemoveFromCart(productID) {
//	if (plCart.length == 0) plLoadCart();
	tmp = [];
	for (i in plCart)
	{
		if (i == productID) continue;
		tmp[i] = plCart[i];
	}
	plCart = tmp;
	plSaveCart();
	el = document.getElementById('Qty_' + productID);
	if (el) el.value = "Number of items";
	el = document.getElementById('curPrice_' + productID);
	if (el) el.innerHTML = "";
	if (plCart.length == 0) plResetCart();
}

function plShowOrder() {
	if (plCart.length == 0)
	{ 
		txt = "Your cart is empty";
	} else {
		txt = "<b>Order Information: </b><br><br>";
		x = 0;
		tot = 0;
		for (i in plCart)
		{
			x ++;
			if (plCart[i][1] > 0)
			{
				txt += '<div class="listit" style="margin:5px 0 0 0;">' + plCart[i][2] + " - " + plCart[i][1] + ' x $'+ plCart[i][0] + '</div>';
				tot += plCart[i][1] * plCart[i][0];
			}
		}
		txt += '<div style="width: 200px; height: 1px; margin: 5px 0px; background-color: #000;font-size: 1px;">&nbsp;</div>';
		txt += '<div class="listit" style="margin:5px 0 0 0;"><B>Total: </B> $'  + tot + '</div>';
	}
	message(txt);

}

function plSaveCart() {
	txt = "";
	for (i in plCart)
	{
		if (txt) txt += "_____";
		txt += plCart[i][0] + "***" + plCart[i][1] + "***" + plCart[i][2]
	}
	Set_Cookie("plShoppingCart", txt);
}

function plLoadCart() {
	var tmp = "";
	var tmp2 = "";
	txt2 = Get_Cookie("plShoppingCart");
	if (txt2)
	{
		tmp = txt2.split("_____");
		plCart = [];
		for (i in tmp)
		{
			tmp2 = tmp[i].split("***");
			if (tmp2.length == 2) plCart[plCart.length] = [tmp2[0], tmp2[1], tmp2[2]];
		}
	}
}

function plResetCart() {
	Set_Cookie("plShoppingCart", "", -1000);
	Delete_Cookie("plShoppingCart");
	plCart = [];
}

function plSelectAll(obj) {
	el = document.getElementsByName("Delete[]");
	for (i =0; i<el.length ; i++ )
	{
		if (obj.checked) el[i].checked = true; else el[i].checked = false; 
	}
}

var platters = [];
function filterPlatters(p) {
	for (i=0; i<=3; i++) {
		el2 = document.getElementById("list_" + i);
		if (i==p) {
			setClass(el2, "active"); 
		} else {
			setClass(el2, "");
		}
	}

//	for (i=1; i<=3; i++)
//	{
//		el = document.getElementsByName("orderItem_" + i);
//		for (k=0; k<el.length ;k++ )
//		{
//			if (!p || p == i) {
//				el[k].style.display = 'block'; 
//			} else {
//				el[k].style.display = 'none'; 
//			}
//		}
//	}

	for (i in platters)
	{
		el = document.getElementById("orderItem_" + platters[i]);
		tmp = el.getAttribute("name").split("_");
		if (tmp[2] == p || !p) {
			el.style.display = 'block'; 
		} else {
			el.style.display = 'none'; 
		}
	}

}

function submitOrder() {
//	if (plCart.length == 0) plLoadCart();
	if (plCart.length == 0)
	{ 
		txt = "Your cart is empty";
		message(txt);
	} else {
		txt = "<div style='margin: 10px 20px;'><b>Order Information: </b><br><br><table width=280>";
		x = 0;
		tot = 0;
		for (i in plCart)
		{
			x ++;
			if (plCart[i][1] > 0)
			{
				txt += '<tr><td align="left"><nobr>' + plCart[i][2] + "</nobr></td><td align='right'><nobr>" + plCart[i][1] + ' x $'+ plCart[i][0] + '</nobr></td></tr>';
				tot += plCart[i][1] * plCart[i][0];
			}
		}
		txt += "</table>";
		txt += '<div style="width: 280px; height: 1px; margin: 10px 0px 5px 0px; background-color: #000;font-size: 1px;">&nbsp;</div>';
		txt += '<table width=280><tr><td align=right><B>Total: </B> </td><td align=right>$'  + (Math. round(100 * tot) / 100) + '</td></tr>';
		txt += '<tr><td align=right><B>GST: </B> </td><td align=right>$'  + (Math. round(5 * tot) / 100) + '</td></tr>';
		txt += '<tr><td align=right ><B>Grand Total: </B> </td><td align=right>$'  + (Math. round(105 * tot) / 100) + '</td></tr></table>';
		txt += '<div style="width: 280px; height: 1px; margin: 5px 0px 20px;; background-color: #000;font-size: 1px;">&nbsp;</div>';
		txt += '<b>Payment information: </b><br><br>';
		txt += '<table><tr><td align=right>Full Name: </td><td align=left><input type="text" name="oName" id="oName" value=""></td></tr>';
		txt += '<tr><td align=right>Address: </td><td align=left><textarea name="oAddress" id="oAddress"></textarea></td></tr>';
		txt += '<tr><td align=right>Phone Number: </td><td align=left><input type="text" name="oPhone" id="oPhone"></td></tr>';
		txt += '<tr><td align=right>Email: </td><td align=left><input type="text" name="oEmail" id="oEmail"></td></tr>';
		txt += '</table>';
//		txt += '<div style="width: 200px; height: 1px; margin: 5px 0px; background-color: #000;font-size: 1px;">&nbsp;</div>';
		txt += '<br><input type="button" value="Cancel" onclick="closeWait(); "> <input type="button" value="Process order" onclick=" processOrder();"><br><br>';
		txt += '</div>';
		showWait(txt);
	}
}

function processOrder() {
	n = document.getElementById("oName");
	a = document.getElementById("oAddress");
	p = document.getElementById("oPhone");
	e = document.getElementById("oEmail");

	error = "";
	if (!n.value || !a.value || !p.value || !checkEmail(e.value)) error += "Please fill all the fields!";
	if (error)
	{
		alert(error);
		return false;
	}

	url = "index.php?n=Main&o=save_order&name=" + encode(n.value) + "&address=" + encode(a.value) + "&phone=" + encode(p.value) + "&email=" + encode(e.value);
	showWait();
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_processOrder;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	txt = "";
}


function _processOrder() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		message("Your order was submitted. You will be contacted shortly to confirm the order. Please have your credit card ready as you will be requested the payment information.");
	}
}

function initOrderForm() {
	for (i in platters)
	{
		el = document.getElementById("curPrice_" + platters[i]);
		el2 = document.getElementById("Qty_" + platters[i]);
		el3 = document.getElementById("platterSizes_" + platters[i]);
		if (el2.value == "Number of items") {
			el.innerHTML = "";
			el3.selectedIndex = 0;
		} 
	}

}
var prevname = "bakery";
function showCategory(name) {
 el = document.getElementById("categImage");
 el.src = 'images/' + name + ".jpg";
 el = document.getElementById("div-" + prevname);
 el.style.display = 'none';
 el = document.getElementById("div-" + name);
 el.style.display = 'block';
 prevname = name;

}

function filterStore(id) {
	window.location = "index.php?n=Main&o=careers&id=" + id;
}


function showVideo() {

	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) {  
		txt = '<embed width="480" height="320" align="middle" type="application/x-shockwave-flash" salign="" allowfullscreen="false" allowscriptaccess="sameDomain" menu="true" name="swf/mikevideos" bgcolor="#ffffff" devicefont="false" flashvars="theSection=slogan" scale="showall" loop="true" play="true" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="swf/hfTour.swf"/>';
	} else {  
		var alternateContent = 'Sorry your current browser does not support scripting or it has been disabled.Please either update your browser or enable scripting support.'
			+ 'This content requires the Adobe Flash Player.'
			+ '<a href=http://www.macromedia.com/go/getflash/>Get Flash</a>';
		txt = alternateContent;  
	}
	txt = "<div style='width: 480px;'><div style='float: right;'><a href='#self' onclick='closeWait();'><img border=0 src='images/bttn_x.gif' onmouseover='this.src=/images/bttn_x_over.gif'></a></div>" + txt + "</div>";
	showWait(txt);
}


function validateJobForm() {
	el = document.getElementById('Name');
	if (!el.value)
	{
		alert("Please enter your name!");
		return false;
	}

	el = document.getElementById('Email');
	if (!el.value)
	{
		alert("Please enter your email address! If you don't have an email address, please enter a phone number in this field.");
		return false;
	}

		el = document.getElementById('Message');
	if (!el.value)
	{
		alert("You must fill the Message field with a cover letter, or a short message explaining your application!");
		return false;
	}
	return true;
}

function showJobApply(storename, storeid, posid) {
	txt = "<div class='jobform'><form action='index.php?o=apply' method='POST' enctype='multipart/form-data' onsubmit='return validateJobForm()'>";
	txt += "<input type='hidden' name='StoreID' value='"+storeid+"'>";
	txt += "<input type='hidden' name='PositionID' value='"+posid+"'>";
	txt += "<table cellpadding=0 cellspacing=0 border=0>";
	txt += "<tr><td class='left'>Store: </td><td class='right'><span>"+storename+"</span><td></tr>";
	txt += "<tr><td class='left'>Your Name: </td><td class='right'><input type='text' name='Name' id='Name'><td></tr>";
	txt += "<tr><td class='left'>Your Email: </td><td class='right'><input type='text' name='Email' id='Email'><td></tr>";
	txt += "<tr><td class='left'>Your Resume: </td><td class='right'><input type='file' name='Resume' id='Resume'><td></tr>";
	txt += "<tr><td class='left'>Message: </td><td class='right'><textarea name='Message' id='Message'></textarea><td></tr>";
	txt += "<tr><td class='center' colspan='2'><input type='submit' value='Submit Application'></td></tr>";
	txt += "</table>";
	txt += "</form></div>";
	message2(txt);
}
