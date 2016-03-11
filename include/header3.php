<?php
$obj_location=new user;
$obj_location->getVenue();

?>

<header id="header">
			<div class="header">
              <div class="wrapper">
           	    <div class="header_left">
               	<a href="javascript:void(0)" class="logo" onclick="javascript:location.href='<?php echo $obj_base_path->base_path(); ?>/'"></a>
                <div class="clear"></div>
                 <div class="styled_select" style="width:211px; float:left;">
                  <select name="selectLoc" id="select" style="width:231px;" onchange="selectLocation(this.value)">
                    <?php while($loc_row = $obj_location->next_record())
								{?>
                    <option value="<?php echo $obj_location->f('venue_city')?>"><?php echo $obj_location->f('venue_city')?></option>
                    <?php }?>
                  </select>
                  </div>
                   <div class="orlando" id="loc">Orlando</div>
                </div>
                <div class="header_right">
                	<div class="top_menu">
                        <ul>
                            <li class="dc"><a href="#" class="here">My TicketHYPE</a>
							<ul>
                                  <li style="background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_yellowbg.png) left top no-repeat; padding-top:4px;">
                                    <a href="<?php echo $obj_base_path->base_path(); ?>/login"  style="line-height:14px; height:34px; background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_yellowbg.png) left center no-repeat;">Pick up My <br>Tickets ></a></li>
                                    <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin" style="background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_menubg.png) 1px center no-repeat;">Ticket Admin ></a></li>
                               </ul>
							</li>
                            <li  class="dc"><a href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/home" <?php if ($_SESSION['ses_page_name']=='ticket-solution.php') echo 'class="here"';?>>Ticketing Solutions</a></li>
                            <li><a href="#">Retail Outlets</a></li>
                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/contact" <?php if ($_SESSION['ses_page_name']=='contact.php') echo 'class="here"';?>>Contact Us</a></li>
                            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_icon.gif" alt="" width="20" height="20" style="margin:5px 10px;"/></li>
                            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_icon.gif" alt="" width="20" height="20" style="margin:5px 0;"/></li>
                        </ul>
                    </div>
                    <?php if ($_SESSION['ses_page_name']!='content.php'){?>
<div class="clear"></div>
<form name="frm_search" method="post" action="<?php echo $obj_base_path->base_path(); ?>/search">
<div class="search_box">
<ul>
<li><input name="search_text" type="text" class="textfield" id="search_text" onfocus="javascript:if(this.value=='Enter Artist, Team, or Venue') {this.value='';}" onblur="javascript:if(this.value=='') {this.value='Enter Artist, Team, or Venue'}" value="<?php if ($_REQUEST['search_text']) echo $_REQUEST['search_text']; else { ?>Enter Artist, Team, or Venue<?php }?>"/></li>
<li><input type="submit" name="Submit" class="btnbg" value="Search" /></li>
</ul>
</div>
</form>
<?php }?>
                </div>
              </div>
                <div class="clear"></div>
                <div class="wrapper" style="margin:15px 0 20px 0;">
                	<img src="<?php echo $obj_base_path->base_path(); ?>/images/add_01.png" alt="" class="left">
                    <a href="<?php echo $obj_base_path->base_path(); ?>/register"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add_02.png" alt="" class="right" usemap="#Map"></a>
                    <map id="Map" name="Map">
                    <area href="<?php echo $obj_base_path->base_path(); ?>/admin/event" coords="126,64,245,94" shape="rect">
                    </map>

                </div>
              <div class="clear"></div>
            </div>
		</header>
		
		<section id="main_nav">
			<div class="main_nav" style="width:990px;">
            	<ul class="main_nav_left" style="width:990px;" >
                	<li><a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/event_management">event management </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/vip_management">vip management </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/branding_customization">branding & customization</a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/admissions">admissions </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/box_office"> box office </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/marketing_promotion"> marketing & promotions</a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/checkout">checkout </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/reporting">reporting  </a>|<a  style="padding:0 1px;" href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/support">support</a></li>
                </ul>
            	                
            </div>
      </section>
	  <div class="clear"></div>	
	  <script>
	  function selectLocation(loc){
	document.getElementById("loc").innerHTML=loc;
	
	
}
	  </script>
      
      
  