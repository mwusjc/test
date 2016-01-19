function frmLogin_validate() {
	el1 = document.getElementById('Username');
	el2 = document.getElementById('Password');
	if (el1.value == '' || el2.value == '')
	{
		message("Please enter your username and password!");
		return false;
	}

	url = "index2.php?n=Users&o=doajaxlogin&username="+ el1.value + "&password=" + md5(el2.value);
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_frmLogin_validate;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}

function _frmLogin_validate() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;

	x=response.getElementsByTagName("login_error");
	try
	{
		err = x[0].firstChild.data;
	}
	catch (ex)
	{
		err = "";
	}
	if (err != "" && err != "&nbsp;")
	{
		message(err);
//		el1 = document.getElementById('Username'); el1.value = "";
		el2 = document.getElementById('Password'); el2.value = "";
		return false;
	} else {
		x=response.getElementsByTagName("postlogin_url");
		url = x[0].firstChild.data;
		window.location = url;
	}	
  }
}

function showForgot(err) {
	setOpacity(10) ;
	id = createAlert("divForgot", "Retrieve Password");
	el = document.getElementById(id);
	txt = "";
	if (err != '')
	{
		txt += "<p style='color: #ff3300; font-weight: bold;'>" + err + "</p>";
	}
	txt += "<p style='width: 250px;'>Please enter your email address in the field below and hit the retrieve button. If your email is found in the database, your password will be emailed to you.</p>";
	txt += "Email address: <input type='text' name='txtEmail' id='txtEmail' value=''> <input type='button' value='retrieve' onclick='sendPassword();'>";
	el.innerHTML = txt;
	centerElement("divForgot");
}

function sendPassword() {
	el=document.getElementById("txtEmail");
	url = "index2.php?n=Users&o=send_password&email=" + encodeURI(el.value);
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_sendPassword;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
}

function _sendPassword() {
  if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;

		x=response.getElementsByTagName("result");
		res = getXMLNode(x);
		closeAlert("divForgot");
		if (res == "ok")
		{
			setOpacity(10) ;
			id = createAlert("divForgotConfirmation", "Retrieve Password");
			el = document.getElementById(id);
			el.innerHTML = "<center>Your password has been emailed to you</center>";
			centerElement("divForgotConfirmation");
		} else {
			showForgot("Email not found");
		}
  }
}

function frmDLogin_validate() {
	el1 = document.getElementById('Username');
	el2 = document.getElementById('Password');
	if (el1.value == '' || el2.value == '')
	{
		alert("Please enter your username and password!");
		return false;
	}

	url = "index.php?n=distributor&o=doajaxlogin&username="+ el1.value + "&password=" + md5(el2.value);
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_frmDLogin_validate;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}

function _frmDLogin_validate() {
  if(checkReadyState(xmlhttp)) {
	var response = xmlhttp.responseXML.documentElement;
	response.normalize;

	x=response.getElementsByTagName("login_error");
	try
	{
		err = x[0].firstChild.data;
	}
	catch (ex)
	{
		err = "";
	}
	if (err != "" && err != "&nbsp;")
	{
		alert(err);
//		el1 = document.getElementById('Username'); el1.value = "";
		el2 = document.getElementById('Password'); el2.value = "";
		return false;
	} else {
		x=response.getElementsByTagName("postlogin_url");
		url = x[0].firstChild.data;
		window.location = url;
	}	
  }
}

function frmSLogin_validate() {
	el1 = document.getElementById('Username');
	el2 = document.getElementById('Password');
	if (el1.value == '' || el2.value == '')
	{
		alert("Please enter your username and password!");
		return false;
	}

	url = "index.php?n=staff&o=doajaxlogin&username="+ el1.value + "&password=" + md5(el2.value);
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_frmLogin_validate;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}
	return false;
}

