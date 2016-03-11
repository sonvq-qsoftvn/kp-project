<?php 
// log out
session_start();
unset($_SESSION['usernm']);
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);
session_destroy();
include("../class/db_mysql.inc");
$obj_base_path = new DB_Sql;
header("Location:".$obj_base_path->base_path()."/admin/index");
?>
