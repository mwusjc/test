</header>
<div class="recipe"></div>

<script type="text/html" id="tpl-recipe">
	<main class='recipes'>
		<h1>_TITLE_</h1>
		<div class='banner-container'>
			<div class='banner' style="background-image:url(<?=site_url()?>assets/_IMAGE_); background-size:cover"></div>
		</div>
		<div class='spacer'></div>
		<div class='row'>
			<div class='col-sm-4'>
				<h3>Ingredients</h3>
				<p>_INGREDIENTS_</p>
			</div>

			<div class='col-sm-8'>
				<h3>Instructions</h3>
				<p>_INSTRUCTIONS_</p>
			</div>
		</div>
		<div class='spacer-20'></div>
		<div class='row'>
			<div class='col-sm-12'><h3>You may also like...</h3></div>
			<div class='recommended'></div>
		</div>
	</main>
</script>

<script type="text/html" id="tpl-recipe-listing">
	<div class="col-xs-12 col-sm-3 recipe text-center">
		<a href='<?=site_url()?>recipes/_SLUG_'>
		<div class='img'><img src="<?=site_url()?>assets/_IMAGE_" /></div>
		_TITLE_
		</a>
	</div>
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
				hlf.recipes.renderSingleRecipe(hlf.data.recipes);

			}
		}
		xmlhttp.send();
	})

</script>