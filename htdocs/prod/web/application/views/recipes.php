
<div class="herobanner responsive">
    <img src="<?=site_url()?>assets/images/476444092.jpg">
    <div class="caption">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <h1 style="text-shadow: 1px 1px black;">Recipe of the week</h1>
                    <h2 style="text-shadow: 1px 1px black;">Beef Stroganoff</h2>
                </div>
            </div>
        </div>
    </div>    
</div>
</header>
<main class='recipes'>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h2>Good taste starts here</h2>

            <p>We don't just offer fresh food. We provide fresh ideas too. Every week we feature a new recipe. And, don't miss our tasty selection of appetizers, entrées and desserts in our recipe archive. Bon appetit! </p>
        </div>
    </div>
    <div class='spacer-20'></div>
    <div class='row'>
        <div class="col-xs-12 col-sm-12">
            <input type="text" class="search col-xs-12 col-sm-12" placeholder="What do you want to cook?" value="" data-filter-search="hlf.data.recipes">
            <button class="btn green sticky"><span class="glyphicon glyphicon-search white" aria-hidden="true"></span></button>
        </div>
    </div>
          <div class='spacer-20'></div>
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <ul role="tablist">
            <?php foreach($recipes_categories AS $key=>$item) : ?>
                <li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab" data-filter-id='<?=$item->ID?>'><?=$item->Name?></a></li>
                <?PHP endforeach; ?>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9">
             <div class='pajinate'>
             <div class='no-results-found hidden'><h1>Sorry! Nothing to be found here.</h1></div>
            <div class="row recipes-container content">
                

        <!--        <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/177275363.jpg" /></div>
                    Pasta Primevara
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/480928701.jpg" /></div>
                    Cheese Linguini
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/476444092.jpg" /></div>
                    Beef Stroganoff
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/474947341.jpg" /></div>
                    Tuna Linguini
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/179229184.jpg" /></div>
                    Salmon Linguini
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/468017321.jpg" /></div>
                    Calamary Pasta
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/470822257.jpg" /></div>
                    Pesto Linguini
                </div>
                <div class="col-xs-12 col-sm-4 recipe">
                    <div class='img'><img src="<?=site_url()?>assets/images/121268869-1.jpg" /></div>
                    Chicken Lasagna
                </div>  -->
            </div> 
            <div class="page_navigation"></div>
            </div>
        </div>
    </div>
</main>


<script type="text/html" id="tpl-recipe-listing">
    <div class="col-xs-12 col-sm-4 recipe"><a href='<?=site_url()?>recipes/_ID_/_SEO_'>
        <div class='img'><img data-original="<?=site_url()?>assets/_IMAGE_" class='lazy' /></div>
        <div class="img_copy">_TITLE_</div>
        </a>
    </div>
</script>
<script type='text/javascript'>
    hlf.data.recipes = <?=json_encode($recipes)?>;
    hlf.data.recipes_categories = <?=json_encode($recipes_categories)?>;
    
    jQuery(document).ready(function($) {
        hlf.recipes.init(hlf.data.recipes);
    })

</script>