<?php
//include('../include/user_inc.php');
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_cart = new user;
$obj_ticket = new user;
//$email = $_POST['email'];
//$obj_checkEmail->checkEmail($email);
//echo $obj_checkEmail->num_rows();

//print_r($_REQUEST);

    for($i=1;$i<$_REQUEST['frm_count'];$i++){
		if($_REQUEST['frm_ticket'.$i] != ''){
			$cid[] = $obj_cart->add_to_cart_sub($_REQUEST['frm_event_id'],$_REQUEST['frm_sub_id'],$_REQUEST['frm_ticket'.$i],$_REQUEST['frm_mx_price'.$i],$_REQUEST['frm_us_price'.$i],$_SESSION['unique'],$_REQUEST['frm_us_tid'.$i],$_REQUEST['frm_payment'],$_REQUEST['frm_date'],$_REQUEST['frm_end_date'],$_REQUEST['frm_start'],$_REQUEST['frm_end'],$_SESSION['session_id']);
		}
    }
	
    if($_SESSION['ses_admin_id'] == ''){
            $_SESSION['cid'] = $cid;
    }

?>		
  
<table border="0">
	    <?php
	    $obj_ticket->getTicket_sub($_SESSION['ses_admin_id'],$_SESSION['unique'],$_REQUEST['frm_sub_id']);
	    while($row = $obj_ticket->next_record()){
	    ?>
	    <tr>
			<td width="25%">
				    <?php echo $obj_ticket->f('ticket');?>
			</td>
			<td>
				    <?php
				    if($_SESSION['langSessId']=='eng') {
						echo $obj_ticket->f('ticket_name_en');
				    }
				    elseif($_SESSION['langSessId']=='spn')
				    {
						echo $obj_ticket->f('ticket_name_sp');
				    }
				    ?>
                          </td>
	    </tr>
	    <?php
	    }
	    ?>
</table>	  
		  
