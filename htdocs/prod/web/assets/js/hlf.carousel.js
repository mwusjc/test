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
            "_slideID_" : item.slides[slide.order].slideID,
            "_link_" : item.slides[slide.order].link,
            "_desktopSlideBackground_" : item.slides[slide.order].desktopSlideBackground,
            "_mobileSlideBackground_" : item.slides[slide.order].mobileSlideBackground,
            "_active_" : item.slides[slide.order].active ? "active" : "",
            "_containerCSS_" : item.slides[slide.order].containerCSS != null ? item.slides[slide.order].containerCSS : "display:none",
            "_headingContainerCSS_" : item.slides[slide.order].headingContainerCSS != null ? item.slides[slide.order].headingContainerCSS : "display:none",
            "_heading_" : item.slides[slide.order].heading != null ? item.slides[slide.order].heading : "",
            "_headingCSS_" : item.slides[slide.order].headingCSS != null ? item.slides[slide.order].headingCSS : "display:none",
            "_headingMobileCSS_" : item.slides[slide.order].headingMobileCSS != null ? item.slides[slide.order].headingMobileCSS : "display:none",
            "_subheading_" : item.slides[slide.order].subheading != null ? item.slides[slide.order].subheading : "",
            "_subheadingCSS_" : item.slides[slide.order].subheadingCSS != null ? item.slides[slide.order].subheadingCSS : "display:none",
            "_subheadingMobileCSS_" : item.slides[slide.order].subheadingMobileCSS != null ? item.slides[slide.order].subheadingMobileCSS : "display:none",
            "_imageOverlay_" : item.slides[slide.order].imageOverlay != null ? item.slides[slide.order].imageOverlay : "",
            "_imageOverlayCSS_" : item.slides[slide.order].imageOverlayCSS != null ? item.slides[slide.order].imageOverlayCSS : "display:none",
            "_textOverlay_" : item.slides[slide.order].textOverlay != null ? item.slides[slide.order].textOverlay : "",
            "_textOverlayCSS_" : item.slides[slide.order].textOverlayCSS != null ? item.slides[slide.order].textOverlayCSS : "display:none",
            "_priceImage_" : item.slides[slide.order].priceImage != null ? item.slides[slide.order].priceImage : "",
            "_priceImageCSS_" : item.slides[slide.order].priceImageCSS != null ? item.slides[slide.order].priceImageCSS : "display:none",
            "_badge1_" : item.slides[slide.order].badges[0] != undefined ? item.slides[slide.order].badges[0].image : "",
            "_badge1CSS_" : item.slides[slide.order].badges[0] != undefined ? item.slides[slide.order].badges[0].css : "display:none",
            "_badge2_" : item.slides[slide.order].badges[1] != undefined ? item.slides[slide.order].badges[1].image : "",
            "_badge2CSS_" : item.slides[slide.order].badges[1] != undefined ? item.slides[slide.order].badges[1].css : "display:none",
            "_descriptionLeftText_" : item.slides[slide.order].descriptionLeftText != null ? item.slides[slide.order].descriptionLeftText : "",
            "_descriptionLeftTextCSS_" : item.slides[slide.order].descriptionLeftTextCSS != null ? item.slides[slide.order].descriptionLeftTextCSS : "display:none",
            "_descriptionLeftTextMobileCSS_" : item.slides[slide.order].descriptionLeftTextMobileCSS != null ? item.slides[slide.order].descriptionLeftTextMobileCSS : "display:none",
            "_descriptionRightText_" : item.slides[slide.order].descriptionRightText != null ? item.slides[slide.order].descriptionRightText : "",
            "_descriptionRightTextCSS_" : item.slides[slide.order].descriptionRightTextCSS != null ? item.slides[slide.order].descriptionRightTextCSS : "display:none",
            "_descriptionRightTextMobileCSS_" : item.slides[slide.order].descriptionRightTextMobileCSS != null ? item.slides[slide.order].descriptionRightTextMobileCSS : "display:none"
          };

          html = hlf.drawTemplate("#slide-template", mapping);
          $('.carousel-inner').append(html);

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