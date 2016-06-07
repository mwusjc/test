-- --------------------------------------------------------
-- https://www.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:223
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE platters SET platters.Status=REPLACE(Status, 'disabled', 'enabled') WHERE platters.id=28;
UPDATE platters SET platters.CategoryID=REPLACE(CategoryID, '4', '10') WHERE platters.id=28;
UPDATE platters SET platters.VisualOrder=REPLACE(VisualOrder, '0', '3') WHERE platters.id=28;