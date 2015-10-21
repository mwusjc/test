
</header>
<main>
<div class="row">
  <div class="col-xs-12 col-sm-6">
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Flyer
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="#">This week</a></li>
        <li><a href="#">Next week</a></li>
      </ul>
    </div>
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Categories
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="#">Deli</a></li>
        <li><a href="#">Fish/ Seafood</a></li>
        <li><a href="#">Meat</a></li>
        <li><a href="#">Produce</a></li>
        <li><a href="#">Bakery</a></li>
      </ul>
    </div>
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Flyer
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="#">7 Days Bake It</a></li>
        <li><a href="#">All Stars Bakery</a></li>
        <li><a href="#">Black Diamond</a></li>
        <li><a href="#">Breyers</a></li>
        <li><a href="#">Bob's Red Mill</a></li>
        <li><a href="#">Casa Italia</a></li>
        <li><a href="#">Castello</a></li>
      </ul>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6">
    <input type="button" value="Download PDF" class="right green" />
    <input type="button" value="+" class="white padding right" />
    <input type="button" value="-" class="white padding margin right" />
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12">
    <div id="carousel" class="carousel slide flyer" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="<?=site_url()?>assets/images/flyer_cover_aug25.jpg"/>
        </div>
        <div class="item">
          <img src="<?=site_url()?>assets/images/flyer_spread_aug25.jpg">
        </div>
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
    
  </div>
</div>

</main>