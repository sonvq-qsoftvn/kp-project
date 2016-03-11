<?php
// home page
session_start();

// List of page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	$objlist = new merchant_admin;
	$objlist_num = new merchant_admin;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Page Management</title>
	
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
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->




<script type="text/javascript">

function del(eID)
{
	if(confirm("Are you sure you want to delete this venue?"))
	{
		location.href="<?php echo $obj_base_path->base_path(); ?>/admin/delete-page/"+eID;
	}
	
}
</script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

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
           <div class="blue_box10"><p>Page</p></div>
           	<?php include("admin_menu/list_page_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#006600;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#FF0000;">
        <strong><?php echo $msg;?>		
		</strong></div>	
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
                <td colspan="7" style="font: bold 13px/30px Arial, Helvetica, sans-serif; padding: 2px 0; color:#000;background:#ccc; text-align: center;">Successfully Deleted</td>
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
                <td colspan="7" style="font: bold 13px/30px Arial, Helvetica, sans-serif; text-align:center; padding: 2px 0; color:#000; background: #ccc;">Successfully added</td>
                <?php
                    }
                ?>
            </tr>
                
            <tr>
                <th  class="top_txt">No.</th>
		<th  class="top_txt">Path</th>
                <th  class="top_txt">Page Name</th>
		<th  class="top_txt">Date</th>
		<th  class="top_txt">Status</th>
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
					
					$objlist->list_page($limit);
					$objlist_num->list_page_all();
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
					while($row = $objlist->next_record())
					{				
					?>
					<tr>         
					<td width="3%" style="padding: 0 10px;"><?php echo $objlist->f('page_id');?></td>
					<td width="3%"><?php echo $objlist->f('path');?></td>
					<td width="8%"><?php echo $objlist->f('page_name');?></td>
					
					<td width="3%"><?php if($objlist->f('create_time')){echo date("Y-m-d",$objlist->f('create_time'));}?></td>
					<td width="3%"><?php if($objlist->f('publish')==1){echo "Publish";}else{echo "Unpublish";}?></td>
					
					<td width="15%">
					<a href="javascript:void(0);" onClick="del('<?php echo $objlist->f('page_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" />Delete</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit_page/<?php echo $objlist->f('page_id');?>">Edit</a>
					<?php if($objlist->f('path') != 'other'){?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php echo $obj_base_path->base_path(); ?>/<?php echo $objlist->f('path');?>/<?php echo $objlist->f('page_id');?>/<?php echo str_replace(',','',str_replace(' ', '-',$objlist->f('page_name')));?>/en" target="_blank">Preview EN</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php echo $obj_base_path->base_path(); ?>/<?php echo $objlist->f('path');?>/<?php echo $objlist->f('page_id');?>/<?php echo str_replace(' ', '-',$objlist->f('title_sp'));?>/es" target="_blank">Preview ES</a>
					<?php } ?>
					</td>
					
					</tr>
					
					<?php }?>
					<tr><td colspan="6" align="center"><?php $p->show();?></td></tr>
					<?php
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
