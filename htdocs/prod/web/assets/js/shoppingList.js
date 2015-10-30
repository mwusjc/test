var sl = {
	init: function(){
		console.log("init");      
		$(".addToCart").click(function(e){
	    	console.log("click!");
	    	sl.addProduct(sl.scrapeProduct($(e.target).closest(".modal-body")));
	    	$(e.target)[0].innerHTML = "Added";
	    	$(e.target).unbind( "click" );
	    });
	},
	shoppingList: {
		"products":[]
	},
	updateCount: function(){

	},
	getProducts: function(){
		return this.shoppingList.products
	},
	scrapeProduct: function(html){
		console.log(html);
		var prod = {}
		prod.name = html.find(".title").html();
		prod.pricing = html.find(".pricing").html();
		prod.packaging = html.find(".packaging").html();
		prod.image = html.find("img").attr("src");
		return prod;
	},
	addProduct: function(prod){
		console.log(prod);
		this.shoppingList.products.push(prod);
	}
}
