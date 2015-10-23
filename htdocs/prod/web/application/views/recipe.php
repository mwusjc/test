<?php

?>
</header>
<main class='recipes'>
    <h1><?=$recipe->Name?></h1>
    <div class='banner-container'>
        <div class='banner'>
            <img src="<?=site_url()?>assets/images/476444092.jpg">    
        </div>
    </div> 
    <div class='spacer'></div>
    <div class='row'>
        <div class='col-sm-4'>
            <h3>Ingredients</h3>
            <?=nl2br($recipe->Ingredients)?>
        </div>

        <div class='col-sm-8'>
            <h3>Instructions</h3>
            <?=nl2br($recipe->Directions)?>
        </div>
    </div>
    <div class='spacer-20'></div>
    <div class='row'>
        <div class='col-sm-12'><h3>You may also like...</h3></div>
        <div class='recommended'></div>
    </div>
</main>


<script type="text/html" id="tpl-recipe-listing">
    <div class="col-xs-12 col-sm-3 recipe text-center"><a href='<?=site_url()?>recipes/_ID_/_SEO_'>
        <div class='img'><img src="<?=site_url()?>assets/_IMAGE_" /></div>
        _TITLE_
        </a>
    </div>
</script>
<script type='text/javascript'>
    hlf.data.recipes = <?=json_encode($recommended)?>;                        

    jQuery(document).ready(function($) {
        hlf.recipes.drawRecommended(hlf.data.recipes, '.recommended');
    })

</script>