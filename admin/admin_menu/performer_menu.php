<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];  
//echo basename($_SERVER['PHP_SELF']);
?>
	<div class="blue_boxr">
      <ul>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/addperformer" <?php if(basename($_SERVER['PHP_SELF'])=="edit_addperformer.php"  || basename($_SERVER['PHP_SELF'])=="addperformer.php") {?> class="here" <?php } ?>>Create/Edit</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_performers.php" <?php if(basename($_SERVER['PHP_SELF'])=="list_performers.php") {?> class="here" <?php } ?>>List/Select</a></li>
       <li><a href="#">Promote</a></li>	
       <li><a href="#">Gallery</a></li>
       <li><a href="#">Bookings</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/report">Reports</a></li>						   
     </ul>
   </div>