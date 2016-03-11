<?php    
//error_reporting(-1);
$objsideBar=new admin;
$_SESSION['ses_user_id'];
//$objsideBar->adminBillingDetails($_SESSION['ses_user_id']);
//$objsideBar->next_record();
//$num = $objsideBar->num_rows();
?>   
    <div class="coupon_leftcol">     
      
        <ul>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/dashboard">My Account <br /><span>settings, users & payment info</span></a></li>
       <?php /*?> <?php if($num){ ?>  
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/charge_payment">Charged Payment<br /><span>seller payment info</span></a></li>
         <?php } ?> <?php */?>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events">Events      <br /><span>View/Edit Events & Venues</span></a></li>
          <!--<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/customize">Customize  <br /><span>Questions & Templates</span></a></li>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/coupons">Coupons  <br /><span>Discount, Presale & Comps</span></a></li>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/customers">Customers <br /><span>Lookup, Import & Export Data</span></a></li>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/promote">Promotions  <br /><span>Banner, Email Outbox & Social</span></a></li>
          <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/reports">Reports<br /><span>Sales, Traffic & Custom</span></a></li>
		  <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/checkin-events">Event Check-In <br />Event Update & Status</a></li>-->
           
        </ul>
      
    </div>






										 			                             	
