
	hlf.recipes = {
		// myData: this.loadData(),
		init: function(data) {
			this.filterListener();
			this.drawList(data);
			this.loadData();

		},

		loadData: function() {
			// console.log(hlf.data.recipes);
			// var url = "/assets/flyers/20151210/desktop/data.json";
			var url = "/assets/data/recipes/recipes-new2.json";

			var xmlhttp = new XMLHttpRequest();

			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					var data = JSON.parse(xmlhttp.responseText);
					// console.log(data);
					hlf.data.recipes = data;
					console.log(hlf.data.recipes);
				}
			}
			xmlhttp.send();
		},

		filterListener: function() {
			var that = this;
			$('[data-filter-id]').on("click", function() {
				// console.log($(this).data('filter-id'));
				that.filterCategory( hlf.data.recipes, $(this).data('filter-id') );
			});

			$('[data-filter-search]').on("change keyup", function() {
			   that.filterSearch( eval($(this).data('filter-search') ), $(this).val() );
			});
		},
		filterCategory : function(data,filter) {
			var filtered = {};
			$.each(data, function(key,item) {
				console.log(item.image);
				// console.log(key);
				// check if item category that was clicked (i.e. poultry) is in the list of categories in item
			  if(item.category == filter) {
			  	filtered[key] = item;
			  }
			});
			this.drawList(filtered);
			$('input.search').val(null);
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
				mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.title, "_SEO_" : item.seotitle, "_ID_" : item.ID };
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