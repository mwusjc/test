  </header>
<main>
    <div class="row">
        <div class='col-sm-12 text-danger'>
            <?php echo validation_errors(); ?>
        </div>
    </div>
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <h2>Scarborough</h2>
    <p>850 Ellesmere Road </br/>
      Scarborough, ON, M1P 2W5 </br/>
      <a href="https://www.google.ca/maps/dir//830+Ellesmere+Rd,+Scarborough,+ON+M1P+2W4/@43.7651696,-79.2837722,17z/data=!4m13!1m4!3m3!1s0x89d4d18c85f57a1b:0x10c6c8ca7ccfa579!2s830+Ellesmere+Rd,+Scarborough,+ON+M1P+2W4!3b1!4m7!1m0!1m5!1m1!1s0x89d4d18c85f57a1b:0x10c6c8ca7ccfa579!2m2!1d-79.2837722!2d43.7651696" target="_blank" class="scarborough direction green">Get Directions</a></p>
    <p><strong>Store Hours</strong> </br/>
    Mon-Sat: 7:00AM-10:00PM </br/>
    Sun: 8:00AM-8:00PM</p>
	<a target="_blank" href="tel:+14162981999">(416) 298-1999</a>

    <h2 style="margin-top: 50px;">Mississauga</h2>
    <p>50 Matheson Blvd. East </br/>
    Mississauga, ON, L4Z 1N5 </br/>
    <a href="https://www.google.ca/maps/dir/Highland+Farms,+Matheson+Boulevard+East,+Mississauga,+ON//@43.6180221,-79.6594865,15z/data=!4m8!4m7!1m5!1m1!1s0x882b40a400000000:0x9671955aa8a955ae!2m2!1d-79.670644!2d43.620964!1m0" target="_blank" class="mississauga direction green">Get Directions</a></p>

    <p><strong>Store Hours</strong> </br/>
    Mon-Sat: 7:00AM-10:00PM </br/>
    Sun: 8:00AM-8:00PM</p>
    <a  target="_blank" href="tel:+19055019910">(905) 501-9910</a>

    <h2 style="margin-top: 50px;"><strong style="color: #00a64f">Opening Soon:</strong> Vaughan</h2>
    <p>9940 Dufferin Street </br/>
      Vaughan, Ontario, L6A 4K5</br/>
      <a href="https://www.google.ca/maps/dir/9940+Dufferin+St,+Vaughan,+ON+L6A//@43.8593551,-79.4892365,17z/data=!3m1!4b1!4m8!4m7!1m5!1m1!1s0x882b296988ff9a6b:0x746897a2e8081ae5!2m2!1d-79.4870478!2d43.8593513!1m0" target="_blank" class="vaughan direction green">Get Directions</a></p>
    <p><strong>Store Hours</strong> </br/>
    Mon-Sat: 7:00AM-10:00PM </br/>
    Sun: 8:00AM-8:00PM</p>
	<a target="_blank" href="tel:+19058324481">(905)-832-4481</a>
  </div>
  <div class="col-xs-12 col-sm-1">
  </div>
  <div class="col-xs-12 col-sm-8 desktop">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11525.396282766096!2d-79.28310320000003!3d43.76561230000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x9b44a05bb8d40afe!2sHighland+Farms!5e0!3m2!1sen!2sca!4v1443038915026" width="610" height="240" frameborder="0" style="border:0" allowfullscreen></iframe>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3411.0333680487756!2d-79.67259422484713!3d43.62160343674393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b40a400000000%3A0x9671955aa8a955ae!2sHighland+Farms+!5e0!3m2!1sen!2sca!4v1443039231471" width="610" height="240" frameborder="0" style="border:0" allowfullscreen></iframe>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2876.82985394126!2d-79.48923648449214!3d43.85935514709326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b296988ff9a6b%3A0x746897a2e8081ae5!2s9940+Dufferin+St%2C+Vaughan%2C+ON+L6A%2C+Canada!5e0!3m2!1sen!2sca!4v1487861923043" width="610" height="240" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>
<div class="spacer"></div>
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <h2>We're here to help.</h2>

    <p>Trying to locate a difficult-to-find product? Or have a fresh idea that could make your Highland Farms experience even more enjoyable? We'd love to hear from you. Send us an email at <a href="mailto:customerservice@highlandfarms.on.ca" class="green">customerservice@highlandfarms.on.ca</a> or if you prefer, use the form to the right.</p>
  </div>
  <div class="col-xs-12 col-sm-1">
  </div>
  <div class="col-xs-12 col-sm-8">
  	<div class="required-fields">* Required Fields</div>
    <?php 
      $first = filter_input(INPUT_POST, 'first', FILTER_SANITIZE_SPECIAL_CHARS); 
      $last = filter_input(INPUT_POST, 'last', FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
      $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
      $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
      $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
    ?>
    <form method="post" action="" id="form">
      <div class="row">
        <div class="col-xs-12 col-sm-6 visit-us-form-field">
        	<input name="first" class="visit-us-half-width" type="text" value="<?php echo $first; ?>" aria-required="true" aria-label="First Name" placeholder="First Name*" title="First Name should not be left blank." x-moz-errormessage="First Name should not be left blank." required/>
        </div>
      	<div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="last" class="visit-us-half-width" type="text" value="<?php echo $last; ?>" aria-required="false" aria-label="Last Name" placeholder="Last Name*" x-moz-errormessage="Last Name should not be left blank." required/></div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="email" class="visit-us-half-width" type="email" value="<?php echo $email; ?>" aria-required="true" aria-label="Email" placeholder="Email*" x-moz-errormessage="Email should not be left blank." required/></div>
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="phone" class="visit-us-half-width" type="text" value="<?php echo $phone; ?>" aria-required="false" aria-label="Phone Number" placeholder="Phone Number"/></div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="subject" class="visit-us-half-width" type="text" maxlength="150" value="<?php echo $subject; ?>" aria-required="true" aria-label="Subject Line" placeholder="Subject Line*" x-moz-errormessage="Subject line should not be left blank." required /></div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-12 visit-us-form-field"><textarea name="message" value="<?php echo $message; ?>" aria-required="true" aria-label="Your Message" placeholder="Your Message*" title="Message should not be left blank." x-moz-errormessage="Message should not be left blank." required></textarea></div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 visit-us-form-field"><input name="submit" type="submit" aria-label="Submit" value="Submit" class="green" /></div>
      </div>
      <span class="error" id="form-status"></span>
    </form>
  </div>
</div>

</main>

<script type='text/html' id='tpl-product-modal'>
<div class="modal fade otu" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-body">
              <div class="row">
                  <div class="col-s-12 text-center">
                      <h3>Successfully Submitted.</h3>
                  </div>
              </div>
              <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
          </div>
      </div>
  </div>
</div>
</script>