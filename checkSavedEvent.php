<?php
session_start();

include("class/db_mysql.inc");
include("class/user_class.php");
include("class/EasyGoogleMap.class.php");
include("class/pagination.class.php");
include("class/class.phpmailer.php");
//include("include/fpdf/fpdf.php");
//include("pdfb/pdfb.php");
//include("pdfb/pdfb.php");
include('include/pdf_barcode/Barcode.php');
require('include/pdf_barcode/alphapdf.php');
$obj_base_path = new DB_Sql;
//page name
$_SESSION['ses_page_name']=basename($_SERVER['PHP_SELF']);

//include('include/user_inc.php');

$obj_activate = new user;

$event_id = $_POST['event_id'];

$obj_activate->checkedSavedUserEvent($event_id);
$obj_activate->next_record();
if($obj_activate->num_rows()>0)
	echo 1;
else
	echo 0;
	
?>		
  
	  
		  
