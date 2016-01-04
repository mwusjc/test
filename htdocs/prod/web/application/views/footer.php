<footer>
  <div class="wrapper">
    <div class="row">

      <div class="subscribe col-xs-12 col-sm-4 pull-right">
        <!-- Begin MailChimp Signup Form -->
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
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

<script src="../../assets/js/bootstrap.js?rev=a455a998d98c7ee364bd00bf6853d40e"></script>
<script src="../../assets/js/main.js?rev=bda417a6dfdec98b1fb0d034a4b63f29"></script>
<script src="../../assets/js/flyerLoader.js?rev=0731e64db67106d5717b39e4a7e6f61d"></script>
<script src="../../assets/js/shoppingList.js?rev=c70a077489931af66dd3794cc0fa6bf6"></script>
<script src="../../assets/js/jquery.pajinate.min.js?rev=fdcae8fb7ff4daa34ad497e010fcea97"></script>
<script src="../../assets/js/jquery.lazyload.min.js?rev=5c01d7aff077b4ed0804b71c2e3ab4a1"></script>
<script src="../../assets/js/hlf.js?rev=4e592819b4ed4753b1aaa9d68f60cda5"></script>
<script src="../../assets/js/hlf.recipesjson.js?rev=2bbe18fd09efbccda8369cc84f7391a4"></script>
<script src="../../assets/js/sizeify.js?rev=0a69844d8c7f95148c11eaceacd8171c"></script>
<script src="../../assets/js/validate.js?rev=0ba12861d4b921c8a3506b29a96fe106"></script>
<script src="../../assets/js/hlf.carousel.js?rev=b92dddcb103a4b1bc0cceb0766d0431a"></script>

<script type='text/javascript'>
  jQuery(document).ready(function($) {
    sl.init();
    $("body").on("click", ".menu-toggle", function(){
      $(".main-nav").hasClass("closed")?$(".main-nav").removeClass("closed"):$(".main-nav").addClass("closed");
    });
    carousel.currentTime = new Date();
    carousel.init(carousel.currentTime);
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