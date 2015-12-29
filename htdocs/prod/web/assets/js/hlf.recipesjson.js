
	hlf.recipes = {
		init: function(data) {
			this.filterListener();
			this.drawList(data);
		},

		testing: function(data) {
			mapping = { "_IMAGE_" : data[0].image, "_TITLE_" : data[0].title, "_INGREDIENTS_" : data[0].ingredients, "_INSTRUCTIONS_" : data[0].instructions };

			html = hlf.drawTemplate("#tpl-recipe", mapping);

			$('.blah').append(html);
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
				mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.title, "_SLUG_" : item.slug, "_SEO_" : item.seotitle, "_ID_" : item.ID };
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
				mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.title, "_SEO_" : item.seotitle, "_ID_" : item.ID };
				html = hlf.drawTemplate("#tpl-recipe-listing", mapping);
				$(container).append(html);
			});
		}
	}