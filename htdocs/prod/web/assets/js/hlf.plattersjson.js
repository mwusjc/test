
  hlf.platters = {
    // Make categories global
    categories: [],

    init: function(data) {
      this.filterListener();
      this.drawList(data);
      this.setListeners();  
    },

    getCategories: function(data) {
      var plattersLength = hlf.data.platters.length;
      // var categories = [];

      // Loop through all platters and retrieve unique category values
      for(var i=0; i < plattersLength; i++) {
        if(this.categories.indexOf(hlf.data.platters[i].category === -1)) {
          // We have a unique value
          this.categories.push(hlf.data.platters[i].category);
        }

        // Not sure why yet, but this logic appears to work when looking to only return unique values in comparison to the if block above
        // Solution derived from http://stackoverflow.com/questions/13486479/how-to-get-an-array-of-unique-values-from-an-array-containing-duplicates-in-java
        this.categories = this.categories.reverse().filter(function (element, index, categories) {
          return categories.indexOf(element, index+1) === -1;
        }).reverse();
      }

      // Reorder the elements of the categories list to match required visual order
      // Required visual order is as follows: 
      /* 
        Breakfast Bites
        Appetizers
        Deli, Cheese & Vegetables
        Party Platters
        Fabulous Fruits
        Divine Desserts
        Special Order Cakes
        Flowers & Gift Baskets
      */

      // Derived from recommended solution at http://stackoverflow.com/questions/2440700/reordering-arrays for how to reorder elements of array
      // TO-DO: Preferably move away from using classname.prototype for custom functionality in future
      Array.prototype.move = function(fromIndex, toIndex) {
        this.splice(toIndex, 0, this.splice(fromIndex, 1)[0]);
      };

      // Adjusting necessary indices
      this.categories.move(1, 2);
      this.categories.move(7, 3);
      this.categories.move(3, 5);
      this.categories.move(5, 3);
      this.categories.move(6, 7);

      // Populate categories list based on reordered array
      for(var j=0; j < this.categories.length; j++) {
        // TO-DO: Optimize the string manipulation done for data-filter-id so that multiple functions are not chained for lowercasing, replacement of spaces with dashes, removal of commas, and removal of ampersands (matches the order of operations below)
        $('ul[role="tablist"]').append('<li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab" data-filter-id=' + this.categories[j].toLowerCase().replace(/\s+/g, "-").replace(/,/g,'').replace(/\&-/g, '') + '>' + this.categories[j] + '</a></li>');
      }
    },

    filterListener: function() {  
      var that = this; 
      $('[data-filter-id]').on("click", function() {
        that.filterCategory( hlf.data.platters, $(this).data('filter-id') );
      });
    },

    filterCategory : function(data,filter) {    
      var filtered = {};
      // Loop though platters data and match categories to individual platters when filtering
      $.each(data, function(key, item) {
        if(hlf.platters.searchCategories(filter, item.category)) {
          filtered[key] = item;
        }
      });
      // Re-render visual list of platters based on selected category
      this.drawList(filtered);
    }, 

    searchCategories: function(categorySlug, categoryName) {
      // Loop though platters and match currently selected category to relevant platters
      for (var i=0; i < categoryName.length; i++) {
        // Create category slug from plain English name (Eg. breakfast-bites from Breakfast Bites)
        var currentPlatterCategory = categoryName.toLowerCase().replace(/\s+/g, "-").replace(/,/g,'').replace(/\&-/g, '');
        if (currentPlatterCategory === categorySlug) {
          return true;
        }
      }
    },

    togglePopup: function(name) {
      // remove all modal instances (one time use)
      $('#detailModal.otu').remove();

      var item;
      var plattersLength = hlf.data.platters.length;
      // Loop through platters and find one which matches the name of the one clicked
      for(var i=0; i < plattersLength; i++) {
        item = hlf.data.platters[i];
        
        // When matching platter name is found from that which was clicked, populate modal template with corresponding data and add to DOM
        if(item.name === name) {
          // Loop through all properties
          for(var property in item) {
            if(item.hasOwnProperty(property)) {
              // Check for sizes array when looping through platter properties and gather info including price and serving capacity
              if(property === 'sizes') {
                // Loop through entries in sizes array and populate platter template mapping accordingly
                for(var j=0; j < item['sizes'].length; j++) {
                  // Populate and draw modal template
                  mapping = { 
                    "{IMG}" : "assets/" + item.image,
                    "{QTY}" : (item.quantity ? item.quantity : ''), 
                    "{TITLE}": (item.name ? item.name : ''), 
                    "{DESCRIPTION}": (item.description ? item.description : ''), 
                    "{SORTORDER}": (item.sortOrder ? item.sortOrder : '')
                  };

                  // Map nested object data to item
                  item.size = item['sizes'][j]['size'];
                  item.container = item['sizes'][j]['container'];
                  item.unit = item['sizes'][j]['unit'];
                  item.price = item['sizes'][j]['price'];
                  item.serves = item['sizes'][j]['serves'];
                }
              }
            }
          }
          html = hlf.drawTemplate("#tpl-product-modal", mapping);
          // Add modal template to DOM
          $('body').append(html);
          
          // Populate modal pricing section based on available data
          var detailModalPricing = document.querySelector('#detailModal .platter-chart');
          var spaceChar = '&nbsp;'

          // TO-DO: Clean this up to avoid mostly repated logic from above for accessing price data
          for(var property in item) {
            if(item.hasOwnProperty(property)) {
              if(property === 'sizes') {
                // Loop through entries in sizes array and populate pricing section based on different sizes available
                for(var j=0; j < item['sizes'].length; j++) {
                  // Check for items that do not have a set price (Eg. Gift Card)
                  if(item['sizes'][j]['price'] === null || (item['sizes'][j]['price'] === undefined)) {
                    detailModalPricing.innerHTML = detailModalPricing.innerHTML;
                  }
                  else {
                    // Continue with displaying all available price data for chosen item
                    // Ternary operators are used here to determine whether or not to add a table data cell based on available info
                    var itemSize = item['sizes'][j]['size'] ? '<td>' + item['sizes'][j]['size'] + spaceChar + item['sizes'][j]['unit'] + '</td>': '';
                    var itemServes = item['sizes'][j]['serves'] ? '<td>' + item['sizes'][j]['serves'] + '</td>': '';
                    var itemPrices = item['sizes'][j]['price'] ? '<td>' + '$' + item['sizes'][j]['price'] + '</td>': '';
                    detailModalPricing.innerHTML += '<tr>' + itemSize + itemServes + itemPrices + '</tr>'; 
                  }
                }
              }
            }
          }

          $('#detailModal').modal('show');
          return true;
        }
        else {
          // Using continue here so that data for any platter can be retrieved for modal by continuing to iterate through platters data until match is found, 
          // rather than return false which would stop execution and cause unexpected behaviour from user perspective
          continue;
        }
      }

        
    },

    setListeners: function() {
      var that = this;
      $(document).on('click', '[data-platter-name]', function(e) {
          e.preventDefault();
          that.togglePopup( $(this).data("platter-name") ); 
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
          mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.name, "_PRICE_" : item.Price, "_DESCRIPTION_": item.description, "_SORTORDER_": item.sortOrder};
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