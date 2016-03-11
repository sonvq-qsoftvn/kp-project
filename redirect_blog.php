<?php
include('include/user_inc.php');

$lang = $_REQUEST['lang'];
$blog_title= $_REQUEST['title'];
$page_id = $_REQUEST['page_id'];

//echo $lang;
//echo $blog_title;
//echo $page_id;


header("location: ".$obj_base_path->base_path()."/".$lang."/blog/".$page_id."/".$blog_title);

exit;
?>
