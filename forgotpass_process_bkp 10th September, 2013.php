<?php
include('include/user_inc.php');
$faq = new user;
$obj_sendmail = new user;

	$loginid = $_POST["email_cell"];
	if($loginid==""){
		$_SESSION['login_msg1'] = "Please insert your email address!";
		//header("Location:".$obj_base_path->base_path()."/forgot_password.php");	
	}
			

 	$faq->checkAdminUser($loginid) ;
	if($faq->num_rows() > 0 ) 
	{	
		$faq->next_record();						
		$rem_password = $faq->f('rem_password');
		$email = $faq->f('email');
		
		$status = $faq->f('activate_status');
		
		//send password email
		//$obj_sendmail->forgot_pass($rem_password,$email);			

		if($status == '0')
		{
			if($_SESSION['langSessId']=='eng')
			{
				/*$_SESSION['login_msg1'] == "Account pending validation.<br />This account has been signed up but is waiting for validation. Please check your messages.<br />
											Do you want to resend the validation instructions? <br />
											Please click on the link.(and resend validation instruction on request)";*/
				echo "Account pending validation.<br />This account has been signed up but is waiting for validation. Please check your messages.<br />
											Do you want to resend the validation instructions? <br />
											Please click on the link.(and resend validation instruction on request)";
			}

		}
		else
		{
			//redirect
			if($_SESSION['langSessId'] == 'eng')
			echo "We've sent a message with information about resetting your password to Email Addess or Cell Phone.<br />Check the Message and follow instructions to reset your password.";
			
			$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
						 <tbody>
							 <tr>
								<td valign="top" align="center">
									<table width="100%" cellspacing="0" cellpadding="0">                  
										<tbody>
											<tr>
												<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
													<center>
														<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
														<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'.$this->base_path().'/images/KPasapp_logo.png"></a>
													</center>
												</td>
											</tr>
										</tbody>
									</table>
									<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
										<tbody>
											<tr>
												<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
													<p style="margin-top:0px"></p>
													<div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">
														You recently requested a password reset for your KPasapp account. To create a new password, click on the link below:<br/>
														<a> Reset Your Password. </a>
													</div>
													<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">
														This request was made on '.date('F d, Y at h:i a').'
													</p>
													<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">&nbsp;</p>
													<p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><br>
													  Regards,<br>
													  KPasapp Member Services<br />
													  ********************************************************<br />
													  Please do not reply to this message. Mail sent to this address cannot be answered.
													</p>
													<p></p>
												</td>
											</tr>
											<tr>
												<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
													<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
														<div style="float:right">
															<a target="_blank" href="https://twitter.com/KPasapp"><img width="" border="0" height="" src="'.$this->base_path().'/images/twitter_icon.png"></a>
															<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="" border="0" height="" src="'.$this->base_path().'/images/facebook_icon.png"></a>
															<a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
														</div>
														<div>
															Copyright &copy; 2013 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							 </tr>
						 </tbody>
					</table>';
					//echo $output; exit;
					//from email
					$this->admin_setting();
					$this->next_record();
					//$from=$this->f('email');
					$from="amit.startafresh@gmail.com";
					$to=$email;
					$subject='Request to reset your KPasapp password.';
					$com_name='Kpasapp';
					
					
					$this->send_mail($from,$to,$subject,$output,$com_name);
					//header("Location:".$obj_base_path->base_path()."/forgot_password.php");
					//exit;
		}

	}
	else{
		
		if($_SESSION['langSessId']=='eng')
		echo "Email address or cell number are not found.<br> Please enter your email address or cell number including country code (digits only no space) to receive instructions on resetting your password.";
		else
		echo "Dirección de correo electrónico o número de celular no se encuentran.<br>Introduzca su dirección de correo electrónico o número de celular con prefijo del país (sólo dígitos sin espacios) para recibir instrucciones sobre cómo restablecer su contraseña.
";
		//header("Location:".$obj_base_path->base_path()."/forgot_password.php");
		//exit;
	}

//echo $_SESSION['login_msg1'];
?>		
  

	  
		  
