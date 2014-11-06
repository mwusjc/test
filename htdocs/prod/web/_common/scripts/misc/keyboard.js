
var alt = false;
var ctrl = false;
var shift = false;

function keyHandler(ev) {
		alt = (ev.altKey) ? true : false;
		ctrl = (ev.ctrlKey) ? true : false;
		shift = (ev.shiftKey) ? true : false;
		macAlt = (ev.metaKey) ? true: false;
		cancelEv = false;

	if ((ev.keyCode<16)||(ev.keyCode>18)) {
		 if (ctrl) {
			switch (ev.keyCode)
			{
				case 78: //Alt + N
					window.location = "index.php?n=Projects&o=new";
					return false;
				case 65: //Alt + A
					showAllProjects(); 
					ctrl=false; return false;break;
				case 77: //Alt + M
					showMyProjects();
					ctrl=false; return false; break;
				case 84: //Alt + T
					window.location = "index.php?n=Projects&o=tools";
					return false;
				case 69: //Alt + E
					exportProjectList();
					ctrl=false; return false; break;
				case 76: //Alt + L
					window.location = "index.php?n=Users&o=logout";						
					return false;
				case 72: //Alt + H
					window.location = "index.php";						
					return false;
			}
		 }
		 alt = false;
         ctrl = false;
         shift = false; 
		 if (cancelEv) return false;
	}
	if (ctrl) return false;
	return true;
}