-- --------------------------------------------------------
-- https://sjc-istudio.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:195
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE platters_categories SET platters_categories.OrderID=REPLACE(orderID, '3', '2') WHERE platters_categories.id=3;
UPDATE platters_categories SET platters_categories.OrderID=REPLACE(orderID, '2', '3') WHERE platters_categories.id=1;
UPDATE platters_categories SET platters_categories.Name=REPLACE(name, 'Deli, Cheese, Vegetables & Seafood', 'Deli, Cheese & Vegetables') WHERE platters_categories.id=1;