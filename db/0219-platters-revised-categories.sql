-- --------------------------------------------------------
-- https://www.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:219
-- --------------------------------------------------------
USE `webdev_hlf`;
INSERT INTO platters_categories (Name, Status, `TimeStamp`, UserID, OrderID) VALUES('Party Platters', 'enabled', 0, 0, 4);
INSERT INTO platters_categories (Name, Status, `TimeStamp`, UserID, OrderID) VALUES('Fabulous Fruits', 'enabled', 0, 0, 5);
INSERT INTO platters_categories (Name, Status, `TimeStamp`, UserID, OrderID) VALUES('Flowers & Gift Baskets', 'enabled', 0, 0, 8);
UPDATE platters_categories SET platters_categories.Name=REPLACE(name, 'Special Order Cakes, Flowers & Gifts', 'Special Order Cakes') WHERE platters_categories.id=4;
UPDATE platters_categories SET platters_categories.OrderID=REPLACE(orderID, '7', '6') WHERE platters_categories.id=6;
UPDATE platters_categories SET platters_categories.OrderID=REPLACE(orderID, '5', '7') WHERE platters_categories.id=4;
UPDATE platters_categories SET platters_categories.OrderID=REPLACE(orderID, '4', '6') WHERE platters_categories.id=2;
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Perogies & Dip', 3, 34.99, '', '', 'images/pp_pop_perogies.jpg', 0, 0, 'enabled', '40 pcs. Serves 8 - 12', NULL, NULL, 'Golden brown and crispy on the outside, each perogi is stuffed with potato and cheese goodness. Serve it with your favourite dip: Chunky Blue Cheese, Roasted Red Pepper, Artichoke & Asiago or Avocado Hummus.');
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Flavours of the World', 3, 39.99, '', '', 'images/pp_pop_flavours_of_the_world.jpg', 0, 0, 'enabled', 'Serves 8 - 10', NULL, NULL, 'Travel the globe with our international-inspired cheese platter, featuring grana padano, beemster, auricchio and manchego.');
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '1', '3') WHERE platters.id=16;
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Flavours of Italy', 3, 39.99, '', '', 'images/pp_pop_flavours_of_italy.jpg', 0, 0, 'enabled', 'Serves 8 - 10', NULL, NULL, 'Feast on a traditional platter of Italian cold cuts, Genoa salami, pancetta, parma prosciutto, culatello, auricchio, dry olives and dry figs.');
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Flavours of Spain', 3, 39.99, '', '', 'images/pp_pop_flavours_of_spain.jpg', 0, 0, 'enabled', 'Serves 8 - 10', NULL, NULL, 'Take your guests on a Spanish flavour adventure. Enjoy our platter of manchego cheese, serrano ham, chorizo sausage, almond stuffed olives, grilled eggplant and stuffed cherry peppers');
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Flavours of Paris', 3, 39.99, '', '', 'images/pp_pop_flavours_of_paris.jpg', 0, 0, 'enabled', 'Serves 8 - 10', NULL, NULL, 'A unique and delicious assortment of French And local cheeses, including double crème brie, chèvre noir and sauvagine.');
INSERT INTO platters (Name, CategoryID, Price, Price2, Price3, Image, `TimeStamp`, UserID, Status, Quantity, Quantity2, Quantity3, Description) VALUES('Deli Delight', 1, 49.99, '', '', 'images/pp_pop_deli_delight.jpg', 0, 0, 'enabled', '14” Serves 8 - 12', NULL, NULL, 'Enjoy a selection of your favourite deli sandwiches on rye bread and filled with smoked meats. Of course, it wouldn’t be complete without a side of pickles!');
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '3', '8') WHERE platters.id=11;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '3', '8') WHERE platters.id=8;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '3', '8') WHERE platters.id=9;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '3', '8') WHERE platters.id=24;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '2', '9') WHERE platters.id=4;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '4', '10') WHERE platters.id=29;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '4', '10') WHERE platters.id=30;
UPDATE platters SET platters.Status=REPLACE(Status, 'enabled', 'disabled') WHERE platters.id=20;
UPDATE platters SET platters.Status=REPLACE(Status, 'enabled', 'disabled') WHERE platters.id=23;
UPDATE platters SET platters.Status=REPLACE(Status, 'enabled', 'disabled') WHERE platters.id=26;
UPDATE platters SET platters.Status=REPLACE(Status, 'enabled', 'disabled') WHERE platters.id=10;
UPDATE platters SET platters.Status=REPLACE(Status, 'enabled', 'disabled') WHERE platters.id=28;
UPDATE platters SET platters.Description=REPLACE(Description, 'A healthy and delicious option for your guests. We pile on the fresh veggies and add a flavourful dip. It makes a fresh, colourful centrepiece.', 'A healthy and delicious option that makes a colourful centrepiece. We pile on the fresh veggies and add a flavour dip. We recommend Classic Ranch.') WHERE platters.id=7;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, '16"', '14” Serves 8 - 12') WHERE platters.id=7;
UPDATE platters SET platters.Description=REPLACE(Description, 'This platter has deliciousness all rolled up. We\'ve taken our pitas and filled them with deli meats and cheeses, and rolled everything up for a colouful display.', 'A meat lover\’s dream come true! Freshly sliced roast beef, smoked turkey, corned beef, Black Forest ham and cooked chicken are accented with olives and cherry tomatoes') WHERE platters.id=11;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, '14"', '14” Serves 8 - 12') WHERE platters.id=11;
UPDATE platters SET platters.Description=REPLACE(Description, 'The perfect bite-sized snack filled with corned beef, Black Forest ham, turkey breast and Havarti cheese.', 'A feast for your senses! Specially selected roast beef, Black Forest ham, and smoked chicken are paired with the finest havarti and marble/mild cheddar.') WHERE platters.id=8;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, '14"', '14” Serves 8 - 12') WHERE platters.id=8;
UPDATE platters SET platters.Price=REPLACE(Price, '29.99', '39.99') WHERE platters.id=8;
UPDATE platters SET platters.Price2=REPLACE(Price2, '39.99', '') WHERE platters.id=8;
UPDATE platters SET platters.Price3=REPLACE(Price3, '49.99', '') WHERE platters.id=8;
UPDATE platters SET platters.Quantity2=REPLACE(Quantity2, '16"', NULL) WHERE platters.id=8;
UPDATE platters SET platters.Quantity3=REPLACE(Quantity3, '18"', NULL) WHERE platters.id=8;
UPDATE platters SET platters.Description=REPLACE(Description, 'Made with fresh buns from our bakery, these mini sandwiches stuffed with black forest ham, turkey breast and havarti cheese will satisfy your hungry crowd.', 'Serve up our hearty subs filled with freshly sliced turkey, Black Forest ham and havarti cheese.') WHERE platters.id=9;
UPDATE platters SET platters.Price=REPLACE(Price, '49.99', '59.99') WHERE platters.id=9;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, '14"', '14” Serves 8 - 12') WHERE platters.id=9;
UPDATE platters SET platters.Price2=REPLACE(Price2, '59.99', '') WHERE platters.id=9;
UPDATE platters SET platters.Quantity2=REPLACE(Quantity2, '16"', NULL) WHERE platters.id=9;
UPDATE platters SET platters.Description=REPLACE(Description, 'This saucy dish of juicy wings is the MVP of every game night. Choose between hot, medium or mild. And of course, it wouldn\'t be complete without the classic Blue Cheese dip.', 'These juicy wings, with a classic Blue Cheese dip, are the MVP of every game night. Choose your style of spice: mild, medium or hot. If you\’re game, try another dip flavour: Roasted Red, Pepper, Artichoke & Asiago or Avocado Hummus.') WHERE platters.id=24;
UPDATE platters SET platters.Price=REPLACE(Price, '34.99', '39.99') WHERE platters.id=24;
UPDATE platters SET platters.Price2=REPLACE(Price2, '59.99', '') WHERE platters.id=24;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, '24 pcs', '40 pcs. Jumbo wings & dip. (Mild, Medium or Hot) \n Serves 8 - 12') WHERE platters.id=24;
UPDATE platters SET platters.Quantity2=REPLACE(Quantity2, '50 pcs', NULL) WHERE platters.id=24;
UPDATE platters SET platters.Name=REPLACE(Name, 'Wing Party', 'Jumbo Wings & Dip') WHERE platters.id=24;