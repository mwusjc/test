</header>

<link rel="stylesheet" href="<?=site_url()?>assets/css/vaughan-2.css">
<link rel="stylesheet" href="<?=site_url()?>assets/css/addtocalendar.css">
<script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
<script type="text/javascript">
window.addeventasync = function(){
    addeventatc.settings({
        license    : "axrmLOfZszxyrEweZmoa27130",
        mouse      : false,
        css        : false,
        outlook    : {show:true, text:"Outlook"},
        google     : {show:true, text:"Google <em>(online)</em>"},
        yahoo      : {show:true, text:"Yahoo <em>(online)</em>"},
        outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
        appleical  : {show:true, text:"Apple iCalendar"},
        facebook   : {show:false, text:"Facebook Event"},
        dropdown   : {order:"appleical,google,outlook,outlookcom,yahoo"}
    });
};
</script>

<main class='landing-2'>
  <div class="row">
    <div class="social-blurb mobile">
      <span><span class="orange-text">Follow us</span> and get the <br class="breakpoint">latest deals &amp; savings!</span>
    </div><br class="mobile">
    <div class="event-social-icons">
      <a href="http://www.facebook.com/sharer.php?s=100&p[url]=http://hfstartfresh.ca" alt="facebook" class="facebook-landing"></a>
      <a href="http://twitter.com/intent/tweet?text=A+fresh+new+Highland+Farms+is+coming+to+Vaughan&hashtags=hfstartfresh" alt="twitter" class="twitter-landing"></a>
      <a href="https://www.instagram.com/highlandfarms_on/" alt="instagram" class="instagram-landing"></a><br>
    </div>
    <div class="social-blurb desktop">
      <span><span class="orange-text">Follow us</span> and get the <br class="breakpoint">latest deals &amp; savings!</span>
    </div>
  </div>
  <div class="row countdown">
    <div class="title col-md-8"><h1>Grand Opening Countdown</h1></div>
    <div id="clockdiv" class="col-md-4">
      <div class="numbercontainer">
        <h1 class="seconds clocknumber orange-text heading-text">00:</h1>
        <div class="smalltext">Seconds</div>
      </div>
      <div class="numbercontainer">
        <h1 class="minutes clocknumber orange-text heading-text">00:</h1>
        <div class="smalltext">Minutes</div>
      </div>
      <div class="numbercontainer">
        <h1 class="hours clocknumber orange-text heading-text">00:</h1>
        <div class="smalltext">Hours</div>
      </div>
      <div class="numbercontainer">
        <h1 class="days clocknumber orange-text heading-text">00:</h1>
        <div class="smalltext">Days</div>
      </div>
     </div>
  </div>
  <div class="row box orange rounded intro">
    <div class="col-xs-12 col-sm-12">
    <h1>Join us Friday,<br>
    March 31 at 10am for<br class="breakpoint">
    our Grand Opening!</h1><br>
    <span>9940 Dufferin St. at <br class="breakpoint">Major MacKenzie Dr. W.</span>
    </div>
  </div>
  <div class="row box orange offer">
    <div class="col-md-2 circle green"><h4>Plus</h4></div>
    <div class="col-md-9">
      <div class="row">
        <div class="col-xs-6 col-md-6"><h4>FREE</h4></div>
        <div class="col-xs-6 col-md-6"><h4>FREE</h4></div>
      </div>
      <div class="row details">
        <div class="col-xs-6 col-md-6"><h3>$25 Gift Card <br>to the first 200 <br>customers</h3></div>
        <div class="col-xs-6 col-md-6"><h3>Eco-friendly <br>shopping bag with <br class="breakpoint">every purchase</h3></div>
      </div>
    </div>
  </div>
  <div class="row box orange calendar">
    <div class="col-md-8">
      <h3>Get these exclusive offers<br>
      Friday, March 31 only at our<br class="breakpoint">
      fresh new Vaughan location!</h3>
    </div>
    <div class="col-md-4">
      <div title="Add to Calendar" class="addeventatc addtocalendar">
          + add to your calendar
          <span class="start">03/31/2017 10:00 AM</span>
          <span class="end">03/31/2017 12:00 PM</span>
          <span class="timezone">America/Toronto</span>
          <span class="title">Highland Farms Grand Opening</span>
          <span class="description">For details, link here: http://www.hfstartfresh.ca</span>
          <span class="location">9940 Dufferin Street, Vaughan, ON, L6A 4K5</span>
          <span class="organizer">Highland Farms</span>
          <span class="organizer_email">Organizer e-mail</span>
          <span class="all_day_event">false</span>
          <span class="date_format">MM/DD/YYYY</span>
          <span class="calname">Highland_Farms_Vaughan_Grand_Opening</span>
      </div>
    </div>
  </div>
  <div class="row store"> 
    <div class="col-md-12">
      <h1>You'll love our new Vaughan store!</h1>
    </div>
  </div>
  <div class="row store-image"> 
    <img alt="Highland Farms Store Front" src="<?=site_url()?>/assets/media/vaughan/store-front.jpg">
    <div class="col-md-3 orange circle"><h4>FRESH<br>&amp; NEW</h4></div>
    <div class="row">
      <div class="col-md-6 store-caption">
        <span>Check out our <br>state-of-the-art <br>supermarket fully <br>stocked with <br>freshness.</span>
      </div>
    </div>
  </div>
</main>
<div class="container-fluid deli-header">
  <div class="row">
    <div>
      <img alt="Deli Section" src="<?=site_url()?>/assets/media/vaughan/deli-sign.jpg">
    </div>
    <div>
      <img alt="Platters and Gifts" src="<?=site_url()?>/assets/media/vaughan/platters-gifts.jpg">
    </div>
  </div>
</div>
<main class="landing-3">
  <div class="row deli">
    <h1>Freshly sliced</h1>
    <p>Shop our legendary selection of meats and cheeses inspired by flavours from around the world. Everything is cut-to-order by our friendly staff. You’ll also find a mouth-watering selection of olives, antipastos and fresh deli salads.</p>
  </div>
  <div class="row produce">
    <img alt="Produce Section" src="<?=site_url()?>/assets/media/vaughan/apples.jpg">
    <div class="col-md-3 green circle"><h4><span>FARM</span><br>FRESH<br><span>EVERY DAY</span></h4></div>
    <h1>The freshest produce</h1>
    <p>The size, selection and value of our produce is unsurpassed. Everything is hand-selected daily. Bringing you the freshest produce at the best prices.</p>
  </div>
  <div class="row organic">
    <div>
      <img alt="Natural and Wellness Badge" src="<?=site_url()?>/assets/media/vaughan/organic-badge.jpg">
    </div>
    <div class="col-md-6">
        <h1>Live and eat well</h1>
        <p>We know how important health and wellness is to our customers. That’s why our new store features a huge selection of gluten-free, natural and organic products.</p>
    </div>
  </div>
</main>
<div class="container-fluid country-kitchen-header">
  <div class="row">
  <img alt="Country Kitchen Section" src="<?=site_url()?>/assets/media/vaughan/country-kitchen.jpg">
  </div>
</div>
<main class="landing-4">
  <div class="row prepared">
    <h1>Freshly prepared</h1>
    <p>Don’t worry if you’re running a little late. Our talented cooks whip up fresh and delicious meals such as chicken, ribs, pasta and a variety of sides – all ready to serve quickly and easily. Let us take care of dinner tonight!</p>
  </div>
  <div class="row aisle">
    <img alt="Shopping Aisle" src="<?=site_url()?>/assets/media/vaughan/aisle.jpg"><br>
    <h1>Great prices in <br class="breakpoint">every aisle</h1>    
    <p>Get competitive prices on thousands of brand names throughout the store.</p>
    <hr>
  </div>
  <div class="row flyer-deals">
    <h1>Look for our deals... at your fingertips!</h1>
    <p>Great deals and savings every week! Subscribe to our e-flyer.</p>
    <div class="col-xs-8 col-sm-8 col-md-offset-2 vaughan-subscribe-2 desktop">
    <!-- Begin MailChimp Signup Form -->
      <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
        <input type="email" value="" name="EMAIL" id="mce-EMAIL" aria-label="email" placeholder="email address" aria-required="true" required>
         <div><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
        <input type="submit" aria-label="Subscribe" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email sticky right">
      </form>
    </div>
    <div class="vaughan-subscribe-2 mobile">
      <!-- Begin MailChimp Signup Form -->
      <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
        <input type="email" value="" name="EMAIL" id="mce-EMAIL" aria-label="email" placeholder="email address" aria-required="true" required>
        <div><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
        <input type="submit" aria-label="Subscribe" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email">
      </form>
    </div>
  </div>
  <div class="scroll">
    <a onclick="scrollWin()"><img alt="Scroll to Top" src="<?=site_url()?>/assets/media/vaughan/scroll-to-top.png"></a>
  </div>
</main>

<script type="text/javascript" async src="<?=site_url()?>/assets/js/vaughan-countdown.js"></script>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>