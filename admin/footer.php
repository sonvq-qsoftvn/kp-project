<?php
error_reporting(0);
$obj=new user;
?>
<footer id="footerbg">
<div class="footer">
	<div class="footer_in_box">
	<div class="footer_link">
          <h2>Ticket Holders</h2>
          <ul>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/my-account">Ticket Holders</a></li>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/my-account">My Tickets</a></li>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/edit">Edit Account</a></li>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/edit">Update Password</a></li>
			<?php if($_SESSION['ses_user_userid']==""){ ?>
			<li><a href="<?php echo $obj_base_path->base_path(); ?>/login">Login</a></li>
			<?php }else{?>
			<li><a href="<?php echo $obj_base_path->base_path(); ?>/logout">Logout</a></li>
			<?php }?>
          </ul>
    </div>
		
		<div class="footer_link3">
          <h2>Ticketing Solutions</h2>		  
          <ul>
		  <?php if($_SESSION['ses_user_id']==""){ ?>
			<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/">Admin Login</a></li>
			<?php }else{?>
			<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/logout">Admin Logout</a></li>
			<?php }?>
            <!--<li><a href="#">Admin Login</a></li>-->
            <li><a href="#">Ticket Pricing</a></li>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/register">Hosting an Event?</a></li>            
          </ul>
        </div>
		  <div class="footer_link4" >
          <h2>Connect</h2>		  
          <ul>
           <li><a href="http://www.facebook.com/tickethype" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/social_01.png" alt="" width="20" height="20" /> Facebook</a></li>
           <li><a href="http://twitter.com/tickethype" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/social_02.png" alt="" width="20" height="20" /> Twitter</a></li>
           <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/social_03.png" alt="" width="20" height="20" /> You Tube</li>        
	       <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/social_04.png" alt="" width="20" height="20" /> Rss</li>		
          </ul>
		  </div>
        <div class="clear"></div>
	</li>	
     </div>
      <div class="clear"></div>
      <div class="footer" style="padding-top:44px;">	 
         Use of TicketHype is subject to our Terms of Service. Copyright © 2011 TicketHype, Inc. All Rights Reserved.
     </div>      		
  </footer>