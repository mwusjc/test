<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=empty($title)?"Highland Farms":$title?></title>
    <?php
        $meta_desc = "Highland Farms provides you with freshness down every aisle. From fresh produce, meat and seafood to freshly baked goods and prepared foods, our supermarkets also offer organic and natural alternatives for the healthy at heart. Visit one of our locations today!";
        if(isset($desc))
            $meta_desc = $desc;
    ?>
    <meta name="description" content="<?=$meta_desc?>">
    <meta name="viewport" content="initial-scale=1">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/assets/images/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/images/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/images/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/images/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/assets/images/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/assets/images/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/assets/images/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/assets/images/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/assets/images/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/assets/images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/assets/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/assets/images/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/assets/images/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="/assets/images/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="/assets/images/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="/assets/images/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="/assets/images/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="/assets/images/mstile-310x310.png" />

    <link rel="stylesheet" href="../../assets/css/styles.css?rev=c1c49fbe4e4180a5c15297f560223305">
    <link rel="stylesheet" href="../../assets/css/mobile.css?rev=31782873ae78c8eb34dd2d96a830ac25">

     <script type='text/javascript'>
        var hlf = {};
            hlf.data = {};
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/assets/js/jquery-2.1.4.min.js"><\/script>')</script>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K5FQFX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K5FQFX');</script>
<!-- End Google Tag Manager -->
<header>
    <img class="menu-toggle mobile" src="<?=site_url()?>/assets/images/mobile/icon_menu.png" />
    <nav class="main-nav mobile closed">
        <ul class="main-menu">
            <li><a href='<?=site_url()?>'>Home</a></li>
            <li><a href='<?=site_url()?>flyer'>Flyer</a></li>
            <li><a href='<?=site_url()?>recipes'>Recipes</a></li>
            <li><a href='<?=site_url()?>inside-store'>Inside The Store</a></li>
            <li><a href='<?=site_url()?>country-kitchen'>Country Kitchen</a></li>
            <li><a href='<?=site_url()?>party-platters'>Platters & Gifts</a></li>
            <li><a href='<?=site_url()?>about'>About</a></li>
            <li><a href='<?=site_url()?>visit-us'>Visit Us</a></li>
        </ul>
    </nav>

    <div class="wrapper desktop">
        <div class="subscribe col-xs-12 col-sm-4 pull-left" style="padding: 0px; top: 20px">
        <!-- Begin MailChimp Signup Form -->
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                <p style="margin: 10px 0 10px;">Subscribe to our e-flyer!</p>
                <input type="email" value="" name="EMAIL" class="col-xs-12 col-sm-12" id="mce-EMAIL" aria-label="email" placeholder="email address" aria-required="true" required>
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
                <input type="submit" aria-label="Subscribe" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email sticky right green">
            </form>
        </div>
        <!--End mc_embed_signup-->
    </div>

    <a href="/" class="logo desktop"><img src="<?=site_url()?>/assets/images/Highland-Farms-Logo-NEW.png" alt="Highland Farms"/></a>
    <a href="/" class="logo mobile"><img src="<?=site_url()?>/assets/images/Highland-Farms-Logo-NEW.png" alt="Highland Farms"/></a>
    <div class="shopcart">
        <a href='<?=site_url()?>shopping'>
            <span class="desktop">Shopping list</span>
        <img src="<?=site_url()?>/assets/images/shoppingcart-2.png" />
        <i class='items-in-cart'>0</i>
        </a>
    </div>

        <div class="mobile mobile-subscribe col-xs-12 col-sm-4" style="margin: 10px 0 10px">
        <!-- Begin MailChimp Signup Form -->
            <form action="//highlandfarms.us9.list-manage.com/subscribe/post?u=a574aa827269d018202389912&amp;id=792b79af52" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                <p style="margin: 10px 0 10px; text-align: center">Subscribe to our e-flyer!</p>
                <input type="email" value="" name="EMAIL" class="col-xs-12 col-sm-12" id="mce-EMAIL" aria-label="email" placeholder="email address" aria-required="true" required>
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_a574aa827269d018202389912_792b79af52" tabindex="-1" value="" placeholder="Your e-mail address"></div>
                <input type="submit" aria-label="Subscribe" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="subscribe-email sticky right green">
            </form>
        </div>
        <!--End mc_embed_signup-->

    <nav class="desktop">
        <ul>
            <li><a id="home" href='<?=site_url()?>'>Home</a></li>
            <li><a id="flyer" href='<?=site_url()?>flyer'>Flyer</a></li>
            <li><a id="recipes" href='<?=site_url()?>recipes'>Recipes</a></li>
            <li><a id="insideTheStore" href='<?=site_url()?>inside-store'>Inside The Store</a></li>
            <li><a id="countryKitchen" href='<?=site_url()?>country-kitchen'>Country Kitchen</a></li>
            <li><a id="plattersAndGifts" href='<?=site_url()?>party-platters'>Platters & Gifts</a></li>
            <li><a id="about" href='<?=site_url()?>about'>About</a></li>
            <li><a id="visitUs" href='<?=site_url()?>visit-us'>Visit Us</a></li>
        </ul>
    </nav>

    <script type="text/javascript">
        $(function(){
          $('nav ul li a').each(function() {
            if ($(this).prop('href') == window.location.href) {
              $(this).addClass('current');
            }
          });
        });
    </script>

    <?php date_default_timezone_set('America/Toronto'); ?>