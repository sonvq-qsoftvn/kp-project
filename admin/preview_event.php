<?php
// home page
session_start();
include('../include/admin_inc.php');

$event_id = $_REQUEST['event_id'];

//create object
$objEvent=new admin;
$obj_venue=new admin;
$obj_ticket=new admin;

// Event Details
$objEvent->getEventById($event_id);
$objEvent->next_record();

// Venue Details
$obj_venue->venue_details_eventId($event_id);
$obj_venue->next_record();

// Event Date
list($event_date,$event_time) = explode(" ",$objEvent->f('event_start_date_time'));
list($event_date_end,$event_time_end) = explode(" ",$objEvent->f('event_end_date_time'));

// Get tickets by Event ID
$obj_ticket->getTicketById($event_id); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Privew Event</title>
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

<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
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
                	<div class="heading"><?php echo $objEvent->f('event_name_en')?></div>
                    <div class="clear"></div>
                	<div class="map_ticket">
                    	<div class="leftpart">
                        	<div class="time_reviews_box">
                            	<div class="timetxt"><?php echo date("D",strtotime($event_date))." ".date("M",strtotime($event_date))." ".date("d",strtotime($event_date)).", ".date("Y",strtotime($event_date));?> - <?php echo date('g:i a',strtotime($event_time)); ?> to <?php echo date('g:i a',strtotime($event_time_end)); ?></div>
                                <div class="reviews_box">
                                	<div class="left_option">Reviews (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                                    <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                                </div>
                            </div>
                        	<div class="map_box">
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
									
							</script>
                           <div id="map" style="width:323px; height:251px; font-family: arial; font-size: 12px; color: #313E61; text-align: center; background-color:#FFFFFF;"></div>
    
                            </div>
                        </div>
                        <div class="rightpart">
                        	<div class="select_box1">
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="select_table1">
                                  <tr>
                                    <td colspan="4"><div class="heading">Select Tickets </div></td>
                                  </tr>
                                  <?php 
								  	if($obj_ticket->num_rows()){
										while($obj_ticket->next_record()){
								  ?>
                                  <tr>
                                    <td>
                                    	<div class="dropdown2"><select name="">
                                        <?php for($i=1;$i<=$obj_ticket->f('ticket_num');$i++) {?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php } ?>
                                        </select></div>
                                    </td>
                                    <td><?php echo $obj_ticket->f('ticket_name_en'); ?></td>
                                    <td><a href="#showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>" id="ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    	<img src="<?php echo $obj_base_path->base_path(); ?>/images/select_table_img1.png" border="0" /></a></td>
                                    <td><div class="amount_btn">$<?php echo $obj_ticket->f('price_us'); ?></div></td>
                                  </tr>
                                  <script type="text/javascript">
									$(document).ready(function() {
										$("#ticket_des<?php echo $obj_ticket->f('ticket_id'); ?>").fancybox({ 
										'hideOnOverlayClick':false,
										'hideOnContentClick':false
										});
									});
								  </script>
                                  <div style="display:none;">
                                  	<div style="width:500px; height:auto; background:#FFF;" id="showticketdes<?php echo $obj_ticket->f('ticket_id'); ?>">
                                    	<?php echo $obj_ticket->f('description_en'); ?>
                                    </div>
                                  </div>
                                  <?php
										}
									}
									else{
								  ?>
                                   <tr>
                                    <td colspan="4" style="margin:0 0 0 10px;">No tickets available</td>
                                  </tr>
                                  <?php } ?>
                                  
                                </table>
                        	</div>
                        	<div class="select_box2">
                            	<div class="buy_btn"><?php  if($obj_ticket->num_rows()){?><a href="#">Buy</a><?php } ?></div>
                                <div class="icon_link">
                                	<ul>
                                    	<li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon1.gif" border="0" /></a></li>
                                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon2.gif" border="0" /></a></li>
                                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon3.gif" border="0" /></a></li>
                                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon4.gif" border="0" /></a></li>
                                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon5.gif" border="0" /></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="like_box" style=" margin: 0 ;">
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
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="show_box">
                     <div class="offer_box">
                       <div class="leftbox">
                       	<p><?php echo (stripslashes($objEvent->f('event_details_en')));?></p>
                       </div>
                       <div class="preview_imgbox">
                        <div class="imgbox">
                            <ul>
                                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_img1.gif" border="0" /></li>
                                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_img2.gif" border="0" /></li>
                                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/preview_img3.gif" border="0" /></li>
                            </ul>
                        </div>
                        <p>Art Walk San Jose de Cabo</p>
                        </div>
					  </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="view_box">
                	<div class="heading">Users who viewed this event also viewed</div>
                	<div class="hot_events">
                    
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="view_box" style="margin: 0;">
                	<div class="heading">Fan Reviews and Photos</div>
                     <div class="photo_count">Fan Photos (39)</div>
                	<div class="hot_events2">
                    
                    </div>
                    <div class="clear"></div>
                    <div class="time_reviews_box" style="width: 652px; margin: 10px auto; float: none; overflow: hidden;">
                        <div class="reviews_box" style="margin: 5px 0 10px 0;">
                            <div class="left_option">Reviews (899)<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div></div>
                            <div class="right_option"><div class="dropdown1"><select name=""><option>4.6 / 5</option></select></div></div>
                        </div>
                        <div class="right_btn"><a href="#">Write a review</a></div>
                        <div class="clear"></div>        
                       <div class="dropdown3"><select name=""><option>Choose a sort order </option></select></div>         
                  </div>
                  <div class="clear"></div>
                  <div class="Tchai_box">
                  	<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div>
                    <div class="headtxt">Tchaikovsky was Great</div>
                  	<p>Hollywood Bowl - Hollywood, CA - Fri, Sep 7 2012</p>
                    <p>Posted 09/18/2012 by <strong>EKHO1</strong> <a href="#">this Fan's Reviews</a></p>
                    <div class="feature_btn"><a href="#">Featured Review</a></div>
                    <div class="clear"></div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,</p>
                    <p><strong>Favorite moment: </strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br />Aenean commodo ligula eget dolor. </p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <span><a href="#">Yes</a> | <a href="#">No</a> </span> <span style="margin: 0 10px;"><a href="#">(Report as inappropriate)</a></span></p>
                    <div class="share_this">
                    	<ul>
                        	<li style="margin: 0 10px 0 0;">Share this review:</li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon1.gif" border="0" /></a></li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon2.gif" border="0" /></a></li>
                        </ul>
                    </div>
                  </div>
                  <div class="Tchai_box">
                  	<div class="reviews"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/ster_review.png" border="0" /></a></div>
                    <div class="headtxt">Tchaikovsky was Great</div>
                  	<p>Hollywood Bowl - Hollywood, CA - Fri, Sep 7 2012</p>
                    <p>Posted 09/18/2012 by <strong>EKHO1</strong> <a href="#">this Fan's Reviews</a></p>
                    <div class="feature_btn"><a href="#">Featured Review</a></div>
                    <div class="clear"></div>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,</p>
                    <p><strong>Favorite moment: </strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <br />Aenean commodo ligula eget dolor. </p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. <span><a href="#">Yes</a> | <a href="#">No</a> </span> <span style="margin: 0 10px;"><a href="#">(Report as inappropriate)</a></span></p>
                    <div class="share_this">
                    	<ul>
                        	<li style="margin: 0 10px 0 0;">Share this review:</li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon1.gif" border="0" /></a></li>
                            <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/share_icon2.gif" border="0" /></a></li>
                        </ul>
                    </div>
                  </div>
                  <div class="page_box2">
               	 	<div class="pagination2">
                    	<ul>
                        	<li><a href="#" class="active">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">300</a></li>
                            <li><a href="#">Next</a></li>
                            <li><a href="#" style="color: #929292;"> >> </a></li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        	<div class="right_panel">
                <!--<div class="signupbox">
                    <div class="header">
					    <ul>
						    <li style="margin: 0 10px;"><a href="#">New User?</a></li>
							<li><a href="#">Register</a></li>
							<li> | </li>
							<li><a href="#">Sign In</a></li>
						</ul>
					</div>
                    <div class="fieldbox">
					    <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td><input name="" type="text" value="Your email" style="margin: 17px 0 0 0;" /></td>
						  </tr>
						  <tr>
							<td style="padding: 0;">Or</td>
						  </tr>
						  <tr>
							<td><input name="" type="text" value="Your cell for SMS" /></td>
						  </tr>
						  <tr>
							<td><input name="" type="text" value="City" /></td>
						  </tr>
						  <tr>
							<td><input name="" type="button" value="Go" class="go_btn" /></td>
						  </tr>
						</table>
					</div>
					<div class="upcoming_btn"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/upcoming_imgbtn.gif" border="0" /></a></div>
                </div>-->
                <div class="follow_box">
                	<div class="topbox">
                    	<h6>Follow us</h6>
                        <div class="quick_link">
                        	<ul>
                            	<li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg1.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg2.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg3.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg4.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg5.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg6.png" border="0" /></a></li>
                                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg7.png" border="0" /></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="timeline_box">
                        <div class="leftbox">
                            <ul>
                                <li><span class="per"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/timeline_img1.gif" border="0" /></a></span></li>
                                <li><span class="next"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/timeline_img2.gif" border="0" /></a></span></li>
                                <li>Your timeline</li>
                            </ul>
                        </div>
                        <div class="rightbox">
                            <ul>
                                <li><span class="per"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/previewimg.png" border="0" /></a></span></li>
                                <li> 4 of 10 </li>
                                <li><span class="next"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/nextimg.png" border="0" /></a></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="midbox">
                     <div class="imgbox"><img src="<?php echo $obj_base_path->base_path(); ?>/images/followimg1.gif" border="0" /></div>
                     <div class="right_txtbox">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div class="txt1"><span>Jeffrey Dhywood: </span>whats your take</div></td>
                            <td><span class="follow_num">55 </span></td>
                          </tr>
                          <tr>
                            <td colspan="2"><textarea name="" cols="" rows="">&nbsp;</textarea></td>
                          </tr>
                        </table>
                        <div class="tweet_btn"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/tweet_btn.gif" border="0" /></a></div>	
                    </div>
                    </div>
                </div>
            </div>
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
	initialize('<?php echo $obj_venue->f('city'); ?>+<?php echo $obj_venue->f('st_name'); ?>+<?php echo $obj_venue->f('venue_zip'); ?>');
})
</script>

</body>
</html>
