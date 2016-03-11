<?php
include('include/user_inc.php');
$venue_id = $_REQUEST['venue_id'];
$venue_name = $_REQUEST['venue_name'];

//create object

$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;
$objCommon = new Common();
$objVenueLocation = new user;



$objVenueLocation->getVenueLocationByVenueID($venue_id);
$objVenueLocation->next_record(); 

// Venue Details
$obj_venue->venue_details_venueid($venue_id);
$obj_venue->next_record();

//================================  for meta==================== 

$objvenue_category=new user;     
$objvenue_category->getCategorByVenue($venue_id);
$objvenue_category->next_record();

if($_SESSION['langSessId']=='eng')
	$_SESSION['set_lang_venue'] = 'en';
else
	$_SESSION['set_lang_venue'] = 'es';



if($_REQUEST['lang']=="")
{
	
	if($_SESSION['langSessId']=='eng')
	{
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'en'));
		exit;
	}
	else{
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'sp'));
		exit;
	}
	
}
else if($_REQUEST['lang']!="" && $_REQUEST['lang']!=$_SESSION['set_lang_venue'])
{
	if($_SESSION['langSessId']=='eng')
	{
		$_SESSION['set_lang_venue'] = 'en';
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'en'));
		exit;
	}
	else{ 
		$_SESSION['set_lang_venue'] = 'es';
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'sp'));
		exit;
	}
	
}

if (!isset($_REQUEST['state_name']) || !isset($_REQUEST['county_name']) || !isset($_REQUEST['city_name'])) {

	if($_SESSION['langSessId']=='eng')
	{
		$_SESSION['set_lang_venue'] = 'en';
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'en'));
		exit;
	}
	else{ 
		$_SESSION['set_lang_venue'] = 'es';
		header("location: ".$obj_base_path->base_path(). $objCommon->getCleanVenueURL($venue_id, $objVenueLocation, 'sp'));
		exit;
	}
}

/*-----------------------------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta itemscope itemtype="http://schema.org/Article" /><!---------FOR G+ DESCRIPTION SHARE--------->

<title><?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_venue->f('venue_name'))); } else { echo htmlentities(stripslashes($obj_venue->f('venue_name_sp')));}?></title>
<meta charset="utf-8">
<meta name="title" content="<?php if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_venue->f('venue_name'))); } else { echo htmlentities(stripslashes($obj_venue->f('venue_name_sp')));}?>">
<meta name="keywords" content="<?php  if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($objvenue_category->f('category_name'))); } else { echo htmlentities(stripslashes($objvenue_category->f('category_name_sp')));}?>">
<meta name="description" content="<?php  if($_SESSION['langSessId']=='eng') { echo htmlentities(stripslashes($obj_venue->f('venue_short_add_en'))); } else { echo htmlentities(stripslashes($obj_venue->f('venue_short_add_sp')));}?>">


<!---------------------------------------------------------------------------------------->

<!------------------------------------FOR ENGLISH VENUE SHARE START----------------------------------------------->
<?php
if($_REQUEST['lang']=='en')
{
	
?>
	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' /> <!--app id : 1411675195718012--->
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?> <!--- THIS IS THE FB:URL echo "actual_link= ".$actual_link; -->
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="<?php  echo htmlentities(stripslashes($obj_venue->f('venue_name')));?>" />
	<meta name="title" content="<?php  echo htmlentities(stripslashes($obj_venue->f('venue_name')));?>" />
	<meta property="og:url" content="<?php echo $actual_link; ?>" />
	<meta itemprop="description" content="<?php echo htmlentities(stripslashes($obj_venue->f('venue_short_add_en')));?>" />
	<meta property="og:description" content="<?php echo htmlentities(stripslashes($obj_venue->f('venue_short_add_en')));?>" />
	
<?php
}

/*----------------------------------- FOR ENGLISH VENUE SHARE END-----------------------------------------------------*/

/*------------------------------------FOR SPANISH VENUE SHARE START-----------------------------------------------------*/
else
{
	
?>
	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"   /> <!---"charset=iso-8859-1" for English, Spanish, French, German, etc.-->
	<meta property='fb:app_id' content='1411675195718012' />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?> <!--- THIS IS THE FB:URL echo "actual_link= ".$actual_link; -->
	<meta property='og:site_name' content='Kpasapp' />
	<meta property="og:title" content="<?php  echo htmlentities(stripslashes($obj_venue->f('venue_name_sp')));?>" />
	<meta name="title" content="<?php  echo htmlentities(stripslashes($obj_venue->f('venue_name_sp')));?>" />
	<meta property="og:url" content="<?php echo $actual_link; ?>" />
	<meta itemprop="description" content="<?php echo htmlentities(stripslashes($obj_venue->f('venue_short_add_sp')));?>" />
	<meta property="og:description" content="<?php echo htmlentities(stripslashes($obj_venue->f('venue_short_add_sp')));?>" />
<?php
}
?>


<!------------------------------------FOR SPANISH VENUE SHARE START-------------------------------------------------------->


<?php if($obj_venue->f('venue_image')==''){?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/images/kpassa_logo_fb.png">

<?php
}
else
{
?>
<meta property="og:image" content="<?php echo $obj_base_path->base_path(); ?>/files/venue/large/<?php echo $obj_venue->f('venue_image');?>"/>
<?php
}
?>

<!---------------------------------------------------------------------------------------->


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

</head>
<body>
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg">
            	<div class="cheese_box">
                	<div class="heading"><?php if($_SESSION['langSessId']=='eng') { echo $obj_venue->f('venue_name'); } else { echo $obj_venue->f('venue_name_sp');}?></div>
                    <div class="clear"></div>
                	<div class="map_ticket">
                      <div class="leftpart" style="width: 338px;">
                        <div class="time_reviews_box">
                            
                            <div class="reviews_box">
                                <div class="left_option"><?=REVIEWS?> (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                                <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div style="margin:10px 0 20px; font-weight:bold;">
                        	<p><?php echo $obj_venue->f('venue_address');?></p>
                         	<p><?php echo $obj_venue->f('city').', '.$obj_venue->f('st_name');?></p>
                        </div>
                        <div style="margin:10px 0 20px;">
                            <p><?php if($_SESSION['langSessId']=='eng') { 
                                        echo stripslashes(substr($obj_venue->f('venue_short_add_en'),0,126)); } 
                                    else { 
                                        echo stripslashes(substr($obj_venue->f('venue_short_add_sp'),0,126)); } 
                                        ?>
                            </p>
                        </div>
                        
                        <?php $add = $obj_venue->f('venue_name').", ".$obj_venue->f('venue_address').", ".$obj_venue->f('city').", ".$obj_venue->f('st_name'); ?>
						
			<div class="clear"></div>			
                        <div class="map_box" style="height:339px;">
			
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>			
<script>
      
    <?php
      $Address = urlencode($add);
      $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
      $xml = simplexml_load_file($request_url) or die("url not loading");
      $status = $xml->status;
      if ($status=="OK") {
          //$Lat = $xml->result->geometry->location->lat;
         // $Lon = $xml->result->geometry->location->lng;
	 $Lat = $obj_venue->f('venue_lat');
	 $Lon = $obj_venue->f('venue_long');
          $LatLng = $Lat.",".$Lon;
      }
    ?>
 
      
var map;
var TILE_SIZE = 256;
var chicago = new google.maps.LatLng(<?php echo $LatLng;?>);

function bound(value, opt_min, opt_max) {
  if (opt_min != null) value = Math.max(value, opt_min);
  if (opt_max != null) value = Math.min(value, opt_max);
  return value;
}

function degreesToRadians(deg) {
  return deg * (Math.PI / 180);
}

function radiansToDegrees(rad) {
  return rad / (Math.PI / 180);
}

/** @constructor */
function MercatorProjection() {
  this.pixelOrigin_ = new google.maps.Point(TILE_SIZE / 2,
      TILE_SIZE / 2);
  this.pixelsPerLonDegree_ = TILE_SIZE / 360;
  this.pixelsPerLonRadian_ = TILE_SIZE / (2 * Math.PI);
}

MercatorProjection.prototype.fromLatLngToPoint = function(latLng,
    opt_point) {
  var me = this;
  var point = opt_point || new google.maps.Point(0, 0);
  var origin = me.pixelOrigin_;

  point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;

  // Truncating to 0.9999 effectively limits latitude to 89.189. This is
  // about a third of a tile past the edge of the world tile.
  var siny = bound(Math.sin(degreesToRadians(latLng.lat())), -0.9999,
      0.9999);
  point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) *
      -me.pixelsPerLonRadian_;
  return point;
};

MercatorProjection.prototype.fromPointToLatLng = function(point) {
  var me = this;
  var origin = me.pixelOrigin_;
  var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
  var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
  var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) -
      Math.PI / 2);
  return new google.maps.LatLng(lat, lng);
};

function createInfoWindowContent() {
  var numTiles = 1 << map.getZoom();
  var projection = new MercatorProjection();
  var worldCoordinate = projection.fromLatLngToPoint(chicago);
  var pixelCoordinate = new google.maps.Point(
      worldCoordinate.x * numTiles,
      worldCoordinate.y * numTiles);
  var tileCoordinate = new google.maps.Point(
      Math.floor(pixelCoordinate.x / TILE_SIZE),
      Math.floor(pixelCoordinate.y / TILE_SIZE));

}

function initialize() {
  var mapOptions = {
    zoom: 15,
    center: chicago
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  //var coordInfoWindow = new google.maps.InfoWindow();
  //coordInfoWindow.setContent(createInfoWindowContent());
  //coordInfoWindow.setPosition(chicago);
  //coordInfoWindow.open(map);

  //google.maps.event.addListener(map, 'zoom_changed', function() {
  //  coordInfoWindow.setContent(createInfoWindowContent());
  //  coordInfoWindow.open(map);
  //});
  
  var marker = new google.maps.Marker({
      position: chicago,
      map: map,
      title: ''
  });
  
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div id="map-canvas" style="height: 100%; width: 100%;"></div>

			
<!-- removed from here -->				
			<iframe class="alignleft" scrolling="no" frameborder="0" style="border:0px;margin-right:5px;padding:0px;" src="<?php //echo $obj_base_path->base_path().'/google_map.php?add='.$add;?>" width="100%" height="100%"></iframe>
                            <script type="text/javascript">
								 	var map = null;
									var geocoder = null;
								
									function initialize(add) {
										if (GBrowserIsCompatible()) {
											map = new GMap2(document.getElementById("map"));
											map.setCenter(new GLatLng(37.4419, -122.1419), 15);
											geocoder = new GClientGeocoder();
											var addressof=add;
											showAddress(addressof);
										}
									}
								
									function showAddress(address) {
									  if (geocoder) {
											geocoder.getLatLng(
												address,
												function(point) {
													if (!point) {
														alert(address + " not found");
													} else {
														map.setCenter(point, 15);
														var marker = new GMarker(point);
														map.addOverlay(marker);
														marker.openInfoWindowHtml(address + '<br /><div align="left" width="100%" style="margin:5px 0px 0px 10px;"><a style="color:#6a6a6a;" href="http://maps.google.com/maps?f=d&hl=en&geocode=&saddr=&daddr=' + address + '&ie=UTF8" target="_blank">Get directions</a></div>');
													}
												}
											);
										}
									}
									
							</script>                         <!--<div id="map" style="width:323px; height:325px; font-family: arial; font-size: 12px; color: #313E61; text-align: center; background-color:#FFFFFF;"></div>-->    
                        </div>
                        	<!--<div id="map" class="map_class" style=""></div>    
                        </div>-->
                        <div class="clear"></div>
                      </div>
                      <div class="rightpart" style="width: 344px;">
                        
                        
						<div class="clear"></div>
                        <div class="like_box" style=" margin: 0 0 10px 0;">
				
			<!----------------------------SOCIAL SHARE BUTTON  START--------------------------------------->
					<?php $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
									
					<?php if($_SESSION['langSessId']=='eng' || $_REQUEST['lang']=='en')
					 {
						 $lang="en_US";
					 }
					 else 
					 {
						$lang="es_ES";
					 }
					 
					 ?>
			        <div class="clear"></div>
			        <div id="fb-root"></div>
				<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/<?php echo $lang;?>/all.js#xfbml=1&appId=1411675195718012";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-share-button" data-href="<?php echo $url;?>" data-type="box_count"></div>
			
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url;?>" data-via="Kpasapp" data-lang="<?php echo $lang;?>" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
					
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
						<div class="clear"></div>		
                        <div class="offer_box" style="float: left; margin: 0; width:100%;">                       
                       	 <div class="preview_imgbox" style="float: left; width: 100%;">
                         <div class="imgbox" style="width:100%; height: auto;">
                            <ul>
                            <!--<li><img src="<?php //echo $obj_base_path->base_path(); ?>/images/preview_img1.gif" border="0" /></li>-->
                         	  
                            <?php if($obj_venue->f('venue_image')){  

							?>
                            	<li style="margin: 0; display: block;">
                                <a href="#feature_image" id="feature">
                                	<img src="<?php echo $obj_base_path->base_path(); ?>/files/venue/thumb/<?php echo $obj_venue->f('venue_image');?>"  border="0"  /></a>
                                </li>
					<script type="text/javascript">
						$(document).ready(function() {
						$("#feature").fancybox({ 
						'hideOnOverlayClick':false,
						'hideOnContentClick':false
						});
						});
					</script>
                                  <div style="display:none;">
                                  	<div style="width:auto;height:auto; background:#FFF; padding:10px;" id="feature_image">
                                    	<img src="<?php echo $obj_base_path->base_path(); ?>/files/venue/large/<?php echo $obj_venue->f('venue_image');?>"  border="0"  />
                                    </div>
                                  </div>
                            <?php } 
								
							  ?>
                            </ul>
                         </div>
                        </div>
					  </div>				
					  <div class="clear"></div>		
                      </div>
                    </div>
                    <div class="clear"></div>
                    <div class="show_box"> 
					                    
                      <div class="leftbox">
                       	<p style="min-height: 0; height: auto;"><?php if($_SESSION['langSessId']=='eng') { echo $obj_venue->f('venue_description'); } else { echo $obj_venue->f('venue_description_sp');}?></p>
                       </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="view_box">
                	<div class="heading"><?=SECTION1_TEXT;?></div>
                	<div class="hot_events">
                    
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="view_box" style="margin: 0;">
                	<div class="heading"><?=SECTION2_TEXT;?></div>
                    <div class="photo_count"><?=FAN_PHOTOS?> (39)</div>
                	<div class="hot_events2">
                    
                    </div>
                    <div class="clear"></div>
                    <div class="time_reviews_box" style="width: 652px; margin: 10px auto; float: none; overflow: hidden;">
                        <div class="reviews_box" style="margin: 5px 0 10px 0;">
                            <div class="left_option"><?=REVIEWS?> (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                            <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                        </div>
                        <div class="right_btn"><a href="#"><?=WRITE_REVIEW?></a></div>
                        <div class="clear"></div>        
                       <div class="dropdown3"><select name=""><option><?=CHOOSE_SORT_ORDER?> </option></select></div>         
                  </div>
                  <div class="clear"></div>
                  <div class="Tchai_box">
                  	<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div>

                    <div class="feature_btn"><a href="#"><?=FEATURED_REVIEW?></a></div>
                    <div class="clear"></div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,</p>
                  
                  
                    <div class="share_this">
                    	<ul>
                        	<li style="margin: 0 10px 0 0;"><?=SHARE_REVIEW?>:</li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon1.gif" border="0" /></a></li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon2.gif" border="0" /></a></li>
                        </ul>
                    </div>
                  </div>

                </div>
            </div>
        	  <?php include("include/frontend_rightsidebar.php");?>
		 <?php include("include/footer_bottom.php");?>
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	initialize('<?php echo $obj_venue->f('venue_address'); ?>,<?php echo $obj_venue->f('city'); ?>,<?php echo $obj_venue->f('st_name'); ?>');
	
	//initialize('city center,salt lake ,kolkata ,west bengal');
	//initialize('<?php echo $obj_venue->f('city'); ?>,<?php echo $obj_venue->f('st_name'); ?>');
})
</script>

</body>
</html>
