<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>

<style type="text/css">
	.ckitem {
		width: 168px;
		min-height: 230px;
		text-align: center;
		display: inline-block;
		vertical-align: bottom;
	}
	.ckitem > a.imgcontainer {
		display: inherit;
	}
	.ckitem > a.bttnplus1 {
		display: inline-block;
		text-align: right;
		width: 80%;
	}
	.ckitem img {
		max-width: 150px;
		max-height: 180px;
		clear: both;
	}
	#p4, #p5 {
		width: 75px;
	}
	#p4 {
		padding-top: 51px;
	}
	#p5 {
		padding-top: 60px;
	}
	#p7, #p8 {
		width: 85px;
	}
	#p9 {
		padding-top: 15px;
	}
</style>

<?php
function showPrivateLabel($Name,$Summary,$Image) {
	return array(
		"Name" => $Name,
		"Summary" => $Summary,
		"Image" => $Image
	);
}

function shimmy($Name,$Headline,$Copy,$imgname){
	$Summary = '<b>' . $Headline . '</b><p>' . $Copy . '</p>';
	$Image = '/images/HF-38/'.$imgname.'.jpg';
	return showPrivateLabel($Name,$Summary,$Image);
}

$prods = array(
	array(
		"Name" => 'Homestyle Lasagna with Meat Sauce',
		"Summary" => '&lt;b&gt;Homemade Taste, Without the Effort!&lt;/b&gt;&lt;br&gt;&lt;br&gt;Our Homestyle Lasagna with Meat Sauce is made from premium quality durum semolina, covered in delicious Parmesan cheese. The meat sauce is a zesty blend of ripe tomatoes and tender beef, perfectly seasoned with fine herbs and spices. No preservatives added, so you get the exquisite natural flavour.&lt;br&gt;',
		"Image" => '/images/ck_lasagnameatsauce_tn.jpg'
	),
	showPrivateLabel('Homestyle Veal Cannelloni', '<b>Veal Cannelloni</b><br><br>Only the freshest, most tender, 100% veal is used to make this Cannelloni recipe. Slow-cooked to bring out all the flavour, and mixed with your favourite spices, our Veal Cannelloni is a great idea for your dinner.<br><br>', '/images/ck_vealcannelloni_tn.jpg'),
	showPrivateLabel('Homestyle Three Cheese Cannelloni', '<b>Three Cheese Cannelloni</b><br><br>This universal Italian favourite includes three of the finest cheeses, Ricotta, Mozzarella and Parmesan in a base of pure durum semolina, flavoured with a mixture of oregano and other exotic spices. It comes pre-cooked, all you need to do is pop it in the oven, and enjoy!<br>', '/images/ck_3cheesecannelloni_tn.jpg'),
	showPrivateLabel('Gourmet Pizza Sauce','<b>Pizza night will taste even better</b><p>The secret to a great pizza is this all natural sauce made with perfectly ripe tomatoes and a pinch of fine herbs and spices. Its fresh, rustic flavour brings out the deliciousness of all your favourite toppings.</p>','/images/HF-38/pizza.jpg'),
	showPrivateLabel('Gourmet Creamy Vodka Sauce','<strong>Rich & Creamy Flavour You Will Love</strong><p>Our All Natural Gourmet Vodka Sauce is made with the finest natural ingredients. Smother your dishes in the perfect blend of lush tomatoes and rich cream. The exquisite flavour will make it on of your family’s favourites.</p>','/images/HF-38/vodka.jpg'),
	shimmy('Gourmet Roasted Garlic Sauce','Delicious Garlic Goodness','Our All Natural Gourmet Roasted Garlic Tomato Sauce accents the pure taste of our tomato Sauce. A unique blend of roasted garlic with delicate hints of select herbs and spices produces a sauce that makes everyday dishes sing.','garlic'),
	shimmy('Gourmet Tomato Basil Sauce','Pure Taste of Tomato','Our All Natural Gourmet Tomato Basil Sauce brings the pure taste of tomato to your everyday dishes. Only the freshest, juiciest tomatoes are chosen and slow-cooked with a unique blend of herbs and spices to mix all the delicate flavours. The result is a sauce that makes even ordinary dishes come alive!','basil'),
	shimmy('Gourmet Creamy Hot & Spicy Sauce','The Hot Favourite!','Our All Natural Gourmet Hot & Spicy Sauce is the perfect way to spice up your pasta dishes. This delicious blend of farm-fresh tomatoes, vegetables and Highland Farms’ special seasoning is slow-cooked to release all the delicious flavour and aroma. Mmm..marvellous!!','spicy'),
	showPrivateLabel('Homestyle Butter', '<b>Butter</b><br><br>Available in salted, partly salted and unsalted varieties, our Butter has that typical farm-fresh taste that Highland Farms is known for.<br><br>', 'images/ck_butter_tn.jpg'),
	showPrivateLabel('Homestyle Dry Roasted Almonds', '<b>The Perfect Nutritious Snack. </b><br><br>Dry roasted to perfection and full of delicious and rich flavours, Country Kitchen Almonds make for the perfect nutritious snack.<br>', 'images/ck_dryroastedalmonds.jpg'),
	showPrivateLabel('Homestyle Dry Roasted Salted Almonds', '<b>Delicious and Rich Flavour </b><br><br>Salted and dry roasted to perfection, Country Kitchen Almonds are full of delicious and rich flavours, making for the perfect nutritious snack.<br>', 'images/ck_dryroastedalmondssalted.jpg'),
	showPrivateLabel('Homestyle Natural Pistachios', '<b>Rich In Natural Flavour </b><br><br>Ideal for cooking and entertaining, Country Kitchen Natural Pistachios are rich in natural flavour and perfect pick for everyday snacking.<br>', 'images/ck_naturalpistachios.jpg'),
	showPrivateLabel('Homestyle Baked Pies', '<b>Like Mom Used To Make! </b><br><br>Our Homestyle Baked Pies have that special home-made taste. Choose from such favourites as apple, cherry, blueberry, bumbleberry, peaches &amp; cream and rhubarb-strawberry. Or try our special sugar-free Baked Pies. They have the same delicious flavour and texture. Enjoy!<br>', 'images/ck_pies_tn.jpg'),
	showPrivateLabel('Homestyle Panettone Fruit Cake', '<b>Panettone Fruit Cake</b><br><br>Made from sultana raisins and an assortment of glazed fruits, our Panettone Cake is great for any occasion, and makes an ideal gift for your loved ones. <br><br>', 'images/ck_pannetone_tn.jpg')
);
?>

<body onLoad="MM_preloadImages('images/bttn_plus_over.gif')">
	<div class="ckbanner"> <img src="../../images/temp_kcflashholder.jpg" alt="Ontario Homegrown Friesh Field Tomatoes" border="0"></div>
	<div class="ckcontainer">
		<div class="left"></div>
		<div class="right">
			<?php
			$kount = 0;
			foreach ($prods as $prod) {
				$kount++;
				?>
				<div class="ckitem" style="cursor:pointer" onClick="showPrivateLabel('<?php echo $prod['Name'] ?>', '<?php echo $prod['Summary'] ?>', '<?php echo $prod['Image'] ?>');">
					<a class="imgcontainer" href="#self" target="_self"><img id="p<?php echo $kount ?>" src="<?php echo $prod['Image'] ?>" alt="Homestyle Lasagna with Meat Sauce"  border="0"></a><a href="#self" target="_self" class="bttnplus1"><img src="/images/bttn_plus.gif" name="bttnplus1" width="18" height="16" border="0" id="bttnplus1" onMouseOver="MM_swapImage('bttnplus1','','/images/bttn_plus_over.gif',1)" onMouseOut="MM_swapImgRestore()"></a>
					<center><div class="ckitemtxt" align="center" style="width: 97px;margin-right: 2px;"> <?php echo $prod['Name'] ?></div></center>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</body>