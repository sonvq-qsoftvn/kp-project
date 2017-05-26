<?php
//payment success page
include('include/user_inc.php');

//echo $_SESSION['ses_admin_id'];
//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;
$obj_new=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();


if($_SESSION['langSessId']== 'eng'){
define('SIGN_UP_WITH', 'Sign up with');
define('ORSHOW', 'OR');
define('ACCOUNT_TYPE', 'Account Type');
define('PERSONAL', 'Personal');
define('PROFESSIONAL', 'Professional');
define('FIRST_NAME', 'First Name');
define('LAST_NAME', 'Last Name');
define("EMAIL","Email address");
define('CELL_PHONE', 'Cell phone');
define('LANG', 'Language');
define('COUNTRY', 'Country');
define('PASS', 'Password');
define('CON_PASS', 'Confirm Password');
define('HUMAN', 'Are you human, or spambot?');
define('PRIVIACY', 'Privacy & Terms');
define('TERMS_CONDITION', 'By creating my KPasapp account, I agree to the  <a href="#" style="text-decoration:underline; color:#117ADA">KPasapp Terms of Service, KPasapp Privacy Policy and Communications Terms.</a>');
define('CREATE_ACCOUNT', 'Create Account');
define('SIGN_UP', 'Sign Up');
}
else if($_SESSION['langSessId']== 'spn')
{
define('SIGN_UP_WITH', 'Entrar con');
define('ORSHOW', 'o');
define('ACCOUNT_TYPE', 'Tipo de cuenta');
define('PERSONAL', 'Personal');
define('PROFESSIONAL', 'Profesional');
define('FIRST_NAME', 'Nombre');
define('LAST_NAME', 'Apellido');
define("EMAIL","Correo ElectrÃ³nico");
define('CELL_PHONE', 'MÃ³vil');
define('LANG', 'Idioma');
define('COUNTRY', 'PaÃ­s');
define('PASS', 'ContraseÃ±a');
define('CON_PASS', 'Confirme contraseÃ±a');
define('HUMAN', 'Â¿Eres humano o robot de spam?');
define('PRIVIACY', 'TÃ©rminos y condiciones');
define('TERMS_CONDITION', 'Al crear mi cuenta KPasapp, reconozco que he leÃ­do y aceptado los <a href="#" style="text-decoration:underline; color:#117ADA">Terminos y Condiciones, Politicas de Cancelaciones y DevoluciÃ³n y Politicas de Privacidad de KPasapp.com.</a>');
define('CREATE_ACCOUNT', 'Crear Cuenta');
define('SIGN_UP', 'Guardar');
}

//echo "session-id ".$_SESSION['tid']; exit;
//if($_POST['action'] == 'new_signup'){
//	$pass = $_POST[''];
//	$con_pass = $_POST[''];
//}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Completed</title>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
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
					//$tid = $_SESSION['tid'];
					//echo "ses-T= ".$_SESSION['tid'];
					//if($_SESSION['tid'] == ''){
						//echo "user : ".$_SESSION['ses_admin_id']; exit;
						$obj_transaction=new user;
						$obj_transaction->getTranId($_SESSION['ses_admin_id']);
						$obj_transaction->next_record();
						
						$tid = $obj_transaction->f('id');
					//}
					
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
					
					$obj_user->user_details($obj_order_details->f('user_id'));
					$obj_user->next_record();
				?>
                                <tr>
                                  <td>
                                  <div style="font-size:18px;margin-top:10px;">
				   Dear	<?php echo $obj_user->f('fname')." ".$obj_user->f('lname')."<br/>"; ?>
                                  <?php if($_SESSION['langSessId']=='eng') {?>Thank you for your order.<?php }elseif($_SESSION['langSessId']=='spn'){?>Gracias por su pedido.<?php }?></div></td>
                                </tr>
                               <tr><td>
				
			       </td></tr>
                                <tr>
                                  <td><img src="images/spacer.gif" alt="" width="1" height="9" /></td>
                                </tr>
				<tr>
                                  <td><strong><?php if($_SESSION['langSessId']=='eng') {?>Your order no. is<?php }elseif($_SESSION['langSessId']=='spn'){?>Su referencia es<?php }?> : <?php echo $tid;//$obj_order_details->f('order_no');?></strong></td>
                                </tr>
				<tr>
                                  <td><strong><?php if($_SESSION['langSessId']=='eng') {?>Your reference is<?php }elseif($_SESSION['langSessId']=='spn'){?>Su referencia es<?php }?> : <?php echo $obj_order_details->f('order_no');?></strong></td>
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
					    <h1><?php echo $event_id." , ".$objEvent->f('event_name_en');?></h1> 
					    <?php
					    }
								elseif($_SESSION['langSessId']=='spn')
								{
								$name = $objEvent->f('event_name_sp');
								?>
					    <h1><?php echo $event_id." , ".$objEvent->f('event_name_sp');?></h1> 
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
                                
                                $dateOfEvent = date("l, M d, Y",strtotime($date))." ".$start . " - ";
                                if($date != $edate){ 
                                    $dateOfEvent = $dateOfEvent . date("l, M d, Y",strtotime($edate)) . " " . $end;
                                }
								?>
                                
								<p><?php echo date("l, M d, Y",strtotime($date))." ".$start;?> - <?php if($date != $edate){ echo date("l, M d, Y",strtotime($edate))." ";} echo $end;?></p>
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
				//echo $_SESSION['ses_admin_id'];
				//echo $_SESSION['unique'];
				//echo $_SESSION['event_id'];
				
            $mailTalbleEN = "<table border='1' style='width: 670px;height: auto;'>
                <tr>
                    <th width='16%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Quantitys</th>
                    <th width='17%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>TicketName</th>
                    <th width='16%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Price</th>
                    <th width='15%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Fee</th>
                    <th width='20%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Total</th>
                </tr>";
            
            $mailTalbleES = "<table border='1' style='width: 670px;height: auto;border: 1px solid #CCCCCC;'>
                <tr>
                    <th width='16%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Cantidad</th>
                    <th width='17%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Boleto</th>
                    <th width='16%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Precio</th>
                    <th width='15%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Cargos</th>
                    <th width='20%' style='font-weight: bold;color: #000;padding: 2px 8px;background: #dff6f7;'>Total</th>
                </tr>";
			  $count = 1;
			  //echo $e_id; exit;
			  $obj_ticket=new user;
			  $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$_SESSION['event_id']);
			  while($row = $obj_ticket->next_record()){
			  ?>
                        <?php 
                            $mailTalbleEN = $mailTalbleEN . "<tr>";
                            $mailTalbleES = $mailTalbleES . "<tr>";
                        ?>
                        <tr>
                          <td>
                    <?php 
                        $mailTalbleEN = $mailTalbleEN . "<td>" . $obj_ticket->f('ticket') . "</td>";
                        $mailTalbleES = $mailTalbleES . "<td>" . $obj_ticket->f('ticket') . "</td>";
                        echo $obj_ticket->f('ticket');
                    ?>
                          </td>
                          <td>
                          <?php
                            if($_SESSION['langSessId']=='eng') {
                                $mailTalbleEN = $mailTalbleEN . "<td>" . $obj_ticket->f('ticket_name_en') . "</td>";
                                echo $obj_ticket->f('ticket_name_en');
                            }
                            elseif($_SESSION['langSessId']=='spn')
                            {
                                $mailTalbleES = $mailTalbleES . "<td>" . $obj_ticket->f('ticket_name_sp') . "</td>";
                                echo $obj_ticket->f('ticket_name_sp');
                            }
			    ?>
                          </td>
                          <td>
			  <?php 
                $priceTicket = '';
				if($_SESSION['pay'] == 'us'){
				      $priceTicket = number_format($obj_ticket->f('us_price'),2,'.',',');
				}elseif($_SESSION['pay'] == 'mx'){
				      $priceTicket = number_format($obj_ticket->f('mx_price'),2,'.',',');
				}
                echo $priceTicket;
                $mailTalbleEN = $mailTalbleEN . "<td>" . $priceTicket . "</td>";
                $mailTalbleES = $mailTalbleES . "<td>" . $priceTicket . "</td>";
				?></td>
                          
			    <td> 
			    <?php
			      $promo_fee_us = 0;
			      $objfee = new user;
			      $objfee->getsetting();
			      $objfee->next_record();
			     $ticketFee = '';
			     
	// ================================ Check Spanish or English and show the ticket fee  ============================
                if($_SESSION['pay'] == 'us'){
		
                    // Now check whether fees is include or not
                    if($objEvent->f('include_payment') == 1){		    
                      $tic_fee = 0;
                    }
                    else{
                      $tic_fee = $obj_ticket->f('ticket_fee_us');
                    }


                    // Now check whether promoton is include or not
                    if($objEvent->f('include_promotion') == 1){
                      $promo_fee = 0;
                    }
                    else{
                      $promo_fee = $obj_ticket->f('promo_fee_us');
                    }

                    $tic_fee_us = $promo_fee +  $tic_fee;
                    $ticketFee = number_format($tic_fee_us,2,'.',',');
                }
                else
                {
                    if($objEvent->f('include_payment') == 1){		    
                      $tic_fee_mx = 0;
                    }
                    else{
                      $tic_fee_mx = $obj_ticket->f('ticket_fee_mx');
                    }

                    // Now check whether promoton is include or not
                    if($objEvent->f('include_promotion') == 1){

                      $promo_fee_mx = 0;
                    }
                    else
                    {
                      $promo_fee_mx = $obj_ticket->f('promo_fee_mx');
                    }


                    $tic_fee_mx = $promo_fee_mx +  $tic_fee_mx;
                    $ticketFee = number_format($tic_fee_mx,2,'.',',');
                }
                
                echo $ticketFee;
                $mailTalbleEN = $mailTalbleEN . "<td>" . $ticketFee . "</td>";
                $mailTalbleES = $mailTalbleES . "<td>" . $ticketFee . "</td>";
			      
	 // ========================= End of Check Spanish or English and show the ticket fee  =========================
			    
			    
			    
			    ?>
			  </td>
                          <td>
			 
			  <?php
			  
			 // Check for inlcude payment
			  $totalTicketFee = '';
			if($_SESSION['pay'] == 'us'){
			  
			  
			  // For Include Fee
			  if($objEvent->f('include_payment') == 1){
			    
			    $incl_fee_us = 0;
			    
			  }
			  else{
			    
			    $incl_fee_us = $objfee->f('ticket_min_us') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('us_price'));
			    
			  }
			  
			  // For Include Promotion
			  if($objEvent->f('include_promotion') == 1){
			    
			    $incl_promo_us = 0;
			  }
			  else{
			    
			    $incl_promo_us = $objfee->f('promo_fee_min_us') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('us_price'));
			    
			  }
			  
			  // Calculate Total Fee for 1 ticket...
			  $total_per_ticket_fee_us =  $obj_ticket->f('ticket')*($incl_fee_us + $incl_promo_us + $obj_ticket->f('us_price'));
			  $totalTicketFee = number_format($total_per_ticket_fee_us,2,'.',',');			    
			  $_SESSION['total']=$_SESSION['total'] + $total_per_ticket_fee_us; //This is for All Total Amount  
			  
			}
			  
			elseif($_SESSION['pay'] == 'mx'){
			  
			  // For Include Fee
			  if($objEvent->f('include_payment') == 1){
			    
			    $incl_fee_mx = 0;
			    
			  }
			  else{
			    
			    $incl_fee_mx = $objfee->f('ticket_min_mx') + (($objfee->f('ticket_percent_nincl')/100)*$obj_ticket->f('mx_price'));
			    
			  }
			  
			  // For Include Promotion
			  if($objEvent->f('include_promotion') == 1){
			    
			    $incl_promo_mx = 0;
			  }
			  else{
			    
			    $incl_promo_mx = $objfee->f('promo_fee_min_mx') + (($objfee->f('promo_percent_nincl')/100)*$obj_ticket->f('mx_price'));
			    
			  }
			  
			  //echo "<br><br>=======".$obj_ticket->f('mx_price')."========<br><br><br>";
			  
			  // Calculate Total Fee for 1 ticket...
			  $total_per_ticket_fee_mx =  $obj_ticket->f('ticket')*($incl_fee_mx + $incl_promo_mx + $obj_ticket->f('mx_price'));
			  $totalTicketFee = number_format($total_per_ticket_fee_mx,2,'.',',');			    
			  $_SESSION['total']=$_SESSION['total'] + $total_per_ticket_fee_mx; //This is for All Total Amount  
			  
			   
			}
            
            echo $totalTicketFee;
            $mailTalbleEN = $mailTalbleEN . "<td>" . $totalTicketFee . "</td>";
            $mailTalbleES = $mailTalbleES . "<td>" . $totalTicketFee . "</td>";
			?>
			  </td>
	                   
                        </tr>
                        <?php 
                            $mailTalbleEN = $mailTalbleEN . "</tr>";
                            $mailTalbleES = $mailTalbleES . "</tr>";
                        ?>
                        <?php
                        	$count++;
			    }
			?>
			<tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><strong>Total : </strong></td>
                          <td>
                                <?php $finalTotal = "<strong>" . number_format($obj_order_details->f('payment_amount'),2,'.',',') . "</strong>"; ?>
                                <?php 
                                    if($_SESSION['pay'] == 'us'){
                                        if($_SESSION['langSessId']=='eng') {
                                            $finalTotal = $finalTotal . " US$";
                                        } elseif ($_SESSION['langSessId']=='spn') { 
                                            $finalTotal = $finalTotal . " EE.UU. $";                                            
                                        }                                         
                                    } elseif($_SESSION['pay'] == 'mx'){ 
                                        if($_SESSION['langSessId']=='eng') {
                                            $finalTotal = $finalTotal . " MX Pesos";
                                        } elseif ($_SESSION['langSessId']=='spn') {
                                            $finalTotal = $finalTotal . " Pesos MX";
                                        }                                         
                                    }
                                    echo $finalTotal;
                                ?>
                          </td>
		   
                </tr>
                    <?php
                        $totalRow = "
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong>Total : </strong></td>
                                <td>" . $finalTotal . "</td>
                            </tr>";
                        $mailTalbleEN = $mailTalbleEN . $totalRow . "</table>";
                        $mailTalbleES = $mailTalbleES . $totalRow . "</table>";
                    ?>
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
						<p>En breve recibirÃ¡s un email de confirmaciÃ³n con su confirmaciÃ³n electrÃ³nica.<br>Si usted no recibe el correo electrÃ³nico de confirmaciÃ³n dentro de los 5 minutos, por favor revise su carpeta de spam o basura para garantizar la entrega segura. Si usted cree que ha habido un problema con la entrega del correo electrÃ³nico, por favor contacte con nosotros en info@kpasapp.com<br>
Esperamos verle en <strong><?php echo $name;?></strong>!<br>
<!--<a href="<?php echo $obj_base_path->base_path(); ?>">Click Here</a> to return to KPasapp home page</p>-->						
</p>
						<?php }?>
					</td>
				</tr>
                               </table>
                            </form>
                <div class="clear"></div>
		<div id="pass">
			<?php
				$obj->check_user_pass($_SESSION['ses_admin_id']); 
				$obj->next_record();
				$pass_exists = $obj->f('password');
				if($pass_exists == ''){
					?>
					<?php if($_SESSION['langSessId'] == 'eng'){ ?>
					<p>Sign up to KPasapp and make it even easier to make reservation, purchase and print tickets, manage your order, and more!
</p>
					<?php }elseif($_SESSION['langSessId'] == 'spn'){ ?>
					<p>Registrate a KPasapp, y hÃ¡galo aÃºn mÃ¡s fÃ¡cil de hacer reservaciones, comprar y imprimir boletos, gestionar sus pedidos, y mucho mÃ¡s!</p>
					<?php } ?>
					
					<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>
					<form method="post" action="" enctype="multipart/form-data" name="new_frm" id="new_frm" autocomplete = "off">
					<input type="hidden" name="action" value="new_signup">
					<input type="hidden" name="aid" id="aid" value="<?php echo $_SESSION['ses_admin_id'];?>">
					<table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
					  <tr>
					    <td style="padding-left: 18px;width: 120px;"><?php echo PASS;?></td>
					    <td><input type="password" name="password" id="password" class="textbg_grey required" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_pass"></span><span id="result"></span></td>
					  </tr>
					  <tr>
					    <td style="padding-left: 18px;width: 120px;"><?php echo CON_PASS;?> <span style="color:red;">*</span></td>
							<td><input type="password" name="con_password" id="con_password" class="textbg_grey required" equalto="#password" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_con_pass"></span></td>
					  </tr>
					  <tr>
						    <td colspan="2" style="text-align:left; padding-left: 15px;"><input type="button" name="submit1" id="submit1" value="<?php echo SIGN_UP;?>" class="event_save" style="cursor:pointer;" onclick="new_signup();"/></td>
					  </tr>
					</table>
					</form>
					<?php
				}
			?>
		</div>
		
            </div>
           <div class="clear"></div>
	   
	
	</div>
	
    </div>
    <div class="clear"></div>
    <div class="clear"></div>
    

</div>
<?php
	//$obj_user->user_details($obj_order_details->f('user_id'));
	//$obj_user->next_record();
	
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
	Dear ".$obj_user->f('fname') . " " . $obj_user->f('lname') .  " <br>
	
	Thank you for your order.<br><br> 
    Your order no. is: <strong>". $tid ."</strong><br>
	Your order reference number is: <strong>".$obj_order_details->f('order_no')."</strong> <br>
    Your email address is: <strong>".$obj_user->f('email')."</strong> <br>
    Your telephone number is: <strong>".$obj_user->f('mobile')."</strong> <br><br>
	
	
	Please keep it securely, as it will be required when you check in.<br> 
	Please print this message and present it to check in at the event.<br>
	You ordered:	
	<h2>". $event_id." , ".$objEvent->f('event_name_en') . "</h2>" . $dateOfEvent . "<br>"
            . $objEvent->f('venue_name'). "<br>" . $objEvent->f('venue_address') . "<br>" 
            . $objEvent->f('city_name') . ", " . $objEvent->f('county_name') . ", " . $objEvent->f('state_name') . "<br><br>"
            . $mailTalbleEN . "
        
	<br>Thank you for using KPasapp.com, your passport to all the events of Baja California Sur <br>

	We look forward to seeing you at ".$name.", <br><br>
	
	The KPasapp Team<br>
	Do not reply to this email.<br>
	Email us at info@kpasapp.com if you require additional assistance.<br>
	";
	}
	elseif($_SESSION['langSessId']=='spn'){
	$message="
	Estimado ".$obj_user->f('fname') . " " . $obj_user->f('lname') ." <br>
	
	Gracias por su pedido.<br><br> 
    Su referencia es: <strong>". $tid ."</strong> <br>
	El nÃºmero de referencia de su pedido es: <strong>".$obj_order_details->f('order_no')."</strong> <br>
    Su dirección de correo electrónico es: <strong>".$obj_user->f('email')."</strong> <br>
    Su número de teléfono es: <strong>".$obj_user->f('mobile')."</strong> <br><br>
	
	
	Por favor, mantenga de forma segura, ya que se requerirÃ¡ al check in.<br> 
	Favor de imprimir este mensaje y presentarlo al registrarse en el evento.<br>
	Usted ordenÃ³:	
	<h2>". $event_id." , ".$objEvent->f('event_name_en') . "</h2>" . $dateOfEvent . "<br>"
            . $objEvent->f('venue_name'). "<br>" . $objEvent->f('venue_address') . "<br>" 
            . $objEvent->f('city_name') . ", " . $objEvent->f('county_name') . ", " . $objEvent->f('state_name') . "<br><br>"
	. $mailTalbleES . "
    
	<br>Gracias por usar KPasapp.com, su pasaporte para todos los eventos de Baja California Sur. <br>

	Lo esperamos en ".$name.", <br><br>
	
	El Equipo de KPasapp <br>
	No responda a este correo electrÃ³nico.<br>
	Contactanos en info@kpasapp.com si necesita ayuda adicional.<br>
	";
	}
	
	if($_SESSION['langSessId']=='eng') {
	$subject="Order confirmation for ".$name."!";
	}elseif($_SESSION['langSessId']=='spn'){
	$subject="ConfirmaciÃ³n de la orden para ".$name."!";
	}
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: info@kpasapp.com' . "\r\n";
	//$headers .= "\r\nReturn-Path: \r\n";  // Return path for errors 
	@mail($recipient, $subject, $message, $headers);
	@mail('main@kpasapp.com', $subject, $message, $headers);
//    @mail('vuquangson1610@gmail.com', $subject, $message, $headers);
?>



<!--footer-->
<?php include("include/frontend_footer.php");?>
<!--footer-->


</body>
</html>

