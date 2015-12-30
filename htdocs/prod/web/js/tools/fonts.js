var fontsize = 13
var savedFontSize = 13;
//	alert(savedFontSize);

function setFontSize() {
	$("#minus").click(function () {changeFontSize(-1)});
	$("#plus").click(function () {changeFontSize(1)});
	if (savedFontSize)
	{
		savedFontSize = Get_Cookie("FontSize");
		if (parseInt(savedFontSize)) fontsize = savedFontSize;
		el = document.getElementsByTagName("body");
		if (el)
		{
			try
			{
				el[0].style.fontSize = fontsize + "px";	
			}
			catch (ex)
			{
				;
			}
			
		}
	}
}

function changeFontSize(direction) {
	el = document.getElementsByTagName("body");
	if (direction == 0)
	{
		el[0].style.fontSize = "13px";
		fontsize = 13;
	} else {
		if (fontsize >= 17 && direction > 0) return true;
		if (fontsize <= 10 && direction < 0) return true;
		fontsize = parseInt(fontsize) + parseInt(direction); 
		el[0].style.fontSize = fontsize + "px";
	}
	direction = 1 - direction;
	Set_Cookie("FontSize", fontsize, 1);
}