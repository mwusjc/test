	if ( getenv('DB_PORT') ) {
		var $mHost	= getenv('DB_PORT_3306_TCP_ADDR');
		var $mUser	= getenv('DB_ENV_MYSQL_USER');
		var $mDb	= getenv('DB_ENV_MYSQL_DATABASE');
		var $mPass	= getenv('DB_ENV_MYSQL_PASSWORD');
	} else {
		var $mHost	= "valhalla-prod.cb1qb4plxjpf.us-east-1.rds.amazonaws.com";
		var $mUser	= "highland";
		var $mDb	= "highland";
		var $mPass	= "1mn9alXLS65zYbK3pHxRgjC";
	}
