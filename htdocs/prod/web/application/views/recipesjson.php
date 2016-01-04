<div class="herobanner responsive" style="background-image:url(<?=site_url()?>assets/media/recipes/rec_linguine_with_pesto.jpg); background-size:cover">
	<div class="caption col-xs-12">
		<div class="wrapper">
			<div class="row">
				<a href="/recipes/linguine-with-pesto" class="feature-title col-xs-10 col-sm-6">
					<h1>Recipe of the Week</h1>
					<h2>Linguine with Pesto</h2>
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
			<ul role="tablist" class="categories-list">
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
	<div class="col-xs-6 col-sm-4 recipe">
		<a href='<?=site_url()?>recipes/_SLUG_'>
			<div class='img'><img data-original="<?=site_url()?>assets/_IMAGE_" alt='_TITLE_' class='lazy' /></div>
			<div class="img_copy">_TITLE_</div>
		</a>
	</div>
</script>

<script type="text/html" id="tpl-category">
<li role="presentation"><a href="#" aria-controls="home" role="tab" data-toggle="tab" data-filter-id="_SLUG_">_TITLE_</a></li>
</script>

<script type='text/javascript'>

	jQuery(document).ready(function($) {
		var url = "../assets/data/recipes/recipes-v2.json";

		var xmlhttp = new XMLHttpRequest();

		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				var data = JSON.parse(xmlhttp.responseText);
				hlf.data.recipes = data;
				hlf.recipes.getFeaturedRecipe(hlf.data.recipes);
				hlf.recipes.getCategories(hlf.data.recipes);
				hlf.recipes.sortCategories('.categories-list');
				hlf.recipes.init(hlf.data.recipes);
			}
		}
		xmlhttp.send();
	});

</script>