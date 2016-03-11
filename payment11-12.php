<?php
include('include/user_inc.php');
$e_id = $_REQUEST['event_id'];
//$sub_id = $_REQUEST['sub_id'];
//echo $event_id; exit;

//create object
$objEvent=new user;
$objmulti_event=new user;
$objmul_date=new user;
$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;
$objsub_event=new user;
$obj_venue_sub=new user;

$obj_sub_ticket=new user;
$obj_sub_ticket_img=new user;

$obj_chk=new user;
$obj_cur_eve_dt=new user;

$obj_cart=new user;
$obj_cart_details=new user;
$obj_remove=new user;
$obj_count=new user;
$obj_total=new user;
$obj=new user;
$obj_country=new user;
$obj_venuestate=new user;

$obj_cart_details->getCartDetails($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
					
//echo $obj_cart_details->num_rows();
if($obj_cart_details->num_rows() == 0){ 
	//echo "hi ".$e_id; exit;
	header("location:".$obj_base_path->base_path()."/event/".$e_id); 
	exit;
}

$obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
$obj_ticket->next_record();
if($obj_ticket->f('mx_price') != '' && $obj_ticket->f('us_price') == 0){					
$_SESSION['pay'] = 'mx';
}
elseif($obj_ticket->f('us_price') != '' && $obj_ticket->f('mx_price') == 0){
$_SESSION['pay'] = 'us';
}
elseif($obj_ticket->f('us_price') != '' && $obj_ticket->f('mx_price') != 0){
$_SESSION['pay'] = 'us';
}

if($_GET['act'] != ''){
	unset($_SESSION['pay']);
	$_SESSION['pay'] = $_GET['act'];
}

if($_GET['type'] != '' && $_GET['type'] == 'checkout'){
	if($_SESSION['payment'] == 'standard'){
		header("location: ".$obj_base_path->base_path()."/standard/pay.php");
	}
}

$obj_count->getCartCount($_SESSION['ses_admin_id'],$_SESSION['unique']);
	if($obj_count->num_rows()==0){
		header("location: ".$obj_base_path->base_path()."/index");
	}

//print_r($_SESSION);
if($_GET['action'] == 'del' && $_GET['tid'] !=''){
	//echo "hihih".$e_id; exit;
	$obj_remove->remove($_GET['tid']);
	$obj_remove->next_record();
	header("location: ".$obj_base_path->base_path()."/payment/".$e_id);
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>
<script type="text/javascript">

$(document).ready(function() {
        
        //options( 1 - ON , 0 - OFF)
        var auto_slide = 0;
        var hover_pause = 1;
        var key_slide = 1;
        
        //speed of auto slide(
        var auto_slide_seconds = 500;
        /* IMPORTANT: i know the variable is called ...seconds but it's 
        in milliseconds ( multiplied with 1000) '*/
        
        /*move he last list item before the first item. The purpose of this is 
        if the user clicks to slide left he will be able to see the last item.*/
		
        //$('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        
        //check if auto sliding is enabled
        if(auto_slide == 1){
            /*set the interval (loop) to call function slide with option 'right' 
            and set the interval time to the variable we declared previously */
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            
            /*and change the value of our hidden field that hold info about
            the interval, setting it to the number of milliseconds we declared previously*/
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
  
        //check if hover pause is enabled
       /* if(hover_pause == 1){
            //when hovered over the list 
            $('#carousel_ul').hover(function(){
                //stop the interval
                clearInterval(timer)
            },function(){
                //and when mouseout start it again
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
  
        }*/
  
        //check if key sliding is enabled
        if(key_slide == 1){
            
            //binding keypress function
            $(document).bind('keypress', function(e) {
                //keyCode for left arrow is 37 and for right it's 39 '
                if(e.keyCode==37){
                        //initialize the slide to left function
                        slide('left');
                }else if(e.keyCode==39){
                        //initialize the slide to right function
                        slide('right');
                }
            });

        }
        
        
  });

//FUNCTIONS BELLOW

//slide function  
function slide(where){
    
            //get the item width
            var item_width = $('#carousel_ul li').outerWidth() + 500;
            
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/
            if(where == 'left'){
                //...calculating the new left indent of the unordered list (ul) for left sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
            }else{
                //...calculating the new left indent of the unordered list (ul) for right sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
            
            }
            
            
            //make the sliding effect using jQuery's animate function... '
            $('#carousel_ul:not(:animated)').animate({'left' : left_indent},0,function(){    
                
                /* when the animation finishes use the if statement again, and make an ilussion
                of infinity by changing place of last or first item*/
                if(where == 'left'){
                    //...and if it slided to left we put the last item before the first item
                    $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                }else{
                    //...and if it slided to right we put the first item after the last item
                    $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
                }
                
                //...and then just get back the default left indent
                $('#carousel_ul').css({'left' : '0px'});
            });
            
            
            
             
           
}
  
  
function tkt_num(count,cart_id,event_id){
	sendData = {"count":$("#ticket_num"+count).val(),"cart_id":cart_id,"event_id":event_id};
	//alert(event_id);
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_ticket_num.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#checkout_frm").html(data);
	   }
	 });
}


</script>

<script type="text/javascript">
function checkLoggedin(){
	<?php
		if($_SESSION['ses_admin_id']==""){
	?>
		$('html, body').animate({scrollTop: parseInt($("#text_email").offset().top) - 100}, 2000);
		$('#email_cell').focus();
	<?php
		} else{
	?>
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/checkSavedEvent.php",
		   cache: false,
		   type: "POST",
		   data: "event_id=<?php echo $event_id;?>",   
		   success: function(data){
			  // alert(data);
			   if(data==1){
				$('#alrdy_svd_evnt1').trigger('click');
			   }
			   else
			   {
		  	 	window.location = "<?php echo $obj_base_path->base_path(); ?>/add_saved_events.php?event_id=<?php echo $event_id;?>";
			   }
		   }
		 });
		
	<?php }?>
	
}

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#alrdy_svd_evnt1").fancybox({ 
			'hideOnOverlayClick':false,
			'hideOnContentClick':false,
			'onComplete': function(){
				setTimeout( function() {$.fancybox.close(); },2000); // 3000 = 3 secs
			  }
		});
	});
	
function setHover1(val,setDateTime,multi_id,event_id)
{
	//alert(multi_id);
	//alert(event_id);
	$("#frm_multi_id").val(multi_id);
	$("#frm_event_id").val(event_id);
	
	$('.abc').css({"color":"#FFFFFF","font-size":"12px","font-weight":"normal"});

	$('#tbl1'+val).css({"color":"red","font-size":"15px","font-weight":"bold"});
	$('.timetxt').html(setDateTime);
}

function addtocart(num,mx,us)
{
	//alert(val)
	$("#frm_ticket"+num).val($("#ticket_num"+num).val());
	$("#frm_mx_price"+num).val(mx);
	$("#frm_us_price"+num).val(us);
}

function save(){
	$("#frm").submit();
}
	

function pay_type(type){
	if(type == 'standard'){
		//alert('<?php echo $obj_base_path->base_path()?>/standard/pay.php');
		document.frm.action = '<?php echo $obj_base_path->base_path()?>/standard/pay.php';
		$("#frm").submit();
	}
}
	
	</script>
<div style="display:none;">
    <div style="width:400px;height:auto; background:#FFF; padding:10px; font-size:19px;" id="alrdy_svd_evnt">
       You already saved this event.
    </div>
</div>
<a href="#alrdy_svd_evnt" id="alrdy_svd_evnt1"></a>

</head>
<body>
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg">
            
            <div style="text-align:center;"><?php if($_SESSION['err'] != ''){ echo $_SESSION['err']; unset($_SESSION['err']);}?></div>
            <div class="clear"></div>
            
            	
                <div class="clear"></div>
				<div class="view_box7">
                	<div class="heading"><?php if($_SESSION['langSessId']=='eng') {?>Checkout<?php }elseif($_SESSION['langSessId']=='spn'){?>finalizar pedido<?php }?></div>
                	<div class="hot_event7">
					<?php
					$obj_cart_details->next_record();
					$event_id = $obj_cart_details->f('event_id');
					//$payment =  $obj_cart_details->f('payment');
					$ticket_id =  $obj_cart_details->f('ticket_id');
					$multi_id  =  $obj_cart_details->f('multi_id');
					//$_SESSION['payment'] = $payment;
					// Event Details
					$objEvent->getEventDetails($event_id);
					$objEvent->next_record();
					
					
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
                    $start = strtotime($objEvent->f('event_start_date_time'));
					$end = strtotime($objEvent->f('event_end_date_time'));
					?>
					<p><?php echo date("d-m-Y g:i A",$start);?> - <?php echo date("d-m-Y g:i A",$end);?></p>
					<p><?php echo $objEvent->f('venue_name');?></p>
					<p><?php echo $objEvent->f('venue_address');?></p>
					<p><?php echo $objEvent->f('city_name');?>, <?php echo $objEvent->f('county_name');?>, <?php echo $objEvent->f('state_name');?></p>                
                    </div>
                    <div class="clear"></div>
                </div>
				<div class="view_box7">
                	<div class="heading"><?php if($_SESSION['langSessId']=='eng') {?>Review your order<?php }elseif($_SESSION['langSessId']=='spn'){?>Revise su pedido<?php }?></div>
                	<div class="hot_event7">
                    <div><span> <span style="float: right; padding: 0; margin: 0 auto; width: 315px;"><strong>
					<?php if($_SESSION['langSessId']=='eng') {
						if($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0){
						?>
                    		Select payment currency:
                    <?php
						}
						else
						{
							echo "Payment Currency:"; 
						}
                    }
					elseif($_SESSION['langSessId']=='spn'){
					if($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0){
					?>
                    		Seleccione moneda de pago:
                    <?php 
						}
						else
						{
							echo "moneda de pago:";
						}
					}
					?>
                    
                    <?php
					
					
					//echo $obj_ticket->f('mx_price');
					//echo $obj_ticket->f('us_price');
					
                    if($obj_ticket->f('mx_price') != 0 && $obj_ticket->f('us_price') == 0){?>
<?php if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php }?> <!--<a href="<?php //echo $obj_base_path->base_path()."/payment.php?act=mx"; ?>"><input type="radio" name="cur" id="" value="" <?php //if($_SESSION['pay'] == 'mx'){ echo "checked";}?> /></a>-->
					<?php
                    }elseif($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') == 0)
					{
					?>
 <?php if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php }?> <!--<a href="<?php //echo $obj_base_path->base_path()."/payment.php?act=us"; ?>"><input type="radio" name="cur" id="" value="" <?php //if($_SESSION['pay'] == 'us'){ echo "checked";}?> /></a> -->
 					<?php
                    }
					elseif($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0)
					{
					?>
<?php if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php }?> <a href="<?php echo $obj_base_path->base_path()."/payment.php?act=mx"; ?>"><input type="radio" name="cur" id="" value="" <?php if($_SESSION['pay'] == 'mx'){ echo "checked";}?> /></a>

<?php if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php }?> <a href="<?php echo $obj_base_path->base_path()."/payment.php?act=us"; ?>"><input type="radio" name="cur" id="" value="" <?php if($_SESSION['pay'] == 'us'){ echo "checked";}?> /></a> 

					<?php
                    }
					?>
 					</strong></span></span></div>
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
                          <th width="16%">&nbsp;</th>
                        </tr>
                        
                        <?php 
						$count = 1;
						//echo $e_id; exit;
						$obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
						while($row = $obj_ticket->next_record()){
						?>
                        
                        <tr>
                          <td>
						  <select name="ticket_num" id="ticket_num<?php echo $count;?>" onchange="tkt_num(<?php echo $count;?>,<?php echo $obj_ticket->f('cart_id');?>,<?php echo $e_id;?>);">
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
						  	echo $obj_ticket->f('us_price');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo $obj_ticket->f('mx_price');
						  }
						  ?></td>
                          <td></td>
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo $obj_ticket->f('ticket')*$obj_ticket->f('us_price');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo $obj_ticket->f('ticket')*$obj_ticket->f('mx_price');
						  }
						  ?></td>
                          <td><a href="<?php echo $obj_base_path->base_path()."/payment.php?event_id=".$e_id."&action=del&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
                        </tr>
                        
                        <?php
                        	$count++;
						}
						?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><strong>Total : <?php $obj_total->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total->next_record(); //echo $obj_total->f('Total');?></strong>
                          <input type="hidden" name="ticket" value="<?php echo $obj_total->f('Total');?>" />
                          </td>
                          <td><strong>Total : <?php $obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay'],$_SESSION['unique'],$e_id); $obj_total->next_record(); echo $obj_total->f('Amt');?></strong></td>
                          <td><?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
                        </tr>
                        <tr>
                        	<td colspan="6" style="text-align:right;"><!--<input type="submit" value="Checkout" /> <input type="submit" value="Update" />--></td>
                        </tr>
                      </table>
                      	<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
                        <input type="hidden" name="amount" value="<?php echo $obj_total->f('Amt');?>" />
                        <input type="hidden" name="payment_type" id="payment_type" value="" />
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
                        <input type="hidden" name="multi_id" value="<?php echo $multi_id;?>" />
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['ses_admin_id'];?>" />
                        <input type="hidden" name="name" value="<?php echo $name;?>" />
                      </form>
                      </div>                      
					</div>
                    </div>
                    <div class="clear"></div>
              </div>				
				<div class="clear"></div>
              <div class="blue_bg"><?php if($_SESSION['langSessId']=='eng') {?>Buyers Information<?php }elseif($_SESSION['langSessId']=='spn'){?>Información del comprador<?php }?></div> 
			  <div class="clear"></div>
			  
              <?php if($_SESSION['ses_admin_id'] == ''){?>
              
              <div class="account_bg" style="height: 52px;"><?php if($_SESSION['langSessId']=='eng') {?>You have a KPasapp.com account?<?php }elseif($_SESSION['langSessId']=='spn'){?>¿Tiene una cuenta KPasapp.com?<?php }?>
              <br />
              <span class="field_bg" style="width: 652px;margin: -1px; text-align:center;">
			  <?php if($_SESSION['langSessId']=='eng') {?>Sign in with <?php }elseif($_SESSION['langSessId']=='spn'){?>Entrar con <?php }?> <img src='<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif' width="22" height="22" border="0"/><img src='<?php echo $obj_base_path->base_path(); ?>/images/4google_blue.gif' width="22" height="22" border="0"/><strong><?php if($_SESSION['langSessId']=='eng') {?> OR<?php }elseif($_SESSION['langSessId']=='spn'){?> O<?php }?></strong> 
              <input type="text" name="textfield" class="textbg_grey" placeholder="<?php if($_SESSION['langSessId']=='eng') {?>Email or Cell#<?php }elseif($_SESSION['langSessId']=='spn'){?>Email o celular #<?php }?>" style="width: 150px;"/>  
              <input type="text" name="textfield" class="textbg_grey" placeholder="<?php if($_SESSION['langSessId']=='eng') {?>Password<?php }elseif($_SESSION['langSessId']=='spn'){?>Contraseña<?php }?>" style="width: 150px;"/>
              <input type="submit" name="Submit" value="<?php if($_SESSION['langSessId']=='eng') {?>Sign in<?php }elseif($_SESSION['langSessId']=='spn'){?>Entrar<?php }?>" class="btn1_sudip"/>
              </span>			    
		 	 </div>
         
         	 <?php }?>
         
		 <div class="clear"></div> 
		   
		 <div class="clear"></div>
		 <div class="account_box" style="margin-bottom: 19px;">
		 <div class="account_left">
         
         	<!--form-->
            <?php
				if($_SESSION['ses_admin_id'] != ''){
					$obj->getAdminById($_SESSION['ses_admin_id']);
					$obj->next_record();
				}
			?>
           <form method="post" action="" enctype="multipart/form-data" name="contact" id="contact" autocomplete = "off"> 
            <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
               <tr>
                <td width="23%" style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "First Name";}elseif($_SESSION['langSessId']=='spn'){echo "Nombre";} ?> <span style="color:red;">*</span></td>
                    <td width="77%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="<?php echo $obj->f('fname')?>" style="width: 190px;"/><br/><span class="err" id="err_name"></span></td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Last Name";}elseif($_SESSION['langSessId']=='spn'){ echo "Apellido";} ?><span style="color:red;">*</span></td>
                <td>
                    <input type="text" name="lname" id="lname" class="textbg_grey required" value="<?php echo $obj->f('lname');?>" style="width: 190px;"/> <br/>
                    <span class="err" id="err_lname"></span>
                </td>
              </tr>						  
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Email";}elseif($_SESSION['langSessId']=='spn'){ echo "Correo Electrónico";} ?><span style="color:red;">*</span></td>
                <td>
                <input type="text" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" onblur="return IsEmail();" readonly="readonly" />
                <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>
                </td>
              </tr>
                                          
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Mobile#";}elseif($_SESSION['langSessId']=='spn'){ echo "móvil";}?></td>
                <td>
                    <select name="mobile_code" id="mobile_code" class="textbg_grey" style="width:155px; margin-left:5px;">
                    <?php
                         $obj_cntry = new user;
                        $sel = "selected='selected'";
                         $obj_cntry->countries_list();
                            while($obj_cntry->next_record()){
                    ?>
                        <option value="<?php echo $obj_cntry->f('phonecode');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $obj->f('mobile_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $obj->f('mobile_code')==''){ echo $sel; } else if($obj->f('mobile_code')==$obj_cntry->f('phonecode')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                    <?php
                        }
                    ?>    
                    </select>

                  <input type="text" name="phone" id="phone" class="textbg_grey" value="<?php echo $obj->f('mobile')?>" style="width: 190px;" onkeyup="checkPhone()" />
                                            
                    <div id="sh_alt_phn" style="color:red; margin-left:6px;"></div>
                </td>
              </tr>
              
              
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Country";}elseif($_SESSION['langSessId']=='spn'){ echo "País";}?><span style="color:red;">*</span></td>
                <td>
                    <select name="country_id" id="country_id" onchange="setCountryCode()" class="textbg_grey" style="width:205px;margin-left:5px;">
                    <?php
                        $value_code = '';
                        $sel = "selected='selected'";
                        if($_SESSION['langSessId']=="spn")
                            $value_code = "value='52'";
                        else
                            $value_code = "value='1'";
                        
                        // check country code for per user
                        if($obj->f('country_code')!="" && $obj->f('country_code')!=0)
                            $value_code = $obj->f('country_code');
                            
                        $obj_country->countries_list();
                        while($obj_country->next_record()){
                    ?>
                        <option value="<?php echo $obj_country->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $obj->f('country_id')==0){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $obj->f('country_id')==0){ echo $sel; } else if($obj->f('country_id')==$obj_country->f('id')) { echo $sel;}  ?>><?php echo $obj_country->f('nicename');?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="hidden" name="country_code" id="country_code" value="<?php echo $value_code;?>" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "State";}elseif($_SESSION['langSessId']=='spn'){ echo "Estado";}?><span style="color:red;" id="star1">*</span></td>
                <td>
                  <div id="div_state_display">
                   <select name="province" id="province" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">State</option>
                        <?php
                          $obj_venuestate->getStateById($obj->f('country_id'));
                          while($row = $obj_venuestate->next_record())
                          {
                          ?>
                          <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('province')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_venuestate->f('state_name');?></option>
                            <?php
                          }
                          ?>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "County";}elseif($_SESSION['langSessId']=='spn'){ echo "Municipio";}?><span style="color:red;">*</span></td>
                <td>
                    <input type="text" name="county" id="county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('county')?>" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "City";}elseif($_SESSION['langSessId']=='spn'){ echo "Ciudad";}?><span style="color:red; display:none;" id="star3">*</span></td>
                <td>
                      <input type="text" name="city" id="city" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('city')?>" />  
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Address";}elseif($_SESSION['langSessId']=='spn'){ echo "Dirección";}?><span style="color:red;">*</span></td>
                <td>
                <textarea name="address" id="address" style="width:210px; margin-left: 6px;"><?php echo $obj->f('address')?></textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Postal Code";}elseif($_SESSION['langSessId']=='spn'){ echo "Código Postal";}?><span style="color:red;">*</span></td>
                <td>
                <input type="text" name="postal_code" id="postal_code" class="textbg_grey" style="width: 190px; margin-right:6px;" value="<?php echo $obj->f('postal_code')?>" />
                </td>
              </tr>
              
            </table>
            
            
            <!--end-->
         
         </div>		
		 </div>
		 <div class="clear"></div>
        <div class="blue_bg"><?php if($_SESSION['langSessId']=='eng') {?>Select your payment method<?php }elseif($_SESSION['langSessId']=='spn'){?>Seleccione su forma de pago<?php }?></div> 
		 <div class="clear"></div>		 
		 <div class="account_box">
		 <div class="account_left">
		 <div class="blue_buy">
		 <h1>Buy : <span>Select your payment option</span></h1>
		 <div class="clear"></div>
		 <div class="blue_inn" align="center">
		 <ul>
		 <li><a href="javascript:void(0);" >Credit/Debit Card</a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo5.gif' width="35" height="19" border="0"/><br/>
		   <input name="radiobutton" type="radio" value="radiobutton" onclick="pay_type('standard');"/></li>
		 <li><a href="#">Paypal</a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo6.gif' width="35" height="19" border="0"/><br/><input name="radiobutton" type="radio" value="radiobutton"/></li>
		 <li><a href="#">Bank Transfer</a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo7.gif' width="40" height="21" border="0"/><br/><input name="radiobutton" type="radio" value="radiobutton"/></li>
		 <?php if($_SESSION['pay'] == 'mx'){?>
         <li style="border: 0;"><a href="#">Cash</a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo8.gif' width="44" height="21" border="0"/><br/><input name="radiobutton" type="radio" value="radiobutton"/></li>
         <?php }?>
		 </ul>
		 </div>
		 </div>
		 </div>		 
		 </div>
         
         By clicking the "Submit Order" button, you are agreeing to the KPasapp.com Purchase Policy and Privacy Policy. All orders are subject to payment approval and billing address verification. Please contact customer service if you have any questions regarding your order.
         <div align="center"><input type="submit" value="Submit Order" class="btn1_sudip" /></div>
          </form>                 
          </div>
        	  <?php include("include/frontend_rightsidebar.php");?>
			
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>

<?php if($obj_venue->f('venue_name')!=$obj_venue_sub->f('venue_name')){?>
<script type="text/javascript">
$(document).ready(function(){
	initialize('<?php echo $obj_venue->f('city'); ?>+<?php echo $obj_venue->f('st_name'); ?>+<?php echo $obj_venue->f('venue_zip'); ?>');
})
</script>
<?php } ?>

</body>
</html>
