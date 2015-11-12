
</header>
<main>
<div class="row currentFlyerHeadingsContainer">
  <h1 class="title currentFlyerDateRangeTitle">Current Flyer</h2>
  <h4 class="currentFlyerDateRange" id="thisWeekDates">Friday, Nov 6 - Thursday, Nov 12</h4> 
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6">

    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Categories
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" id="categoryMenu" aria-labelledby="dropdownMenu1">
      </ul>
    </div>
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Brands
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" id="brandMenu" aria-labelledby="dropdownMenu2">
      </ul>
    </div>
    
    <a class="btn btn-default modal-toggle" type="button" id="flyerModal" data-toggle="modal" data-backdrop="false" href="#chooseFlyer">
      Choose Flyer
    </a>
    <div class="modal fade out in" id="chooseFlyer" tabindex="-1" role="dialog" aria-labelledby="flyerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" id="currentFlyer" data-dismiss="modal">
                        <div class="col-xs-12 col-sm-3 text-center">
                            <img class="image flyerThumb" src="">
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <h2 class="title">This Week's Flyer</h2>
                            <h3 class="flyerDateRange">Friday, Nov 6 - Thursday, Nov 12</h3>  
                        </div>
                    </div>     
                    <div class="row" id="nextFlyer" data-dismiss="modal">
                        <div class="col-xs-12 col-sm-3 text-center">
                            <img class="image flyerThumb" src="">
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <h2 class="title">Next Week's Flyer</h2>
                            <h3 class="flyerDateRange">Friday, Nov 13 - Thursday, Nov 19</h3>  
                        </div>
                    </div>
                    <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Categories
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" id="categoryMenu" aria-labelledby="dropdownMenu1">
      </ul>
    </div>
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Brands
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" id="brandMenu" aria-labelledby="dropdownMenu2">
      </ul>
    </div> -->
  </div>
  <div class="col-xs-12 col-sm-4" >
    <span id="backToFlyerView" class="btn btn-default right" style="display:none;">Back to full flyer</span>
  </div>
  <div class="col-xs-12 col-sm-2">
    <a href="#" id="flyerPDF" class="btn right green" target="_blank">Download PDF</a>
  </div>
</div>
<div class="row" id="flyerView">
  <div class="col-xs-12 col-sm-12">
      
    <div id="carousel" class="carousel slide flyer desktop" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
      </div>
      <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
      
    <div id="carousel-mobile" class="carousel slide flyer mobile" data-ride="carousel">
      <div class="carousel-inner carousel-inner-mobile" role="listbox">
      </div>
      <a class="left carousel-control" href="#carousel-mobile" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-mobile" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
      
  </div>
</div>
<div class="row" id="listView">
  <div class="col-xs-12 col-sm-12 listViewWrapper">

  </div>
</div>

</main>
<script type='text/javascript'>
    jQuery(document).ready(function($) {
      fl.init();
      $("#currentFlyer").click(function(){
        fl.loadData(fl.getWeek("current"),"desktop");
        fl.loadData(fl.getWeek("current"),"mobile");
        $(".currentFlyerDateRange").html(fl.getWeekRange("current"));
        $(".currentFlyerDateRangeTitle").html("Current Flyer");
      });
      $("#nextFlyer").click(function() {
        fl.loadData(fl.getWeek("next"),"desktop");
        fl.loadData(fl.getWeek("next"),"mobile");
        $(".currentFlyerDateRange").html(fl.getWeekRange("next"));
        $(".currentFlyerDateRangeTitle").html("Next Week's Flyer");
      });
      $('#backToFlyerView').click(function(){
        fl.switchView("flyer");
      });
      $('body').click(function(e){
        if ($(e.target).parents(".productPopup").size()){
          //Don't do anything
        }
        else{
          $(".productPopup").modal("hide");
        }
      });
      var style = $('<style>.modal-backdrop { display:none; }</style>');
      $('html > head').append(style);
      });

</script>