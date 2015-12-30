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
	posy=getScrollLength("top") + (document.documentElement.clientHeight - objheight) / 2 ;
	posx=getScrollLength("left") + (document.documentElement.clientWidth -objwidth)/2 ;
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
		newsrc += "_over." + tmp[tmp.length-1];
		tmp = "";
		for (i=0;i<filename.length-1 ;i++ )
		{
			tmp += filename[i] + "/" ;
		}
		img.src = tmp + newsrc;
}

function msout(img) {
		img.src = img.src.replace("_over", "");
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