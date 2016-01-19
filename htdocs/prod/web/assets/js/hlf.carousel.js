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

    // iterate through carousels, if current time is greater than start-time of current carousel,
    // use that carousel
    $.each(data, function(key,item) {
      var d1 = new Date(carousel.currentTime);
      var d2 = new Date(item.startDate);

      // found the current carousel we should be rendering
      if (d1 > d2) {

        // iterate through the slides of the current carousel
        $.each(item.slides, function(key2,slide) {

          // render the template
          mapping = {
            "_slideID_" : item.slides[key2].slideID,
            "_link_" : item.slides[key2].link,
            "_desktopSlideBackground_" : item.slides[key2].desktopSlideBackground,
            "_mobileSlideBackground_" : item.slides[key2].mobileSlideBackground,
            "_backgroundSize_" : item.slides[key2].backgroundSize,
            "_containerCSS_" : item.slides[key2].containerCSS != null ? item.slides[key2].containerCSS : "",
            "_headingContainerCSS_" : item.slides[key2].headingContainerCSS != null ? item.slides[key2].headingContainerCSS : "display:none",
            "_headingContainerMobileCSS_" : item.slides[key2].headingContainerMobileCSS != null ? item.slides[key2].headingContainerMobileCSS : "display:none",
            "_heading_" : item.slides[key2].heading != null ? item.slides[key2].heading : "",
            "_headingCSS_" : item.slides[key2].headingCSS != null ? item.slides[key2].headingCSS : "display:none",
            "_headingMobileCSS_" : item.slides[key2].headingMobileCSS != null ? item.slides[key2].headingMobileCSS : "display:none",
            "_subheading_" : item.slides[key2].subheading != null ? item.slides[key2].subheading : "",
            "_subheadingCSS_" : item.slides[key2].subheadingCSS != null ? item.slides[key2].subheadingCSS : "display:none",
            "_subheadingMobileCSS_" : item.slides[key2].subheadingMobileCSS != null ? item.slides[key2].subheadingMobileCSS : "display:none",
            "_imageOverlay_" : item.slides[key2].imageOverlay != null ? item.slides[key2].imageOverlay : "",
            "_imageOverlayCSS_" : item.slides[key2].imageOverlayCSS != null ? item.slides[key2].imageOverlayCSS : "display:none",
            "_textOverlay_" : item.slides[key2].textOverlay != null ? item.slides[key2].textOverlay : "",
            "_textOverlayCSS_" : item.slides[key2].textOverlayCSS != null ? item.slides[key2].textOverlayCSS : "display:none",
            "_priceImage_" : item.slides[key2].priceImage != null ? item.slides[key2].priceImage : "",
            "_badge1_" : item.slides[key2].badges[0] != undefined ? item.slides[key2].badges[0].image : "",
            "_badge1CSS_" : item.slides[key2].badges[0] != undefined ? item.slides[key2].badges[0].css : "display:none",
            "_badge1MobileCSS_" : item.slides[key2].badges[0] != undefined ? item.slides[key2].badges[0].mobileCSS : "display:none",
            "_badge2_" : item.slides[key2].badges[1] != undefined ? item.slides[key2].badges[1].image : "",
            "_badge2CSS_" : item.slides[key2].badges[1] != undefined ? item.slides[key2].badges[1].css : "display:none",
            "_badge2MobileCSS_" : item.slides[key2].badges[1] != undefined ? item.slides[key2].badges[1].mobileCSS : "display:none",
            "_descriptionLeftText_" : item.slides[key2].descriptionLeftText != null ? item.slides[key2].descriptionLeftText : "",
            "_descriptionLeftTextCSS_" : item.slides[key2].descriptionLeftTextCSS != null ? item.slides[key2].descriptionLeftTextCSS : "display:none",
            "_descriptionLeftTextMobileCSS_" : item.slides[key2].descriptionLeftTextMobileCSS != null ? item.slides[key2].descriptionLeftTextMobileCSS : "display:none",
            "_descriptionRightText_" : item.slides[key2].descriptionRightText != null ? item.slides[key2].descriptionRightText : "",
            "_descriptionRightTextCSS_" : item.slides[key2].descriptionRightTextCSS != null ? item.slides[key2].descriptionRightTextCSS : "display:none",
            "_descriptionRightTextMobileCSS_" : item.slides[key2].descriptionRightTextMobileCSS != null ? item.slides[key2].descriptionRightTextMobileCSS : "display:none"
          };

          html = hlf.drawTemplate("#slide-template", mapping);
          $('.carousel-inner').append(html);

          // remove price image if there is none
          if (item.slides[key2].priceImage == null ) {
            $('.price-image').remove();
          }

          // make the first slide active
          if (key2 === 0) {
            $('.item').addClass('active');
          }

          // add carousel dots dynamically
          if (key2 === 0) {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + key2 + '" class="active" style="margin-left: 4px"></li>');
          } else {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + key2 + '" style="margin-left: 4px"></li>');
          }
        });

        // do not continue iterating through list
        return false;
      }

    });
  }
}