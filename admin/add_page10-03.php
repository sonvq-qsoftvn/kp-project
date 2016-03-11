<?php
// create page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	$objlist = new merchant_admin;
	$objedit = new merchant_admin;
	$page_id=$_REQUEST['page_id'];
	if(isset($_REQUEST['submit1']))
	{
		// post value
		$page_name=$_POST['title'];
		$title_sp=$_POST['title_sp'];
		$page_content=$_POST['page_content'];
		$page_content_sp=$_POST['page_content_sp'];
		
		if($_POST['page_link']!='')
			$page_link=$_POST['page_link'];
		else
			$page_link=str_replace(" ", "", $_POST['title']);
		
		// -- add Content --		
		$objedit->add_page($page_name,$title_sp,$page_content,$page_content_sp,$page_link);
		?>
		<script language="javascript">
		window.location="<?php echo $obj_base_path->base_path();?>/admin/list_page.php?err=3";
		</script>
		<?php
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Create Page</title>
	
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
		location.href="";
	}
	
}

</script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

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
    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
      <form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
      <input type="hidden" name="page_id" value="<?php echo $page_id  ?>">
        <tr>
            <td valign="top" width="18%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Page Title <span class="state_en"> EN </span>::</td>
            <td width="82%"><input type="text" name="title" style="height: 24px;" class="event_field8" value=""></td>
        </tr>
        <tr>
            <td width="18%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Page Title <span class="state_en"> SP </span>::</td>
            <td valign="top" width="82%"><input type="text" name="title_sp" style="height: 24px;" class="event_field8" value=""></td>
        </tr>
        <tr>
              <td  align="right" height="4"></td>
              <td></td>
        </tr>			
            
        <tr>
            <td style="font: normal 12px/18px Arial, Helvetica, sans-serif;">Description ::</td>
            <td valign="top">
            <div id="TabbedPanels2" class="TabbedPanels2">
                <ul class="TabbedPanelsTabGroup2">
                    <li class="TabbedPanelsTab2" tabindex="1">Espanol</li>  
                    <li class="TabbedPanelsTab2" tabindex="0">English</li> 
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/globe1.jpg" width="38" height="38" border="0" style="float:right; margin:0 10px 0 0;"/>	 
                </ul>
                <div class="TabbedPanelsContentGroup2">
                    <div class="TabbedPanelsContent2">
                    <?php 
						include($obj_base_path->base_path()."/ckeditor/ckeditor.php");
                       $CKeditor = new CKeditor();
                       $CKeditor->BasePath = 'ckeditor/';
                       $CKeditor->editor('page_content_sp');
                    ?>
                    </div>
                    <div class="TabbedPanelsContent2">
                     <?php 
                       $CKeditor = new CKeditor();
                       $CKeditor->BasePath = 'ckeditor/';
                       $CKeditor->editor('page_content');
                    ?>
                    </div> 
                </div>
            </div>
            </td>
        </tr>
        <tr>
            <td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 8px 0 0 0;">Page Link::</td>
            <td><input type="text" name="page_link" class="event_field8" style=" height: 24px;"  value="<?php echo $objlist->f('page_link')  ?>"></td>
       </tr>				
        <tr>
        <td>&nbsp;</td>				
        <td><input type="submit" name="submit1" value="Save" class="createbtn" style="height: 28px;"></td>
        </tr>
        
        </form>
    </table>






    <div class="clear"></div>
    </div>
    
    
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>

<script type="text/javascript">
<!--
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
