<?php
include('include/user_inc.php');


$obj_bookings_events=new user;
$obj_bookings_events_num=new user;
$objEvent=new user;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Bookings</title>
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
      //$("#loader"+num).show();
    
    $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/invite_friend.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
		    alert(data);
		    $("#loader"+num).hide();
		    
		    $("#sent_mail"+num).html(data);
		    $(".email").val("");
		    $(".message").val("");
		    
		    setTimeout( function() {
		                           $.fancybox.close();
					   $("#sent_mail"+num).html("");
					   },4000);
		    
		     //email="";
		     //body="";
		     //message="";
		     
			  //("#inv_frnd"+num).hide();
		          

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

<style>
 .heading7{
  /*position:absolute;*/
  left:100px;
  top:150px;
  background: #fff;
 }
.e-lable, .invita-lable, .type-lable {
  background: none repeat scroll 0 0 #9DD4EC;
  color: #000000;
  float: left;
  padding: 11px;
  width: 95%;
}
.e-mail-wrap textarea, .invita-wrapp textarea, .type-wrapp textarea {
  border: medium none;
}
#fancybox-content {
  background: none repeat scroll 0 0 #FFFFFF;
}
.invita-text-area textarea, .type-text-area textarea {
  padding: 10px;
  height: 90px;
}
.send-wrapp .btn2_sudip {
  border-radius: 4px 4px 4px 4px;
  color: #fff;
  padding: 2px 10px;
}
.send-wrapp {
  background: none repeat scroll 0 0 #9DD4EC;
  float: left;
  padding: 10px;
  width: 95.5%;
}

</style>
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
			   <div class="blue_boxh"><p>My Booking Events</p></div>
			 </div>
             <div class="clear"></div>
            
             <div class="Tchai_box" style="width: auto;">
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tool_event">
                  <tr>
                    <th width="40%">Event</th>
                    <!--<th width="30%">Venue Name</th>-->
		    <th width="15%">Status options</th>
                    <th width="15%">Action options</th>
                  </tr>
                  <?php
				    $current = time();
				    //echo $current;
				    $items = 10;
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
					$target=$obj_base_path->base_path()."/bookings.php";	
					
					$obj_bookings_events->bookingEventByUser($limit,$_SESSION['ses_admin_id']);
					$obj_bookings_events_num->bookingEventByUserCount($_SESSION['ses_admin_id']);
					$num = $obj_bookings_events_num->num_rows();
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
						while($obj_bookings_events->next_record())
						{
						 //echo strtotime($obj_bookings_events->f('end'));
							//if($current <= strtotime($obj_bookings_events->f('end'))){
							//	$obj_del_saved->delSavedEvents($obj_bookings_events->f('saved_id'));
							//	continue;
							//}
							
							//echo "C";
                  ?>
                  <tr>
                    <td><?php 
		      
		      if($obj_bookings_events->f('multi_id')>0)
		        {
				if($_SESSION['langSessId']=='eng') {
	echo '<a href="'.$obj_base_path->base_path().'/eventPage/'.$obj_bookings_events->f('event_id').'/'.$obj_bookings_events->f('multi_id').'">'.htmlentities(stripslashes($obj_bookings_events->f('event_name_en'))).'</a>';}
			       else { echo '<a href="'.$obj_base_path->base_path().'/eventPage/'.$obj_bookings_events->f('event_id').'/'.$obj_bookings_events->f('multi_id').'">'.$obj_bookings_events->f('event_name_sp').'</a>';}
			
			 }
		       else {
			  	if($_SESSION['langSessId']=='eng') {
				 echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_bookings_events->f('event_id').'">'.htmlentities(stripslashes($obj_bookings_events->f('event_name_en'))).'</a>'; } else { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_bookings_events->f('event_id').'">'.$obj_bookings_events->f('event_name_sp').'</a>';}
			    }
		       
		      
		      

		     ?>
		  <br/>
		    <?php if($_SESSION['langSessId']=='eng') { echo date("D",strtotime($obj_bookings_events->f('start')))." ".date("M",strtotime($obj_bookings_events->f('start')))." ".date("d",strtotime($obj_bookings_events->f('start'))).", ".date("Y",strtotime($obj_bookings_events->f('start')))." - ".date('g:i A',strtotime($obj_bookings_events->f('start'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($obj_bookings_events->f('start')))." ".strftime("%e",strtotime($obj_bookings_events->f('start')))." de ".strftime("%b",strtotime($obj_bookings_events->f('start'))).", ".strftime("%Y",strtotime($obj_bookings_events->f('start')))." ".strftime('%l:%M%p',strtotime(strtotime($obj_bookings_events->f('start')))); }?>
		    <br/>
		    <?php if($_SESSION['langSessId']=='eng') { echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_bookings_events->f('venue_id').'">'.htmlentities(stripslashes($obj_bookings_events->f('venue_name'))).'</a> ,'.htmlentities(stripslashes($obj_bookings_events->f('city_name'))); } else { echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_bookings_events->f('venue_id').'">'.$obj_bookings_events->f('venue_name_sp').'</a> ,'.$obj_bookings_events->f('city_name_sp'); }?>
		    
		    </td>
                    <!--<td><?php// echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_bookings_events->f('venue_id').'">'.$obj_bookings_events->f('venue_name').'</a>';?></td>
		    <td><?php //echo date("Y-m-d h:i:s A",strtotime($obj_bookings_events->f('start')));?></td>-->
		    <td>
		     <?php if($obj_bookings_events->f('transaction_id')==0 || $obj_bookings_events->f('transaction_id')=="" || $obj_bookings_events->f('transaction_id')=='null')
		      {
		       $status="In process";
		      echo $status;
		      }
		      else if($obj_bookings_events->f('transaction_id')>0)
		      {
		       $status="Confirmed";
		       echo $status;
		      }?>
		    </td>
                    <td>
		     <?php if($status=="In process"){?>
		      <a href="#"><!--<img src='<?php echo $obj_base_path->base_path(); ?>/images/complete.png' width="28" height="27" border="0" alt="complete"/>/<img src='<?php echo $obj_base_path->base_path(); ?>/images/cancel.png' width="28" height="27" border="0" alt="cancel"/>-->complete/cancel</a>&nbsp;&nbsp;
		      <?php }
                    	if($status=="Confirmed"){?>
			<a href="#"><img src='<?php echo $obj_base_path->base_path(); ?>/images/transfer.jpg' width="28" height="27" border="0" alt="Transfer"/></a>&nbsp;&nbsp;
			<?php }?>
                        <!--<a onclick="open_share('<?php //echo $obj_bookings_events->f('event_id')?>','<?php //echo $obj_base_path->base_path().'/event/'.$obj_bookings_events->f('event_id')?>')">Share</a>&nbsp;&nbsp;-->
			<a onclick="all_share('<?php echo $obj_bookings_events->f('event_id')?>','<?php echo $obj_base_path->base_path().'/event/'.$obj_bookings_events->f('event_id')?>','<?php if($_SESSION['langSessId']=='eng'){echo "en_US";}else{echo "es_ES";}?>','<?php echo $j?>')"><img src='<?php echo $obj_base_path->base_path(); ?>/images/share.png' width="28" height="27" border="0" alt="<?php if($_SESSION['langSessId']=='eng'){echo "Share";}else{echo "Comparte";}?>"/></a>&nbsp;&nbsp;
			
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
			 <div class="invita-text-area"><textarea  disabled name="body" id="body_<?php echo $j?>"  rows="10" cols="50">Hi,&#13;&#160;&#160;&#160;&#160;<?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_bookings_events->f('event_name_en'))); } else { echo  $obj_bookings_events->f('event_name_sp');}?> is coming up on <?php if($_SESSION['langSessId']=='eng') { echo date("D",strtotime($obj_bookings_events->f('start')))." ".date("M",strtotime($obj_bookings_events->f('start')))." ".date("d",strtotime($obj_bookings_events->f('start'))).", ".date("Y",strtotime($obj_bookings_events->f('start')))." - ".date('g:i A',strtotime($obj_bookings_events->f('start'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($obj_bookings_events->f('start')))." ".strftime("%e",strtotime($obj_bookings_events->f('start')))." de ".strftime("%b",strtotime($obj_bookings_events->f('start'))).", ".strftime("%Y",strtotime($obj_bookings_events->f('start')))." ".strftime('%l:%M%p',strtotime($obj_bookings_events->f('start'))); } ?> at <?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_bookings_events->f('venue_name')))." in ".htmlentities(stripslashes($obj_bookings_events->f('city_name'))); } else { echo $obj_bookings_events->f('venue_name_sp')." in ".$obj_bookings_events->f('city_name_sp'); }?> </textarea></div>
			</div>
			   <div class="type-wrapp">
			    <div class="type-lable"><?php if($_SESSION['langSessId']=='eng') { echo "Type your message:" ;}else {echo "Escribe su mensaje:" ;}?></div>
			    <div class="type-text-area"><textarea name="message" id="message_<?php echo $j?>"  rows="10" cols="50" class="message"></textarea></div>
			   </div>
			   <div class="send-wrapp"><div id="sent_mail<?php echo $j?>"></div>
			   <div><input type="button" name="save" value="<?php if($_SESSION['langSessId']=='eng') { echo "Send" ;}else {echo "Enviar" ;}?>" onclick="multiMail(<?php echo $j?>)" class="btn2_sudip"/></div></div>
			   </div>
		    <span id="loader<?php echo $j?>" style="display:none;"><img src='<?php echo $obj_base_path->base_path(); ?>/images/total-loader.gif'></span>
			  
	                  </div>
	   
	    <script type="text/javascript">
					$(document).ready(function() {
					       $("#feature<?php echo $j?>").fancybox({
						/*'afterClose': function() {
						  alert('a');
						},
						beforeLoad : function(){
						  alert('a');
						 },*/
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
		    <?php $url=$obj_base_path->base_path().'/event/'.$obj_bookings_events->f('event_id') ?>
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
			 js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=149448255219243";
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
                  <tr>
                    <td colspan="4"><?php $p->show();?></td>
                  </tr>
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

</body>
</html>
