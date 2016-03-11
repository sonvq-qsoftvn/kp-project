<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];
$page_set1 = $allUrlSet[count($allUrlSet)-2];

 $page_set = $allUrlSet[count($allUrlSet)-1];
 $page_set1 = $allUrlSet[count($allUrlSet)-2];

$event_id= $allUrlSet[count($allUrlSet)-1];
//echo "h=".$page_set1;
?>
<div class="blue_boxr">
  <ul>
   <!--<li><a href="<?php //echo $obj_base_path->base_path(); ?>/admin/add-gallery/event/<?php // echo $event_id?>" <?php// if($page_set=="add-gallery" || basename($_SERVER['PHP_SELF'])=="edit_gallery.php") {?> class="here" <?php// } ?>>Add media</a></li>-->
   <li>
       
       <a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-ad" <?php if($page_set=="add-ad" || $page_set1=="edit-ad"  ) {?> class="here" <?php } ?>>
           
           Create/Edit</a>
   
   </li>
   
   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/ad-list/" <?php if($page_set1=="ad-list" || $page_set1=="ad-list.php") {?> class="here" <?php } ?>>List/Select</a></li>	
   						   
  </ul>
</div>