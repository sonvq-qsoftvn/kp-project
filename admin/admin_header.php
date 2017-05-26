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

    include("../include/language_switcher.php");
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
                <?php 
                    $userType = -1;
                    $account_type = new admin;
                    $account_type->getAccountTypeByUserId($_SESSION['ses_user_id']);

                    if($account_type->num_rows() > 0) {
                        $account_type->next_record();
						$userType = $account_type->f('account_type');
                    }
                ?>
				<div class="back_navigation" style="width:auto;">
                    <ul>
                        <?php if($userType > 0) : ?>
                            <li><div class="back_nav_devider">&nbsp;</div></li>
                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list" <?php if($page_url == 'events.php' || $page_url == 'edit_event.php' || $page_url == 'list_events.php' || $page_url == 'sub_events.php' || $page_url == 'edit_sub_events_edit.php') { ?>class="active"<?php } ?>><?= AD_MENU_EVENTS ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
                            
                            <li><div class="back_nav_devider">&nbsp;</div></li>
                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_venues.php" <?php if($page_url == 'addvenue.php' || $page_url == 'list_venues.php' || $page_url == 'editvenue.php') { ?>class="active"<?php } ?>><?= AD_MENU_VENUES ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>
                            
                            <?php if($userType == 1 || $userType == 2) : ?>
                                <li><div class="back_nav_devider">&nbsp;</div></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_performers.php" <?php if($page_url == 'addperformer.php' || $page_url == 'list_performers.php' || $page_url == 'edit_addperformer.php') { ?>class="active"<?php } ?>><?= AD_MENU_PERFORMERS ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>

                                <li><div class="back_nav_devider">&nbsp;</div></li>
                                <li><a href="#"><?= AD_MENU_PROVIDERS ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0"/></span></a></li>

                                <li><div class="back_nav_devider">&nbsp;</div></li>
                                <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-sponsors"><?= AD_MENU_SPONSORS ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a></li>

                                <li><div class="back_nav_devider">&nbsp;</div></li>
                                <li>
                                    <a href="<?php echo $obj_base_path->base_path(); ?>/admin/payment_account.php" <?php if($page_url == 'payment_account.php'){ ?>class="active"<?php } ?>><?= AD_MENU_ACCOUNT ?></a>
                                    <ul class="sub">
                                        <li><a href="#"><?= AD_MENU_BOOKINGS ?></a></li>
                                        <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-final-report/" <?php if($page_url == 'event_final_report.php'){ ?>class="active"<?php } ?>><?= AD_MENU_REPORTS ?></a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                                                        
                                
                            <li><div class="back_nav_devider">&nbsp;</div></li>
                            <?php if($userType == 2 || $userType == 3) : ?>
                                <li><a style="cursor:pointer;" <?php if($page_url == 'list_page.php') { ?>class="active"<?php } ?>><?= AD_MENU_DASHBOARD ?><span class="nav_arrow"><img src="<?php echo $obj_base_path->base_path(); ?>/images/event_navarrow.png" border="0" /></span></a>				
                                    <ul class="sub">
                                        <li>
                                            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/newsletter_blog_generation.php" <?php if($page_url == 'newsletter_blog_generation.php'){ ?>class="active"<?php } ?>>
                                                <?= AD_MENU_NEWSLETTER_BLOG_GENERATION_LIST ?>
                                            </a>
                                        </li>
                                        <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_page" <?php if($page_url == 'list_page.php') { ?>class="active"<?php } ?>><?= AD_MENU_PAGES ?></a></li>
                                        <?php if($userType == 2) : ?>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_category" <?php if($page_url == 'list_category.php') { ?>class="active"<?php } ?>><?= AD_MENU_EVENT_CATEGORY ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/dbbackup.php"><?= AD_MENU_DATABASE ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_state"<?php if($page_url == 'list_state.php') { ?>class="active"<?php } ?>><?= AD_STATE ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_city"<?php if($page_url == 'list_city.php') { ?>class="active"<?php } ?>><?= AD_CITY ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list_personal_user" <?php if($page_url == 'list_personal_user.php') { ?>class="active"<?php } ?>><?= AD_MENU_USERS ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-client"><?= AD_MENU_CLIENT_MANAGEMENT ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/ad-list/"><?= AD_MENU_AD_MANAGEMENT ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/meta-list/"><?= AD_MENU_META_TAG_MANAGEMENT ?></a></li>
                                            <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/sitemap/" target="_blank"><?= AD_MENU_SITEMAP_GENERATOR ?></a></li>                                            
                                        <?php endif; ?>
                                        <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/social-share/"><?= AD_MENU_SOCIAL_SHARE ?></a></li>
                                    </ul>
                                </li>
                                <li><div class="back_nav_devider">&nbsp;</div></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
				</div>
				<!--<div class="back_search_box"><input name="" type="text" class="search_field" value="Search" /><input name="" type="button" class="searchbtn" /></div>-->
			<?php } ?>
       </div>
				
 <!------------------------end navigation------------------------------------------------->