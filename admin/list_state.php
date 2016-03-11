<?php
// home page
session_start();

// List of page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	$objlist = new merchant_admin;
	$objlist_num = new merchant_admin;
	$obj_delete = new merchant_admin;
	
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "delete")	
{
	$obj_delete->deleteState($_GET['id']);
	$_SESSION['msg'] = "State deleted successfully";
	header("Location:".$obj_base_path->base_path()."/admin/list_state");
	exit;
}


	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Sate</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<!-- jQuery lightBox plugin -->



<script type="text/javascript">

function del(eID)
{
	if(confirm("Are you sure you want to delete this State?"))
	{
		location.href="<?php echo $obj_base_path->base_path(); ?>/admin/state-list/delete/"+eID;
	}
	
}
</script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
</head>

<body class="body1">
<?php include("admin_header.php"); ?>
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
           <div class="blue_box10"><p>States</p></div>
           <?php
				$path_parts = pathinfo(__FILE__);
			?>
				<div class="blue_boxr">
				  <ul>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add_state">Create/Edit State</a></li>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_state" <?php if($path_parts['filename']=="list_state") {?> class="here" <?php } ?>>List State</a></li>
			
				 </ul>
			   </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
        <strong><?php echo "sss".$msg;?></strong></div>	
	<?php
	}?>	
		
    
    <div class="myevent_box">

	<form action="#">       
        <!--[if !IE]>start table_wrapper<![endif]-->
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
		    <div class="guide_box2">
            <table cellpadding="0" cellspacing="0" width="100%" border="0"  class="id_detail2">               
                
                <tr>
                <?php
                    if($_REQUEST['err']==1)
                    {
                ?>
                <td colspan="7" style="font: bold 13px/30px Arial,Helvetica, sans-serif; padding: 2px 0; color:#000; background: #ccc; text-align: center;">Successfully Deleted</td>
                <?php
                    }
                ?>
                <?php
                    if($_REQUEST['err']==2)
                    {
                ?>
                <td colspan="7" style="font: bold 13px/30px Arial, Helvetica, sans-serif; padding: 2px 0; text-align: center; color:#000; background: #ccc;">Successfully edited</strong></font>&nbsp;</td>
                <?php
                    }
                ?>
                <?php
                    if($_REQUEST['err']==3)
                    {
                ?>
                <td width="18%" colspan="7" style="font: bold 13px/30px Arial, Helvetica, sans-serif; text-align:center; padding: 2px 0; color:#000; background: #ccc;">Successfully added</td>
                <?php
                    }
                ?>
            </tr>
                
                <tr>
                    <th  class="top_txt">No.</th>
                    <th  class="top_txt">State Name EN</th>
                    <th  class="top_txt">State Name SP</th>
                    <th  class="top_txt">Operation</th>
                </tr>
                <?php
					$items = 25;
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
					
					$objlist->statelist($limit);
					$objlist_num->statelist_num();
					$num = $objlist_num->num_rows();
					//echo $num;
					if($num>0)
					{
					$p = new pagination;
					$p->Items($num);
					$p->limit($items);
					$p->target($target);
					$p->currentPage($page);
					$p->calculate();
					$p->changeClass("pagination");
					$cnt=1;				
					while($row = $objlist->next_record())
					{				
					?>
					<tr>         
					<td width="8%" style="padding: 0 10px;"><?php echo $cnt;;?></td>
					<td width="23%"><?php echo $objlist->f('state_name');?></td>
					<td width="23%"><?php echo $objlist->f('state_name_sp');?></td>
					
					<td width="11%">
                    	<a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_state/<?php echo $objlist->f('id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />Edit</a>
                    	<a href="javascript:void(0);" onClick="del('<?php echo $objlist->f('id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" />Delete</a>
                    </td>
					</tr>
					
					<?php $cnt++; } if($num>25){?>
					<tr><td colspan="6" align="center" ><?php $p->show();?></td></tr>
					<?php
					}
					}
					else
					{
					?>
					<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
					<?php
					}
					?>
                
            </table>
            </div>
			</div>
        </div>
        <!--[if !IE]>end table_wrapper<![endif]-->
        
        <!--[if !IE]>start table menu<![endif]-->
        <!--[if !IE]>end table menu<![endif]-->
       
    </form>
    <div class="clear"></div>
    </div>
    
    
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

</body>
</html>
