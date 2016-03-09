-- --------------------------------------------------------
-- https://sjc-istudio.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall?tab=activity#ticket:142
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE products SET products.name=REPLACE(name, 'Perogies', 'Roasted BBQ Chicken') WHERE products.id=35;
UPDATE products SET products.description=REPLACE(description, 'Treat yourself to our freshly prepared perogies. Cooked to perfection – they’re crispy on the outside, soft on the inside.', 'Cooked to perfection, our juicy and saucy whole chicken is ready to be enjoyed. Get that BBQ deliciousness all year round.') WHERE products.id=35;
UPDATE products SET products.image=REPLACE(image, '/assets/images/country-kitchen/products/ck_ready-meals_perogies.jpg', '/assets/images/country-kitchen/products/ck-roasted-bbq-chicken.jpg') WHERE products.id=35;
INSERT INTO products (category, name, subtitle, description, image, qty, qty_type, bread_type, `order`, item_order) VALUES(6, 'Fully Cooked Pork Back Ribs', NULL, 'Covered in sauce, our fall-off-the-bone ribs are made fresh in store. You\'ll love the flavours of this classic comfort food.', '/assets/images/country-kitchen/products/ck-cooked-pork-back-ribs.jpg', NULL, NULL, NULL, 8, NULL);