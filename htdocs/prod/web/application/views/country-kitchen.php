
  <div class="herobanner responsive country-kitchen-banner-container">
    <img class="desktop country-kitchen-banner" src="<?=site_url()?>assets/images/ck_banner_sep23_tn-logo-flatten.jpg" />
    <img class="mobile" src="<?=site_url()?>assets/images/ck_banner_mobile.jpg" />
  </div>
  <div class="country-kitchen">
    <div class="wrapper">
      <div class="row">
        <div class="country-kitchen-heading col-xs-12 col-sm-12">
            <h1>Exclusive to Highland Farms</h1>
            <h2>Prepared with the finest ingredients from traditional recipes, every delicious Country Kitchen dish is a comforting celebration of life and food.</h2>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Modal -->


<main>

    <div class='row'>

        <div class='col-sm-6'>
            <div class="ck-item" data-id="1" data-slidedown='.ck-products[data-id="1"]' data-category-name='frozen-entrees'>
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_frozen.png')?>" alt="Frozen Entr&eacute;es"/></div>
                <h2 class="box bottom">Frozen Entrées</h2>  
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="ck-item" data-id="2" data-slidedown='.ck-products[data-id="2"]' data-category-name='breads'>                
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_bread.png')?>" alt="Bread &amp; Artisan Breads"/></div>
                <h2 class="box bottom">Bread & Artisan Breads</h2>
            </div>
        </div>

    </div>
    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='1' data-category-name='frozen-entrees'>
                <h1>Frozen Entrées</h1>
                <h2>Made from the freshest and finest ingredients, our selection of entrées is an easy way to serve your family's favourites.</h2>
                 <div class='row'>
                   <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "1") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>   
                 </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='2' data-category-name='breads'>
                <h1>Bread & Artisan Breads</h1>
                <h2>Our hearty and wholesome breads are freshly baked with natural, quality ingredients.</h2>
                <div class='row'>
                <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "2") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>' data-category='<?=$item->bread_type?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>                            
                                 
                </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>  
        </div>

    </div>

    <div class='row'>
        <div class='col-sm-6'>
            <div class="ck-item" data-id="3" data-slidedown='.ck-products[data-id="3"]' data-category-name='all-natural-sauces'>  
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_sauces.png')?>" alt="All Natural Sauces"/></div>
                <h2 class="box bottom">All Natural Sauces</h2>
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="ck-item" data-id="4" data-slidedown='.ck-products[data-id="4"]' data-category-name='sweet-savoury-snacks'>            
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_snacks.png')?>" alt="Sweet &amp; Savoury Snacks"/></div>
                <h2 class="box bottom">Sweet & Savoury Snacks</h2>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='3' data-category-name='all-natural-sauces'>
                <h1>All Natural Sauces</h1>
                <h2>Enhance the flavour of your dishes with our flavourful sauces, seasoned to perfection.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "3") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>   
                </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='4' data-category-name='sweet-savoury-snacks'>
                <h1>Sweet & Savoury Snacks</h1>
                <h2>Satisfy your cravings with an array of nuts and dried fruit.</h2>
                <div class='row'>
                    <img class="sweetSavoury" src="/assets/images/sweet_savory.jpg" alt="Sweet and Savoury Snacks"> 
                </div>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "4") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>   
                </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>
        </div>
    </div>

    <div class='row'>

        <div class='col-sm-6'>
            <div class="ck-item" data-id="5" data-slidedown='.ck-products[data-id="5"]' data-category-name='baked-goods'>            
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_baked-goods.png')?>" alt="Baked Goods"/></div>
                <h2 class="box bottom">Baked Goods</h2>
            </div>
        </div>
        <div class='col-sm-6'>                                                
            <div class="ck-item" data-id="6" data-slidedown='.ck-products[data-id="6"]' data-category-name='prepped-ready-meals'>              
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_readymeals.png')?>" alt="Prepped &amp; Ready Meals"/></div>
                <h2 class="box bottom">Prepped & Ready Meals</h2>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='5' data-category-name='baked-goods'>
                <h1>Baked Goods</h1>
                <h2>Freshly made and ready to be devoured, we have something for every sweet tooth.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "5") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>   
                </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 ck-details'>
            <div class='ck-products bottom-slide' data-id='6' data-category-name='prepped-ready-meals'>
                <h1>Prepped & Ready Meals</h1>
                <h2>Our chefs have prepped the freshest ingredients of your favourite dishes. Everything's ready to be enjoyed in minutes.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "6") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" alt="<?=$item->name?>"/></div>
                                    <p class='title'><?=$item->name?></p> 
                                </a>
                            </div>
                <?PHP endif; } ?>   
                </div>
                <span class="glyphicon glyphicon-remove close" data-slideup='.ck-products'></span>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-xs-12 col-sm-8 originals-feature' style='padding-right:0px;'>
            <div class='img' style='height:200px;'><img src="<?=site_url('/assets/images/country-kitchen/ck_giftcard.jpg')?>" alt="Highland Farms Originals" width="900" /></div>
        </div>
        <div class='col-xs-12 col-sm-4 green bg-primary border bottom-box' style='height:200px;border:0px;'>
            <div class='bg-primary' style='position:absolute;bottom:0;'>
                <h1>Highland Farms Originals</h1>
                <p><a href='/about/highland-farms-originals'>Learn More <span style='font-size:120%;'>></span></a></p>
            </div>
        </div>
    </div>

</main>

<script type='text/html' id='tpl-product-modal'>
  <div class="modal fade otu productPopup" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 text-center">
                        <img class='image' src="{IMG}">
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <h2 class='title'>{TITLE} {QTY}{QTY_TYPE}</h2>
                        <h3>{SUBTITLE}</h3>        
                        <p class='description'>{DESCRIPTION}</p>
                        <a href='#' data-add-cart='{ID}' class='btn green addToCart'>Add to Shopping List</a>
                    </div>
                </div>     
                <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
            </div>
        </div>
    </div>
</div>
</script>
<script type='text/javascript'>

    hlf.data.products = <?=json_encode($products)?>;
    hlf.data.products_categories = <?=json_encode($products_categories)?>;

    hlf.countrykitchen = {
        init: function() {
            this.setListeners();  
        },

        togglePopup: function(id) {
            $('#detailModal.otu').remove();  // remove all modal instances (one time use)
            var item = hlf.data.products[id];
            mapping = { 
                "{IMG}" : item.image,
                "{QTY}" : (item.qty ? item.qty : ''), 
                "{QTY_TYPE}" : (item.qty_type ? item.qty_type : ''), 
                "{TITLE}": item.name, 
                "{SUBTITLE}": (item.subtitle ? item.subtitle : ''), 
                "{DESCRIPTION}": item.description, 
                "{ID}": item.id, 
            };
            html = hlf.drawTemplate("#tpl-product-modal", mapping);
            $('body').append(html);
            $('#detailModal').modal('show');  
        },

        setListeners: function() {
            var that = this;
            $('[data-toggle-details]').on('click', function(e) {
                e.preventDefault();
                that.togglePopup( $(this)[0].getAttribute("data-toggle-details") ); 
            });

            $('[data-slidedown]').on("click", function() {
                var obj = $(this)[0].getAttribute("data-slidedown"); 
                $('.ck-products').slideUp();
                $(obj).slideDown(); 
            });
            $('[data-slideup]').on("click", function() {
                var obj = $(this)[0].getAttribute("data-slideup"); 
                $(obj).slideUp();
                //Check if a fragment identifier exists on section close and remove it from the URL if present
                if(document.URL.substr(document.URL.indexOf('#') > 0)) {
                    var resetURL = document.URL.substr(0, document.URL.indexOf('#'));
                    window.location = resetURL;
                }
            });
            
            $('body').on("click", '[data-add-cart]', function(e) {
               e.preventDefault(); 
               var id = $(this)[0].getAttribute("data-add-cart");
               
               $.post('/shopping/add/', {"id": id},  function(response) {
               }).fail(function() {
                  alert("Unfortunately something went wrong! Please try again."); 
               });
               
               
            });
        }
    };

    jQuery(document).ready(function($) {
        //Check if fragment exists in URL
        if(window.location.hash) {
            //If a fragment exists, store it in a variable
            var fragment = window.location.hash;
            //Find matching DOM element to current fragment (without the preceding hash that is returned from using window.location.hash)
            var fragmentElement = $(".ck-products[data-category-name='" + fragment.substr(1) + "']");
            //If matching fragment is found in DOM, render the specified category as expanded on page load
            if(fragmentElement !== null) {
                if(fragmentElement.hasClass("bottom-slide")) { 
                    $(fragmentElement).slideDown(); 
                }
            }
            else {
                //Do nothing if fragment returns null
            }
        }
        else {
            //Do nothing if no page fragment identifier exists in URL
        }

        hlf.countrykitchen.init();

        $(".ck-item, .ck-products").click(function(e){
            //Check if details slide-down is visible on page (using jQuery object here, :visible is not part of native CSS spec)
            var numDetails = $(".ck-products:visible").length;
            if (numDetails > 0){
                //Use HTML5 History API to change page state based on current fragment identifier
                var data = e.currentTarget.getAttribute("data-category-name"),
                    url = "#" + data;
                    history.replaceState(url, null, url);
            }
            else{
              //Do nothing if no category area has been selected
            }
        });
    });

</script>