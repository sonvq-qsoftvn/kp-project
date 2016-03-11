<div class="secondary_navigation_<?php echo $_SESSION['langSessId']?>" style="margin:0 auto;">
	<div class="secondary_navigationbg">
    <div class="secondary_nav_<?php echo $_SESSION['langSessId']?>">
        <ul>
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/about/kpasapp"><?=ABOUT_KCPASA?></a></li>
            
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            
            <li><a href="<?php echo $obj_base_path->base_path(); ?>/about/about-baja-sur"><?=ABOUT_BAJASUR?></a></li>
            
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="#"><?=WHATS_UP?></a></li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="#"><?=RESOURCES?></a></li>
            <!--<li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="#"><?=YELLOW_PAGES?></a></li>-->
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="#"><?=FORUM_CHAT?></a></li>
        </ul>
    </div>
    <div class="icon_link_box">
        <div class="icon_link">
            <ul>
                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link1.png" border="0" width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link2.png" border="0"  width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link3.png" border="0"  width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link4.png" border="0"  width="26" height="30"/></a></li>
            </ul>
        </div>
    </div>
    </div>
       <div class="select_langbox">
        <div class="select_txt"><?=SELECT_LANGUAGE?></div>
        <div class="select_box">
		<script language="javascript">
			$(document).ready(function(){
				$('#languageId').change(function(){
					$('#frmlanguage').submit();
				})
			})
		</script>
		<form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" name="frmlanguage" id="frmlanguage">
			<select name="languageId" id="languageId">
				<option value="eng" <?=($_SESSION['langSessId']=='eng')? 'selected="selected"' : ''?>>English</option>
				<option value="spn" <?=($_SESSION['langSessId']=='spn')? 'selected="selected"' : ''?>>espa&#241;ol</option>
			</select>
		</form>
		</div>
    </div>
 </div>