<?php
session_start();

include("./class/db_mysql.inc");
include("./class/user_class.php");
include("./class/pagination.class.php");
include("./class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_adduser = new user;
$obj_sendmail = new user;

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$country_id = $_POST['country_id'];
$country_code = $_POST['country_code'];
$rem_password = $_POST['password'];
$password = md5($_POST['password']);
$account_type = $_POST['account_type'];
$language = $_POST['language'];

if($language == 'English'){
$_SESSION['langSessId'] = 'eng';
}
elseif($language == 'Spanish')
{
$_SESSION['langSessId'] = 'spn';
}

$user_id = $obj_adduser->register_user($fname,$lname,$email,$phone,$country_id,$country_code,$rem_password,$password,$account_type,$language);

//if($_SESSION['langSessId']=='eng') 
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
if($language=='English') 
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


?>		
  

	  
		  
