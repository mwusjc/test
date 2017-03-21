var fl = {
  init: function(){
    if (window.innerWidth > 677){
      this.loadData(fl.getWeek("current"),"desktop");
      //$(".flyer.desktop .item").first().addClass("active");
    }
    else{
      this.loadData(fl.getWeek("current"),"mobile");
      $(".flyer.mobile .item").first().addClass("active");
    }
    this.checkOverlapDay();
  },
  getWeek: function(week){
    if (week == "current"){
      var wednesday = this.getWednesday(new Date());
    }
    else{
      var wednesday = this.getNextWednesday(new Date());
    }
    var yyyy = wednesday.getFullYear().toString();
    var mm = (wednesday.getMonth()+1).toString();
    var dd  = wednesday.getDate().toString();
    return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]);
  },
  getWeekRange: function(week){
    //Check current Flyer range, and adjust duration shown on screen
    if (week == "current"){
      var wednesday = this.getWednesday(new Date());
    }
    else{
      var wednesday = this.getNextWednesday(new Date());
    }
    if (week == "current"){
      var t = this.getWednesday(new Date());
    }
    else{
      var t = this.getNextWednesday(new Date());
    }
    wednesday.setDate(wednesday.getDate()+1);
    t.setDate(t.getDate()+1);
    nextTuesday = t;
    nextTuesday.setDate(nextTuesday.getDate()+6);

    /*
    * NOTE: Temporary code for flyer week of March 2nd 2017 to March 8th 2017 - to be removed when permanent flyer logic changes take effect    */

    if(fl.getWeek("current") == "20170316") {
      var range = "Thu Mar 16 2017 - Wed Mar 22 2017";
      return range;
    }

    if(fl.getWeek("current") == "20170323") {
      var range = "Thu Mar 23 2017 - Wed Mar 29 2017";
      return range;
    }

    return wednesday.toDateString() +" - "+ nextTuesday.toDateString();
  },
  getWednesday: function(d) {
    d = new Date(d);
    var day = d.getDay(),
      diff = d.getDate() - day + (day <= 3 ? -3:4);
    return new Date(d.setDate(diff));
  },
  getNextWednesday: function(d) {
    var thu = this.getWednesday(d);
    return new Date(thu.setDate(thu.getDate()+7));
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
    this.generatePopups(data, type);
        if (type == "desktop") {
            $(".flyer.desktop .item").first().addClass("active");
        } else {
            $(".flyer.mobile .item").first().addClass("active");
        }

    $("#flyerPDF").attr("href","/assets/flyers/"+data.week+"/download.pdf");

  },
  generateImageMaps: function(data, type){
    var html = "";
    for (var j = 0; j < data.pages.length; j++){
      for (var i=0; i < data.pages[j].products.length; i++){
        var prod = data.pages[j].products[i];
        html += "<a href='#' data-target='#"+type+"productPopup"+j+"_"+i+"' data-item-name='" + prod.name + "' class='imageMap' data-toggle='modal' style='left:"+prod.coords[0]+"px;top:"+prod.coords[1]+"px;width:"+prod.coords[2]+"px;height:"+prod.coords[3]+"px;' id='productImageMap"+j+"_"+i+"'></a>";
      }
      if (type=="desktop"){
        $(".desktop.flyer .item .flyerWrap")[j].innerHTML += html;
      }
      else{
        $(".mobile.flyer .item .flyerWrap")[j].innerHTML += html;
      }
      html = "";
    }
  },
  generatePopups: function(data, type){
    var html = "";

    $("."+type+".productPopup").remove();
    for (var j = 0; j < data.pages.length; j++){
      for (var i=0; i < data.pages[j].products.length; i++){
        var prod = data.pages[j].products[i];
        html +=   "<div class='modal fade out "+type+" productPopup' id='"+type+"productPopup"+j+"_"+i+"' tabindex='-1' role='dialog' >";
        html +=   ' <div class="modal-dialog" role="document">'
        html +=   '   <div class="modal-content">'
        html +=   '     <div class="modal-body" data-category="'+ prod.category +'" data-item-name="' + prod.name + '">'
        html +=   '       <div class="row">'
        html +=   '         <div class="col-xs-12 col-sm-6 text-center">'
        //Pull in current week as folder name for Flyers
        html +=   '           <img class="image productPopupImage" src="/assets/images/'+data.week+'/'+prod.image+'">'
        html +=   '         </div>'
        html +=   '         <div class="col-xs-12 col-sm-6">'
        html +=   '           '+(prod.comments=='save'?'<h3 class="comment">save more!</h3>':"");
        html +=   '           <h2 class="title">'+prod.name+'</h2>'
        html +=   '           <div class="pricing">'+prod.pricing+'</div>'
        html +=   '           <div class="packaging">'+prod.packaging+'</div>'
        html +=   '           <a href="#" data-add-cart="id" class="btn green addToCart">Add to Shopping List</a>'
        html +=   '         </div>'
        html +=   '       </div>'
        html +=   '       <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>'
        html +=   '     </div>'
        html +=   '   </div>'
        html +=   ' </div>';
        html +=   "</div>";
      }
      $("body")[0].innerHTML += html;
      html = "";
    }
  },
  previewFlyers: function() {
    var currentWeek = fl.getWeek("current");
    var nextWeek = fl.getWeek("next");
    //Check if Flyer has entered overlap period, and adjust flyers shown as well as duration dates
    $("#currentFlyer .flyerThumb").attr("src","/assets/flyers/"+currentWeek+"/mobile/page1.jpg");
    $("#currentFlyer .flyerDateRange").html(fl.getWeekRange("current"));
    $("#nextFlyer .flyerThumb").attr("src","/assets/flyers/"+nextWeek+"/mobile/page1.jpg");
    /* $("#nextFlyer .flyerDateRange").html("Thu Mar 02 2017 - Wed Mar 08 2017");*/
    $("#nextFlyer .flyerDateRange").html(fl.getWeekRange("next"));


    /*
    * NOTE: Temporary code added for visual flyer duration tweaks to take effect solely on Wednesday, February 22nd 2017.
    * Code to be removed when permanent flyer logic changes take effect is only the if..statement below.
    * The line that reads 'window.setTimeout('$("#chooseFlyer").modal("show");',1000);' is to remain as that is critical to visual treatment of overlap days
     */
    if(currentWeek == "20170316") {
      $("#nextFlyer .flyerDateRange").html("Thu Mar 23 2017 - Wed Mar 29 2017");    
    } 
    if(currentWeek == "20170316") {
      $("#currentFlyer .flyerDateRange").html("Thu Mar 16 2017 - Wed Mar 22 2017");    
    } 

    

    window.setTimeout('$("#chooseFlyer").modal("show");',1000);
  },
  checkOverlapDay: function(){
    var today = new Date();
    var test = location.search;
    //Assuming overlap day is Thursday
    /* if (today.getDay() == 4 || (today.getDay()==3 && today.getHours()>=22) || (test.match("overlap=true"))){
      this.previewFlyers();
    }*/
    if (today.getDay() == 3 || (today.getDay()==2 && today.getHours()>=22) || (test.match("overlap=true"))){
      this.previewFlyers();
    }
    else{
      $("#chooseFlyer").modal("hide");
      $("#flyerModal").hide();
    }
  },
  loadData: function(week,type){
    //Check week for current flyer, and modify data URL accordingly
    var url = "/assets/flyers/"+week+"/"+type+"/data.json";

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", url, true);
    xmlhttp
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4) {
      var data = JSON.parse(xmlhttp.responseText);
      fl.populateFlyer(data,type);
      fl.populateListView(data,type);
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
    brands.sort();
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
    categories.sort();
    for (var i = 0; i < categories.length; i++){
      html+= '<li><a href="#" class="categoryItem" data-category="'+categories[i]+'">'+categories[i]+'</a></li>'
    }
    $("#categoryMenu")[0].innerHTML = html;
    $(".categoryItem").click(function(e){
      fl.filterCategory(e.target.getAttribute("data-category"));
    })
  },
  filterCategory: function(cat){
    $("#dropdownMenu1")[0].innerHTML = "Categories <span class='caret'></span>";
    $("#dropdownMenu2")[0].innerHTML = "Brands <span class='caret'></span>";
    $("#listView .row").show();
    $.each($("#listView .row"),function(i, row){
      row.getAttribute("data-category").indexOf(cat)<0? $(row).hide():$(row).show();
    });
    $("#dropdownMenu1")[0].innerHTML = '<span class="filter">' + cat + '</span>' + ' <span class="caret"></span>';
    this.switchView("list");
  },
  filterBrand: function(brand){
    $("#dropdownMenu1")[0].innerHTML = "Categories <span class='caret'></span>";
    $("#dropdownMenu2")[0].innerHTML = "Brands <span class='caret'></span>";
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
        html+=    '<div class="row" data-category="'+prod.category+'" data-brand="'+brandstring+'">'
        html+=      ' <div class="col-xs-12 col-sm-3 text-center">'
        //Pull in current week as folder name for Flyers
        html +=   '     <img class="image" src="/assets/images/'+data.week+'/'+prod.image+'">'
        html+=      ' </div>'
        html+=      ' <div class="col-xs-12 col-sm-9">'
        html+=      '   '+(prod.comments=='save'?'<h3 class="comment">save more!</h3>':"");
        html+=      '   <h2 class="title">'+prod.name+'</h2>'
        html+=      '   <span class="pricing">'+prod.pricing+'</span>'
        html+=      '   <span class="packaging">'+prod.packaging+'</span>'
        html+=      '   <div><a href="#" data-add-cart="id" class="btn green addToCartListView">Add to Shopping List</a></div>'
        html+=      ' </div>'
        html+=    '</div>'
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