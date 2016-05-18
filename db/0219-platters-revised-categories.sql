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