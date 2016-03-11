<?php
include('include/user_inc.php');

$obj_upd = new user;
$obj_ticket = new user;
$obj_total = new user;
$count = $_POST['count'];
$cart_id = $_POST['cart_id'];
$event_id = $_POST['event_id'];

$payment = $_POST['payment'];
$promotion = $_POST['promotion'];
/*echo $count." ".$cart_id;
exit;*/

$obj_upd->upd_ckeckout($count,$cart_id);
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
			  $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$event_id);
			  while($row = $obj_ticket->next_record()){
			  ?>
                        
                        <tr>
                          <td>
			    <select name="ticket_num" id="ticket_num<?php echo $count;?>" onChange="tkt_num(<?php echo $count;?>,<?php echo $obj_ticket->f('cart_id');?>,<?php echo $event_id;?>,<?php echo $payment;?>,<?php echo $promotion;?>);">
							<?php for($i=1;$i<=$obj_ticket->f('ticket_num');$i++) {?>
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
			      $objfee = new user;
			      $objfee->getsetting();
			      $objfee->next_record();
			      if($_SESSION['pay'] == 'us'){
				if($payment == 1){
				  $ticket_fee_us = $objfee->f('ticket_min_us') + (($objfee->f('ticket_percent_incl')/100)*$obj_ticket->f('us_price'));
				}
				else
				{
				  $ticket_fee_us = $objfee->f('ticket_min_us') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('us_price'));
				}
                                
                                if($promotion == 1){
				  $promo_fee_us = $objfee->f('promo_fee_min_us') + (($objfee->f('promo_percent_incl')/100)*$obj_ticket->f('us_price'));
				}
				else
				{
				  $promo_fee_us = $objfee->f('promo_fee_min_us') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('us_price'));
				}
                                
			      }elseif($_SESSION['pay'] == 'mx'){
				if($payment == 1){
				  $ticket_fee_us = $objfee->f('ticket_min_mx') + (($objfee->f('ticket_percent_incl')/100)*$obj_ticket->f('mx_price'));
				}
				else
				{
				  $ticket_fee_us = $objfee->f('ticket_min_mx') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('mx_price'));
				}
                                
                                if($promotion == 1){
				  $promo_fee_us = $objfee->f('promo_fee_min_mx') + (($objfee->f('promo_percent_incl')/100)*$obj_ticket->f('mx_price'));
				}
				else
				{
				  $promo_fee_us = $objfee->f('promo_fee_min_mx') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('mx_price'));
				}

			      }
			      
                              $ticket_fee_us = $ticket_fee_us + $promo_fee_us;
			      echo number_format($ticket_fee_us,2,'.',',');
			      $_SESSION['fee'] = $ticket_fee_us;
			    ?>
			  </td>
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo $total = number_format($obj_ticket->f('ticket')*($obj_ticket->f('us_price')+$ticket_fee_us),2,'.',',');
							$_SESSION['total'] = $total;
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo $total = number_format($obj_ticket->f('ticket')*($obj_ticket->f('mx_price')+$ticket_fee_us),2,'.',',');
							$_SESSION['total'] = $total;
						  }
						  ?></td>
                          <td><a href="<?php echo $obj_base_path->base_path()."/payment.php?event_id=".$event_id."&action=del&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
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
                          <td><strong>Total : <?php //$obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay'],$_SESSION['unique'],$event_id,$obj_cart_details->f('cart_id')); $obj_total->next_record(); //echo number_format($obj_total->f('Amt'),2,'.',',');
			      echo $_SESSION['total'];
			  ?></strong></td>
			  
			  
                          <td><?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
                        </tr>
                        <tr>
                        	<td colspan="6" style="text-align:right;"><!--<input type="submit" value="Checkout" /> <input type="submit" value="Update" />--></td>
                        </tr>
                      </table>
                      	<!--<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
                        <input type="hidden" name="amount" value="<?php echo $obj_total->f('Amt');?>" />
                        <input type="hidden" name="payment_type" id="payment_type" value="" />
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
                        <input type="hidden" name="multi_id" value="<?php echo $multi_id;?>" />
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['ses_admin_id'];?>" />
                        <input type="hidden" name="name" value="<?php echo $name;?>" />-->
                      </form>
