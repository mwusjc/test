
  <div class="herobanner responsive">
    <img src="<?=site_url()?>assets/images/ck_banner_sep23_tn-logo-flatten.jpg" />
  </div>
  <div class="country-kitchen">
    <div class="wrapper">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
         <h1>Only Available at Highland Farms </h1>
          <h2>Prepared with the finest ingredients from traditional home-made recipes, 
    every delicious Country Kitchen dish is a comforting celebration of life and food.</h2>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <img src="images/ck_vodka_tn.jpg">
          </div>
          <div class="col-xs-12 col-sm-6">
            <h2>Gourmet Creamy Vodka Sauce 473mL</h2>
            <p><strong>Rich &amp; Creamy Flavour You Will Love</strong></p>
            <p>Our All Natural Gourmet Vodka Sauce is made with the finest natural ingredients. Smother your dishes in the perfect blend of lush tomatoes and rich cream. The exquisite flavour will make it on of your familyâ€™s favourites.</p>
            <input type="button" value="Add to Shopping List" class="green"/>
          </div>
        </div>
        <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
      </div>
    </div>
  </div>
</div>

<main>

<div class="row">
  <div class="col-xs-12 col-sm-3">
    <ul role="tablist">
      <li role="presentation"><a href="#dessert" aria-controls="home" role="tab" data-toggle="tab">Baked Goods</a></li>
      <li role="presentation"><a href="#international" aria-controls="profile" role="tab" data-toggle="tab">Food-to-Go</a></li>
      <li role="presentation"><a href="#meat" aria-controls="messages" role="tab" data-toggle="tab">Sauces &amp; Condiments</a></li>
      <li role="presentation"><a href="#pasta" aria-controls="settings" role="tab" data-toggle="tab">Alternatives</a></li>
    </ul>
  </div>
  <div class="col-xs-12 col-sm-9">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="all">
        <div class="row">
          <div class="col-xs-12 col-sm-4"><a href="" data-toggle="modal" data-target="#myModal"><img src="<?=site_url()?>assets/images/ck_lasagnameatsauce_tn.jpg" />Homestyle Lasagna with Meat Sauce</a></div>
          <div class="col-xs-12 col-sm-4"><a href="" data-toggle="modal" data-target="#myModal"><img src="<?=site_url()?>assets/images/ck_vealcannelloni_tn.jpg" />Homestyle Veal Cannelloni</a></div>
          <div class="col-xs-12 col-sm-4"><a href="" data-toggle="modal" data-target="#myModal"><img src="<?=site_url()?>assets/images/ck_3cheesecannelloni_tn.jpg" />Homestyle Three Cheese Cannelloni</a></div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_pizza_tn.jpg" />Gourmet Pizza Sauce 473ml</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_vodka_tn.jpg" />Gourmet Creamy Vodka Sauce 473ml</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_garlic_tn.jpg" />Gourmet Roasted Garlic Sauce 1L</div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_basil_tn.jpg" />Gourmet Tomato Basil Sauce 1L</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_spicy_tn.jpg" />Gourmet Creamy Hot &amp; Spicy Sauce 1L</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_pies_tn.jpg" />Homestyle Baked Pies</div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_100Wheat-Slice-Bread_v1_tn.jpg" />Flax Seed Bread</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_100Wheatt-Slice-Bread_v2_tn.jpg" />100% Whole Wheat Bread</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_FlaxSeed-Slice-Bread_tn.jpg" />Enriched White Bread</div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_dryroastedalmonds_tn.jpg" />Homestyle Dry Roasted Almonds</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_dryroastedalmondssalted_tn.jpg" />Homestyle Dry Roasted Salted Almonds</div>
          <div class="col-xs-12 col-sm-4"><img src="<?=site_url()?>assets/images/ck_naturalpistachios_tn.jpg" />Homestyle Natural Pistachios</div>
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