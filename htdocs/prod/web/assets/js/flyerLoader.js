var fl = {
	init: function(){
		this.loadData(fl.getWeek("current"));
		this.checkOverlapDay();
	},
	getWeek: function(week){
		if (week == "current"){
			var thursday = this.getThursday(new Date());
		}
		else{
			var thursday = this.getNextThursday(new Date());
		}
		var yyyy = thursday.getFullYear().toString();
		var mm = (thursday.getMonth()+1).toString(); 
		var dd  = thursday.getDate().toString();
		return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]);
	},
	getWeekRange: function(week){
		if (week == "current"){
			var thursday = this.getThursday(new Date());
		}
		else{
			var thursday = this.getNextThursday(new Date());
		}
		nextWednesday = this.getThursday(new Date());
		nextWednesday.setDate(thursday.getDate()+6);
		return thursday.toDateString() +" - "+ nextWednesday.toDateString();
	},
	getThursday: function(d) {
		d = new Date(d);
		var day = d.getDay(),
			diff = d.getDate() - day + (day == 0 ? -3:4) - 7; 
		return new Date(d.setDate(diff));
	},
	getNextThursday: function(d) {
		d = new Date(d);
		var day = d.getDay(),
			diff = d.getDate() - day + (day == 0 ? -3:4); 
		return new Date(d.setDate(diff));
	},
	populateFlyer: function(data){
		var html = "";
		for (var i = 0; i < data.pages.length; i++){
			html +='<div class="item"><div class="flyerWrap"><img src="/assets/flyers/'+data.week+'/'+data.pages[i].image+'"></div></div>';
		}
		$(".carousel-inner").html(html);
		this.generateImageMaps(data);
		this.generatePopups(data);
		$(".item").first().addClass("active");
		// $('.item img').loupe({
		// 	width: 500,
		// 	height: 500
  		// });
	},
	generateImageMaps: function(data){
		var html = "";
		for (var j = 0; j < data.pages.length; j++){
			for (var i=0; i < data.pages[j].products.length; i++){
				var prod = data.pages[j].products[i];
				html += "<a href='#productPopup"+j+"_"+i+"' class='imageMap' data-toggle='modal' data-backdrop='false' style='left:"+prod.coords[0]+"px;top:"+prod.coords[1]+"px;width:"+prod.coords[2]+"px;height:"+prod.coords[3]+"px;' id='productImageMap"+j+"_"+i+"'></a>";
			}
			$(".flyer .item .flyerWrap")[j].innerHTML += html;
			html = "";
		}
	},
	generatePopups: function(data){
		var html = "";
		for (var j = 0; j < data.pages.length; j++){
			for (var i=0; i < data.pages[j].products.length; i++){
				var prod = data.pages[j].products[i];
				html += 	"		<div class='modal fade out productPopup' id='productPopup"+j+"_"+i+"' tabindex='-1' role='dialog' >";
				html += 	'			<div class="modal-dialog" role="document">'
				html += 	'				<div class="modal-content">'
				html += 	'					<div class="modal-body">'
				html += 	'						<div class="row">'
				html += 	'							<div class="col-xs-12 col-sm-6 text-center">'
				html += 	'								<img class="image productPopupImage" src="/assets/images/'+prod.image+'">'
				html += 	'							</div>'
				html += 	'							<div class="col-xs-12 col-sm-6">'
				html += 	'								<h3 class="comment">'+prod.comments+'</h3>  '
				html += 	'								<h2 class="title">'+prod.name+'</h2>'      
				html += 	'								<div class="pricing">$'+prod.pricing+'</div>'
				html += 	'								<div class="packaging">'+prod.packaging+'</div>'
				html += 	'								<a href="#" data-add-cart="id" class="btn green addToCart">Add to Shopping List</a>'
				html += 	'							</div>'
				html += 	'						</div>'
				html += 	'						<span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>'
				html += 	'					</div>'
				html += 	'				</div>'
				html += 	'			</div>';
				html += 	"		</div>";
			}
			$(".flyer .item .flyerWrap")[j].innerHTML += html;
			html = "";
		}
	},
	checkOverlapDay: function(){
		var today = new Date();
		//Assuming overlap day is Thursday

		if (today.getDay() == 4){
			var currentWeek = fl.getWeek("current");
			var nextWeek = fl.getWeek("next");
			$("#currentFlyer .flyerThumb").attr("src","/assets/flyers/"+currentWeek+"/page1.jpg");
			$("#currentFlyer .flyerDateRange").html(fl.getWeekRange("current"));
			$("#nextFlyer .flyerThumb").attr("src","/assets/flyers/"+nextWeek+"/page1.jpg");
			$("#nextFlyer .flyerDateRange").html(fl.getWeekRange("next"));
			$("#flyerModal").show();
		}
		else{
			$("#flyerModal").hide();
		}
	},
	loadData: function(week){
		var url = "/assets/flyers/"+week+"/data.json"; 
		var xmlhttp = new XMLHttpRequest(); 
		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange= function() {
			if (xmlhttp.readyState == 4) {
			var data = JSON.parse(xmlhttp.responseText);
			fl.populateFlyer(data);
			}
		}
		xmlhttp.send();
	}
}