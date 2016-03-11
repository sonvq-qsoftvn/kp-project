<?php
include('include/user_inc.php');
//$event_id = $_REQUEST['event_id'];
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

$_SESSION['pay'] = 'us';
if($_GET['act'] != ''){
	unset($_SESSION['pay']);
	$_SESSION['pay'] = $_GET['act'];
}

if($_GET['type'] != '' && $_GET['type'] == 'checkout'){
	if($_SESSION['payment'] == 'standard'){
		header("location: ".$obj_base_path->base_path()."/standard/pay.php");
	}
}

$obj_count->getCartCount($_SESSION['ses_admin_id']);
	if($obj_count->num_rows()==0){
		header("location: ".$obj_base_path->base_path()."/index");
	}


//print_r($_SESSION);
if($_GET['action'] == 'del' && $_GET['tid'] !=''){
	//echo $_GET['tid']; exit;
	$obj_remove->remove($_GET['tid']);
	$obj_remove->next_record();
	header("location: ".$obj_base_path->base_path()."/payment");
}

if(isset($_POST['action']) && $_POST['action'] == 'cart')	
{
	//echo "success "; 
	/*echo $_POST['frm_event_id']."cvb ";
	echo $_POST['frm_multi_id']."cvbc ";
	echo $_POST['frm_count']."xxx ";*/
	$unique = time();
	for($i=1;$i<$_POST['frm_count'];$i++){
	/*echo $_POST['frm_ticket'.$i]." ";
	echo $_POST['frm_mx_price'.$i]." ";
	echo $_POST['frm_us_price'.$i]."<br>";*/
		if($_POST['frm_ticket'.$i] != ''){
			$cid[] = $obj_cart->add_to_cart($_POST['frm_event_id'],$_POST['frm_multi_id'],$_POST['frm_ticket'.$i],$_POST['frm_mx_price'.$i],$_POST['frm_us_price'.$i],$unique);
		}
	}
	if($_SESSION['ses_admin_id'] == ''){
		$_SESSION['cid'] = $cid;
		$_SESSION['unique'] = $unique;
		$_SESSION['err'] = "Login to continue..";
		header("location: ".$obj_base_path->base_path()."/event/".$_POST['frm_event_id']."");
		exit;
	}
	else
	{
		$_SESSION['cid'] = '';
		header("location: payment");
	}
	/*print_r($cid);
	exit;*/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

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
                	<div class="heading">Checkout</div>
                	<div class="hot_event7">
					<?php
					$obj_cart_details->getCartDetails($_SESSION['ses_admin_id']);
					$obj_cart_details->next_record();
					$event_id = $obj_cart_details->f('event_id');
					$payment =  $obj_cart_details->f('payment');
					$_SESSION['payment'] = $payment;
					// Event Details
					$objEvent->getEventDetails($event_id);
					$objEvent->next_record();
					
					
                    if($_SESSION['langSessId']=='eng') {
					?>
                    <h1><?php echo $objEvent->f('event_name_en');?></h1> 
                    <?php
                    }
					elseif($_SESSION['langSessId']=='spn')
					{
					?>
                    <h1><?php echo $objEvent->f('event_name_sp');?></h1> 
					<?php 
					}
					?>
					<p><?php echo $objEvent->f('event_start_date_time'); echo $objEvent->f('event_start_ampm');?> - <?php echo $objEvent->f('event_end_date_time'); echo $objEvent->f('event_end_ampm');?></p>
					<p><?php echo $objEvent->f('venue_name');?></p>
					<p><?php echo $objEvent->f('venue_address');?></p>
					<p><?php echo $objEvent->f('city_name');?>, <?php echo $objEvent->f('nicename');?>, <?php echo $objEvent->f('state_name');?></p>                
                    </div>
                    <div class="clear"></div>
                </div>
				<div class="view_box7">
                	<div class="heading">Review your order</div>
                	<div class="hot_event7">
                    <div><span>If Tickets are priced in both US$ and MX pesos:  <span style="float: right; padding: 0; margin: 0 auto; width: 272px;"><strong>Select payment currency:<br />
  MX Pesos  <a href="<?php echo $obj_base_path->base_path()."/payment.php?act=mx"; ?>"><input type="radio" name="cur" id="" value="" <?php if($_SESSION['pay'] == 'mx'){ echo "checked";}?> /></a>   US$  <a href="<?php echo $obj_base_path->base_path()."/payment.php?act=us"; ?>"><input type="radio" name="cur" id="" value="" <?php if($_SESSION['pay'] == 'us'){ echo "checked";}?> /></a> </strong></span></span></div>
					<div class="clear"></div>
					<div class="hot_event7">
					  <form action="<?php echo $obj_base_path->base_path()?>/standard/pay.php" method="post" id="">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="event_review">
                        <tr>
                          <th width="17%">TicketName</th>
                          <th width="16%">Price</th>
                          <th width="15%">Fee</th>
                          <th width="16%">Quantity</th>
                          <th width="20%">Total</th>
                          <th width="16%">&nbsp;</th>
                        </tr>
                        
                        <?php 
						$obj_ticket->getTicket($_SESSION['ses_admin_id']);
						while($row = $obj_ticket->next_record()){
						?>
                        
                        <tr>
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
                          <td><?php echo $obj_ticket->f('ticket');?></td>
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo $obj_ticket->f('ticket')*$obj_ticket->f('us_price');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo $obj_ticket->f('ticket')*$obj_ticket->f('mx_price');
						  }
						  ?></td>
                          <td><a href="<?php echo $obj_base_path->base_path()."/payment.php?action=del&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
                        </tr>
                        
                        <?php
                        }
						?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><strong>Total : <?php $obj_total->totalTicket($_SESSION['ses_admin_id']); $obj_total->next_record(); echo $obj_total->f('Total');?></strong>
                          <input type="hidden" name="ticket" value="<?php echo $obj_total->f('Total');?>" />
                          </td>
                          <td><strong>Total : <?php $obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay']); $obj_total->next_record(); echo $obj_total->f('Amt');?></strong></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                        	<td colspan="6" style="text-align:right;"><input type="submit" value="Checkout" /></td>
                        </tr>
                      </table>
                      	<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
                        <input type="hidden" name="amount" value="<?php echo $obj_total->f('Amt');?>" />
                      </form>
					</div>
                    </div>
                    <div class="clear"></div>
                  </div>				
				<div class="clear"></div>
                
                
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
