-- --------------------------------------------------------
-- https://www.assembla.com/spaces/www-highlandfarms-ca/tickets/new_cardwall#ticket:161
-- --------------------------------------------------------
USE `webdev_hlf`;
UPDATE platters SET platters.Description=REPLACE(description, 'A seasonal selection of premium fresh fruits that\'ll sweeten any gathering.', 'A little touch of sweetness will go far for any type of occasion. Tempt your guests with our selection of fresh pastries.') WHERE platters.id=6;