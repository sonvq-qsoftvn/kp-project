<?php
include("../class/db_mysql.inc");
include("../class/admin_class.php");
include("../class/pagination.class.php");
include('../class/pagination_search.class.php');
include('../class/user_class.php');
//include("../class/class.phpmailer.php");
//include("../class/class.smtp.php");
$obj_base_path = new DB_Sql;
$obj=new user;
//include("../include/session_admin.inc.php");
include_once '../ckeditor/ckeditor.php';
include_once '../ckfinder/ckfinder.php';

if($_SESSION['ses_admin_seller_type']==2 && $_SESSION['ses_page_name']!='scan.php' && $_SESSION['ses_page_name']!='scan_ticket.php')
header("Location:".$obj_base_path->base_path()."/admin/scan");

?>