-- --------------------------------------------------------
-- https://www.assembla.com/spaces/bx_hUmG88r5AL4dmr6CpXy/tickets/new_cardwall?default_list_cardwall=milestone:-2#ticket:142
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE products SET products.order=5 WHERE products.id=36;
UPDATE products SET products.order=2 AND products.name="Homestyle Focaccia" WHERE products.id=26;
UPDATE products SET name=REPLACE(name, 'Homestyle Pizza', 'Homestyle Focaccia') WHERE id=26;
UPDATE products SET products.order=2 WHERE products.order=0 AND products.id=26;
UPDATE products SET products.order=1 AND products.name='Baked 16" Pizza' WHERE products.id=25;
UPDATE products SET products.name=REPLACE(name, 'Gourmet Pizza', 'Baked 16" Pizza') WHERE products.id=25;
UPDATE products SET products.order=1 WHERE products.order=0 AND products.id=25;
UPDATE products SET products.image=REPLACE(image, '/assets/images/country-kitchen/products/ck_ready-meals_gourmet-pizza.jpg', '/assets/images/country-kitchen/products/ck-baked-pizza-16inch.jpg') WHERE products.id=25;
UPDATE products SET products.order=6 WHERE products.id=35;
UPDATE products SET products.order=3 WHERE products.id=22;
UPDATE products SET products.order=4 WHERE products.id=24;
UPDATE products SET products.order=7 WHERE products.id=37;