<?php
error_reporting(1);

include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");


// =================================== Google Plus =====================================
########## Google Settings.. Client ID, Client Secret #############
$google_client_id 		= '256208379976-qn6714nedvs4ci49mlfm1o988q6dhqld.apps.googleusercontent.com';
$google_client_secret 	= 'OmTKyOc5XDUNqs9_taw_GP9l';
$google_redirect_url 	= 'http://kpasapp.com/google.php';
$google_developer_key 	= 'AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s';

//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

$gClient = new Google_Client();
$gClient->setApplicationName('Login to saaraan.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])) 
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
}

//Redirect user to google authentication page for code, if code is empty.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}


if (isset($_SESSION['token'])) 
{ 
		$gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
	  //Get user details if user is logged in
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
}
else 
{
	//get google login url
	$authUrl = $gClient->createAuthUrl();
}

//echo $authUrl;
if(isset($authUrl)) //user is not logged in, show login button
{
	echo '<a class="login" href="'.$authUrl.'"></a>';
}
else{
	header("Location:".$obj_base_path->base_path()."/index.php?reset=1");
}

// =================================== Google Plus =====================================

// ========================================================================
$obj=new user;

if( isset($_POST['hid_sign']) )
{
	//print_r($_POST);exit;
	$loginid=$_POST["email_cell"];
	$pass=$_POST["pass_signin"];
	$remember=$_POST["remember_me"];
	$faq = new User;

	 $faq->login($loginid,$pass) ;

	if ($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['admin_email'] = $faq->f('email');
		$_SESSION['name'] = $faq->f('fname')." ". $faq->f('lname');
		$_SESSION['ses_admin_id'] = $faq->f('admin_id');
		$_SESSION['login_mode'] = 'site';
		
            if(isset($remember)){
                setcookie('first_name1','amit',time()+60*60*24*365, '/');
				$_SESSION['login_mode1'] = 'site111';

            } else {
                setcookie('first_name1','',time()-3600, '/');
				$_SESSION['login_mode1'] = '';
            }
			
	?>
    <script language="javascript">
			$(document).ready(function(){
				<?php
				if($faq->f('language')=="Spanish")
					$set_lang = "spn";
				else
					$set_lang = "eng";
				?>
				$('#languageId').val('<?php echo $set_lang;?>');
				$('#frmlanguage').submit();
				
			})
		</script>
    	<?php /*?><script>
			window.location ="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
		</script><?php */?>
    <?php	
		//redirect
		//header("Location:".$obj_base_path->base_path()."/index");
		if($_SESSION['cid'] != ''){
			foreach($_SESSION['cid'] as $data){
				$obj_cart->update_cart($data,$_SESSION['ses_admin_id'],$_SESSION['unique']);
			}
		}
	}
	else
	{
		if($_SESSION['langSessId']=='eng')
		$_SESSION['login_msg'] = "Invalid login. Please try again.";
		else
		$_SESSION['login_msg'] = "login inválido. Por favor, inténtelo de nuevo.";
		header("Location:".$obj_base_path->base_path()."/index");
	}
}


?>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<div class="right_panel">
      <?php if($_SESSION['ses_admin_id']==""){?>
        <div class="signupbox" style=" background: #22456D; margin: 0 0 4px 0;">
            <div class="header" style="border: 0; padding: 10px 0; margin: 0;">
                <h4><?=TAB_MY_KPASSAPP?></h4>
            </div>
            <div class="fieldbox" style=" padding: 10px; width: 240px; background: #bde6fa;">
				<div class="Tchai_box1" style="width: 390px; margin: 10px auto; float: left;">
				
                <div style="color:red;font: normal 12px/20px Arial, Helvetica, sans-serif; width:240px;" id="showerr">
                    <?php if($_SESSION['login_msg']){?><?php echo $_SESSION['login_msg'];unset($_SESSION['login_msg']);?> <?php } ?>
                </div>
               
                <div style="width: 400px; float: none; margin: 0 auto;">
                <div style="width: 120px; float: left; margin: 10px auto 0 3px;">
                    <h1 style="font: normal 22px/20px Arial, Helvetica, sans-serif; color: #000000; padding:0px; margin: 0;"><?php echo SIGN_IN_WITH?></h1>
                 </div>
                <div style="width: 270px; float: right; margin: 0 3px 24px 3px;">
                    <a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php"><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif" border="0" /></a>
                  <!--  <img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_blue.gif" border="0" style="margin: 0 5px;" />-->
                    <a href="<?php echo $authUrl ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/google_blue.gif" border="0" /> </a>
                </div>
                </div>
                <div class="clear"></div>
                <div id="showloginIcon" style="display:none;">
				<div class="red_button"></div>
				</div>
                <div style="width: 260px; float: left; margin: 0 3px;">
                <h1 style="font: normal 22px/22px Arial, Helvetica, sans-serif; padding: 0; margin: 0; color: #000000;"><?php echo ORSHOW?></h1>
                </div>                            
                <div class="clear"></div>                            
                  <form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete="off">
                    <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                    <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td id="text_email" style="text-align: left; text-transform: none; font-size: 12px;"><?php echo EMAIL_CELL;?> #</td>
                        <td width="20%"><input type="text" name="email_cell"  id="email_cell" class="textbg_grey" value="" tabindex="1" style="width:134px; border-radius:5px; line-height: 20px; height: 18px; float:right;"/></td>
                      </tr>
                      <tr>
                        <td style="text-align: left;  text-transform: none; font-size: 12px;"><?php echo PASS?><div><a href="<?php echo $obj_base_path->base_path(); ?>/forgot_password.php" style="text-decoration: underline; color:#0066CC;"><?php echo FORGOT?></a></div></td>
                        <td><input type="password" name="pass_signin" value="" id="pass_signin" tabindex="2" style="width:134px; height:18px; border-radius:5px;float:right;;"/> </td>
                      </tr>
                      <tr>
                      <td style="text-align: left; text-transform: none; font-size: 12px;">
                      	<div style="float:right; text-transform:none;"><input type="checkbox" name="remember_me" id="remember_me" value="1" /> <?php echo REMEMBER_ME;?> </div>
                      </td>
                      <td><input type="submit" name="submit11" id="submit11" value="<?php echo SIGNIN?>" class="btn1_sudip" tabindex="3" style="cursor:pointer;" /></td>
                      </tr>
                      <tr>
                       <td colspan="2" style="text-align: left; font-size: 12px;"><?php echo DONT_KP?> ?<!--<div class="upcoming_btn"><a href="<?php echo $obj_base_path->base_path(); ?>/registration">
        <img src="<?php echo $obj_base_path->base_path(); ?>/images/create_imgbtn.png" border="0" style="margin: 0 auto; display: block;" /></a></div>class="event_signin"
    </div>--></td>
                     </tr>
                     <tr>
                      <td colspan="2" style="text-align:right">
                      <div class="btn2_sudip"><a href="<?php echo $obj_base_path->base_path(); ?>/registration"><?php echo SIGNUP?></a></div>
                       <!-- <img src="<?php echo $obj_base_path->base_path(); ?>/images/sign_up_btn.png" border="0" /></a>-->
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
            	<div class="clear"></div>
            </div>
        </div>
		<div class="clear"></div>
		 <?php } if($_SESSION['ses_admin_id']!=""){
			 	$obj_usr = new User;
				$obj_usr->getAdminById($_SESSION['ses_admin_id']);
				$obj_usr->next_record();
				if($obj_usr->f('account_type')==1){
					$red = "professional_userprofile";
				}
				else
					$red = "userprofile";
?>
             <div class="light_greybox">
                <div class="heading_bg" style="height:auto !important;">
                    <ul>
                        <li style="margin:0;">
                             <a href="<?php echo $obj_base_path->base_path()."/".$red; ?>" style="text-decoration:none;">
                             	<input type="button" name="Submit1" value="<?php echo $_SESSION['name'];?>" class="user_btn" style="cursor:pointer;"/></a>
                            <a href="<?php echo $obj_base_path->base_path(); ?>/logout">
                            	<input type="button" name="Submit2" value="sign out" class="sign_btn" style="cursor:pointer;"/>
                            </a>
                        </li>
                    </ul>
                </div>
             </div>
		<?php } ?>
		<div class="clear"></div>		
	   <?php //} //else { ?>
        <div class="signupbox" style="border: 1px solid #666; padding: 0; margin: 0 0 4px 0; border-radius: 0px; background:none;">            
            <img src="<?php echo $obj_base_path->base_path(); ?>/images/turns_img.gif" border="0"/>
			<!--<p><img src="<?php echo $obj_base_path->base_path(); ?>/images/get_app.gif" border="0" /></p>-->
        </div>
         <?php //}  ?>
                
          <?php if($_SESSION['ses_admin_id']==""){?>       
        	<div class="follow_box" style="border:0px; margin:0px !important;">
         
            <?php /*?><div class="topbox">
                <h6><?=FOLLOW_US?></h6>
                <div class="quick_link">
                    <ul>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg1.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg2.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg3.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg4.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg5.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg6.png" border="0" /></a></li>
                        <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/quick_linkimg7.png" border="0" /></a></li>
                    </ul>
                </div>
            </div><?php */?>
          
            <?php /*?><div class="signupbox">
            <!--<div class="header">
                <ul>
                    <li style="margin: 0 10px;"><a href="#">New User?</a></li>
                    <li><a href="#">Register</a></li>
                    <li> | </li>
                    <li><a href="#">Sign In</a></li>
                </ul>
            </div>-->
              <?php if($_SESSION['ses_admin_id']==""){?>
            <div class="fieldbox" style="margin: 15px auto;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="Input2" type="text" value="<?=YOUR_EMAIL?>" style="margin: 17px 0 0 0;" /></td>
                  </tr>
                  <tr>
                    <td style="padding: 0;"><?=S_OR?></td>
                  </tr>
                  <tr>
                    <td><input name="" type="text" value="<?=YOUR_CELL?>" /></td>
                  </tr>
                  <tr>
                    <td><input name="" type="text" value="<?=YOUR_CITY?>" /></td>
                  </tr>
                  <tr>
                    <td><input name="" type="button" value="<?=GO?>" class="go_btn" /></td>
                  </tr>
                </table>
            </div>
            <div class="upcoming_btn"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/upcoming_imgbtn.gif" border="0" /></a></div>
            <?php } ?>
        </div><?php */?>
         <div class="clear"></div>
            <div class="middlebox">
           <!-- <div class="timeline_box">
                <div class="leftbox">
                    <ul>
                        <li><span class="per"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/timeline_img1.gif" border="0" /></a></span></li>
                        <li><span class="next"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/timeline_img2.gif" border="0" /></a></span></li>
                        <li class="timeline_<?php $_SESSION['langSessId'];?>"><?=YOUR_TIMELINE?></li>
                    </ul>
                </div>
                <div class="rightbox">
                    <ul>
                        <li><span class="per"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/previewimg.png" border="0" /></a></span></li>
                        <li> 4 of 10 </li>
                        <li><span class="next"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/nextimg.png" border="0" /></a></span></li>
                    </ul>
                </div>
            </div>-->
            <div class="midbox" style="padding:0px;">
               <!-- <div class="imgbox"><img src="<?php echo $obj_base_path->base_path(); ?>/images/followimg1.gif" border="0" /></div>-->
                <div class="right_txtbox"  style="padding:0px;">
                    <!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><div class="txt1"><?=SOCIAL_NETWORK_TEXT?></div></td>
                        <td><span class="follow_num">55 </span></td>
                      </tr>
                      <tr>
                        <td colspan="2"><textarea name="" cols="" rows="">&nbsp;</textarea></td>
                      </tr>
                    </table>
                    <div class="tweet_btn"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/tweet_btn.gif" border="0" /></a></div>	-->
                </div>
            </div>
            </div>
        </div>  
		<?php } ?>
        <div class="kc_box" style="margin: 0;">
            <div class="topbox">7,314 people like <span class="name">KCPasa </span></div>
            <div class="likebox">
                <ul>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg2.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                    <li><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/likeimg1.gif" border="0" /></a></li>
                </ul>
            </div>
        </div>
        <div class="ontwitter_box">
        <div class="header"><?=TWITTER_HEADER?></div>
        <div class="midbox">
            <ul>
                <li>Tell President @<a href="#">SBYudhoyono of #Indonesia</a> to stop the plan to kill orangutans and #SaveAceh: Sign & RT! avaaz.org/en/the_plan_to… 3 weeks ago <span class="readimg"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/readimg.gif" border="0" /></a></span></li>
                <li>Tell President @<a href="#">SBYudhoyono of #Indonesia</a> to stop the plan to kill orangutans and #SaveAceh: Sign & RT! avaaz.org/en/the_plan_to… 3 weeks ago</li>
                <li>Tell President @<a href="#">SBYudhoyono of #Indonesia</a> to stop the plan to kill orangutans and #SaveAceh: Sign & RT! avaaz.org/en/the_plan_to… 3 weeks ago <span class="readimg"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/readimg.gif" border="0" /></a></span></li>
            </ul>
            <div class="clear"></div>
            <div class="followbtn"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/follow_btn.gif" border="0" /></a></div>
        </div>
            
        </div>
      
        <div class="botadd"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/images/right_add4.gif" border="0" /></a></div>
    </div>
    
    