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
	try
	{
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
	catch (ex)
	{
		;
	}
	
}
	function getXMLNode(x, nodeIndex) {
	if (!nodeIndex) nodeIndex = 0
	try
	{
		if (BrowserDetect.browser == "Firefox") {
			ret = x[nodeIndex].textContent;
			return ret;
		} else {
			ret =x[nodeIndex].firstChild.data;
			return ret;
		}
	}
	catch (ex)
	{
		return "";
	}

}

