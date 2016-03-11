<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_email_check = new user;
$obj_add_altemail = new user;
$obj_getDtls = new user;
$obj_sendmail = new user;
$obj_del_altemail = new user;
$obj_save = new user;
$obj_get_dtls1 = new user;
$obj_get_dtls3 = new user;
$obj_get_dtls2 = new user;
$altername_email = $_POST['altername_email'];
$mode = $_POST['mode'];

if($mode=="del"){
// =================================== Delete Altername Email Id ====================================
	$obj_del_altemail->deleteAltEmail($altername_email);
	
// =================================== Delete Altername Email Id ====================================
}
else if($mode=="save"){
// =================================== Save Altername Email Id ====================================

	$obj_save->saveAltEmail($altername_email,$_SESSION['ses_admin_id']);
	$obj_save->next_record();
	
	$obj_getDtls->checkpass($_SESSION['ses_admin_id']);
	$obj_getDtls->next_record();
			
	$id = base64_encode('confirm1');
	// Email body
	if($_SESSION['langSessId']=="spn")
	{
		$body = '<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
					<tbody><tr>
						<td valign="top" align="center">
					
							<table width="100%" cellspacing="0" cellpadding="0">                  
								 
								<tbody><tr>
									<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
										<center>
											<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'. $obj_base_path->base_path().'">
											<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'. $obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
										</center>
															</td>
								</tr>
											</tbody></table>
					
							<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
								<tbody><tr>
									<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">Estimado '.$obj_getDtls->f("fname").',</strong></p>
									  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><strong id="docs-internal-guid-4916fb8b-6e2d-8af7-f6cd-de14632abae0">Se cambio su dirección de correo electrónico a tu cuenta KPasapp.</strong><strong id="docs-internal-guid-5af4bcea-6e32-1a86-7627-a0a049d1e675">Por favor, confirme esta solicitud haciendo clic en el enlace</strong></p>
									  <div dir="ltr">
										  <table>
											<tr>
<td width="491"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
												<a target="_blank" href="'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=1""  style="font-weight:bold;">Confirmar Mi alternativo Dirección de correo electrónico. </a></strong></p>
											 </td>
											</tr>
									    </table>
									  </div>
										<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e32-5ee5-43e2-0f9b2c8e98b2">Si no puede abrir el hipervínculo anterior, copie y pegue el URL en su navegador de Internet (si el enlace se divide en dos líneas, asegúrese de copiar ambas líneas).</strong><strong id="docs-internal-guid-4916fb8b-5028-880a-b274-ed16a467475e"> '. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=1</strong></p>
										<p>Si no hiciste esta solicitud, háganoslo saber de inmediato para su propia seguridad. Es importante porque nos ayuda a asegurarnos de que nadie se está metiendo en su cuenta sin su conocimiento.<br>
										  Atentamente,</p>
									  <p>El Equipo KPasapp<br>
										  No responda a este correo electrónico.<br>
									    Envíanos un email a info@kpasapp.com si necesita ayuda adicional.</p></td>
								</tr>
								<tr>
								<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
											<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
												<div style="float:right">
						<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/twitter_icon.png"></a>
						<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/facebook_icon.png"></a>
						<a target="_blank" href="#"><img width="43" border="0" src="'. $obj_base_path->base_path().'/images/youtube_icon.png"></a>
						</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
										</td>
									</tr>
						</tbody></table>
						</td>
					</tr>
					</tbody></table>';

		$subject = 'Confirme su dirección de correo electrónico alterna';
	}
	else
	{
		$body = '<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
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
									<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">Dear '.$obj_getDtls->f("fname").',</strong></p>
									  <p dir="ltr"><span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><strong id="docs-internal-guid-4916fb8b-6de2-6030-1199-9cfa80c6e1a2">You added an </strong><strong id="docs-internal-guid-4916fb8b-6e25-39fa-a172-6d521a9a2d08">changed your</strong> <strong>alternate email address to your KPasapp account.</strong><strong id="docs-internal-guid-5af4bcea-6de3-1e1a-d5f2-259c81d7ca5e">Please confirm this request by clicking on the link</strong></span></p>
									  <div dir="ltr">
										  <table>
											<tr>
											  <td><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
												<a target="_blank" href="'.$obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=1"  style="font-weight:bold;">Confirm your Email Address </a></strong></p>
											 </td>
											</tr>
									    </table>
									  </div>
										<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e25-e639-1f3e-751a130456a0">If you are unable to open the hyperlink above, copy and paste the URL into your internet browser (if the link is split into two lines, be sure to copy both lines).</strong><strong id="docs-internal-guid-4916fb8b-5032-96e7-8232-8c3ada5f5efe">'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=1.</strong></p>
										<p dir="ltr"><strong id="docs-internal-guid-4916fb8b-6de4-7bec-6c5f-6d2746ff5517">Once you confirm it, you can use this email address for your KPasapp operations such as reservations and notifications. You can also make it your primary address for all your KPasapp business</strong></p>
                                      <p>If you did not make this request, let us know right away for your own security. Its important because it helps us make sure no one is getting into your account without your knowledge.<br>
                                          Sincerely,</p>
                                        <p>The KPasapp Team<br>
                                          Do not reply to this email.<br>
                                        Email us at info@kpasapp.com if you require additional assistance.</p></td>
								</tr>
								<tr>
								<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
											<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
												<div style="float:right">
						<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/twitter_icon.png"></a>
						<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'.$obj_base_path->base_path().'/images/facebook_icon.png"></a>
						<a target="_blank" href="#"><img width="43" border="0" src="'.$obj_base_path->base_path().'/images/youtube_icon.png"></a>
						</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
										</td>
									</tr>
						</tbody></table>
						</td>
					</tr>
					</tbody></table>';
		$subject='Confirm your change email address';
	}
	
	$obj_sendmail->alt_email_change($altername_email,$obj_getDtls->f('fname'),$body,$subject);
	
	
	
	echo 1;
	
// =================================== Save Altername Email Id ====================================
}
elseif($mode == "make_primary"){
	// =================================== Make primary ====================================
	$old_email = $_POST['old_email'];
	$user_id = $_SESSION['ses_admin_id'];
	
	$obj_email_check->checkEmail($altername_email);
	if($obj_email_check->num_rows()){
		echo 0;
	}
	else{

	$obj_get_dtls3->checkpass($_SESSION['ses_admin_id']);
	$obj_get_dtls3->next_record();
	
	$id = base64_encode('confirm2');
	// Email body
	if($_SESSION['langSessId']=="spn")
	{
		$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
				<tbody><tr>
					<td valign="top" align="center">
				
						<table width="100%" cellspacing="0" cellpadding="0">                  
							 
							<tbody><tr>
								<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
									<center>
										<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'. $obj_base_path->base_path().'">
										<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'. $obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
									</center>
								</td>
							</tr>
										</tbody></table>
				
						<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
							<tbody><tr>
								<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e5c-44f6-a4d9-cf6a31832629">Estimado </strong><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">'.$obj_get_dtls3->f("fname").',</strong></p>
								  <p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-639a-60df-ebc5922ff6e5">
								  </strong><strong id="docs-internal-guid-4916fb8b-6e5c-887a-c189-c33735200c41">Han pedido de reemplazar su dirección principal de correo electrónico con su dirección de correo electrónico alterna.</strong><strong id="docs-internal-guid-5af4bcea-6e5c-d271-0e61-f7a0300c9275">Por favor, confirme esta solicitud haciendo clic en el enlace</strong></p>
								  <div dir="ltr">
								    <table>
									  <tr>
										  <td width="500"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
										  <a target="_blank" href="'. $obj_base_path->base_path().'/confirm_email?id='.$id.'" style="font-weight:bold;">Confirmar mi cambio de Primaria Dirección de correo electrónico</a></strong></p>
										 </td>
									  </tr>
									</table>
								  </div>
												
									<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e5e-72e5-49d4-63b3ed8df7e1">Si no puede abrir el hipervínculo anterior, copie y pegue el URL en su navegador de Internet (si el enlace se divide en dos líneas, asegúrese de copiar ambas líneas).</strong>'. $obj_base_path->base_path().'/confirm_email?id='.$id.'</p>
									<p>Si no hiciste esta solicitud, háganoslo saber de inmediato para su propia seguridad. Es importante porque nos ayuda a asegurarnos de que nadie se está metiendo en su cuenta sin su conocimiento.<br>
									  Atentamente,</p>
									<p>El Equipo KPasapp<br>
									  No responda a este correo electrónico.<br>
									  Envíanos un email a info@kpasapp.com si necesita ayuda adicional.<br>
								  </p>
									<p dir="ltr">&nbsp;</p></td>
							</tr>
							<tr>
							<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
										<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
											<div style="float:right">
					<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/twitter_icon.png"></a>
					<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/facebook_icon.png"></a>
					<a target="_blank" href="#"><img width="43" border="0" src="'. $obj_base_path->base_path().'/images/youtube_icon.png"></a>
					</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
									</td>
								</tr>
					</tbody></table>
					</td>
				</tr>
				</tbody></table>';
		$subject='Solicitud de sustitución de su dirección principal de correo electrónico con su dirección de correo electrónico alterna.';
	}
	else
	{
		$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
				<tbody><tr>
					<td valign="top" align="center">
				
						<table width="100%" cellspacing="0" cellpadding="0">                  
							 
							<tbody><tr>
								<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
									<center>
										<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'. $obj_base_path->base_path().'">
										<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'. $obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
									</center>
								</td>
							</tr>
										</tbody></table>
				
						<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
							<tbody><tr>
								<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">Dear '.$obj_get_dtls3->f("fname").',</strong></p>
								  <p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-639a-60df-ebc5922ff6e5">
								  </strong><strong id="docs-internal-guid-4916fb8b-6e3c-0efd-bf6f-d7afc8f36470">Your have requested to replace your primary email address with your alternate email address.</strong><strong id="docs-internal-guid-5af4bcea-6e3c-42a6-17d0-ffdb8f78b425">Please confirm this request by clicking on the link</strong></p>
								  <div dir="ltr">
									  <table>
										<tr>
										  <td><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
										  <a target="_blank" href="'. $obj_base_path->base_path().'/confirm_email?id='.$id.'" style="font-weight:bold;">Confirm My Change of Primary Email Address</a></strong></p>
										 </td>
										</tr>
									</table>
								  </div>
												
									<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e3d-6d5f-7a05-6309e5b1e538">If you are unable to open the hyperlink above, copy and paste the URL into your internet browser (if the link is split into two lines, be sure to copy both lines).</strong>'. $obj_base_path->base_path().'/confirm_email?id='.$id.'</p>
									<p dir="ltr"><strong id="docs-internal-guid-4916fb8b-6e3e-b4fe-6cf6-b4ad85c78f46">Once you confirm it, you can use this email address for your KPasapp operations such as reservations and notifications. You can also make it your primary address for all your KPasapp business.</strong></p>
									<p>If you did not make this request, let us know right away for your own security. Its important because it helps us make sure no one is getting into your account without your knowledge.<br>
									  Sincerely,</p>
									<p>The KPasapp Team<br>
									  Do not reply to this email.<br>
									Email us at info@kpasapp.com if you require additional assistance.</p></td>
							</tr>
							<tr>
							<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
										<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
											<div style="float:right">
					<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/twitter_icon.png"></a>
					<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/facebook_icon.png"></a>
					<a target="_blank" href="#"><img width="43" border="0" src="'. $obj_base_path->base_path().'/images/youtube_icon.png"></a>
					</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
									</td>
								</tr>
					</tbody></table>
					</td>
				</tr>
				</tbody></table>';
		$subject='Request to replace your primary email address with your alternate email address.';

	}
	
	$obj_save->make_primary_mail($altername_email,$obj_get_dtls3->f('fname'),$output,$subject);
	echo 1;
	}
	// =================================== Make primary ====================================
}
else{
// =================================== Add Altername Email Id ====================================
	$obj_email_check->checkEmail($altername_email);
	if($obj_email_check->num_rows()){
		echo 0;
	}
	else{
		
			$obj_get_dtls2->checkpass($_SESSION['ses_admin_id']);
			$obj_get_dtls2->next_record();
			$id = base64_encode('confirm1');
			
			// Email body
			if($_SESSION['langSessId']=="spn")
			{
				$body = '<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
							<tbody><tr>
								<td valign="top" align="center">
							
									<table width="100%" cellspacing="0" cellpadding="0">                  
										 
										<tbody><tr>
											<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
												<center>
													<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'. $obj_base_path->base_path().'">
													<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'. $obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
												</center>
																	</td>
										</tr>
													</tbody></table>
							
									<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
										<tbody><tr>
											<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">Estimado '.$obj_get_dtls2->f('fname').',</strong></p>
											  <p dir="ltr"><strong id="docs-internal-guid-4916fb8b-6e1e-958c-b6e7-5490b65ed084">Se agregó una nueva  dirección de correo electrónico a tu cuenta KPasapp.</strong><strong id="docs-internal-guid-5af4bcea-6e1f-3572-a1c1-0e801e0e1877">Por favor, confirme esta solicitud haciendo clic en el enlace</strong></p>
											  <div dir="ltr">
												  <table>
													<tr>
<td width="491"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
														<a target="_blank" href="'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=2""  style="font-weight:bold;">Confirmar Mi alternativo Dirección de correo electrónico. </a></strong></p>
													 </td>
													</tr>
											    </table>
											  </div>
												<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6e19-d538-738d-8fff8cef0622">Si no puede abrir el hipervínculo anterior, copie y pegue el URL en su navegador de Internet (si el enlace se divide en dos líneas, asegúrese de copiar ambas líneas).</strong><strong id="docs-internal-guid-4916fb8b-5028-880a-b274-ed16a467475e">'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=2</strong></p>
											  <p dir="ltr"><strong id="docs-internal-guid-4916fb8b-6e1a-4997-e1af-3b38d3254ccd">Una vez confirmada, usted puede utilizar esta dirección de correo electrónico para sus operaciones KPasapp como reservas y notificaciones. También puede hacerla su dirección principal para estancias de negocios KPasapp.</strong></p>
												<p>Si no hiciste esta solicitud, háganoslo saber de inmediato para su propia seguridad. Es importante porque nos ayuda a asegurarnos de que nadie se está metiendo en su cuenta sin su conocimiento.<br>
												  Atentamente,</p>
											  <p>El Equipo KPasapp<br>
												  No responda a este correo electrónico.<br>
											    Envíanos un email a info@kpasapp.com si necesita ayuda adicional</p></td>
										</tr>
										<tr>
										<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
													<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
														<div style="float:right">
								<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/twitter_icon.png"></a>
								<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/facebook_icon.png"></a>
								<a target="_blank" href="#"><img width="43" border="0" src="'. $obj_base_path->base_path().'/images/youtube_icon.png"></a>
								</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
												</td>
											</tr>
								</tbody></table>
								</td>
							</tr>
							</tbody></table>';

				$subject = 'Confirme su dirección de correo electrónico alterna';
			}
			else{
				$body = '<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
							<tbody><tr>
								<td valign="top" align="center">
							
									<table width="100%" cellspacing="0" cellpadding="0">                  
										 
										<tbody><tr>
											<td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
												<center>
													<a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'. $obj_base_path->base_path().'">
													<img border="0" align="middle" alt="KPasapp" title="KPasapp" src="'. $obj_base_path->base_path().'/images/KPasapp_logo.png"></a>
												</center>
																	</td>
										</tr>
													</tbody></table>
							
									<table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
										<tbody><tr>
											<td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0"><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3078-c5de-a01a-95d21091b1ea">Dear '.$obj_get_dtls2->f('fname').',</strong></p>
											  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms"><strong id="docs-internal-guid-4916fb8b-6de2-6030-1199-9cfa80c6e1a2">You added an alternate email address to your KPasapp account.</strong><strong id="docs-internal-guid-5af4bcea-6de3-1e1a-d5f2-259c81d7ca5e">Please confirm this request by clicking on the link</strong></p>
											  <p style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">
											  </p>
											  <div dir="ltr">
												  <table>
													<tr>
											    <td><p dir="ltr"><strong id="docs-internal-guid-5dddb8f4-3079-9d88-499c-ae80ffeba552">
														<a target="_blank" href="'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=2""  style="font-weight:bold;">Confirm My Email Address </a></strong></p>
													 </td>
													</tr>
												  </table>
											  </div>
												<p dir="ltr"><strong id="docs-internal-guid-5af4bcea-6de4-01d0-929e-d9d57d1d9b24">If you are unable to open the hyperlink above, copy and paste the URL into your internet browser (if the link is split into two lines, be sure to copy both lines).</strong>'. $obj_base_path->base_path().'/confirm_email?id='.$id.'&mode=2</p>
												<p dir="ltr"><strong id="docs-internal-guid-4916fb8b-6de4-7bec-6c5f-6d2746ff5517">Once you confirm it, you can use this email address for your KPasapp operations such as reservations and notifications. You can also make it your primary address for all your KPasapp business</strong></p>
												<p>If you didnot make this request, let us know right away for your own security. Its important because it helps us make sure no one is getting into your account without your knowledge.<br>
												  Sincerely,</p>
											  <p>The KPasapp Team<br>
												  Do not reply to this email.<br>
											    Email us at info@kpasapp.com if you require additional assistance.</p></td>
										</tr>
										<tr>
										<td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
													<div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
														<div style="float:right">
								<a target="_blank" href="https://twitter.com/KPasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/twitter_icon.png"></a>
								<a target="_blank" href="https://www.facebook.com/master.kpasapp"><img width="43" border="0" height="43" src="'. $obj_base_path->base_path().'/images/facebook_icon.png"></a>
								<a target="_blank" href="#"><img width="43" border="0" src="'. $obj_base_path->base_path().'/images/youtube_icon.png"></a>
								</div><div>Copyright &copy; 2011 <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Kpasapp</span>, Inc. All rights reserved.</div></div>
												</td>
											</tr>
								</tbody></table>
								</td>
							</tr>
							</tbody></table>';
				$subject='Confirm your new email address';
			}
			
			// Send Email
			$obj_sendmail->send_confrimation($altername_email,$obj_get_dtls2->f('fname'),$body,$subject);
	
			$obj_add_altemail->add_more_emailid_user($altername_email);
			$_SESSION['duplicate_email'] = "You have added a new email address to your account. A confirmation email has been sent to that address. Please confirm this new email address by clicking on the link in the email.!";
		echo 1;
	}
// =================================== Add Altername Email Id ====================================
}




?>		
  
		  
