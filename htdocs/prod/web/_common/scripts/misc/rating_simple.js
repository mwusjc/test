var imgAry = new Array();
var stars = new Array("../images/icons/small/staroff.gif","../images/icons/small/staron.gif");

function preLoadImg(obj) {
	for(i=0;i<obj.length;i++) {
		imgAry[i]=new Image(); 
		imgAry[i].src=obj[i];
	}
}

preLoadImg(stars);

function rateMouse(fldName, rateIndex) {
	for(var i=0; i<5; i++) {
		img = document.getElementById('rateimg' + fldName + i);
		if(i <= rateIndex) {
			img.src = imgAry[1].src;
		} else {
			img.src =  imgAry[0].src;
		}
	}
	x = 0;

	for(var i=0; i<5; i++) {
		img = document.getElementById('rateimg' + fldName + i);
		if (img.src == 'http://www.cgrecu.com/images/icons/small/staron.gif' || img.src == 'http://cgrecu.com/images/icons/small/staron.gif' ) x = x +1;
	}
	el=document.getElementById('rat' + fldName);
	el.value = x;
}
