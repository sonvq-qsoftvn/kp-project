<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];
?>
<div class="blue_boxr">
  <ul>
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/events" <?php if($page_set=="events" || basename($_SERVER['PHP_SELF'])=="edit_event.php") {?> class="here" <?php } ?>>Create/Edit</a></li>
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list" <?php if($page_set=="event-list") {?> class="here" <?php } ?>>List/Select</a></li>
   <li><a href="#">Promote</a></li>	
   <li><a href="#">Gallery</a></li>	
   <li><a href="#">Bookings</a></li>
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/report">Reports</a></li>						   
  </ul>
</div>