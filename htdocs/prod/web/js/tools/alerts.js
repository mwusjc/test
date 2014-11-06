function error(txt) {
	Shadowbox.open({
        content:    txt,
        player:     "html",
        title:      "",
        height:     "auto",
        width:      "auto"
    });
	$("#sb-wrapper").css("background-color" , "#cc6633");
	$("#sb-wrapper").css("opacity" , "0.9");
	$("#sb-title").css("height" , "0");
	$("#sb-body-inner").css("text-align" , "center");
}

function alert2(txt) {
	Shadowbox.open({
        content:    txt,
        player:     "html",
        title:      "",
        height:     "250",
        width:      "auto"
    });
	$("#sb-wrapper").css("background-color" , "#e5edf4");
	$("#sb-wrapper").css("opacity" , "0.9");
	$("#sb-title").css("height" , "0");

}



function alert3(page) {
	url = "index.php?o=ajax&page=" + page;
	initObj();
	if (xmlhttp!=null) {
	  xmlhttp.onreadystatechange=_alert3;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
	  xmlhttp.send(null);
	}

}

function message(txt, w, h) {
	Shadowbox.open({
        content:    txt,
        player:     "html",
        title:      "",
        height:     h,
        width:      w
    });
	$("#sb-wrapper").css("background-color" , "#e5edf4");
	$("#sb-wrapper").css("opacity" , "0.9");
	$("#sb-wrapper-inner").css("overflow" , "hidden");
	$("#sb-body").css("overflow" , "hidden");
	$("#sb-body-inner").css("overflow" , "hidden");
	$("#sb-title").css("height" , "0");

}

function messageEditable(txt, w, h) {
	Shadowbox.open({
        content:    txt,
        player:     "html",
        title:      "",
        height:     h,
        width:      w,
		options: {enableKeys: false }
    });
	$("#sb-wrapper").css("background-color" , "#e5edf4");
	$("#sb-wrapper").css("opacity" , "0.9");
//	$("#sb-wrapper-inner").css("overflow" , "auto");
//	$("#sb-body").css("overflow" , "auto");
//	$("#sb-body-inner").css("overflow" , "auto");
	$("#sb-title").css("height" , "0");

}


function _alert3() {
	if(checkReadyState(xmlhttp)) {
	Shadowbox.open({
        content:    xmlhttp.responseText,
        player:     "html",
        title:      "",
        height:     "600",
        width:      "800"
    });
	$("#sb-wrapper").css("background-color" , "#e5edf4");
	$("#sb-wrapper").css("opacity" , "0.9");
	$("#sb-title").css("height" , "0");
	}
	

}