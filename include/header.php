<?php
$obj_location=new user;
$obj_cat=new user;
$objlist_num=new user;
$obj_add_newsletter=new user;
$obja=new user;
$obja->api_show();
$obja->next_record();	
$obj_location->getVenue();

if(isset($_POST['Submit2'])){
$email = $_POST['email'];
if($email!="" || $email != "Enter your email address"){
if($obj_add_newsletter->add_contact($email))
{
$msg = "Thank you for join us.";
}else{
$msg = "An error occured. Try again letter.";
}
}
}
 
?>


<header id="header">
			<div class="header">
              <div class="wrapper">
           	    <div class="header_left">
               	<a href="<?php echo $obj_base_path->base_path(); ?>/" class="logo" onclick="javascript:location.href='<?php echo $obj_base_path->base_path(); ?>/'"></a>
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
                            <li><a href="http://www.facebook.com/tickethype" target="_blank" style="padding:0px !important;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_icon.gif" alt="" width="20" height="20" style="margin:5px 10px;"/></a></li>
                            <li><a href="http://twitter.com/tickethype" target="_blank" style="padding:0px !important;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_icon.gif" alt="" width="20" height="20" style="margin:5px 0;"/></a></li>
                        </ul>
                    </div>
                    <?php if ($_SESSION['ses_page_name']!='content.php'){?>
<div class="clear"></div>
<?php
$action=str_replace("/lang/spn","",$obj_base_path->base_path());
$action=str_replace("/lang/eng","",$obj_base_path->base_path());
?>
<form name="frm_search" method="post" action="<?php echo $action; ?>/search">
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
				 <ul>
                	
                	<li>
                   
                    	<a href="<?php echo $obja->f('topbanner_link');?>" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/files/home_banner/<?php echo $obja->f('topbanner_image');?>" alt="" class="left"></a>
                       
                     </li>
				 </ul>
                    <a href="<?php echo $obj_base_path->base_path(); ?>/gateway-setup"><img src="<?php echo $obj_base_path->base_path(); ?>/images/add_02.png" alt="" class="right" usemap="#Map"></a>
                    <map id="Map" name="Map">
                    <area href="<?php echo $obj_base_path->base_path(); ?>/admin/event" coords="126,64,245,94" shape="rect">
                    </map>

                </div>
              <div class="clear"></div>
            </div>
		</header>
		
		<section id="main_nav">
			<div class="main_nav">
            	<ul class="main_nav_left" style="width:530px;">
                	<!--<li><a href="<?php echo $obj_base_path->base_path(); ?>/search-results/Concert">Concerts</a>|</li>
					<li><a href="<?php echo $obj_base_path->base_path(); ?>/search-results/Sporting">Sports</a>|</li>
					<li><a href="<?php echo $obj_base_path->base_path(); ?>/search-results/Other">Theater</a>|</li>
					<li><a href="<?php echo $obj_base_path->base_path(); ?>/search-results/Party">Events</a>|</li>-->
                    <?php 
						$obj_cat->event_category_list(1);
						while($obj_cat->next_record()){
					?>
					<li><a href="<?php echo $obj_base_path->base_path(); ?>/searchEventCat?cat=<?php echo $obj_cat->f('category_id'); ?>"><?php echo $obj_cat->f('category_name'); ?></a>|</li>
					<?php  }?>
                    
                </ul>
				<form name="newsletter_frm" id="newsletter_frm" action="" method="post">
            	<ul class="main_nav_right">
                    <li class="right_align">SIGN UP FOR <br/>OUR NEWSLETTER !</li>
                    <li><input name="email" id="email" type="text" class="textfield1" value="Enter your email address" onfocus="JAVASCRIPT:if (this.value == 'Enter your email address') {this.value = '';}
" onblur="JAVASCRIPT:if (this.value == '') { this.value = 'Enter your email address';}" />
                  </li>
                    <li><input type="submit" name="Submit2" class="btnbg2" value="GO!"/></li>
                </ul>
				</form>                
            </div>
      </section>
	  <div class="clear"></div>	
	  <script>
	  function selectLocation(loc){
	document.getElementById("loc").innerHTML=loc;
	
	
	}
	  </script>