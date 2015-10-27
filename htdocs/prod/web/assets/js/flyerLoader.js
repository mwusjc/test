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
			html +='<div class="item"><img src="/assets/flyers/'+data.week+'/'+data.pages[i].image+'"></div>';
		}
		$(".carousel-inner").html(html);
		$(".item").first().addClass("active");
		$('.item img').loupe({
			width: 500,
			height: 500
      	});
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