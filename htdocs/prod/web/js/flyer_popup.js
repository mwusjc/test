
function showFlyerSelection () {
	txt = "<div class='fpop-holder'><h1>SELECT A FLYER TO VIEW</h1><div class='fpop-left'><h2>This Week’s Flyer.</h2><br>Effective "+flyerdates[0]+".<a href='/index.php?n=Flyers&o=main&mode=previous'><img width='300' src='"+flyerpics[0]+"'></a></div><div class='fpop-right'><h2>Upcoming Flyer.</h2><br>Effective "+flyerdates[1]+".<a href='/index.php?n=Flyers&o=main&mode=standard'><img width='300' src='"+flyerpics[1]+"'></a></div></div>";
	messageRound(txt);
}

$(document).ready(function () {
	showFlyerSelection();
});