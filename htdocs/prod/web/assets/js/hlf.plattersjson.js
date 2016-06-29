
  hlf.platters = {
    init: function(data) {
      this.filterListener();
      this.drawList(data);
      this.setListeners();  
    },
    
    filterListener: function() {  
      var that = this; 
      $('[data-filter-id]').on("click", function() {
         that.filterCategory( hlf.data.platters, $(this).data('filter-id') );
      });
    },

    getCategories: function(data) {
      var plattersLength = hlf.data.platters.length;
      var categories = [];

      // Loop through all platters and retrieve unique category values
      for(var i=0; i < plattersLength; i++) {
        if(categories.indexOf(hlf.data.platters[i].category === -1)) {
          // We have a unique value
          categories.push(hlf.data.platters[i].category);
        }

        // Not sure why yet, but this logic appears to work when looking to only return unique values in comparison to the if block above
        // Solution derived from http://stackoverflow.com/questions/13486479/how-to-get-an-array-of-unique-values-from-an-array-containing-duplicates-in-java
        categories = categories.reverse().filter(function (element, index, categories) {
            return categories.indexOf(element, index+1) === -1;
        }).reverse();
      }
      console.log('unique categories', categories);

      // Populate the categories list based on unique array
      for(var j=0; j < categories.length; j++) {
        $('ul[role="tablist"]').append('<li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab" data-filter-id="">' + categories[j] + '</a></li>');
      }

      // Reorder the categories list to match current visual order
      this.orderCategories(categories, 1, 1);
    },

    // Try to visually order categories by modifying array
    orderCategories: function(categoriesArray, value, changeAmount) {
      var oldIndex = categoriesArray.indexOf(value);
      if(oldIndex > -1) {
        var newIndex = (oldIndex + changeAmount);

        if(newIndex < 0) {
          newIndex = 0;
        }
        else if(newIndex >= categoriesArray.length) {
          newIndex = categoriesArray.length;
        }

        var categoriesClone = categoriesArray.slice();
        categoriesClone.splice(oldIndex, 1);
        categoriesClone.splice(newIndex, 0, value);

        return categoriesClone;
      }

      return categoriesArray;
    },

    filterCategory : function(data,filter) {    
      var filtered = {};
      $.each(data, function(key,item) {
         if(item.CategoryID == filter) {
          filtered[key] = item;   
         } 
      });
      this.drawList(filtered);
      $('input.search').val(null);
    }, 

    togglePopup: function(id) {
      $('#detailModal.otu').remove();  // remove all modal instances (one time use)
      var item = hlf.data.platters[id];
      mapping = { 
          "{IMG}" : "<?=site_url() ?>"+"assets/"+item.image,
          "{QTY}" : (item.Quantity ? item.Quantity : ''), 
          "{QTY2}" : (item.Quantity2 ? item.Quantity2 : ''), 
          "{QTY3}" : (item.Quantity3 ? item.Quantity3 : ''), 
          "{QTY_TYPE}" : (item.Qty_type ? item.Qty_type : ''), 
          "{TITLE}": item.name, 
          "{SUBTITLE}": (item.Subtitle ? item.Subtitle : ''), 
          "{DESCRIPTION}": item.description, 
          "{ID}": item.id,
          "{PRICE}": (item.Price ? "$" + item.Price : ''),
          "{PRICE2}": (item.Price2 ? "$" + item.Price2 : ''),
          "{PRICE3}": (item.Price3 ? "$" + item.Price3 : ''),
          "{SORTORDER}": (item.sortOrder ? item.sortOrder : '')
      };
      html = hlf.drawTemplate("#tpl-product-modal", mapping);

      $('body').append(html);
      $('#detailModal').modal('show');  
    },

    setListeners: function() {
      var that = this;
      $(document).on('click', '[data-toggle-details]', function(e) {
          e.preventDefault();
          that.togglePopup( $(this).data("toggle-details") ); 
      });
            
      $('body').on("click", '[data-add-cart]', function(e) {
         e.preventDefault(); 
         var id = $(this).data("add-cart");
         
         $.post('/shopping/add/', {"id": id},  function(response) {
            console.log(response); 
         }).fail(function() {
            alert("Unfortunately something went wrong! Please try again."); 
         });
         
      });
    },

    drawList: function(data) { 
      $('.platters-container').html(' ');
      $.each(data, function(key,item) {
          mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.name, "_PRICE_" : item.Price, "_DESCRIPTION_": item.description, "_SORTORDER_": item.sortOrder };
          html = hlf.drawTemplate("#tpl-platter-listing", mapping);
          $('.platters-container').append(html);
      });
      if( $('.platter').length == 0) {
        $('.no-results-found').removeClass('hidden');
      } 
      else {
        $('.no-results-found').addClass('hidden');
      }
      if($('.platter').length > 9) {
        this.pajinate(".pajinate");
      }
      else {
        $('.page_navigation').html(' ');
      }
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
    }
  }