<?php
error_reporting(1);

include_once(dirname(dirname(__FILE__)) . "/class/db_mysql.inc");
include_once(dirname(dirname(__FILE__)) . "/class/user_class.php");
include_once(dirname(dirname(__FILE__)) . "/class/pagination.class.php");
include_once(dirname(dirname(__FILE__)) . "/class/class.phpmailer.php");

require './facebook-php/src/Facebook/autoload.php';
$facebook = new \Facebook\Facebook(array(
    'app_id' => '445192265673724',
    'app_secret' => '41f5bccae260641bce323da48eb35776',
    'default_graph_version' => 'v2.5',
));
$helper = $facebook->getRedirectLoginHelper();

$permissions = ['email', 'read_stream', 'publish_stream']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://www.kpasapp.com/fb_callback.php', $permissions);

// =================================== Google Plus =====================================
########## Google Settings.. Client ID, Client Secret #############
$google_client_id 	= '199568594992-5ppg13iba5cnp7ga6l0nnrfjjkvnlaa1.apps.googleusercontent.com';
$google_client_secret 	= 'mDck0ws-RLAuOXXhEpcoQtgB';
$google_redirect_url 	= 'https://www.kpasapp.com/google.php';
$google_developer_key 	= 'AIzaSyDavBYRIR_y12c5EfKqqY40KLUaKwBujTo';

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

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user details if user is logged in
    $user = $google_oauthV2->userinfo->get();
    $user_id = $user['id'];
    $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
    $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
    $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
    $_SESSION['token'] = $gClient->getAccessToken();
} else {
    //get google login url
    $authUrl = $gClient->createAuthUrl();
}

if (isset($authUrl)) { //user is not logged in, show login button
    echo '<a class="login" href="' . $authUrl . '"></a>';
} else {
    //header("Location:".$obj_base_path->base_path()."/index.php?reset=1");
}

// =================================== Google Plus =====================================

// ========================================================================        

$objright_banner = new user;

if ($_SESSION['langSessId'] == "eng") {
    $lang_param_id = "en";
    $objright_banner->all_ad_image($lang_param_id);
} elseif ($_SESSION['langSessId'] == "spn") {
    $lang_param_id = "es";
    $objright_banner->all_ad_image($lang_param_id);
}

$obj=new user;

if (isset($_POST['hid_sign'])) {
    $loginid = $_POST["email_cell"];
    $pass = $_POST["pass_signin"];
    $remember = $_POST["remember_me"];;
    $faq = new User;

    $faq->login($loginid, $pass);

    if ($faq->num_rows() > 0) {
        $faq->next_record();
        $_SESSION['admin_email'] = $faq->f('email');
        $_SESSION['name'] = $faq->f('fname') . " " . $faq->f('lname');
        $_SESSION['ses_admin_id'] = $faq->f('admin_id');
        $_SESSION['login_mode'] = 'site';

        $_SESSION['usernm'] = $faq->f('email');
        $_SESSION['ses_user_id'] = $faq->f('admin_id');
        $_SESSION['ses_organization_id'] = $faq->f('organization_id');
        $_SESSION['ses_admin_seller_type'] = $faq->f('seller_type');        
        ?>
        <script language="javascript">
            $(document).ready(function(){
                <?php
                if ($faq->f('language') == "Spanish")
                    $set_lang = "spn";
                else
                    $set_lang = "eng";
                ?>
                $('#languageId').val('<?php echo $set_lang; ?>');
                $('#frmlanguage').submit();
            })
        </script>

        <?php        
        if ($_SESSION['cid'] != '') {
            foreach ($_SESSION['cid'] as $data) {
                $obj_cart->update_cart($data, $_SESSION['ses_admin_id'], $_SESSION['unique']);
            }
        }

        if (isset($remember)) {            
            $_SESSION['remember'] = 'rem';
            $_SESSION['email'] = $faq->f('username');
            $_SESSION['pass'] = $faq->f('rem_password');	
        }
        header("Location:" . $obj_base_path->base_path() . "/index");
    } else {
        if ($_SESSION['langSessId'] == 'eng')
            $_SESSION['login_msg'] = "Invalid login. Please try again.";
        else
            $_SESSION['login_msg'] = "login inválido. Por favor, inténtelo de nuevo.";
        header("Location:" . $obj_base_path->base_path() . "/index");
    }
}
?>
<?php if($_SESSION['langSessId']=="eng"){$lang_param =  "en_US";}elseif($_SESSION['langSessId']=="spn"){$lang_param = "es_MX";}?>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.carouFredSel.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!----------ajax for subscribe start-------------->

<script type="text/javascript">
function check_subscribe()
{
    $("#loader").show();
    var email= $('#mce-EMAIL').val();	
    var sendData = {'email':$('#mce-EMAIL').val(),'lang':'<?php echo $lang_param; ?>'};	
    var valid = true;
    if(email == '' || email == null) {
        $('#email_msg').html("<?php if ($_SESSION['langSessId'] == "eng") {
                echo "Please provide email id";
            } elseif ($_SESSION['langSessId'] == "spn") {
                echo "Proporcione correo electrónico de identificación";
            } ?>");	
		$('#mce-EMAIL').focus();
		valid = false;
    } else {
		var vemail = email;
		if (vemail.match('^[A-z0-9._%-]+@[A-z0-9.-]+\.[A-z]{2,4}$') != vemail) {
            $('#email_msg').html("<?php if ($_SESSION['langSessId'] == "eng") {
                    echo "Please Enter Valid Email Address!";
                } elseif ($_SESSION['langSessId'] == "spn") {
                    echo "Por favor Ingrese Dirección de email válida";
                } ?>");	
			$('#mce-EMAIL').focus();
			valid = false;
		} 
    }    
    
    if (valid) { 
        $.ajax({ 
            url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_subscribe_email.php",
            cache: false,
            type: "POST",
            data:sendData ,   
            success: function(data){
                $("#email_msg").html(data);
                $("#loader").hide();
                setTimeout('$("#email_msg").html("")',2000);
                setTimeout('$("#mce-EMAIL").val("")',2000);
                $('#mce-EMAIL').focus();            
            }
        });
    }
}
</script>
<style>
    #mc-embedded-subscribe{
        background: url("../images/bgbtn.gif") repeat-x scroll center bottom #23446D;
        border: 0 none;
        color: #FFFFFF;
        cursor: pointer;
        display: block;
        float: right;
        font: bold 14px/24px Arial,Helvetica,sans-serif;
        height: 24px;
        margin: 0;
        outline: medium none;
        padding: 0 10px;
        text-align: center;
        width: auto;
    }

    .botaddbox h4 { color: #000; font: 24px/28px Arial,Helvetica,sans-serif; margin: 0 0 8px; text-align:center;}
    .imgbot { border: 2px solid #ccc; float: left; margin-right: 12px; width: 112px;}
    .imgbot2 { border: 2px solid #ccc; float: left; margin-bottom: 12px; width: auto;}
    .imgbot2 img { width: 100%;}
    .botaddbox2 a { background: none repeat scroll 0 0 #23446d; color: #fff; font-family: arial; font-size: 13px; font-weight: bold; padding: 6px 16px; text-decoration: none; line-height:28px; text-align:right;}
    .bottext2 { clear: both;float: left; font-family: arial; font-size: 13px; font-weight: 400; margin-bottom: 10px; width:100%; }
    .botaddbox2 h4 { color: #000; font: 24px/28px Arial,Helvetica,sans-serif; margin: 0 0 8px; text-align:center;}
    .botaddbox2 {clear: both; display: block; float: right; height: 404px; width: 276px; padding:0 6px; border-top: 2px solid; padding-top: 10px;}
    .imgbot img { width: 100%;}
    .botaddbox {
        border-top: 2px solid;
        clear: both;
        display: block;
        float: right;
        padding: 4px 6px;
        width: 276px;
        margin-bottom:10px;
    }
    .bottext { float: left;font-family: arial; font-size: 13px; font-weight: 400; width: 148px;  margin-bottom: 0px;}
    .botaddbox a { background: none repeat scroll 0 0 #23446d; color: #fff; font-family: arial; font-size: 12px; font-weight: bold; line-height: 26px; padding: 6px 4px; text-decoration: none;}
    .botaddbox h4 a {background: none repeat scroll 0 0 rgba(0, 0, 0, 0);color: #000000;font-size: 18px; font-weight: normal; padding: 6px 0px; }
    .botaddbox h4 a:hover{color:#23446D; text-decoration: underline;}
    .botaddbox .imgbot a {background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;display: inline-block; padding: 4px;}
    .botbutt2 {clear: both; display: block; float: left; margin-bottom: 10px; width: 100%; text-align:right;}
    .botaddbox2 h4 a {background: none repeat scroll 0 0 rgba(0, 0, 0, 0);color: #000000;font-size: 18px; font-weight: normal; padding: 6px 0px; }
    .botaddbox2 h4 a:hover{color:#23446D; text-decoration: underline;}
    .botaddbox2 .imgbot2 a {background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;display: inline-block; padding: 4px;}
    .botbutt { display: block; float: right; margin: 10px 0;}
    .botaddbox .botbutt > a { padding: 6px 6px;}
    .e-wrapps input[type="email"] { width: 140px;}

</style>   

<!-----------ajax for subscribe end--------------->
	<div class="right_panel">
        <?php if($_SESSION['ses_admin_id']==""){?>
            <!---------------Mail Chimp Start----------------------->	
            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup">
                <?php 
                    if($_SESSION['langSessId']=="eng"){
                        $mailChimpUrl = 'https://kpasapp.us3.list-manage.com/subscribe/post?u=6fc63136bc5f6edea5aad0fba&amp;id=15c9255bf1';
                    } else {
                        $mailChimpUrl = 'https://kpasapp.us3.list-manage.com/subscribe/post?u=6fc63136bc5f6edea5aad0fba&amp;id=a46a200e93';
                    }
                ?>
                <form action="<?php echo $mailChimpUrl; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div class="e-wrapps">	
                        <input type="email" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;"><input type="text" name="b_130e6654487fe713844d189db_e429b6d314" tabindex="-1" value=""></div>
                        <input type="button" value="<?php if($_SESSION['langSessId']=="eng"){ echo "Subscribe"; }elseif($_SESSION['langSessId']=="spn"){?>Suscribe<?php }?>" name="subscribe" id="mc-embedded-subscribe" class="button" onclick="check_subscribe()">
                    </div>
                    <div id="email_msg"><span id="loader" style="display:none;"><img alt="image loader" src="<?php echo $obj_base_path->base_path().'/images/loader2.gif'; ?>" width="18" height="18"/></span></div>
                    <div class="e-labe-wrapp"> <label for="mce-EMAIL"><?php if($_SESSION['langSessId']=="eng"){ echo "Send me your alerts & newsletters"; }elseif($_SESSION['langSessId']=="spn"){?><?php echo htmlentities("Envíeme su alertas y boletines"); ?><?php }?></label></div>
                </form>
            </div>
            <!---------------Mail Chimp End----------------------->
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
                            <div class="sign-wraap">
                                <span class="sign-text"><?php echo SIGN_IN_WITH?></span>
                            </div>
                            <div class="face-wrapper">
                                <a href="<?php echo $loginUrl; ?>"><img alt="blue facebook login icon" src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif" border="0" /></a>
                                <a href="<?php echo $authUrl ?>"><img alt="blue google plus icon" src="<?php echo $obj_base_path->base_path(); ?>/images/google_blue.gif" border="0" /> </a>
                            </div>
                            <div class="or-text">
                              <span class="or"><?php echo ORSHOW?></span>
                            </div>    
                        </div>
                        <div class="clear"></div>
                        <div id="showloginIcon" style="display:none;">
                            <div class="red_button"></div>
                        </div>

                        <div class="clear"></div>                            
                        <form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete="off">
                            <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td id="text_email" style="text-align: left; text-transform: none; font-size: 12px;"><?php echo EMAIL_CELL;?> #</td>
                                    <td width="20%"><input type="text" name="email_cell"  id="email_cell" class="textbg_grey" value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email'];}?>" tabindex="1" style="width:134px; border-radius:5px; line-height: 20px; height: 18px; float:right;"/></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;  text-transform: none; font-size: 12px;"><?php echo PASS?>
										<div class="hidden-on-mobile">
											<a href="<?php echo $obj_base_path->base_path(); ?>/forgot_password.php" style="text-decoration: underline; color:#0066CC;"><?php echo FORGOT?></a>
										</div>
									</td>
                                    <td><input type="password" name="pass_signin" value="<?php if(isset($_COOKIE['pass'])){ echo $_COOKIE['pass'];}?>" id="pass_signin" tabindex="2" style="width:134px; height:18px; border-radius:5px;float:right;;"/> </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; text-transform: none; font-size: 12px;">
                                      <div class="remember-me-container" style="float:right; text-transform:none; width: 108px;">
										<input type="checkbox" name="remember_me" id="remember_me" value="1" /> <?php if($_SESSION['langSessId']=="eng"){ echo REMEMBER_ME; }elseif($_SESSION['langSessId']=="spn"){?>Recordarme<?php }?> 
									  </div>
									  <div class="hidden-on-desktop">
										<a href="<?php echo $obj_base_path->base_path(); ?>/forgot_password.php" style="text-decoration: underline; color:#0066CC;"><?php echo FORGOT?></a>
									  </div>
                                    </td>
                                    <td><input type="submit" name="submit11" id="submit11" value="<?php echo SIGNIN?>" class="btn1_sudip" tabindex="3" style="cursor:pointer;" /></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td colspan="2" style="text-align:right">
                                        <div class="acc-text"><?php if($_SESSION['langSessId']=="eng"){ echo "No KPasapp account?"; }elseif($_SESSION['langSessId']=="spn"){?>Sin acuenta KPasapp?<?php }?></div>
                                        <div class="btn2_sudip"><a href="<?php echo $obj_base_path->base_path(); ?>/registration"><?php echo SIGNUP?></a></div>
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
            } else {
                $red = "userprofile";
            } ?>
            <div class="light_greybox">
                <div class="heading_bg" style="height:auto !important;">
                     <ul>
                         <li style="margin:0;">
                             <a href="<?php echo $obj_base_path->base_path()."/".$red; ?>" style="text-decoration:none;">
                                 <input type="button" name="Submit1" value="<?php echo $_SESSION['name'];?>" class="user_btn" style="cursor:pointer;"/>
                             </a>
                             <a href="<?php echo $obj_base_path->base_path(); ?>/logout">
                                 <input type="button" name="Submit2" value="<?php if($_SESSION['langSessId']=="eng"){?>sign out<?php }elseif($_SESSION['langSessId']=="spn"){?>Salir<?php }?>" class="sign_btn" style="cursor:pointer;"/>
                             </a>
                         </li>
                     </ul>
                </div>
            </div>
		<?php } ?>
		<div class="clear"></div>		
                
        <?php if($_SESSION['ses_admin_id']==""){?>       
        	<div class="follow_box" style="border:0px; margin:0px !important;">                     
                <div class="clear"></div>
                <div class="middlebox">           
                    <div class="midbox" style="padding:0px;">
                        <div class="right_txtbox"  style="padding:0px;"></div>
                    </div>
                </div>
           </div>  
		<?php } ?>
        <div class="clear"></div>
        
        <div class="botadd hidden-mobile">
            <?php 
                $arrayAdsObject = [];
                while($rows= $objright_banner->next_record()) {
                    $singleAds = [];
                    $singleAds['position_id'] = $objright_banner->f('position_id');
                    $singleAds['ad_size'] = $objright_banner->f('ad_size');
                    $singleAds['link_url'] = $objright_banner->f('link_url');
                    $singleAds['ad_title'] = htmlentities($objright_banner->f('ad_title'));
                    $singleAds['ad_text'] = htmlentities($objright_banner->f('ad_text'));
                    $singleAds['ad_image_name'] = $objright_banner->f('ad_image_name');
                    $singleAds['call_to_action'] = $objright_banner->f('call_to_action');
                    $singleAds['ad_id'] = $objright_banner->f('ad_id');
                    $arrayAdsObject[] = $singleAds;
                }
                
                $arrayAdsInGroup = [];
                if (count($arrayAdsObject) > 0) {
                    foreach ($arrayAdsObject as $singleAds) {
                        $adPosition = $singleAds['position_id'];
                        $adSize = $singleAds['ad_size'];
                        $adPositionSize = $adPosition . '_' . $adSize;
                        $arrayAdsInGroup[$adPositionSize][] = $singleAds;
                    }
                }
            ?> 
            <?php if (count($arrayAdsInGroup) > 0) : ?>
                <?php foreach ($arrayAdsInGroup as $key => $singleGroup) : ?>
                    <?php if (count($singleGroup) > 1) : ?>
                        <div id="wrapper" style="overflow: hidden; width: 100%; margin-left: -3px;">
                            <div id="carousel_<?php echo $key; ?>" class="carousel-slider" data-id="#carousel_<?php echo $key; ?>">
                                <?php foreach($singleGroup as $adItem) : ?>
                                    <div class="boxads-container">
                                        <?php if($adItem['ad_size'] == 'banner') : ?>
                                            <div class="botaddbox adtracker" data-id="<?php echo $adItem['ad_id']; ?>">
                                                <h4>
                                                    <a href="<?php echo $adItem['link_url'] ?>" target="_blank">
                                                        <?php echo $adItem['ad_title']; ?>
                                                    </a>
                                                </h4>
                                                <div class="imgbot">
                                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                                        <img alt="<?php echo $adItem['ad_text']; ?>" 
                                                             src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/<?php echo $adItem['ad_image_name']; ?>" border="0" />
                                                    </a>
                                                </div>
                                                <div class="bottext"><?php echo $adItem['ad_text']; ?></div>    
                                                <div class="botbutt"> 
                                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                                        <?php echo $adItem['call_to_action']; ?>
                                                    </a>
                                                </div> 
                                            </div>
                                        <?php else : ?>   
                                            <div class="botaddbox2 adtracker" data-id="<?php echo $adItem['ad_id']; ?>">
                                                <h4>
                                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                                        <?php echo $adItem['ad_title']; ?>
                                                    </a>
                                                </h4>
                                                <div class="imgbot2">
                                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                                        <img alt="<?php echo $adItem['ad_text']; ?>" 
                                                             src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/<?php echo $adItem['ad_image_name']; ?>" border="0" />
                                                    </a>
                                                </div>
                                                <div class="bottext2"><?php echo $adItem['ad_text']; ?></div>	
                                                <div class="botbutt2"> 
                                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                                        <?php echo $adItem['call_to_action']; ?>
                                                    </a>
                                                </div>
                                            </div>                        
                                        <?php endif; ?> 
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php $adItem = $singleGroup[0]; ?>
                        <?php if($adItem['ad_size'] == 'banner') : ?>
                            <div class="botaddbox adtracker" data-id="<?php echo $adItem['ad_id']; ?>">
                                <h4>
                                    <a href="<?php echo $adItem['link_url'] ?>" target="_blank">
                                        <?php echo $adItem['ad_title']; ?>
                                    </a>
                                </h4>
                                <div class="imgbot">
                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                        <img alt="<?php echo $adItem['ad_text']; ?>" 
                                             src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/<?php echo $adItem['ad_image_name']; ?>" border="0" />
                                    </a>
                                </div>
                                <div class="bottext"><?php echo $adItem['ad_text']; ?></div>    
                                <div class="botbutt"> 
                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                        <?php echo $adItem['call_to_action']; ?>
                                    </a>
                                </div> 
                            </div>
                        <?php else : ?>   
                            <div class="botaddbox2 adtracker" data-id="<?php echo $adItem['ad_id']; ?>">
                                <h4>
                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                        <?php echo $adItem['ad_title']; ?>
                                    </a>
                                </h4>
                                <div class="imgbot2">
                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                        <img alt="<?php echo $adItem['ad_text']; ?>" 
                                             src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/<?php echo $adItem['ad_image_name']; ?>" border="0" />
                                    </a>
                                </div>
                                <div class="bottext2"><?php echo $adItem['ad_text']; ?></div>	
                                <div class="botbutt2"> 
                                    <a href="<?php echo $adItem['link_url']; ?>" target="_blank">
                                        <?php echo $adItem['call_to_action']; ?>
                                    </a>
                                </div>
                            </div>                        
                        <?php endif; ?>  
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<script>
    $(function() {
//        $("#carousel").carouFredSel({
//            items: 1,
//            prev: '#prev',
//            next: '#next',
//
//        });


//        var slider_ads=$('#carousel').show().bxSlider({
//            controls: true,
//            displaySlideQty:1,
//            moveSlideQty:1,
//            pager:false,
//            auto:true,
//            speed: 200,
//            pause: 4000,
//            mode:'horizontal'
//        });
        
        $('.carousel-slider').each(function(){
           var idSlider = $(this).attr('data-id');
           console.log(idSlider);
           $(idSlider).bxSlider({
                controls: true,
                displaySlideQty:1,
                moveSlideQty:1,
                pager:false,
                auto:true,
                speed: 200,
                pause: 5000,
                mode:'horizontal'
            });
        });
        
        $('.botaddbox2 a, .botaddbox a, .ads-box a').click(function(){
            var ad_id = $(this).closest('div.adtracker').attr('data-id');
            
            console.log('Clicked on ad_id = ' + ad_id);
            if (ad_id > 0) {
                $.ajax({ 
                    dataType: 'jsonp',
                    url: "https://freegeoip.net/json/",
                    cache: false,
                    type: "GET",   
                    success: function(data){
                        var ip_address = data.ip;
                        var city = data.city;
                        var country_code = data.country_code;
                        var country_name = data.country_name;
                        var sendData = {
                            "ip_address": ip_address,
                            "city": city,
                            "country_code": country_code,
                            "country_name": country_name,
                            "ad_id": ad_id
                        };
                        console.log(data);
                        $.ajax({ 
                            url: "<?php echo $obj_base_path->base_path(); ?>/ajax_save_ads_click.php",
                            cache: false,
                            type: "POST",
                            data: sendData,   
                            success: function(data){
                                
                            }
                        });
                    }
                });
            }
        });
    });
</script>

                