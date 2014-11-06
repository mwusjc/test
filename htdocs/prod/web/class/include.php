<?php
/* ************************************************************************************************************ *
**	 Common classes first - these will change very rarely
***************************************************************************************************************/

# settings - must be loaded first
require "settings/settings.php";

# base classes - always the same, four versions: minimal/basic/standard/full
require "_common/class/include.php";

# modules list
require_once "class/modules.php";
include("_common/class/core/title.main.class.php");

/* ************************************************************************************************************ *
**	 Custom modules - these are unique to each application
***************************************************************************************************************/
require "_common/class/core/access.class.php";

# main document
require "class/core/tbf.class.php";
require "class/modules/home/home.manager.class.php";


# users
require "class/modules/users/user.class.php";
require "class/modules/users/user.manager.class.php";


require "class/modules/flyers/flyer.manager.class.php";
require "class/modules/highland.class.php";


?>