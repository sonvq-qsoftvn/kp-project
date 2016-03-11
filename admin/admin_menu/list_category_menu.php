<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];  
//echo basename($_SERVER['PHP_SELF']);
?>
	<div class="blue_boxr">
      <ul>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_category" <?php if(basename($_SERVER['PHP_SELF'])=="add_category.php"  || basename($_SERVER['PHP_SELF'])=="add_category.php") {?> class="here" <?php } ?>>Create Category</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_category" <?php if(basename($_SERVER['PHP_SELF'])=="list_category.php") {?> class="here" <?php } ?>>List Category</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_subcategory" <?php if(basename($_SERVER['PHP_SELF'])=="list_subcategory.php") {?> class="here" <?php } ?>>List Sub-Category</a></li>

     </ul>
   </div>