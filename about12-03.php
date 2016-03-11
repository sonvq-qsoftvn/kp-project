<?php
include('include/user_inc.php');

$page_id=$_REQUEST['page_id'];
$objintro=new user;
$objintro->intro_page($page_id);
$objintro->num_rows();

if($objintro->num_rows() > 0)
$objintro->next_record();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $objintro->f('page_name');?></title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>

</head>

<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" >
            	<div class="cheese_box">
		 <div class="blue_box1">
                   <div class="blue_boxh"><a href="<?php echo $obj_base_path->base_path(); ?>/about/kpasapp" style="text-decoration:none;"><p><?php echo $objintro->f('page_name');?></p></a></div>
		   <?php if($page_id!="about-baja-sur" && $page_id!="privacy-terms"){?>
                   <div class="blue_boxr">
                       <ul>
                           <li><a href="<?php echo $obj_base_path->base_path(); ?>/about/feature" <?php if($page_id=="feature") {?> class="here" <?php } ?>><?php echo Features;?></a></li>
                           <li><a href="<?php echo $obj_base_path->base_path(); ?>/about/plan-pricing" <?php if($page_id=="plan-pricing") {?> class="here" <?php } ?>><?php echo Plans_Pricing;?></a></li>
                           <li><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/eventgoers" <?php if($page_id=="eventgoers") {?> class="here" <?php } ?>><?php echo Event_goers;?></a></li>
                           <li><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/eventprofessionals" <?php if($page_id=="eventprofessionals") {?> class="here" <?php } ?>><?php echo Event_Managers;?></a>
                           	<ul>
                                    <li><a href="#">Event managers</a></li>
                                    <li><a href="#">Venues managers</a></li>
				    <li><a href="#">Performers</a></li>
				    <li><a href="#">Event service providers</a></li>
				    <li><a href="#">Sponsors</a></li>
                            	</ul>
                           </li>
                           <li><a href="#"><?php echo Event_Service_Providers;?></a></li>
                       </ul>
                   </div>
		   <?php } ?>
		 </div>
		 <div class="clear"></div>
                 <div class="Tchai_box" style="width: auto;">
                        <?php echo $objintro->f('page_content'); ?>
                  </div>
                </div>
               <div class="clear"></div>
                    
                </div>
            <?php include("include/frontend_rightsidebar.php");?>
             <div class="clear"></div>
                
        </div>

    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>


</body>
</html>
