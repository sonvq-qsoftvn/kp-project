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

$google_client_id 	= '256208379976-qn6714nedvs4ci49mlfm1o988q6dhqld.apps.googleusercontent.com';
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
	$remember=$_POST["remember_me"];
	//echo "sdf".$remember; exit;
	$faq = new User;

	 $faq->login($loginid,$pass) ;

	if ($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$_SESSION['admin_email'] = $faq->f('email');
		$_SESSION['name'] = $faq->f('fname')." ". $faq->f('lname');
		$_SESSION['ses_admin_id'] = $faq->f('admin_id');
		$_SESSION['login_mode'] = 'site';
		
		
		$_SESSION['usernm'] = $faq->f('email');
		$_SESSION['ses_user_id'] = $faq->f('admin_id');
		$_SESSION['ses_organization_id'] = $faq->f('organization_id');
		$_SESSION['ses_admin_seller_type'] = $faq->f('seller_type');
           /* if(isset($remember)){
				//echo "hii"; exit;
				$expire=time()+60*60*24*30;
                setcookie('first_name1','amit',$expire);
				//$_SESSION['login_mode1'] = 'site111';

            } else {
                setcookie('first_name1','',time()-3600, '/');
				$_SESSION['login_mode1'] = '';
            }*/
			
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
		
		if(isset($remember)){
				//echo "rtret"; exit;
				//$expire=time()+60*60*24*30;
                //setcookie('first_name1','amit',$expire);
				//$_SESSION['login_mode1'] = 'site111';
				$_SESSION['remember'] = 'rem';
				$_SESSION['email'] = $faq->f('username');
				$_SESSION['pass'] = $faq->f('rem_password');
			//header("Location:".$obj_base_path->base_path()."/set_cookie.php");	
         } 
	  if($faq->f('account_type') == 0){
	    header("Location:".$obj_base_path->base_path()."/userprofile");
	    exit;
	  }
	  else
	  {
	    header("Location:".$obj_base_path->base_path()."/professional_userprofile");
	    exit;
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


<title>Registration</title>
<meta charset="utf-8">
<meta name="title" content="Registration">
<meta name="keywords" content="Registration">
<meta name="description" content="Registration">

<!--<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.placeholder.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/contact.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>-->

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

a.checkbtn{
	font: normal 12px/24px Arial, Helvetica, sans-serif;
	border-radius: 5px;
	color: #000;
	border: 1px solid #CCCCCC;
	overflow: hidden;
	background: #f5f5f5;
	height: 24px;
	float: right;
	margin: 0 auto;
	text-decoration: none;
	width: auto;
	padding: 0 12px;
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


function checkemail()
{
  var emailcell=$("#email_cell").val();
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(emailcell);
}


function check_user(){
    if (!checkemail()) {
      $("#email_cell").val('');
      $("#email_cell").focus();
      
      <?php if($_SESSION['langSessId']=='eng') {?>
      alert('Please enter a valid email.');
      <?php }elseif($_SESSION['langSessId']=='spn'){?>
      alert('Por favor, introduzca un email válido.');
      <?php }?>
      
      return false;
    }
   // else
    {
	$('#loading').show();
	sendData = {"email":$("#email_cell").val()};
	//alert($("#email_cell").val());
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_new_form.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   	$('#loading').hide();
		$("#new_form").html(data);
	   }
	 });
    }
    
    $("#email_cell").val('');
  
	
}



</script>
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
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
                    	<div class="blue_boxh"><p><?php if($_SESSION['langSessId']=='eng') { echo "Sign Up"; }else { echo "Regístrarse";}?></p></div>
                    </div>
                	<div class="clear"></div>
                    <div style="width: 990px; float: none; margin: 0 auto;">	
				  	<div class="Tchai_box1" style="width: 990px; margin: 18px auto; border: 0; float: left;">
					<div style="width: 800px; float: left; margin: 0 auto 0 18px;">
						<div style="width: 200px; float: left; margin: 10px auto 0 3px;">                        
                        <h1 style="font: normal 22px/20px Arial, Helvetica, sans-serif; color: #000000; padding: 0; margin: 0;"><?php echo SIGN_UP_WITH;?></h1>
                    <div style="float: left; margin: 54px auto 0 3px;"><h1 style="font: normal 12px/20px Arial, Helvetica, sans-serif; color: #000000; padding: 0; margin: 0;">
			<?php if($_SESSION['langSessId']=='eng'){
			echo "Or let’s check your email address ";
			}elseif($_SESSION['langSessId']=='spn'){
			  echo "O vamos a comprobar su direcci&oacute;n de correo electr&oacute;nico.";
			  } ?></h1></div>
                        
                        </div>
						<div style="width: 100px; float: left; margin: 23px 6px 24px 30px;">                            
                       <a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php"><img src="<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif" border="0" /></a>
                      <!-- <a target="_blank" href="<?php echo $obj_base_path->base_path(); ?>/login-twitter.php"><img src="<?php echo $obj_base_path->base_path(); ?>/images/twitter_blue.gif" border="0" style="margin: 0 5px;" /></a> -->                      
                       	 <a href="<?php echo $authUrl ?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/google_blue.gif" border="0" /> </a>
                        <!--<img src="<?php echo $obj_base_path->base_path(); ?>/images/open_id.gif" border="0"  style="margin: 0 5px;" />-->
			
			<br>

						<div style="width: 350px; float: left; margin: 10px 3px 24px 3px;">
						  <input type="text" name="email_cell" id="email_cell" class="textbg_grey" style="width: 240px; float: left; height: 24px; border: 1px solid #777; margin: 0 6px; outline: none;" value="" />
						  
						  <a href="javascript:void(0);" onClick="check_user();" class="checkbtn">
						    <?php
						      if($_SESSION['langSessId']=='eng'){
							echo "Check";
						      }
						      elseif($_SESSION['langSessId']=='spn'){
							echo "Compruebe";
						      }
						    ?>
						  </a>
						</div>
                    </div>
					</div>
					<div class="clear"></div>
                   
		      <div id="new_form">
		      </div>
                    </div>
                    
                   <div style="display:none;">
                        <div id="get_pass_google" class="fancybox_open">
                            <form method="post" enctype="multipart/form-data" class="login" action="<?php echo $authUrl ?>">
                            <input type="hidden" value="<?php echo $authUrl ?>" />
                              <div style="padding:10px;">Choose an Acount Type:
                             <span style="margin-right:1px;">Personal &nbsp;&nbsp;<input type="radio" name="account_type_google" checked="checked" value="0" onClick="accountype()" /></span> or
                             <span style="margin-left:10px;">Professional &nbsp;&nbsp;<input type="radio" name="account_type_google" value="1" onClick="accountype1()"  /></span>
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
