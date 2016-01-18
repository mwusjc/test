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
    var i = 0;
    $.each(data, function(key,item) {
      var d1 = new Date(carousel.currentTime);
      var d2 = new Date(item.startDate);

      // found the current carousel we should be rendering
      if (d1 > d2) {

        // iterate through the slides of the current carousel
        $.each(item.slides, function(key2,slide) {

          // render the template
          mapping = {
            "_slideID_" : item.slides[i].slideID,
            "_link_" : item.slides[i].link,
            "_desktopSlideBackground_" : item.slides[i].desktopSlideBackground,
            "_mobileSlideBackground_" : item.slides[i].mobileSlideBackground,
            "_backgroundSize_" : item.slides[i].backgroundSize,
            "_containerCSS_" : item.slides[i].containerCSS != null ? item.slides[i].containerCSS : "",
            "_headingContainerCSS_" : item.slides[i].headingContainerCSS != null ? item.slides[i].headingContainerCSS : "display:none",
            "_headingContainerMobileCSS_" : item.slides[i].headingContainerMobileCSS != null ? item.slides[i].headingContainerMobileCSS : "display:none",
            "_heading_" : item.slides[i].heading != null ? item.slides[i].heading : "",
            "_headingCSS_" : item.slides[i].headingCSS != null ? item.slides[i].headingCSS : "display:none",
            "_headingMobileCSS_" : item.slides[i].headingMobileCSS != null ? item.slides[i].headingMobileCSS : "display:none",
            "_subheading_" : item.slides[i].subheading != null ? item.slides[i].subheading : "",
            "_subheadingCSS_" : item.slides[i].subheadingCSS != null ? item.slides[i].subheadingCSS : "display:none",
            "_subheadingMobileCSS_" : item.slides[i].subheadingMobileCSS != null ? item.slides[i].subheadingMobileCSS : "display:none",
            "_imageOverlay_" : item.slides[i].imageOverlay != null ? item.slides[i].imageOverlay : "",
            "_imageOverlayCSS_" : item.slides[i].imageOverlayCSS != null ? item.slides[i].imageOverlayCSS : "display:none",
            "_textOverlay_" : item.slides[i].textOverlay != null ? item.slides[i].textOverlay : "",
            "_textOverlayCSS_" : item.slides[i].textOverlayCSS != null ? item.slides[i].textOverlayCSS : "display:none",
            "_priceImage_" : item.slides[i].priceImage != null ? item.slides[i].priceImage : "",
            // "_priceImageCSS_" : item.slides[i].priceImageCSS != null ? item.slides[i].priceImageCSS : "display:none",
            "_badge1_" : item.slides[i].badges[0] != undefined ? item.slides[i].badges[0].image : "",
            "_badge1CSS_" : item.slides[i].badges[0] != undefined ? item.slides[i].badges[0].css : "display:none",
            "_badge1MobileCSS_" : item.slides[i].badges[0] != undefined ? item.slides[i].badges[0].mobileCSS : "display:none",
            "_badge2_" : item.slides[i].badges[1] != undefined ? item.slides[i].badges[1].image : "",
            "_badge2CSS_" : item.slides[i].badges[1] != undefined ? item.slides[i].badges[1].css : "display:none",
            "_badge2MobileCSS_" : item.slides[i].badges[1] != undefined ? item.slides[i].badges[1].mobileCSS : "display:none",
            "_descriptionLeftText_" : item.slides[i].descriptionLeftText != null ? item.slides[i].descriptionLeftText : "",
            "_descriptionLeftTextCSS_" : item.slides[i].descriptionLeftTextCSS != null ? item.slides[i].descriptionLeftTextCSS : "display:none",
            "_descriptionLeftTextMobileCSS_" : item.slides[i].descriptionLeftTextMobileCSS != null ? item.slides[i].descriptionLeftTextMobileCSS : "display:none",
            "_descriptionRightText_" : item.slides[i].descriptionRightText != null ? item.slides[i].descriptionRightText : "",
            "_descriptionRightTextCSS_" : item.slides[i].descriptionRightTextCSS != null ? item.slides[i].descriptionRightTextCSS : "display:none",
            "_descriptionRightTextMobileCSS_" : item.slides[i].descriptionRightTextMobileCSS != null ? item.slides[i].descriptionRightTextMobileCSS : "display:none"
          };

          html = hlf.drawTemplate("#slide-template", mapping);
          $('.carousel-inner').append(html);

          // remove price image if there is none
          if (item.slides[i].priceImage == null ) {
            $('.price-image').remove();
          }

          // make the first slide active
          if (i === 0) {
            $('.item').addClass('active');
          }

          i++;

          // add carousel dots dynamically
          if (i === 0) {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + i + '" class="active" style="margin-left: 4px"></li>');
          } else {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + i + '" style="margin-left: 4px"></li>');
          }
        });

        // do not continue iterating through list
        return false;
      }

    });
  }
}