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
<li>
<a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-meta" <?php if($page_set=="add-meta" || $page_set1=="edit-meta"  ) {?> class="here" <?php } ?>>Create/Edit</a>
</li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/meta-list/" <?php if($page_set1=="meta-list" ) {?> class="here" <?php } ?>>List/Select</a></li>	
</ul>
</div>
