<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];

$event_id= $allUrlSet[count($allUrlSet)-1];
//echo "h=".$page_set;
?>
<div class="blue_boxr">
  <ul>
   <!--<li><a href="<?php //echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/<?php // echo $event_id?>" <?php// if($page_set=="add-gallery" || basename($_SERVER['PHP_SELF'])=="edit_gallery.php") {?> class="here" <?php// } ?>>Add media</a></li>-->
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/<?php echo $page_set ?>" <?php if($page_set!="") {?> class="here" <?php } ?>>Create/Edit</a></li>
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/ad-list/">List/Select</a></li>	
   						   
  </ul>
</div>