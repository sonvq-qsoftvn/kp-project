<?php
include('include/user_inc.php');
$obj=new user;
$obj_page=new user;
$obj_page1=new user;
$obj_sendmail=new user;
//echo $_SESSION['langSessId'];

//$_SESSION['account_type_google'] = 1;
// =================================== Google Plus =====================================
########## Google Settings.. Client ID, Client Secret #############
/*$google_client_id 		= '256208379976.apps.googleusercontent.com';
$google_client_secret 	= 'a0m2Fb7eTLjnm343HEuQXgNC';
$google_redirect_url 	= 'http://phppowerhousedemo.com/webroot/team5/kcpasa/google.php';
$google_developer_key 	= 'AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s';*/

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

if(isset($authUrl)) //user is not logged in, show login button
{
	/*echo '<a class="login" href="'.$authUrl.'"><img src="images/google-login-button.png" /></a>';*/
}
else{
	header("Location:".$obj_base_path->base_path()."/registration.php?reset=1");
}

// =================================== Google Plus =====================================




if($_SESSION['ses_admin_id']!="")
	header("Location:".$obj_base_path->base_path()."/index");

if( isset($_POST['hid_sign']) )
{
	//print_r($_POST);exit;
	$loginid=$_POST["email_cell"];
	$pass=$_POST["pass_signin"];
	$faq = new User;

	 $faq->login($loginid,$pass) ;

	if ($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['admin_email'] = $faq->f('email');
		$_SESSION['ses_admin_id'] = $faq->f('admin_id');
		
		//redirect
		header("Location:".$obj_base_path->base_path()."/index");

	}
	else
	{
		$_SESSION['login_msg'] = "Invalid login credentials. Please try again!";
		header("Location:".$obj_base_path->base_path()."/registration");
	}
}

// get url of the pages
$obj_page->intro_page_id(5);
$obj_page->next_record();
$obj_page1->intro_page_id(6);
$obj_page1->next_record();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up</title>
<!--<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/contact.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.error{
	color:red;
	margin:0 10px;
	font: normal 11px/16px Arial, Helvetica, sans-serif;	
}
#contact label{
	margin-right:5px;
}

#contact{
	margin-left:5px;
}

#contact .short{
	color:#FF0000;
}

#contact .weak{
	color:#E66C2C;
}

#contact .good{
	color:#2D98F3;
}

#contact .strong{
	color:#006400;
}

.tooltip{
	position:absolute;
	z-index:9999;
	background-color:#f5f5f5;
	font-size:14px;
	width:260px;
	min-height:30px;
	border: 2px solid #ccc;
	-moz-border-radius: 10px;
	overflow: hidden;
	padding: 9px;
	margin: 0 0 0 109px;
	font: normal 12px/17px Arial, Helvetica, sans-serif;
	border-radius: 10px;
	color: #000;
}
.tooltip ul{
	margin:0;
	padding: 8px;
}
.tooltip ul li{
	margin:0;
	padding: 0;
	width:260px;
	float: left;
	list-style-type: disc !important;
}
.err{
	color:red;
	margin: 0 5px;
}
 
</style>


<script type="text/javascript">
function setCountryCode()
{
	sendData = {"country_id":$('#country_id').val()};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_set_country_code.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#country_code").val(data);
	   }
	 });
}

$(document).ready(function () {
  $("#tip1").hover(function () {
    $(this).append('<div class="tooltip"><ul><li>The email address has to be confirmed before the account can be used fully. The confirmation link is emailed after the registration is completed.</li><li>The email address in combination with the password can be used to login.</li></ul></div>');
  }).mouseout(function(){
	
    $("div.tooltip").remove();
  
  }); 
  //alert(window.location.protocol+'//'+window.location.host+'/'+'kcpasa/registration')

});

function checkEmail()
{
	$('#email_err').html("");
	sendData = {"email":$('#email').val()};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_checkemail.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
		   if(data>0){
			   $('#email').val("");
			   <?php if($_SESSION['langSessId']=='eng'){ ?>
			  $("#email_err").html("This login already exists");
			   <?php } else { ?>
			    $('#email_err').html("Este login ya existe");
			   <?php } ?>
			  setTimeout('$("#email_err").html("")',2000);
			   $('#email').focus();
		   }
		   /*else
			   $("#country_code").val(data);*/
	   }
	 });
}

function clean_err()
{
	$('#email_err').html("");
}

$(document).ready(function() {
		$("#google_pass").fancybox();
	});
	
$(document).ready(function() {
		$("#facebook_pass").fancybox();
	});
	
function accountype()
{
	sendData = {"acc_type":"personal"};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_setaccountype_google.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   }
	 });
}
function accountype1()
{
	sendData = {"acc_type":"professional"};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_setaccountype_google.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   }
	 });
}
</script>
</head>

<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
	<div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg" style="width:978px;">
            	<div class="cheese_box">
                    <div class="blue_box1" style="width: 976px;">
                    	<div class="blue_boxh"><p><?php echo "Sign Up";?></p></div>
                    </div>
                	<div class="clear"></div>
                    <div style="width: 990px; float: none; margin: 0 auto;">	
				  	<div class="Tchai_box1" style="width: 990px; margin: 18px auto; border: 0; float: left;">
					<div style="width: 535px; float: left; margin: 0 auto 0 18px;">
						<div style="width: 120px; float: left; margin: 10px auto 0 3px;"><h1 style="font: normal 22px/20px Arial, Helvetica, sans-serif; color: #000000; padding: 0; margin: 0;"><?php echo SIGN_UP_WITH;?></h1></div>
						<div style="width: 400px; float: right; margin: 0 3px 24px 3px;">                            
                       <a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php"><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif" border="0" /></a>
                      <!-- <a target="_blank" href="<?php echo $obj_base_path->base_path(); ?>/login-twitter.php"><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_blue.gif" border="0" style="margin: 0 5px;" /></a> -->                      
                       	 <a href="<?php echo $authUrl ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/google_blue.gif" border="0" /> </a>
                        <!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/open_id.gif" border="0"  style="margin: 0 5px;" />-->
                    </div>
					</div>
					<div class="clear"></div>
                    <div style="width: 260px; float: left; margin: 0 0 0 21px;">
                    	<h1 style="font: normal 22px/22px Arial, Helvetica, sans-serif; padding: 0; margin: 0; color: #000000;"><?php echo ORSHOW;?></h1>
                    </div> 
					<div class="clear"></div>
                    
                      <form method="post" action="" enctype="multipart/form-data" name="contact" id="contact" autocomplete = "off">
                        <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                          <tr>
                            <td style="padding-left: 18px;"><?php echo ACCOUNT_TYPE;?>:</td>
                            <td>
                                <span style="margin-right:1px;"><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/<?php echo $obj_page->f('page_link')?>" target="_blank"><?php echo PERSONAL;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode1" checked="checked" value="0"  /></span> or
                                <span style="margin-left:10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/<?php echo $obj_page1->f('page_link')?>" target="_blank"><?php echo PROFESSIONAL;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode2" value="1"  /></span>                            </td>
                          </tr>
                          <tr>
                            <td width="18%" style="padding-left: 18px;"><?php echo FIRST_NAME;?> <span style="color:red;">*</span></td>
                            <td width="82%"><input type="text" name="fname" id="fname" class="textbg_grey required" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_name"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo LAST_NAME;?> <span style="color:red;">*</span></td>
                         	<td><input type="text" name="lname" id="lname" class="textbg_grey required" style="width: 190px;"/> <br/><div class="clear"></div><span class="err" id="err_lname"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo EMAIL;?> 
                            	 <span class="question" id="tip1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="margin: 0 5px;" /></span></td>
                            <td><input type="text" name="email" id="email" class="textbg_grey required email" style="width: 190px;" onclick="clean_err()" onblur="checkEmail()"/><br/><div class="clear"></div><span class="err" id="email_err"></span> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo CELL_PHONE;?> #</td>
                            <td><input type="text" name="phone" id="phone" class="textbg_grey" style="width: 190px;"/></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo LANG;?></td>
                            <td style="padding: 4px 0 0 7px;">
                                <select name="language" id="language" class="textbg_grey" style="width: 199px;">
                                    <option value="English" <?php if($_SESSION['langSessId']=="eng"){?> selected="selected" <?php } ?>>English</option>
                                    <option value="Spanish" <?php if($_SESSION['langSessId']=="spn"){?> selected="selected" <?php } ?>>espa&#241;ol</option>
                                </select>
                             </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo COUNTRY;?></td>
                            <td style="padding: 4px 0 0 7px;">
                                <select name="country_id" id="country_id" onchange="setCountryCode()" class="textbg_grey" style="width: 199px;">
                                <?php
									$value_code = '';
									$sel = "selected='selected'";
									if($_SESSION['langSessId']=="spn"){
										$value_code = "value='52'";
										$county_val = 52;
									}
									else{
										$value_code = "value='1'";
										$county_val = 1;
									}
										
                                    $obj->countries_list();
                                    while($obj->next_record()){
                                ?>
                                    <option value="<?php echo $obj->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj->f('id')==138){ echo $sel; } if($_SESSION['langSessId']=="eng" && $obj->f('id')==226){ echo $sel; } ?>><?php echo $obj->f('nicename')?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <input type="hidden" name="country_code" id="country_code" value="<?php echo $county_val;?>"  />
                             </td>
                          </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;"><?php echo PASS;?> <img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="margin: 0 5px;" /></td>
                            <td><input type="password" name="password" id="password" class="textbg_grey required" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_pass"></span><span id="result"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo CON_PASS;?> <span style="color:red;">*</span></td>
                			<td><input type="password" name="con_password" id="con_password" class="textbg_grey required" equalto="#password" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_con_pass"></span></td>
                          </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;"><input id="num1" name="num1" readonly="readonly" class="sum" style="width: 12px; font: bold 16px/18px Arial, Helvetica, sans-serif; color: #525252; background: none; border: 0;" value="<?php echo rand(1,4) ?>" /> + 
                                <input id="num2" name="num2" readonly="readonly" class="sum" value="<?php echo rand(5,9) ?>" style="width: 12px; font: bold 16px/18px Arial, Helvetica, sans-serif; color: #525252; background: none; border: 0;"/> =</td>
                			<td>
                                <input type="text" name="captcha" id="captcha" class="captcha" maxlength="2" />
                                <div id="spambot">(<?php echo HUMAN;?>)</div>                            
                            </td>	
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><a href="#" style="color:#00F;"><?php echo PRIVIACY;?></a></td>
                			<td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" style="text-align:left; padding-left: 15px;">
                            	<?php echo TERMS_CONDITION;?>
                            </td>
                          </tr>
                          <tr>
						    <td colspan="2" style="text-align:left; padding-left: 15px;"><input type="submit" name="submit1" id="submit1" value="<?php echo CREATE_ACCOUNT;?>" class="event_save" style="cursor:pointer;"/></td>
                          </tr>
                        </table>
                      </form>
                    </div>
                    
                   <div style="display:none;">
                        <div id="get_pass_google" class="fancybox_open">
                            <form method="post" enctype="multipart/form-data" class="login" action="<?php echo $authUrl ?>">
                            <input type="hidden" value="<?php echo $authUrl ?>" />
                              <div style="padding:10px;">Choose an Acount Type:
                             <span style="margin-right:1px;">Personal &nbsp;&nbsp;<input type="radio" name="account_type_google" checked="checked" value="0" onclick="accountype()" /></span> or
                             <span style="margin-left:10px;">Professional &nbsp;&nbsp;<input type="radio" name="account_type_google" value="1" onclick="accountype1()"  /></span>
                            <!--<a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php" target="_blank"><p style="color:#666" >Log in to Facebook</p></a>-->
                            <input type="submit" name="sub" value="Log in to Google" />
                            </div>
                            </form>
                        </div>
                    </div>
    
    
    				<div style="display:none;">
                    <div id="get_pass_facebook" class="fancybox_open">
                        <form method="post" enctype="multipart/form-data" action="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php">
                            <div style="padding:10px;">Choose an Acount Type:
                             <span style="margin-right:1px;">Personal &nbsp;&nbsp;<input type="radio" name="account_type_facebook"  checked="checked" value="0"  /></span> or
                             <span style="margin-left:10px;">Professional &nbsp;&nbsp;<input type="radio" name="account_type_facebook"  value="1"  /></span>
                            <!--<a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php" target="_blank"><p style="color:#666" >Log in to Facebook</p></a>-->
                            <input type="submit" name="sub" value="Log in to Facebook" />
                            </div>
                        </form>
                        </div>
                    </div>

					</div>
                </div>
                <div class="clear"></div>
            </div>
           <?php //include("include/frontend_rightsidebar.php");?>
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
