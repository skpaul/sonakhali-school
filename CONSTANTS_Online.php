<?php
    //Must add SLASH(/) after this constant i.e.  require_once(ROOT_DIRECTORY . '/db_connect.php');
    defined("ROOT_DIRECTORY")
    or define("ROOT_DIRECTORY", realpath(dirname(__FILE__)));
    //$example = ROOT_DIRECTORY . "/applicant_photo/" . "$gender" . "/" . $post_code . "/" . $userid. ".jpg";


    //Must add SLASH(/) after this constant i.e. require_once(LIBRARY_PATH .'/form.php');
    //defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

    defined("BASE_URL") or define("BASE_URL", "https://sonakhalischool.com"); 
    defined("DATABASE_SERVER") or define("DATABASE_SERVER", "localhost");
    defined("DATABASE_USER_NAME") or define("DATABASE_USER_NAME", "zahiskpo_sonakhali");
    defined("DATABASE_PASSWORD") or define("DATABASE_PASSWORD", "Sonakhali$2021@School");
    defined("DATABASE_NAME") or define("DATABASE_NAME", "zahiskpo_sonakhali");
    defined("ENVIRONMENT") or define("ENVIRONMENT", "PRODUCTION"); //DEVELOPMENT  //PRODUCTION
    defined("ORGANIZATION_SHORT_NAME") or define("ORGANIZATION_SHORT_NAME", "Uttar Sonakhali School");
    defined("ORGANIZATION_FULL_NAME") or define("ORGANIZATION_FULL_NAME", "Uttar Sonakhali School");
?>
