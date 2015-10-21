var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
var responsive = {
  init: function(){
    el = $('.responsive');
    this.mathematics(el);
    this.bind();
  },
  bind: function(){
    // wait for window finish resize
    $(window).resize(function(){
      delay(function(){
        responsive.mathematics(el);
      },300);
    });
  },
  mathematics: function(el){
    el.each(function(){
      $this = $(this);
      var containerHeight = $this.height(),
          containerWidth = $this.width(),
          obj = $this.find('> img');
          
      // get visibility hidden image width and height
      var tmp = new Image();
      tmp.src= obj.attr('src');
      tmp.onload=function() {
        var heightScale = containerHeight/tmp.height,
            widthScale = containerWidth/tmp.width,
            newHeight = widthScale*tmp.height,
            newWidth = heightScale*tmp.width,
            offsetY = -(newHeight - containerHeight)/2,
            offsetX = -(newWidth - containerWidth)/2;
        if(newWidth < containerWidth) {
          obj.css({
            'height':newHeight, 'width':'',
            'margin-top':offsetY,
            'margin-left':''
          });
        } else {
          obj.css({
            'width':newWidth, 'height':'',
            'margin-top':'',
            'margin-left':offsetX 
          });
        }
      };

    });
  }
};                  
var details = {
  init: function(){
    $detail = $('#details');
    toggle = $('.details');
    closebtn = $('#details .close');

    this.bind();
  },
  bind: function(){
    toggle.click(this.open);
    closebtn.click(this.close);
  },
  open: function(){
    $detail.stop().fadeIn(100);
    return false;
  },
  close: function(){
    $detail.stop().fadeOut(100);
    return false;
  }
}; details.init();