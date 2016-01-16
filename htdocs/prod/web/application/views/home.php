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

<script type="text/html" id="slide-template">
  <a href="_link_" class="item _active_">

    <div class="desktop _slideID_" style="background: url(_desktopSlideBackground_) no-repeat center center; background-size: _backgroundSize_; height: 375px">

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

    </div> <!-- end desktop -->

    <div class="mobile _slideID_">

          <img class="mobile" src="_mobileSlideBackground_" style="max-width: 100%; min-width: 100%">

          <p class="heading-container" style="_headingContainerMobileCSS_">
            <span class="heading-text" style="_headingMobileCSS_">_heading_</span> <br>
            <span class="subheading-text" style="_subheadingMobileCSS_">_subheading_</span>
          </p>

          <img class="badge1" src="_badge1_" alt="badge" style="_badge1MobileCSS_">

          <img class="badge2" src="_badge2_" alt="badge" style="_badge2MobileCSS_">

          <div class="container" style="_containerCSS_">

              <img class="carousel-image-overlay" src="_imageOverlay_" alt="image" style="_imageOverlayCSS_">

              <p class="carousel-text-overlay" style="_textOverlayCSS_">
              _textOverlay_
              </p>

              <img class="price-image" src="_priceImage_" alt="price" style="_priceImageCSS_">

              <div class="carousel-description-left" style="_descriptionLeftTextMobileCSS_">
                _descriptionLeftText_
              </div>

              <div class="carousel-description-right" style="_descriptionRightTextMobileCSS_">
                _descriptionRightText_
              </div>

          </div> <!-- end container -->

    </div> <!-- end mobile -->

  </a> <!-- end item -->
</script>


<main class='home'>
	<div class="row home-categories">
		<div class="col-xs-12 col-sm-4">
			<a href='/flyer'>
				<h4 class="box top">Flyers</h4>
				<div class='img'><img src="<?=site_url()?>/assets/images/hf_flyer.jpg" alt="Flyers" style="width: 100%;"/></div>
			</a>
		</div>
		<div class="col-xs-12 col-sm-4">
			<a href='<?=site_url()?>recipes' id="homepage-recipe">
				<h4 class="box top">Recipes</h4>
			</a>
		</div>
		<div class="col-xs-12 col-sm-4">
			<a href='<?=site_url()?>country-kitchen'>
				<h4 class="box top">Country Kitchen</h4>
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

<script type="text/html" id="tpl-featured-recipe-thumb">
  <div class='img'><img src="<?=site_url()?>/assets/_THUMBNAIL_" alt="Recipes"/></div>
</script>

<script>

  jQuery(document).ready(function($) {

    hlf.data.recipes = JSON.parse(<?php echo $recipes ?>);
    hlf.recipes.getFeaturedRecipeHomepage(hlf.data.recipes);

  });

</script>