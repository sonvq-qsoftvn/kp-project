<?php
//create object
$obj_admin=new admin;
$admin_id=$_SESSION['ses_user_id'];

//get admin detail
$obj_admin->getAdminById($admin_id);
$obj_admin->next_record();

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

function add_button_function_vip(){
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/vip";
}
function add_bottle(){
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/addBottle";
}
function add_button_function_category(){
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/addCategory";
}
function add_button_function(){
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/event";
}

function add_coupon_function() {
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/coupon"
}

function add_template() {
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/scheme"
}

function update_template() {
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/customize"
}

function qs_template() {
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/question"
}

function add_question_function()
{
window.location = "<?php echo $obj_base_path->base_path(); ?>/admin/question";
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
                <div class="wrapper" style="margin:15px 0 20px 0;">
                	<img src="<?php echo $obj_base_path->base_path(); ?>/files/home_banner/<?php echo $obja->f('topbanner_image');?>" alt="" class="left">
                    <a href="<?php echo $obj_base_path->base_path(); ?>/gateway-setup"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add_02.png" alt="" class="right"></a>
                </div>
              <div class="clear"></div>
            </div>
		</header>
		<!--end head-->
        
        <section id="admin_nav">
			<div class="admin_nav">
            <ul class="admin_nav_left1">
                   <li style="margin:14px 0;"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/admin_icon.gif" alt="" width="49" height="49"></a></li>
                   <li style="margin: 24px 0 0 10px;"><?php echo $obj_admin->f('fname')." ".$obj_admin->f('lname');?><br/><span>Account Owner</span></li>
                   <li style="margin: 44px 0 0 18px;"><span class="english">English (United States) EDT (-04:00)</span></li>
			</ul>
            <div style="margin-top: 35px;" class="admin_nav_right">
		  <ul>
		  <li style="width: 120px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/hide_icon.png" alt="" width="19" height="19"><a href="javascript:void(0);" id="hide_help"> Hide Guide</a><a href="javascript:void(0);" id="show_help" style="display:none;"> Show Guide</a></li>
		  <li style="width: 80px;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/help_icon.png" alt="" width="19" height="19"><a href="<?php echo $obj_base_path->base_path(); ?>/contact">Help</a></li>
		  <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/logout.png" alt="" width="28" height="19"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/logout">Logout</a></li>
		  </ul>
		  </div>          	             
          </div>
      </section>