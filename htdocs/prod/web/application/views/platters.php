
  <div class="herobanner responsive">
    <img class="desktop" src="<?=site_url()?>assets/images/pp_banner.jpg" />
    <img class="mobile" src="<?=site_url()?>assets/images/pp_banner_mobile.jpg" />

    <div class="wrapper">
      <div class="caption">
        <h1>Platters &amp; Gifts</h1>
        <span data-toggle="modal" data-target="#myModal" class="btn green">Place an order</span>
      </div>
    </div>
  </div>
</header>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body padding">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <h2>Scarborough</h2>
            <p><a href="tel:+14162981999">(416)-298-1999</a></p>

            <p>850 Ellesmere Road </br>
            Scarborough, M1P 2W5</p>

            <p>Mon-Sat: 7:00am-10:00pm </br>
            Sun: 9:00am-8:00pm</p>
          </div>
          <div class="col-xs-12 col-sm-6">
            <h2>Mississauga</h2>
            <p><a href="tel:+19055019910">(905)-501-9910</a></p>

            <p>50 Matheson Blvd. East </br>
            Mississauga, L4Z 1N5</p>

            <p>Mon-Sat: 7:00am-10:00pm </br>
            Sun: 9:00am-8:00pm</p>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <a href="/assets/order-form.pdf" class="btn green" target="_blank">Download order form</a>
          </div>
        </div>
        <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
      </div>
    </div>
  </div>
</div>

<main>
<div class="row">
  <div class="col-xs-12 col-sm-12">
     <h1>Fresh Ideas For Your Next Event </h1>
    <h2>You have enough to worry about with your upcoming party. Leave the finger food to us. Ask in store for details.</h2>
  </div>
</div>
<div class="row divider spacer"></div>
&nbsp;
  

<!--      
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <ul role="tablist">
      <li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab">Breakfast Bites</a></li>
      <li role="presentation"><a href="#international" aria-controls="profile" role="tab" data-toggle="tab">Deli, Cheese, Vegetables and Seafood</a></li>
      <li role="presentation"><a href="#meat" aria-controls="messages" role="tab" data-toggle="tab">Party Platters</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Fabulous Fruits</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Devine Deserts</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Special Order Cakes, Flowers &amp; Gift Baskets</a></li>
    </ul>
  </div>
  <div class="col-xs-12 col-sm-9">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="all">
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_BagelBonanza.jpg" /><strong>$29.99</strong> <span class="break">2 dozen</span> Bagel Delight</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_SunshineBreakfast.jpg" /><strong>$34.99</strong> <span class="break">14" </span> Sweet Mornings</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_antipasto.jpg" /><strong>$49.99</strong> <span class="break">14" </span> Antipasto Perfecto</div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_pop_deli_meat_cheese_fiesta.jpg" /><strong>$39.99</strong> <span class="break">14"+</span> Savoury Delights</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_pop_deli_meat_banquet.jpg" /><strong>$49.99</strong> <span class="break">14"+</span> Meat Your Match</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_european_meat_tn.jpg" /><strong>$49.99</strong> <span class="break">14" </span> European Flair</div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="dessert"><h1>Baked Goods</h1></div>
      <div role="tabpanel" class="tab-pane" id="international"><h1>Food-to-go</h1></div>
      <div role="tabpanel" class="tab-pane" id="meat"><h1>Sauces &amp; condiments</h1></div>
      <div role="tabpanel" class="tab-pane" id="pasta"><h1>Alternatives</h1></div>
    </div>
  </div>
</div>   -->

    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <ul role="tablist">
                <?php foreach($platters_categories AS $key=>$item) :
                      if ($item->Status == "enabled") {?>
                    <li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab" data-filter-id='<?=$item->ID?>'><?=$item->Name?></a></li>
                <?PHP } endforeach; ?>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9">
            <div class='pajinate'>
                <div class='no-results-found hidden'><h1>Sorry! Nothing to be found here.</h1></div>
                <div class="row platters-container content">

                </div> 
                <div class="page_navigation"></div>
            </div>
        </div>
    </div>
</main>

<script type="text/html" id="tpl-platter-listing">
    <div class="col-xs-6 col-sm-4 platter"><a href='#' data-obj-id='_ID_' data-toggle-details='_ID_'>
        <div class='image'><img data-original="<?=site_url()?>assets/_IMAGE_" class='lazy' /></div>
        <div class="img_copy">_TITLE_</div>
        </a>
    </div>
</script>
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
    hlf.data.platters = <?=json_encode($platters)?>;
    hlf.data.platters_categories = <?=json_encode($platters_categories)?>;
    
    jQuery(document).ready(function($) {
        hlf.platters.init(hlf.data.platters);
    })
       
          
    hlf.platters = {
        init: function(data) {
            this.filterListener();
            this.drawList(data);
            this.setListeners();  
        },
        
        filterListener: function() {  
            var that = this; 
            $('[data-filter-id]').on("click", function() {
               that.filterCategory( hlf.data.platters, $(this).data('filter-id') );
            });
            
        },

        filterCategory : function(data,filter) {    
            var filtered = {};
            $.each(data, function(key,item) {
               if(item.CategoryID == filter) {
                filtered[key] = item;   
               } 
            });
            this.drawList(filtered);
            $('input.search').val(null);
        }, 
        togglePopup: function(id) {
            $('#detailModal.otu').remove();  // remove all modal instances (one time use)
            item = hlf.data.platters[id];
            console.log(item);
            mapping = { 
                "{IMG}" : "<?=site_url() ?>"+"assets/"+item.Image,
                "{QTY}" : (item.Qty ? item.Qty : ''), 
                "{QTY_TYPE}" : (item.Qty_type ? item.Qty_type : ''), 
                "{TITLE}": item.Name, 
                "{SUBTITLE}": (item.Subtitle ? item.Subtitle : ''), 
                "{DESCRIPTION}": item.Description, 
                "{ID}": item.id, 
            };
            html = hlf.drawTemplate("#tpl-product-modal", mapping);
            $('body').append(html);
            $('#detailModal').modal('show');  
        },

        setListeners: function() {
            var that = this;
            $(document).on('click', '[data-toggle-details]', function(e) {
                e.preventDefault();
                that.togglePopup( $(this).data("toggle-details") ); 
            });

            $('[data-slidedown]').on("click", function() {
                var obj = $(this).data("slidedown"); 
                $('.ck-products').slideUp();
                $(obj).slideDown(); 
            });
            $('[data-slideup]').on("click", function() {
                var obj = $(this).data("slideup"); 
                $(obj).slideUp();
            });
            
            $('body').on("click", '[data-add-cart]', function(e) {
               e.preventDefault(); 
               var id = $(this).data("add-cart");
               
               $.post('/shopping/add/', {"id": id},  function(response) {
                  console.log(response); 
               }).fail(function() {
                  alert("Unfortunately something went wrong! Please try again."); 
               });
               
               
            });
        },

        drawList: function(data) { 
            $('.platters-container').html(' ');
            $.each(data, function(key,item) {
                mapping = { "_IMAGE_" : item.Image, "_TITLE_" : item.Name, "_ID_" : item.ID, "_DESCRIPTION_": item.Description };
                html = hlf.drawTemplate("#tpl-platter-listing", mapping);
                $('.platters-container').append(html);
            });
            if( $('.platter').length == 0) {
                $('.no-results-found').removeClass('hidden');
            } else {
                $('.no-results-found').addClass('hidden');
            }
            if($('.platter').length > 9) this.pajinate(".pajinate");
            else $('.page_navigation').html(' ');
             $("img.lazy").lazyload({
                  placeholder : "img/grey.gif",
                  effect      : "fadeIn"
             });   
        },
        pajinate: function(ele) {
            $(ele).pajinate({
                'items_per_page': 9,
                'show_paginate_if_one': false
            })
        }
    };
</script>