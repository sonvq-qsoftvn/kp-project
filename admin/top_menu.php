<!-- <div class="header_right">
 <div class="top_menu">-->
<?php
	//echo $_SESSION['ses_page_name'];

 if ($_SESSION['ses_page_name']=='dashboard.php' || $_SESSION['ses_page_name']=='user.php'  || $_SESSION['ses_page_name']=='seller.php'   || $_SESSION['ses_page_name']=='users.php'  || $_SESSION['ses_page_name']=='payment-settings.php'){ ?>

 <div class="blue_box1">
			   <div class="blue_boxh"><p>WELCOME</p></div>
			   <div class="blue_boxr">
			   <ul>
			   <?php $pagename=basename($_SERVER['PHP_SELF']);?>
			   
			 <li style="width:80px; padding:0 0 0 0;">
			 <a <?php if($pagename=="dashboard.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/dashboard"><span>Dashboard ></span></a>
			 </li>
			 
            <li style="padding-right:0px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="0" height="22" /></li>
            <li class="link" style="width:100px; padding:0 0 0 0;"><a <?php if($pagename=="user.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/user"><span>User Settings ></span></a></li>
			
            <li style="padding-right:0px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="0" height="2" /></li>
            <li class="link" style="width:145px; padding:0 0 0 0;"><a <?php if($pagename=="seller.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/seller"><span>Organization Settings ></span></a></li>
			
			<li style="padding-right:0px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="0" height="2" /></li>
            <li class="link" style="width:100px; padding:0 0 0 0;"><a <?php if($pagename=="users.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/users"><span>Manage Users ></span></a></li>
			
            <li style="padding-right:0px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="2" /></li>
            <li class="link" style="width:100px; padding:0 0 0 0;"><a <?php if($pagename=="payment-settings.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/payment-settings"><span>Payment Info ></span></a></li>
			
            <li style="padding-right:0px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="22" /></li>
			   </ul>
			   </div>
			   </div> 
<?php } 
 elseif ($_SESSION['ses_page_name']=='events.php' || $_SESSION['ses_page_name']=='event.php'  || $_SESSION['ses_page_name']=='venues.php' ||  $_SESSION['ses_page_name']=='venue.php'  ||  $_SESSION['ses_page_name']=='event_ads.php') { ?>

	
	
	<div class="blue_box1">
			   <div class="blue_boxh"><p>EVENTS</p></div>
			   <div class="blue_boxr">
			   <ul>
			   <?php $pagename=basename($_SERVER['PHP_SELF']);?>
			 <li style="width:100px;">
			 <a <?php if($pagename=="events.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/events"><span>All Events ></span></a>
			 </li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="22" /></li>
            <li class="link" style="width:70px;"><a <?php if($pagename=="venues.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/venues"><span>Venues ></span></a></li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="2" /></li>
            <li class="link" style="width:80px;"><a <?php if($pagename=="event.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/event"><span>Add Event ></span></a></li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="2" /></li>
            <li class="link" style="width:80px;"><a <?php if($pagename=="venue.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/venue"><span>Add Venue ></span></a></li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="22" /></li>
			   </ul>
			   </div>
			   </div>
	
	
<?php } 
 elseif ($_SESSION['ses_page_name']=='customize.php' || $_SESSION['ses_page_name']=='scheme.php' || $_SESSION['ses_page_name']=='schemes.php' || $_SESSION['ses_page_name']=='questions.php' || $_SESSION['ses_page_name']=='question.php'){ ?>
<!--<a href="#">Customize</a>-->
<!--</div>-->
<!--=======================-->

<div class="blue_box1" style="float: none; margin: 0 auto;">
<div class="blue_boxh"><p>customize</p></div>
<div class="blue_boxr">
<ul>
<?php $pagename=basename($_SERVER['PHP_SELF']);?>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/questions" <?php if($pagename=="questions.php") {?>class="here"<?php }?>>questions ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/question" <?php if($pagename=="question.php") {?>class="here"<?php }?>>create a question ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/schemes" <?php if($pagename=="schemes.php") {?>class="here"<?php }?>>templates ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/scheme" <?php if($pagename=="scheme.php") {?>class="here"<?php }?>>create a template ></a></li>
<li style="width: auto;"><a href="javascript:void(0);" id="top_assign_event">assign to events ></a></li>
</ul>
</div>
</div>
<!--===================-->
	
	<!--</div>-->
<?php }
elseif ($_SESSION['ses_page_name']=='checkin-events.php') { ?>

	
	
	<div class="blue_box1">
			   <div class="blue_boxh"><p>EVENTS CHECKIN</p></div>
			   <div class="blue_boxr">
			   <ul>
			  
			 <li style="width:100px;">&nbsp;</li>
            </ul>
			   </div>
			   </div>
	
	
<?php } elseif ($_SESSION['ses_page_name']=='reports.php' || $_SESSION['ses_page_name']=='sale.php' ||  $_SESSION['ses_page_name']=='summary-exports.php'  || $_SESSION['ses_page_name']=='payments.php'  ){ ?>
<!--<a href="#">Reports</a>-->
<!--</div>-->
<!--====================-->
<div class="blue_box1" style="float: none; margin: 0 auto;">
<div class="blue_boxh"><p>reports</p></div>
<div class="blue_boxr">
<ul>
<?php $pagename=basename($_SERVER['PHP_SELF']);?>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/reports" <?php if($pagename=="reports.php") {?>class="here"<?php }?>>report overview ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/reports/builder/"  <?php if($pagename=="builder.php") {?>class="here"<?php }?>>report builder ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/payments" <?php if($pagename=="payments.php") {?>class="here"<?php }?>>settlements ></a></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/reports/summary-exports/" <?php if($pagename=="summary-exports.php") {?>class="here"<?php }?>>summary exports ></a></li>
</ul>
</div>
</div>
<!--===================-->		
	<!--</div>-->
	<?php }elseif ($_SESSION['ses_page_name']=='coupons.php' || $_SESSION['ses_page_name']=='coupon.php'){ ?>

		 <div class="blue_box1">
			   <div class="blue_boxh"><p>Coupons</p></div>
						   <div class="blue_boxr">
						  <ul>
						  <?php $pagename=basename($_SERVER['PHP_SELF']);?>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/questions">Questions > </a></li>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/question">Create a Question > </a></li>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/schemes">Templates > </a></li>
						   <li style="width: auto;"><a <?php if($pagename=="coupon.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/coupon">Create a Coupon > </a></li>
						  </ul>
						   </div>
			   </div>
       
	<?php }elseif ($_SESSION['ses_page_name']=='scan.php'){ ?>
              
			
			  <div class="blue_box1">
			   
						   <div class="blue_boxr" style="float:left">
						   <ul>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events">All Events > </a></li>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/venues">Venues > </a></li>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event">Add Event > </a></li>
						   <li style="width: auto;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/venue">Add Venue > </a></li>
						   <li style="width: auto;"><a href="#">payment info ></a></li>
						   </ul>
						   </div>
			   </div>	
			
			  
			  
	<?php }elseif ($_SESSION['ses_page_name']=='customers.php' || $_SESSION['ses_page_name']=='customer.php' ){ ?>
<!--<a href="#">Customers</a>-->

        
<div class="blue_box1">
<div class="blue_boxh"><p>Customers</p></div>
<div class="blue_boxr">
<ul>
<?php $pagename=basename($_SERVER['PHP_SELF']);?>
<li style="width:130px;"><a <?php if($pagename=="customers.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/customers"><span>Customers ></span></a></li>

<li class="link" style="width:130px;"><a <?php if($pagename=="customer.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/customer/tickets"><span>Tickets ></span></a></li>

<li class="link" style="width:130px;"><a <?php if($pagename=="schemes.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/schemes"><span>Templates ></span></a></li>

<li class="link" style="width:130px;"><a <?php if($pagename=="importcsv.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/customer/importcsv"><span>Import Customers ></span></a></li>

</ul>
</div>
</div>
			   
			   
			   
	<!--</div>-->
	<?php }elseif ($_SESSION['ses_page_name']=='promote.php' || $_SESSION['ses_page_name']=='social.php'  || $_SESSION['ses_page_name']=='widget.php'  || $_SESSION['ses_page_name']=='newsletters.php' || $_SESSION['ses_page_name']=='draft.php' || $_SESSION['ses_page_name']=='emailtemplate.php'){ ?>
<!--<a href="#">Promotion</a>
</div>-->
        
			<div class="blue_box1">
			   <div class="blue_boxh"><p>Promotion</p></div>
			   <div class="blue_boxr">
			   <ul>
			   <?php $pagename=basename($_SERVER['PHP_SELF']);?>
                <li style="width:120x;"><a <?php if($pagename=="promote.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/promote/newsletters"><span>Email Outbox ></span></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="22" /></li>
                <li class="link" style="width:120px;"><a <?php if($pagename=="ticket_pdf.php") {?>class="here"<?php }?> href="<?php echo $obj_base_path->base_path(); ?>/admin/promote/social"><span>Social Settings ></span></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="2" /></li>
                <li class="link" style="width:120px;"><a <?php if($pagename=="importcsv.php") {?>class="here"<?php }?> href=""><span>Tracking Tags ></span></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="4" height="22" /></li>
			   </ul>
			   </div>
			   </div>	
	<!--</div>-->
	<?php }?>
