<script type="text/javascript">
function theRotator() {
	//Set the opacity of all images to 0
	$('div#rotator ul li').css({opacity: 0.0});
	
	//Get the first image and display it (gets set to full opacity)
	$('div#rotator ul li:first').css({opacity: 1.0});
		
	//Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
	setInterval('rotate()',6000);
	
}

function rotate() {	
	//Get the first image
	var current = ($('div#rotator ul li.show')?  $('div#rotator ul li.show') : $('div#rotator ul li:first'));

	//Get next image, when it reaches the end, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('div#rotator ul li:first') :current.next()) : $('div#rotator ul li:first'));	
	
	//Set the fade in effect for the next image, the show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
};

$(document).ready(function() {		
	//Load the slideshow
	theRotator();
});
</script>
<script type="text/javascript">
 $(document).ready(function() {
 	 $("#responsecontainer").load("<?php echo $obj_base_path->base_path(); ?>/pulse_feature.php").fadeIn("slow");
   var refreshId = setInterval(function() {
      $("#responsecontainer").load('<?php echo $obj_base_path->base_path(); ?>/pulse_feature.php?randval='+ Math.random());
   }, 7000);
   $.ajaxSetup({ cache: false });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#bottleservice").fancybox();
});
</script>
<?php 
//object
$obj_advertisement=new user;
?>
<div class="rightcol">
<div class="rightcol_box">
<div>
<p>Pulse<span>(Event)</span></p>
</div>
<div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="7" /></div>
<div class="right_box" id="responsecontainer">
</div>
<div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="7" /></div>
<div style="width: 274px; margin: 14px auto; float: none;"><a href="<?php echo $obj_base_path->base_path(); ?>/sell-tickets-online"><img src="<?php echo $obj_base_path->base_path(); ?>/images/SellYourTickets.jpg" alt="" width="274" height="136" border="0" usemap="#Map" /></a>
<map name="Map" id="Map"><area shape="rect" coords="122,96,292,246" href="<?php echo $obj_base_path->base_path(); ?>/sell-tickets-online" /></map></div>
<div class="clear"><img src="images/spacer.gif" alt="" width="1" height="8" /></div>
<div style="margin: 0 0 14px 0; float: none;">
<a href="<?php echo $obj_base_path->base_path(); ?>/bottleservice" id="bottleservice"><img src="<?php echo $obj_base_path->base_path(); ?>/images/bottleservice23.jpg" alt="" /></a>
<div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="2" /></div></div>
<div class="adv_box">
<p>ADVERTISEMENT</p>
</div>
<div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="2" /></div>
<div class="adv_box">
<div id="rotator"><ul>
  	<?php 
	//list of advertisement
	$obj_advertisement->list_advertisement();
	while($obj_advertisement->next_record()){
	?>
    <li class="show" style="opacity: 1; "><a href="<?php echo $obj_advertisement->f('url'); ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/files/advertisement/thumb/<?php echo $obj_advertisement->f('image'); ?>"  width="274" height="227" alt="<?php echo $obj_advertisement->f('advertisement_name'); ?>"></a></li>
	<?php } ?>
  </ul>
</div>
</div>
<div class="clear"><img src="<?php echo $obj_base_path->base_path(); ?>/images/spacer.gif" alt="" width="1" height="7" /></div>
<div class="buy_ticket">
<div style="width: 81px; float: left; margin: 4px 10px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/buy_with.gif" alt="" width="81" height="79" /></div>
<div style="width: 170px; float: right; margin: 4px 0;">
<p>TicketHype Fan Guarantee.<br /> 
<span>Have you heard about our new return and exchange policies?</span></p>
<p><a href="#">Learn More>></a></p>
</div>
</div>
</div>
</div>