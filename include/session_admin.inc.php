<?php
session_start();
$path = explode("/",$_SERVER['REQUEST_URI']);
/*echo $path[2];exit;*/
if($path[2]!= "ticketing_solutions") {
if($_SESSION['usernm']=="")
header("Location:".$obj_base_path->base_path()."/admin/index");
}
//page name
$_SESSION['ses_page_name']=basename($_SERVER['PHP_SELF']);
?>