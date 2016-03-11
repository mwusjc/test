-- --------------------------------------------------------
-- https://www.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:74
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, 'regular', NULL) WHERE platters.id=29;
UPDATE platters SET platters.Quantity=REPLACE(Quantity, 'regular', NULL) WHERE platters.id=30;