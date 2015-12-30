<?php
/* ************************************************************************************************************ *
**	 Common classes first - these will change very rarely
***************************************************************************************************************/

date_default_timezone_set('America/Toronto');

# settings - must be loaded first
require_once "settings/settings.php";

# base classes - always the same, four versions: minimal/basic/standard/full
require_once "_common/class/include_admin.php";

# modules list
require_once "class/modules.php";




/* ************************************************************************************************************ *
**	 Custome modules - these are unique to each application
***************************************************************************************************************/


# home
require_once "class/modules/home/home.admin.class.php";

# users
require "class/modules/users/user.admin.class.php";
require "class/modules/users/user.class.php";

require "_common/class/core/button.class.php";
require "_common/class/core/title.class.php";
require "_common/class/core/access.class.php";

require "class/modules/users/usergroup.admin.class.php";
require "class/modules/users/usergroup.class.php";

require "class/modules/flyers/flyer.admin.class.php";
require "class/modules/flyers/flyer.class.php";
require "class/modules/flyers/flyer.page.class.php";

require "class/modules/brands/brand.admin.class.php";
require "class/modules/brands/brand.class.php";

require "class/modules/categories/category.admin.class.php";
require "class/modules/categories/category.class.php";

require "class/modules/products/product.admin.class.php";
require "class/modules/products/product.class.php";
require "class/modules/products/product.new.class.php";

require "class/modules/stores/store.admin.class.php";
require "class/modules/stores/store.class.php";

require "class/modules/platters/platter.admin.class.php";
require "class/modules/platters/platter.class.php";

require "class/modules/recipes/recipe.admin.class.php";
require "class/modules/recipes/recipe.class.php";

require "class/modules/orders/order.admin.class.php";
require "class/modules/orders/order.class.php";

require "class/modules/jobs/job.admin.class.php";
require "class/modules/jobs/job.class.php";
require "class/modules/jobs/position.admin.class.php";
require "class/modules/jobs/position.class.php";

require "class/modules/private_label/private.label.admin.class.php";
require "class/modules/private_label/private.label.class.php";

require "_common/class/modules/pages/page.admin.class.php";
require "_common/class/modules/pages/email.page.admin.class.php";
require "_common/class/modules/pages/message.admin.class.php";
require "_common/class/modules/pages/message.class.php";

require "_common/class/modules/comments/comment.admin.class.php";
require "class/modules/registrations/registration.admin.class.php";
require "class/modules/registrations/registration.class.php";

require "class/modules/promo/promo.admin.class.php";
require "class/modules/promo/promo.class.php";

require "class/modules/deals/deal.admin.class.php";
require "class/modules/deals/deal.class.php";

?>