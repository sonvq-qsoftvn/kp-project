<?php
include('../include/admin_inc.php');

//create object
//echo "hello!";
//exit;
$objEventDetails = new admin;
$objReport = new admin;
$objReportXML = new admin;
$objcart=  new admin;
$objcartReport=  new admin;
$objEventDetailsReport = new admin;

$event_id_str=base64_decode($_REQUEST['event_id']); //selected event string come from previous page
$event_id=explode(',',$event_id_str);
$num_event=count($event_id);

$admin_id = $_SESSION['ses_user_id'];
//$report_check_arr = $_POST['report_check'];
//$report_check_event = rtrim(implode(',', $report_check_arr), ',');
////echo $report_check_event;
////exit();

if(isset($_POST['submit_xls']))
{
	
	$all_trans_arr=$_POST['all_transaction'];
	$all_trans_str = rtrim(implode(',', $all_trans_arr), ',');
	//echo $all_trans_str;
	//exit;
	$eventIDS=$_POST['event_id_str']; //hidden  field value of event string
	
		$XML = "Transaction Date,Admin Id,User Id,Event Id,Event Name,Transaction Id,Cart Id,Quantity,Ticket Id,Ticket Name,Price,Commission,Total,Currency,Net To Admin\n";
		$file ="report_". date("Y-m-d"). ".xls";
		
		$objReportXML->get_EXcel($all_trans_str);
		//$objReportXML->next_record();
		//exit;
		 		
		while($myrow = $objReportXML->next_record())
		{
			if($objReportXML->f('payment_currency')=='USD')
			  {
			        $price=$objReportXML->f('us_price');
				//echo "ifP=".$price;
			  }
			else
			  {
			        $price=$objReportXML->f('mx_price');
				//echo "elseP=".$price;
			  }
			$commission = (($objReportXML->f('fee_incl_amount'))+($objReportXML->f('fee_non_incl_amount'))); //commission means Fees total of transaction field
			
			
			
			 /*ALL CART IDS START*/
				$objcartReport->getCartId($objReportXML->f('unique_id'));
				$objcartReport->next_record();
					
			 /*ALL CART IDS END*/
				    
			/*EVENT DETAILS START*/
				$objEventDetailsReport->event_details_byID($objReportXML->f('event_id'));
				$objEventDetailsReport->next_record();
			 /*EVENT DETAILS END*/	    
				
				$XML.= $objReportXML->f('transaction_date_time'). ",";
				$XML.= $objEventDetailsReport->f('event_creator'). ",";
				$XML.= $objReportXML->f('user_id'). ",";
				$XML.= $objReportXML->f('event_id'). ",";
				$XML.= str_replace(',','-',$objReportXML->f('event_name_en')). ",";	    
				//$XML.= str_replace(',','-',$objReportXML->f('fname').$objReportXML->f('lname')). ",";
				$XML.= $objReportXML->f('id'). ",";
				$XML.= $objcartReport->f('cartid'). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_quantity')). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_id')). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_name_en')). ",";
				$XML.= $price. ",";
				$XML.= $commission. ",";
				$XML.= $objReportXML->f('payment_amount'). ",";
				$XML.= $objReportXML->f('payment_currency'). ",";
				$XML.= $objReportXML->f('net_to_admin'). "\n";
		    
		//echo $XML;
		//exit;
		}
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$file\"");
		header("Content-Transfer-Encoding: binary");
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
		    header('Cache-Control: public');
		}
		echo $XML;
		exit;


}


if(isset($_POST['submit_csv']))
{
	$all_trans_arr=$_POST['all_transaction'];
	$all_trans_str = rtrim(implode(',', $all_trans_arr), ',');
	//echo $all_trans_str;
	//exit;
	$eventIDS=$_POST['event_id_str']; //hidden  field value of event string
	
		$XML = "Transaction Date,Admin Id,User Id,Event Id,Event Name,Transaction Id,Cart Id,Quantity,Ticket Id,Ticket Name,Price,Commission,Total,Currency,Net To Admin\n";
		$file ="report_". date("Y-m-d"). ".csv";
		
		$objReportXML->get_EXcel($all_trans_str);
		//$objReportXML->next_record();
		//exit;
		 		
		while($myrow = $objReportXML->next_record())
		{
			if($objReportXML->f('payment_currency')=='USD')
			  {
			        $price=$objReportXML->f('us_price');
				//echo "ifP=".$price;
			  }
			else
			  {
			        $price=$objReportXML->f('mx_price');
				//echo "elseP=".$price;
			  }
			
			    $commission = (($objReportXML->f('fee_incl_amount'))+($objReportXML->f('fee_non_incl_amount'))); //commission means Fees total of transaction field
				//echo "if=".$commission;    
			   
			 /*ALL CART IDS START*/
				$objcartReport->getCartId($objReportXML->f('unique_id'));
				$objcartReport->next_record();
									
			 /*ALL CART IDS END*/
			 
			 /*EVENT DETAILS START*/
				$objEventDetailsReport->event_details_byID($objReportXML->f('event_id'));
				$objEventDetailsReport->next_record();
			 /*EVENT DETAILS END*/	    
				
				$XML.= $objReportXML->f('transaction_date_time'). ",";
				$XML.= $objEventDetailsReport->f('event_creator'). ",";
				$XML.= $objReportXML->f('user_id'). ",";
				$XML.= $objReportXML->f('event_id'). ",";
				$XML.= str_replace(',','-',$objReportXML->f('event_name_en')). ",";	    
				//$XML.= str_replace(',','-',$objReportXML->f('fname').$objReportXML->f('lname')). ",";
				$XML.= $objReportXML->f('id'). ",";
				$XML.= $objcartReport->f('cartid'). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_quantity')). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_id')). ",";
				$XML.= str_replace(',','-',$objReportXML->f('ticket_name_en')). ",";
				$XML.= $price. ",";
				$XML.= $commission. ",";
				$XML.= $objReportXML->f('payment_amount'). ",";
				$XML.= $objReportXML->f('payment_currency'). ",";
				$XML.= $objReportXML->f('net_to_admin'). "\n";
		    
		//echo $XML;
		//exit;
		}
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$file\"");
		header("Content-Transfer-Encoding: binary");
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
		    header('Cache-Control: public');
		}
		echo $XML;
		exit;	

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Promotion List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>

<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
	.add_media{
		width: auto;
		height: 34px;
		background: #00f;
		margin: 0;
		display: inline-block;
	
	}
	.add_media a{
		font-size: 18px;
		line-height: 34px;
		font-weight:normal;
		color: #fff;
		text-align: center;
		padding:0 12px;
		margin: 0;
		display: block;
		text-decoration: none;
		cursor: pointer;
	}
</style>

<script language="javascript" type="text/javascript">
	
/*---------MULTIPLE CHECK BOX SECTION START -----------*/

function allReportCheck(source) {
		//alert("alj");
  checkboxes = document.getElementsByName('report_check[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

/*---------MULTIPLE CHECK BOX SECTION END -----------*/
</script>

<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>

<div id="maindiv">
	

	
	<div class="clear"></div>
	<div class="body_bg">
     <div class="clear"></div>
     <div class="container">
        <?php include("admin_header_menu.php");?>
		 <div class="clear"></div>		
		<!--start body-->
		   <div id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <div class="blue_box1">
				<div class="blue_box10"><p>Report</p></div>
				<div class="blue_boxr">
				<ul>
				<li><a href="<?php echo $obj_base_path->base_path()."/admin/event-final-report/"?>">Final Report</a></li>
				<li><a href="<?php echo $obj_base_path->base_path()."/admin/event-provisional-report/"?>">Provisional Report</a></li>
				</ul>
				</div>
			   </div>
			   
			   
			    
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
						
         <input type="hidden" name="listEvent" id="listEvent" value="1" /> 
        	
		 <div class="myevent_box">		 
	 	
			</div>		
          
	 <div class="clear"></div>		
	 <div class="myevent_box">
	 <div class="event_header" style="color:#FF0000"><strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		<form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<div style="float: right; margin: 0px 4px 4px 2px;" font-size="14px;"><input type="submit" name="submit_xls" value="Export to xls" /></div>
		<div style="float: right";  font-size="14px;"><input type="submit" name="submit_csv" value="Export to csv" /></div>
		<div class="clear"></div>
		        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
                       <!-- <td width="9%" class="top_txt"><input type="checkbox" name="all_report" id="check_all_report" onClick="allReportCheck(this)" value="all_report">Select All</td>-->
		        <td width="6%" class="top_txt">Transdate</td>
			<td width="4%" class="top_txt">Admin Id</td>
			<td width="5%" class="top_txt">User Id</td>
			<td width="5%" class="top_txt">Event Id</td>
			<td width="8%" class="top_txt">Event</td>
			<td width="6%" class="top_txt">Transaction Id</td>
			<td width="8%" class="top_txt">Cart Id</td>
			<td width="5%" class="top_txt">Ticket Quantity</td>
			<td width="8%" class="top_txt">Ticket Id</td>
			<td width="8%" class="top_txt">Ticket Name</td>
			<td width="4%" class="top_txt">Price</td>
			<td width="5%" class="top_txt">Comm</td>
			<td width="4%" class="top_txt">Total</td>
			<td width="6%" class="top_txt">Cur</td>
			<td width="8%" class="top_txt">Net To Admin</td>
			</tr>

	                <?php
			
			
			if($num_event>0)
			{
			  for($i=0;$i<sizeof($event_id);$i++)
			   {
				//echo "G= ".$event_id[$i]."<br/>";
				$objReport->eventReport($admin_id,$event_id[$i]); //get all transaction value by admin_id and the selected event. 
				while($row = $objReport->next_record())
				 {
				    
											    
				    $objEventDetails->event_details_byID($objReport->f(event_id));
				    $objEventDetails->next_record();
				    
				     $event_end_date = $objEventDetails->f('event_end_date_time');
				    
				    //echo "big= ".$event_end_date."<br/>";
				    //echo '<pre>'.
				    //print_r($objEventDetails);
				    //echo $objReport->f('ticket_id');
				    
				    /*ALL CART IDS START*/
					$objcart->getCartId($objReport->f('unique_id'));
					$objcart->next_record();
					
				    /*ALL CART IDS END*/
				    ?>
				    
				<tr>
				<!--<td width="9%" class="top_txt"><input type="checkbox" name="report_check[]" id="report_check" value="<?php //echo $objReport->f('id'); ?>"></td>-->
					<td><?php echo $objReport->f('transaction_date_time');?></td>
					<td><?php echo $objEventDetails->f('event_creator');?></td>
					<td><?php echo $objReport->f('user_id');?></td>
					<td><?php echo $objEventDetails->f('e_id');?></td>
					<td><?php echo $objEventDetails->f('event_name_en');?></td>
					<td><?php echo $objReport->f('id');?></td>
					
					<td><?php echo $objcart->f('cartid');?></td>
					<td><?php echo $objReport->f('ticket');?></td>
					<td><?php echo $objReport->f('ticket_id');?></td>
					<td><?php echo $objReport->f('ticket_name_en');?></td>
					<!--<td><?php //echo ucwords($objReport->f('fname').$objReport->f('lname'));?></td>-->
					<td><?php if($objReport->f('payment_currency')=='USD') {echo $objReport->f('us_price');} else{echo $objReport->f('mx_price');}?></td>
					<td><?php echo (($objReport->f('fee_incl_amount'))+($objReport->f('fee_non_incl_amount')));?></td>
					<td><?php echo $objReport->f('payment_amount');?></td>
					<td><?php echo $objReport->f('payment_currency');?></td>
					<td><?php echo $objReport->f('net_to_admin');?></td>
					<input type="hidden" name="event_id_str" value="<?php echo $event_id_str ?>"/>
					<input type="hidden" name="all_transaction[]" value="<?php echo $objReport->f('id'); ?>"/>
				</tr>
				    
			     <?php
				   }//while end  
			   }
		         } //if  end
			 
			 else
			 {?>
			<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Ad Found</font></td></tr>	
			<?php }
			 ?>
		
			</table>
	</form>
    	</div>	
		<div class="clear"></div>
	</div>
	</div>
	<div class="clear"></div>	
	</div>
    <div class="clear"></div>
					
</div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>