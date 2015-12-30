var overlayon = false;
var overlaycolor = "#444444";
var overlayopacity = 85;
var overlayid = "overlay_main";
var messageid = "message_win";
var overlayZ = 20;

window.onresize = resizeOverlay;

function showOverlay() {
	xxx = document.getElementById("hideme");	if (xxx) xxx.style.visibility = "hidden";
	dv = document.getElementById(overlayid);
	if (!dv)
	{
		v = Viewport();
		x = v.pageX;
		y = v.pageY;

		dv = document.createElement("div");
		dv.style.position = "absolute";
		dv.id = overlayid;
		dv.style.backgroundColor = overlaycolor;
		opacity(dv, overlayopacity);
		
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.height = y + "px";
		dv.style.width = x + "px";

		dv.style.zIndex = overlayZ;	
		document.body.appendChild(dv);
	} else {
		v = Viewport();
		x = v.pageX;
		y = v.pageY;
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.height = y + "px";
		dv.style.width = x + "px";

		dv.style.display = "block";
	}
	overlayon = true;
}

function closeOverlay() {
		dv = document.getElementById(overlayid);
		dv.style.display = "none";
		overlayon = false;
}

function showWait(msg) {
	if (!msg) msg = "<div onclick='closeWait();' style='width: 400px; height: 300px; padding: 30px; '><b>Please wait .... </b><br><br><img src='_common/images/loadingAnimation.gif'></div>";
	showOverlay();

	dv = document.getElementById(messageid);
	if (!dv)
	{
		dv = document.createElement("div");

		dv.style.position = "absolute";
		dv.style.display = "block";
		dv.innerHTML = msg;
		opacity(dv, 0);
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.backgroundColor = "#ffffff";
		dv.style.color = "#444444";
		dv.style.zIndex = overlayZ + 1;	
		dv.style.borderWidth = "2px";	
		dv.style.borderStyle = "solid";	
		dv.style.borderColor = "#bfbfbf";	
		dv.style.padding = "5px";
		dv.id = messageid;
		document.body.appendChild(dv);
	} else  {
		dv.innerHTML = msg;
		dv.style.display = "block";
	}
	w = dv.offsetWidth; if (parseInt(w) == 0) w = 600;
	h = dv.offsetHeight; if (parseInt(h) == 0) h = 400;
	c = getCenter(w, h);
	dv.style.left = c.x + "px";
	dv.style.top = c.y + "px";
	opacity(dv, 100);
 }

 function closeWait() {
		dv = document.getElementById(messageid);
		dv.style.display = "none";
		dv.innerHTML = "";
		closeOverlay();
		xxx = document.getElementById("hideme");	if (xxx) xxx.style.visibility = "visible";
 }

 function showAlert(msg) {
	showWait(msg);
 }
 
 function closeAlert() {
	closeWait();
 }

function showError(msg) {
	msg = "<div class='error'>" + msg + "<br><br<div class='line'>&nbsp;</div><br><center><input type='button' value='close' onclick='closeWait();'></div>";
	showAlert(msg);
}

function resizeOverlay() {
	if (overlayon)
	{
		v = Viewport();
		x = v.pageX;
		y = v.pageY;

		dv = document.getElementById(overlayid);
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.height = y + "px";
		dv.style.width = x + "px";

		dv = document.getElementById(messageid);
		w = dv.offsetWidth; if (parseInt(w) == 0) w = 600;
		h = dv.offsetWidth; if (parseInt(h) == 0) h = 400;
		c = getCenter(w, h);
		dv.style.left = c.x + "px";
		dv.style.top = c.y + "px";

	}
}

function message(msg, wdth) {
	txt = "";
	if (wdth)
	{
		txt = " width: " + wdth + "px;";
	}
	showAlert("<div onclick='closeWait();' style='"+txt+"padding: 30px 60px; text-align: center; line-height: 150%;'><b>"+msg+"</b><br><br><input type=button value=close onclick='closeWait();'></div>");
}

function messageRound(msg, wdth) {
	showOverlay();
	msg = "<div class='round-msg'><img class='fpop-close' src='/images/fpop-close.png' onclick='closeWait();'>"+msg+"</div>";

	txt = "";
	if (wdth)
	{
		txt = " width: " + wdth + "px;";
	}
	dv = document.getElementById(messageid);
	if (!dv)
	{
		dv = document.createElement("div");

		dv.style.position = "absolute";
		dv.style.display = "block";
		dv.innerHTML = msg;
		opacity(dv, 0);
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.backgroundColor = "#ffffff";
		dv.style.borderRadius = "12px";
		dv.style.color = "#444444";
		dv.style.zIndex = overlayZ + 1;	
		dv.style.borderWidth = "1px";	
		dv.style.borderStyle = "solid";	
		dv.style.borderColor = "#ffffff";	
		dv.style.padding = "0px";
		dv.id = messageid;
		document.body.appendChild(dv);
	} else  {
		dv.innerHTML = msg;
		dv.style.display = "block";
	}
	w = dv.offsetWidth; //if (parseInt(w) == 0) w = 600;
	h = dv.offsetHeight; //if (parseInt(h) == 0) h = 400;
	c = getCenter(w, h);
	dv.style.left = c.x + "px";
	dv.style.top = c.y + "px";
	opacity(dv, 100);
}


function customMessage(msg, styl) {
	showAlert("<div onclick='closeWait();' style='padding: 30px 60px; text-align: center; line-height: 150%;"+styl+"'><b>"+msg+"</b><br><br><input type=button value=close onclick='closeWait();'></div>");
}

function upload(url) {
	txt = "<div id='divUpload'><center><span style='color: #ff0000; display: none;' id='uploadStatus'>please wait ... </span></center><div><form method='POST' id='frmUpload' name='frmUpload' action='"+url+"' target='frameUpload' enctype='multipart/form-data'>Select file: <input type='file' value='' name='Filename'> <input type='button' value='upload' onclick='doUpload();'></form></div>";
	txt += "<iframe src='' width=500 height=100 bgcolor='00ffff' name='frameUpload' id='frameUpload'></iframe>";
	txt += "<br><center><input type='button' value='cancel' onclick='closeWait();'></center>";
	txt += "</div>";
	showWait(txt);
}

function doUpload() {
	el = document.getElementById("uploadStatus"); el.style.display = 'inline';
	el = document.getElementById("frmUpload");
	el.submit();

}

function completeUpload(param) {
	alert('a');
	closeWait();
	postUpload(param);
}

function uploadFailed(param) {
	el = document.getElementById("uploadStatus"); el.innerHTML = "Upload failed!!!";
}

function message2(msg, wdth) {
	txt = "";
	if (wdth)
	{
		txt = " width: " + wdth + "px;";
	}
	showOverlay();
	box("<div class='msgalert' style='"+txt+"; border: 5px solid #eee; padding: 0px;'>" +'<div class="login-close" style="position: absolute; right: 10px; top: 2px;;"> <a href="#"><img src="images/icon_delte_over.gif" alt="close" name="closepop" width="21" height="21" border="0" id="closepop" onmouseover="MM_swapImage(\'closepop\',\'\',\'images/icon_delte_up.gif\',1)" onmouseout="MM_swapImgRestore()" onclick="closeWait()" /></a></div>'+ "<div style=' text-align: center; line-height: 150%;'><b>"+msg+"</b></div></div>");
}

function box(msg, wdth) {
	txt = "";
	if (wdth)
	{
		txt = " width: " + wdth + "px;";
	}
	dv = document.getElementById(messageid);
	if (!dv)
	{
		dv = document.createElement("div");

		dv.style.position = "absolute";
		dv.style.display = "block";
		dv.innerHTML = msg;
		opacity(dv, 0);
		dv.style.top = "0px";
		dv.style.left = "0px";
		dv.style.backgroundColor = "#ffffff";
		dv.style.color = "#444444";
		dv.style.zIndex = overlayZ + 1;	
		dv.style.borderWidth = "0px";	
		dv.style.borderStyle = "solid";	
		dv.style.borderColor = "#bfbfbf";	
		dv.style.padding = "0px";
		dv.id = messageid;
		document.body.appendChild(dv);
	} else  {
		dv.innerHTML = msg;
		dv.style.display = "block";
	}
	w = dv.offsetWidth; //if (parseInt(w) == 0) w = 600;
	h = dv.offsetHeight; //if (parseInt(h) == 0) h = 400;
	c = getCenter(w, h);
	dv.style.left = c.x + "px";
	dv.style.top = c.y + "px";
	opacity(dv, 100);

}
