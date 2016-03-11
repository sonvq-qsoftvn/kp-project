<?php
session_start();
if($_SESSION['usernm']=="")
header("Location:".$obj_base_path->base_path()."/administrator/index");

//page name
$_SESSION['ses_page_name']=basename($_SERVER['PHP_SELF']);
?>