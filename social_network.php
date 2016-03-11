<?php
include('include/user_inc.php');
//print_r($_SESSION);

$obj_user=new user;
$obj_add=new user;
$obj_check_add=new user;
$obj_edit=new user;

$obj_user->getAdminById($_SESSION['ses_admin_id']);
$obj_user->next_record();

// check already added
$obj_check_add->checkAlreadyadded($_SESSION['ses_admin_id']);
$obj_check_add->next_record();

if( isset($_POST['hid_social_network']) )
{
	if($_POST['facebook_page']!="")
		$facebook_page = $_POST['facebook_page'];
	else
		$facebook_page = 0;
	
	if($_POST['twitter_account']!="")
		$twitter_account = $_POST['twitter_account'];
	else
		$twitter_account = 0;
	
	if($_POST['google_account']!="")
		$google_account = $_POST['google_account'];
	else
		$google_account = 0;
		
	/*if($_POST['youtube_channel']!="")
		$youtube_channel = $_POST['youtube_channel'];
	else
		$youtube_channel = 0;
	
	
	if($_POST['pinterest']!="")
		$pinterest = $_POST['pinterest'];
	else
		$pinterest = 0;
	
	if($_POST['linkedin']!="")
		$linkedin = $_POST['linkedin'];
	else
		$linkedin = 0;
	
	if($_POST['tumblr']!="")
		$tumblr = $_POST['tumblr'];
	else
		$tumblr = 0;
	
	if($_POST['whatsapp']!="")
		$whatsapp = $_POST['whatsapp'];
	else
		$whatsapp = 0;
	
	if($_POST['instagram']!="")
		$instagram = $_POST['instagram'];
	else
		$instagram = 0;
	
	if($_POST['flickr']!="")
		$flickr = $_POST['flickr'];
	else
		$flickr = 0;*/
	
	if($obj_check_add->num_rows()){
		// Edit
		//$obj_edit->editSocialNetworkUser($facebook_page,$twitter_account,$youtube_channel,$google_account,$pinterest,$linkedin,$tumblr,$whatsapp,$instagram,$flickr,$_SESSION['ses_admin_id']);
		$obj_edit->editSocialNetworkUser($facebook_page,addslashes($_POST['facebook_page_text']),$twitter_account,addslashes($_POST['twitter_account_text']),$google_account,addslashes($_POST['google_account_text']),$_SESSION['ses_admin_id']);
	}
	else{
		// Add Social Network
		//$obj_add->addSocialNetworkUser($facebook_page,$twitter_account,$youtube_channel,$google_account,$pinterest,$linkedin,$tumblr,$whatsapp,$instagram,$flickr,$_SESSION['ses_admin_id']);
		$obj_add->addSocialNetworkUser($facebook_page,addslashes($_POST['facebook_page_text']),$twitter_account,addslashes($_POST['twitter_account_text']),$google_account,addslashes($_POST['google_account_text']),$_SESSION['ses_admin_id']);
	}
	if($_SESSION['langSessId']=="spn"){
		$_SESSION['socail_msg'] = "Cuenta de la red social es la instalación con éxito.";
	}
	else{
		$_SESSION['socail_msg'] = "Social network account is setup successfully.";
	}
	header("Location:".$obj_base_path->base_path()."/social_network.php");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Social Network</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<style>
.textbg_grey{
	width:320px !important;
}
</style>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    <div class="clear"></div>
    <div class="container">
       <div class="left_panel bg" style="width:978px;">
            <div class="blue_box1" style="width:976px;">
             <div class="blue_boxh">
                <p style="font-size: 28px; line-height: 30px;"><?php echo "My Kpasapp<br/><span>Personal Profile</span>";?></p>
             </div>
             <div class="blue_boxr" style="width: 754px;">
               <ul>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/userprofile">Account</a></li>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/personal_preference">Preferences</a></li>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/social_network" class="here">Social Networks</a></li>
               </ul>
             </div>
            </div>
            <div class="clear"></div>                
            <div style="width: 976px; float: none; margin: 0 auto;">	
                <?php if($_SESSION['socail_msg']){?>
                <div style="width: 494px; float: left; margin:6px auto 0 23px;">
                    <h1 class="h1show"><?php echo $_SESSION['socail_msg']; $_SESSION['socail_msg'] = '';?></h1>
                </div>
                <?php } ?>
                <div class="clear"></div>
                <div class="showHeading"><?php echo SETUP_SOCIAL;?></div>	
                <div class="clear"></div>
                <form method="post" action="" enctype="multipart/form-data" name="social_network" id="social_network" autocomplete="off">
                <input type="hidden" name="hid_social_network" id="hid_social_network" value="1" />

                <table width="100%" align="left" border="0" cellpadding="4" cellspacing="4" class="prefer_box" style="width:700px;">
                  <tr>
                    <td width="30%" style="padding-left: 18px;"><?php echo FACEBOOK_PAGE;?></td>
                    <td width="70%"><input type="text" name="facebook_page_text" id="facebook_page_text" class="textbg_grey" value="<?php echo $obj_check_add->f('facebook_page_text');?>" />
                    	<input type="checkbox" name="facebook_page" id="facebook_page" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('facebook_page')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo TWITTER_ACCOUNT;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey" value="<?php echo $obj_check_add->f('twitter_account_text');?>" /><input type="checkbox" name="twitter_account" id="twitter_account" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('twitter_account')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo GOOGLE_ACCOUNT;?></td>
                    <td><input type="text" name="google_account_text" id="google_account_text" class="textbg_grey" value="<?php echo $obj_check_add->f('google_account_text');?>" /><input type="checkbox" name="google_account" id="google_account" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('google_account')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                 
                  <!-- 
                  <tr>
                    <td style="padding-left: 18px;"><?php echo YOUTUBE_CHANNEL;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="youtube_channel" id="youtube_channel" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('youtube_channel')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo PINTEREST;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="pinterest" id="pinterest" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('pinterest')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>-->
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>                      						  
                </table>
                <!--<table width="100%" align="left" border="0" cellpadding="4" cellspacing="4" class="prefer_box">
                  <tr>
                    <td width="47%" style="padding-left: 18px;"><?php echo LINKEDIN;?></td>
                    <td width="53%"><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="linkedin" id="linkedin" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('linkedin')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo TUMBLR;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="tumblr" id="tumblr" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('tumblr')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo WHATSAPP;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="whatsapp" id="whatsapp" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('whatsapp')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo INSTAGRAM;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="instagram" id="instagram" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('instagram')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo FLICKR;?></td>
                    <td><input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey"  /><input type="checkbox" name="flickr" id="flickr" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('flickr')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>   /></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>

                </table>-->
                <div class="clear"></div>
                <div style="width: 240px; margin: 14px auto; float: none;"><input type="submit" name="submit1" id="submit1" value="<?php echo SUBMIT;?>" class="event_save" style="cursor:pointer;"/></div>
            </form>                    
            </div>
            <div class="clear"></div>
       </div>
       <div class="clear"></div>
    </div>

    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");
		
?>
</div>


</body>

</html>