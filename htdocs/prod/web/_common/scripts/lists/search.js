function suggestOptions() {

	el = document.getElementById("srcText");	
	el2 = document.getElementById("divAuto");	

	qry = el.value;
	if (qry)
	{
		el2.style.position = "absolute";
		el2.style.top = findPosY	 (el) + 21;
		el2.style.left = findPosX(el);
		el2.style.display = "block";
		el2.innerHTML = "<center><img style='margin-top: 150px; margin-left: 150px; margin-right: 150px;' src='_common/images/ajax/indicator_snake.gif' border='0'></center>";
		el.readonly = true;

		url = "index.php?n=Files&o=suggest&query="+qry;
		
		initObj();
		if (xmlhttp!=null) {
			  xmlhttp.onreadystatechange=doSuggestOptions;
			  xmlhttp.open("GET",url,true);
			  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
			  xmlhttp.send(null);
		}
	} else {
		el2.style.display = "none";
	}
}

function doSuggestOptions() {
	if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("id");
		z=response.getElementsByTagName("name");
		el = document.getElementById("divAuto");	
		txt = "<table cellpadding='0' cellspacing='0' border='0' style='height: 320px; width: 300px; margin-top: 40px; margin-bottom: 10px; margin-left: 14px; margin-right: 26px; '>";
		for (i=0; i<x.length ; i++)
		{
			if (i >= 10) break;
			y1= x[i].firstChild.data;
			y2= z[i].firstChild.data;
//			txt = txt + "<tr onclick=\"el=document.getElementById('srcText'); el.value='" + y + "';el2=document.getElementById('divAuto');el2.style.display='none';\" onmouseover=\"this.style.backgroundColor='#fff';\"onmouseout=\"this.style.backgroundColor='#f0f0f0'; \"><td width='220' align='left' class='small_txt'>" + y + "</td><td width='80' align='right' class='small_txt'>" + "12 results" + "</td></tr>";
			txt = txt + "<tr><td align='left' class='small_txt' style='height: 20px;'><a href='index.php?n=Files&o=view&id="+y1+"'>" + y2 + "</a></td></tr>";
		}
		txt = txt + "<tr><td align='left' class='small_txt' style='height: " + (320 - i*25) + "px;'>&nbsp;</td></tr>";
		txt = txt + "</table>";
		el.innerHTML = txt;
		el = document.getElementById("srcText");	
		el.readonly = false;	
		el.focus();
	}
}

function selectEntry() {

}

function closeSuggest() {
	el2 = document.getElementById("divAuto");	
	el2.style.display = "none";
}