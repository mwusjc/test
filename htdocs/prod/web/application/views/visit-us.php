<?php
if(isset($_POST['submit'])) {
    // $to = "customerservice@highlandfarms.on.ca";
    $to = "andre.madarang@stjoseph.com";
    $from = $_POST['email'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $email = "From: $first $last<br/>
                    Email: $from<br/>
                    Phone: $phone<br/>
                    Message: " . nl2br($message)
    ;

    send_ses_email($to, "VISIT US: Submission", $email);
    ?>
    <script type='text/javascript'>
        $(function() {
            $('body').append($("#tpl-product-modal").html());
            $('#detailModal').modal('show');
        });
    </script>
    <?php
}
?>
  </header>
<main>
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <h2>Scarborough</h2>
    <p>850 Ellesmere Road </br/>
      Scarborough, ON, M1P 2W5 </br/>
      <a href="https://www.google.ca/maps/dir//830+Ellesmere+Rd,+Scarborough,+ON+M1P+2W4/@43.7651696,-79.2837722,17z/data=!4m13!1m4!3m3!1s0x89d4d18c85f57a1b:0x10c6c8ca7ccfa579!2s830+Ellesmere+Rd,+Scarborough,+ON+M1P+2W4!3b1!4m7!1m0!1m5!1m1!1s0x89d4d18c85f57a1b:0x10c6c8ca7ccfa579!2m2!1d-79.2837722!2d43.7651696" target="_blank" class="green">Get Directions</a></p>
    <p><strong>Store Hours</strong> </br/>
    Mon-Sat: 7:00AM-10:00PM </br/>
    Sun: 8:00AM-8:00PM</p>
	<a target="_blank" href="tel:+14162981999">(416) 298-1999</a>

    <h2 style="margin-top: 50px;">Mississauga</h2>
    <p>50 Matheson Blvd. East </br/>
    Mississauga, ON, L4Z 1N5 </br/>
    <a href="https://www.google.ca/maps/dir/Highland+Farms,+Matheson+Boulevard+East,+Mississauga,+ON//@43.6180221,-79.6594865,15z/data=!4m8!4m7!1m5!1m1!1s0x882b40a400000000:0x9671955aa8a955ae!2m2!1d-79.670644!2d43.620964!1m0" target="_blank" class="green">Get Directions</a></p>

    <p><strong>Store Hours</strong> </br/>
    Mon-Sat: 7:00AM-10:00PM </br/>
    Sun: 8:00AM-8:00PM</p>
    <a  target="_blank" href="tel:+19055019910">(905) 501-9910</a>
  </div>
  <div class="col-xs-12 col-sm-1">
  </div>
  <div class="col-xs-12 col-sm-8 desktop">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11525.396282766096!2d-79.28310320000003!3d43.76561230000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x9b44a05bb8d40afe!2sHighland+Farms!5e0!3m2!1sen!2sca!4v1443038915026" width="610" height="240" frameborder="0" style="border:0" allowfullscreen></iframe>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3411.0333680487756!2d-79.67259422484713!3d43.62160343674393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b40a400000000%3A0x9671955aa8a955ae!2sHighland+Farms+!5e0!3m2!1sen!2sca!4v1443039231471" width="610" height="240" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>
<div class="spacer"></div>
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <h2>We're here to help.</h2>

    <p>Trying to locate a difficult-to-find product?
Or have a fresh idea that could make your Highland Farms experience even more enjoyable? We'd love to hear from you.</p>
  </div>
  <div class="col-xs-12 col-sm-1">
  </div>
  <div class="col-xs-12 col-sm-8">
    <form method="post" action="" id="form">
      <div class="row">
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="first" class="visit-us-half-width" type="text" value="" aria-required="false" aria-label="First Name" placeholder="First Name"/></div>
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="last" class="visit-us-half-width" type="text" value="" aria-required="false" aria-label="Last Name" placeholder="Last Name"/></div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="email" class="visit-us-half-width" type="text" value="" aria-required="false" aria-label="Email" placeholder="Email"/></div>
        <div class="col-xs-12 col-sm-6 visit-us-form-field"><input name="phone" class="visit-us-half-width" type="text" value="" aria-required="false" aria-label="Phone Number" placeholder="Phone Number"/></div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 visit-us-form-field"><textarea name="message" value="" aria-required="false" aria-label="Your Message" placeholder="Your Message"></textarea></div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 visit-us-form-field"><input name="submit" type="submit" aria-label="Submit" value="Submit" class="green" /></div>
      </div>
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