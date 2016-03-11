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
                            <li><a href="#" class="here">My TicketHYPE</a>
							
							</li>
                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/ticketing_solutions/home" <?php if ($_SESSION['ses_page_name']=='ticket-solution.php') echo 'class="here"';?>>Ticketing Solutions</a></li>
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
                    <img src="<?php echo $obj_base_path->base_path(); ?>/images/add_02.png" alt="" class="right" usemap="#Map" alt="">
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
                	<li><a href="#">concerts</a>|<a href="#">sports</a>|<a href="#">theater</a>|<a href="#">events</a>|<a href="#">family</a></li>
                </ul>
            	<ul class="main_nav_right">
                    <li class="right_align">SIGN UP FOR <br/>OUR NEWSLETTER !</li>
                    <li><input name="textfield2" type="text" class="textfield1" value="Enter your email address"/>
                  </li>
                    <li><input type="submit" name="Submit2" class="btnbg2" value="GO!"/></li>
                </ul>                
            </div>
      </section>
	  <div class="clear"></div>	
	  <script>
	  function selectLocation(loc){
	document.getElementById("loc").innerHTML=loc;
	
	
}
	  </script>