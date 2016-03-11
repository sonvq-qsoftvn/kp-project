<?php
include('../include/admin_inc.php');
include('../class/test_class.php');

//create object
$objmetalist = new admin();
$objmetalist_num = new admin();
?>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>


<?php
$objmetalist->getAllmeta();
$num = $objmetalist->num_rows();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Promotion List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
	.add_media{
		width: auto;
		height: 34px;
		background: #00f;
		margin: 0;
		display: inline-block;
	
	}
	.add_media a{
		font-size: 18px;
		line-height: 34px;
		font-weight:normal;
		color: #fff;
		text-align: center;
		padding:0 12px;
		margin: 0;
		display: block;
		text-decoration: none;
		cursor: pointer;
	}
</style>
<script language="javascript">





</script>
<script language="javascript">
function del(gID)
{
	if(confirm("Are you sure you want to delete this Ad?"))
	{
		window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete-meta/"+gID;
	}
	
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
				<div class="blue_box10"><p>Meta Management</p></div>
				<?php include("admin_menu/createmata_menu.php");?>
			   </div>
			   
			   
			    
			   <div class="clear"></div>
                          <div style="color:green;">
				<?php
				
				if(isset($_SESSION['media_del_msg'])){
				
				
				echo $_SESSION['media_del_msg'];
				
				unset($_SESSION['media_del_msg']);
				}
				
				
				
			    
			    ?>
			    
			</div>
			</div>	
		     </div>
     </div>
    
    <div>	
	<div class="myevent_box">		 
	 	
		<?php
		//echo "num= ".$num;
		if($num>0)
		{
			
		 ?>
			</div>		
          
	 <div class="clear"></div>		
	 <div class="myevent_box">
	   <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
                        <td width="30%" class="top_txt">Page Name</td>  
                        <td width="25%" class="top_txt">Meta Title</td> 
			<td width="25%" class="top_txt">Meta Tag</td>
			<!--<td width="16%" class="top_txt">Meta Description</td>-->			
                        <td width="30%" class="top_txt">Manage</td>
			</tr>
	                <?php
			 
			    while($row = $objmetalist->next_record())
			     {
			     ?>
		
		
		<tr>
		<!--<td>&nbsp</td>-->
		<td><?php echo $objmetalist->f('page_name');?></td>
                <td><?php echo $objmetalist->f('meta_title');?></td>                
		<td><?php echo $objmetalist->f('meta_tag');?></td>
	        <!--<td><?php echo $objmetalist->f('meta_description');?></td>-->
               
               
		<!--<td align="center"></td>-->
		<td style="padding: 5px;">
        	<span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-meta/<?php echo $objmetalist->f('page_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
        	
            <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objmetalist->f('page_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>

        </td>
                 
       </tr>
    
 
  <?php // $j++;
  } //while  end ?>
        
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Data Found</font></td></tr>
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