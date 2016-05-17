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