mouseX = 0; mouseY = 0;

function encode(strToEncode) {
	return encodeURIComponent(strToEncode);
}
function updateMousePosition(e) {
	mouseX = getMouseX(e);
	mouseY = getMouseY(e);
}

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
  return "";
}

function findPosX(obj)
  {
	 try
	 {
		var curleft = 0;
		if(obj.offsetParent)
			while(1) 
			{
			  curleft += obj.offsetLeft;
			  if(!obj.offsetParent)
				break;
			  obj = obj.offsetParent;
			}
		else if(obj.x)
			curleft += obj.x;
		return curleft;
	 }
	 catch (e)
	 {
		 return 0;
	 }
  }

  function findPosY(obj)
  {
	 try {
		var curtop = 0;
		if(obj.offsetParent)
			while(1)
			{
			  curtop += obj.offsetTop;
			  if(!obj.offsetParent)
				break;
			  obj = obj.offsetParent;
			}
		else if(obj.y)
			curtop += obj.y;
		return curtop;
	 } 
	 catch (e) {
		return 0;
	 }
  }

// JavaScript Document
function MM_preloadImages() { //v3.0
  var d=document; 
  if(d.images)
  { 
  	if(!d.MM_p) d.MM_p=new Array();
    	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
		for(i=0; i<a.length; i++)
    		if (a[i].indexOf("#")!=0)
			{ d.MM_p[j]=new Image; 
				d.MM_p[j++].src=a[i];
			}
		}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; 
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  
  	if(!d) d=document; 
  	if((p=n.indexOf("?"))>0&&parent.frames.length) {
    	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
	}
  if(!(x=d[n])&&d.all) x=d.all[n];
  for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); 
  return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; 
  document.MM_sr=new Array; 
  for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null)
   {
	   document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
   }
}


///////////////////////////////////
function showText(id) {
//	el =document.getElementById("txt_main"); el.style.display = "none";
for (i=1;i<= 3 ; i++ )
{
	el =document.getElementById("txt0" + i); el.style.display = "none";
}
	el =document.getElementById("txt0" + id); el.style.display = "inline";
}

function showText2(id) {
//	el =document.getElementById("txt_main"); el.style.display = "none";
for (i=1;i<= 11 ; i++ )
{
	el =document.getElementById("txt0" + i); el.style.display = "none";
}
	el =document.getElementById("txt0" + id); el.style.display = "inline";
}

function showText3(id) {
//	el =document.getElementById("txt_main"); el.style.display = "none";
for (i=1;i<= 2 ; i++ )
{
	el =document.getElementById("txt0" + i); el.style.display = "none";
}
	el =document.getElementById("txt0" + id); el.style.display = "inline";
}


function hideText(id) {
//	el =document.getElementById("txt_main"); el.style.display = "inline";
//	el =document.getElementById("txt0" + id); el.style.display = "none";
}

function swapImg_txt(id, ref1, ref2, ref3, ref4){
	showText(id);
	MM_swapImage(ref1,ref2,ref3,ref4);
}
function swapImg_txt2(id, ref1, ref2, ref3, ref4){
	showText2(id);
	MM_swapImage(ref1,ref2,ref3,ref4);
}
function swapImg_txt3(id, ref1, ref2, ref3, ref4){
	showText3(id);
	MM_swapImage(ref1,ref2,ref3,ref4);
}

function bookmark(url, sitename)
{
  ns="Netscape and FireFox users, use CTRL+D to bookmark this site."
  if ((navigator.appName=='Microsoft Internet Explorer') &&
    (parseInt(navigator.appVersion)>=4))
  {
    window.external.AddFavorite(url, sitename);
  }
  else if (navigator.appName=='Netscape')
  {
    alert(ns);
  }
}

//send to a friend script

function showform() {
	el =document.getElementById("sendfriend");
	el.style.display = "block";
}
function hideform() {
	el =document.getElementById("sendfriend");
	el.style.display = "none";
}


var initialsubj="Hay buddy, take a look at this"
var initialmsg="Hi:\n You may want to check out this site: "+window.location
var good;
function checkEmailAddress(field) {

var goodEmail = field.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.info)|(\.sex)|(\.biz)|(\.aero)|(\.coop)|(\.museum)|(\.name)|(\.pro)|(\..{2,2}))$)\b/gi);
if (goodEmail) {
good = true;
}
else {
alert('Please enter a valid address.');
field.focus();
field.select();
good = false;
   }
}
u = window.location;
function mailThisUrl() {
good = false
checkEmailAddress(document.eMailer.email);
if (good) {

//window.location = "mailto:"+document.eMailer.email.value+"?subject="+initialsubj+"&body="+document.title+" "+u;
window.location = "mailto:"+document.eMailer.email.value+"?subject="+initialsubj+"&body="+initialmsg
   }
}

function showSect() {
	el =document.getElementById("sectmenu");
	el.style.display = "block";
}
function hideSect() {
	el =document.getElementById("sectmenu");
	el.style.display = "none";
}

function showSectB() {
	el =document.getElementById("sectmenu-b");
	el.style.display = "block";
}
function hideSectB() {
	el =document.getElementById("sectmenu-b");;
	el.style.display = "none";
}

function showSectY() {
	el =document.getElementById("sectmenu-y");
	el.style.display = "block";
}
function hideSectY() {
	el =document.getElementById("sectmenu-y");
	el.style.display = "none";
}

function showSectR() {
	el =document.getElementById("sectmenu-r");
	el.style.display = "block";
	el2=document.getElementById("sectmenulink-r");
	el2.style.backgroundColor="#ffffff";
	
}
function hideSectR() {
	el =document.getElementById("sectmenu-r");
	el.style.display = "none";
}
function showSectDP() {
	el =document.getElementById("sectmenu-dp");
	el.style.display = "block";
	
}
function hideSectDP() {
	el =document.getElementById("sectmenu-dp");
	el.style.display = "none";
}
function showSectPNK() {
	el =document.getElementById("sectmenu-pnk");
	el.style.display = "block";
	
}
function hideSectPNK() {
	el =document.getElementById("sectmenu-pnk");
	el.style.display = "none";
}
function showSectRockb() {
	el =document.getElementById("sectmenu-rockb");
	el.style.display = "block";
	
}
function hideSectRockb() {
	el =document.getElementById("sectmenu-rockb");
	el.style.display = "none";
}


function showSectP() {
	el =document.getElementById("sectmenu-p");
	el.style.display = "block";
}
function hideSectP() {
	el =document.getElementById("sectmenu-p");;
	el.style.display = "none";
}
function swapImageSwapText(id, ref1, ref2, ref3, ref4){
	swapText(ref4);
	MM_swapImage2(id,ref1,ref2,ref3);
}
function swapText(txt){
	el=document.getElementById("floortxt"); el.innerHTML = txt;
}

function bookmarkSite() {
	bookmark("http://preview.thebrandfactory.com/rockport2/index3.html",'The Rockport Group');
}

function bookmarkPage() {
	bookmark(window.location.href,window.location.href);
}

var curImage = 0;
function nextImage() {
	curImage ++;
	if (curImage >= imgList.length) curImage=0;
	MM_swapImage2('mainImage','',imgList[curImage][0].replace("_thumb", ""),1,imgList[curImage][1]);
}

function selectImage(x) {
	curImage = x-1;
}

function prevImage() {
	curImage --;
	if (curImage < 0) curImage=imgList.length-1;
	MM_swapImage2('mainImage','',imgList[curImage][0].replace("_thumb", ""),1,imgList[curImage][1]);
}




function nextImage2() {
	curImage ++;
	if (curImage >= imgList.length) curImage=0;
	MM_swapImage2('mainImage','',imgList[curImage][0].replace("_thumb", ""),1,imgList[curImage][1]);
	z=imgText[curImage];
	swapText(z);
}


function prevImage2() {
	curImage --;
	if (curImage < 0) curImage=imgList.length-1;
	MM_swapImage2('mainImage','',imgList[curImage][0].replace("_thumb", ""),1,imgList[curImage][1]);
	z=imgText[curImage];
	swapText(z);
}






function MM_swapImage2 (p1,p2,p3,idx,imgtitle){
//	alert(p3);
	try
	{
		for (i=0;i<imgList.length ;i++ )
		{
	//		alert(imgList[i].replace("_thumb", ""));
	//		break;
			if (imgList[i][0].replace("_thumb", "") == p3) {
				curImage = i;
				el  = document.getElementById('imageTitle');
				el.innerHTML = imgtitle;
				break;
			}
		}
	}
	catch (ex)
	{
	}

	MM_swapImage(p1,p2,p3,1);
}

function showGallery(x) {
	txt = "";
	for (i in imgList)
	{
		txt += "insert into cms_gallery_images(galleryid, name, thumbnail, fullimage) values(" + x + ", '','"+imgList[i]+"','"+imgList[i].replace("_thumb", "")+"');<br>";
	}
	document.write(txt);
}


var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();

function getScrollLength(orientation) {
	if (BrowserDetect.browser == "Explorer" || BrowserDetect.browser == "Firefox")
	{
		if (orientation == "top") return document.documentElement.scrollTop;
		if (orientation == "left") return document.documentElement.scrollLeft;
	} else {
		if (orientation == "top") return document.body.scrollTop;
		if (orientation == "left") return document.body.scrollLeft;
	}
}

function getMouseX(e) {
	var posx = 0;
	if (!e) var e = window.event;
	if (e.pageX || e.pageY) 	{
		posx = e.pageX;
	}
	else if (e.clientX || e.clientY) 	{
		posx = e.clientX + document.body.scrollLeft+ document.documentElement.scrollLeft;
	}
	return posx;
}

function getMouseY(e) {
	var posy = 0;
	if (!e) var e = window.event;
	if (e.pageY) 	{
		posy = e.pageY;
	}
	else if (e.clientY) 	{
		posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}
	return posy;
}

function getCenter(objwidth, objheight) {
	v = Viewport();

//		alert(v.scrollY + ": " +objheight);
//		alert($(window).height());

	posy=v.scrollY + ($(window).height() - objheight) / 2 ;
	posx=v.scrollX + ($(window).width() - objwidth) / 2 ;

	return {x:posx, y:posy};
}

function getXMLNode(x) {
	if (BrowserDetect.browser == "Firefox") {
		return x[0].textContent;
	} else {
		return x[0].firstChild.data;
	}

}

function getWindowWidth() {
	return getScrollLength("left") + document.documentElement.clientWidth;
}

function getWindowHeight() {
	return getScrollLength("top") + document.documentElement.clientHeight;
}

function Viewport(){ 
	var viewport = {};
	viewport.windowX = (document.documentElement && document.documentElement.clientWidth) || window.innerWidth || self.innerWidth || document.body.clientWidth; 
	viewport.windowY = (document.documentElement && document.documentElement.clientHeight) || window.innerHeight || self.innerHeight || document.body.clientHeight; 
	viewport.scrollX = (document.documentElement && document.documentElement.scrollLeft) || window.pageXOffset || self.pageXOffset || document.body.scrollLeft; 
	viewport.scrollY = (document.documentElement && document.documentElement.scrollTop) || window.pageYOffset || self.pageYOffset || document.body.scrollTop; 
	viewport.pageX = (document.documentElement && document.documentElement.scrollWidth) ? document.documentElement.scrollWidth : (document.body.scrollWidth > document.body.offsetWidth) ? document.body.scrollWidth : document.body.offsetWidth; 
	viewport.pageY = (document.documentElement && document.documentElement.scrollHeight) ? document.documentElement.scrollHeight : (document.body.scrollHeight > document.body.offsetHeight) ? document.body.scrollHeight : document.body.offsetHeight;
	return viewport;
}

function Set_Cookie( name, value, expires, path, domain, secure ) 
{
		// set time, it's in milliseconds
		var today = new Date();
		today.setTime( today.getTime() );

		/*
		if the expires variable is set, make the correct 
		expires time, the current script below will set 
		it for x number of days, to make it for hours, 
		delete * 24, for minutes, delete * 60 * 24
		*/
		if ( expires )
		{
		expires = expires * 1000 * 60 * 60 * 24;
		}
		var expires_date = new Date( today.getTime() + (expires) );

		document.cookie = name + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
		( ( path ) ? ";path=" + path : "" ) + 
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
}


// this fixes an issue with the old method, ambiguous values 
// with this test document.cookie.indexOf( name + "=" );
function Get_Cookie( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f
	
	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );
		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');
		
		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			try
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );	
			}
			catch (ex)
			{
				cookie_value = "";
			}
			
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}		

// this deletes the cookie when called
function Delete_Cookie( name, path, domain ) {
	if ( Get_Cookie( name ) ) document.cookie = name + "=" +
	( ( path ) ? ";path=" + path : "") +
	( ( domain ) ? ";domain=" + domain : "" ) +
	";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function opacity(elem, level) {
	elem.style.opacity = level/100;
	elem.style.filter = "alpha(opacity="+level+")";
}

function setClass(obj, className) {
	try
	{
		obj.className = className;
	}
	catch (ex)
	{
		obj.setAttribute("class", className);
	}
}

function msover(img) {
		filename = img.src.split("/");
		tmp = filename[filename.length-1].split(".");
		newsrc ="";
		for (i = 0;  i<tmp.length - 1; i++)
		{
			newsrc += tmp[i];
		}
		newsrc += "-over." + tmp[tmp.length-1];
		tmp = "";
		for (i=0;i<filename.length-1 ;i++ )
		{
			tmp += filename[i] + "/" ;
		}
		img.src = tmp + newsrc;
}

function msout(img) {
		img.src = img.src.replace("-over", "");
}


function centerElement(elid) {
	el = document.getElementById(elid);
	center = getCenter(el.offsetWidth, el.offsetHeight);
	el.style.left = parseInt(center.x) + "px";
	el.style.top = parseInt(center.y) + "px";
	el.style.position = "absolute";
	el.style.zIndex = 11;
}

function catchEnter() {
	if (window.event.keyCode==13){
		hideAlert();
	}
}

function addToFavorites(urlAddress, pageName) { 
	if (window.sidebar) window.sidebar.addPanel(pageName, urlAddress,"");
		else if( window.external ) window.external.AddFavorite( urlAddress, pageName); 
			else if(window.opera && window.print) { return true; }
}

function numberFormat(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function ajaxCall(url, callBack) {
	initObj();
	if (xmlhttp!=null) {
	  if (callBack) xmlhttp.onreadystatechange=callBack; else  xmlhttp.onreadystatechange=_alert3;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}

}

