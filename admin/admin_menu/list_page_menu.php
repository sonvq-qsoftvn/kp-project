<?php
$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet)-1];  
//echo basename($_SERVER['PHP_SELF']);
?>
	<div class="blue_boxr">
      <ul>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_page" <?php if(basename($_SERVER['PHP_SELF'])=="add_page.php"  || basename($_SERVER['PHP_SELF'])=="edit_page.php") {?> class="here" <?php } ?>>Create/Edit Page</a></li>
       <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_page" <?php if(basename($_SERVER['PHP_SELF'])=="list_page.php") {?> class="here" <?php } ?>>List Page</a></li>

     </ul>
   </div>