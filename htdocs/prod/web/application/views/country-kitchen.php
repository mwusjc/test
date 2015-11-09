
  <div class="herobanner responsive">
    <img class="desktop" src="<?=site_url()?>assets/images/ck_banner_sep23_tn-logo-flatten.jpg" />
    <img class="mobile" src="<?=site_url()?>assets/images/ck_banner_mobile.jpg" />
  </div>
  <div class="country-kitchen">
    <div class="wrapper">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
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
            <div class="ck-item" data-id="1" data-slidedown='.ck-products[data-id="1"]'>
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_frozen.png')?>" /></div>
                <h2 class="box bottom">Frozen Entrées</h2>  
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="ck-item" data-id="2" data-slidedown='.ck-products[data-id="2"]'>                
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_bread.png')?>" /></div>
                <h2 class="box bottom">Bread & Artisan Breads</h2>
            </div>
        </div>

    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <div class='ck-products' data-id='1'>
                <h1>Frozen Entrées</h1>
                <h2>Made from the freshest and finest ingredients, our selection of entrées is an easy way to serve your family's favourites.</h2>
                 <div class='row'>
                   <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "1") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
        <div class='col-sm-12'>
            <div class='ck-products' data-id='2'>
                <h1>Bread & Artisan Breads</h1>
                <h2>Our hearty and wholesome breads are freshly baked with natural, quality ingredients.</h2>
                <div class='row'>
                <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "2") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
            <div class="ck-item" data-id="3" data-slidedown='.ck-products[data-id="3"]'>  
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_sauces.png')?>" /></div>
                <h2 class="box bottom">All Natural Sauces</h2>
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="ck-item" data-id="4" data-slidedown='.ck-products[data-id="4"]'>            
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_snacks.png')?>" /></div>
                <h2 class="box bottom">Sweet & Savoury Snacks</h2>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12'>
            <div class='ck-products' data-id='3' >
                <h1>All Natural Sauces</h1>
                <h2>Enhance the flavour of your dishes with our flavourful sauces, seasoned to perfection.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "3") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
        <div class='col-sm-12'>
            <div class='ck-products' data-id='4'>
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
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
            <div class="ck-item" data-id="5" data-slidedown='.ck-products[data-id="5"]'>            
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_baked-goods.png')?>" /></div>
                <h2 class="box bottom">Baked Goods</h2>
            </div>
        </div>
        <div class='col-sm-6'>                                                
            <div class="ck-item" data-id="6" data-slidedown='.ck-products[data-id="6"]'>              
                <div class='image'><img src="<?=site_url('/assets/images/country-kitchen/ck_category_readymeals.png')?>" /></div>
                <h2 class="box bottom">Prepped & Ready Meals</h2>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12'>
            <div class='ck-products' data-id='5' >
                <h1>Baked Goods</h1>
                <h2>Freshly made and ready to be devoured, we have something for every sweet tooth.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "5") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
        <div class='col-sm-12'>
            <div class='ck-products' data-id='6'>
                <h1>Prepped & Ready Meals</h1>
                <h2>Our chefs have prepped the freshest ingredients of your favourite dishes. Everything's ready to be enjoyed in minutes.</h2>
                <div class='row'>
                  <?php
                    foreach($products AS $key=>$item) {
                        if($item->category == "6") : ?>
                            <div class='col-sm-3'>
                                <a href='' data-toggle-details='<?=$item->id?>'>
                                    <div class='img-block'><img src="<?=site_url($item->image)?>" /></div>
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
        <div class='col-sm-8' style='padding-right:0px;'>
            <div class='img' style='height:200px;'><img src="<?=site_url('/assets/images/country-kitchen/ck_giftcard.jpg')?>" width="900" /></div>
        </div>
        <div class='col-sm-4 green bg-primary border' style='height:200px;border-radius: 0 10px 10px 0px;border:0px;'>
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
            item = hlf.data.products[id];
            console.log("item",item);
            console.log("item image",item.image);
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
        hlf.countrykitchen.init(); 
    });

</script>