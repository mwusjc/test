var xmlhttp;

function checkReadyState(obj)
{
  if(obj.readyState == 4)
  {
    if(obj.status == 200)
    {
      return true;
    }
    else
    {
//      alert("Problem retrieving XML data");
	  return true;
    }
  }
}

function initObj() {
	xmlhttp = null;
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
		;
	  }
	else
	  {
	  alert("Your browser does not support XMLHTTP.");
	  }
}



function getXMLNode(x) {
	if (BrowserDetect.browser == "Firefox") {
		return x[0].textContent;
	} else {
		return x[0].firstChild.data;
	}

}

