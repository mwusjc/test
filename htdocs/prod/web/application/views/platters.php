
  <div class="herobanner responsive">
    <img src="<?=site_url()?>assets/images/pp_banner.jpg" />

    <div class="wrapper">
      <div class="caption">
        <h1 style="color:black;">Party Platters &amp; More</h1>
        <input type="button" value="Place an order" data-toggle="modal" data-target="#myModal" class="green">
      </div>
    </div>
  </div>
</header>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body padding">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <h2>Scarborough</h2>
            <p>(416)-298-1999</p>

            <p>850 Ellesmere Road </br>
            Scarborough, M1P 2W5</p>

            <p>Mon-Sat: 7:00am-10:00pm </br>
            Sun: 9:00am-8:00pm</p>
          </div>
          <div class="col-xs-12 col-sm-6">
            <h2>Mississauga</h2>
            <p>(905)-501-9910</p>

            <p>50 Matheson Blvd. East </br>
            Mississauga, L4Z 1N5</p>

            <p>Mon-Sat: 7:00am-10:00pm </br>
            Sun: 9:00am-8:00pm</p>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <input type="button" data-dismiss="modal" value="Download order form" />
          </div>
        </div>
        <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
      </div>
    </div>
  </div>
</div>

<main>
<div class="row">
  <div class="col-xs-12 col-sm-12">
     <h1>Fresh Ideas For Your Next Event </h1>
    <h2>You have enough to worry about with your upcoming party. Leave the finger food to us. Simply reserve online and we'll have everything fresh and ready for your big day.</h2>
  </div>
</div>
<div class="row divider spacer"></div>
&nbsp;
<div class="row">
  <div class="col-xs-12 col-sm-3">
    <ul role="tablist">
      <li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab">Breakfast Bites</a></li>
      <li role="presentation"><a href="#international" aria-controls="profile" role="tab" data-toggle="tab">Deli, Cheese, Vegetables and Seafood</a></li>
      <li role="presentation"><a href="#meat" aria-controls="messages" role="tab" data-toggle="tab">Party Platters</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Fabulous Fruits</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Devine Deserts</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Special Order Cakes, Flowers &amp; Gift Baskets</a></li>
    </ul>
  </div>
  <div class="col-xs-12 col-sm-9">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="all">
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_BagelBonanza.jpg" /><strong>$29.99</strong> <span class="break">2 dozen</span> Bagel Delight</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_SunshineBreakfast.jpg" /><strong>$34.99</strong> <span class="break">14" </span> Sweet Mornings</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_antipasto.jpg" /><strong>$49.99</strong> <span class="break">14" </span> Antipasto Perfecto</div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_pop_deli_meat_cheese_fiesta.jpg" /><strong>$39.99</strong> <span class="break">14"+</span> Savoury Delights</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_pop_deli_meat_banquet.jpg" /><strong>$49.99</strong> <span class="break">14"+</span> Meat Your Match</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/pp_european_meat_tn.jpg" /><strong>$49.99</strong> <span class="break">14" </span> European Flair</div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="dessert"><h1>Baked Goods</h1></div>
      <div role="tabpanel" class="tab-pane" id="international"><h1>Food-to-go</h1></div>
      <div role="tabpanel" class="tab-pane" id="meat"><h1>Sauces &amp; condiments</h1></div>
      <div role="tabpanel" class="tab-pane" id="pasta"><h1>Alternatives</h1></div>
    </div>
  </div>
</div>
</main>