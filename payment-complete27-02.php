<?php
//payment success page
include('include/user_inc.php');

//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();

//echo "session-id ".$_SESSION['tid']; exit;
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Completed</title>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />

</head>
<body>

<!--header-->
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<!--header-->

<div id="maindiv">
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
                  <div class="blue_box1" style="width: 976px;"><div class="blue_boxh"><p><?php if($_SESSION['langSessId']=='eng') {?>Order Completed<?php }elseif($_SESSION['langSessId']=='spn'){?>Orden Completado<?php }?></p></div></div>
                  <div class="clear"></div>
                          <div class="clear"></div>
                            <form action="" method="post" enctype="multipart/form-data">
                              <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="padding: 24px 0;">
                                <?php
					$tid = $_SESSION['tid'];
					if($_SESSION['tid'] == ''){
						//echo "user : ".$_SESSION['ses_admin_id']; exit;
						$obj_transaction=new user;
						$obj_transaction->getTranId($_SESSION['ses_admin_id']);
						$obj_transaction->next_record();
						
						$tid = $obj_transaction->f('id');
					}
					
					$obj_order_details=new user;
					$obj_order_details->getOrderDetails($tid);
					$obj_order_details->next_record();
					$event_id = $obj_order_details->f('event_id');
					//$payment =  $obj_cart_details->f('payment');
					$ticket_id =  $obj_order_details->f('ticket_id');
					$multi_id  =  $obj_order_details->f('multi_id');
					//$cart_id = $obj_order_details->f('cart_id');
					$ticket = $obj_order_details->f('ticket');
					//$_SESSION['payment'] = $payment;
					// Event Details
					$objEvent=new user;
					$objEvent->getEventDetails($event_id);
					$objEvent->next_record();
				?>
                                <tr>
                                  <td>
                                  <div style="font-size:18px;margin-top:10px;">
                                  <?php if($_SESSION['langSessId']=='eng') {?>Thank you for your order.<?php }elseif($_SESSION['langSessId']=='spn'){?>Gracias por su pedido.<?php }?></div></td>
                                </tr>
                               
                                <tr>
                                  <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
                                </tr>
				<tr>
                                  <td><strong><?php if($_SESSION['langSessId']=='eng') {?>Your order no. is<?php }elseif($_SESSION['langSessId']=='spn'){?>Su referencia es<?php }?> : <?php echo $obj_order_details->f('order_no');?></strong></td>
                                </tr>
				<tr>
                                  <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
                                </tr>
				
                                <tr>
                                  <td><strong><?php if($_SESSION['langSessId']=='eng') {?>You ordered<?php }elseif($_SESSION['langSessId']=='spn'){?>Ordenaste<?php }?>: </strong></td>
                                </tr>
				<tr>
					<td>
						<div class="view_box7" style="border: medium none;">
						
						<div class="hot_event7">
							<?php
								
					    if($_SESSION['langSessId']=='eng') {
								$name = $objEvent->f('event_name_en');
								?>
					    <h1><?php echo $objEvent->f('event_name_en');?></h1> 
					    <?php
					    }
								elseif($_SESSION['langSessId']=='spn')
								{
								$name = $objEvent->f('event_name_sp');
								?>
					    <h1><?php echo $objEvent->f('event_name_sp');?></h1> 
								<?php 
								}
								?>
					    <?php
								$obj_cart=new user;
								$obj_cart->cart_details($obj_order_details->f('cart_id'));
								$obj_cart->next_record();
								
								$start = $obj_cart->f('start');
								$end = $obj_cart->f('end');
								$date = $obj_cart->f('sdate');
								$edate = $obj_cart->f('edate');
								?>
								<p><?php echo date("l, m, d, Y",strtotime($date))." ".$start;?> - <?php if($date != $edate){ echo date("l, m, d, Y",strtotime($edate))." ";} echo $end;?></p>
								<p><?php echo $objEvent->f('venue_name');?></p>
								<p><?php echo $objEvent->f('venue_address');?></p>
								<p><?php echo $objEvent->f('city_name');?>, <?php echo $objEvent->f('county_name');?>, <?php echo $objEvent->f('state_name');?></p>                
					    </div>
					    <div class="clear"></div>
					</div>

					</td>
				</tr>
				<tr>
                                  <td></td>
                                </tr>
				<tr>
					<td>
						<div class="view_box7" style="border: medium none;">
						
			
			
					<div class="hot_event7">
					    <div>
						</div>
								<div class="clear"></div>
								<div class="hot_event7">
								 <div  id="checkout_frm">
					      <form action="" name="frm" id="frm" method="post">
					      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="event_review">
						<tr>
						  <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Quantity<?php }elseif($_SESSION['langSessId']=='spn'){?>Cantidad<?php }?></th>
						  <th width="17%"><?php if($_SESSION['langSessId']=='eng') {?>TicketName<?php }elseif($_SESSION['langSessId']=='spn'){?>Boleto<?php }?></th>
						  <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Price<?php }elseif($_SESSION['langSessId']=='spn'){?>Precio<?php }?></th>
						  <th width="15%"><?php if($_SESSION['langSessId']=='eng') {?>Fee<?php }elseif($_SESSION['langSessId']=='spn'){?>Cargos<?php }?></th>
						  <th width="20%"><?php if($_SESSION['langSessId']=='eng') {?>Total<?php }elseif($_SESSION['langSessId']=='spn'){?>Total<?php }?></th>
						  
						</tr>
						
						<?php 
									$count = 1;
									//echo $e_id; exit;
									$obj_ticket=new user;
									$obj_ticket->getTicketDetails($obj_order_details->f('ticket_id'));
									//while($row = $obj_ticket->next_record()){
									$obj_ticket->next_record();
									?>
						
						<tr>
						  <td>
									  <?php echo $obj_order_details->f('ticket');?></td>
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
										echo number_format($obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_ticket->f('price_mx'),2,'.',',');
									  }
									  ?></td>
						  <td></td>
						  <td><?php 
									  if($_SESSION['pay'] == 'us'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_mx'),2,'.',',');
									  }
									  ?></td>
						  
						</tr>
						
						<?php
							//$count++;
									//}
									?>
						<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td><!--<strong>Total : <?php //$obj_total->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total->next_record(); //echo $obj_total->f('Total');?></strong>
						  <input type="hidden" name="ticket" value="<?php //echo $obj_total->f('Total');?>" />-->
						  </td>
						  <td><!--<strong>Total : <?php //$obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay'],$_SESSION['unique'],$e_id,$obj_cart_details->f('cart_id')); $obj_total->next_record(); echo number_format($obj_total->f('Amt'),2,'.',',');?></strong>-->
						  <strong>
							Total : <?php
									if($_SESSION['pay'] == 'us'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_mx'),2,'.',',');
									  }
							?>
						  </strong>
						  <?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
						</tr>
						
					      </table>
						
					      </form>
					      </div>                      
								</div>
					    </div>
					    <div class="clear"></div>
					    
				      </div>				

					</td>
				</tr>
				<tr>
					<td>
						<?php if($_SESSION['langSessId']=='eng') {?>
						<p>You will receive shortly an email confirmation with your electronic confirmation.<br> 
If you do not receive the confirmation email within 5 minutes please check your Spam or Junk folders to ensure safe delivery. If you think that there has been a problem with delivery of the email please contact us at info@kpasapp.com<br>
We look forward to seeing you at <strong><?php echo $name;?></strong>!<br>
<!--<a href="<?php echo $obj_base_path->base_path(); ?>">Click Here</a> to return to KPasapp home page</p>-->
						<?php }elseif($_SESSION['langSessId']=='spn'){?>
						<p>En breve recibirás un email de confirmación con su confirmación electrónica.<br>Si usted no recibe el correo electrónico de confirmación dentro de los 5 minutos, por favor revise su carpeta de spam o basura para garantizar la entrega segura. Si usted cree que ha habido un problema con la entrega del correo electrónico, por favor contacte con nosotros en info@kpasapp.com<br>
Esperamos verle en <strong><?php echo $name;?></strong>!<br>
<!--<a href="<?php echo $obj_base_path->base_path(); ?>">Click Here</a> to return to KPasapp home page</p>-->						
</p>
						<?php }?>
					</td>
				</tr>
                               </table>
                            </form>
                <div class="clear"></div>
		
            </div>
           <div class="clear"></div>
	   
	
	</div>

    </div>
    <div class="clear"></div>
    

</div>
<?php
	$obj_user->user_details($obj_order_details->f('user_id'));
	$obj_user->next_record();
	
	$recipient = $obj_user->f('email');
	
	if($_SESSION['langSessId']=='eng') {
		$name = $objEvent->f('event_name_en');
	}
	else
	{
		$name = $objEvent->f('event_name_sp');
	}
	
	if($_SESSION['langSessId']=='eng') {
		$tname = $obj_ticket->f('ticket_name_en');
	  }
	  elseif($_SESSION['langSessId']=='spn')
	  {
	    $tname = $obj_ticket->f('ticket_name_sp');
	  }
	  
	//$date = date("F j, Y, g:i a",strtotime($objEvent->f('event_start_date_time')));
	$showdate = date("F j, Y",strtotime($date))." ".$start;
	
	if($_SESSION['langSessId']=='eng') {
	$message="
	Dear ".$obj_user->f('fname')." <br>
	
	Thank you for your order.<br><br> 
	Your order reference number is: <strong>".$obj_order_details->f('order_no')."</strong> <br><br>
	
	
	Please keep it securely, as it will be required when you check in.<br> 
	Please print this message and present it to check in at the event.<br>
	You ordered <br><br>
	
	".$obj_order_details->f('ticket')." ".$tname.", ".$name.", ".$showdate." <br><br>
	
	Thank you for using KPasapp.com, your passport to all the events of Baja California Sur <br><br>

	We look forward to seeing you at ".$name.", <br><br>
	
	The KPasapp Team<br>
	Do not reply to this email.<br>
	Email us at info@kpasapp.com if you require additional assistance.<br>
	";
	}
	elseif($_SESSION['langSessId']=='spn'){
	$message="
	Estimado ".$obj_user->f('fname')." <br>
	
	Gracias por su pedido.<br><br> 
	El número de referencia de su pedido es: <strong>".$obj_order_details->f('order_no')."</strong> <br><br>
	
	
	Por favor, mantenga de forma segura, ya que se requerirá al check in.<br> 
	Favor de imprimir este mensaje y presentarlo al registrarse en el evento.<br>
	Usted ordenó: <br><br>
	
	".$obj_order_details->f('ticket')." ".$tname.", ".$name.", ".$showdate." <br><br>
	
	Gracias por usar KPasapp.com, su pasaporte para todos los eventos de Baja California Sur. <br><br>

	Lo esperamos en ".$name.", <br><br>
	
	El Equipo de KPasapp <br>
	No responda a este correo electrónico.<br>
	Contactanos en info@kpasapp.com si necesita ayuda adicional.<br>
	";
	}
	
	if($_SESSION['langSessId']=='eng') {
	$subject="Order confirmation for ".$name."!";
	}elseif($_SESSION['langSessId']=='spn'){
	$subject="Confirmación de la orden para ".$name."!";
	}
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: info@kcpasa.com' . "\r\n";
	//$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	@mail($recipient, $subject, $message, $headers);
	//@mail('unified.subhrajyoti@gmail.com', $subject, $message, $headers);
?>

<?php /* ?>
<?php 
				$message="
				<table width='100%' border='0' align='center' cellpadding='2' cellspacing='2'>
                                
                                
                                <tr>
                                  <td><strong>You ordered: </strong></td>
                                </tr>
				<tr>
					<td>
						<div class='view_box7'>
						
						<div class='hot_event7'>";
													
						if($_SESSION['langSessId']=='eng'){
						$name = $objEvent->f('event_name_en');
								
				$message.="<h1>".$objEvent->f('event_name_en')."</h1>";
						}
						elseif($_SESSION['langSessId']=='spn')
						{
						$name = $objEvent->f('event_name_sp');
				$message.="<h1>".$objEvent->f('event_name_sp')."</h1>"; 
						}
						$start = $obj_order_details->f('start');
						$end = $obj_order_details->f('end');
						$date = $obj_order_details->f('sdate');
						$edate = $obj_order_details->f('edate');
								
				
				$message.="<p>".$objEvent->f('venue_name')."</p>";
				$message.="<p>".$objEvent->f('venue_address')."</p>";
				$message.="<p>".$objEvent->f('city_name');?>, <?php echo $objEvent->f('county_name');?>, <?php echo $objEvent->f('state_name')."</p>";               
				$message.="</div>
					    <div class='clear'></div>
					</div>

					</td>
				</tr>
				<tr>
                                  <td></td>
                                </tr>
				<tr>
					<td>
						<div class='view_box7'>
						
			
			
					<div class='hot_event7'>
					    <div>
						</div>
								<div class='clear'></div>
								<div class='hot_event7'>
								 <div  id='checkout_frm'>
					      <form action='' name='frm' id='frm' method='post'>
					      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='event_review'>
						<tr>
						  <th width='16%'>". if($_SESSION['langSessId']=='eng') {?>Quantity<?php }elseif($_SESSION['langSessId']=='spn'){?>Cantidad<?php } ."</th>
						  <th width='17%'><?php if($_SESSION['langSessId']=='eng') {?>TicketName<?php }elseif($_SESSION['langSessId']=='spn'){?>Boleto<?php }?></th>
						  <th width='16%'><?php if($_SESSION['langSessId']=='eng') {?>Price<?php }elseif($_SESSION['langSessId']=='spn'){?>Precio<?php }?></th>
						  <th width='15%'><?php if($_SESSION['langSessId']=='eng') {?>Fee<?php }elseif($_SESSION['langSessId']=='spn'){?>Cargos<?php }?></th>
						  <th width='20%'><?php if($_SESSION['langSessId']=='eng') {?>Total<?php }elseif($_SESSION['langSessId']=='spn'){?>Total<?php }?></th>
						  
						</tr>
						
						<?php 
									$count = 1;
									//echo $e_id; exit;
									$obj_ticket=new user;
									$obj_ticket->getTicketDetails($obj_order_details->f('ticket_id'));
									//while($row = $obj_ticket->next_record()){
									$obj_ticket->next_record();
									?>
						
						<tr>
						  <td>
									  <?php echo $obj_order_details->f('ticket');?></td>
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
										echo number_format($obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_ticket->f('price_mx'),2,'.',',');
									  }
									  ?></td>
						  <td></td>
						  <td><?php 
									  if($_SESSION['pay'] == 'us'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_mx'),2,'.',',');
									  }
									  ?></td>
						  
						</tr>
						
						<?php
							//$count++;
									//}
									?>
						<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>
						  </td>
						  <td>
						  <strong>
							Total : <?php
									if($_SESSION['pay'] == 'us'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_us'),2,'.',',');
									  }elseif($_SESSION['pay'] == 'mx'){
										echo number_format($obj_order_details->f('ticket')*$obj_ticket->f('price_mx'),2,'.',',');
									  }
							?>
						  </strong>
						  <?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
						</tr>
						<tr>
							<td colspan='6' style='text-align:right;'><!--<input type='submit' value='Checkout' /> <input type='submit' value='Update' />--></td>
						</tr>
					      </table>
						
					      </form>
					      </div>                      
								</div>
					    </div>
					    <div class='clear'></div>
					    
				      </div>				

					</td>
				</tr>
                               </table>

				";
				
				$subject="Payment Confirmation";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: info@abcd.com' . "\r\n";
				$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
				//@mail($recipient, $subject, $message, $headers);
				@mail('unified.subhrajyoti@gmail.com', $subject, $message, $headers);
?>
</div>
<?php */ ?>


<!--<script>
setInterval('location.href="<?php //echo $obj_base_path->base_path(); ?>"', 4000);
</script>-->
<!--footer-->
<?php include("include/frontend_footer.php");?>
<!--footer-->


</body>
</html>

