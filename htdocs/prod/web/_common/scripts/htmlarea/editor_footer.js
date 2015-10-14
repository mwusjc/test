// generate the code to init all wysiwyg's
// have to put at the end of the html doc
var htmlArea = new Array(20);
var j=0;
for (i=1;i<document.all.length;i++) {
	if (document.all(i).tagName=="TEXTAREA") {
		var isRich = false;
		for (k=0;k<globRichs.length;k++) {
//			alert(globRichs[k]);
			isRich = (globRichs[k]==document.all(i).name)?true:isRich;
		} // for
		if (isRich) {
			htmlArea[j]=document.all(i).name;
			j=j+1;
		} // if
	} // if 
} // for

for (i=0;i<j;i++) { 
	editor_generate(htmlArea[i]); 
} // for