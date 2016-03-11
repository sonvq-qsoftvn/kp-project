<?php 
include('include/user_inc.php');

$objEvent=new user;
$objEventGallery=new user;

$event_name = $_REQUEST['event_id'];
//echo $event_name; 
$media_id = $_REQUEST['media_id'];
$media_name = $_REQUEST['media_name'];
	$url_main="http://".$_SERVER['HTTP_HOST'];
	//echo $url_main."<br/>";
	 //echo $url . '<br/>';
	// $url1="http://".$_SERVER['HTTP_HOST'];
	 //echo $url1;
	 $url = $_SERVER['REQUEST_URI'];
	 //echo $url.'<br/>';
	 $url_lang_arr=explode('/',$url);
	 $url_lang=$url_lang_arr[1];
	 //echo $url_lang;
					 
	if($url_lang=='en')
	 {
		$lang_id = "en_US" ;
	 
	 }
	else
	 {
	     $lang_id = "es_MX" ;
	 }

//echo $lang_id;
/*For Gallery Media*/
$objEventGallery->galleryByMediaID($media_id,$lang_id);
$objEventGallery->next_record();

$e_id = $objEventGallery->f('event_id');
/*For  Event*/
//$objEvent->getOrgEvent($event_id);
//$objEvent->next_record();

//$event_name_en=  $objEvent->f('event_name_en');
//echo $event_name_en;
//$event_name_sp= $objEvent->f('event_name_sp');
//echo $event_name_sp;

				 
					 
					if($url_lang=='en')
					 {
						 $lang="en_US";
						 $url3=$url_main."/en/event/".$event_name."/gallery/".$media_id."/".$media_name;
						 //echo $url3;
					 }
					 else 
					 {
						$lang="es_ES";
						$url3=$url_main."/es/evento/".$event_name."/galeria/".$media_id."/".$media_name;
						// echo $url3;
					 }
					// echo $url3;
					 //$url3 = "http://kpasapp.com/fancy_share.php?event_id=513&media_id=".$media_id;
					 
					
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo htmlentities(stripslashes($objEventGallery->f('media_name'))); ?></title>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->


<meta property='fb:app_id' content='1411675195718012' />
<!--<meta property="og:locale" content="<?php //if($_SESSION['langSessId']=='eng'){echo "en_US";}else{echo "es_ES";}?>" />-->
<meta property="og:locale" content="<?php if($url_lang=='en') { echo "en_US";} else { echo "es_ES";}?>" />
<meta property="og:type" content="website" />

<!--1411675195718012--->


<meta property='og:site_name' content='Kpasapp' />

<meta property="og:title" content="<?php  { echo $objEventGallery->f('media_name');}?>" />

<meta name="title" content="<?php  { echo $objEventGallery->f('media_name');}?>" />

<meta property="og:url" content="<?php echo $url3 ?>" />

<meta property="og:description" content="<?php echo $objEventGallery->f('description'); ?>" />

<meta name="description" content="<?php echo $objEventGallery->f('description');?>" />

<?php //if($objEventGallery->f('media_format')=="video"){?>

<!--<meta property='og:video' content="http://www.youtube.com/embed/<?php //echo end(explode('=',$objEventGallery->f('media_url')));?>" />-->
<!-- og:video:1 --><!--<meta property="og:image" content="http://img.youtube.com/vi/ixredWC9HfQ/0.jpg" />
<!-- og:video:1 --><!--<meta property="og:video" content="http://www.youtube.com/embed/ixredWC9HfQ" />-->
<!-- og:video:1 --><!--<meta property="og:video:height" content="360" />-->
<!-- og:video:1 --><!--<<!--meta property="og:video:type" content="application/x-shockwave-flash" />-->
<!-- og:video:1 --><!--<meta property="og:video:width" content="640" />-->
<?php // }?>
<?php if($objEventGallery->f('media_url')==''){?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">

<?php
}
else
{
	if($url_lang=='en' || $url_lang=='es')
	   {
?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/large/<?php echo $objEventGallery->f('media_url');?>"/>
<?php
	   }
}
?>

      <?php
       /*For Video Url Cheking*/
           function videoType($video_url) {
		if (strpos($video_url, 'youtube') > 0) {
		    return 'youtube';
		} elseif (strpos($video_url, 'vimeo') > 0) {
		    return 'vimeo';
		} elseif (strpos($video_url, 'dailymotion') > 0) {
		    return 'dailymotion';
		} else {
		    return 'image';
		}
	    }
	/*For Video Url Cheking*/
	?>
	
	<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
	
	
</head>
<style>
#maindiv .whitebg { background: #fff;}
/*.logo_fancy {}*/
.toptxtbox { background: #00759b; padding: 11px; width: 98%;font-family: Arial, Helvetica, sans-serif; font-size:  15px; color: #fff; line-height:  20px; text-align:  left; margin: 0 0 15px 0;}
/*a.toptxtbox{text-decoration: none;}*/
.share_btns { width: 100%; float: left; margin: 0 0 15px 0; position: relative;}
.share_btns ul { padding: 0; margin: 0;}
.share_btns ul li { padding: 0; margin: 0 5px 0 0; list-style-type: none; float: left;}
.boximgdiv { text-align:  center; margin: 0 auto 10px auto; display: table; overflow:  hidden;}
.captiontxthere { font-family: Arial, Helvetica, sans-serif; font-size:  16px; color: #000; line-height:  20px; text-align:  left; padding: 5px 10px; margin: 0 0 5px 0; font-weight:bold;}
.descriptiontxt { font-family: Arial, Helvetica, sans-serif; font-size:  14px; color: #000; line-height:  18px; text-align:  left; padding: 5px 10px; margin: 0;}
</style>
<body>
	<div id="maindiv">
		
	<div><a style="text-decoration: none;" href="<?php echo $obj_base_path->base_path(); ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/KPasapp_logo.png" border="0"></a></div>
		<div class="whitebg">
		<div class="clear"></div>
		<?php if($url_lang=='en') { ?>
	   
		<a href="<?php echo $obj_base_path->base_path().'/event/'.$e_id;?>"><div class="toptxtbox">Click here to go to <?php echo $event_name;?></div></a>
		<?php } else { ?>
		 
		<a href="<?php echo $obj_base_path->base_path().'/event/'.$e_id;?>"><div class="toptxtbox">Haga clic para hir a <?php echo $event_name;?></div></a>
		<?php }?>
		
		<?php if($objEventGallery->f('media_format')!="video") {?>
		<div class="share_btns">
                  <ul>
			<li>
		   
                             <!-----------social share---------->
			        <div class="clear"></div>
			        <div id="fb-root"></div>
				<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/<?php if($url_lang=='en') { echo "en_US";} else { echo "es_ES";}?>/all.js#xfbml=1&appId=1411675195718012";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-share-button" data-href="<?php echo $url3;?>" data-type="box_count"></div></li>
				
				
				<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url3;?>" data-via="Kpasapp" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
				
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>
		  
		  <!-- Place this tag where you want the +1 button to render. -->
					<li><div class="g-plusone" data-size="tall"></div>
					
					<!-- Place this tag after the last +1 button tag. -->
					<script type="text/javascript">
					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/platform.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script></li>
					
					
					
					<li><script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script></li>
					
					<!-- Place this tag where you want the su badge to render -->
					<li><su:badge layout="5"></su:badge>
					
					<!-- Place this snippet wherever appropriate -->
					<script type="text/javascript">
					  (function() {
					    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
					    li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
					  })();
					</script></li>
					</ul>
	</div>
		 <!-----------social share---------->
		<?php }?> <!-- Only Show for images not for the  video --->
		 
		  <?php $video_url=$objEventGallery->f('media_url');
		    $var=videoType($video_url);
		   //echo "<br/>var=".$var;?>
		  <?php if($objEventGallery->f('media_format')!="video") {?>
		  <div class="boximgdiv"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/gallery/large/<?php echo $objEventGallery->f('media_url');?>"  border="0"  /></div>
		 <?php } else { ?>
		 <?php  if($var=="youtube") { //echo "YOUTUBE";?>
		 <iframe width="398" height="224" src="//www.youtube.com/embed/<?php echo end(explode('=',$objEventGallery->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
		 <?php }
		  elseif($var=="vimeo") { ?>
		 <iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$objEventGallery->f('media_url')));?>" width="398" height="224" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		 <?php }
		  elseif($var=="dailymotion") {
		    $dm_vid_arr=explode('_',end(explode('/',$obj_event_media->f('media_url'))));
		    $dm_vid = $dm_vid_arr[0];
		    ?>
		    <iframe frameborder="0" width="398" height="224" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
		 <?php }
		 }
		 ?>
		  <div class="captiontxthere"><?php echo $objEventGallery->f('caption');?></div>
		  <div class="descriptiontxt"><?php echo $objEventGallery->f('description');?></div>
		  <div class="clear"></div>
	</div>
</div>				
</body>
</html>