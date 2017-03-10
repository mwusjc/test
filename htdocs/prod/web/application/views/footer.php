<footer>
  <div class="wrapper">
    <div class="row">

      <div class="social-icons  col-xs-12 col-sm-4 pull-right">
          <a href="https://www.facebook.com/HighlandFarmsON/" alt="facebook" class="right" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-facebook-gray.png)"></a>
          <a href="https://twitter.com/highlandfarmson" alt="twitter" class="right" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-twitter-gray.png)"></a>
          <a href="https://www.instagram.com/highlandfarms_on/" alt="instagram" class="right" style="background-image:url(<?=site_url()?>/assets/media/social/social-icon-instagram-gray.png)"></a>
      </div>

      <div class="col-xs-12 col-sm-8">
        <ul>
          <li><a class="link-footer" href="<?=site_url()?>about/privacy_policy">Privacy Policy</a></li>
          <li><a class="link-footer" href="<?=site_url()?>about/disclaimer">Disclaimer</a></li>
          <li><a class="link-footer" href="<?=site_url()?>about/accessibility">Accessibility</a></li>
          <li><a class="link-footer" href="<?=site_url()?>careers">Careers</a></li>
          <li><a class="link-footer" href="<?=site_url()?>visit-us">Contact Us</a></li>
        </ul>
        <p class="copyright">© <?php echo date("Y"); ?> Highland Farms</p>
      </div>

    </div>
  </div>
</footer>

<script src="../../assets/js/bootstrap.js?rev=a455a998d98c7ee364bd00bf6853d40e"></script>
<script src="../../assets/js/main.js?rev=bda417a6dfdec98b1fb0d034a4b63f29"></script>
<script src="../../assets/js/flyerLoader.js?rev=1f286af4e22eec7645a072791db7d704"></script>
<script src="../../assets/js/shoppingList.js?rev=846e83c06b039eb62ed86df6a297a111"></script>
<script src="../../assets/js/jquery.pajinate.min.js?rev=fdcae8fb7ff4daa34ad497e010fcea97"></script>
<script src="../../assets/js/jquery.lazyload.min.js?rev=5c01d7aff077b4ed0804b71c2e3ab4a1"></script>
<script src="../../assets/js/hlf.js?rev=0d4b5e4e2272ab9376032eefbcf8ff23"></script>

<script src="../../assets/js/hlf.recipesjson.js?rev=97f3be97a9afad0d68df8deeb9dfe53f"></script>
<script src="../../assets/js/hlf.plattersjson.js"></script>
<script src="../../assets/js/validate.js?rev=37aac988798c9fded355b84889b615a5"></script>
<script src="../../assets/js/hlf.carousel.js?rev=70a4278bf548de304a6abfaad2b7247c"></script>
<script src="../../assets/js/hlf.careers.js?rev=cf26fa3ebc546246d5dbcffb68be047f"></script>
<script src="../../assets/js/markdown.min.js?rev=e96d24cf1ba1e3f43912cbe7a6ffbc7f"></script>
<script src="/bower_components/es6-promise/es6-promise.min.js?rev=e96d24cf1ba1e3f43912cbe7a6ffbc7f"></script>
<script src="/bower_components/fetch/fetch.js?rev=e96d24cf1ba1e3f43912cbe7a6ffbc7f"></script>

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
<!-- Google Code for Remarketing Tag -->
<!--
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
-->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 866265235;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/866265235/?guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>
