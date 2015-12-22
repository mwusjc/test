var carousel = {
	init: function(currentTime) {
		this.loadData();

	},
	loadData: function() {
		var url = "/assets/data/carousel/carousel.json";
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				var data = JSON.parse(xmlhttp.responseText);

				carousel.render(data);
			}
		}
		xmlhttp.send();
	},
	render: function(data) {

		// iterate through carousels, if current time is greater than start-time, use that carousel
		$.each(data, function(key,item) {

			var d1 = new Date(carousel.currentTime);
			var d2 = new Date(item.startDate);


			// found the current carousel we should be rendering
			if (d1.getTime() > d2.getTime()) {

				$.each(item.slides, function(key2,slide) {

					// render the correct template based on the slide number.
					if (slide.order === 0) {
						mapping = {
							"_desktopSlideBackground_" : item.slides[slide.order].desktopSlideBackground,
							"_desktopSideImage_" : item.slides[slide.order].desktopSideImage,
							"_featuredDescription_" : item.slides[slide.order].featuredDescription,
							"_link_" : item.slides[slide.order].link,
							"_mobileSlideBackground_" : item.slides[slide.order].mobileSlideBackground,
							"_desktopSideImageStyles_" : item.slides[slide.order].desktopSideImageStyles
						};
						html = hlf.drawTemplate("#slide-feature", mapping);
						$('.carousel-inner').append(html);

						// don't show image if there is none!
				  	if(item.slides[slide.order].desktopSideImage == null ||
				  		item.slides[slide.order].desktopSideImage.trim() == "") {
	        		$('.item-1-img').remove();
	        	}

					} else if (slide.order === 1 || slide.order === 2) {
							mapping = {
								"_desktopSlideBackground_" : item.slides[slide.order].desktopSlideBackground,
								"_link_" : item.slides[slide.order].link,
								"_mobileSlideBackground_" : item.slides[slide.order].mobileSlideBackground,
								"_description_" : item.slides[slide.order].description,
								"_descriptionSubtext_" : item.slides[slide.order].descriptionSubtext,
								"_desktopPriceImage_" : item.slides[slide.order].desktopPriceImage,
						};
						html = hlf.drawTemplate("#slide-dow-inline", mapping);
						$('.carousel-inner').append(html);
					} else if (slide.order >= 3) {
							mapping = {
								"_desktopSlideBackground_" : item.slides[slide.order].desktopSlideBackground,
								"_link_" : item.slides[slide.order].link,
								"_mobileSlideBackground_" : item.slides[slide.order].mobileSlideBackground,
								"_desktopPriceImage_" : item.slides[slide.order].desktopPriceImage
							};
							html = hlf.drawTemplate("#slide-dow", mapping);
							$('.carousel-inner').append(html);
					}

					// add carousel dots dynamically
					if (slide.order === 0) {
						$('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + slide.order + '" class="active" style="margin-left: 4px"></li>');
					} else {
						$('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + slide.order + '" style="margin-left: 4px"></li>');
					}
				});

				// do not continue iterating through list
				return false;
			}

    });
	}
}