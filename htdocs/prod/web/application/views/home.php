<style>
    @media screen and (max-width: 767px) {
      #carousel-slide1 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_1.jpg) no-repeat center center !important;
        background-size: cover !important;
      }
      #carousel-slide2 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_2.jpg) no-repeat center center !important;
      }
      #carousel-slide3 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_3.jpg) no-repeat center center !important;
      }
      #carousel-slide4 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_4.jpg) no-repeat center center !important;
      }
      #carousel-slide5 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_5.jpg) no-repeat center center !important;
      }
      #carousel-slide6 {
        background: url(assets/images/test-new-carousel/home_banner_mobile_6.jpg) no-repeat center center !important;
      }
      span.heading-text {
        font-size: 48px !important;
        line-height: 54px !important;
      }
      span.subheading-text {
        font-size: 28px !important;
        line-height: 36px !important;
      }
      .carousel-description-left {
        bottom: -10px !important;
      }
      .carousel-description-right {
        right: 155px !important;
        bottom: 0 !important;
        font-size: 16px !important;
      }
    }
</style>

<div id="carousel" class="carousel slide home" data-ride="carousel" data-interval="60000" >
    <ol class="carousel-indicators">
    </ol>

    <div class="carousel-inner" role="listbox">



    </div> <!-- end carousel-inner -->


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

<script type="text/html" id="slide-feature">
  <a href="_link_"  class="item active responsive">
    <div class="carousel-item-container desktop col-xs-12">
      _featuredDescription_
      <div class="item-1-img" style="_desktopSideImageStyles_">
          <img src="<?=site_url()?>_desktopSideImage_" alt="image" style="_desktopSideImageStylesImg_">
      </div>
    </div>

    <div class="desktop item-1-slide" style="background-image: url('_desktopSlideBackground_');"></div>

    <img class="mobile" src="<?=site_url()?>_mobileSlideBackground_">
  </a>
</script>

<script type="text/html" id="slide-dow-inline">
    <a  href="_link_" class="item responsive">
      <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
      <div class="row dow-product-desc-container">
        <p class="pull-left desktop dow-product-desc">_description_<h5 class="dow-product-details">_descriptionSubtext_</h5></p>
        </div>
          <img class="desktop" src="<?=site_url()?>_desktopPriceImage_">
        </div>

        <img class="desktop" src="<?=site_url()?>_desktopSlideBackground_">
        <img class="mobile" src="<?=site_url()?>_mobileSlideBackground_">
    </a>
</script>

<script type="text/html" id="slide-dow">
    <a href="_link_" class="item responsive">
    <div class="carousel-item-container desktop col-xs-12 home-carousel-caption">
        <img class="desktop" src="<?=site_url()?>_desktopPriceImage_">
    </div>

    <img class="desktop" src="<?=site_url()?>_desktopSlideBackground_">
    <img class="mobile" src="<?=site_url()?>_mobileSlideBackground_">

  </a>
</script>

<script type="text/html" id="slide-template">
  <a href="_link_" id="carousel-slide1" class="item _active_" style="background: url(_desktopSlideBackground_) no-repeat center center; background-size: cover; height: 375px;">

          <div class="container" style="_containerCSS_">

              <p class="heading-container" style="_headingContainerCSS_">
                <span class="heading-text" style="_headingCSS_">_heading_</span> <br>
                <span class="subheading-text" style="_subheadingCSS_">_subheading_</span>
              </p>

              <img class="carousel-image-overlay" src="_imageOverlay_" alt="image" style="_imageOverlayCSS_">

              <p class="carousel-text-overlay" style="_textOverlayCSS_">
              _textOverlay_
              </p>

              <img class="price-image" src="_priceImage_" alt="price" style="_priceImageCSS_">

              <img class="badge1" src="_badge1_" alt="badge" style="_badge1CSS_">

              <img class="badge2" src="_badge2_" alt="badge" style="_badge2CSS_">

              <div class="carousel-description-left" style="_descriptionLeftTextCSS_">
                _descriptionLeftText_
              </div>

              <div class="carousel-description-right" style="_descriptionRightTextCSS_">
                _descriptionRightText_
              </div>

          </div> <!-- end container -->

        </a> <!-- end item -->

</script>

<script type="text/html" id="mobile-style">
  <style>
    @media screen and (max-width: 767px) {
      #slide1 {
        background: url(_mobileSlideBackground_) no-repeat center center !important;
        background-size: cover !important;
      }

      .price {
        width: 150px;
      }
      span.heading-text {
        font-size: 48px !important;
        line-height: 54px !important;
      }

      span.subheading-text {
        font-size: 28px !important;
        line-height: 36px !important;
      }

    }
  </style>
</script>



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