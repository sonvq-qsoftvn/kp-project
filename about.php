<?php

$allUrlSet = explode("/",$_SERVER['REQUEST_URI']);

//echo $allUrlSet;

$page_lang = $allUrlSet[count($allUrlSet)-3];

if ($page_lang != "" && ($page_lang == 'en' || $page_lang== 'es')) {
	$_REQUEST['lang']=$page_lang;
}
include('include/user_inc.php');


//echo "p= ".$page_lang;

$page_id=$_REQUEST['page_id'];

//print_r($_REQUEST);
//echo "page= ". $page_id;
if($page_id=="")
{$page_id='kpasapp';}
else if($page_id=="feature" || $page_id=="funciones")
{$page_id="feature";}
else if($page_id=="plan-pricing" || $page_id=="planes-precios")
{$page_id="plan-pricing";}
else if($page_id=="event_goers" || $page_id=="publico")
{$page_id="eventgoers";}
else if($page_id=="event_professionals" || $page_id=="profesionales_de_eventos")
{$page_id="eventprofessionals";}

$objintro=new user;
$objintro->intro_page_new($page_id);
$objintro->num_rows();

if($objintro->num_rows() > 0)
$objintro->next_record();



//================================  for meta==================== 


if($_SESSION['langSessId']=='eng')
{ $lang="en"; }
else
{$lang="es";}

	$objformeta=new user;     
	$objformeta->getAllMeta('about',$lang);
	$objformeta->next_record();
//================================  for meta==================== 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $objformeta->f('meta_title') ?></title>
<meta charset="utf-8">
<meta name="title" content="<?php echo $objformeta->f('meta_title') ?>">
<meta name="keywords" content="<?php echo $objformeta->f('meta_tag') ?>">
<meta name="description" content="<?php echo $objformeta->f('meta_description') ?>">
            
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
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
                  
		   <div class="blue_boxh"><a href="<?php if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/<?php } else { echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/<?php } ?>" style="text-decoration:none;"><p  style="font-size: 15px; font-weight: 900"><?php if($_SESSION['langSessId']=='eng') { echo $objintro->f('page_name'); } else { echo $objintro->f('title_sp'); }?></p></a></div>
		   
		   <?php if($page_id!="about-baja-sur" && $page_id!="privacy-terms"){?>
                   <div class="blue_boxr" style="/*width: 455px;*/ width: auto; margin-right:  10px;">
<ul>
<li><a href="<?php if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/feature <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/funciones<?php }?>" <?php if($page_id=="feature" || $page_id=="funciones") {?> class="here" <?php } ?>><?php echo Features;?></a></li>

<li><a href="<?php if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/plan-pricing <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/planes-precios <?php }?>" <?php if($page_id=="plan-pricing" || $page_id=="planes-precios") {?> class="here" <?php } ?>><?php echo Plans_Pricing;?></a></li>

<li><a href="<?php if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/event_goers <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/publico <?php }?>" <?php if($page_id=="eventgoers" || $page_id=="publico") {?> class="here" <?php } ?>><?php echo Event_goers;?></a></li>

<li><a href="<?php if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/event_professionals <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/profesionales_de_eventos <?php }?>" <?php if($page_id=="eventprofessionals" || $page_id=="profesionales_de_eventos") {?> class="here" <?php } ?>><?php echo Event_Managers;?></a>
<ul>
                                    <li><a href="#">Event managers</a></li>
                                    <li><a href="#">Venues managers</a></li>
				    <li><a href="#">Performers</a></li>
				    <li><a href="#">Event service providers</a></li>
				    <li><a href="#">Sponsors</a></li>
                            	</ul>
                           </li>
                           <!--<li><a href="#"><?php echo Event_Service_Providers;?></a></li>-->
                       </ul>
                   </div>
		   <?php } ?>
		 </div>
		 <div class="clear"></div>
                 <div class="Tchai_box" style="width: auto;">
                        <?php if($_SESSION['langSessId']=='eng') { echo $objintro->f('page_content');} else {echo $objintro->f('page_content_sp');} ?>
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
