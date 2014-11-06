var RSLite;
var curRating = new Array();
function RSLiteObject(){
	this.interval = 500;
	this.attempts = 3;
	this.call = function (page){
		var i = new Image();
		var d = new Date();
		document.cookie = 'RSLite=x; expires=Fri, 31 Dec 1999 23:59:59 GMT;';
		i.src = page;
		setTimeout( "RSLite.receive(1);", this.interval );
	}  
	this.receive = function ( attempt ){  
		var response = null;
		var aCookie = document.cookie.split("; ");
		for (var i=0; i < aCookie.length; i++){
			var aCrumb = aCookie[i].split("=");
			if (aCrumb[0] == 'RSLite') response = aCrumb[1];
		}
		if ( response != null ){
			this.callback( unescape(response.replace(/\+/g,' ')) );
		} else {
			if (attempt < this.attempts){
				setTimeout( "RSLite.receive( " + (attempt+1) +" );",this.interval);
			} else { this.failure(); }
		}    
	}
	this.callback = function( response ){ alert(response); }
	this.failure = function(){ 
		// alert( "Timed Out"); // disable for the time moment
	}
}

function myCallback(response) {
	//alert(response);
	// write the result back
	var tmpObj = document.getElementById('ResponseArea');
	if (tmpObj != null) {
		tmpObj.innerHTML = response;
	} // if
}

RSLite = new RSLiteObject();
RSLite.callback = myCallback;
      
var imgAry = new Array();
var stars = new Array("images/rate/staroff.gif","images/rate/staron.gif");

function preLoadImg(obj) {
	for(i=0;i<obj.length;i++) {
		imgAry[i]=new Image(); imgAry[i].src=obj[i];
	}
}

preLoadImg(stars);

// mouse-event related code
function rate(rateIndex,ContentSection,ContentID) {
	var newR = parseInt(rateIndex.substr(rateIndex.length - 1, 1));
	var b = rateIndex.substr(0,rateIndex.length - 1);
	curRating[b] = newR;
	var query = "index.php?name="+ContentSection+"&op=rate&id="+ContentID+"&Rating="+newR;
	RSLite.call(query);
}

function ratehidden(rateIndex,ContentSection,ContentID) {
	var newR = parseInt(rateIndex.substr(rateIndex.length - 1, 1));
	var b = rateIndex.substr(0,rateIndex.length - 1);
	curRating[b] = newR;
	varHidden = document.getElementById(ContentID);
	varHidden.value = newR;
}

function rateMouseOut(rateIndex) {
	var b = rateIndex.substr(0,rateIndex.length - 1);
	var n = (curRating[b] == null)?0:curRating[b]; 
	for(var i=1; i<=5; i++) {
		if(i <= n) document.getElementById(b+i).src = imgAry[1].src;
		else document.getElementById(b+i).src = imgAry[0].src;
	}
}
function rateMouseOver(rateIndex) {

	var n = parseInt(rateIndex.substr(rateIndex.length - 1, 1));
	var b = rateIndex.substr(0,rateIndex.length - 1);
	for(var i=1; i<=5; i++) {
		if(i <= n) document.getElementById(b+i).src = imgAry[1].src;
		else document.getElementById(b+i).src = imgAry[0].src;
	}
}