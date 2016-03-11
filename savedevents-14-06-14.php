<?php
include('include/user_inc.php');


$obj_saved_events=new user;
$obj_saved_events_num=new user;
$obj_del_saved=new user;

if($_REQUEST['saved_id']){
	
	$obj_del_saved->delSavedEvents($_REQUEST['saved_id']);
	$_SESSION['saved_msg'] = "Event unsaved!";
	header("location:".$obj_base_path->base_path()."/savedevents");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Saved Events</title>
<!--<script type="text/javascript" src="<?php //echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>-->

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>-->
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script>
 function multiMail(num)
  {
  var email="";
  var body="";
  var message="";
  
      //alert("chek multi");
      email=$("#email_"+num).val();
      //alert("e="+email);
      body=$("#body_"+num).val();
      //alert("b="+body);
      message=$("#message_"+num).val();
      //alert("m="+message);
      //var sm=$("#sent_mail"+num).val();
      //alert("sm="+sm);
      sendData = {"email":email,"body":body,"message":message};
      $("#loader"+num).show();
    
    $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/invite_friend.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
		    alert(data);
		    $("#loader"+num).hide();
		    
		    $.fancybox.close();
			  
			  //("#inv_frnd"+num).hide();
		          ("#sent_mail"+num).html(data);
		   }
		 });
    //window.location("<?php echo $obj_base_path->base_path(); ?>/bookings");
    }
    
   <!-----------//all share//-------------->
   function all_share(event_id,url,lang,num)
    {
     //alert("hi!");
     //alert("hi!"+event_id);
     //alert("hi!"+url);
     //alert("hi!"+lang);
     //alert("#allshare"+num1);
     //alert(num1);
     $(".alshareCls").hide();
     $("#allshare"+num).slideDown("slow");
     //alert("hello1");
    
	
    } <!----funtion end.....---->
</script>

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
           <div class="cheese_box">
			 <div class="blue_box1">
			   <div class="blue_boxh"><p>Saved Event</p></div>
			 </div>
             <div class="clear"></div>
             <?php if($_SESSION['saved_msg']){?>
              <p style="font-size:16px;color:#F00;"><?php echo $_SESSION['saved_msg'];$_SESSION['saved_msg'] = '';?></p><?php } ?>
             <div class="Tchai_box" style="width: auto;">
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tool_event">
                  <tr>
                    <th width="40%">Event Name</th>
                    <th width="30%">Venue Name</th>
		    <th width="15%">Event Date</th>
                    <th width="15%">Manage</th>
                  </tr>
                  <?php
				    $current = time();
				    $items = 2;
					$page = 1;

				    if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
					{
						$limit = " LIMIT ".(($page-1)*$items).",$items";
						$i = $items*($page-1)+1;
					}
					else
					{
						$limit = " LIMIT $items";
						$i = 1;
					}
					$target=$obj_base_path->base_path()."/savedevents.php";	
					
					$obj_saved_events->savedEventByUser($limit,$_SESSION['ses_admin_id']);
					$obj_saved_events_num->savedEventByUserCount($_SESSION['ses_admin_id']);
					$num = $obj_saved_events_num->num_rows();
					if($num>0)
					{
						$p = new pagination;
						$p->Items($num);
						$p->limit($items);
						$p->target($target);
						$p->currentPage($page);
						$p->calculate();
						$p->changeClass("pagination1");
						$i=0;
						$j=1;
						while($obj_saved_events->next_record())
						{
							if($current > strtotime($obj_saved_events->f('end'))){
								$obj_del_saved->delSavedEvents($obj_saved_events->f('saved_id'));
								continue;
							}
                  ?>
                  <tr>
                    <td><?php if($_SESSION['langSessId']=='eng') { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_en').'</a>'; } else { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_sp').'</a>';}?></td>
                    <td><?php echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_saved_events->f('venue_id').'">'.$obj_saved_events->f('venue_name').'</a>';?></td>
		    <td><?php if($_SESSION['langSessId']=='eng') { echo date("D",strtotime($obj_saved_events->f('start')))." ".date("M",strtotime($obj_saved_events->f('start')))." ".date("d",strtotime($obj_saved_events->f('start'))).", ".date("Y",strtotime($obj_saved_events->f('start')))." - ".date('g:i A',strtotime($obj_saved_events->f('start'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($obj_saved_events->f('start')))." ".strftime("%e",strtotime($obj_saved_events->f('start')))." de ".strftime("%b",strtotime($obj_saved_events->f('start'))).", ".strftime("%Y",strtotime($obj_saved_events->f('start')))." ".strftime('%l:%M%p',strtotime($obj_saved_events->f('start'))); } ?></td>
                    <td>
                    	<a href=""><?php if($_SESSION['langSessId']=='eng') { echo "Reservation";}else { echo "Reserva";}?></a>&nbsp;&nbsp;
			<a href="<?php echo $obj_base_path->base_path(); ?>/savedevents/<?php echo $obj_saved_events->f('saved_id');?>"><img src='<?php echo $obj_base_path->base_path(); ?>/images/cancel.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng') { echo "Remove";}else { echo "Remove";}?>"/></a>&nbsp;&nbsp;
                        <a onclick="all_share('<?php echo $obj_saved_events->f('id')?>','<?php echo $obj_base_path->base_path().'/event/'.$obj_saved_events->f('id')?>','<?php if($_SESSION['langSessId']=='eng'){echo "en_US";}else{echo "es_ES";}?>','<?php echo $j?>')"><img src='<?php echo $obj_base_path->base_path(); ?>/images/share.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Share";}else{echo "Comparte";}?>"/></a>&nbsp;&nbsp;
                        <a id="feature<?php echo $j?>" href="#inv_frnd<?php echo $j?>"><img src='<?php echo $obj_base_path->base_path(); ?>/images/invite.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Invite friends";}else{echo "Invita amigos";}?>"/></a>
			
			<!-- jQuery fancybox plugin -->
			 <script type="text/javascript">
					$(document).ready(function() {
					       $("#feature"+<?php echo $j?>).fancybox({
					        'width': 400,
						'height': 400,
						'transitionIn'	: 'elastic',
						'transitionOut' : 'elastic',
						//autoSize: true ,
					      'hideOnOverlayClick':false,
					      'hideOnContentClick':false
						
						});
					});
				  </script>
			  <!---------Invite Section Start--------------->
			  <div style="display:none;">
			   <div id="inv_frnd<?php echo $j?>">
			   <div><span class="heading7">Emails:</span><span><textarea name="email" id="email_<?php echo $j?>" rows="5" cols="50"></textarea></span></div>
			   <div><span class="heading7">Event's Details:</span></span><textarea disabled name="body" id="body_<?php echo $j?>"  rows="10" cols="50">Hi,<?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_saved_events->f('event_name_en'))); } else { echo  $obj_saved_events->f('event_name_sp');}?> is coming up on <?php if($_SESSION['langSessId']=='eng') { echo date("D",strtotime($obj_saved_events->f('start')))." ".date("M",strtotime($obj_saved_events->f('start')))." ".date("d",strtotime($obj_saved_events->f('start'))).", ".date("Y",strtotime($obj_saved_events->f('start')))." - ".date('g:i A',strtotime($obj_saved_events->f('start'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($obj_saved_events->f('start')))." ".strftime("%e",strtotime($obj_saved_events->f('start')))." de ".strftime("%b",strtotime($obj_saved_events->f('start'))).", ".strftime("%Y",strtotime($obj_saved_events->f('start')))." ".strftime('%l:%M%p',strtotime($obj_saved_events->f('start'))); } ?> at <?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_saved_events->f('venue_name')))." in ".htmlentities(stripslashes($obj_saved_events->f('city_name'))); } else { echo $obj_saved_events->f('venue_name_sp')." in ".$obj_saved_events->f('city_name_sp'); }?> </textarea></span></div>
			   <div><span class="heading7">Message:</span><span><textarea name="message" id="message_<?php echo $j?>"  rows="10" cols="50"></textarea></span></div>
			   <div><input type="button" name="save" value="save" onclick="multiMail(<?php echo $j?>)" class="btn2_sudip"/></div>
			   </div>
			  <span id="loader<?php echo $j?>" style="display:none;"><img src='<?php echo $obj_base_path->base_path(); ?>/images/total-loader.gif'></span>
			  <div id="sent_mail<?php echo $j?>"></div>
	                  </div>
	           <!---------Invite Section End--------------->
			</div>
                    </td>
                  </tr>
                  <?php
		                          $j++;
						}
				  ?>
                  <tr>
                    <td colspan="4"><?php $p->show();?></td>
                  </tr>
                  <?php
					}
					else{
				  ?>
                   <tr>
                    <td colspan="4"> <span style="font-size:14px;color:red">No Record Found</span></td>
                  </tr>
                   <?php
						}
				  ?>
                </table>
             </div>
           </div>
           <div class="clear"></div>
                    
         </div>
         <?php include("include/frontend_rightsidebar.php");?>
         <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>


</body>
</html>
