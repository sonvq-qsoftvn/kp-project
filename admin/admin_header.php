<?php
$page_url = basename($_SERVER['PHP_SELF']);
//echo $page_url;
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(empty($_SESSION['langAdminSelected'])) {
            $_SESSION['langAdminSelected'] = 'sp';
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['languageId'])) {
            $_SESSION['langAdminSelected'] = $_POST['languageId'];
        }
    }     

    ############# Code For Language Change ###############
    if (!isset($_SESSION['langAdminSelected'])) {
        include("../include/languages/admin_spanish.php");
    }
    else if($_SESSION['langAdminSelected'] == 'en')
    {
        include("../include/languages/admin_english.php");
    }
    else if($_SESSION['langAdminSelected'] == 'sp')
    {
        include("../include/languages/admin_spanish.php");
    }
?>
  <!------------------------start header------------------------------------------------- -->
		<div id="back_header_box">
			<div class="back_header">
				<div class="back_header_top">
					<div class="logo"><img src="<?php echo $obj_base_path->base_path(); ?>/images/logo_new.png" border="0" width="282" height="98"/></div>
					<div class="back_right_part">
						<div class="righttxt"><?=AD_LOGO_TITLE;?></div>
					</div>
				</div>            	
			</div>
            <div class="select_langbox">
                <div class="select_box">
                    <script language="javascript">
                        $(document).ready(function(){
                            $('#languageId').change(function() {
                                $('#sellanguage').submit();
                            })
                        })
                    </script>                    
                    <form method="post" action="" name="sellanguage" id="sellanguage" >
                        <select name="languageId" id="languageId">
                            <option value="en" <?= ($_SESSION['langAdminSelected'] == 'en') ? 'selected="selected"' : '' ?>>English</option>
                            <option value="sp" <?= ($_SESSION['langAdminSelected'] == 'sp') ? 'selected="selected"' : '' ?>>espa&#241;ol</option>
                        </select>
                    </form>
                </div>
            </div>
		</div>
		<div class="clear">&nbsp;</div>
  <!-----------------------end-header-------------------------------------------------->

  <!------------------------ navigation------------------------------------------------->
  
        <div id="back_navigation_bar">
			<?php if(isset($_SESSION['ses_user_id']) && ($_SESSION['ses_user_id']!="")) { ?>
				<div class="back_navigation" style="width:auto;">
					  <ul>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list" <?php if($page_url == 'events.php' || $page_url == 'edit_event.php' || $page_url == 'list_events.php' || $page_url == 'sub_events.php' || $page_url == 'edit_sub_events_edit.php') { ?>class="active"<?php } ?>>Events <span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_venues.php" <?php if($page_url == 'addvenue.php' || $page_url == 'list_venues.php' || $page_url == 'editvenue.php') { ?>class="active"<?php } ?>>Venues <span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_performers.php" <?php if($page_url == 'addperformer.php' || $page_url == 'list_performers.php' || $page_url == 'edit_addperformer.php') { ?>class="active"<?php } ?>>Performers<span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="#">Providers<span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0"/></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="#">Sponsors<span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="#">Bookings<span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-final-report/" <?php if($page_url == 'event_final_report.php'){ ?>class="active"<?php } ?>>Reports</a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/payment_account.php" <?php if($page_url == 'payment_account.php'){ ?>class="active"<?php } ?>>Account</a></li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
						<li>
                            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/newsletter_blog.php" <?php if($page_url == 'newsletter_blog.php'){ ?>class="active"<?php } ?>>
                                Newsletter/Blog
                            </a>
                        </li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
                        <?php if($_SESSION['ses_user_id']==1){?>
						<li><a style="cursor:pointer;" <?php if($page_url == 'list_page.php') { ?>class="active"<?php } ?>>Dashboard <span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a>				
                            <ul class="sub">
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_page" <?php if($page_url == 'list_page.php') { ?>class="active"<?php } ?>>Pages</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_category" <?php if($page_url == 'list_category.php') { ?>class="active"<?php } ?>>Event Category</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/dbbackup.php">Database</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_state"<?php if($page_url == 'list_state.php') { ?>class="active"<?php } ?>>State</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_city"<?php if($page_url == 'list_city.php') { ?>class="active"<?php } ?>>City</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_personal_user" <?php if($page_url == 'list_personal_user.php') { ?>class="active"<?php } ?>>Users</a></li>
				<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-client">Add Client</a></li>
				<li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/ad-list/">Ad Management</a></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/meta-list/">Meta Tag Management</a></li>
				 <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/sitemap/" target="_blank">Sitemap Generator</a></li>
                            </ul>
                        </li>
						<li><div class="back_nav_devider">&nbsp;</div></li>
                        <?php } ?>
                        
                        
                        
					  </ul>
				</div>
				<!--<div class="back_search_box"><input name="" type="text" class="search_field" value="Search" /><input name="" type="button" class="searchbtn" /></div>-->
			<?php } ?>
       </div>
				
 <!------------------------end navigation------------------------------------------------->