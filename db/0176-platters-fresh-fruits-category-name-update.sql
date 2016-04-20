-- --------------------------------------------------------
-- https://www.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:161
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE platters_categories SET platters_categories.Name=REPLACE(name, 'Fresh Fruits & Sweets', 'Divine Desserts') WHERE platters_categories.id=2;