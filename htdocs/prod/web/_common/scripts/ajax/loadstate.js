function loadStates(pCountry) {
	
	url = "index.php?n=Ajax&o=getStates&id=" + pCountry;
	el = document.getElementById('StateID');
	el.options.length= 0;
	option = new Option();
	option.text = ' loading, please wait .... ';
	option.value = 0;
	el.options[0] = option;

	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	// code for IE
	else if (window.ActiveXObject)
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	if (xmlhttp!=null)
	  {
	  xmlhttp.onreadystatechange=_loadStates;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	  }
	else
	  {
	  alert("Your browser does not support XMLHTTP.");
	  }


}

function _loadStates() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;
	x1=response.getElementsByTagName("id");
	x2=response.getElementsByTagName("name");
	el = document.getElementById('StateID');
	
	el.options.length = 0;
	for (i=0;i<x1.length ;i++ )
	{
		option = new Option();
		option.text = x2[i].firstChild.data;
		option.value = x1[i].firstChild.data;
		el.options[el.options.length] = option;
	}

  }
 }