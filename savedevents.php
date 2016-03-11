<?php
include('include/user_inc.php');


$obj_saved_events=new user;
$obj_saved_events_num=new user;
$obj_del_saved=new user;
$obj_user=new user;
//echo "admin_id= ".$_SESSION['ses_admin_id'];
$obj_user->user_details($_SESSION['ses_admin_id']);
$obj_user->next_record();
$f_name=$obj_user->f('fname');
$l_name=$obj_user->f('lname');
//echo $f_name." ".$l_name;

if($_REQUEST['saved_id']){
	
	$obj_del_saved->delSavedEvents($_REQUEST['saved_id']);
	$_SESSION['saved_msg'] = "Event unsaved!";
	header("location:".$obj_base_path->base_path()."/savedevents");
	exit;
}
$saved_event = $_REQUEST['saved_id'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Saved Event</title>
<meta charset="utf-8">
<meta name="title" content="Saved Event">
<meta name="keywords" content="Saved Event">
<meta name="description" content="Saved Event">
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
 function multiMail(num,event_id,event_name,multi_event_id)
  {
	
  $("#loader"+num).show();
  var email="";
  var body="";
  var message="";
  var eventId=event_id;
  var eventName=event_name;
  var multiEventId=multi_event_id;
  
      //alert("chek multi");
      email=$("#email_"+num).val();
      //alert("e="+email);
      body=$("#body_"+num).val();
      //alert("b="+body);
      message=$("#message_"+num).val();
      //alert("m="+message);
      //var sm=$("#sent_mail"+num).val();
      //alert("sm="+sm);
      sendData = {"email":email,"body":body,"message":message,"eventId":eventId,"eventName":eventName,"multiEventId":multiEventId};
      
    
    $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/invite_friend.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
		    //alert(data);
		    $("#loader"+num).hide();
		    
		    $("#sent_mail"+num).html(data);
		    $(".email").val("");
		    $(".message").val("");
		    
		    setTimeout( function()
			{
				$.fancybox.close();
				$("#sent_mail"+num).html("");
				},2000);
		    	}
	  });
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
				//        $items = 2;
				//	$page = 1;
				//
				//    if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
				//	{
				//		$limit = " LIMIT ".(($page-1)*$items).",$items";
				//		$i = $items*($page-1)+1;
				//	}
				//	else
				//	{
				//		$limit = " LIMIT $items";
				//		$i = 1;
				//	}
				//	$target=$obj_base_path->base_path()."/savedevents.php";	
					
					$obj_saved_events->savedEventByUser($limit,$_SESSION['ses_admin_id']);
					$obj_saved_events_num->savedEventByUserCount($_SESSION['ses_admin_id']);
					$num = $obj_saved_events_num->num_rows();
					if($num>0)
					{
						//$p = new pagination;
						//$p->Items($num);
						//$p->limit($items);
						//$p->target($target);
						//$p->currentPage($page);
						//$p->calculate();
						//$p->changeClass("pagination1");
						$i=0;
						$j=1;
						while($obj_saved_events->next_record())
						{
										
							if($current > strtotime($obj_saved_events->f('end'))){
								$obj_del_saved->delSavedEvents($obj_saved_events->f('saved_id'));
								continue;
							}
							
			
			   if($obj_saved_events->f('multi_id')=="" || $obj_saved_events->f('multi_id')==null || $obj_saved_events->f('multi_id')==NULL)
				{
					 $multi_id=0;
				}
			/*-------------------------------------------------------------------------------------------------------------*/
				//Start date time and  end date time  of  events...//
				
				list($event_date,$event_time) = explode(" ",$obj_saved_events->f('start'));
				list($event_date_end,$event_time_end) = explode(" ",$obj_saved_events->f('end'));
					
			/*-------------------------------------------------------------------------------------------------------------*/ 				
                  ?>
                  <tr>
                    <td><?php if($_SESSION['langSessId']=='eng') { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_en').'</a>'; } else { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_sp').'</a>';}?></td>
                    <td><?php echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_saved_events->f('venue_id').'">'.$obj_saved_events->f('venue_name').'</a>';?></td>
		    <td><?php if($_SESSION['langSessId']=='eng') { echo date("D",strtotime($obj_saved_events->f('start')))." ".date("M",strtotime($obj_saved_events->f('start')))." ".date("d",strtotime($obj_saved_events->f('start'))).", ".date("Y",strtotime($obj_saved_events->f('start')))." - ".date('g:i A',strtotime($obj_saved_events->f('start'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($obj_saved_events->f('start')))." ".strftime("%e",strtotime($obj_saved_events->f('start')))." de ".strftime("%b",strtotime($obj_saved_events->f('start'))).", ".strftime("%Y",strtotime($obj_saved_events->f('start')))." ".strftime('%l:%M%p',strtotime($obj_saved_events->f('start'))); } ?></td>
		  
                    <td>
			
                    	<a href=""><?php if($_SESSION['langSessId']=='eng') { echo "Reservation";}else { echo "Reserva";}?></a>&nbsp;&nbsp;
			<a href="<?php echo $obj_base_path->base_path(); ?>/savedevents/<?php echo $obj_saved_events->f('saved_id');?>"><img src='<?php echo $obj_base_path->base_path(); ?>/images/cancel.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng') { echo "Remove";}else { echo "Remove";}?>"/></a>&nbsp;&nbsp;
			
			<!---------NEWLY ADDED FOR  SHARE---------------->
			<?php if($_SESSION['langSessId']=='eng'){?>
			
			<a href='<?php echo $obj_base_path->base_path(); ?>/en/event/<?php echo htmlentities(stripslashes($obj_saved_events->f('event_name_en')));?>/savedevent/<?php echo $obj_saved_events->f('id')?>' class="fancybox"><img src='<?php echo $obj_base_path->base_path(); ?>/images/share.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Share";}else{echo "Comparte";}?>"/></a>
			<?php } else {?>
			
			<a href='<?php echo $obj_base_path->base_path(); ?>/es/evento/<?php echo htmlentities(stripslashes($obj_saved_events->f('event_name_sp')));?>/savedevent/<?php echo $obj_saved_events->f('id')?>' class="fancybox"><img src='<?php echo $obj_base_path->base_path(); ?>/images/share.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Share";}else{echo "Comparte";}?>"/></a>
			
			<?php }?>
			
			<!-----------NEWLY ADDED---------->
			
		       
		        <a id="feature<?php echo $j?>" href="#inv_frnd<?php echo $j?>"><img src='<?php echo $obj_base_path->base_path(); ?>/images/invite.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Invite friends";}else{echo "Invita amigos";}?>"/></a>
			
			
			   <!---------Invite Section Start--------------->
			   <div style="display:none;">
			   <div id="inv_frnd<?php echo $j?>">
			   <div class="e-mail-wrap">
			    <div class=e-lable><?php if($_SESSION['langSessId']=='eng') { echo "Enter the list of email addresses separated by ,:" ;}else {echo "Entrar las direcciones de correo electrónico separadas por ,:" ;}?></div>
			    <div class="e-text-area"><textarea name="email" id="email_<?php echo $j?>" rows="5" cols="50" class="email"></textarea></div>
			   </div>
			   <div class="invita-wrapp">
			 <div class="invita-lable"><?php if($_SESSION['langSessId']=='eng') { echo "Your invitation message:" ;}else {echo "Su mensaje de invitación:" ;}?></div>
			 <div class="invita-text-area">
				<textarea  disabled name="body" id="body_<?php echo $j?>"  rows="50" cols="50"><?php if($_SESSION['langSessId']=='eng') { ?>Hi,&#13;<?php echo htmlentities(stripslashes($obj_saved_events->f('event_name_en'))); } else { ?>Hola,&#13;<?php echo  $obj_saved_events->f('event_name_sp');}?> <?php if($_SESSION['langSessId']=='eng') { ?> &nbsp;is coming up on  <?php  echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date))." - ".date('g:i A',strtotime($event_time)); } else { ?> &nbsp;se llevará el <?php setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($event_date))." ".strftime("%e",strtotime($event_date))." de ".strftime("%b",strtotime($event_date)).", ".strftime("%Y",strtotime($event_date))." ".strftime('%l:%M%p',strtotime($event_time)); } ?><?php if($_SESSION['langSessId']=='eng') {?> at <?php echo htmlentities(stripslashes($obj_saved_events->f('venue_name')))." in ".htmlentities(stripslashes($obj_saved_events->f('city_name'))).".&#13;".$f_name." ".$l_name."&#13;is inviting you."; } else { ?> a <?php echo $obj_saved_events->f('venue_name_sp')." in ".$obj_saved_events->f('city_name_sp').".&#13;".$f_name." ".$l_name."&#13;te está invitando."; }?> </textarea>	
				
			 </div>
			</div>
			   <div class="type-wrapp">
			    <div class="type-lable"><?php if($_SESSION['langSessId']=='eng') { echo "Type your message:" ;}else {echo "Escribe su mensaje:" ;}?></div>
			    <div class="type-text-area"><textarea name="message" id="message_<?php echo $j?>"  rows="10" cols="50" class="message"></textarea></div>
			   </div>
			   <div class="send-wrapp"><div id="sent_mail<?php echo $j?>"></div>
			   
			   <?php if($_SESSION['langSessId']=='eng') {?>
			   <div><span id="loader<?php echo $j?>" style="display:none;"><img src='<?php echo $obj_base_path->base_path(); ?>/images/total-loader.gif'></span><input type="button" name="save" value="Send" onclick="multiMail(<?php echo $j;?>,<?php echo $obj_saved_events->f('id');?>,'<?php echo htmlentities(stripslashes($obj_saved_events->f('event_name_en')));?>',<?php echo $multi_id;?>)" class="btn2_sudip"/></div>
			   <?php }
			    else { ?>
			    <div><span id="loader<?php echo $j?>" style="display:none;"><img src='<?php echo $obj_base_path->base_path(); ?>/images/total-loader.gif'></span><input type="button" name="save" value="Enviar" onclick="multiMail(<?php echo $j;?>,<?php echo $obj_saved_events->f('id');?>,'<?php echo $obj_saved_events->f('event_name_sp');?>',<?php echo $multi_id;?>)" class="btn2_sudip"/></div>
			    <?php }?>
		    			  
	                  </div>
	   
	                                   <script type="text/javascript">
					       $(document).ready(function() {
					       $("#feature<?php echo $j?>").fancybox({
						onClosed: function()
						 {
						  $('#email_<?php echo $j?>').val('');
						  $('#message_<?php echo $j?>').val('');
						 },
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
	           <!---------Invite Section End--------------->
		   
		    <!-------------Share Section Start---------------------------->
		    <?php $url=$obj_base_path->base_path().'/event/'.$obj_saved_events->f('event_id') ?>
		    <?php if($_SESSION['langSessId']=='eng' || $_REQUEST['lang']=='eng')
			  {
				  $lang="en_US";
				  $url2=$url."/lang/eng";
			  }
			  else 
			  {
				 $lang="es_ES";
				 $url2=$url."/lang/spn";
			  }
			  
			  ?>
	       <div style="display: none" id="allshare<?php echo $j?>" class="alshareCls">
		       <div id="fb-root<?php echo $j?>"></div>
		       <script>(function(d, s, id) {
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) return;
			 js = d.createElement(s); js.id = id;
			 js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=508763702557865";
			 fjs.parentNode.insertBefore(js, fjs);
		       }(document, 'script', 'facebook-jssdk'));</script>
		       
		       <div class="fb-share-button" data-href="<?php echo $url2;?>" data-type="box_count"></div>
		       
		       <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url;?>" data-via="Kpasapp" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
		       
		       <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		       
		       <!-- Place this tag where you want the +1 button to render. -->
		       <div class="g-plusone" data-size="tall"></div>
		       
		       <!-- Place this tag after the last +1 button tag. -->
		       <script type="text/javascript">
			 (function() {
			   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			   po.src = 'https://apis.google.com/js/platform.js';
			   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			 })();
		       </script>
		       
		       
		       
		       <script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>
		       
		       <!-- Place this tag where you want the su badge to render -->
		       <su:badge layout="5"></su:badge>
		       
		       <!-- Place this snippet wherever appropriate -->
		       <script type="text/javascript">
			 (function() {
			   var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
			   li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
			   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
			 })();
		       </script>
                  </div>
	     <!------------------Share Section End----------------------->
	     
                    </td>
			 
			  
		  </tr>
                  <?php
					$j++;
						//} //if date cheking
						
					   } // while
				  ?>
                 <!-- <tr>
                    <td colspan="4"><?php //$p->show();?></td>
                  </tr>-->
                  <?php
					} //(num>0)
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

<!---------------Fancy  box  start---------------------->

	    <script type="text/javascript">
		    jQuery(document).ready(function() {
			//jQuery("a.fancybox").fancybox();
	    
		    $(".fancybox").fancybox({
			     'width': 400,
			     'height': 100,
			     'autoSize': false,
			     'transitionIn'    : 'elastic',
			    'transitionOut'    : 'elastic',
			    'type'             : 'iframe'
			});});	    
		</script>
<!----------------Fancy box end--------------------->

</body>
</html>
