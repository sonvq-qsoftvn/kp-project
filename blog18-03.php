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

<meta property="og:locale" content="<?php if($lang == 'en'){echo "en_US";}else{echo "es_ES";}?>" />
<meta property="og:type" content="article" />

<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = "http://www.phppowerhousedemo.com/webroot/team5/kpasapp/blog/".$obj->f('page_link')."";
?>
<meta property="og:title" content="<?php if($lang == 'en'){echo $objintro->f('page_name');}else{echo $objintro->f('title_sp');}?>" />
<meta property='og:site_name' content='Kpasapp' />

<meta name="title" content="<?php if($lang == 'en'){echo $objintro->f('page_name');}else{echo $objintro->f('title_sp');}?>" />

<meta property="og:url" content="<?php echo $actual_link;?>" />
<meta property="og:description" content="<?php if($lang == 'en'){echo strip_tags($objintro->f('page_content'));}else{echo strip_tags($objintro->f('page_content_sp'));}?>" />
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">

<title><?php if($lang == 'en'){echo $objintro->f('page_name');}else{echo $objintro->f('title_sp');}?></title>
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
		   
                   <div class="blue_boxr" style="text-align: center;">
			<?php if($num>0){?>
			<a href="<?php echo $obj_base_path->base_path(); ?>/blog/<?php echo $objprev->f('page_id');?>/<?php echo str_replace(" ","-",$objprev->f('page_name'));?>/<?php echo $lang;?>"><< Previous</a>
			<?php } ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			
			
			<?php if($lang == 'en'){echo $objintro->f('page_name');}else{echo $objintro->f('title_sp');}?>
			
			
			&nbsp;&nbsp;&nbsp;&nbsp;
			
			<?php if($num1>0){?>
			<a href="<?php echo $obj_base_path->base_path(); ?>/blog/<?php echo $objnext->f('page_id');?>/<?php echo str_replace(" ","-",$objnext->f('page_name'));?>/<?php echo $lang;?>">Next >></a>
			<?php } ?>
                   </div>
		   <?php //} ?>
		 </div>
		 <div class="clear"></div>
                 <div class="Tchai_box" style="width: auto;"> 
                        <?php if($lang == 'en'){echo $objintro->f('page_content');}else{echo $objintro->f('page_content_sp');} ?>
                  </div>
		 
                </div>
               <div class="clear"></div>
			
			<?php if($objintro->f('social')==1){?>
			<div style="margin: 4px;float:left;padding: 5px;">

			<?php $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
			
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=149448255219243";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-share-button" data-href="<?php echo $url;?>" data-type="box_count"></div>
			
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url;?>" data-via="your_screen_name" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
			
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
			<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone" data-size="tall"></div>
			
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/platform.js';
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
