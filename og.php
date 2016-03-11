<?php
include('include/user_inc.php');

$page_id=$_REQUEST['page_id'];
$lang=$_REQUEST['lang'];
//echo "hii".$lang;
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

<!--<meta property="og:locale" content="<?php //if($lang == 'en'){echo "en_US";}else{echo "es_ES";}?>" />-->
<meta property="og:locale" content="<?php {echo "es_ES";}?>" />
<meta property="og:type" content="website" />

<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = "http://www.phppowerhousedemo.com/webroot/team5/kpasapp/blog/".$obj->f('page_link')."";
?>
<meta property="og:title" content="<?php {echo $objintro->f('title_sp');}?>" />
<meta property='og:site_name' content='Kpasapp' />

<meta name="title" content="<?php {echo $objintro->f('title_sp');}?>" />

<meta property="og:url" content="<?php echo $actual_link;?>" />
<meta property="og:description" content="<?php {echo strip_tags($objintro->f('page_content_sp'));}?>" />

<?php if($objintro->f('photo') != ''){?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/files/event/medium/<?php echo $objintro->f('photo');?>">
<?php
}
else
{
?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpasapp_logo_fb.png">
<?php
}
?>
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
</head>
<body></body>
</html>