<?php
//create object
$obj_admin=new admin;


$obj_location=new admin;
$obj_location->getVenue();
$obja=new admin;
$obja->api_show();
$obja->next_record();	


?>
<script>
function selectLocation(loc){
	document.getElementById("loc").innerHTML=loc;
	
	
}
</script>
 <!--start head-->
		<header id="header">
			<div class="header">
              <div class="wrapper">
           	    <div class="header_left">
               	<a href="<?php echo $obj_base_path->base_path(); ?>/" class="logo"></a>
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
                           <li class="dc">
                                <a href="#" class="here">My TicketHYPE</a>
                                <ul>
                                    <li style="background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_yellowbg.png) left top no-repeat; padding-top:4px;">
                                    <a href="<?php echo $obj_base_path->base_path(); ?>/login"  style="line-height:14px; height:34px; background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_yellowbg.png) left center no-repeat;">Pick up My <br>Tickets ></a></li>
                                    <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin" style="background: url(<?php echo $obj_base_path->base_path(); ?>/images/dropdown_menubg.png) 1px center no-repeat;">Ticket Admin ></a></li>
                               </ul>
                            </li>
                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/ticketing_solutions/home">Ticketing Solutions</a></li>
                            <li><a href="#">Retail Outlets</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="http://www.facebook.com/tickethype" target="_blank" style="padding:0px !important;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_icon.gif" alt="" width="20" height="20" style="margin:5px 10px;"/></a></li>
                            <li><a href="http://twitter.com/tickethype" target="_blank" style="padding:0px !important;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_icon.gif" alt="" width="20" height="20" style="margin:5px 0;"/></a></li>
                        </ul>
                    </div>
                    <div class="search_box">
                        <!--<input type="text" name="textfield" class="textfield" value="Enter Artist, Team or Venue"/>
                        <input type="submit" name="Submit" class="btnbg" value="Search" />-->
                   
                   <form method="post" action="<?php echo $obj_base_path->base_path(); ?>/admin/events">
                        <ul>
                        <li><input type="text" name="keyword" class="textfield" value="Enter Event"  onfocus="javascript:if(this.value=='Enter Event') {this.value='';}" onblur="javascript:if(this.value=='') {this.value='Enter Event'}" /></li>
                        <li><input type="submit" name="Submit" class="btnbg" value="Search" /></li>
                        </ul>
                    </form>
                    </div>
                </div>
              </div>
                <div class="clear"></div>
                <div class="wrapper" style="margin:15px 0 0px 0;">
                	<img src="<?php echo $obj_base_path->base_path(); ?>/files/home_banner/<?php echo $obja->f('topbanner_image');?>" alt="" class="left">
                    <a href="<?php echo $obj_base_path->base_path(); ?>/register"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add_02.png" alt="" class="right"></a>
                </div>
              <div class="clear"></div>
            </div>
		</header>
		<!--end head-->