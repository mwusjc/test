

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
      var theCurrentTime = new Date(carousel.currentTime);
      var carouselStartDate = new Date(item.startDate);

      // found the current carousel we should be rendering
      if (theCurrentTime > carouselStartDate) {

        // iterate through the slides of the current carousel
        $.each(item.slides, function(slideKey,slide) {

          // render the template
          mapping = {
            "_slideID_" : item.slides[slideKey].slideID,
            "_link_" : item.slides[slideKey].link,
            "_desktopSlideBackground_" : item.slides[slideKey].desktopSlideBackground,
            "_mobileSlideBackground_" : item.slides[slideKey].mobileSlideBackground,
            "_backgroundSize_" : item.slides[slideKey].backgroundSize,
            "_containerCSS_" : item.slides[slideKey].containerCSS != null ? item.slides[slideKey].containerCSS : "",
            "_headingContainerCSS_" : item.slides[slideKey].headingContainerCSS != null ? item.slides[slideKey].headingContainerCSS : "display:none",
            "_headingContainerMobileCSS_" : item.slides[slideKey].headingContainerMobileCSS != null ? item.slides[slideKey].headingContainerMobileCSS : "display:none",
            "_heading_" : item.slides[slideKey].heading != null ? item.slides[slideKey].heading : "",
            "_headingCSS_" : item.slides[slideKey].headingCSS != null ? item.slides[slideKey].headingCSS : "display:none",
            "_headingMobileCSS_" : item.slides[slideKey].headingMobileCSS != null ? item.slides[slideKey].headingMobileCSS : "display:none",
            "_subheading_" : item.slides[slideKey].subheading != null ? item.slides[slideKey].subheading : "",
            "_subheadingCSS_" : item.slides[slideKey].subheadingCSS != null ? item.slides[slideKey].subheadingCSS : "display:none",
            "_subheadingMobileCSS_" : item.slides[slideKey].subheadingMobileCSS != null ? item.slides[slideKey].subheadingMobileCSS : "display:none",
            "_imageOverlay_" : item.slides[slideKey].imageOverlay != null ? item.slides[slideKey].imageOverlay : "",
            "_imageOverlayCSS_" : item.slides[slideKey].imageOverlayCSS != null ? item.slides[slideKey].imageOverlayCSS : "display:none",
            "_textOverlay_" : item.slides[slideKey].textOverlay != null ? item.slides[slideKey].textOverlay : "",
            "_textOverlayCSS_" : item.slides[slideKey].textOverlayCSS != null ? item.slides[slideKey].textOverlayCSS : "display:none",
            "_priceImage_" : item.slides[slideKey].priceImage != null ? item.slides[slideKey].priceImage : "",
            "_badge1_" : item.slides[slideKey].badges[0] != undefined ? item.slides[slideKey].badges[0].image : "",
            "_badge1CSS_" : item.slides[slideKey].badges[0] != undefined ? item.slides[slideKey].badges[0].css : "display:none",
            "_badge1MobileCSS_" : item.slides[slideKey].badges[0] != undefined ? item.slides[slideKey].badges[0].mobileCSS : "display:none",
            "_badge2_" : item.slides[slideKey].badges[1] != undefined ? item.slides[slideKey].badges[1].image : "",
            "_badge2CSS_" : item.slides[slideKey].badges[1] != undefined ? item.slides[slideKey].badges[1].css : "display:none",
            "_badge2MobileCSS_" : item.slides[slideKey].badges[1] != undefined ? item.slides[slideKey].badges[1].mobileCSS : "display:none",
            "_badge3_" : item.slides[slideKey].badges[2] != undefined ? item.slides[slideKey].badges[2].image : "",
            "_badge3CSS_" : item.slides[slideKey].badges[2] != undefined ? item.slides[slideKey].badges[2].css : "display:none",
            "_badge3MobileCSS_" : item.slides[slideKey].badges[2] != undefined ? item.slides[slideKey].badges[2].mobileCSS : "display:none",
            "_descriptionLeftText_" : item.slides[slideKey].descriptionLeftText != null ? item.slides[slideKey].descriptionLeftText : "",
            "_descriptionLeftTextCSS_" : item.slides[slideKey].descriptionLeftTextCSS != null ? item.slides[slideKey].descriptionLeftTextCSS : "display:none",
            "_descriptionLeftTextMobileCSS_" : item.slides[slideKey].descriptionLeftTextMobileCSS != null ? item.slides[slideKey].descriptionLeftTextMobileCSS : "display:none",
            "_descriptionRightText_" : item.slides[slideKey].descriptionRightText != null ? item.slides[slideKey].descriptionRightText : "",
            "_descriptionRightTextCSS_" : item.slides[slideKey].descriptionRightTextCSS != null ? item.slides[slideKey].descriptionRightTextCSS : "display:none",
            "_descriptionRightTextMobileCSS_" : item.slides[slideKey].descriptionRightTextMobileCSS != null ? item.slides[slideKey].descriptionRightTextMobileCSS : "display:none"
          };
          html = hlf.drawTemplate("#slide-template", mapping);
          $('.carousel-inner').append(html);
          // remove price image if there is none
          if (item.slides[slideKey].priceImage == null ) {
            $('.price-image').remove();
          }
          // make the first slide active
          if (slideKey === 0) {
            $('.item').addClass('active');
          }
          // add carousel dots dynamically
          if (slideKey === 0) {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + slideKey + '" class="active" style="margin-left: 4px"></li>');
          } else {
            $('.carousel-indicators').append('<li data-target="#carousel" data-slide-to="' + slideKey + '" style="margin-left: 4px"></li>');
          }
        });
        // do not continue iterating through list
        return false;
      }
    });
  }
}



jQuery(document).ready(function($) {
    sl.init();
    $("body").on("click", ".menu-toggle", function(){
        $(".main-nav").hasClass("closed")?$(".main-nav").removeClass("closed"):$(".main-nav").addClass("closed");
    });

    carousel.currentTime = new Date();
    carousel.init(carousel.currentTime);

});

