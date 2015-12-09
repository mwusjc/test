<div id="carousel" class="carousel slide home" data-ride="carousel" data-interval="6000" >
    <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
        <li data-target="#carousel" data-slide-to="2"></li>
        <li data-target="#carousel" data-slide-to="3"></li>
        <li data-target="#carousel" data-slide-to="4"></li>
        <li data-target="#carousel" data-slide-to="5"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <a href="#"  class="item active responsive">
            <!-- Add inline text here to replace copy within current image asset -->
            <div class="carousel-item-container desktop col-xs-12">
                <div class="item-1-img">
                    <img src="<?=site_url()?>/assets/images/home_float_left.png" alt="holidays">
                </div>
            </div>

            <div class="desktop item-1-slide"></div>


            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_1.jpg">

        </a>
        <a  href="/flyer"class="item responsive">
            <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
                <div class="row dow-product-desc-container">
                    <p class="pull-left desktop dow-product-desc">Fresh Ontario<br/>Pork Back Ribs</p>
                </div>
                <img class="desktop" src="<?=site_url()?>/assets/images/home_price-2.png">
            </div>

            <img class="desktop" src="<?=site_url()?>/assets/images/home_carousel-2.jpg">
            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_2.jpg">
        </a>
        <a href="/flyer" class="item responsive">
            <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
                <div class="row dow-product-desc-container">
                    <p class="pull-left desktop dow-product-desc">Apples<br/>Red or Golden Delicious<br/>Fancy Grade</p>
                </div>
                <img class="desktop" src="<?=site_url()?>/assets/images/home_price-3.png">
            </div>

            <img class="desktop" src="<?=site_url()?>/assets/images/home_carousel-3.jpg">
            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_3.jpg">

        </a>
        <a href="/flyer" class="item responsive">
            <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
                <img class="desktop" src="<?=site_url()?>/assets/images/home_price-4.png">
            </div>

            <img class="desktop" src="<?=site_url()?>/assets/images/home_carousel-4.jpg">
            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_4.jpg">

        </a>
        <a href="/flyer" class="item responsive">
            <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
                <img class="desktop" src="<?=site_url()?>/assets/images/home_price-5.png">
            </div>

            <img class="desktop" src="<?=site_url()?>/assets/images/home_carousel-5.jpg">
            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_5.jpg">

        </a>
        <a href="/flyer" class="item responsive">
            <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
                <img class="desktop" src="<?=site_url()?>/assets/images/home_price-6.png">
            </div>

            <img class="desktop" src="<?=site_url()?>/assets/images/home_carousel-6.jpg">
            <img class="mobile" src="<?=site_url()?>/assets/images/home_banner_mobile_6.jpg">
        </a>
    </div>
    <a class="left carousel-control" href="#carousel" role="button" data-slide="prev" onclick="$('#carousel').carousel('pause');">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel" role="button" data-slide="next" onclick="$('#carousel').carousel('pause');">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

</header>
<main class='home'>
    <div class="row home-categories">
        <div class="col-xs-12 col-sm-4">
            <a href='/flyer'>
                <h4 class="box top">Flyers</h1>
                <div class='img'><img src="<?=site_url()?>/assets/images/hf_flyer.jpg" alt="Flyers" style="width: 100%;"/></div>
            </a>
        </div>
        <div class="col-xs-12 col-sm-4">
            <a href='<?=site_url()?>recipes'>
                <h4 class="box top">Recipes</h1>
                <div class='img'><img src="<?=site_url()?>/assets/images/home_recipes.jpg" alt="Recipes"/></div>
            </a>
        </div>
        <div class="col-xs-12 col-sm-4">
            <a href='<?=site_url()?>country-kitchen'>
                <h4 class="box top">Country Kitchen</h1>
                <div class='img'><img src="<?=site_url()?>/assets/images/home_ck.jpg" alt="Country Kitchen"/></div>
            </a>
        </div>
    </div>

    <hr class='extra-space'>

    <div class="row">
        <div class="col-xs-6 col-sm-3 home-thumbnail-grid">
            <a href='<?=site_url()?>visit-us'>
                <img class="col-xs-12" src="<?=site_url()?>/assets/images/home_visit.jpg" alt="Visit Us"/>
                <p class="col-xs-12 home-thumbnail-desc">Visit Us</p>
            </a>
        </div>
        <div class="col-xs-6 col-sm-3 home-thumbnail-grid">
            <a href='<?=site_url()?>party-platters'>
                <img class="col-xs-12" src="<?=site_url()?>/assets/images/home_pp.jpg" alt="Party Platters And More"/>
                <p class="col-xs-12 home-thumbnail-desc">Party Platters And More</p>
            </a>
        </div>
        <div class="col-xs-6 col-sm-3 home-thumbnail-grid">
            <a href='<?=site_url()?>about/highland-farms-originals'>
                <img class="col-xs-12" src="<?=site_url()?>/assets/images/home_originals.jpg" alt="Highland Farms Originals"/>
                <p class="col-xs-12 home-thumbnail-desc">Highland Farms Originals</p>
            </a>
        </div>
        <div class="col-xs-6 col-sm-3 home-thumbnail-grid">
            <a href='<?=site_url()?>inside-store'>
                <img class="col-xs-12" src="<?=site_url()?>/assets/images/home_inside-store.jpg" alt="Inside The Store"/>
                <p class="col-xs-12 home-thumbnail-desc">Inside The Store</p>
            </a>
        </div>
    </div>
</main>


