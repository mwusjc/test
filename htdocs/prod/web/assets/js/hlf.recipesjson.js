
	hlf.recipes = {
		init: function(data) {
			this.filterListener();
			this.drawList(data);
		},

		renderSingleRecipe: function(data) {

			var currentRecipe = data[0];
			console.log('hi');
			console.log(window.location.pathname);
			var pathArray = window.location.pathname.split( '/' );
			var slug = pathArray.pop();

			mapping = {
				"_IMAGE_" : currentRecipe.image,
				"_TITLE_" : currentRecipe.title,
				"_INGREDIENTS_" : hlf.recipes.nl2br(currentRecipe.ingredients),
				"_INSTRUCTIONS_" : hlf.recipes.nl2br(currentRecipe.instructions)
			};

			html = hlf.drawTemplate("#tpl-recipe", mapping);

			$('.blah').append(html);

			// render the recommended recipes
			// shuffle and slice functions are used to pick 4 random items if there are more than 4 related
			// recipes defined in the JSON
			hlf.recipes.drawRecommended(hlf.recipes.shuffle(currentRecipe.related).slice(0,4), '.recommended');
		},

		// slightly modified version of: http://phpjs.org/functions/nl2br/
		nl2br: function(str) {
			var breakTag = '<br>';

		  return (str + '')
		    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
		},

		// http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
		shuffle: function(array) {
			var currentIndex = array.length, temporaryValue, randomIndex;

		  // While there remain elements to shuffle...
		  while (0 !== currentIndex) {

		    // Pick a remaining element...
		    randomIndex = Math.floor(Math.random() * currentIndex);
		    currentIndex -= 1;

		    // And swap it with the current element.
		    temporaryValue = array[currentIndex];
		    array[currentIndex] = array[randomIndex];
		    array[randomIndex] = temporaryValue;
		  }
		  return array;
		},

		filterListener: function() {
			var that = this;
			$('[data-filter-id]').on("click", function() {
				that.filterCategory( hlf.data.recipes, $(this).data('filter-id') );
			});

			$('[data-filter-search]').on("change keyup", function() {
			   that.filterSearch( eval($(this).data('filter-search') ), $(this).val() );
			});

		},
		filterCategory : function(data,filter) {
			var filtered = {};
			$.each(data, function(key,item) {

				// check if item category that was clicked (i.e. poultry) is in the list of categories in
				// the current item
			  if(hlf.recipes.searchCategories(filter, item.categories)) {
			  	filtered[key] = item;
			  }
			});
			this.drawList(filtered);
			$('input.search').val(null);
		},

		searchCategories: function(nameKey, myArray) {
			for (var i=0; i < myArray.length; i++) {
        if (myArray[i].slug === nameKey) {
            return true;
        }
    	}
    	return false;
		},

		filterSearch: function(data, filter) {
			var filtered = {};
			$.each(data, function(key,item) {
			   if(item.title.toLowerCase().indexOf(filter.toLowerCase()) > -1) {
				filtered[key] = item;
			   }
			});
			this.drawList(filtered);
			$('li').removeClass('active');
		},

		drawList: function(data) {
			$('.recipes-container').html(' ');
			$.each(data, function(key,item) {
				mapping = {
					"_IMAGE_" : item.image,
					"_TITLE_" : item.title,
					"_SLUG_" : item.slug
				};
				html = hlf.drawTemplate("#tpl-recipe-listing", mapping);
				$('.recipes-container').append(html);
			});
			if( $('.recipe').length == 0) {
				$('.no-results-found').removeClass('hidden');
			} else {
				$('.no-results-found').addClass('hidden');
			}
			if($('.recipe').length > 9) this.pajinate(".pajinate");
			else $('.page_navigation').html(' ');
			 $("img.lazy").lazyload({
				  placeholder : "img/grey.gif",
				  effect      : "fadeIn"
			 });
			 $(window).scroll(); // won't load images right away without this line
		},
		pajinate: function(ele) {
			$(ele).pajinate({
				'items_per_page': 9,
				'show_paginate_if_one': false
			})
		},
		drawRecommended: function(data,container) {
		  $(container).html(' ');
			$.each(data, function(key,item) {
				mapping = {
					"_IMAGE_" : item.image,
					"_TITLE_" : item.title,
					"_SLUG_" : item.slug
				};
				html = hlf.drawTemplate("#tpl-recipe-listing", mapping);
				$(container).append(html);
			});
		}
	}