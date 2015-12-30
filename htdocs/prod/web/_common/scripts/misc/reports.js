function updateDateRange() {
	el1 = document.getElementById('fromDate');
	el2 = document.getElementById('toDate');
	dv =  document.getElementById('mainStatsTable');
	dv.innerHTML = "<img src='_common/images/ajax/progressbar_microsoft.gif'>";

	url = "index2.php?n=Reports&o=update_stats&fromDate=" + el1.value + "&toDate=" + el2.value;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_updateDateRange;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}

function _updateDateRange() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;
	x=response.getElementsByTagName("content");
	y= x[0].firstChild.data;
	el = document.getElementById("mainStatsTable");
	el.innerHTML = y;
  }
}

function plotChart(reportType) {
	el1 = document.getElementById('fromDate');
	el2 = document.getElementById('toDate');
	dv =  document.getElementById('mainStatsTableChart');
	dv.innerHTML = "<img src='_common/images/ajax/progressbar_microsoft.gif'>";

	url = "index2.php?n=Reports&o=view_chart&type="+reportType+"&fromDate=" + el1.value + "&toDate=" + el2.value;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_plotChart;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}


function _plotChart() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;
	x=response.getElementsByTagName("content");
	y= x[0].firstChild.data;
	el = document.getElementById("mainStatsTableChart");
	el.innerHTML = y;
  }
}

function viewUsers() {
	el1 = document.getElementById('fromDate');
	el2 = document.getElementById('toDate');
	dv =  document.getElementById('mainStatsTable');
	dv.innerHTML = "<img src='_common/images/ajax/progressbar_microsoft.gif'>";

	url = "index2.php?n=Reports&o=view_users&fromDate=" + el1.value + "&toDate=" + el2.value;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_viewUsers;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}

function _viewUsers() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;
	x=response.getElementsByTagName("content");
	y= x[0].firstChild.data;
	el = document.getElementById("mainStatsTable");
	el.innerHTML = y;
  }
}
