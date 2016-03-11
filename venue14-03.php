<?php
include('include/user_inc.php');
$venue_id = $_REQUEST['venue_id'];

//create object

$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;


// Venue Details
$obj_venue->venue_details_venueid($venue_id);
$obj_venue->next_record();


//print_r($_SESSION);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venue</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
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
                        
                        <div class="map_box" style="height:325px;">
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
													alert(point);
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
									
							</script>
                        	<div id="map" class="map_class" style=""></div>    
                        </div>
                        <div class="clear"></div>
                      </div>
                      <div class="rightpart" style="width: 344px;">
                        
                        
						<div class="clear"></div>
                        <div class="like_box" style=" margin: 0 0 10px 0;">
                    	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                              <tr>
                                <td style="padding: 0;"><div class="like_textbox bg1"><input name="" type="text" value="104" /></div></td>
                                <td><div class="like_textbox bg2"><input name="" type="text" value="75" /></div></td>
                                <td><div class="like_textbox bg3"><input name="" type="text" value="4" /></div></td>
                                <td><div class="like_textbox bg4"><input name="" type="text" value="2" /></div></td>
                                <td><div class="like_textbox bg5"><input name="" type="text" value="2054" /></div></td>
                              </tr>
                              <tr>
                                <td style="padding: 0;"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img1.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img2.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img3.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img4.gif" border="0" /></a></td>
                                <td><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/like_img5.gif" border="0" /></a></td>
                              </tr>
                           </table>	
						</div>
						<div class="clear"></div>		
                        <div class="offer_box" style="float: left; margin: 0; width:100%;">                       
                       	 <div class="preview_imgbox" style="float: left; width: 100%;">
                         <div class="imgbox" style="width:100%; height: auto;">
                            <ul>
                            <!--<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_img1.gif" border="0" /></li>-->
                         	  
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
			<div class="left_panel addbox">
            <div class="add1"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add1.gif" border="0" /></a></div>
          </div>
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
