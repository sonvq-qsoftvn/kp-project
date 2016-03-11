<?php
//ajax event price level
include('../include/admin_inc.php');

$obj_list_price=new admin;
$obj_price_level=new admin;
$obj_price_level_delete=new admin;
//post value
$price_level_id=$_POST['price_level_id'];

if($_POST['price_level_id']){
	$obj_price_level->event_price_level_by_id($price_level_id);
	if($obj_price_level->num_rows()>0){
	
		$obj_price_level_delete->delete_event_price_level_by_id($price_level_id);
	
	}
}
?>
<table id="price_level_div" align="center" width="700" border="0" cellspacing="0" cellpadding="0" class="upcoming_bg" style="width:720px;">
    <tr>
      <th width="7%" style="padding: 0 10px;">ID</th>
      <th width="21%">Name</th>
      <th width="29%">Price</th>
      <th width="12%">Limit</th>
      <th width="21%">Manage</th>
      <th width="10%" colspan="2">&nbsp;</th>
    </tr>
    <?php
    //list price
    $obj_list_price->event_price_list($_POST['event_id']);
    
    while($obj_list_price->next_record())
    {		
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#edit_price_level<?php echo $obj_list_price->f('price_level_id'); ?>").fancybox();			
    });
    </script>
    <tr>         
      <td width="7%" style="padding: 0 10px;"><?php echo $obj_list_price->f('price_level_id'); ?></td>
      <td width="21%"><strong><?php echo $obj_list_price->f('price_name'); ?></strong></td>
      <td width="29%"> <?php echo $obj_list_price->f('price_amount'); ?></td>
      <td width="12%">0 / <?php echo $obj_list_price->f('ticket_limit'); ?></td>
      <td width="9%"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /> <a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_price_level?event_id=<?=$_REQUEST['event_id']?>&price_level_id=<?php echo $obj_list_price->f('price_level_id'); ?>" id="edit_price_level<?php echo $obj_list_price->f('price_level_id'); ?>">Edit</a></td>
      <td width="9%"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> <a href="javascript:void(0);" id="delete_price_level" onclick="delete_price_level('<?php echo $obj_list_price->f('price_level_id'); ?>','<?php echo $_POST['event_id']; ?>');" >Delete</a></td>
      <td width="13%">&nbsp;
      <?php /*?><?php if($obj_list_price->f('event_launch')==1) { ?>
      <img src="<?php echo $obj_base_path->base_path(); ?>/images/green_icon.png" alt="" width="28" height="22" />
      <?php }else {?>
      <img src="<?php echo $obj_base_path->base_path(); ?>/images/yellow_icon.png" alt="" width="28" height="22" />
      <?php }?>	<?php */?>	  
      </td>
    </tr>
    <?php 
    }
    ?>
       
 </table>