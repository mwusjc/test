
	hlf.recipes = {
		init: function(data) {
			this.filterListener();
			this.drawList(data);
		},

		getFeaturedRecipe: function(data) {

			var currentDate = new Date();

			// all the recipes in which the currentDate is greater than the recipe featuredStartTime.
			var previousDates = data.filter(function(item) {
				return currentDate >= new Date(item.featuredStartDate);
			});

			// sort the dates in ascending order
			var sorted = previousDates.sort(function(a,b) {
				return new Date(a.featuredStartDate).getTime() - new Date(b.featuredStartDate).getTime();
			});

			// the featured recipe is the last element of the array
			var featuredRecipe = sorted.pop();

			mapping = {
				"_TITLE_" : featuredRecipe.title,
				"_SLUG_" : featuredRecipe.slug,
				"_IMAGE_" : featuredRecipe.image
			};
			html = hlf.drawTemplate("#tpl-featured-recipe", mapping);
			$('.featured-recipe').append(html);

		},

		getCategories: function(data) {

			var categories = [];

			//iterate over each recipe
			$.each(data, function(key,item) {

				//iterate over each category in the recipe
				$.each(item.categories, function(key2,category) {

					if (!(hlf.recipes.searchCategories(category.slug, categories))) {
						categories.push(category);
						mapping = {
							"_TITLE_" : category.title,
							"_SLUG_" : category.slug
						};
						html = hlf.drawTemplate("#tpl-category", mapping);
						$('.categories-list').append(html);
					}
				});
			});

		},

		sortCategories: function(selector) {
			var mylist = $(selector);
			var listitems = mylist.children('li').get();
			listitems.sort(function(a, b) {
			   return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
			})
			$.each(listitems, function(index, item) { mylist.append(item); });
		},

		renderSingleRecipe: function(data) {

			var pathArray = window.location.pathname.split( '/' );
			var slug = pathArray.pop();

			var index = hlf.recipes.getRecipeIndex(data, slug);

			mapping = {
				"_IMAGE_" : data[index].image,
				"_TITLE_" : data[index].title,
				"_INGREDIENTS_" : hlf.recipes.nl2br(data[index].ingredients),
				"_INSTRUCTIONS_" : hlf.recipes.nl2br(data[index].instructions)
			};

			html = hlf.drawTemplate("#tpl-recipe", mapping);

			$('.recipe').append(html);

			// render the recommended recipes
			// shuffle and slice functions are used to pick 4 random items if there are more than 4 related
			// recipes defined in the JSON
			hlf.recipes.drawRecommended(hlf.recipes.shuffle(data[index].related).slice(0,4), '.recommended');
		},

		getRecipeIndex: function(data, searchTerm) {
			for (var i=0; i < data.length; i++) {
        if (data[i].slug === searchTerm) {
            return i;
        }
    	}
    	return -1;
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