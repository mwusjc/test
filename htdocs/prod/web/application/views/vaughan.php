</header>

<main class='home'>
	<div class="row countdown">
		<div class="col-xs-12 col-sm-12">
      <div style="background:#00a64f; padding:12px 15px; margin:0; border-radius: 30px 30px 0 0; height: 450px;">
        <h4 style="color:white; font-size: 24px; font-family: 'HelveticaNeueLT-Bold'; padding-top: 30px" align="center">Something’s coming just around the corner</h4>
        <h4 style="color:#f99d1c; font-size: 20px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;" align="center">#hfstartfresh</h4>
        <style>
          #clockdiv {
            margin-top:30px; margin-bottom:20px;
          }

          .smalltext {
            color:white; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: left;
          }
          
          .clocknumber {
            color:#f99d1c; font-family: 'HelveticaNeueLT-Bold';
          }
          @media (min-width: 644px) {
            .clocknumber {
              font-size: 95px;
            }
            #clockdiv {
              margin-top:60px; margin-bottom:20px;
            }
            .smalltext {
              font-size: 18px; 
            }
          }
          @media (min-width: 451px) and (max-width: 643px) {
            .clocknumber {
              font-size: 62px;
            }
          }
          @media (min-width: 356px) and (max-width: 450px) {
            .clocknumber {
              font-size: 48px;
            }
            .smalltext {
              font-size: 12px;
            }
            #clockdiv {
              padding-top:15px; padding-bottom:10px;
            }
          }
          @media (max-width: 355px) {
            .clocknumber {
              font-size: 36px;
            }
            .smalltext {
              font-size: 11px;
            }
          }
        </style>
        <div id="clockdiv" align="center">
            <div style="display:inline-block;">
              <span class="days clocknumber">00:</span>
              <div class="smalltext">Days</div>
            </div>
            <div style="display:inline-block;">
              <span class="hours clocknumber">00:</span>
              <div class="smalltext">Hours</div>
            </div>
            <div style="display:inline-block;">
              <span class="minutes clocknumber">00:</span>
              <div class="smalltext">Minutes</div>
            </div>
            <div style="display:inline-block;">
              <span class="seconds clocknumber">00:</span>
              <div class="smalltext">Seconds</div>
            </div>
        </div>
        <script>
        function getTimeRemaining(endtime) {
          var t = Date.parse(endtime) - Date.parse(new Date());
          var seconds = Math.floor((t / 1000) % 60);
          var minutes = Math.floor((t / 1000 / 60) % 60);
          var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
          var days = Math.floor(t / (1000 * 60 * 60 * 24));
          return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
          };
        }

        function initializeClock(id, endtime) {
          var clock = document.getElementById(id);
          var daysSpan = clock.querySelector('.days');
          var hoursSpan = clock.querySelector('.hours');
          var minutesSpan = clock.querySelector('.minutes');
          var secondsSpan = clock.querySelector('.seconds');

          function updateClock() {
            var t = getTimeRemaining(endtime);

            daysSpan.innerHTML = t.days+":";
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2)+":";
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2)+":";
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
              clearInterval(timeinterval);
            }
          }

          updateClock();
          var timeinterval = setInterval(updateClock, 1000);
        }

        var deadline = 'March 31 2017 10:00:00 GMT-0500';
        initializeClock('clockdiv', deadline);
        </script>
        <div class="subscribe col-xs-12 col-sm-10 desktop" style="padding: 0px; top: 20px; margin: 0 auto; float: none; height:100px" align="center">
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" align="center" style="margin: 0 auto;">
                <input type="email" value="" name="EMAIL" class="col-xs-12 col-sm-12" id="mce-EMAIL" aria-label="email" placeholder="Enter your email to stay tuned" aria-required="true" required style="width:90%">
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
                <input type="submit" aria-label="Submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email sticky right" style="background-color: #f99d1c;">
            </form>
        </div>
        <div class="subscribe col-xs-12 col-sm-10 mobile" style="padding: 0px; top: 20px; margin: 0 auto; float: none;" align="center">
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" align="center" style="margin: 0 auto;">
                <input type="email" value="" name="EMAIL" class="col-xs-12 col-sm-12" id="mce-EMAIL" aria-label="email" placeholder="Enter your email to stay tuned" aria-required="true" required style="width:100%">
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
                <br>
                <input type="submit" aria-label="Submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email" style="background-color: #f99d1c; margin:0 0 40px 0">
            </form>
        </div>
        <div align="center">
          <style>
            .social-icon {
              height: 32px;
              width: 32px;
              margin: 2.5px;
              display: inline-block;
            }
          </style>
          <a href="https://www.facebook.com/HighlandFarmsON/" alt="facebook" class="social-icon" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-facebook-orange.png); background-size: cover"></a>
          <a href="https://twitter.com/highlandfarmson" alt="twitter" class="social-icon" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-twitter-orange.png); background-size: cover"></a>
          <a href="https://www.instagram.com/highlandfarms_on/" alt="instagram" class="social-icon" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-instagram-orange.png); background-size: cover"></a>
        </div>
      </div>
		</div>
	</div>

</main>

