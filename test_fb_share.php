<?php 
include('include/user_inc.php');

$event_id = 550;
$sub_id = $_REQUEST['sub_id'];
$multi_id = $_REQUEST['multi_id'];

//create object
$objEvent=new user;
$objmulti_event=new user;
$objmul_date=new user;
$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_fee=new user;
$obj_ticket_img=new user;
$objsub_event=new user;
$obj_venue_sub=new user;

$obj_sub_ticket=new user;
$obj_sub_ticket_img=new user;

$obj_chk=new user;
$obj_cur_eve_dt=new user;

$obj_cart=new user;
$obj_count=new user;

$obj_expire=new user;
$obj_samefunc=new user;


// Event Details
$objEvent->getOrgEvent($event_id);
$objEvent->next_record();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_SESSION['langSessId']; if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($objEvent->f('event_name_en'))).'en'; } else { echo htmlentities(stripslashes($objEvent->f('event_name_sp'))).'sp';}?></title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->


<title>TNS Test es-fees Incl-1MXP</title>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->

<meta property='fb:app_id' content='1411675195718012' />
<!--<meta property="og:locale" content="<?php //if($_SESSION['langSessId']=='eng'){echo "en_US";}else{echo "es_ES";}?>" />-->
<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />

<!--1411675195718012--->
<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>

<meta property='og:site_name' content='Kpasapp' />
<?php $_SESSION['langSessId']='spn';?>
<meta property="og:title" content="<?php if($_SESSION['langSessId']=='spn') { echo htmlentities(stripslashes($objEvent->f('event_name_sp'))); } else { echo $objEvent->f('event_name_en');}?>" />

<meta name="title" content="<?php if($_SESSION['langSessId']=='spn') { echo htmlentities(stripslashes($objEvent->f('event_name_sp'))); } else { echo $objEvent->f('event_name_en');}?>" />

<meta property="og:url" content="<?php echo $actual_link; ?>" />

<meta property="og:description" content="<?php if($_SESSION['langSessId']=='spn') { echo date("l, j F, Y, g:i a",strtotime($objEvent->f('event_start_date_time'))).", ".$obj_venue->f('venue_name').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".htmlentities(stripslashes($objEvent->f('event_short_desc_sp'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($event_date))." ".strftime("%e",strtotime($event_date))." de ".strftime("%b",strtotime($event_date)).", ".strftime("%Y",strtotime($event_date)).", ".$obj_venue->f('venue_name_sp').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".$objEvent->f('event_short_desc_en');}?>" />

<meta name="description" content="<?php if($_SESSION['langSessId']=='spn') { echo date("l, j F, Y, g:i a",strtotime($objEvent->f('event_start_date_time'))).", ".$obj_venue->f('venue_name').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".htmlentities(stripslashes($objEvent->f('event_short_desc_sp'))); } else { setlocale(LC_TIME, 'es_ES'); echo  strftime("%a",strtotime($event_date))." ".strftime("%e",strtotime($event_date))." de ".strftime("%b",strtotime($event_date)).", ".strftime("%Y",strtotime($event_date)).", ".$obj_venue->f('venue_name_sp').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".$objEvent->f('event_short_desc_en');}?>" />

<?php if($objEvent->f('event_photo')==''){?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">
<?php
}
else
{
?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objEvent->f('event_photo');?>"/>
<?php
}
?> 

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>



<?php $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
<?php if($_SESSION['langSessId']=='eng' || $_REQUEST['lang']=='eng')
 {
         $lang="en_US";
         $url2=$url."/lang/eng";
 }
 else 
 {
        $lang="es_ES";
        $url2=$url."/lang/spn";
 }
 
 ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=508763702557865";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-share-button" data-href="<?php echo $url;?>" data-type="box_count"></div>


<?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($objEvent->f('event_name_en'))); } else { echo $objEvent->f('event_name_sp');}?>
<?php echo $_SESSION['langSessId']?>
