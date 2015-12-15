<footer>
  <div class="wrapper">
    <div class="row">

      <div class="subscribe col-xs-12 col-sm-4 pull-right">
        <!-- Begin MailChimp Signup Form -->
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <p>Subscribe to our e-flyer!</p>
                <input type="email" value="" name="EMAIL" class="col-xs-12 col-sm-12" id="mce-EMAIL" aria-label="email" placeholder="email address" aria-required="true" required>
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
                <input type="submit" aria-label="Subscribe" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email sticky right green">
            </form>
        </div>
        <!--End mc_embed_signup-->

      <div class="col-xs-12 col-sm-8">
        <ul>
          <li><a href="<?=site_url()?>about/privacy_policy">Privacy Policy</a></li>
          <li><a href="<?=site_url()?>about/disclaimer">Disclaimer</a></li>
          <li><a href="<?=site_url()?>about/accessibility">Accessibility</a></li>
          <li><a href="<?=site_url()?>careers">Careers</a></li>
          <li><a href="<?=site_url()?>visit-us">Contact Us</a></li>
        </ul>
        <p class="copyright">© 2015 Highland Farms</p>
      </div>

    </div>
  </div>
</footer>

<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/flyerLoader.js"></script>
<script src="/assets/js/shoppingList.js"></script>
<script src="/assets/js/jquery.pajinate.min.js"></script>
<script src="/assets/js/jquery.lazyload.min.js"></script>
<script src="/assets/js/hlf.js"></script>
<script src="/assets/js/hlf.recipes.js"></script>
<script src="/assets/js/sizeify.js"></script>
<script src="/assets/js/jquery.validate.min.js"></script>
<script type='text/javascript'>
  jQuery(document).ready(function($) {
    sl.init();
    $("body").on("click", ".menu-toggle", function(){
      $(".main-nav").hasClass("closed")?$(".main-nav").removeClass("closed"):$(".main-nav").addClass("closed");
    });

    // contact us/visit-us form validation
    $('#form').validate({
			rules: {
				first: "required",
				email: {
					required: true,
					email: true
				},
				message: "required"
			},
			messages: {
				first: "Please enter your first name",
				email: {
					required: "Please enter your email address",
					email: "Please enter a valid email address"
				},
				message: "Please enter your message"
			}
		});

		// Job application form validation
    $('#job-application').validate({
			rules: {
				first: "required",
				last: "required",
				email: {
					required: true,
					email: true
				},
				phone: "required"
			},
			messages: {
				first: "Please enter your first name",
				last: "Please enter your last name",
				email: {
					required: "Please enter your email address",
					email: "Please enter a valid email address"
				},
				phone: "Please enter your phone number",
			}
		});

		$("#upload-resume-file").rules("add", {
			required:true,
			messages: {
		    required: "Please select a file"
		  }
		});

  });
</script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-56448531-1', 'auto');
ga('send', 'pageview');
</script>
</body>
</html>