<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-3];
$event_id= $allUrlSet[count($allUrlSet)-1];
//echo "h=".$page_set;
?>
<div class="blue_boxr">
  <ul>
   <!--<li><a href="<?php //echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/<?php // echo $event_id?>" <?php// if($page_set=="add-gallery" || basename($_SERVER['PHP_SELF'])=="edit_gallery.php") {?> class="here" <?php// } ?>>Add media</a></li>-->
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/promotion-list/event/<?php echo $event_id?>" <?php if($page_set=="promotion-list") {?> class="here" <?php } ?>>List/Select</a></li>
   <!--<li><a href="#">Promote</a></li>-->	
   <li><a href="#">Bookings</a></li>
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-final-report">Reports</a></li>	
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/export.php">Export</a></li>						   
  </ul>
</div>