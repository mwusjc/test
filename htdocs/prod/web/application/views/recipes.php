
<div class="herobanner responsive" style="background-image:url(<?=site_url()?>assets/media/recipes/rec_creme_brulee.jpg); background-size:cover">
    <div class="caption col-xs-12">
        <div class="wrapper">
            <div class="row">
                <a href="/recipes/362/Creme-Brulee" class="feature-title col-xs-10 col-sm-6">
                    <h1>Recipe of the Week</h1>
                    <h2>Creme Brulee</h2>
                </a>
            </div>
        </div>
    </div>    
</div>
</header>
<main class='recipes'>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h1>Good taste starts here</h1>

            <h2>We don't just offer fresh food. We provide fresh ideas too. Every week we feature a new recipe. And, don't miss our tasty selection of appetizers, entrées and desserts in our recipe archive. <br/>Bon appetit! </h2>
        </div>
    </div>
    <div class='spacer-20'></div>
    <div class='row'>
        <div class="col-xs-12 col-sm-12">
            <input type="text" class="search col-xs-12 col-sm-12" aria-label="What do you want to cook?" placeholder="What do you want to cook?" value="" data-filter-search="hlf.data.recipes">
            <button class="btn green sticky search"><span class="glyphicon glyphicon-search white" aria-hidden="true"></span></button>
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
            </div> 
            <div class="page_navigation"></div>
            </div>
        </div>
    </div>
</main>


<script type="text/html" id="tpl-recipe-listing">
    <div class="col-xs-6 col-sm-4 recipe"><a href='<?=site_url()?>recipes/_ID_/_SEO_'>
        <div class='img'><img data-original="<?=site_url()?>assets/_IMAGE_" alt='_TITLE_' class='lazy' /></div>
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