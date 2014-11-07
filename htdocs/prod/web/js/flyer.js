document.onmousemove = drag;
document.onmouseup = drop;
document.onkeyup = moveObject;
var regionIndex = 0;
var boundaries = []
var mouseOffset;
var curRegion = "";
var dragActive = false;
var slices = [];
var sliceIndex = 2;
var moveMode = 0;
var products = [];
var categories = [];
var loadedProduct = {id: 0, name:"", summary:"",category:"",brand:"",pricing:"",packaging:"",comments:"",image:"",thumbnail:""};
var activeSlices = [];
var productLoaded = false;


function showGrid() {
	obj = document.getElementById("pageHolder");
	for (i = 0; i< obj.offsetWidth ; i = i + 5 )
	{
		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.width = '1px';
		dv.style.backgroundColor = '#eee';
		dv.style.height = obj.offsetHeight + "px";
		dv.style.top =  findPosY(obj) + "px";
		dv.style.left =  (findPosX(obj) + i) + "px";
		opacity(dv, 40);
		dv.onmousedown = dragStart;
		document.body.appendChild(dv);
	}
	obj = document.getElementById("pageHolder");
	for (i = 0; i< obj.offsetHeight; i = i + 5 )
	{
		dv = document.createElement("div");
		dv.style.position = 'absolute';
		dv.style.height = '1px';
		dv.style.backgroundColor = '#eee';
		dv.style.width = obj.offsetWidth + "px";
		dv.style.left=  findPosX(obj) + "px";
		dv.style.top =  (findPosY(obj) + i) + "px";
		opacity(dv, 40);
		dv.onmousedown = dragStart;
		document.body.appendChild(dv);
	}
}

function dragStart(e) {
	if (!e) w=window.event;
	if (dragActive) return true;
	if (moveMode) return true;
	obj = document.getElementById("pageHolder");
	
	boundaries[0] = findPosX(obj);
	boundaries[1] = findPosY(obj);
	boundaries[2] = boundaries[0] + obj.offsetWidth;
	boundaries[3] = boundaries[1] + obj.offsetHeight;

	if (obj && e)
	{
		dragActive = true;
		mouseOffset = getPosition(obj, e);
		dragObj = obj;
		regionIndex ++;
		dv = document.createElement("div");
		dv.id="region_" + regionIndex;
		opacity(dv, 45);
		dv.style.backgroundColor = "#eeeeee";
		dv.style.position = 'absolute';
		l = getMouseX(e);
		dv.style.left = l + "px"; 
		dv.style.width = "1px";
		t = getMouseY(e);
		dv.style.top = t + "px"; 
		dv.style.height = "1px";

		dv.style.backgroundColor = "#fff";
		dv.style.display = "none";
		dv.style.borderWidth = "1px";
		dv.style.borderStyle = "dotted";
		dv.style.borderColor = "#000";
		dv.onclick = toggleSlice;
		dv.onmousedown = dragStart;
		dv.oncontextmenu = contextMenu;
		document.body.appendChild(dv);
		curRegion = dv.id;
		dv.innerHTML = "<div onclick='return false;' style='background-color: #aaa; width: 100%; height: 100%;'></div>";
		
	}

}


function drag(e) {
	if (dragActive)
	{
		el = document.getElementById(curRegion);
		el.style.display = "block";
		w = getMouseX(e)  - mouseOffset.x - boundaries[0];
		h = getMouseY(e) - mouseOffset.y - boundaries[1];
		w = Math.min(w, boundaries[2] - parseInt(el.style.left));
		h = Math.min(h, boundaries[3] - parseInt(el.style.top));
		el.style.width = w +  "px";
		el.style.height = h + "px";
	}
}

function drop() {
	if (dragActive)
	{
		el = document.getElementById(curRegion);
		if (parseInt(el.style.width) * parseInt(el.style.height) >= 25) {
			tmp = 3 * Math.floor((parseInt(el.style.left)  - boundaries[0])/3) + boundaries[0]; el.style.left  = tmp + "px";
			tmp = 3 * Math.round((parseInt(el.style.width))/3)-2;el.style.width  = tmp + "px";
			tmp = 3 * Math.floor((parseInt(el.style.top)  - boundaries[1])/3) + boundaries[1]; el.style.top = tmp + "px";
			tmp = 3 * Math.round((parseInt(el.style.height))/3)-2;el.style.height = tmp + "px";

			el.style.zIndex = sliceIndex ++;
			el.innerHTML = regionIndex;
			slices[regionIndex] = {id: dv.id, selected: false, top: t, left: l, width: 0, height: 0, index: 1, productid: regionIndex};
			products[regionIndex] = {id: 0, name:"", summary:"",category:"",brand:"",pricing:"",packaging:"",comments:"",image:"",thumbnail:""};
			slices[regionIndex].top = parseInt(el.style.top);
			slices[regionIndex].left = parseInt(el.style.left);
			slices[regionIndex].width = parseInt(el.style.width);
			slices[regionIndex].height= parseInt(el.style.height);
			slices[regionIndex].index= parseInt(sliceIndex);
			updateSlices();
		}
	}
	dragActive = false;
	debug();
}

function getPosition(obj, e){
	lft =getMouseX(e) - findPosX(obj);
	tp = getMouseY(e) - findPosY(obj);
	return {x:lft, y:tp};
}

function toggleSlice(id) {
	if (dragActive) return true;
	if (!id) id = this.id;
	obj = document.getElementById(id);
	if (!obj)
	{
		id = this.id;
		obj = document.getElementById(id);
	}
	tmp = obj.id.split("_");
	
	toggleSliceDisplay(tmp[1]);
	updateSelection();
}

function toggleSliceDisplay(sliceID) {
	if (sliceID && sliceID == parseInt(sliceID)) {
		slices[sliceID].selected = !slices[sliceID].selected;
		if (slices[sliceID].selected)
		{
			obj.style.borderColor = "#0000ff";
			obj.style.backgroundColor = "#FFFF99";
			opacity(obj, 55);
		} else {
			obj.style.borderColor = "#000000";
			obj.style.backgroundColor = "#FFFFFF";
			opacity(obj, 45);
		}
	}

}

function removeSlice(id) {
	el = document.getElementById(id);
	tmp = id.split("_");
	el.style.display = 'none';
	slices[tmp[1]] = [];
	updateSlices();
}

function changeIndex(id, direction) {
	el = document.getElementById(id);
	tmp = id.split("_");
	newIndex = 	slices[tmp[1]].index + direction;
	slices[tmp[1]].index = newIndex;
	el.style.zIndex = newIndex;
}

function closeContextMenu() {
	dv = document.getElementById("contextM");
	dv.style.display = "none";

}

function contextMenu(e) {
	dv = document.getElementById("contextM");
	if (dv)
	{
		dv.style.display = "block";
	} else {
		dv = document.createElement("div");
		dv.id = 'contextM';
		dv.style.zIndex = 1000;
		dv.style.position = 'absolute';
		dv.style.backgroundColor = '#ffffff';
		dv.style.borderColor = '#eee';
		dv.style.borderWidth = '1px';
		dv.style.borderStyle = 'solid';
		dv.style.lineHeight = '150%';
		dv.style.top = getMouseY(e) + "px";
		dv.style.left = getMouseX(e) + "px";
		document.body.appendChild(dv);
	}

	txt = "<table cellpadding=0 cellspacing=0 border=0>";
	txt += "<tr><td style='width: 13px; background-color: silver; border-right: 1px solid #eee;'>&nbsp;</td>";
	txt += "<td style='padding: 5px 0px;'><table cellspacing=0 cellpadding=0 border=0>";
	txt += "<tr><td style='border-bottom: 1px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick='removeSlice(\""+this.id+"\"); closeContextMenu();'>delete region</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt += "<tr><td style='border-bottom: 1px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick='toggleSlice(\""+this.id+"\"); closeContextMenu();'>toggle select</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt += "<tr><td style='border-bottom: 1px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick='changeIndex(\""+this.id+"\", 1); closeContextMenu();'>bring to front</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt += "<tr><td style='border-bottom: 1px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick='changeIndex(\""+this.id+"\", -1); closeContextMenu();'>send to back</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt += "<tr><td style='border-bottom: 1px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick='startMove(\""+this.id+"\", -1); closeContextMenu();'>move region</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt += "<tr><td style='border-bottom: 0px solid #eee; padding: 3px 0px;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#self' onclick=' closeContextMenu();'>close</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
	txt +="</table>";
	txt +="</td></tr></table>";
	dv.innerHTML = txt;
	return false;
}

function startMove(id) {
	tmp = id.split("_");
	moveMode = tmp[1];
	dragActive = false;
	el = document.getElementById(id);
	el.style.borderWidth ="3px";
	el.style.borderColor ="#ff0000";
}

function moveObject(e) {
	if (!moveMode) return true;
	if (!e) window.event;
	el = document.getElementById("region_" + moveMode);

	if (e.keyCode == 39)
	{
		el.style.left = (parseInt(el.style.left) + 1) + "px";
		return false;
	}

	if (e.keyCode == 37)
	{
		el.style.left = (parseInt(el.style.left) - 1) + "px";
		return false;
	}

	if (e.keyCode == 38)
	{
		el.style.top = (parseInt(el.style.top) + 1) + "px";
		return false;
	}

	if (e.keyCode == 40)
	{
		el.style.top = (parseInt(el.style.top) - 1) + "px";
		return false;
	}

	if (e.keyCode == 13) endMove();

	return false;
}

function endMove() {
	el = document.getElementById("region_" + moveMode);
	el.style.borderWidth = "1px";
	el.style.borderColor = "#000";
	modeMode = 0;
	dragActive = false;
}

function updateSlices() {
	container = document.getElementById('regionsList');
	txt = "<table cellpadding=0 cellspacing=0 width=100%>";
	for (i in slices)
	{
		if (slices[i].selected) bgcl = "#cccccc"; else bgcl = "#f0f0f0";
		if (slices[i].id) txt += "<tr><td style='width: 290px; vertical-align: middle; background-color: "+bgcl+"; color: #000; padding: 5px 2px; margin-bottom: 1px; cursor: pointer;' onclick='toggleSlice(\""+slices[i].id+"\");'>Region  # " + i + "</td><td style='width: 20px; vertical-align: middle;background-color: "+bgcl+"; '><a href='#self' onclick='removeSlice(\"region_"+i+"\")'><img src='/_common/images/common/small/delete2.png' border='0'></a></td></tr>";
	}
	txt += "</table>";
	container.innerHTML = txt;
}

function updateSelection() {

	activeSlices = [];
	for (i in slices)
	{
		if (slices[i].selected) activeSlices[activeSlices.length] = i;
	}

	el = document.getElementById("rpSelected");
	txt = "";
	for (i in activeSlices)
	{
			txt +="<span style='background-color: #666; color: #fff; border: 1px solid red'>" +  activeSlices[i] + "</span>&nbsp;&nbsp;";
	}
	el.innerHTML = txt;
	if (activeSlices.length == 0)
	{ 
		clearProductArea();
	} else {
		if (activeSlices.length == 1) loadSliceProduct(slices[activeSlices[0]].productid);
	}
	 updateSlices();

	 for (i in slices)
	 {
		 el = document.getElementById("region_" + i);
		 el.innerHTML = i + "<br>" + products[i].name;
	 }
}

function showProductsForm() {
	txt = "<table><tr><td width=120></td><td width=240></td><td width=15><a href='#self' onclick='closeAlert();'>X</a></td></tr>";
	txt += "<tr><td align='right'>Filter by Category: </td><td><select id='pfCategory' onchange='loadProducts(this.options[this.selectedIndex].value)'><option value=''> -- select category -- </option>";
	for (i in categories)
	{
		txt += "<option value='"+i+"'>"+categories[i]+"</option>";
	}
	txt += "</select></td></tr>";
	txt += "<tr><td align='right'>Products List: </td><td><select id='pfProduct' multiple='yes' size='10'></select></td></tr>";
	txt += "<tr><td colspan='2'><center><input type='button' value='Cancel' onclick='closeAlert();'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Load Product' onclick='loadProduct();'></center></td></tr>";
	txt = '<div>'+txt+'</div>';
	showAlert(txt);
}

function loadProducts(id) {
	url = "index2.php?n=Flyers&o=get_products&id=" + id;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_loadProducts;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
}

function _loadProducts() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;

		x=response.getElementsByTagName("ProductID");
		y=response.getElementsByTagName("ProductName");

		el = document.getElementById("pfProduct");
		el.options.length = 0;
		for (i =0; i<x.length ; i++ )
		{
			opt = new Option();
			opt.value = x[i].firstChild.data;
			opt.text = y[i].firstChild.data;
			el.options[el.options.length] = opt;
		}
	}
}

function loadProduct() {
	el = document.getElementById("pfProduct");
	url = "index2.php?n=Flyers&o=get_product_info&id=" + el.options[el.selectedIndex].value;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_loadProduct;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}

}

function _loadProduct() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;

//		newProduct = products.length;
//		products[newProduct] = {id: 0, name:'', summary:'', packagin:'',pricing:'',comments:'',catergory:'',brand:'',image:'',thumb:''}

		x=response.getElementsByTagName("Name");
		el = document.getElementById("rpName"); el.value = getXMLNode(x);
		loadedProduct.name =getXMLNode(x);
				
		try
		{
			x=response.getElementsByTagName("ProductID");
			loadedProduct.id =getXMLNode(x);
		}
		catch (ex)	{ }

		try
		{
			x=response.getElementsByTagName("Image");
			loadedProduct.image =getXMLNode(x);
		}
		catch (ex)	{ }

		try
		{
			x=response.getElementsByTagName("Thumbnail");
			loadedProduct.thumb =getXMLNode(x);
		}
		catch (ex)	{ }

		try
		{
		x=response.getElementsByTagName("Description");
//		el = document.getElementById("rpSummary"); el.innerHTML = getXMLNode(x);
		loadedProduct.summary =getXMLNode(x);
		}
		catch (ex)	{ }

//		try
//		{
//		x=response.getElementsByTagName("Description");
//		el = document.getElementById("rpSummary"); el.innerHTML = getXMLNode(x);
//		loadedProduct.thumb =getXMLNode(x);
//		}
//		catch (ex)	{ }

		try
		{
		x=response.getElementsByTagName("Packaging");
//		el = document.getElementById("rpPackaging"); el.innerHTML = getXMLNode(x);
		loadedProduct.packaging =getXMLNode(x);

		}
		catch (ex)	{ }
		
		try
		{
		x=response.getElementsByTagName("Pricing");
//		el = document.getElementById("rpPricing"); el.innerHTML = getXMLNode(x);
		loadedProduct.pricing =getXMLNode(x);

		}
		catch (ex)	{ }
		
		try
		{
		x=response.getElementsByTagName("Comments");
//		el = document.getElementById("rpComments"); el.innerHTML = getXMLNode(x);
		loadedProduct.comments =getXMLNode(x);

		}
		catch (ex)	{ }

		try
		{
		x=response.getElementsByTagName("CategoryID");
//		el = document.getElementById("rpCategoryID"); 
		loadedProduct.category =getXMLNode(x);
		for (i =0; i<el.options.length ; i++ )
		{
			if (el.options[i].value == getXMLNode(x))
			{
				el.selectedIndex = i;
			}
		}

		}
		catch (ex)	{ }

		try
		{
		x=response.getElementsByTagName("BrandID");
//		el = document.getElementById("rpBrandID");
		loadedProduct.brand =getXMLNode(x);
		for (i =0; i<el.options.length ; i++ )
		{
			if (el.options[i].value == getXMLNode(x))
			{
				el.selectedIndex = i;
			}
		}

		}
		catch (ex)	{ }
		
		updateProductArea();
		closeWait();
		message("Product loaded succesfully");
	}
}

function saveSliceInfo() {
	if (activeSlices.length == 0)
	{
		message("No slices were selected!!");
		return false;
	}
	saveProductArea();
	for (i in activeSlices)
	{
		products[activeSlices[i]] = loadedProduct;
		toggleSliceDisplay(activeSlices[i]);
	}
	updateSelection();
}

function clearProductArea() {
			el = document.getElementById("rpName"); el.value = "";		
			el = document.getElementById("rpSummary"); el.innerHTML = "";
			el = document.getElementById("rpPackaging"); el.innerHTML = "";
			el = document.getElementById("rpPricing"); el.innerHTML = "";
			el = document.getElementById("rpComments"); el.innerHTML = "";
			el = document.getElementById("rpCategoryID"); el.selectedIndex = 0;
			el = document.getElementById("rpBrandID");el.selectedIndex = 0;
			el = document.getElementById("rpPath"); el.innerHTML = "";
			productLoaded = false;
}

function saveProductArea() {
			el = document.getElementById("rpName");  loadedProduct.name = el.value;		
			el = document.getElementById("rpSummary"); loadedProduct.summary = elValue(el);
			el = document.getElementById("rpPackaging"); loadedProduct.packaging = elValue(el);
			el = document.getElementById("rpPricing"); loadedProduct.pricing = elValue(el);

			el = document.getElementById("rpComments"); loadedProduct.comments = elValue(el);
			el = document.getElementById("rpCategoryID"); loadedProduct.category = el.options[el.selectedIndex].value;
			el = document.getElementById("rpBrandID"); loadedProduct.brand = el.options[el.selectedIndex].value;
			el = document.getElementById("rpPath"); loadedProduct.image = el.innerHTML;
//			debug();
}

function updateProductArea() {
			el = document.getElementById("rpName"); el.value = loadedProduct.name;		
			el = document.getElementById("rpSummary"); el.innerHTML = loadedProduct.summary;
			el = document.getElementById("rpPackaging"); el.innerHTML = loadedProduct.packaging;
			el = document.getElementById("rpPricing"); el.innerHTML = loadedProduct.pricing;
			el = document.getElementById("rpComments"); el.innerHTML = loadedProduct.comments;
			el = document.getElementById("rpPath"); el.innerHTML = loadedProduct.image;
			el = document.getElementById("rpCategoryID"); 
			for (i =0; i<el.options.length ; i++ )
			{
				if (el.options[i].value ==loadedProduct.category)
				{
					el.selectedIndex = i;
				}
			}
			el = document.getElementById("rpBrandID");
			for (i =0; i<el.options.length ; i++ )
			{
				if (el.options[i].value == loadedProduct.brand)
				{
					el.selectedIndex = i;
				}
			}

}

function loadSliceProduct(id) {
		productLoaded = true;
		loadedProduct = products[id];
		updateProductArea();
//		el = document.getElementById("rpDebug"); el.innerHTML = slices[id].top + ", " + slices[id].left + ", " + slices[id].width + ", " + slices[id].height;
}

function postUpload(param) {
	loadedProduct.image = param;
	el = document.getElementById("rpPath"); 
//	el.style.width = "200px";
	el.innerHTML = loadedProduct.image;
}

function saveFlyerPage() {
	txt = "";
	for (i in slices)
	{
		if (slices[i].length == 0) continue;
		txt += i + "^^^^";
//			slices[regionIndex] = {id: dv.id, selected: false, top: t, left: l, width: 0, height: 0, index: 1, productid: regionIndex};
//			products[regionIndex] = {id: 0, name:"", summary:"",category:"",brand:"",pricing:"",packaging:"",comments:"",image:"",thumbnail:""};

		txt += (slices[i].top - boundaries[1]) + "^^^^";
		txt += (slices[i].left - boundaries[0]) + "^^^^";
		txt += slices[i].width + "^^^^";
		txt += slices[i].height + "^^^^";
		txt += slices[i].index + "^^^^";
		txt += products[i].id+ "^^^^";
		txt += products[i].name+ "^^^^";
		txt += products[i].summary+ "^^^^";
		txt += products[i].category+ "^^^^";
		txt += products[i].brand+ "^^^^";
		txt += products[i].pricing+ "^^^^";
		txt += products[i].packaging+ "^^^^";
		txt += products[i].comments+ "^^^^";
		txt += products[i].image+ "#####";
	}	

	el = document.getElementById('pageData');
	el.innerHTML = txt;
	el = document.getElementById('frmEdit');
	el.submit();


}

function loadRegions() {
	regionIndex =0;
	obj = document.getElementById("pageHolder");
	
	boundaries[0] = findPosX(obj);
	boundaries[1] = findPosY(obj);
	boundaries[2] = boundaries[0] + obj.offsetWidth;
	boundaries[3] = boundaries[1] + obj.offsetHeight;
	for (i in slices)
	{
		slices[i].left = parseInt(boundaries[0]) + parseInt(slices[i].left);
		slices[i].top = parseInt(boundaries[1]) + parseInt(slices[i].top);
	}

for (i in slices)
	{
		dv = document.createElement("div");
		dv.id="region_" + i;
		regionIndex = i;
		opacity(dv, 45);
		dv.style.backgroundColor = "#eeeeee";
		dv.style.position = 'absolute';
		dv.style.left = parseInt(slices[i].left) + "px"; 
		dv.style.width = slices[i].width + "px";
		dv.style.top = parseInt(slices[i].top) + "px"; 
		dv.style.height = slices[i].height + "px";
		dv.style.backgroundColor = "#fff";
		dv.style.borderWidth = "1px";
		dv.style.borderStyle = "dotted";
		dv.style.borderColor = "#000";
		dv.onclick = toggleSlice;
		dv.onmousedown = dragStart;
		dv.oncontextmenu = contextMenu;
		document.body.appendChild(dv);

//		dv.innerHTML = "<div onclick='return false;' style='background-color: #aaa; width: 100%; height: 100%;'></div>";
		dv.style.zIndex = sliceIndex ++;
	}
	updateSlices();
	updateSelection();
	debug();
}

function debug() {
	return true;
	txt = "";
	txt += boundaries[0] + "," + boundaries[1]+ "," + boundaries[2]+ "," + boundaries[3] + "\n";
	txt += "--------------------\n";
	x= 3;
	for (i in slices)
	{
		if (slices[i].length == 0) continue;
		txt += i + ":  ";
//			slices[regionIndex] = {id: dv.id, selected: false, top: t, left: l, width: 0, height: 0, index: 1, productid: regionIndex};
//			products[regionIndex] = {id: 0, name:"", summary:"",category:"",brand:"",pricing:"",packaging:"",comments:"",image:"",thumbnail:""};

		txt += slices[i].top + ",";
		txt += slices[i].left + ",";
		txt += slices[i].height+ ",";
		txt += slices[i].width + "\n";
//		txt += products[i].id+ "^^^^";
//		txt += products[i].name+ "^^^^";
//		txt += products[i].summary+ "^^^^";
//		txt += products[i].category+ "^^^^";
//		txt += products[i].brand+ "^^^^";
//		txt += products[i].pricing+ "^^^^";
//		txt += products[i].packaging+ "^^^^";
//		txt += products[i].comments+ "^^^^";
//		txt += products[i].image+ "\n";
		x++;
	}	

	el = document.getElementById('rpDebug');
	el.rows = x;
	el.innerHTML = txt;

}

function elValue(el) {
	if (!el.value) return el.innerHTML; else return el.value;
}