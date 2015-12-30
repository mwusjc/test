function toggle_node(pNode) {
	el = document.getElementById(pNode);
	if (el.style.display == "block") el.style.display = "none";
	else el.style.display = "block";
}