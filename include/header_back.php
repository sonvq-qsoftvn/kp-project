<div id="header">
<!--<div class="logo"><a href="<?php echo $obj_base_path->base_path(); ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/logo.png" alt="" width="249" height="60" /></a></div>-->
<div class="headermid">
<ul>
<li><a href="<?php echo $obj_base_path->base_path(); ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/logo.png" alt="" width="249" height="60" /></a></li>
<li style="padding: 20px 0 0 70px;">
<?php 
$obj_user=new user;

//get user detail
$obj_user->userDetailById($_SESSION['ses_user_userid']);
$obj_user->next_record();
if($_SESSION['ses_user_userid']){
?>
<span>Welcome,</span> <?php echo $obj_user->f('f_name')." ".$obj_user->f('l_name'); ?> &nbsp;&nbsp;&nbsp;&nbsp;|   <a href="<?php echo $obj_base_path->base_path(); ?>/logout">Sign out</a>
<?php }?>
</li>
<li style="padding: 20px 0 0 10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/login">My TicketHYPE</a></li>
<li style="padding: 20px 0 0 10px;">|</li>
<li style="padding: 20px 0 0 10px;"><a href="#">Gift Cards</a></li>
<li style="padding: 20px 0 0 10px;">|</li>
<li style="padding: 20px 0 0 10px;"><a href="#">Retail Outlets</a></li>
<li style="padding: 20px 0 0 10px;">|</li>
<li style="padding: 20px 0 0 10px;"><a href="#">Help</a></li>
<li style="padding: 20px 0 0 10px;">|</li>
<li style="padding: 20px 0 0 10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/register">Register</a></li>
</ul>
</div>
<div class="headerright">
<div class="phone"><!--<a href="<?php //echo $obj_base_path->base_path(); ?>/contact"><img src="<?php //echo $obj_base_path->base_path(); ?>/images/mail.gif" alt="" width="13" height="9" /> <span class="con_text">Contact Us</span></a><br/>(866) 446-1863--></div>
</div>
<?php if ($_SESSION['ses_page_name']!='content.php'){?>
<div class="clear"></div>
<form name="frm_search" method="post" action="<?php echo $obj_base_path->base_path(); ?>/search">
<div class="search_box">
<ul>
<li><input name="search_text" type="text" class="textfield" id="search_text" onfocus="javascript:if(this.value=='Enter Artist, Team, or Venue') {this.value='';}" onblur="javascript:if(this.value=='') {this.value='Enter Artist, Team, or Venue'}" value="<?php if ($_REQUEST['search_text']) echo $_REQUEST['search_text']; else { ?>Enter Artist, Team, or Venue<?php }?>"/></li>
<li><input type="submit" name="Submit" class="btnbg" value="" /></li>
</ul>
</div>
</form>
<?php }?>

<div class="clear"></div>
<div id="navigation">
<div class="navigation_left">
<ul>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/index" <?php if ($_SESSION['ses_page_name']=='index.php') echo 'class="here"';?>>Home</a></li>
<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/devider.gif" alt="" width="2" height="49" /></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/content/about" <?php if ($_SESSION['ses_page_name']=='content.php' && $_REQUEST['page_link']=='about') echo 'class="here"';?>>About</a></li>
<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/devider.gif" alt="" width="2" height="49" /></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/ticket-solution" <?php if ($_SESSION['ses_page_name']=='ticket-solution.php') echo 'class="here"';?>>Ticketing Solutions</a></li>
<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/devider.gif" alt="" width="2" height="49" /></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/content/press" <?php if ($_SESSION['ses_page_name']=='content.php' && $_REQUEST['page_link']=='press') echo 'class="here"';?>>Press</a></li>
<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/devider.gif" alt="" width="2" height="49" /></li>
<li><a href="<?php echo $obj_base_path->base_path(); ?>/contact" <?php if ($_SESSION['ses_page_name']=='contact.php') echo 'class="here"';?>>Contact Us</a></li>
<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/devider.gif" alt="" width="2" height="49" /></li>
</ul>
</div>
<div class="navigation_right">
<div class="coupon_1">
<a href="#">Get Tickets Now!</a>
</div>
</div>
</div>
</div>