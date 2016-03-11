<?php
//include('include/user_inc.php');
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_upd = new user;
$obj_ticket = new user;
$obj_total = new user;
$count = $_POST['count'];
$cart_id = $_POST['cart_id'];
$event_id = $_POST['event_id'];
 
$payment = $_POST['payment'];
$promotion = $_POST['promotion'];
$attempt_id=$_POST['attempt'];
/*echo $count." ".$cart_id;
exit;*/

$obj_upd->upd_ckeckout($count,$cart_id);
unset($_SESSION['total_amnt_tckt']);
unset($_SESSION['total']);

?>		
  

                      <form action="" name="frm" id="frm" method="post">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="event_review">
                        <tr>
                          <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Quantity<?php }elseif($_SESSION['langSessId']=='spn'){?>Cantidad<?php }?></th>
                          <th width="17%"><?php if($_SESSION['langSessId']=='eng') {?>TicketName<?php }elseif($_SESSION['langSessId']=='spn'){?>Boleto<?php }?></th>
                          <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Price<?php }elseif($_SESSION['langSessId']=='spn'){?>Precio<?php }?></th>
                          <th width="15%"><?php if($_SESSION['langSessId']=='eng') {?>Fee<?php }elseif($_SESSION['langSessId']=='spn'){?>Cargos<?php }?></th>
                          <th width="20%"><?php if($_SESSION['langSessId']=='eng') {?>Total<?php }elseif($_SESSION['langSessId']=='spn'){?>Total<?php }?></th>
                          <th width="16%">&nbsp;</th>
                        </tr>
                        
                        <?php 
			  $count = 1;
			  //echo $event_id; exit;
			  $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$_SESSION['event_id']);
			  while($row = $obj_ticket->next_record()){
			  ?>
                        
                        <tr>
                          <td>
			    <select name="ticket_num" id="ticket_num<?php echo $count;?>" onChange="tkt_num(<?php echo $count;?>,<?php echo $obj_ticket->f('cart_id');?>,<?php echo $event_id;?>,<?php echo $payment;?>,<?php echo $promotion;?>);">
							<?php for($i=1;$i<=$obj_ticket->f('ticket_num');$i++) {
							  if($i == $obj_ticket->f('ticket')){ 
							    $ticket .=$i.",";
							  }
							  ?>
                                <option value="<?php echo $i;?>" <?php if($i == $obj_ticket->f('ticket')){ echo "selected";}?>><?php echo $i;?></option>
                            <?php } ?>
                             </select>
						  <?php //echo $obj_ticket->f('ticket');?></td>
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
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo number_format($obj_ticket->f('us_price'),2,'.',',');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo number_format($obj_ticket->f('mx_price'),2,'.',',');
						  }
						  ?></td>
                          <td>
			    <?php
			      $promo_fee_us = 0;
			      $objfee = new user;
			      $objfee->getsetting();
			      $objfee->next_record();


	// ================================ Check Spanish or English and show the ticket fee  ============================
			      if($_SESSION['pay'] == 'us'){
		
				// Now check whether fees is include or not
				if($payment == 1){		    
				  $tic_fee = 0;
				}
				else{
				  $tic_fee = $obj_ticket->f('ticket_fee_us');
				}
				
				
				// Now check whether promoton is include or not
				if($promotion == 1){
				  $promo_fee = 0;
				}
				else{
				  $promo_fee = $obj_ticket->f('promo_fee_us');
				}
				
				$tic_fee_us = $promo_fee +  $tic_fee;
				echo number_format($tic_fee_us,2,'.',',');
			      }
			      else
			      {
				if($payment == 1){		    
				  $tic_fee_mx = 0;
				}
				else{
				  $tic_fee_mx = $obj_ticket->f('ticket_fee_mx');
				}
				
				// Now check whether promoton is include or not
				if($promotion == 1){
			    
				  $promo_fee_mx = 0;
				}
				else
				{
				  $promo_fee_mx = $obj_ticket->f('promo_fee_mx');
				}
				
				
				$tic_fee_mx = $promo_fee_mx +  $tic_fee_mx;
				echo number_format($tic_fee_mx,2,'.',',');
			      }
			      
	 // ========================= End of Check Spanish or English and show the ticket fee  =========================

			    ?>
			  </td>
                          <td>
			  <?php
			  


	// ==================================================  Check for Total payment ======================== ========================= 
			  
			if($_SESSION['pay'] == 'us'){
			  
			  
			  // For Include Fee
			  if($payment == 1){
			    
			    $incl_fee_us = 0;
			    
			  }
			  else{
			    
			    $incl_fee_us = $objfee->f('ticket_min_us') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('us_price'));
			    
			  }
			  
			  // For Include Promotion
			  if($promotion == 1){
			    
			    $incl_promo_us = 0;
			  }
			  else{
			    
			    $incl_promo_us = $objfee->f('promo_fee_min_us') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('us_price'));
			    
			  }
			  
			  // Calculate Total Fee for 1 ticket...
			  $total_per_ticket_fee_us =  $obj_ticket->f('ticket')*($incl_fee_us + $incl_promo_us + $obj_ticket->f('us_price'));
			  echo number_format($total_per_ticket_fee_us,2,'.',',');			    
			  $_SESSION['total']=$_SESSION['total'] + $total_per_ticket_fee_us; //This is for All Total Amount  
			  
			}
			  
			elseif($_SESSION['pay'] == 'mx'){
			  
			  // For Include Fee
			  if($payment == 1){
			    
			    $incl_fee_mx = 0;
			    
			  }
			  else{
			    
			    $incl_fee_mx = $objfee->f('ticket_min_mx') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('mx_price'));
			    
			  }
			  
			  // For Include Promotion
			  if($promotion == 1){
			    
			    $incl_promo_mx = 0;
			  }
			  else{
			    
			    $incl_promo_mx = $objfee->f('promo_fee_min_mx') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('mx_price'));
			    
			  }
			  
			  //echo "<br><br>=======".$obj_ticket->f('mx_price')."========<br><br><br>";
			  
			  // Calculate Total Fee for 1 ticket...
			  $total_per_ticket_fee_mx =  $obj_ticket->f('ticket')*($incl_fee_mx + $incl_promo_mx + $obj_ticket->f('mx_price'));
			  echo number_format($total_per_ticket_fee_mx,2,'.',',');			    
			  $_SESSION['total']=$_SESSION['total'] + $total_per_ticket_fee_mx; //This is for All Total Amount 


    // ================================================== End of Check for Total payment ======================== ========================= 



	//		     if($_SESSION['pay'] == 'us'){
	//    $total = $obj_ticket->f('ticket')*($obj_ticket->f('us_price')+$add_ed_fee_inc_payment + $add_ed_fee_inc_promotion);
	//    echo  $total_of_same_ticket= number_format($obj_ticket->f('ticket')*($obj_ticket->f('us_price')+$add_ed_fee_inc_payment + $add_ed_fee_inc_promotion),2,'.',',');
	//			    $_SESSION['total']=$_SESSION['total'] + $total; //This is for All Total Amount
	//			    $_SESSION['total_amnt_tckt'] = $_SESSION['total_amnt_tckt'] + $total; //use for Amount hidden Field..
	//			    
	//		      }elseif($_SESSION['pay'] == 'mx'){
	//			     $total = $obj_ticket->f('ticket')*($obj_ticket->f('mx_price')+$add_ed_fee_inc_payment + $add_ed_fee_inc_promotion);
	//			     
	//    echo  $total_of_same_ticket =  number_format($obj_ticket->f('ticket')*($obj_ticket->f('mx_price')+$add_ed_fee_inc_payment + $add_ed_fee_inc_promotion),2,'.',',');
	//			   
	//			    $_SESSION['total']=$_SESSION['total'] + $total; //This is for All Total Amount
	//			    $_SESSION['total_amnt_tckt'] = $_SESSION['total_amnt_tckt'] + $total; //use for Amount hidden Field..
			      }
			  ?>
			  </td>
                          <td>
             <a href="<?php echo $obj_base_path->base_path()."/payment.php?event_id=".$_SESSION['event_id']."&action=del&attempt_id=".$attempt_id."&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
                        </tr>
                        
                        <?php
                        	$count++;
			    }
			?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><strong><!--Total :--> <?php $obj_total->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total->next_record(); //echo $obj_total->f('Total');?></strong>
                          <input type="hidden" name="ticket" value="<?php echo $obj_total->f('Total');?>" />
                          </td>
                          <td>
			    <strong>Total : <?php 
			       echo number_format($_SESSION['total'],2,'.',','); //All Total Amount in nuber format..
			  ?></strong></td>
			  
			  
                          <td><?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
                        </tr> 
                        <tr>
                        	<td colspan="6" style="text-align:right;"><!--<input type="submit" value="Checkout" /> <input type="submit" value="Update" />--></td>
                        </tr>
                      </table>
		                        <!---USE FOR CHANGING AMONT HIDDEN FIELD AFTER CALLING AJAX---->
                      	<input type="hidden" id ="total_amnt_ajax" name="total_amnt_ajax" value="<?php echo $_SESSION['total_amnt_tckt'];?>" />
                        <input type="hidden" id ="total_count" name="total_count" value="<?php echo $ticket;?>" />
                      </form>
		     
