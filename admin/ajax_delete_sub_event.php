<?php
session_start();
//ajax event price level
include('../include/admin_inc.php');

$objlist=new event;
$objlist_num = new event;

$event_id = $_REQUEST['sub_event_id'];
$parent_id = $_REQUEST['parent_id'];

$objlist->delete_sub_event($event_id);
$objlist->delete_sub_event_type($event_id);
$objlist->delete_sub_event_category($event_id);
$objlist->delete_sub_event_ticket($event_id);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2" id="div_subevent_list">
<tr>
	<td width="18%" class="top_txt" style="text-align:left">Event</td>
	<td width="15%" class="top_txt" style="text-align:left">City</td>
	<td width="15%" class="top_txt" style="text-align:left">Venue</td>
	<td width="16%" class="top_txt" style="text-align:left">Start Date</td>
	<td width="16%" class="top_txt" style="text-align:left">End Date</td>
	<td width="10%" class="top_txt" style="text-align:left">Edit</td>
	<td width="10%" class="top_txt" style="text-align:left">Delete</td>
</tr>
<?php
$objlist->allSubEventList($parent_id); 
$objlist_num->allSubEventListCount($parent_id);
$num = $objlist_num->num_rows(); 
$loop=1;
if($num>0)
{
	while($row = $objlist->next_record())
	{
?>	
   <tr> 
        <td width="18%"><?php echo stripslashes($objlist->f('event_name_en'));?></td>
		<td width="15%"><?php echo $objlist->f('city_name');?></td>
		<td width="18%"><?php echo $objlist->f('venue_name');?></td>
		<td width="12%"><?php echo $objlist->f('event_start_date_time');?></td>
		<td width="9%"><?php echo $objlist->f('event_end_date_time');?></td>
		<td width="10%"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_sub_events_edit.php?sub_event_id=<?php echo $objlist->f('event_id');?>&event_id=<?php echo $parent_id;?>&mode=1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></td>
		<td width="18%"><a href="javascript:void(0);" onclick="deleteSubEvent('<?php echo $objlist->f('event_id')?>','<?php echo $parent_id;?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></td>
	</tr>
	    <?php
		}
	}
	else
	{
	?>
	<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Subevent Found</font></td></tr>
	<?php
	}
	?>
</table>
