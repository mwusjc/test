
  hlf.platters = {
    init: function(data) {
      this.filterListener();
      this.drawList(data);
    },

    getCategories: function(data) {

      var categories = [];

      //iterate over each platter
      $.each(data, function(key,item) {

        //iterate over each category in the recipe
        $.each(item.categories, function(key2,category) {

          if (!(hlf.platters.searchCategories(category, categories))) {
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

    // slightly modified version of: http://phpjs.org/functions/nl2br/
    nl2br: function(str) {
      var breakTag = '<br>';

      return (str + '')
        .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    },

    filterListener: function() {
      var that = this;
      $('[data-filter-id]').on("click", function() {
        that.filterCategory( hlf.data.recipes, $(this).data('filter-id') );
      });

      $('[data-filter-search]').on("change keyup", function() {
         that.filterSearch( hlf.data.recipes, $(this).val() );
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
          "_THUMBNAIL_" : item.thumbnail,
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
    }
  }