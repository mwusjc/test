
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
  <a href="/assets/order-form.pdf" class="btn green" target="_blank">Download order form</a>
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
    hlf.data.platters = JSON.parse(<?php echo $platters ?>);
    
    jQuery(document).ready(function($) {
        console.log('platters JSON data', hlf.data.platters);
        var p = hlf.data.platters;
        var newArray = [];
        for(var x in p) { 
            newArray.push(p[x]); 
        }
        // Mapping revised object collection of platters
        newArray.map(function(x) {
            return x.sortOrder = parseInt(x.sortOrder);
        });
        
        // Sorting platters from result set based on value of VisualOrder column from platters table in DB
        newArray = newArray.sort(function(a, b) {
            a = a.sortOrder;
            b = b.sortOrder;
            return (a > b) ? 1 : ((b > a) ? -1 : 0);
        });

        // Make dataset match expected results
        hlf.data.platters = newArray;
        hlf.platters.init(hlf.data.platters);
    });
</script>