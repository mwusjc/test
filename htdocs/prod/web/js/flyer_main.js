var pages = [];
var slices = [];
var products = [];
var boundaries = [];
//var curSlices = [];
//var curProducts = [];
var curPage = 0;
var flyerMode = "single";
var cart = [];
var masterWidth = 600;
var toggleAutoShow = true;
var showAutoAlert = true;

var imgz = {};

function initFlyer(pageid) {
	if (!pageid) pageid = 0;
	loadPage(pageid);
}

function loadPage(pageID) {
	if (flyerMode == "single")
	{
		obj = document.getElementById("pageHolder1");
		obj.style.backgroundImage = "url("+pages[pageID].image+")";
		obj.style.width = pages[pageID].width + "px";
		obj.style.height = pages[pageID].height + "px";
		boundaries[pageID] = [];
		boundaries[pageID][0] = findPosX(obj);
		boundaries[pageID][1] = findPosY(obj);
		boundaries[pageID][2] = boundaries[pageID][0] + obj.offsetWidth;
		boundaries[pageID][3] = boundaries[pageID][1] + obj.offsetHeight;
	} else {
		obj = document.getElementById("pageHolder1");
		if (pageID >= pages.length) {
			obj.style.backgroundImage = "";
			obj.style.backgroundColor = "#ffffff";
			obj.onmouseover = null;
			obj.onmousemove = null;
			obj.onmouseout = null;
			obj.onclick = null;
		} else {
			obj.style.backgroundImage = "url("+pages[pageID].image+")";
			obj.style.width = (pages[pageID].width/2) + "px";
			obj.style.height = (pages[pageID].height/2) + "px";
			boundaries[pageID] = [];
			boundaries[pageID][0] = findPosX(obj);
			boundaries[pageID][1] = findPosY(obj);
			boundaries[pageID][2] = boundaries[pageID][0] + obj.offsetWidth;
			boundaries[pageID][3] = boundaries[pageID][1] + obj.offsetHeight;
		}

		obj = document.getElementById("pageHolder2");
		if (pageID+1 >= pages.length) {
			obj.style.backgroundImage = "";
			obj.style.backgroundColor = "#ffffff";
			obj.onmouseover = null;
			obj.onmousemove = null;
			obj.onmouseout = null;
			obj.onclick = null;
		} else {
			obj.style.backgroundImage = "url("+pages[pageID+1].image+")";
			obj.style.width = (pages[pageID+1].width/2) + "px";
			obj.style.height = (pages[pageID+1].height/2) + "px";
			boundaries[pageID+1] = [];
			boundaries[pageID+1][0] = findPosX(obj);
			boundaries[pageID+1][1] = findPosY(obj);
			boundaries[pageID+1][2] = boundaries[pageID+1][0] + obj.offsetWidth;
			boundaries[pageID+1][3] = boundaries[pageID+1][1] + obj.offsetHeight;
		}
	}

	curPage = pageID;
	el = document.getElementById("currentPage");
	if (flyerMode == "single")
	{
		el.innerHTML = curPage + 1;
	} else {
		if (curPage < pages.length-1) el.innerHTML = (curPage + 1) + ", " + (curPage+2);	 else el.innerHTML = (curPage + 1);
	}
	loadCart();
	updateCart();
//	showSlices();
}

function showProduct(obj, e) {
	if (!toggleAutoShow) return false;
	pageIndex = parseInt(obj.id.replace("pageHolder", ""));
	if (pageIndex == 1)
	{
		pageID = curPage
	} else {
		pageID = curPage + 1;
	}
	if (!e) e = window.event;
	el = document.getElementById('divProduct');
	if (!el)
	{
		el = document.createElement("div");
		el.id = 'divProduct';
		el.style.display = 'none';
		el.style.position = 'absolute';
//		el.style.backgroundColor = "#ffffff";
		el.style.borderStyle = "solid";
		el.style.borderColor = "#000";
		el.style.borderWidth = "0px";
		el.style.padding = "0px";
//		el.style.padding = "30px";
		document.body.appendChild(el);
	}

	slice = getSlice(getMouseX(e), getMouseY(e), pageID);
//	mydiv=document.getElementById("debug");
//	mydiv.innerHTML = "MOUSE: x" + getMouseX(e) + ", y" + getMouseY(e) + "<br>";
//	mydiv.innerHTML += "BOUNDARIES: top" + boundaries[1] + ", left" + boundaries[0] + "<br>";
//	mydiv.innerHTML += "COMPUTED: top" + (getMouseY(e) - boundaries[1]) + ", left" + (getMouseX(e) - boundaries[0]) + "<br>";
//	mydiv.innerHTML += "SLICE: left" + slice + "<br>";

	if (slice > -1)
	{
		el.innerHTML = buildMouseover(slice);
		el.style.left = getMouseX(e) + "px";
		el.style.top = getMouseY(e) + "px";
		el.style.display = 'block';
	} else {
		el.style.display = 'none';
	}

}

function showProductOnClick(obj, e) {
	pageIndex = parseInt(obj.id.replace("pageHolder", ""));
	if (pageIndex == 1)
	{
		pageID = curPage
	} else {
		pageID = curPage + 1;
	}
	if (!e) e = window.event;
	el = document.getElementById('divProduct');
	if (!el)
	{
		el = document.createElement("div");
		el.id = 'divProduct';
		el.style.display = 'none';
		el.style.position = 'absolute';
//		el.style.backgroundColor = "#ffffff";
		el.style.borderStyle = "solid";
		el.style.borderColor = "#000";
		el.style.borderWidth = "0px";
		el.style.padding = "0px";
//		el.style.padding = "30px";
		document.body.appendChild(el);
	}

	slice = getSlice(getMouseX(e), getMouseY(e), pageID);
//	mydiv=document.getElementById("debug");
//	mydiv.innerHTML = "MOUSE: x" + getMouseX(e) + ", y" + getMouseY(e) + "<br>";
//	mydiv.innerHTML += "BOUNDARIES: top" + boundaries[1] + ", left" + boundaries[0] + "<br>";
//	mydiv.innerHTML += "COMPUTED: top" + (getMouseY(e) - boundaries[1]) + ", left" + (getMouseX(e) - boundaries[0]) + "<br>";
//	mydiv.innerHTML += "SLICE: left" + slice + "<br>";

	if (slice > -1)
	{
		el.innerHTML = buildMouseover(slice);
		el.style.left = getMouseX(e) + "px";
		el.style.top = getMouseY(e) + "px";
		el.style.display = 'block';
	} else {
		el.style.display = 'none';
	}

}

function buildMouseover(productID) {

	var txt;

	if (!(productID in imgz)) {
		imgz[productID] = {
			rootRelative: products[productID].image,
			fullyQualified: document.domain + '/' + products[productID].image,
			thumb: sizeify(document.domain + '/' + products[productID].image,'p80')
		};
	}

	txt = '<table class = "flyermo content" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff"><tr>';
    txt += '<td valign=top> ';
    //txt += '<img src="'+products[productID].image.replace(".","_tn.")+'" alt="roast" /></td><td style="text-align: left"><table cellspacing=0 cellpadding=0><tr><td><b>';
    txt += '<img src="' + imgz[productID].thumb + '" alt="roast" /></td><td style="text-align: left"><table cellspacing=0 cellpadding=0><tr><td><b>';
	txt += products[productID].name+'</b></td><td><img src="images/icon_delte_up.gif" onclick="hideProduct2(obj,event);" style="cursor: pointer; " onmouseover="this.src=\'images/icon_delte_over.gif\'"  onmouseout="this.src=\'images/icon_delte_up.gif\'"></td></tr></table><br />';
    txt += '<div class="mo-price" style="margin:5px 0 5px 0;"> $'+products[productID].pricing+'</div>';
    if (products[productID].packaging) txt += '<div style="margin:5px 0 5px 0; padding-left: 0px;"> '+products[productID].packaging+'</div>';
    txt += '</div>';
    txt += '<div style="padding-top: 5px;">'+products[productID].summary+'<br />';
    if (products[productID].comments) txt += products[productID].comments+'<br />';
	// txt += '<a target="_blank" href="http://twitter.com/home?status=great+sale+at+highand+farms+http://www.highlandfarms.ca/flyer.php?id='+(curPage + 1) +'" id="shareTwitter">Twitter</a>';
    txt += '</div>';
    txt += '</td>';
    txt += '</tr>';
    txt += '<tr>';
    txt += '<td colspan="2">';
    txt += '<div class="mo-expander" style="height: 22px; float: left; width: 100%;"><a href="#self" onclick="addToCart('+productID+', 1);"><nobr>Click now to add to shopping list</nobr></a></div>';
    txt += '<div class="expanded"> ';
    txt += 'Add to shopping list ';
    txt += '<input name="Qty" type="text" id="Qty" size="3" value="1"/>';
	txt += '<br />';
	txt += '		';
	txt += '</div>';
    txt += '<div class="mo-expander" style="height: 22px; float: left; width: 100%;"><a href="#self"><nobr>Email this deal to a friend</nobr></a></div>';
    txt += '<div style="text-align: left; padding: 0px 5px 0px 40px;"><br><br><br>';
    txt += 'Enter your friend\'s email address: <br>';
    txt += '<input name="Email" type="text" id="Email" size="22" value=""/>';
	txt += '<br />';
    txt += 'Enter your email address: <br>';
    txt += '<input name="FromEmail" type="text" id="FromEmail" size="22" value=""/>';
	txt += '</div>';
	txt += '<div style="text-align: left; padding: 5px 5px 0px 40px;"> ';
	txt += '<input type="button" style="border: 1px solid #ff6600; padding: 3px 10px; background-color:#fff; margin: 3px 0px;" value="Send Invitation" onclick="sendInvite('+products[productID].id+');"><br />';
	txt += '		';
	txt += '</div>';
    txt += '</div></td></tr></table>';
	return txt;
}


function sendInvite(id) {
	el = document.getElementById('Email');
	el2 = document.getElementById('FromEmail');
	if (!el.value)
	{
		alert("Please enter your friend's email address");
		return false;
	}
	if (!el.value)
	{
		alert("Please enter your email address");
		return false;
	}
	url = "index.php?n=Main&o=send_invite&email=" + encode(el.value) + "&fromemail=" + encode(el2.value) + "&id=" + id;
//	showWait();
//	message2("<div style='padding: 40px 50px;'>Your invitation has been sent!</div>");
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_sendInvite;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	txt = "";
}

function _sendInvite() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
	message2("<div style='padding: 40px 50px;'>Your invitation has been sent!</div>");
	}
}

function hideProduct2(obj, e) {
	toggleAutoShow = false;
	if (showAutoAlert) {
		alert("You have chosen to manually browse the products on the flyer. The default functionality will show the product information when you hover the mouse over its image. By turning it off, you will now have to click on the product image to display its description. If you turned this off by accident, click the link at the bottom of the flyer to re-enable automatic browsing. Thank you!");
		el5 = document.getElementById('autobrowse');
		el5.style.visibility ='visible';
	}
	showAutoAlert = false;
	pageIndex = parseInt(obj.id.replace("pageHolder", ""));
	if (pageIndex == 1)
	{
		pageID = curPage
	} else {
		pageID = curPage + 1;
	}

	el = document.getElementById('divProduct');
//	slice = getSlice(getMouseX(e), getMouseY(e), pageID);
//	if (el && slice == -1) ;
	if (el) el.style.display = 'none';

}

function hideProduct(obj, e) {
	if (!toggleAutoShow) return false;
	pageIndex = parseInt(obj.id.replace("pageHolder", ""));
	if (pageIndex == 1)
	{
		pageID = curPage
	} else {
		pageID = curPage + 1;
	}

	el = document.getElementById('divProduct');
	slice = getSlice(getMouseX(e), getMouseY(e), pageID);
	if (el && slice == -1) el.style.display = 'none';
}

function getSlice(x, y, pageID) {
	idx = -1;
	slice = -1;
	x = x - boundaries[pageID][0]; // mouse X coordinate relative to flyer page
	y = y - boundaries[pageID][1]; // mouse Y coordinate relative to flyer page
	ratio = (boundaries[pageID][2] - boundaries[pageID][0]) / masterWidth; // use this number to recompute the slice virtual dimensions. Real dimensions are relative to the background width in CMS (default: 600px)

	for (i in slices)
	{
		if (slices[i].pageid != pages[pageID].id) continue;
		if ((parseInt(slices[i].top * ratio) <= y) &&  ((parseInt(slices[i].top * ratio) + parseInt(slices[i].height * ratio)) >=y) && (parseInt(slices[i].left * ratio) <= x) && ((parseInt(slices[i].left * ratio) + parseInt(slices[i].width * ratio)) >=x))
		{
			if (idx <= slices[i].index)
			{
				idx =slices[i].index;
				slice = i;
			}
		}
	}
	return slice;
}

function showSlices() {
//		mydiv2=document.getElementById("debug2");
//mydiv2.innerHTML = "top, left, height, width<br>";
	for (i in curSlices)
	{
//		mydiv2.innerHTML += "<b>" + i + "</b>: " + curSlices[i].top + ", " +curSlices[i].left+ ", " +(parseInt(curSlices[i].height) + parseInt(curSlices[i].top))+ ", " +(parseInt(curSlices[i].width) + parseInt(curSlices[i].left)) + "<br>";
		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.left = (parseInt(curSlices[i].left) + boundaries[0]) + "px"; 
		dv.style.width ="1px";
		dv.style.top = (parseInt(curSlices[i].top) + boundaries[1]) + "px"; 
		dv.style.height = curSlices[i].height + "px";
		dv.style.backgroundColor = "#0000ff";
		document.body.appendChild(dv);

		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.left = (parseInt(curSlices[i].left) + boundaries[0]) + "px"; 
		dv.style.width =curSlices[i].width + "px";
		dv.style.top = (parseInt(curSlices[i].top) + boundaries[1]) + "px"; 
		dv.style.height = "1px";
		dv.style.backgroundColor = "#0000ff";
		document.body.appendChild(dv);

		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.left = (parseInt(curSlices[i].left) + boundaries[0]) + "px"; 
		dv.style.width =curSlices[i].width + "px";
		dv.style.top = (parseInt(curSlices[i].top) + boundaries[1] + parseInt(curSlices[i].height)) + "px"; 
		dv.style.height = "1px";
		dv.style.backgroundColor = "#0000ff";
		document.body.appendChild(dv);

		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.left = (parseInt(curSlices[i].left) + boundaries[0] + parseInt(curSlices[i].width)) + "px"; 
		dv.style.width ="1px";
		dv.style.top = (parseInt(curSlices[i].top) + boundaries[1]) + "px"; 
		dv.style.height = curSlices[i].height + "px";
		dv.style.backgroundColor = "#0000ff";
		document.body.appendChild(dv);

	}

}

function nextPage() {
	if (flyerMode == "single")
	{
		if (curPage < pages.length - 1)
		{
			loadPage(curPage + 1);
		}
	} else {
		if (curPage < pages.length - 2)
		{
			loadPage(curPage + 2);
		}
	}
}

function prevPage() {
	if (flyerMode == "single")
	{
		if (curPage > 0)
		{
			loadPage(curPage - 1);
		}
	} else {
		if (curPage > 1)
		{
			loadPage(curPage - 2);
		}
	}
}

function addToCart(productID, qt) {
	el = document.getElementById("Qty");
	if (cart[products[productID].id])
	{
		cart[products[productID].id][1] = parseInt(cart[products[productID].id][1]) + parseInt(el.value);
	} else 
		cart[products[productID].id] = [products[productID].name, parseInt(el.value)];
	saveCart();
	updateCart();
}

function addToCart2(productID) {
	el = document.getElementById("Quantity" + productID);
	if (cart[productID])
	{
		cart[productID][1] = parseInt(cart[productID][1]) + parseInt(el.value);
	} else {
		for (i in products)
		{
			if (products[i].id == productID) cart[productID] = [products[i].name, parseInt(el.value)];
		}
	}
	saveCart();
	updateCart();
}

function removeFromCart(productID) {
	tmp = [];
	for (i in cart)
	{
		if (i == productID) continue;
		tmp[i] = cart[i];
	}
	cart = tmp;
	saveCart();
	updateCart();
}

function updateCart() {
	txt = "";
	x = 0;
	for (i in cart)
	{
		x ++;
		txt += '<div class="listit" style="margin:5px 0 0 0;">' + cart[i][1] + " " + cart[i][0] + '</div>';
	}
	el = document.getElementById("shoppingList");
	el.innerHTML = txt;
	el = document.getElementById("cartSize");
	el.innerHTML = x;
}

function saveCart() {
	txt = "";
	for (i in cart)
	{
		if (txt) txt += "_____";
		txt += i + "%%%" + cart[i][0] + "%%%" + cart[i][1]
	}
	Set_Cookie("shoppingCart", txt, 86400);
}

function loadCart(doUpdate) {
	var tmp = "";
	var tmp2 = "";
	txt = Get_Cookie("shoppingCart");
	if (txt)
	{
		tmp = txt.split("_____");
		cart = [];
		for (i in tmp)
		{
			tmp2 = tmp[i].split("%%%");
			cart[tmp2[0]] = [tmp2[1], tmp2[2]];
		}
	}
	if (doUpdate) updateCart();
}

function resetCart() {
	Set_Cookie("shoppingCart", "", -1000);
	Delete_Cookie("shoppingCart");
	cart = [];
}
