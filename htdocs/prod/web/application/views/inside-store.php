<?php
// :|
$inside = array();

$inside[] = array(     "title" => "Bakery",     "subtitle" => "Find Your
Slice of Heaven",     "description" => "Follow your nose to the bakery where
you'll find freshly baked breads and all sorts of sweet temptations. Having a
celebration? Stop by our bakery with your special order.",     "image" =>
"assets/images/store_bakery_web_crop.jpg",     "class" => "brown" );

$inside[] = array(     "title" => "Dairy",     "subtitle" => "Dairy
Goodness",     "description" => "We have a wide selection of farm fresh dairy products including yogurt, milk, cheeses and spreads, as well as an extensive line-up of non-dairy and organic alternatives.",     "image" =>
"assets/images/store_dairy_web_crop.jpg",     "class" => "blue" );

$inside[] = array(     "title" => "Deli",     "subtitle" => "Always a
Cut Above",     "description" => "Visit our deli counter for a traditional market experience. Deli meats and cheeses are cut-to-order by our friendly staff. You'll also find a mouth-watering selection of olives, antipastos and fresh deli salads.",     "image" =>
"assets/images/store_deli_web_crop.jpg",     "class" => "orange" );

$inside[] = array(     "title" => "Seafood",     "subtitle" => "Fish for Flavour",     "description" => "Our fish counter is a seafood lover's dream. Every day, you'll find a fresh selection of fish. If you have any questions, don't hesitate to ask one of our knowledgeable fishmongers.",     "image" => "assets/images/store_seafood_web_crop.jpg",
"class" => "teal" );

$inside[] = array(     "title" => "Flowers",     "subtitle" => "In Full Bloom",     "description" => "Stop by our flower shop for potted plants and beautiful blooms. Ask our specially trained assistants to put together a customized bouquet.",     "image" =>
"assets/images/store_flowers_web_crop.jpg",     "class" => "lightgreen" );

$inside[] = array(     "title" => "Groceries",     "subtitle" => "Selection to suit every taste",     "description" => "As the innovator of the ultimate one-stop supermarket, we are committed to bringing you the widest range of groceries, all while saving you money every day.",     "image" => "assets/images/93472004.jpg",     "class" =>
"green" );

$inside[] = array(     "title" => "Meat",     "subtitle" => "A Cut Above",     "description" => "At our meat department you'll get prime cuts of fresh meat, weighed and packaged right before your eyes. Our friendly staff will ensure you get exactly what you want, including invaluable cooking advice.",     "image"
=> "assets/images/store_meat_web_crop.jpg",     "class" => "red" );

$inside[] = array(     "title" => "Natural &amp; Wellness",     "subtitle" =>
"For Your Natural Lifestyle",     "description" => "We know that offering organic and natural choices is important to our customers. Everything from cereals to soya ice creams – you'll find hundreds of items at a great price.",     "image"
=> "assets/images/177555175.jpg",     "class" => "natural" );

$inside[] = array(     "title" => "Country Kitchen",     "subtitle" => "No Time to Cook? We're Here to Help",     "description" => "Don't worry if you're running a little late. Our talented cooks whip up fresh and delicious meals such as chicken, ribs, pasta and a variety of sides – all ready to serve at a low price and great taste. Let us take care of dinner tonight!",     "image" =>
"assets/images/store_prepared_web_crop.jpg",     "class" => "gingham" );

$inside[] = array(     "title" => "Produce",     "subtitle" => "The Freshest Produce",     "description" => "The size, selection and value of our produce department is unsurpassed. Everything is hand-picked every day at the Ontario Food Terminal from local and international farmers, bringing you the freshest produce at the best prices possible.",     "image" => "assets/images/store_produce_web_crop.jpg",
"class" => "lightgreen" );

$inside[] = array(     "title" => "Sushi",     "subtitle" => "Fresh and Ready to Roll",     "description" => "In the mood for some Japanese? We offer fresh sushi to satisfy your cravings. Packaged and ready to enjoy, Highland Farms gives you a taste of Japan without the cost of expensive specialty restaurants.",     "image" =>
"assets/images/store_sushi_web_crop.jpg",     "class" => "black" ); 

$inside[] = array(     "title" => "Poultry",     "subtitle" => "Discover our juicy selection",
"description" => "Succulent and flavourful, our poultry selection will get your mouth watering. We have all your favourite cuts, from classic wings to boneless chicken breast. No time to marinate? No problem! We have a variety of freshly pre-marinated meats. ",     "image" =>
"assets/images/store_poultry_web_crop.jpg",     "class" => "yellow" );

?>
</header>
<main>
    <div class="row">
        <div class="col-xs-12 col-sm-12"><h1 style="margin-bottom: 0px;">Inside the Store</h1></div>
    </div>

    <div class="row inside-store-container"> 
           Loading...
      </div>
</main>


<script type='text/template' id='tpl-inside-store-collapsed'>
<div class='inside-store-item-container' >
    <div class="inside-store-item" data-istore-id="{ID}">
            <div class='img'><img src="<?=site_url()?>{IMG}" /></div>
            <div class="box bottom title {CLASS}">{TITLE}</div>
        </div>
</div>
</script>
<script type='text/template' id='tpl-inside-store-details'>
       <div id="details" class="row nopadding border border-bottom fade"> 
        <div class="col-xs-12 col-sm-7">
            <img src="<?=site_url()?>{IMG}"/>
        </div>
        <div class="col-xs-12 col-sm-5 details">
            <h1>{TITLE}</h1>
            <h2>{SUBTITLE}</h2>
            <p>{DESCRIPTION}</p>
            <span class="glyphicon glyphicon-remove close"></span>
        </div>
        <div class="col-xs-12 col-sm-12"><h4 class="box bottom brown"> </h1></div>
    </div>
</script>
<script type='text/javascript'>
    
    hlf.data.istore = <?=json_encode($inside)?>;

    

    hlf.istore = {
        init: function(data) {
            this.container = '.inside-store-container';
            this.drawListings(data);
            this.setListeners();
        },

        drawListings: function(data) {
            var container = this.container;
            $(container).html(' ');

            var count = 1;
            $.each(data, function(key,item) {
                mapping = { "{IMG}" : item.image, "{TITLE}" : item.title, "{CLASS}" : item.class, "{ID}" : key };
                html = hlf.drawTemplate("#tpl-inside-store-collapsed", mapping); 
                $(container).append(html);
            });
        },
        drawDetails: function(id) {
            var item = hlf.data.istore[id];

            mapping = { "{IMG}" : item.image, "{TITLE}" : item.title, "{SUBTITLE}": item.subtitle, "{DESCRIPTION}": item.description, "{CLASS}" : item.class, "{ID}" : id };
            html = hlf.drawTemplate("#tpl-inside-store-details", mapping); 

            $('#details').remove();   
            // get the index, place it at the start of the row...
            var divisible = id % 3;
            var index = id - divisible;
            $('[data-istore-id="'+index+'"]').parent('.inside-store-item-container').before(html);
            $('#details').slideDown();
            window.setTimeout("$('#details').addClass('in');", 75);
            // make the rest.. low opacity
            $('.inside-store-item-container').css('opacity',0.2);
        },
        setListeners: function() {
            var that = this;
            $('.inside-store-container').on("click", '[data-istore-id]', function() {
                var id = $(this).data("istore-id"); 
                that.drawDetails(id);                   
            });

            $('.inside-store-container').on("click", 'span.close', function() {
                $('#details').slideUp();
                $('.inside-store-item-container').css('opacity',1);
            });
        }
    }
        
    jQuery(document).ready(function() { 
        hlf.istore.init(hlf.data.istore);
    });
</script>