<?php 
include('include/user_inc.php');

$objEvent=new user;
$obj_venue=new user;

$event_name = $_REQUEST['event_name'];
$event_id = $_REQUEST['event_id'];
//echo $event_name.'<br/>';
//echo $event_id.'<br/>';


$objEvent->getOrgEvent($event_id);
$objEvent->next_record();

$obj_venue->venue_details_eventId($event_id);
$obj_venue->next_record();

list($event_date,$event_time) = explode(" ",$objEvent->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$objEvent->f('event_end_date_time'));

	$url_main="http://".$_SERVER['HTTP_HOST']; //http://kpasapp.com
	//echo $url_main."<br/>";
	//echo $url . '<br/>';
	 //$url1="http://".$_SERVER['HTTP_HOST']; 
	 //echo "url1= ".$url1.'<br/>';
	 $url = $_SERVER['REQUEST_URI'];  // /en/event/TNS%20Test%20en-both%20fees%20n/i/bookings/515
	 //echo $url.'<br/>';
	 $url_lang_arr=explode('/',$url);
	 $url_lang=$url_lang_arr[1];      //   en OR es
	 //echo $url_lang;  
         //echo "ep= ". $objEvent->f('event_photo');
		 
	if($url_lang=='en')
	 {
		$event_title = htmlentities(stripslashes($objEvent->f('event_name_en')));
		
		$event_description = date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date)) .'-'. date('g:i A',strtotime($event_time))." to ".  date('g:i A',strtotime($event_time_end)).", ".$obj_venue->f('venue_name_en').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".htmlentities(stripslashes($objEvent->f('event_short_desc_en')));
		//echo "ED== ".$event_description;
	 
	 }
	else
	 {
	        $event_title =  htmlentities(stripslashes($objEvent->f('event_name_sp')));
	        setlocale(LC_TIME, 'es_ES');
                $event_description =  strftime("%a",strtotime($event_date))." ".strftime("%e",strtotime($event_date))." de ".strftime("%b",strtotime($event_date)).", ".strftime("%Y",strtotime($event_date))." - ".strftime('%l:%M%p',strtotime($event_time))." to ". strftime("%a",strtotime($event_date_end))." ".strftime("%e",strtotime($event_date_end))." de ".strftime("%b",strtotime($event_date_end)).", ".strftime("%Y",strtotime($event_date_end))." - ". strftime('%l:%M%p',strtotime($event_time_end)).", ".$obj_venue->f('venue_name_sp').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name').", ".htmlentities(stripslashes($objEvent->f('event_short_desc_sp')));
		//echo "EDS== ".$event_description;
		//htmlentities(stripslashes($objEvent->f('event_short_desc_sp'))))
	 }



				 
					 
					if($url_lang=='en')
					 {
						 $lang="en_US";
						 $url3=$url_main."/en/event/".$event_name."/bookings/".$event_id;
						 //echo $url3;
					 }
					 else 
					 {
						$lang="es_ES";
						$url3=$url_main."/es/evento/".$event_name."/bookings/".$event_id;
					       //echo $url3;
					 }
					// echo $url3;
					 //$url3 = "http://kpasapp.com/fancy_share.php?event_id=513&media_id=".$media_id;
					 
					
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo $event_title; ?></title>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->


<meta property='fb:app_id' content='1411675195718012' />
<!--<meta property="og:locale" content="<?php //if($_SESSION['langSessId']=='eng'){echo "en_US";}else{echo "es_ES";}?>" />-->
<meta property="og:locale" content="<?php if($url_lang=='en') { echo "en_US";} else { echo "es_ES";}?>" />
<meta property="og:type" content="website" />

<!--1411675195718012--->


<meta property='og:site_name' content='Kpasapp' />

<meta property="og:title" content="<?php  { echo $event_title;}?>" />

<meta name="title" content="<?php  { echo $event_title;}?>" />

<meta property="og:url" content="<?php echo $url3 ?>" />

<meta property="og:description" content="<?php echo $event_description; ?>" />

<meta name="description" content="<?php echo $event_description;?>" />

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
		
	
		<div class="whitebg">
		<div class="clear"></div>
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
		
		 
	</div>
</div>				
</body>
</html>