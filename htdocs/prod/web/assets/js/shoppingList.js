var sl = {
	init: function(){ 
		var shoplistinit = {"products":[]};
		localStorage.getItem("shoppingList")? console.log("Shopping list exists") : localStorage.setItem("shoppingList",JSON.stringify(shoplistinit));   
		this.updateCount();
		$(document).on("click",".addToCart",function(e){
	    	sl.addProduct(sl.scrapeProduct($(e.target).closest(".modal-body")));
	    	$(e.target)[0].innerHTML = "Added";
	    	$(e.target).unbind( "click" );
	    });
	},
	updateCount: function(){
		var prod = sl.getProducts();
		$(".items-in-cart")[0].innerHTML = prod.length;
	},
	getProducts: function(){
		return JSON.parse(localStorage.shoppingList).products
	},
	setProducts: function(prod){
		var shoplistinit = {"products":prod};
		localStorage.setItem("shoppingList",JSON.stringify(shoplistinit));
	},
	clearProducts: function(){
		localStorage.setItem("shoppingList",JSON.stringify(shoplistinit))
		sl.updateCount();
		$(".shoppingListWrapper")[0].innerHTML = "<h2>You currently have nothing in your list.</h2>";
	},
	populateShoppingList: function(){
		var p = sl.getProducts();
		var html = "";
		if(!p || p.length == 0){
			html = "<h2>You currently have nothing in your list.</h2>";
		}
		else{
			for (var i=0; i < p.length; i++){
				var prod = p[i];
				var brandstring = "";
				html+=  	'<div class="row" data-category="'+prod.category+'" data-brand="'+brandstring+'">'
				html+=	    '	<div class="col-xs-12 col-sm-3 text-center">'
//				html+=	    '		<img class="image" src="/assets/images/'+prod.image+'">'
				html+=	    '		<img class="image" src="/assets/images/121268869-1.jpg">'
				html+=	    '	</div>'
				html+=	    '	<div class="col-xs-12 col-sm-9">'
				html+=	    '		<h2 class="title">'+prod.name+'</h2>' 
				html+=	    '		<span class="pricing">$'+prod.pricing+'</span>'
				html+=	    '		<span class="packaging">'+prod.packaging+'</span>'
				html+=	    '	</div>'
				html+=		'</div>'   
			}
		}
		$(".shoppingListWrapper")[0].innerHTML = html;
	},
	cleanup: function(){
		var p = sl.getProducts();
		var clean = [];
		for (var i = 0; i < p.length; i++){
			var duplicate = false;
			for (var j = 0; j < clean.length; j++){
				duplicate = clean[j].name == p[i].name? true: false;
			}
			if (!duplicate){
				clean.push(p[i]);
			}
		}
		sl.setProducts(clean);

	},
	scrapeProduct: function(html){
		var prod = {}
		prod.name = html.find(".title").html();
		prod.pricing = html.find(".pricing").html();
		prod.packaging = html.find(".packaging").html();
		prod.image = html.find("img").attr("src");
		return prod;
	},
	addProduct: function(prod){
		var products = sl.getProducts()
		products.push(prod);
		sl.setProducts(products);
		sl.cleanup();
		sl.updateCount();
	}
}
