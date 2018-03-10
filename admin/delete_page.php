<?php

session_start();
include('../include/admin_inc.php');

$page_delete = new admin;

if (isset($_REQUEST['page_id']) && !empty($_REQUEST['page_id'])) {
    $page_delete->delPage($_REQUEST['page_id']);
}

$_SESSION['page_del_msg'] = "Page is deleted successfully.";
header("Location:" . $obj_base_path->base_path() . "/admin/list_page.php?err=1");
?>