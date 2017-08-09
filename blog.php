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

/*-----------FOR URL CHANGE OF BOLG-------------*/
$old_pattern = array("/[^a-zA-Z0-9]/", "/_+/", "/_$/");
$new_pattern = array("_", "-", "");

$blog_en_title = strtolower(preg_replace($old_pattern, $new_pattern ,$objintro->f('page_name')));
$blog_es_title = strtolower(preg_replace($old_pattern, $new_pattern , $objintro->f('title_sp')));

if($_SESSION['langSessId']=='eng')
	$_SESSION['set_lang_blog'] = 'en';
else
	$_SESSION['set_lang_blog'] = 'es';

if($_REQUEST['lang']=="")
	{
	
		if($_SESSION['langSessId']=='eng')
		{
		header("location: ".$obj_base_path->base_path()."/en/blog/".$page_id."/".$blog_en_title);
			exit;
			
		}
		else{
		header("location: ".$obj_base_path->base_path()."/es/blog/".$page_id."/".$blog_es_title);
			exit;
		}
	
	}
else if($_REQUEST['lang']!="" && $_REQUEST['lang']!=$_SESSION['set_lang_blog'])
{
	if($_SESSION['langSessId']=='eng')
	{
		$_SESSION['set_lang_blog'] = 'en';
		//header("location: ".$obj_base_path->base_path()."/redirect_blog/".$page_id."/en/".$blog_en_title);
		header("location: ".$obj_base_path->base_path()."/en/blog/".$page_id."/".$blog_en_title);
		exit;
	}
	else{ 
		$_SESSION['set_lang_blog'] = 'es';
		//header("location: ".$obj_base_path->base_path()."/redirect_blog/".$page_id."/es/".$blog_es_title);
		header("location: ".$obj_base_path->base_path()."/es/blog/".$page_id."/".$blog_es_title);
		exit;
	}
	
	
}

        $url = $_SERVER['REQUEST_URI'];
	 //echo $url.'<br/>';
	$url_lang_arr=explode('/',$url);
	$url_lang=$url_lang_arr[1];
         //echo $url_lang;
	if($url_lang=="en")
		{
			$fb_url = $obj_base_path->base_path()."/en/blog/".$page_id."/".$blog_en_title;
		}
	else
		{
			$fb_url = $obj_base_path->base_path()."/es/blog/".$page_id."/".$blog_es_title;	
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta itemscope itemtype="http://schema.org/Article" />	
	
	
<?php
if($_REQUEST['lang']=='en')
{
	
?>
	<title><?php  echo htmlentities(stripslashes($objintro->f('page_name')));?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' /> <!--app id : 1411675195718012--->
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?> <!--- THIS IS THE FB:URL echo "actual_link= ".$actual_link; -->
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="<?php  echo $objintro->f('page_name');?>" />
	<meta name="title" content="<?php  echo $objintro->f('page_name');?>" />
	<meta property="og:url" content="<?php echo $actual_link; ?>" />
	<meta itemprop="description" content="<?php echo strip_tags($objintro->f('page_content'));?>" />
	<meta property="og:description" content="<?php echo strip_tags($objintro->f('page_content'));?>" />
	<meta name="description" content="<?php echo strip_tags($objintro->f('page_content'));?>" />
<?php
}
else
{
	
?>
	<title><?php  echo htmlentities(stripslashes($objintro->f('title_sp')));?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?> <!--- THIS IS THE FB:URL echo "actual_link= ".$actual_link; -->
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="<?php  echo $objintro->f('title_sp');?>" />
	<meta name="title" content="<?php  $objintro->f('title_sp');?>" />
	<meta property="og:url" content="<?php echo $actual_link; ?>" />
	<meta itemprop="description" content="<?php echo strip_tags($objintro->f('page_content_sp'));?>" />
	<meta property="og:description" content="<?php echo strip_tags($objintro->f('page_content_sp'));?>" />
	<meta name="description" content="<?php echo strip_tags($objintro->f('page_content_sp'));?>" />
<?php
}
?>


<?php if($objintro->f('photo') != ''){?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo trim($objintro->f('photo'));?>">
<?php
}
else
{
?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpasapp_logo_fb.png">
<?php
}
?>


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.bxSlider.min.js"></script>
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
                   <div class="blue_boxh"><p><?php //if($lang == 'en'){echo $objintro->f('page_name');}else{echo $objintro->f('title_sp');}?> Blog </p></div>
		   <?php //if($page_id=="blog"){
			$objprev=new user;
			$objprev->blog_prev('blog',$page_id);
			$num = $objprev->num_rows();
			
			if($objprev->num_rows()>0){
			$objprev->next_record();
			//echo $objprev->f('page_id');
			}
			
			
			$objnext=new user;
			$objnext->blog_next('blog',$page_id);
			$num1 = $objnext->num_rows();
			
			if($objnext->num_rows()>0){
			$objnext->next_record();
			//echo $objprev->f('page_id');
			}
		   ?>
		   <style>
            .bx-prev, .bx-next {
                visibility: hidden;
            }
			.blue_boxr .previewbtn, .blue_boxr .nextbtn {
				width: 20%;
				font-size:  14px;
				color: #fff;
			}
			.blue_boxr .previewbtn {
				float:  left;
				text-align: left;
				margin: 20px 0 0 0;
			}
			.blue_boxr .nextbtn {
				width: 16%;
				float:  right;
				text-align: right;
				margin: 20px 0 0 0;
			}
			.blue_boxr .previewbtn a, .blue_boxr .nextbtn a{
				font-size:  14px;
				line-height: 20px;
				color: #fff;
				font-weight: bold;
				text-decoration: none;
				cursor: pointer;
				margin: 0;
				padding: 0px 5px;
				display: block;
			}
			.blue_boxr .content_info {
				width: 54%;
				margin: 11px 0 0 1%;
				float:  left;
				font-size:  14px;
				color: #fff;
				font-weight: bold;
				
			}
		   </style>
                   <div class="blue_boxr" style="text-align: center;">
			<div class="previewbtn">
			<?php if($num>0){?>
			<a href="<?php if($_SESSION['langSessId']=='eng'){  echo $obj_base_path->base_path(); ?>/en/blog/<?php echo $objprev->f('page_id');?>/<?php echo strtolower(preg_replace($old_pattern, $new_pattern ,$objprev->f('page_name')));} else {echo $obj_base_path->base_path(); ?>/es/blog/<?php echo $objprev->f('page_id');?>/<?php echo strtolower(preg_replace($old_pattern, $new_pattern , $objprev->f('title_sp')));}?> " class="active"><?php if($_SESSION['langSessId']=='eng'){ ?><< Previous<?php } else { ?><< Anterior<?php }?></a> 
			<?php } ?>
			</div>
			&nbsp;&nbsp;&nbsp;&nbsp;
			
			
			<div class="content_info"><?php if($lang == 'en'){echo stripslashes($objintro->f('page_name'));}else{echo stripslashes($objintro->f('title_sp'));}?></div>
			
			
			&nbsp;&nbsp;&nbsp;&nbsp;
			<div class="nextbtn">
			<?php if($num1>0){?>
			
            <a href="<?php if($_SESSION['langSessId']=='eng'){  echo $obj_base_path->base_path(); ?>/en/blog/<?php echo $objnext->f('page_id');?>/<?php echo strtolower(preg_replace($old_pattern, $new_pattern ,$objnext->f('page_name')));} else {echo $obj_base_path->base_path(); ?>/es/blog/<?php echo $objnext->f('page_id');?>/<?php echo strtolower(preg_replace($old_pattern, $new_pattern , $objnext->f('title_sp')));}?> " class="active"><?php if($_SESSION['langSessId']=='eng'){?>Next >><?php } else{ ?> Siguiente>><?php } ?> </a>
			<?php } ?>
			</div>
                   </div>
		   <?php //} ?>
		 </div>
		 <div class="clear"></div>
                 <div class="Tchai_box" style="width: auto;"> 
                     <?php $url_blog="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
                    <?php if($objintro->f('social')==1){?>

                    <div style="margin: 4px;float:left;padding: 5px;">

                    <?php //$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>

                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=1411675195718012";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>

                    <div class="fb-share-button" data-href="<?php echo $url_blog;?>" data-type="box_count"></div>

                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url_blog;?>" data-via="Kpasapp" data-lang="<?php echo $lang;?>" data-text="<?php if($_REQUEST['lang']=='en') { echo htmlentities(stripslashes($objintro->f('page_name')));} else { echo htmlentities(stripslashes($objintro->f('title_sp')));}?>" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>

                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                    <!-- Place this tag where you want the +1 button to render. -->
                    <div class="g-plusone" data-size="tall"  lang="<?=$lang?>"></div>

                    <!-- Place this tag after the last +1 button tag. -->
                    <script type="text/javascript">

                    (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                    </script>



                    <script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>

                    <!-- Place this tag where you want the su badge to render -->
                    <su:badge layout="5"></su:badge>

                    <!-- Place this snippet wherever appropriate -->
                    <script type="text/javascript">
                      (function() {
                        var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                        li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
                      })();
                    </script>



                    </div>
                <?php } ?>
                     <div class="clear"></div>
                     <hr style="font-size: 14px; font-weight: normal; height: 1px; background: #ccc; ">
                        <?php if($lang == 'en'){echo $objintro->f('page_content');}else{echo $objintro->f('page_content_sp');} ?>
                  </div>
		 
                </div>
                
               <div class="clear"></div>
               
			
			<?php $url_blog="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
			<?php if($objintro->f('social')==1){?>
			<?php if($_SESSION['langSessId']=='eng' || $_REQUEST['lang']=='en')
					 {
						 $lang="en_US";						 
					 }
					 else 
					 {
						$lang="es_ES";						
					 }
					 ?>
			<div style="margin: 4px;float:left;padding: 5px;">

			<?php //$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
			
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=1411675195718012";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-share-button" data-href="<?php echo $url_blog;?>" data-type="box_count"></div>
			
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url_blog;?>" data-via="Kpasapp" data-lang="<?php echo $lang;?>" data-text="<?php if($_REQUEST['lang']=='en') { echo htmlentities(stripslashes($objintro->f('page_name')));} else { echo htmlentities(stripslashes($objintro->f('title_sp')));}?>" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
			
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
			<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone" data-size="tall"  lang="<?=$lang?>"></div>
			
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			
			(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
			</script>
			
			
			
			<script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>
			
			<!-- Place this tag where you want the su badge to render -->
			<su:badge layout="5"></su:badge>
			
			<!-- Place this snippet wherever appropriate -->
			<script type="text/javascript">
			  (function() {
			    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
			    li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
			  })();
			</script>
			
			
			
		    </div>
		<?php } ?>
   
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
