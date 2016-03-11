<?php
include('include/user_inc.php');
$language=$_REQUEST['lang'];
$actual_link_en=$obj_base_path->base_path().'/event_fb_share/'.$language;
$actual_link_es=$obj_base_path->base_path().'/evento_fb_cuota/'.$language;
echo "hello";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if($language=='en')
{
?>
	<meta itemscope itemtype="http://schema.org/Article" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="Check Test For English" />
	<meta name="title" content="Check Test For English" />
	<meta property="og:url" content="<?php echo $actual_link_en; ?>" />
	<meta itemprop="description" content="HEllo,Welcome to facebook.this is for facebook share cheking in english language." />
	<meta property="og:description" content="HEllo,Welcome to facebook.this is for facebook share cheking in english language." />
	<!--<meta name="description" content="HEllo,Welcome to facebook.this is for facebook share cheking in english language." />-->
	<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">
	<!--<meta itemprop="description" content="HEllo,Welcome to facebook.this is for facebook share cheking in english language.">-->
			      
<?php
}
else
{
?>
	<meta itemscope itemtype="http://schema.org/Article" />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="Compruebe Test For Inglés" />
	<meta name="title" content="Compruebe Test For Inglés" />
	<meta property="og:url" content="<?php echo $actual_link_es; ?>" />
	<meta itemprop="description" content="Hola, Bienvenido a facebook.this es para cheking cuota facebook en idioma Inglés." />
	<meta property="og:description" content="Hola, Bienvenido a facebook.this es para cheking cuota facebook en idioma Inglés." />
	<meta name="description" content="Hola, Bienvenido a facebook.this es para cheking cuota facebook en idioma Inglés." />
	<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">
<?php
}
?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                              <tr><td>
					<div style="margin: 4px;float:left;padding: 5px;">
					
					<?php $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					echo "url= ".$url;
					?>
					<?php if($language=='en')
					 {
						 $lang="en_US";
					 }
					else 
					 {
						$lang="es_ES";
						
					 }
					 
					 ?>
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/<?=$lang?>/all.js#xfbml=1&appId=1411675195718012";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					
					<div class="fb-share-button" data-href="<?php echo $url;?>" data-type="box_count" ></div>
				
			      <div class="g-plusone" data-size="tall"  lang="<?=$lang?>"></div>
							    <script type="text/javascript">
							    
							    (function() {
							    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							    po.src = 'https://apis.google.com/js/plusone.js';
							    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							    })();
							    </script>		 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					</div>
					</td>
                              </tr>
                          </table>
</body>