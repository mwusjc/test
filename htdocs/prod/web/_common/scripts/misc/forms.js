validationErrors = [];
function formFailValidation() {
	if (validationErrors.length)
	{
		msg = "The following errors must be corrected: <br><br>";
		for (i=0; i<validationErrors.length; i++)
		{
			msg += "<li>" + validationErrors[i];// + "</li>";
		}
		showAlert("error", "", msg, 0, btClose);
	}
	validationErrors = [];
}

function failValidation(el, msg) {
	el.select();
	el.focus();
	el.style.backgroundColor = '#ff5f00';
//	if (msg) alert(msg);
//	el=document.getElementById("ERROR_AREA");
//	el.innerHTML = el.innerHTML + "<br>" + msg;
	validationErrors[validationErrors.length] = msg;
	//showAlert("error", "", msg, 0, btClose);
}

function failRadioValidation(el, idx, msg) {
	el[idx].checked = true;
	el.select();
	el.style.backgroundColor = '#ff5f00';
//	showAlert("error", "", msg, 0, btClose);
validationErrors[validationErrors.length] = msg;
//	if (msg) alert(msg);
}

function failListValidation(el, msg) {
//	el.select();
	el.focus();
	el.style.backgroundColor = '#ff5f00';
//	if (msg) alert(msg);
//	el=document.getElementById("ERROR_AREA");
//	el.innerHTML = el.innerHTML + "<br>" + msg;
//	showAlert("error", "", msg, 0, btClose);
validationErrors[validationErrors.length] = msg;
}


function checkEmail(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    return false
		 }

 		 return true					
	}
	
	var _email= "";
	function verifyEmail(obj) {
		if (!obj.value) return true;
		if (!checkEmail(obj.value))
		{
			obj.style.backgroundColor = "#FFF1EA";
			obj.style.borderStyle = "solid";
			obj.style.borderWidth = "2px";
			obj.style.borderColor = "#ff5f00";
			obj.select();
			obj.focus();
			showAlert("error", "", "Invalid email address!", 0, btClose);
		} else {
			_email = obj;
			url = "index.php?n=Ajax&o=checkEmail&name=" + encodeURIComponent(obj.value);
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
			  xmlhttp.onreadystatechange=_verifyEmail;
			  xmlhttp.open("GET",url,true);
			  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
			  xmlhttp.send(null);
			  }
			else
			  {
			  alert("Your browser does not support XMLHTTP.");
			  }

//			obj.style.backgroundColor = "#fff";
//			obj.style.borderStyle = "solid";
//			obj.style.borderWidth = "2px";
//			obj.style.borderColor = "#aaa";
		}
	}

	function _verifyEmail() {
	  if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("content");
		y= x[0].firstChild.data;
		if (y!="ok")
		{
			_email.style.backgroundColor = "#FFF1EA";
			_email.style.borderStyle = "solid";
			_email.style.borderWidth = "2px";
			_email.style.borderColor = "#ff5f00";
			_email.select();
//			_username.focus();
			_email.value="";
			showAlert("error", "", y, 0, btClose);
		} else {
			_email.style.backgroundColor = "#fff";
			_email.style.borderStyle = "solid";
			_email.style.borderWidth = "2px";
			_email.style.borderColor = "#aaa";
		}
		_username = "";
	  }
	}
	var _username = "";
	function verifyUsername(obj) {
		_username = obj;
		if (!obj.value) return true;
		url = "index.php?n=Ajax&o=checkName&name=" + encodeURIComponent(obj.value);
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
		  xmlhttp.onreadystatechange=_verifyUsername;
		  xmlhttp.open("GET",url,true);
		  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
		  xmlhttp.send(null);
		  }
		else
		  {
		  alert("Your browser does not support XMLHTTP.");
		  }
		
	}

	function _verifyUsername() {
	  if(checkReadyState(xmlhttp)) {
		var response = xmlhttp.responseXML.documentElement;
		response.normalize;
		x=response.getElementsByTagName("content");
		y= x[0].firstChild.data;
		if (y!="ok")
		{
			_username.style.backgroundColor = "#FFF1EA";
			_username.style.borderStyle = "solid";
			_username.style.borderWidth = "2px";
			_username.style.borderColor = "#ff5f00";
			_username.select();
//			_username.focus();
			_username.value="";
			showAlert("error", "", y, 0, btClose);
		} else {
			_username.style.backgroundColor = "#fff";
			_username.style.borderStyle = "solid";
			_username.style.borderWidth = "2px";
			_username.style.borderColor = "#aaa";
		}
		_username = "";
	  }
	}

	function verifyPassword() {
		el1 = document.getElementById("Password");
		el2 = document.getElementById("Password2");
		if ((el1.value && el2.value && el1.value != el2.value))
		{
			showAlert("error", "", "Passwords don't match!", 0, btClose);
			el1.style.backgroundColor = "#FFF1EA";
			el1.style.borderStyle = "solid";
			el1.style.borderWidth = "2px";
			el1.style.borderColor = "#ff5f00";
			el2.style.backgroundColor = "#FFF1EA";
			el2.style.borderStyle = "solid";
			el2.style.borderWidth = "2px";
			el2.style.borderColor = "#ff5f00";
			el2.value = "";
		} 
		if (el1.value && el2.value && el1.value == el2.value)
		{
			ret = passwordOk(el1.value);
			if (ret)
			{
				showAlert("error", "", ret, 0, btClose);
				el1.style.backgroundColor = "#FFF1EA";
				el1.style.borderStyle = "solid";
				el1.style.borderWidth = "2px";
				el1.style.borderColor = "#ff5f00";
				el2.style.backgroundColor = "#FFF1EA";
				el2.style.borderStyle = "solid";
				el2.style.borderWidth = "2px";
				el2.style.borderColor = "#ff5f00";
				el2.value = "";
			} else {
				el1.style.backgroundColor = "#fff";
				el1.style.borderStyle = "solid";
				el1.style.borderWidth = "2px";
				el1.style.borderColor = "#aaa";
				el2.style.backgroundColor = "#fff";
				el2.style.borderStyle = "solid";
				el2.style.borderWidth = "2px";
				el2.style.borderColor = "#aaa";
			}
		}
	}

	function passwordOk(str) {
		if (str.length < 6)
		{
			return "Password must be at least 6 characters";
		}
	}


function getForm(fobj) {
var str = "";
var ft = "";
var fv = "";
var fn = "";
var els = "";
for(var i = 0; i < fobj.elements.length; i++) {
	els = fobj.elements[i];
	ft = els.title;
	fv = els.value;
	fn = els.name;
	
	reqFlag = false;
	if (els.title != "") {
		msg = els.title.split("_");
		if (msg[0] == "required")
		{
			reqFlag = true;
		}
	}
	switch(els.type) {
		 case "text":
		 case "hidden":
		 case "password":
		 case "textarea":
		 // is it a required field?
		   if (els.title && reqFlag && fv == "")
		   {
			   alert("Please fill up all required fields! The following field requres a value: " + els.name);
			   return "error";
		   }
		  str += fn + "=" + encodeURIComponent(fv) + "&";
		  break;

		  case "checkbox":
		  case "radio":
			   if (els.type == "checkbox" && els.title && reqFlag &&  !els.checked )
			   {
				   alert("Please fill up all required fields!" + els.name);
				   return "error";
			   }

		if(els.checked) str += fn + "=" + encodeURIComponent(fv) + "&";
		  break;


		  case "select-one":
			   if (els.title && reqFlag &&  els.selectedIndex == 0)
			   {
				   alert("Please fill up all required fields!" + els.name);
				   return "error";
			   }

		 str += fn + "=" +

		 els.options[els.selectedIndex].value + "&";
		  break;
		  } // switch
	 } // for
	 str = str.substr(0,(str.length - 1));
	 return str;
}

function validate(fobj) {
                var str = "";
                var ft = "";
                var fv = "";
                var fn = "";
                var els = "";
                for(var i = 0; i < fobj.elements.length; i++) {
                                els = fobj.elements[i];
                                ft = els.title;
                                fv = els.value;
                                fn = els.name;
                                
                                reqFlag = false;
                                if (els.title != "") {
                                                msg = els.title.split("_");
                                                if (msg[0] == "required")
                                                {
                                                                reqFlag = true;
                                                }
                                }
                                switch(els.type) {
                                                 case "text":
                                                 case "hidden":
                                                 case "password":
                                                 case "textarea":
                                                 // is it a required field?
                                                   if (els.title && reqFlag && fv == "")
                                                   {
                                                                                els.style.backgroundColor = "#FF9966";
                                                                   alert("Please fill up all required fields! \n\nThe following field requres a value: " + msg[1].replace("+", " "));
                                                                   return false;
                                                   }
                                                  str += fn + "=" + encodeURIComponent(fv) + "&";
                                                  break;

                                                  case "checkbox":
                                                  case "radio":
                                                                   if (els.type == "checkbox" && els.title && reqFlag &&  !els.checked )
                                                                   {
                                                                                  els.style.backgroundColor = "#FF9966";
                                                                                   alert("Please fill up all required fields! \n\nThe following field requres a value: " + msg[1].replace("+", " "));
                                                                                   return false;
                                                                   }

                                                if(els.checked) str += fn + "=" + encodeURIComponent(fv) + "&";
                                                  break;


                                                  case "select-one":
                                                                   if (els.title && reqFlag &&  els.selectedIndex == 0)
                                                                   {
                                                                                                els.style.backgroundColor = "#FF9966";
                                                                                   alert("Please fill up all required fields! \n\nThe following field requres a value: " + msg[1].replace("+", " "));
                                                                                   return false;
                                                                   }

                                                 str += fn + "=" +

                                                 els.options[els.selectedIndex].value + "&";
                                                  break;
                                                  } // switch
                                 } // for
                                 str = str.substr(0,(str.length - 1));
                                 return str;
}
