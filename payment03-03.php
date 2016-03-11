<style>
.checkbtn {
  width: auto;
  height: 24px;
  background: #134f5c; 
  border: 0;
  outline: none;
  font: bold 16px/24px Arial, Helvetica, sans-serif;
  color: #fff;
  text-align: center;
  padding: 0 12px;
  margin: 0;
  display: inline-block;
  overflow: hidden;
  text-decoration: none;
  cursor: pointer;
}
.checkbtn:hover {  
  color: #fff;
  text-decoration: none;
}
</style>	

<?php
include('include/user_inc.php');
$e_id = $_REQUEST['event_id'];
//unset($_SESSION['event_id']);
$_SESSION['event_id'] = $e_id;

//echo $_SESSION['ses_admin_id'];

//$sub_id = $_REQUEST['sub_id'];
//echo $event_id; exit;
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
	//header("Location:".$obj_base_path->base_path()."/payment.php");
	echo '<a class="login" href="'.$authUrl.'"></a>';
}
else{
	//header("Location:".$obj_base_path->base_path()."/index.php?reset=1");
	//header("location:".$obj_base_path->base_path()."/payment/".$e_id);
	//exit;
}

// =================================== Google Plus =====================================

//create object
$objEvent=new user;
$objmulti_event=new user;
$objmul_date=new user;
$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;
$objsub_event=new user;
$obj_venue_sub=new user;

$obj_sub_ticket=new user;
$obj_sub_ticket_img=new user;

$obj_chk=new user;
$obj_cur_eve_dt=new user;

$obj_cart=new user;
$obj_cart_details=new user;
$obj_remove=new user;
$obj_count=new user;
$obj_total=new user;
$obj=new user;
$obj_country=new user;
$obj_venuestate=new user;
$faq=new user;
$edit_admin=new user;



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
		unset($_SESSION['err']);
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
		unset($_SESSION['err']);
		if($_SESSION['langSessId']=='eng')
		$_SESSION['err'] = "Invalid login. Please try again.";
		else
		$_SESSION['err'] = "login inv&aacute;lido. Por favor, inténtelo de nuevo.";
		header("Location:".$obj_base_path->base_path()."/payment/".$_GET['event_id']);
		exit;
	}
}
//echo $_SESSION['err'];

if(isset($_POST['action']) && $_POST['action'] == 'save')
{
//print_r($_POST);
//echo $_POST["country_id"]; exit;


$obj_adduser = new user;
$obj_sendmail = new user;



$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email_cell'];
$phone = $_POST['phone'];
$country_id = $_POST['country_id'];
$country_code = $_POST['country_code'];
$rem_password = '';
$password = '';

//$rem_password = $_POST['password'];
//$password = md5($_POST['password']);
$account_type = $_POST['account_type'];
if($country_id == 138){
  $language = 'Spanish';
}
else
{
  $language = 'English';
}



$province = $_POST['province'];
$county = $_POST['county'];
$city = $_POST['city'];
$address = $_POST['address'];
$postal_code = $_POST['postal_code'];
$mobile_code = $_POST['mobile_code'];


//if($language == 'English'){
//$_SESSION['langSessId'] = 'eng';
//}
//elseif($language == 'Spanish')
//{
//$_SESSION['langSessId'] = 'spn';
//}

//echo $_SESSION['langSessId']; exit;

$user_id = $obj_adduser->register_user($fname,$lname,$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type,$language,$province,$county,$city,$address,$postal_code,$mobile_code);

//if($_SESSION['langSessId']=='eng')
if($_POST['password'] != ''){

if($language=='English') 
{
$subject='Your activation key for your kpasapp.com account!';

$body='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
<tbody><tr>
	<td valign="top" align="center">

		<table width="100%" cellspacing="0" cellpadding="0">                  
			 
			<tbody><tr>
				<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
					<center>
						<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$obj_base_path->base_path().'">
						<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'.$obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
					</center>
										</td>
			</tr>
						</tbody></table>

		<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
			<tbody><tr>
			  <td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
					<p style="margin-top:0px"></p>
					<div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Dear '.$fname.'</div>

				
			    <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thank you for joining kpasapp.com!<br><br>
					  For your records, your login is: '.$email.' or ('.$country_code.') '.$phone.'

                  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><a target="_blank" href="'.$obj_base_path->base_path().'/activate_user/'.$user_id.'" style="font-weight:bold;">Click here to Activate your login.</a>
                  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><strong id="docs-internal-guid-41d2b438-2620-af16-b214-944f15f673bf">If you are unable to open the hyperlink above, copy and paste the following URL into your internet browser (if the link is split into two lines, be sure to copy both lines): "'.$obj_base_path->base_path().'/activate_user/'.$user_id.'"</strong>                                    
                  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"> Once your login has been activated, you can begin using your KPasapp account and setup your profile to fully take advantage of the numerous features of KPasapp.com, your passport to all the events of Baja California Sur.                    
                <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">                                        With a warm welcome.<br>
                <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">The KPasapp Team<br>
                    Do not reply to this email.<br>
              Email us at info@kpasapp.com if you require additional assistance.</td>
			</tr>
			<tr>
			<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:5px 10px">
						<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
							<div style="float:right">
	<a target="_blank" href="http://twitter.com/tickethype"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/twitter_icon.png"></a>
	<a target="_blank" href="http://www.facebook.com/tickethype"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/facebook_icon.png"></a>
	<a target="_blank" href="#"><img width="43" border="0" src="'.$obj_base_path->base_path().'/images/youtube_icon.png"></a>
	</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
					</td>
				</tr>
						</tbody></table>
	</td>
</tr>
</tbody></table>';
}
else
{
$subject='Su clave de activación para su cuenta kpasapp.com!';
$body='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
<tbody><tr>
	<td valign="top" align="center">
		<table width="100%" cellspacing="0" cellpadding="0">                  
		  <tbody><tr>
			  <td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
			    <center>
				    <a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$obj_base_path->base_path().'">
				    <img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'.$obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
			    </center>
			  </td>
		      </tr>
		</tbody></table>
		<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
			<tbody><tr>
			  <td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
					<p style="margin-top:0px"></p>
					<div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px"><strong id="docs-internal-guid-2a53dcf4-cf71-79c7-e78d-b719f4163692">Estimado </strong> '.$fname.'</div>

				
			    <p dir="ltr"><strong id="docs-internal-guid-2a53dcf4-cf71-4930-5290-27dd9f591481">Gracias por unirse a kpasapp.com !</strong><br><br>
				  <strong id="docs-internal-guid-2a53dcf4-cf72-a832-6bd1-e3d64f59b2cc">Para sus archivos, su login es:</strong> '.$email.' or ('.$country_code.') '.$phone.' </p>
				  <p dir="ltr"><a target="_blank" href="'.$obj_base_path->base_path().'/activate_user/'.$user_id.'" style="font-weight:bold;">Haga clic aqu&#237; para activar su login.</a>			      </p>
				  <p dir="ltr"><strong id="docs-internal-guid-41d2b438-260b-4578-7486-b278d6d5827a">Si no son capaces de abrir el hiperv&#237;nculo anterior, copie y pegue el siguiente URL en su navegador de internet (si el enlace se divide en dos l&#237;neas, asegúrese de copiar ambas l&#237;neas):  "'.$obj_base_path->base_path().'/activate_user/'.$user_id.'"</strong></p>
				  <p dir="ltr">Una vez que su login se ha activado, puede comenzar utilizando su cuenta KPasapp y configurar su perfil para aprovechar al m&aacute;ximo las numerosas caracter&#237;sticas de KPasapp.com, su pasaporte para todos los eventos de Baja California Sur.</p>
				  <p dir="ltr">Con una c&aacute;lida bienvenida.<br>
					  <br>
					  
					  
					  El Equipo de KPasapp<br>
                      No responda a este correo electr&oacute;nico.<br>
                      Email nosotros en info@kpasapp.com si necesita ayuda adicional.<br>
		      </p></td>
			</tr>
			<tr>
			<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
						<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
							<div style="float:right">
	<a target="_blank" href="http://twitter.com/tickethype"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/twitter_icon.png"></a>
	<a target="_blank" href="http://www.facebook.com/tickethype"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/facebook_icon.png"></a>
	<a target="_blank" href="#"><img width="43" border="0" src="'.$obj_base_path->base_path().'/images/youtube_icon.png"></a>
	</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
					</td>
				</tr>
	</tbody></table>
	</td>
</tr>
</tbody></table>';
}


//echo $body;exit;
//send email
if($user_id>0)
$obj_sendmail->merchant_login_mail($subject,$email,$user_id,$body);	
	


//if($_SESSION['langSessId']=='eng') 
if($_SESSION['langSessId'] == 'eng') 
{
	if($phone==""){
		$_SESSION['user_msg'] = "<span style='font:normal 16px/20px Arial,Helvetica,sans-serif; font-style:italic;'>An activation link has been sent to ".$email.".<br>Please check your email and click on the link to activate your KPasapp account.</span><br>
	<span style='font:normal 12px/20px Arial,Helvetica,sans-serif;'>If you do not receive the Activation email within 5 minutes please check your Spam or Junk folders to ensure safe delivery. If you think that there has been a problem with delivery of the email please contact us at info@kpasapp.com.</span>";
	}
	else{
		$_SESSION['user_msg'] = "<span style='font:normal 16px/20px Arial,Helvetica,sans-serif; font-style:italic;'>An activation link has been sent to ".$email." (or ".$phone.").<br>Please check your email (or SMS) and click on the link to activate your KPasapp account.</span><br>
	<span style='font:normal 12px/20px Arial,Helvetica,sans-serif;'>If you do not receive the Activation email within 5 minutes please check your Spam or Junk folders to ensure safe delivery. If you think that there has been a problem with delivery of the email please contact us at info@kpasapp.com.</span>";
	}
}
else{
	if($phone==""){
		$_SESSION['user_msg'] = "<span style='font:normal 16px/20px Arial,Helvetica,sans-serif; font-style:italic;'>Un enlace de activaci&oacute;n ha sido enviado a  ".$email." .<br>Por favor, consulta su correo electr&oacute;nico y haga clic en el enlace para activar su cuenta KPasapp.</span><br>
	<span style='font:normal 12px/20px Arial,Helvetica,sans-serif;'>Si no recibe el e-mail de activaci&oacute;n en 5 minutos por favor revise su carpeta de spam o basura para asegurar entrega segura. Si usted piensa que ha habido un problema con el env&#237;o del correo electr&oacute;nico, por favor cont&aacute;ctenos a info@kpasapp.com.</span>";	}
	else{
		$_SESSION['user_msg'] = "<span style='font:normal 16px/20px Arial,Helvetica,sans-serif; font-style:italic;'>Un enlace de activaci&oacute;n ha sido enviado a  ".$email." (or ".$phone.").<br>Por favor, consulta su correo electr&oacute;nico (SMS) y haga clic en el enlace para activar su cuenta KPasapp.</span><br>
	<span style='font:normal 12px/20px Arial,Helvetica,sans-serif;'>Si no recibe el e-mail de activaci&oacute;n en 5 minutos por favor revise su carpeta de spam o basura para asegurar entrega segura. Si usted piensa que ha habido un problema con el env&#237;o del correo electr&oacute;nico, por favor cont&aacute;ctenos a info@kpasapp.com.</span>";
	}
}

}
  
  // Added By Amit ===================
  $_SESSION['ses_admin_id'] = $user_id;
  $_SESSION['name'] = $fname." ". $lname;
  if($_SESSION['cid'] != '')
  {
      foreach($_SESSION['cid'] as $data){
	$obj_cart->update_cart($data,$_SESSION['ses_admin_id'],$_SESSION['unique']);
      }
  }
  
 
?>   
    <script language="javascript">
      window.location = '<?php echo $obj_base_path->base_path()?>/payment/<?php echo $_GET['event_id']?>';
    </script>
 <?php  
  
  //header("Location:".$obj_base_path->base_path()."/payment/".$_GET['event_id']);
  exit;
  // Added By Amit ===================


}



if(isset($_POST['pay_edit']) && $_POST['pay_edit'] == 1)
{	
	
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$mobile_code=$_POST["mobile_code"];
	$country_id=$_POST["country_id"];
	$province=$_POST["province"];
	$county=$_POST["county"];
	$city=$_POST["city"];
	$address=$_POST["address"];
	$postal_code=$_POST["postal_code"];
	$pay_eid=$_POST["pay_eid"];
	
	//print_r($_POST);exit;
	//if(isset($_POST["act_event"]) && $_POST["act_event"]==1) $act_event=$_POST["act_event"]; else $act_event=0;
	//if(isset($_POST["act_venue"]) && $_POST["act_venue"]==1) $act_venue=$_POST["act_venue"]; else $act_venue=0;
	//if(isset($_POST["act_perform"]) && $_POST["act_perform"]==1) $act_perform=$_POST["act_perform"]; else $act_perform=0;
	//if(isset($_POST["act_provider"]) && $_POST["act_provider"]==1) $act_provider=$_POST["act_provider"]; else $act_provider=0;
	//if(isset($_POST["act_sponser"]) && $_POST["act_sponser"]==1) $act_sponser=$_POST["act_sponser"]; else $act_sponser=0;
	
	
	$faq->checkEmailexists($email,$_SESSION['ses_admin_id']);
	//echo $faq->num_rows().'sss';exit;
	//if(!$faq->num_rows() > 0 ) 
	{	
		
	    $edit_admin->edit_admin_details_new($fname,$lname,$email,$phone,$country_id,$province,$county,$city,$address,$postal_code,$_SESSION['ses_admin_id'],$mobile_code);
	}
	//else
	//{
	//	$_SESSION['err'] = "Email Id Already Exists!";
	//	header("Location:".$obj_base_path->base_path()."/payment/".$pay_eid);
	//	exit;
	//}

}

//echo '<br><br><br>'.$_SESSION['ses_admin_id'].','.$_SESSION['unique'].','.$e_id.'<br><br><br>';
$obj_cart_details->getCartDetails($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
					
if($obj_cart_details->num_rows() == 0){ 
	//echo "hi ".$e_id; exit;
	header("location:".$obj_base_path->base_path()."/event/".$e_id); 
	exit;
}

  $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
  $obj_ticket->next_record();
  if($obj_ticket->f('mx_price') != '' && $obj_ticket->f('us_price') == 0){					
    $_SESSION['pay'] = 'mx';
  }
  elseif($obj_ticket->f('us_price') != '' && $obj_ticket->f('mx_price') == 0){
    $_SESSION['pay'] = 'us';
  }
  elseif($obj_ticket->f('us_price') != '' && $obj_ticket->f('mx_price') != 0){
    $_SESSION['pay'] = 'us';
  }
  
  if($_GET['act'] != ''){
	  unset($_SESSION['pay']);
	  $_SESSION['pay'] = $_GET['act'];
  }

/*if($_POST['type'] != '' && $_POST['type'] == 'checkout'){
	//echo "<pre>";
	//print_r($_POST); exit;
	if($_POST['payment_type'] == 'standard'){
		
		?>
		<script>
		  $("#contact").action('<?php echo $obj_base_path->base_path();?>/standard/pay.php');
		  $("#contact").submit();
		</script>
		<?php
		//header("location: ".$obj_base_path->base_path()."/standard/pay.php");
	}
	if($_POST['payment_type'] == 'pro'){
		
		?>
		<script>
		  $("#contact").action('<?php echo $obj_base_path->base_path();?>/pro/pay.php');
		  $("#contact").submit();
		</script>
		<?php
		//header("location: ".$obj_base_path->base_path()."/pro/pay.php");
	}
}*/


	$obj_count->getCartCount($_SESSION['ses_admin_id'],$_SESSION['unique']);
	if($obj_count->num_rows()==0){
		header("location: ".$obj_base_path->base_path()."/index");
	}

//print_r($_SESSION);
if($_GET['action'] == 'del' && $_GET['tid'] !=''){
	//echo "hihih".$e_id; exit;
	$obj_remove->remove($_GET['tid']);
	$obj_remove->next_record();
	header("location: ".$obj_base_path->base_path()."/payment/".$e_id);
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>
<script type="text/javascript">

$(document).ready(function() {
		
	$('#loading').hide();
        //options( 1 - ON , 0 - OFF)
        var auto_slide = 0;
        var hover_pause = 1;
        var key_slide = 1;
        
        //speed of auto slide(
        var auto_slide_seconds = 500;
        /* IMPORTANT: i know the variable is called ...seconds but it's 
        in milliseconds ( multiplied with 1000) '*/
        
        /*move he last list item before the first item. The purpose of this is 
        if the user clicks to slide left he will be able to see the last item.*/
		
        //$('#carousel_ul li:first').before($('#carousel_ul li:last')); 
        
        //check if auto sliding is enabled
        if(auto_slide == 1){
            /*set the interval (loop) to call function slide with option 'right' 
            and set the interval time to the variable we declared previously */
            var timer = setInterval('slide("right")', auto_slide_seconds); 
            
            /*and change the value of our hidden field that hold info about
            the interval, setting it to the number of milliseconds we declared previously*/
            $('#hidden_auto_slide_seconds').val(auto_slide_seconds);
        }
  
        //check if hover pause is enabled
       /* if(hover_pause == 1){
            //when hovered over the list 
            $('#carousel_ul').hover(function(){
                //stop the interval
                clearInterval(timer)
            },function(){
                //and when mouseout start it again
                timer = setInterval('slide("right")', auto_slide_seconds); 
            });
  
        }*/
  
        //check if key sliding is enabled
        if(key_slide == 1){
            
            //binding keypress function
            $(document).bind('keypress', function(e) {
                //keyCode for left arrow is 37 and for right it's 39 '
                if(e.keyCode==37){
                        //initialize the slide to left function
                        slide('left');
                }else if(e.keyCode==39){
                        //initialize the slide to right function
                        slide('right');
                }
            });

        }
        
        
  });

//FUNCTIONS BELLOW

//slide function  
function slide(where){
    
            //get the item width
            var item_width = $('#carousel_ul li').outerWidth() + 500;
            
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/
            if(where == 'left'){
                //...calculating the new left indent of the unordered list (ul) for left sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) + item_width;
            }else{
                //...calculating the new left indent of the unordered list (ul) for right sliding
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;
            
            }
            
            
            //make the sliding effect using jQuery's animate function... '
            $('#carousel_ul:not(:animated)').animate({'left' : left_indent},0,function(){    
                
                /* when the animation finishes use the if statement again, and make an ilussion
                of infinity by changing place of last or first item*/
                if(where == 'left'){
                    //...and if it slided to left we put the last item before the first item
                    $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                }else{
                    //...and if it slided to right we put the first item after the last item
                    $('#carousel_ul li:last').after($('#carousel_ul li:first')); 
                }
                
                //...and then just get back the default left indent
                $('#carousel_ul').css({'left' : '0px'});
            });
            
            
            
             
           
}
  
  
function tkt_num(count,cart_id,event_id){
	sendData = {"count":$("#ticket_num"+count).val(),"cart_id":cart_id,"event_id":event_id};
	//alert(event_id);
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_ticket_num.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#checkout_frm").html(data);
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
    //else
    {
	$('#loading').show();
	sendData = {"email":$("#email_cell").val()};
	//alert($("#email_cell").val());
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_check_user.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   	$('#loading').hide();
		$("#new").html(data);
	   }
	 });
    }
  
	
}

function validate_new(){
  $("#err_log_pass").html('');
  var password=$("#pass_signin").val();
  var err = 0;
  if (password=='') { $("#err_log_pass").html('Please enter password.'); err = 1; }
  if(err == 0) return true; else return false;
}

function validate(){
  
  $("#err_fname").html('');
  $("#err_lname").html('');
  $("#err_country").html('');
  $("#err_city").html('');
  $("#err_address").html('');
  $("#err_postal_code").html('');
  //$("#err_password").html('');
  //$("#err_re_pass").html('');
  
  var fname=$("#fname").val();
  var lname=$("#lname").val();
  var country=$("#country_id").val();
  var province=$("#province").val();
  var city=$("#city").val();
  var address=$("#address").val();
  var postal_code=$("#postal_code").val();
  //var password=$("#password").val();
  //var repass=$("#re_pass").val();
  
  var err = 0;
  if (fname=='' || fname==null) { $("#err_fname").html('Please input First Name.'); err = 1; }
  if (lname=='' || lname==null) { $("#err_lname").html('Please input Last Name.'); err = 1; }
  if (country=='' || country==null) { $("#err_country").html('Please select a country.'); err = 1; }
  if (province=='' || province==null) { $("#err_province").html('Please select a state.'); err = 1; }
  if (city=='' || city==null) { $("#err_city").html('Please input a city.'); err = 1; }
  if (address=='' || address==null) { $("#err_address").html('Please type your address.'); err = 1; }
  if (postal_code=='' || postal_code==null) { $("#err_postal_code").html('Please type your postal code.'); err = 1; }
  //if (password=='' || password==null) { $("#err_password").html('Enter your password.'); err = 1; }
  //if (repass=='' || repass==null) { $("#err_re_pass").html('Retype your password.'); err = 1; }
  //if (repass != password && password != '' && repass != '') { $("#err_re_pass").html('Password Mismatch.'); err = 1; }
  
  if(err == 0) return true; else return false;
}
</script>

<script type="text/javascript">
function checkLoggedin(){
	<?php
		if($_SESSION['ses_admin_id']==""){
	?>
		$('html, body').animate({scrollTop: parseInt($("#text_email").offset().top) - 100}, 2000);
		$('#email_cell').focus();
	<?php
		} else{
	?>
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/checkSavedEvent.php",
		   cache: false,
		   type: "POST",
		   data: "event_id=<?php echo $event_id;?>",   
		   success: function(data){
			  // alert(data);
			   if(data==1){
				$('#alrdy_svd_evnt1').trigger('click');
			   }
			   else
			   {
		  	 	window.location = "<?php echo $obj_base_path->base_path(); ?>/add_saved_events.php?event_id=<?php echo $event_id;?>";
			   }
		   }
		 });
		
	<?php }?>
	
}

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#alrdy_svd_evnt1").fancybox({ 
			'hideOnOverlayClick':false,
			'hideOnContentClick':false,
			'onComplete': function(){
				setTimeout( function() {$.fancybox.close(); },2000); // 3000 = 3 secs
			  }
		});
	});
	
function setHover1(val,setDateTime,multi_id,event_id)
{
	//alert(multi_id);
	//alert(event_id);
	$("#frm_multi_id").val(multi_id);
	$("#frm_event_id").val(event_id);
	
	$('.abc').css({"color":"#FFFFFF","font-size":"12px","font-weight":"normal"});

	$('#tbl1'+val).css({"color":"red","font-size":"15px","font-weight":"bold"});
	$('.timetxt').html(setDateTime);
}

function addtocart(num,mx,us)
{
	//alert(val)
	$("#frm_ticket"+num).val($("#ticket_num"+num).val());
	$("#frm_mx_price"+num).val(mx);
	$("#frm_us_price"+num).val(us);
}

function save(){
	$("#frm").submit();
}

function contactfrm(){
	$("#contact").submit();
}
	

function pay_type(type){
	var err = 0;
	if(document.contact.fname.value.search(/\S/) == -1){
		alert("Please enter your First name.");
		document.contact.fname.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.lname.value.search(/\S/) == -1){
		alert("Please enter your Last name.");
		document.contact.lname.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.email.value.search(/\S/) == -1){
		alert("Please enter your Email.");
		document.contact.email.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.country_id.value.search(/\S/) == -1){
		alert("Please select your Country.");
		document.contact.country_id.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.province.value.search(/\S/) == -1){
		alert("Please select your State.");
		document.contact.province.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.city.value.search(/\S/) == -1){
		alert("Please enter your City.");
		document.contact.city.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.address.value.search(/\S/) == -1){
		alert("Please enter your Address.");
		document.contact.address.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	else if(document.contact.postal_code.value.search(/\S/) == -1){
		alert("Please enter your Postal code.");
		document.contact.postal_code.focus();
		document.getElementById(type).checked = false;
		err = 1;
	}
	
	else if(document.contact.email.value != '')
	{
		var email = document.getElementById('email');
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email.value)) {
		alert('Please provide a valid email address');
		document.contact.email.focus();
		document.getElementById(type).checked = false;
		err = 1;
		}
	}	
	
	if(err == 0){
		if(type == 'standard'){
			//alert('<?php echo $obj_base_path->base_path()?>/standard/pay.php');
			//document.frm.action = '<?php echo $obj_base_path->base_path()?>/standard/pay.php';
			//$("#frm").submit();
			document.contact.payment_type.value = 'standard';
			
		}
		else if(type == 'pro'){
			//alert('<?php echo $obj_base_path->base_path()?>/standard/pay.php');
			//document.frm.action = '<?php echo $obj_base_path->base_path()?>/pro/pay.php';
			//$("#frm").submit();
			document.contact.payment_type.value = 'pro';
		}
	}
	//alert(<?php echo $_SESSION['ses_admin_id'];?>);
	//$("#u_id").val('<?php echo $_SESSION['ses_admin_id'];?>');
}


function new_checkout(){
  //alert($("#payment_type").val());
  if ($("#payment_type").val() == 'standard'){
     $('#contact').attr('action', '<?php echo $obj_base_path->base_path();?>/standard/pay.php');
     $("#contact").submit();
  }
  else if ($("#payment_type").val() == 'pro') {
    $('#contact').attr('action', '<?php echo $obj_base_path->base_path();?>/pro/pay.php');
    $("#contact").submit();
  }
}

	
function setCountryCode()
{
    // $('#div_county_display').html('<select name="county" id="county" class="textbg_grey" style="width:205px; margin-left:5px;"><option value="">County</option></select>');
	// $('#div_city_display').html('<select name="city" id="city" class="textbg_grey" style="width:205px; margin-left:5px;"><option value="">City</option></select>');
	
	sendData = {"country_id":$('#country_id').val()};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_set_country_code.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#country_code").val(data);
	   }
	 });
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_state_bycountry.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#div_state_display").html(data);
	   }
	 });
}


function display(){
  $("#display").show();
}

function change(eid,type) {
  //alert("hi"+eid+type);
  window.location.href='<?php echo $obj_base_path->base_path()?>/payment.php?event_id='+eid+'&act='+type+'';
}
</script>
<div style="display:none;">
    <div style="width:400px;height:auto; background:#FFF; padding:10px; font-size:19px;" id="alrdy_svd_evnt">
       You already saved this event.
    </div>
</div>
<a href="#alrdy_svd_evnt" id="alrdy_svd_evnt1"></a>

</head>
<body>
<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>
<div id="maindiv">	
	<div class="clear"></div>
	<div class="body_bg">    	
    	<div class="clear"></div>
    	<div class="container">
        	<div class="left_panel bg">
            
            <div style="text-align:center;margin-bottom: 10px; color: red;"><?php //if($_SESSION['err'] != ''){ echo $_SESSION['err']; unset($_SESSION['err']); }
	    if($_SESSION['user_msg'] != ''){ echo $_SESSION['user_msg']; unset($_SESSION['user_msg']); }?></div>
            <div class="clear"></div>
            
            	
                <div class="clear"></div>
		  <div class="view_box7">
                	<div class="heading"><?php if($_SESSION['langSessId']=='eng') {?>Checkout<?php }elseif($_SESSION['langSessId']=='spn'){?>finalizar pedido<?php }?></div>
                	<div class="hot_event7">
			<?php
			$obj_cart_details->next_record();
			$event_id = $obj_cart_details->f('event_id');
			//$payment =  $obj_cart_details->f('payment');
			$ticket_id =  $obj_cart_details->f('ticket_id');
			$multi_id  =  $obj_cart_details->f('multi_id');
			$cart_id = $obj_cart_details->f('cart_id');
			$ticket = $obj_cart_details->f('ticket');
			//$_SESSION['payment'] = $payment;
			// Event Details
			$objEvent->getEventDetails($event_id);
			$objEvent->next_record();
					
					
			if($_SESSION['langSessId']=='eng') {
					    $name = $objEvent->f('event_name_en');
					    ?>
			<h1><?php echo $objEvent->f('event_name_en');?></h1> 
                    <?php
                    }
					elseif($_SESSION['langSessId']=='spn')
					{
					$name = $objEvent->f('event_name_sp');
					?>
                    <h1><?php echo $objEvent->f('event_name_sp');?></h1> 
					<?php 
					}
					?>
                    <?php
					$start = $obj_cart_details->f('start');
					$end = $obj_cart_details->f('end');
					$date = $obj_cart_details->f('sdate');
					$edate = $obj_cart_details->f('edate');
					?>
					<p><?php echo date("l, m, d, Y",strtotime($date))." ".$start;?> - <?php if($obj_cart_details->f('sdate') != $obj_cart_details->f('edate')){ echo date("l, m, d, Y",strtotime($edate))." ";} echo $end;?></p>
					<p><?php echo $objEvent->f('venue_name');?></p>
					<p><?php echo $objEvent->f('venue_address');?></p>
					<p><?php echo $objEvent->f('city_name');?>, <?php echo $objEvent->f('county_name');?>, <?php echo $objEvent->f('state_name');?></p>                
                    </div>
			<div class="clear"></div>
		  </div>
		  <div class="view_box7">
                	<div class="heading"><?php if($_SESSION['langSessId']=='eng') {?>Review your order<?php }elseif($_SESSION['langSessId']=='spn'){?>Revise su pedido<?php }?></div>
                	<div class="hot_event7">
                    <div><span> <span style="float: right; padding: 0; margin: 0 auto; width: 365px;"><strong>
					<?php if($_SESSION['langSessId']=='eng') {
						if($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0){
						?>
                    		Select payment currency:
                    <?php
						}
						else
						{
							echo "Payment Currency:"; 
						}
                    }
					elseif($_SESSION['langSessId']=='spn'){
					if($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0){
					?>
                    		Seleccione moneda de pago:
                    <?php 
						}
						else
						{
							echo "moneda de pago:";
						}
					}
					?>
                    
                    <?php
					
					
					//echo $obj_ticket->f('mx_price');
					//echo $obj_ticket->f('us_price');
					
                    if($obj_ticket->f('mx_price') != 0 && $obj_ticket->f('us_price') == 0){?>
<?php if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php }?> <!--<a href="<?php //echo $obj_base_path->base_path()."/payment.php?act=mx"; ?>"><input type="radio" name="cur" id="" value="" <?php //if($_SESSION['pay'] == 'mx'){ echo "checked";}?> /></a>-->
					<?php
                    }elseif($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') == 0)
					{
					?>
 <?php if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php }?> <!--<a href="<?php //echo $obj_base_path->base_path()."/payment.php?act=us"; ?>"><input type="radio" name="cur" id="" value="" <?php //if($_SESSION['pay'] == 'us'){ echo "checked";}?> /></a> -->
 					<?php
                    }
					elseif($obj_ticket->f('us_price') != 0 && $obj_ticket->f('mx_price') != 0)
					{
					?>
<?php if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php }?> <input type="radio" name="cur" onclick="change(<?php echo $e_id;?>,'mx');" id="" value="" <?php if($_SESSION['pay'] == 'mx'){ echo "checked";}?> />

<?php if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php }?> <input type="radio" name="cur" onclick="change(<?php echo $e_id;?>,'us');" id="" value="" <?php if($_SESSION['pay'] == 'us'){ echo "checked";}?> />

					<?php
                    }
					?>
 					</strong></span></span></div>
					<div class="clear"></div>
					<div class="hot_event7">
					 <div  id="checkout_frm">
                      <form action="" name="frm" id="frm" method="post">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="event_review">
                        <tr>
                          <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Quantity<?php }elseif($_SESSION['langSessId']=='spn'){?>Cantidad<?php }?></th>
                          <th width="17%"><?php if($_SESSION['langSessId']=='eng') {?>TicketName<?php }elseif($_SESSION['langSessId']=='spn'){?>Boleto<?php }?></th>
                          <th width="16%"><?php if($_SESSION['langSessId']=='eng') {?>Price<?php }elseif($_SESSION['langSessId']=='spn'){?>Precio<?php }?></th>
                          <th width="15%"><?php if($_SESSION['langSessId']=='eng') {?>Fee<?php }elseif($_SESSION['langSessId']=='spn'){?>Cargos<?php }?></th>
                          <th width="20%"><?php if($_SESSION['langSessId']=='eng') {?>Total<?php }elseif($_SESSION['langSessId']=='spn'){?>Total<?php }?></th>
                          <th width="16%">&nbsp;</th>
                        </tr>
                        
                        <?php 
			  $count = 1;
			  //echo $e_id; exit;
			  $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique'],$e_id);
			  while($row = $obj_ticket->next_record()){
			  ?>
                        
                        <tr>
                          <td>
			    <select name="ticket_num" id="ticket_num<?php echo $count;?>" onChange="tkt_num(<?php echo $count;?>,<?php echo $obj_ticket->f('cart_id');?>,<?php echo $e_id;?>);">
							<?php for($i=1;$i<=$obj_ticket->f('ticket_num');$i++) {?>
                                <option value="<?php echo $i;?>" <?php if($i == $obj_ticket->f('ticket')){ echo "selected";}?>><?php echo $i;?></option>
                            <?php } ?>
                             </select>
						  <?php //echo $obj_ticket->f('ticket');?></td>
                          <td>
                          <?php
                          if($_SESSION['langSessId']=='eng') {
						  	echo $obj_ticket->f('ticket_name_en');
						  }
						  elseif($_SESSION['langSessId']=='spn')
						  {
						    echo $obj_ticket->f('ticket_name_sp');
						  }
						  ?>
                          </td>
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo number_format($obj_ticket->f('us_price'),2,'.',',');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo number_format($obj_ticket->f('mx_price'),2,'.',',');
						  }
						  ?></td>
                          <td></td>
                          <td><?php 
						  if($_SESSION['pay'] == 'us'){
						  	echo number_format($obj_ticket->f('ticket')*$obj_ticket->f('us_price'),2,'.',',');
						  }elseif($_SESSION['pay'] == 'mx'){
						  	echo number_format($obj_ticket->f('ticket')*$obj_ticket->f('mx_price'),2,'.',',');
						  }
						  ?></td>
                          <td><a href="<?php echo $obj_base_path->base_path()."/payment.php?event_id=".$e_id."&action=del&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
                        </tr>
                        
                        <?php
                        	$count++;
						}
						?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><strong>Total : <?php $obj_total->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total->next_record(); //echo $obj_total->f('Total');?></strong>
                          <input type="hidden" name="ticket" value="<?php echo $obj_total->f('Total');?>" />
                          </td>
                          <td><strong>Total : <?php $obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay'],$_SESSION['unique'],$e_id,$obj_cart_details->f('cart_id')); $obj_total->next_record(); echo number_format($obj_total->f('Amt'),2,'.',',');?></strong></td>
                          <td><?php if($_SESSION['pay'] == 'us'){ if($_SESSION['langSessId']=='eng') {?>  US$ <?php }elseif($_SESSION['langSessId']=='spn'){?>EE.UU. $<?php } }elseif($_SESSION['pay'] == 'mx'){ if($_SESSION['langSessId']=='eng') {?>  MX Pesos <?php }elseif($_SESSION['langSessId']=='spn'){?> Pesos MX <?php } }?></td>
                        </tr>
                        <tr>
                        	<td colspan="6" style="text-align:right;"><!--<input type="submit" value="Checkout" /> <input type="submit" value="Update" />--></td>
                        </tr>
                      </table>
                      	<!--<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
                        <input type="hidden" name="amount" value="<?php echo $obj_total->f('Amt');?>" />
                        <input type="hidden" name="payment_type" id="payment_type" value="" />
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
                        <input type="hidden" name="multi_id" value="<?php echo $multi_id;?>" />
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['ses_admin_id'];?>" />
                        <input type="hidden" name="name" value="<?php echo $name;?>" />-->
                      </form>
                      </div>                      
					</div>
                    </div>
			<div class="clear"></div>
		  </div>				
		  <div class="clear"></div>
				
			
              <div class="blue_bg" style="margin: 0 auto;"><?php if($_SESSION['langSessId']=='eng') {?>Buyers Information<?php }elseif($_SESSION['langSessId']=='spn'){?>Informaci&oacute;n del comprador<?php }?></div> 
	      <div class="clear"></div>
			  
              <?php if($_SESSION['ses_admin_id'] == ''){
			  //echo $authUrl;
			  ?>
              <form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete="on">
              <!--<input type="hidden" name="hid_sign" id="hid_sign" value="1" />-->
              <div class="account_bg" style=" width: 666px; height: 52px; margin: 0; border: 1px solid #555; border-top: 0px; border-bottom: 0px;">
	      <?php if($_SESSION['langSessId']=='eng') {?>
	      For your convenience and security,<br /> you can sign in with your social accounts:
	      <?php }elseif($_SESSION['langSessId']=='spn'){?>
	      Para su conveniencia y seguridad,<br /> puedes acceder con sus cuentas sociales:
	      <?php }?>
              <br />
              <span class="field_bg" style="width: 349px;margin: -46px 10px; background: none; border: 0; text-align:center; font: normal 24px/46px Arial, Helvetica, sans-serif; color: #134f5c;">
			  <?php if($_SESSION['langSessId']=='eng') {?>
			  Sign in with
			  <?php }elseif($_SESSION['langSessId']=='spn'){?>
			  Entrar con
			  <?php }?>
			  <a href="<?php echo $obj_base_path->base_path(); ?>/login-facebook.php"><img src='<?php echo $obj_base_path->base_path(); ?>/images/facebook_blue.gif' width="40" height="46" border="0"/></a>
			  <a href="<?php echo $authUrl; ?>"><img src='<?php echo $obj_base_path->base_path(); ?>/images/4google_blue.gif' width="40" height="46" border="0"/></a>
			  <!--<strong>
			  <?php if($_SESSION['langSessId']=='eng') {?>
			  OR
			  <?php }elseif($_SESSION['langSessId']=='spn'){?>
			  O
			  <?php }?>
			  </strong> -->
              <!--<input type="text" name="email_cell" id="email_cell" class="textbg_grey" placeholder="<?php if($_SESSION['langSessId']=='eng') {?>Email or Cell#<?php }elseif($_SESSION['langSessId']=='spn'){?>Email o celular #<?php }?>" style="width: 150px;"/>  
              <input type="password" name="pass_signin" id="pass_signin" class="textbg_grey" placeholder="<?php if($_SESSION['langSessId']=='eng') {?>Password<?php }elseif($_SESSION['langSessId']=='spn'){?>Contraseña<?php }?>" style="width: 150px;"/>
              <input type="submit" name="Submit" value="<?php if($_SESSION['langSessId']=='eng') {?>Sign in<?php }elseif($_SESSION['langSessId']=='spn'){?>Entrar<?php }?>" class="btn1_sudip"/>-->
              </span>			    
		 	 </div>
         	 </form>
         	 <?php }?>
		   
		 <div class="clear"></div>
		 <div class="account_box" style=" width: 682px; margin-bottom: 19px; margin-top: 0px;">
		 <div class="account_left">
         
         	<!--form-->
	
            <?php
		if($_SESSION['ses_admin_id'] != ''){
		//echo $_SESSION['ses_admin_id'];
			$obj->getAdminById($_SESSION['ses_admin_id']);
			$obj->next_record();
		}
	    ?>
           <form method="post" action="" enctype="multipart/form-data" name="contact" id="contact" autocomplete = "off">
           <?php if($_SESSION['ses_admin_id'] == ''){?>
           <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
           	 <tr>
                <td width="40%" style=" vertical-align: middle; line-height: 24px;">
		<?php if($_SESSION['langSessId']=='eng'){
		  echo "Or let’s check your email address ";
		  }elseif($_SESSION['langSessId']=='spn'){
		    echo "O vamos a comprobar su direcci&oacute;n de correo electr&oacute;nico.";
		    } ?></td>
                <td width="30%">
                <input type="text" name="email_cell" id="email_cell" class="textbg_grey" style="width: 240px; height: 24px; border: 1px solid #777; margin: 0 6px; outline: none;" value="<?php echo $obj->f('email')?>" />
                </td>
                <td>
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
		</td>
              </tr>
	      <tr>
		<td colspan="3"><div style="text-align:center;margin-bottom: 10px; color: red;"><?php if($_SESSION['err'] != ''){ echo $_SESSION['err']; unset($_SESSION['err']); }?></div>
		</td>
	      </tr>
              <tr>
              		<td colspan="3"><div id="loading" style="text-align: center;"><img src="<?php echo $obj_base_path->base_path(); ?>/images/loading.gif" height="100" width="100" /></div></td>
              </tr>
           </table>
           <div id="new"></div>
           <?php 
	    }
	    else
	    {
	  ?>
	  <input type="hidden" name="pay_edit" id="pay_edit" value="1">
	  <input type="hidden" name="pay_eid" id="pay_eid" value="<?php echo $e_id;?>">
	  <input type="hidden" name="language" id="language" value="<?php echo $obj->f('language')?>" />
           <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
               <tr>
                <td width="23%" style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "First Name";}elseif($_SESSION['langSessId']=='spn'){echo "Nombre";} ?> <span style="color:red;">*</span></td>
                    <td width="77%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="<?php echo $obj->f('fname')?>" style="width: 190px;" <?php if($_SESSION['ses_admin_id'] != ''){echo "readonly";}?>/><br/><span class="err" id="err_name"></span></td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Last Name";}elseif($_SESSION['langSessId']=='spn'){ echo "Apellido";} ?><span style="color:red;">*</span></td>
                <td>
                    <input type="text" name="lname" id="lname" class="textbg_grey required" value="<?php echo $obj->f('lname');?>" style="width: 190px;" <?php if($_SESSION['ses_admin_id'] != ''){echo "readonly";}?>/> <br/>
                    <span class="err" id="err_lname"></span>
                </td>
              </tr>						  
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Email";}elseif($_SESSION['langSessId']=='spn'){ echo "Correo Electr&oacute;nico";} ?><span style="color:red;">*</span></td>
                <td>
                <input type="text" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" <?php if($_SESSION['ses_admin_id'] != ''){echo "readonly";}?>/>
                <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>
                </td>
              </tr>
                                          
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Mobile#";}elseif($_SESSION['langSessId']=='spn'){ echo "m&oacute;vil";}?></td>
                <td>
                    <select onChange="display();" name="mobile_code" id="mobile_code" class="textbg_grey" style="width:155px; margin-left:5px;">
                    <?php
                         $obj_cntry = new user;
                        $sel = "selected='selected'";
                         $obj_cntry->countries_list();
                            while($obj_cntry->next_record()){
                    ?>
                        <option value="<?php echo $obj_cntry->f('phonecode');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $obj->f('mobile_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $obj->f('mobile_code')==''){ echo $sel; } else if($obj->f('mobile_code')==$obj_cntry->f('phonecode') && $obj->f('country_id')==$obj_cntry->f('id')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                    <?php
                        }
                    ?>    
                    </select>

                  <input onClick="display();" type="text" name="phone" id="phone" class="textbg_grey" value="<?php echo $obj->f('mobile')?>" style="width: 190px;" />
                                            
                    <div id="sh_alt_phn" style="color:red; margin-left:6px;"></div>
                </td>
              </tr>
              
              
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Country";}elseif($_SESSION['langSessId']=='spn'){ echo "País";}?><span style="color:red;">*</span></td>
                <td>
                    <select onchange="display();" name="country_id" id="country_id" onChange="setCountryCode()" class="textbg_grey" style="width:205px;margin-left:5px;">
                    <?php
                        $value_code = '';
                        $sel = "selected='selected'";
                        if($_SESSION['langSessId']=="spn")
                            $value_code = "value='52'";
                        else
                            $value_code = "value='1'";
                        
                        // check country code for per user
                        if($obj->f('country_code')!="" && $obj->f('country_code')!=0)
                            $value_code = $obj->f('country_code');
                            
                        $obj_country->countries_list();
                        while($obj_country->next_record()){
                    ?>
                        <option value="<?php echo $obj_country->f('id');?>"
			<?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $obj->f('country_id')==0){
			  echo $sel;
			  } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $obj->f('country_id')==0){
			    echo $sel;
			    } else if($obj->f('country_id')==$obj_country->f('id')) {
			      echo $sel;
			      }  ?>><?php echo $obj_country->f('nicename');?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="hidden" name="country_code" id="country_code" value="<?php echo $value_code;?>" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "State";}elseif($_SESSION['langSessId']=='spn'){ echo "Estado";}?><span style="color:red;" id="star1">*</span></td>
                <td>
                  <div id="div_state_display">
		    <?php if($_SESSION['langSessId']=='eng')
			      $temp_country=226;
			  elseif($_SESSION['langSessId']=='spn')
			      $temp_country=138;
		    
		     $selectcountry = $obj->f('country_id') ? $obj->f('country_id') : $temp_country ;
		     $obj_venuestate->getStateById($selectcountry);
		    ?>
                   <select onChange="display();" name="province" id="province" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">State</option>
                        <?php while($row = $obj_venuestate->next_record()) { ?>
                          <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('province')==$obj_venuestate->f('id')){?> selected="selected"<?php }?> >
                            <?php echo $obj_venuestate->f('state_name');?>
			  </option>
                            <?php } ?>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "County";}elseif($_SESSION['langSessId']=='spn'){ echo "Municipio";}?></td>
                <td>
                    <input onClick="display();" type="text" name="county" id="county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('county')?>" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "City";}elseif($_SESSION['langSessId']=='spn'){ echo "Ciudad";}?><span style="color:red; " id="star3">*</span></td>
                <td>
                      <input onClick="display();" type="text" name="city" id="city" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('city')?>" />  
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Address";}elseif($_SESSION['langSessId']=='spn'){ echo "Direcci&oacute;n";}?><span style="color:red;">*</span></td>
                <td>
                <textarea onClick="display();" name="address" id="address" style="width:210px; margin-left: 6px;"><?php echo $obj->f('address')?></textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Postal Code";}elseif($_SESSION['langSessId']=='spn'){ echo "C&oacute;digo Postal";}?><span style="color:red;">*</span></td>
                <td>
                <input onClick="display();" type="text" name="postal_code" id="postal_code" class="textbg_grey" style="width: 190px; margin-right:6px;" value="<?php echo $obj->f('postal_code')?>" />
                </td>
              </tr>
              <div id="display" style="display: none;"><input type="submit" value="<?php if($_SESSION['langSessId']=='eng'){echo "Update";}elseif($_SESSION['langSessId']=='spn'){ echo "Actualizar";}?>" class="btn1_sudip" /></div>
            </table>
		   <?php
           }
		   ?>
            <!--end-->
         
         </div>		
		 </div>
		 <div class="clear"></div>

        <div class="blue_bg">
	<?php if($_SESSION['langSessId']=='eng') {?>
	Select your payment method
	<?php }elseif($_SESSION['langSessId']=='spn'){?>
	Seleccione su forma de pago
	<?php }?>
	</div> 
	<div class="clear"></div>		 
	 <div class="account_box">
	   <div class="account_left">
	   <div class="blue_buy">
	    <?php if($_SESSION['langSessId']=='eng') {?>
	      <h1>Buy : <span>Select your payment option</span></h1>
	      <?php }elseif($_SESSION['langSessId']=='spn'){?>
		  <h1>Comprar : <span>Seleccione su forma de pago</span></h1>
		  <?php }?>
		
		 <div class="clear"></div>
		<div class="blue_inn" align="center">
		<ul>
		<!--<li><a href="javascript:void(0);" ><?php if($_SESSION['langSessId']=='eng') {?>Credit/Debit Card<?php }elseif($_SESSION['langSessId']=='spn'){?>Tarjeta de Cr&eacute;dito/D&eacute;bito<?php }?></a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo5.gif' width="35" height="19" border="0"/><br/>
		  <input name="radiobutton" id="pro" type="radio" value="radiobutton" onClick="pay_type('pro');" disabled="disabled"/></li>-->
		
		<li><a href="#"><?php if($_SESSION['langSessId']=='eng') {?>Paypal<?php }elseif($_SESSION['langSessId']=='spn'){?>Paypal<?php }?></a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo6.gif' width="35" height="19" border="0"/><br/><input name="radiobutton" id="standard" type="radio" value="radiobutton" onClick="pay_type('standard');"/></li>
		
		<!--<li><a href="#"><?php if($_SESSION['langSessId']=='eng') {?>Bank Transfer<?php }elseif($_SESSION['langSessId']=='spn'){?>Transferencia bancaria<?php }?></a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo7.gif' width="40" height="21" border="0"/><br/><input name="radiobutton" id="radiobutton" type="radio" value="radiobutton" disabled="disabled"/></li>-->
		
		<?php if($_SESSION['pay'] == 'mx'){?>
	<!--<li style="border: 0;"><a href="#"><?php if($_SESSION['langSessId']=='eng') {?>Cash<?php }elseif($_SESSION['langSessId']=='spn'){?>efectivo<?php }?></a><br/><img src='<?php echo $obj_base_path->base_path(); ?>/images/logo8.gif' width="44" height="21" border="0"/><br/><input name="radiobutton" id="radiobutton" type="radio" value="radiobutton" disabled="disabled"/></li>-->
	
	<?php }?>
		</ul>
		</div>
	    </div>
	  </div>		 
	  </div>
         
         <?php if($_SESSION['langSessId']=='eng') {?>
	By clicking the "Submit Order" button, you are agreeing to the <a href="<?php echo $obj_base_path->base_path(); ?>/about/privacy-terms">KPasapp.com Purchase Policy and Privacy Policy</a>. All orders are subject to payment approval and billing address verification. Please contact customer service if you have any questions regarding your order.
	<?php }elseif($_SESSION['langSessId']=='spn'){?>
	Al hacer clic en el bot&oacute;n "Enviar pedido", est&aacute;s aceptando la <a href="<?php echo $obj_base_path->base_path(); ?>/about/privacy-terms">Política de Compra y Pol'&#237';tica de Privacidad KPasapp.com</a>. Todos los pedidos est&aacute;n sujetos a la aprobaci&oacute;n de los pagos y a la verificaci&oacute;n de direcciones de facturaci&oacute;n. Por favor, p&oacute;ngase en contacto con atenci&oacute;n al cliente si tiene alguna pregunta acerca de su pedido.
	<?php }?>
	 
        <?php $obj_total_new = new user; $obj_total_new->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total_new->next_record();?>
	<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
	<input type="hidden" name="amount" value="<?php echo $obj_total->f('Amt');?>" />
	<input type="hidden" name="payment_type" id="payment_type" value="" />
	<input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
	<input type="hidden" name="multi_id" value="<?php echo $multi_id;?>" />
	<input type="hidden" name="user_id" id="u_id" value="<?php echo $_SESSION['ses_admin_id'];?>" />
	<input type="hidden" name="name" value="<?php echo $name;?>" />
	<input type="hidden" name="ticket" value="<?php echo $ticket;?>" />
	<input type="hidden" name="cart_id" value="<?php echo $cart_id;?>" />
	<input type="hidden" name="currency" value="<?php echo $_SESSION['pay'];?>" />
	
	
	<input type="hidden" name="type" value="checkout" />
	 <div align="center"><input type="button" onclick="new_checkout();" value="<?php if($_SESSION['langSessId']=='eng') {?>Submit Order<?php }elseif($_SESSION['langSessId']=='spn'){?>Enviar pedido<?php }?>" class="btn1_sudip" /></div>
          </form>                 
          </div>

        <?php include("include/frontend_rightsidebar.php");?>
			
    	</div>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>

<?php if($obj_venue->f('venue_name')!=$obj_venue_sub->f('venue_name')){?>
<script type="text/javascript">
$(document).ready(function(){
	initialize('<?php echo $obj_venue->f('city'); ?>+<?php echo $obj_venue->f('st_name'); ?>+<?php echo $obj_venue->f('venue_zip'); ?>');
})
</script>
<?php } ?>

</body>
</html>