
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
          "{IMG}" : "<?=site_url() ?>"+"assets/"+item.Image,
          "{QTY}" : (item.Quantity ? item.Quantity : ''), 
          "{QTY2}" : (item.Quantity2 ? item.Quantity2 : ''), 
          "{QTY3}" : (item.Quantity3 ? item.Quantity3 : ''), 
          "{QTY_TYPE}" : (item.Qty_type ? item.Qty_type : ''), 
          "{TITLE}": item.Name, 
          "{SUBTITLE}": (item.Subtitle ? item.Subtitle : ''), 
          "{DESCRIPTION}": item.Description, 
          "{ID}": item.id,
          "{PRICE}": (item.Price ? "$" + item.Price : ''),
          "{PRICE2}": (item.Price2 ? "$" + item.Price2 : ''),
          "{PRICE3}": (item.Price3 ? "$" + item.Price3 : ''),
          "{VISUALORDER}": (item.VisualOrder ? item.VisualOrder : '')
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
          mapping = { "_IMAGE_" : item.image, "_TITLE_" : item.Name, "_ID_" : key, "_PRICE_" : item.Price, "_DESCRIPTION_": item.Description, "_VISUALORDER_": item.VisualOrder };
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