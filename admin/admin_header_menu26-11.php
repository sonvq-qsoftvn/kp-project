<?php
	//print_r($_SESSION);
	$obj_admin = new admin;
	
	$obj_admin->getAdminById($_SESSION['ses_user_id']);
	$obj_admin->next_record();
?>

<div id="admin_nav">
    <div class="admin_nav">
    <div class="admin_nav_left">
   <ul>
   <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/admin_icon.gif" alt="" width="49" height="49"></a></li>
   <li><?php echo $obj_admin->f('fname')." ".$obj_admin->f('lname');?><br/><?php echo $obj_admin->f('city_name');?>, <?php echo $obj_admin->f('county_name');?>, <?php echo $obj_admin->f('printable_name');?><br/> 
   <?php
   if($obj_admin->f('account_type') == 0){
   		echo "Personal";
   }
   elseif($obj_admin->f('account_type') == 1){
   		echo "Professional";
   }
   elseif($obj_admin->f('account_type') == 2){
   		echo "Superadmin";
   }
   
   ?>
   </li>
    </ul> 
    </div>          	             
   </div>
  <div class="admin_nav_right">
  <ul>
  <li style="width: 120px;">
  <a href="javascript:void(0);" id="show_help" style="display:none;"> Show Guide</a></li>
  <li style="width: 80px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/help_icon.png" alt="" width="19" height="19"><a href="#">help</a></li>
  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/logout.png" alt="" width="28" height="19"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/logout">logout</a></li>
  </ul>
  </div>
</div>