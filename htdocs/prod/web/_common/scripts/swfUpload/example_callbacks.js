var button_used = 0;
var queue_history = [];
var uploadSessionID;

function preparePage() {
	el=document.getElementById("myBtnUpload");
	el.style.display = "none";

}

function checkFileType() {
	for (i=0; i<queue_history.length; i++)
	{
		if (queue_history[i][2] == button_used)
		{
			return false;
		}
	}
	return true;
}

function getQueuePos(id) {
	for (i=0; i<queue_history.length; i++)
	{
		if (queue_history[i][1] == id)
		{
			return i;
		}
	}
	return -1;
}


function fileQueued(file, queuelength) {
	if (file.size <= 100000)
	{
		showAlert("error", "Invalid size", "To maintain the quality standards, the minimum filesize allowed for upload is 100Kb", btClose,0);
	}
	queue_history[queue_history.length] = [file.name, file.id, button_used];
	var table = document.getElementById("uploadTable");
	table.style.display = "block";

	var row = document.createElement("tr");
	row.id = file.id;

	cell = document.createElement("td");
	if (button_used == 1) ftype = " (main file)";
	if (button_used == 2) ftype = " (thumbnail)";
	cell.appendChild (document.createTextNode(file.name + ftype));
	cell.style.width="332px";
	cell.className = "text1";
	cell.id = file.id + "left";
	row.appendChild(cell);

	cell = document.createElement("td");
	cell.innerHTML = '<a href="#self" onclick="swfu.cancelFile(\''+file.id+'\')"><img src="_common/images/upload/remove_icon.gif" border="0"></a>';
	cell.style.width="78px";
	cell.className = "text2";
	cell.id = file.id + "right";
	row.appendChild(cell);

	table.appendChild(row);
	el=document.getElementById("myBtnUpload");
	el.style.display = "block";
	
}

function positionUploadBut() {
	el =document.getElementById(swfu.movieName + "UploadBtn");
	el2 = document.getElementById("uploadButHolder");

	el.style.position = 'absolute';
	el.style.display = 'block';
	el.style.zIndex = 15;
	el.style.top = findPosY(el2) + 14;
	el.style.left = findPosX(el2) - 14;
}

function uploadFileCancelled(file, queuelength) {
	tmp = [];
	for (i=0; i< queue_history.length; i++)
	{
		if (queue_history[i][1] != file.id)
		{
			tmp[tmp.length] = queue_history[i];
		}
		queue_history = tmp;
	}
	
	if (queue_history.length == 0)
	{
		el=document.getElementById("myBtnUpload");
		el.style.display = "none";
	}

	el = document.getElementById(file.id);
	el.style.display="none";
	positionUploadBut();

}

function uploadFileStart(file, position, queuelength) {
	keyid = queue_history[getQueuePos(file.id)][2];
	el1=document.getElementById("alertBar" + keyid);
	el2=document.getElementById("progbar" + keyid);
	el3=document.getElementById("statusPerc" + keyid);
	el3.style.left = (findPosX(el2) + 65) + "px";
	el3.style.top= (findPosY(el2) + 4) + "px";
	el3.style.display="inline";
	
	el=document.getElementById("alertBarRow" + keyid);
	el.style.visibility = "visible";

//	el=document.getElementById("frmEdit");
////	el.style.mozOpacity=0.1;
////	el.style.opacity=0.1;
//
////	alert(el.offsetHeight + "x" +el.offsetWidth +"px\nposX: " + findPosX(el));
//	div = document.getElementById("divCover");
//	div.style.position = "absolute";
//	div.style.display = "block";
//	div.style.mozOpacity=0.05;
//	div.style.opacity=0.05;
//	div.style.filter="alpha(opacity=15)";
//	div.style.zIndex=100;
//	div.style.backgroundColor = "#000000";
//	div.style.width = el.offsetWidth + "px";
//	div.style.height = el.offsetHeight + "px" ;
//	div.style.left = findPosX(el) + "px";
//	div.style.top = findPosY(el) + "px";
//
//	el = document.getElementById(file.id + "right");
//	el.innerHTML = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"72\"><tr><td id=\""+file.id+"progress2\" style=\"float:left; width: 60px; height: 10px; font-size: 1px; padding: 0px; text-align: left; background-color: #ccc;\"><div id=\""+file.id+"progress\" style=\"background-color: #cc3300; color: #fff; width:1px; font-size: 9px; height: 10px; text-align: center;\">&nbsp;</div></td><td id=\""+file.id+"progress3\" style=\"width: 12px; font-size: 7px; color: #000;\"></td></tr>";
//
//	el = document.getElementById("imgright");
//	el.src="_common/images/upload/uploading_txt.gif";
//
//	el = document.getElementById("imgleft");
//	el.src="_common/images/upload/abode_uploading_icon.gif";
//
}

function showImageAjax() {

	el1=document.getElementById("mainStatusBody");
	el1.innerHTML = "<img src='images/loading.gif'>";
	el1=document.getElementById("statusTitle");
	el1.innerHTML = "completing upload ... <br><br><br>";

	el3=document.getElementById("statusPerc1");
	el3.style.display="none";
	el3=document.getElementById("statusPerc2");
	el3.style.display="none";

//	div = document.getElementById("imgAjax");
//	div.style.display = "block";
//	el=document.getElementById("frmEdit");
//	div.style.zIndex=110;
//	div.style.left = findPosX(el) + (el.offsetWidth - 85)/2 + "px";
//	div.style.top = findPosY(el) + (el.offsetHeight - 85)/2 + "px";
}

function uploadProgress(file, bytesLoaded) {
	keyid = queue_history[getQueuePos(file.id)][2];
	el1=document.getElementById("alertBar" + keyid);
	el2=document.getElementById("progbar" + keyid);
	el3=document.getElementById("statusPerc" + keyid);

	var percent = Math.ceil((bytesLoaded / file.size) * 200)

	el2.style.width =  percent + "px";
	if (keyid == 1)
	{
		el3.innerHTML = "image - ";
	} else {
		el3.innerHTML = "thumbnail - ";
	}
	el3.innerHTML += Math.ceil((percent /200) * 100) + "%";
//	var progress = document.getElementById(file.id + "progress");
//	var progress3 = document.getElementById(file.id + "progress3");
//	var percent = Math.ceil((bytesLoaded / file.size) * 60)
////	progress.style.width = "#f0f0f0 url(progressbar.png) no-repeat -" + (200 - percent) + "px 0";
//	
//	//60 steps
//	if (percent >= 58) {
////		progress.innerHTML = "finalizing ...";
//		progress.style.width = percent + "px";
//		progress3.innerHTML = Math.ceil((percent /60) * 100) + "%";
//	} else {
//		progress.style.width = percent + "px";
//		progress3.innerHTML = Math.ceil((percent /60) * 100) + "%";
//	}
//	if (percent == 60)
//	{
//		progress3.style.innerHTML = "";
//		progress3.style.width= "1px";
//	}
}

function uploadError(errno) {
}

function uploadFileComplete(file) {
}


function completeUpload() {
	showImageAjax();

	el=document.getElementById("Price");
	price = parseFloat(el.value);
	el=document.frmEdit.Keywords;
	keys = encodeURIComponent(el.value);
	for (i=0; i<document.frmEdit.CategoryID.length; i++)
	{
		if (document.frmEdit.CategoryID[i].checked) catid = document.frmEdit.CategoryID[i].value;
	}
	url = "index.php?n=Files&o=smartsave&CategoryID=" +catid + "&Keywords=" + keys + "&Price=" + price;
	for (i=0; i<queue_history.length; i++)
	{
		url += "&file" + i + "=" + queue_history[i][0] + "&filetype" + i + "=" + queue_history[i][2];
	}
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_completeUpload;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
}

function _completeUpload() {
  if(checkReadyState(xmlhttp)) {
//  	div = document.getElementById("imgAjax");
//	div.style.display = "none";
	el = document.getElementById("uploadStatus");
	el.style.display = "none";

	var response = xmlhttp.responseXML.documentElement;
	response.normalize;
	x=response.getElementsByTagName("content");
	y= x[0].firstChild.data;
	if (y == "ok")
	{
		//clean up

		for (i=0; i< queue_history.length ; i++)
		{
			el = document.getElementById(queue_history[i][1]);
			el.style.display= "none";
			el = document.getElementById(queue_history[i][1] + "right");
			el.innerHTML = "<img src=\"_common/images/upload/status_ok_icon.gif\">";
		}
		queue_history.length = 0;
		var table = document.getElementById("uploadTable");
		table.style.display= "none";

		div = document.getElementById("divCover");
		div.style.display = "none";
	}
	document.frmEdit.Keywords.value = "";
	document.frmEdit.Price.value = "";
	div = document.getElementById("divCover");
	div.style.display="none";
	showAlert("info", "Upload complete", "Upload completed successfully, you can upload another file or go to your account", btClose, btAccount);
  }
}


function cancelQueue() {
	swfu.cancelQueue();
	closeStatus();
}

function uploadQueueComplete(file) {
	completeUpload();
}

function startUpload() {
	div = document.getElementById("divCover");
	div.style.display="block";
	div.style.top="0px";
	div.style.left="0px";
	div.style.filter="alpha(opacity=80)";
	div.style.mozOpacity=0.80;
	div.style.opacity=0.80;
	div.style.backgroundColor = "#ffffff";
	div.style.zIndex=1;
	div.style.height = "1000px";
	div.style.width = "1000px";

	tmp = parseInt(getScrollLength("top"));
	tmp = tmp + 1000;
	div.style.height = tmp + "px";
	tmp = parseInt(getScrollLength("left"));
	tmp = tmp + parseInt(document.documentElement.clientWidth);
	div.style.width= tmp + "px";

	
	el = document.getElementById("uploadStatus");
	c = getCenter(150, 100);
	el.style.top = c.y + "px"; 
	el.style.left = c.x  + "px"; 
	el.style.display= "block";
	el.style.zIndex = 10;

	txt = '<table width="220" height="20" cellspacing="10"><tr id="alertBarRow1" style="visibility: hidden;"><td id="alertBar1" style="border: 1px solid #e0e0e0; height: 20px; width: 200px; padding: 0px; text-align: left; color: #000; "><div id="progbar1" style="width: 0px; background-color: #ff6001; height: 20px; color: #000; "></div></td></tr><tr id="alertBarRow2" style="visibility: hidden;"><td id="alertBar2" style="border: 1px solid #e0e0e0; height: 20px; width: 200px; padding: 0px; text-align: left;"><div id="progbar2" style="width: 0px; background-color: #ff6001; height: 20px; "></div></td></tr></table>';

	el1=document.getElementById("mainStatusBody");
	el1.innerHTML = txt;
	el1=document.getElementById("statusTitle");
	el1.innerHTML = "uploading file(s) ... ";


}

function closeStatus() {
	el = document.getElementById("uploadStatus");
	el.style.display= "none";
}