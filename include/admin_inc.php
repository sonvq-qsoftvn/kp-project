<?php
include("../class/db_mysql.inc");
include("../class/pdoDatabase.php");
include("../class/admin_class.php");
include("../class/event_class.php");
include("../class/merchant_admin_class.php");
include("../class/duplicate_event_class.php");
include("../class/pagination.class.php");
include('../class/pagination_search.class.php');
include('../class/user_class.php');
//include("../class/class.phpmailer.php");
//include("../class/class.smtp.php");
$obj_base_path = new DB_Sql;
$obj=new user;
include("../include/session_admin.inc.php");
include_once '../ckeditor/ckeditor.php';
include_once '../ckfinder/ckfinder.php';

include('../class/common_class.php');



?>