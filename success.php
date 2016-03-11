<?php

include('include/user_inc.php');

$obj_transaction=new user;
$obj_transaction->getTranId($_SESSION['ses_admin_id']);
$obj_transaction->next_record();

$tid = $obj_transaction->f('id');
$_SESSION['tid'] = $tid;

//header("location: payment-complete.php");
?>

<div align="center"><h1>LOADING ...</h1></div>

<script>
    setTimeout('window.location = "payment-complete.php"', 25000);
</script>