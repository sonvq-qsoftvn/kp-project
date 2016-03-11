<?php
include('../include/admin_inc.php');

//create object
$objlist = new admin;
$objlist_num = new admin;
$obj_delete = new admin;
$obj_change = new admin;
$obj_venuestate = new admin;
$obj_change = new admin;
$obj_performerstate = new admin;


//===============CODE FOR CHANGE STATUS===================//
if(isset($_GET['status']))	
{
	$obj_change->changeVenueStatus($_GET['id'],$_GET['status']);
	$msg = "Performer status changed successfully";
}


?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<?php
// Serach 
$items = 20;
$page = 1;
		
if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
{
	$limit = " LIMIT ".(($page-1)*$items).",$items";
	$i = $items*($page-1)+1;
}
else
{
	$limit = " LIMIT $items";
	$i = 1;
}

$target=$obj_base_path->base_path()."/admin/list_performers.php";	
if(isset($_POST['listPerformer']) && $_POST['listPerformer'] == '1')	
{
	$performer_state = $_POST['performer_state'];
	$performer_country = $_POST['county'];
	$performer_city = $_POST['city'];
	
	$objlist->allPerformerList($limit,$performer_state,$performer_country,$performer_city);
	$objlist_num->allPerformerListCount($performer_state,$performer_country,$performer_city);
?>
<script type="text/javascript">
$(document).ready(function(){
getCounty('<?php echo $_POST['performer_state'];?>','<?php echo $_POST['county'];?>');
getCity('<?php echo $_POST['county'];?>','<?php echo $_POST['city'];?>');
});
</script>
<?php	
}
else{
		
//event list
$objlist->allPerformerList($limit);
$objlist_num->allPerformerListCount();
}

$num = $objlist_num->num_rows();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Kcpasa - Admin Performer List</title>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script language="javascript">
function del(eID)
{
	if(confirm("Are you sure you want to delete this performer?"))
	{
		location.href="<?php echo $obj_base_path->base_path(); ?>/admin/del/"+eID+"/performer";
	}
	
}
</script>
<script language="javascript" type="text/javascript">
function getCounty(stateid,performer_country)
{
     $('#div_city_display').html('<select name="performer_city" class="selectbg12"><option value="">City</option></select>');
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "state_id="+stateid+"&county="+performer_country;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_get_county_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid,performer_city)
{
     $('#div_venue_display').html('<select name="venue" class="selectbg12"><option value="">Venue</option></select>');
	 data = "county_id="+countyid+"&city_list="+performer_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_get_city_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}

</script>
<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>

<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">
     <div class="clear"></div>
     <div class="container">
        <?php include("admin_header_menu.php");?>
		 <div class="clear"></div>		
		<!--start body-->
		 <div id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <div class="blue_box1">
           		<div class="blue_box10"><p>My Performers</p></div>
           			<?php include("admin_menu/performer_menu.php");?>
			   </div> 
			 <div class="clear"></div>
            </div>	
		 </div>
		 </div>
         <form method="post" action="" enctype="multipart/form-data" name="listing" id="listing">
         <input type="hidden" name="listPerformer" id="listPerformer" value="1" /> 
        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail">
            <tr>
                <td width="36%">
                <select name="performer_state" id="performer_state" class="selectbg12" onChange="getCounty(this.value,'');">
                    <option value="">State</option>
                    <?php
                  $obj_performerstate->getVenueState();
                  while($obj_performerstate->next_record())
                  {
                  ?>
                    <option value="<?php echo $obj_performerstate->f('id');?>" <?php if($performer_state==$obj_performerstate->f('id')){?> selected="selected"<?php }?>>
                    <?php echo $obj_performerstate->f('state_name');?></option>
                    <?php
                  }
                  ?>
              </select>
      			</td>
                <td width="35%"><div id="div_county_display">
                      <select name="performer_country" class="selectbg12">
                      <option value="">County</option>
                      </select>
		  		</div></td>
                <td width="4%" >
                <div id="div_city_display">
                  <select name="performer_city" class="selectbg12">
                  <option value="">City</option>
                  </select>
		  		</div></td>
                
                <td width="25%"> <div class="input_box" style="margin: 0px 0 2px 0; float: right;">
                <input type="image" src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png"  style="border:0px;"  />
                	<!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/search_icon3.png" border="0" onclick="showCal()" style="vertical-align: top;" />--></div></td>
            </tr>
         </table>
          <?php
		 if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");		
		?>	
			<div style="width:160px; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
			<?php
			}
		 ?>
         </form>
		
	  <div class="myevent_box">
	 	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000"><strong><?php if($_SESSION['per_del_msg']){ echo $_SESSION['per_del_msg']; $_SESSION['per_del_msg'] = ''; } ?></strong></div>
	    <div class="myevent_left" style="width:1000px;">
          <div class="guide_box2">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
                <tr>
                    <td width="17%" class="top_txt">Performer</td>
                    <td width="16%" class="top_txt">Address</td>
                    <td width="13%" class="top_txt">City</td>
                    <td width="11%" class="top_txt">County</td>
                    <td width="12%" class="top_txt">State</td>
                    <td width="12%" class="top_txt">Status</td>
                    <td width="19%" class="top_txt">Manage</td>
                </tr>
                <?php
                
                $loop=1;
                if($num>0)
                {
                    $p = new pagination;
                    $p->Items($num);
                    $p->limit($items);
                    $p->target($target);
                    $p->currentPage($page);
                    $p->calculate();
                    $p->changeClass("pagination");			
                    while($row = $objlist->next_record())
                    {
                        
            ?>
          <tr>
            <td><?php echo stripslashes($objlist->f('performer_name_en'));?></td>
            <td><?php echo stripslashes($objlist->f('performer_short_add_en'));?></td>
            <td><?php echo stripslashes($objlist->f('city_name'));?></td>
            <td style="padding: 5px 0;"><?php echo stripslashes($objlist->f('county_name'));?></td>
            <td><?php echo $objlist->f('state_name');?></td>
            
            <td style="text-align: left; padding: 5px 0;">
            <?php if($objlist->f('privacy')==1)  echo "Public"; else echo "Private";?> /   <?php if($objlist->f('activate_status')==1 || $objlist->f('activate_status')==0) echo "Saved"; else if($objlist->f('activate_status')==2) echo "Published";?> 
            </td>
            
            <td style="padding: 5px;">
                <span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-performer/<?php echo $objlist->f('performer_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" title="Edit Venue" /></a></span>
                <span style="margin:0;font-weight:bold;">
                    <a href="<?php echo $obj_base_path->base_path(); ?>/admin/duplicate_performer/<?php echo $objlist->f('performer_id');?>">Duplicate</a>
                </span>
                <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objlist->f('performer_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
                <span style="margin:0;"><a href="#" style="color:#000;">Preview</a></span>
            </td>
          </tr>
      <?php } ?>
         <td colspan="7" align="left" style="padding-right:0px;"><div style="width:160px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
             <?php
                }
                else
                {
            ?>
            <tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Perofrmer Found</font></td></tr>
            <?php
                }
            ?>
        </table>
          </div>	
          <div class="clear"></div>
	  	</div>
	  </div>
		<div class="clear"></div>	
	</div>
    <div class="clear"></div>
</div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>