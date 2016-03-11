<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48502938-1', 'kpasapp.com');
  ga('send', 'pageview');
</script>
<div class="secondary_navigation_<?php echo $_SESSION['langSessId']?>" style="margin:0 auto;">
	<div class="secondary_navigationbg">
    <div class="secondary_nav_<?php echo $_SESSION['langSessId']?>">
    <?php
      //echo $_SERVER['REQUEST_URI']."<br>";     
    ?>
   
        <ul>
       
         <li><a href="<?php  if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-kpasapp/ <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-kpasapp/ <?php }?> "><?=ABOUT_KCPASA?></a></li>
            <!--<li><a href="<?php //echo $obj_base_path->base_path(); ?>/about/kpasapp"><!?=ABOUT_KCPASA?></a></li>-->
            
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            
            <li><a href="<?php  if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/about-baja-sur/ <?php } else {echo $obj_base_path->base_path(); ?>/es/acerca-de-baja-california-sur/ <?php }?> "><?=ABOUT_BAJASUR?></a></li>
            
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="<?php  if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/news/ <?php } else {echo $obj_base_path->base_path(); ?>/es/news/ <?php }?> "><?=WHATS_UP?></a></li>
	    
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="<?php  if($_SESSION['langSessId']=='eng') { echo $obj_base_path->base_path(); ?>/en/resources/ <?php } else {echo $obj_base_path->base_path(); ?>/es/resources/ <?php }?> "><?=RESOURCES?></a></li>
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
           <!-- <li><a href="#"><?=YELLOW_PAGES?></a></li>-->
            <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/secondary_nav_devider.gif" border="0" /></li>
            <li><a href="#"><?=FORUM_CHAT?></a></li>
        </ul>
    </div>
    <div class="icon_link_box">
        <div class="icon_link">
            <ul>
                <li><a href="https://www.facebook.com/master.kpasapp" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link1.png" border="0" width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="https://twitter.com/KPasapp" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link2.png" border="0"  width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="https://plus.google.com/u/0/b/104323031953314630567" target="_blank"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link4.png" border="0"  width="26" height="30"/></a></li>
                <li><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link_devider.gif" border="0"/></li>
                <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/icon_link3.png" border="0"  width="26" height="30"/></a></li>
            </ul>
        </div>
    </div>
    </div>
       <div class="select_langbox">
        <div class="select_txt"><?=SELECT_LANGUAGE?></div>
        <div class="select_box">
		<script language="javascript">
			$(document).ready(function(){
				$('#languageId').change(function() {
				 
	  			  $('#sellanguage').submit();
				})
			})
		</script>
		<?php
		
		$multi_id = $_REQUEST['multi_id'];
		//echo "aa".$_SERVER['REQUEST_URI'];exit;
		//echo "hello: ".$multi_id;
		if($multi_id == "")
		{
		  $action=str_replace("/lang/spn","",$_SERVER['REQUEST_URI']);
		  $action=str_replace("/lang/eng","",$action);
		}
		else if($multi_id!= "")
		{
		  if($_SESSION['langSessId']=="eng")
		  {
		    $action=str_replace("/lang/eng","/lang/spn",$_SERVER['REQUEST_URI']);
		    //echo $action."1";
		  }
		  else if($_SESSION['langSessId']=="spn")
		  {
		    $action=str_replace("/lang/spn","/lang/eng",$_SERVER['REQUEST_URI']);
		    //echo $_SERVER['REQUEST_URI']."<br>";
    		    //echo $action."2";

		  }
		}
?>
		<form method="post" action="<?php echo $action;?>" name="sellanguage" id="sellanguage" >
		  <select name="languageId" id="languageId">
			 <!-- <option value="">Select Language</option>-->
			  <option value="eng" <?=($_SESSION['langSessId']=='eng')? 'selected="selected"' : ''?>>English</option>
			  <option value="spn" <?=($_SESSION['langSessId']=='spn')? 'selected="selected"' : ''?>>espa&#241;ol</option>
		  </select>
		</form>
		</div>
    </div>
 </div>
 