-- --------------------------------------------------------
-- 
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE products SET products.order=3 WHERE products.id=24;
UPDATE products SET products.order=6 WHERE products.id=36;
UPDATE products SET products.order=7 WHERE products.id=35;
UPDATE products SET products.order=8 WHERE products.id=37;
UPDATE products SET products.order=9 WHERE products.id=40;
INSERT INTO products (category, name, subtitle, description, image, qty, qty_type, bread_type, `order`, item_order) VALUES(6, 'Parisienne Potatoes', NULL, 'Enjoy our delicious Parisienne potatoes. They\’re perfectly crispy on the outside and fluffy on the inside.', '/assets/images/country-kitchen/products/ck_ready-meals_parisienne-potatoes.jpg', NULL, NULL, NULL, 4, NULL);
INSERT INTO products (category, name, subtitle, description, image, qty, qty_type, bread_type, `order`, item_order) VALUES(6, 'Scalloped Potatoes', NULL, 'So rich and creamy, it\’ll be love at first bite with our freshly prepared scalloped potatoes.', '/assets/images/country-kitchen/products/ck_ready-meals_scalloped-potatoes.jpg', NULL, NULL, NULL, 5, NULL);
