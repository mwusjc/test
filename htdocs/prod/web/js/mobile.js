
var sliderLeft = 0;
var sliderCount = 4;
var slideInterval;
var slideTimer = 150;
var slideDirection = 0;
var slideStep = 0;
var slideSteps = 0;
var stepDuration = 10;
var slideLength = 0; //pixels
function slideLeft() {
	if (sliderLeft>=-100) return false;
	slideDirection = 1;
	slideSteps = slideTimer/stepDuration;
	slideInterval = setInterval(slide, stepDuration);
}

function slideRight() {
	slideDirection = -1;
	if (sliderLeft <= slideLength) return false;
	slideSteps = slideTimer/stepDuration;
	slideInterval = setInterval(slide, stepDuration);
}

function slide() {
	slideStep ++;
	if (slideStep > slideSteps)
	{
		slideStep = 0;
		clearInterval(slideInterval);
		return true;
	}
	increment = Math.abs(280) / slideSteps;
	el=document.getElementById('slider'); 
	sliderLeft = sliderLeft + increment * slideDirection;
	el.style.marginLeft= sliderLeft + 'px';
	
}


var prevareaid = "";
function showArea(areaid) {
	el = document.getElementById("area" + prevareaid);
	if (el)
	{
		el.style.display = "none";
	}
	prevareaid  = areaid;
	el = document.getElementById("area" + areaid);
	el.style.display = "block";
}

function toggleArea(obj, prexf, x) {
	if (obj.title == "1")
	{
		obj.title = "2";
		el = document.getElementById("inner-area-" +prexf + "-" + x);
		el.style.display = "block";
		obj.style.backgroundImage = "url(images/arrow-down2.jpg)";
	} else {
		obj.title = "1";
		el = document.getElementById("inner-area-" +prexf + "-" + x);
		el.style.display = "none";
		obj.style.backgroundImage = "url(images/arrow-down.jpg)";
	}
}