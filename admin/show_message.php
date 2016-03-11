<?php
include('../include/admin_inc.php');

$obj=new user;
$obj1=new user;
$obj_sendmail=new user;
$faq = new User;
$edit_admin= new User;



//print_r($_SESSION);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profile Setting</title>

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






<body class="body1">

<?php include("admin_header.php"); ?>


<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
        <div class="container">
			<?php include("admin_header_menu.php");?> 
            <div id="body">
        		<div class="body2"> 
		           <div class="blue_box1">
                   	<div class="blue_box10"><p>Database Info</p></div>
                   </div> 
        		</div>	
      		</div>
        </div>
        <div class="container">
            <div class="left_panel bg" style="width:978px;">
                <div class="cheese_box">
                    
                    <div class="clear"></div>
                    <div style="width: 976px; float: none; margin: 0 auto;">	
                    <div class="Tchai_box1" style="">
                    	<?php
							if($_SESSION['ses_user_id']!=1){
						?>
                        <p style="font-size:16px; font-weight:bold;text-transform:uppercase; color:#F00;">You Don't have permission to access Database</p>
                    
                    	<?php
							} else {
						?>
                        <p style="font-size:16px; font-weight:bold;text-transform:uppercase; color:#36C;">Database is saved in db-backup folder.</p>
                    	<?php
							} 
						?>
                      
                    </div>
    
                    </div>
                </div>
                <div class="clear"></div>
            </div>
           <div class="clear"></div>
        </div>

    </div>
    <div class="clear"></div>
	</div>
<div class="clear"></div>
<?php include("admin_footer.php"); ?>


</body>

</html>
