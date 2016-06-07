
  <div class="herobanner responsive" style="background-image:url(<?=site_url()?>assets/images/pp_banner.jpg); background-size:cover">
    <div class="caption col-xs-12">
        <div class="wrapper">
            <div class="row feature-title col-xs-10 col-sm-6">
                <h1 class="capitalize">Platters &amp; Gifts</h1>
            </div>
        </div>
    </div>
  </div>
</header>

<main>
<div class="row">
  <div class="col-xs-12 col-sm-12 platters-heading">
     <h1>Fresh Ideas For Your Next Event </h1>
     <h2>You have enough to worry about with your upcoming party. Leave the finger food to us. Ask in store for details.</h2>
  </div>
  
  <!-- Two PDF download buttons -->
  <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-zero">
    <a href="/assets/order-form.pdf" class="btn green" target="_blank">Download Order Form</a>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-zero">
    <a href="/assets/xxx.pdf" class="btn green" target="_blank">View Catalogue</a>
  </div>
</div>
<div class="row divider spacer"></div>
&nbsp;

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
    <div class="col-xs-6 col-sm-4 platter" data-platter-name="_TITLE_"><a href='#' data-obj-id='_ID_' data-toggle-details='_ID_'>
        <div class='image'><img data-original="<?=site_url()?>assets/_IMAGE_" alt='_TITLE_' class='lazy' /></div>
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
                        <img class='image' src="{IMG}" alt="{TITLE}">
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <h2 class='title'>{TITLE} {QTY_TYPE}</h2>
                        <h3>{SUBTITLE}</h3> 
                        <div class='pricing'>{QTY} {PRICE} <br/> {QTY2} {PRICE2} <br/> {QTY3} {PRICE3} </div>       
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
        var p = hlf.data.platters;
        var newArray = [];
        for(var x in p) { 
            newArray.push(p[x]); 
        }
        // Mapping revised object collection of platters
        newArray.map(function(x) {
            return x.VisualOrder = parseInt(x.VisualOrder);
        });
        
        // Sorting platters from result set based on value of VisualOrder column from platters table in DB
        newArray = newArray.sort(function(a, b) {
            a = a.VisualOrder;
            b = b.VisualOrder;
            return (a > b) ? 1 : ((b > a) ? -1 : 0);
        });

        // Make dataset match expected results
        hlf.data.platters = newArray;
        hlf.platters.init(hlf.data.platters);
    });
          
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
            var item = hlf.data.platters[id];
            mapping = { 
                "{IMG}" : "<?=site_url() ?>"+"assets/"+item.Image,
                "{QTY}" : (item.Quantity ? item.Quantity : ''), 
                "{QTY2}" : (item.Quantity2 ? item.Quantity2 : ''), 
                "{QTY3}" : (item.Quantity3 ? item.Quantity3 : ''), 
                "{QTY_TYPE}" : (item.Qty_type ? item.Qty_type : ''), 
                "{TITLE}": item.Name, 
                "{SUBTITLE}": (item.Subtitle ? item.Subtitle : ''), 
                "{DESCRIPTION}": item.Description, 
                "{ID}": item.id,
                "{PRICE}": (item.Price ? "$" + item.Price : ''),
                "{PRICE2}": (item.Price2 ? "$" + item.Price2 : ''),
                "{PRICE3}": (item.Price3 ? "$" + item.Price3 : ''),
                "{VISUALORDER}": (item.VisualOrder ? item.VisualOrder : '')
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
            console.log("test data", data);
            $.each(data, function(key,item) {
                mapping = { "_IMAGE_" : item.Image, "_TITLE_" : item.Name, "_ID_" : key, "_PRICE_" : item.Price, "_DESCRIPTION_": item.Description, "_VISUALORDER_": item.VisualOrder };
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