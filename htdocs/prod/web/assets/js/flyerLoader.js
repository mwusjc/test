var fl = {
	init: function(){
		if (window.innerWidth > 677){
			this.loadData(fl.getWeek("current"),"desktop");
		}
		else{
        	this.loadData(fl.getWeek("current"),"mobile");
		}
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
	populateFlyer: function(data,type){

		var html = "";
		for (var i = 0; i < data.pages.length; i++){
			html +='<div class="item"><div class="flyerWrap"><img src="/assets/flyers/'+data.week+'/'+type+'/'+data.pages[i].image+'"></div></div>';
		}
                if (type == "desktop") {
                    $(".carousel-inner").html(html);
                } else {
                    $(".carousel-inner-mobile").html(html);
                }
		
		this.generateImageMaps(data, type);
		this.generatePopups(data);
                if (type == "desktop") {
                    $(".item").first().addClass("active");
                } else {
                    $(".carousel-inner-mobile .item").first().addClass("active");
                }
		
		$("#flyerPDF").attr("href","/assets/flyers/"+data.week+"/download.pdf");
		// $('.item img').loupe({
		// 	width: 500,
		// 	height: 500
  		// });
	},
	generateImageMaps: function(data, type){
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
				if (prod.pricing.indexOf("$")<0){
					prod.pricing = "$"+prod.pricing;
				}
				html += 	"<div class='modal fade out productPopup' id='productPopup"+j+"_"+i+"' tabindex='-1' role='dialog' >";
				html += 	'	<div class="modal-dialog" role="document">'
				html += 	'		<div class="modal-content">'
				html += 	'			<div class="modal-body" data-category="'+ prod.category +'" >'
				html += 	'				<div class="row">'
				html += 	'					<div class="col-xs-12 col-sm-6 text-center">'
				html += 	'						<img class="image productPopupImage" src="/assets/images/flyer-images/'+prod.category+'/'+prod.image+'">'
//				html += 	'						<img class="image productPopupImage" src="/assets/images/121268869-1.jpg">'
				html += 	'					</div>'
				html += 	'					<div class="col-xs-12 col-sm-6">'
				html += 	'						'+(prod.comments=='save'?'<h3 class="comment">save more!</h3>':"");
				html += 	'						<h2 class="title">'+prod.name+'</h2>'      
				html += 	'						<div class="pricing">'+prod.pricing+'</div>'
				html += 	'						<div class="packaging">'+prod.packaging+'</div>'
				html += 	'						<a href="#" data-add-cart="id" class="btn green addToCart">Add to Shopping List</a>'
				html += 	'					</div>'
				html += 	'				</div>'
				html += 	'				<span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>'
				html += 	'			</div>'
				html += 	'		</div>'
				html += 	'	</div>';
				html += 	"</div>";
			}
			$(".flyer .item .flyerWrap")[j].innerHTML += html;
			html = "";
		}
	},
	checkOverlapDay: function(){
		var today = new Date();
		//Assuming overlap day is Thursday
		console.log("today",today);
		if (today.getDay() == 4 || (today.getDay()==3 && today.getHours()>=22)){
			console.log("overlap!")
			var currentWeek = fl.getWeek("current");
			var nextWeek = fl.getWeek("next");
			$("#currentFlyer .flyerThumb").attr("src","/assets/flyers/"+currentWeek+"/page1.jpg");
			$("#currentFlyer .flyerDateRange").html(fl.getWeekRange("current"));
			$("#nextFlyer .flyerThumb").attr("src","/assets/flyers/"+nextWeek+"/page1.jpg");
			$("#nextFlyer .flyerDateRange").html(fl.getWeekRange("next"));
			$("#chooseFlyer").modal("show");
		}
		else{
			console.log("no overlap!")
			$("#chooseFlyer").modal("hide");
		}
	},
	loadData: function(week,type){
		var url = "/assets/flyers/"+week+"/"+type+"/data.json"; 
		var xmlhttp = new XMLHttpRequest(); 
		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange= function() {
			if (xmlhttp.readyState == 4) {
			var data = JSON.parse(xmlhttp.responseText);
			fl.populateFlyer(data,type);
			fl.populateListView(data);
			fl.populateCategories(data);
			fl.populateBrands(data);
			sl.init();
			}
		}
		xmlhttp.send();
	},
	populateBrands: function(data){
		var brands = [];
		var html = "";
		for (var j = 0; j < data.pages.length; j++){
			for (var i=0; i < data.pages[j].products.length; i++){
				var prod = data.pages[j].products[i];
				for (var b = 0; b < prod.brands.length; b++){
					brands.indexOf(prod.brands[b])<0?brands.push(prod.brands[b]):null;
				}
			}
		}
		for (var i = 0; i < brands.length; i++){
			html+= '<li><a href="#" class="brandItem" data-brand="'+brands[i]+'">'+brands[i]+'</a></li>'
		}
		$("#brandMenu")[0].innerHTML = html;
		$(".brandItem").click(function(e){
			fl.filterBrand(e.target.getAttribute("data-brand"));
		})
	},
	populateCategories: function(data){
		var categories = [];
		var html = "";
		for (var j = 0; j < data.pages.length; j++){
			for (var i=0; i < data.pages[j].products.length; i++){
				var prod = data.pages[j].products[i];
				prod.category!=undefined&&categories.indexOf(prod.category)<0?categories.push(prod.category):null;
			}
		}
		for (var i = 0; i < categories.length; i++){
			html+= '<li><a href="#" class="categoryItem" data-category="'+categories[i]+'">'+this.categoryList[categories[i]]+'</a></li>'
		}
		$("#categoryMenu")[0].innerHTML = html;
		$(".categoryItem").click(function(e){
			fl.filterCategory(e.target.getAttribute("data-category"));
		})
	},
	categoryList:{
		"produce" : "Produce",
		"grocery" : "Grocery",
		"meat and deli" : "Meat & Deli",
		"bakery" : "Bakery"
	},
	filterCategory: function(cat){
		$("#listView .row").show();
		$("#listView .row:not([data-category='"+cat+"'])").hide();
		$("#dropdownMenu1")[0].innerHTML = this.categoryList[cat] + ' <span class="caret"></span>';
		this.switchView("list");
	},
	filterBrand: function(brand){
		$("#listView .row").show();
		$.each($("#listView .row"),function(i, row){
			row.getAttribute("data-brand").indexOf(brand)<0? $(row).hide():$(row).show();
		});

		$("#dropdownMenu2")[0].innerHTML = brand + ' <span class="caret"></span>';
		this.switchView("list");
	},
	populateListView: function(data){
		var html = "";
		for (var j = 0; j < data.pages.length; j++){
			for (var i=0; i < data.pages[j].products.length; i++){
				var prod = data.pages[j].products[i];
				var brandstring = "";
				for (var b = 0; b < prod.brands.length; b++){
					brandstring+= prod.brands[b] + "|";
				}
				if (prod.pricing.indexOf("$")<0){
					prod.pricing = "$"+prod.pricing;
				}
				html+=  	'<div class="row" data-category="'+prod.category+'" data-brand="'+brandstring+'">'
				html+=	    '	<div class="col-xs-12 col-sm-3 text-center">'
				html+=	    '		<img class="image" src="/assets/images/flyer-images/'+prod.category+'/'+prod.image+'">'
//				html+=	    '		<img class="image" src="/assets/images/121268869-1.jpg">'
				html+=	    '	</div>'
				html+=	    '	<div class="col-xs-12 col-sm-9">'
				html+=	    '		'+(prod.comments=='save'?'<h3 class="comment">save more!</h3>':"");
				html+=	    '		<h2 class="title">'+prod.name+'</h2>' 
				html+=	    '		<span class="pricing">'+prod.pricing+'</span>'
				html+=	    '		<span class="packaging">'+prod.packaging+'</span>'
				html+=	    '		<div><a href="#" data-add-cart="id" class="btn green addToCart">Add to Shopping List</a></div>'
				html+=	    '	</div>'
				html+=		'</div>'   
			}
		}
		$(".listViewWrapper")[0].innerHTML = html;
	},
	switchView: function(view){
		if (view == 'list'){
			$('#listView').show();
			$('#flyerView').hide();
			$('#backToFlyerView').show();
		}
		else{
			$('#listView').hide();
			$('#flyerView').show();
			$('#backToFlyerView').hide();
			$("#dropdownMenu1")[0].innerHTML = "Categories <span class='caret'></span>";
			$("#dropdownMenu2")[0].innerHTML = "Brands <span class='caret'></span>";
		}

	}
}