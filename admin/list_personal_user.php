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
	
	//echo $_GET['id'];
	//echo $_GET['emailid'];
	//exit;
	$obj_delete->deleteUser($_GET['id'],$_GET['emailid']);
	$_SESSION['msg'] = "User deleted successfully";
	header("Location:".$obj_base_path->base_path()."/admin/list_personal_user");
	exit;
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Personal User</title>
	
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

function del(eID,emailId)
{
	if(confirm("Are you sure you want to delete this User?"))
	{
		location.href="<?php echo $obj_base_path->base_path(); ?>/admin/list_personal_user/delete/"+eID+"/"+emailId;
	}
	
}
</script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<?php include("../include/analyticstracking.php")?>
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
           <div class="blue_box10"><p>Users</p></div>
           <?php
				$path_parts = pathinfo(__FILE__);
			?>
				<div class="blue_boxr">
				  <ul>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_personal_user" class="here">Personal users</a></li>
				   <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_profession_user">Professional users</a></li>
			
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
                    <!--<th  class="top_txt">No.</th>-->
                    <th  class="top_txt">Name</th>
                    <th  class="top_txt">Email</th>
                    <th  class="top_txt">Phone</th>
                    <th  class="top_txt">Province</th>
                    <th  class="top_txt">County</th>
                    <th  class="top_txt">City</th>
		    <th  class="top_txt">Language</th>
		    <th  class="top_txt">Post Date</th>
                    <th  class="top_txt">Status</th>
		    <th  class="top_txt">Manage</th>
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
					
					$objlist->per_user_dtls($limit);
					$objlist_num->per_user_dtls_num();
					$num = $objlist_num->num_rows();
					
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
					<!--<td width="4%" style="padding: 5px 10px;"><?php //echo $cnt;;?></td>-->
					<td width="14%"><?php echo ucwords($objlist->f('fname')." ".$objlist->f('lname'));?></td>
					<td width="10%"><?php echo $objlist->f('email');?></td>
					<td width="6%"><?php  echo $objlist->f('phone');?></td>
					<td width="12%"><?php echo $objlist->f('state_name');?></td>
					<td width="12%"><?php echo $objlist->f('country_name');?></td>
					<td width="10%"><?php echo $objlist->f('city');?></td>
					<td width="13%"><?php echo $objlist->f('language');?></td>
					<td width="10%"><?php echo date("Y-m-d",$objlist->f('post_date'));?></td>
					<td width="10%">
                    	
                    	<?php if($objlist->f('activate_status')==1){?><span style="color:#006684;">Active</span><?php } else { ?><span style="color:#F00;">Inactive</span><?php } ?>
			
                    </td>
			<td width="5%">
<span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objlist->f('admin_id');?>','<?php echo $objlist->f('email');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
			</td>
					</tr>
					
					<?php $cnt++; } if($num>25){?>
					<tr>
						<td>&nbsp</td>
						<td>&nbsp</td>
					<td colspan="8" align="left"><div style="width: 150px; float:right; margin:-14px 74px 10px 0;"><?php $p->show();?></div></td>
					</tr>
					<?php
					}
					}
					else
					{
					?>
					<tr><td colspan="8" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
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
