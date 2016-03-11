<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];  
//echo basename($_SERVER['PHP_SELF']);
?>
	<div class="blue_boxr">
      <ul>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/addvenue" <?php if(basename($_SERVER['PHP_SELF'])=="editvenue.php"  || basename($_SERVER['PHP_SELF'])=="addvenue.php") {?> class="here" <?php } ?>>Create/Edit</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_venues.php" <?php if(basename($_SERVER['PHP_SELF'])=="list_venues.php") {?> class="here" <?php } ?>>List/Select</a></li>
       <!--<li><a href="#">Promote</a></li>	
       <li><a href="#">Gallery</a></li>-->
       <li><a href="#">Bookings</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-final-report">Reports</a></li>						   
     </ul>
   </div>