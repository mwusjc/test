<?php

date_default_timezone_set('UTC');

# Control Settings
DEFINE("INI_TEST_MODE", true);#VERISIGN USER NAME

DEFINE("INI_MOD_REWRITE", false);#DB DATABASE NAME
DEFINE("INI_ENABLE_LOG", false);#DB DATABASE NAME
DEFINE("INI_ENABLE_TRACKING", false);#DB DATABASE NAME
DEFINE("INI_ADVANCED_TRACKING",false);#TRACK VISITS
DEFINE("INI_USE_COOKIES", "1");#USE COOKIES TO REMEMBER LOGGED USERS?
DEFINE("INI_COOKIE_EXPIRATION", 86400000);#COOKIES EXPIRE AFTER THIS PERIOD
DEFINE("APP_USE_EXTENDED_USER_SETTINGS",1);#USE EXTENDED USER SETTINGS - ADDITIONAL USER TABLE

# Content Settings
DEFINE("INI_SECRET_CODE", "abcde");#VERISIGN USER NAME
DEFINE("APP_TITLE", "Highland Farms, Grocery Stores, Toronto, York Region, GTA");#DB DATABASE NAME
DEFINE("APP_TITLE_SHORT", "Highland Farms Supermarkets");#DB DATABASE NAME

# Email Settings
DEFINE("EMAIL_FROM_ADDRESS", "admin@kermit.sjc.io");#DB DATABASE NAME
DEFINE("EMAIL_FROM_NAME", "Highland Farms");#DB DATABASE NAME

# System Settings
DEFINE("APP_ADMIN_EMAIL", "admin@kermit.sjc.io");#ADMIN EMAIL - SYSTEM EMAILS WILL BE SENT TO THIS ADDRESS
DEFINE("APP_BASE_DOMAIN","highlandfarms.kermit.sjc.io");#BASE DOMAIN
DEFINE("APP_DOMAIN","highlandfarms.kermit.sjc.io");#BASE DOMAIN INCLUDING SUBDIRECTORIES
DEFINE("APP_SERVER_NAME","http://highlandfarms.kermit.sjc.io/");#HTTP ADDRESS
DEFINE("APP_SERVER_NAME_SECURE","https://highlandfarms.kermit.sjc.io/");#HTTPS ADDRESS
DEFINE("APP_SITE_NAME","Highland Farms");#SITE ADDRESS IN NICE FORMAT (DISPLAY ONLY)
DEFINE("APP_CMS_PATH","http://highlandfarms.kermit.sjc.io/");#APPLICATION BASE PATH

if (getenv('DB_PORT')) {
	DEFINE("INI_DB_SERVER", getenv('DB_PORT_3306_TCP_ADDR'));
	DEFINE("APP_BASE_PATH","/var/www/html/");#APPLICATION BASE PATH
} else {
	DEFINE("INI_DB_SERVER", "valhalla-prod.cb1qb4plxjpf.us-east-1.rds.amazonaws.com");
	DEFINE("APP_BASE_PATH","/var/www/domains/highlandfarms/prod/web/");#APPLICATION BASE PATH
}

DEFINE("INI_DB_USER", "highland"); #DB USER NAME
DEFINE("INI_DB_PWD", "1mn9alXLS65zYbK3pHxRgjC");# DB PASSWORD
DEFINE("INI_DB_DB", "highland");#DB DATABASE NAME

DEFINE("APP_GOOGLE_API_KEY", 'ABQIAAAAkhIsL1cb4s_nBtpXYulOuBTplAeJXmY058aE1BpQStzwi0tqsRQiRZQ65zqUuAX2m51bwLK0EJfLuw');#DB DATABASE NAME
DEFINE("IM_PATH", 'C:\\Program Files\\ImageMagick\\');#DB DATABASE NAME
?>