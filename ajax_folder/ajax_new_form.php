<?php
//include('include/user_inc.php');
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

if($_SESSION['langSessId']== 'eng'){
define('SIGN_UP_WITH', 'Sign up with');
define('ORSHOW', 'OR');
define('ACCOUNT_TYPE', 'Account Type');
define('PERSONAL', 'Personal');
define('PROFESSIONAL', 'Professional');
define('FIRST_NAME', 'First Name');
define('LAST_NAME', 'Last Name');
define("EMAIL","Email address");
define('CELL_PHONE', 'Cell phone');
define('LANG', 'Language');
define('COUNTRY', 'Country');
define('PASS', 'Password');
define('CON_PASS', 'Confirm Password');
define('HUMAN', 'Are you human, or spambot?');
define('PRIVIACY', 'Privacy & Terms');
define('TERMS_CONDITION', 'By creating my KPasapp account, I agree to the  <a href="#" style="text-decoration:underline; color:#117ADA">KPasapp Terms of Service, KPasapp Privacy Policy and Communications Terms.</a>');
define('CREATE_ACCOUNT', 'Create Account');
}
else if($_SESSION['langSessId']== 'spn')
{
define('SIGN_UP_WITH', 'Entrar con');
define('ORSHOW', 'o');
define('ACCOUNT_TYPE', 'Tipo de cuenta');
define('PERSONAL', 'Personal');
define('PROFESSIONAL', 'Profesional');
define('FIRST_NAME', 'Nombre');
define('LAST_NAME', 'Apellido');
define("EMAIL","Correo ElectrÃ³nico");
define('CELL_PHONE', 'MÃ³vil');
define('LANG', 'Idioma');
define('COUNTRY', 'PaÃ­s');
define('PASS', 'ContraseÃ±a');
define('CON_PASS', 'Confirme contraseÃ±a');
define('HUMAN', 'Â¿Eres humano o robot de spam?');
define('PRIVIACY', 'TÃ©rminos y condiciones');
define('TERMS_CONDITION', 'Al crear mi cuenta KPasapp, reconozco que he leÃ­do y aceptado los <a href="#" style="text-decoration:underline; color:#117ADA">Terminos y Condiciones, Politicas de Cancelaciones y DevoluciÃ³n y Politicas de Privacidad de KPasapp.com.</a>');
define('CREATE_ACCOUNT', 'Crear Cuenta');
}



$obj = new user;
$obj_country = new user;
$obj_venuestate = new user;
$obj_page=new user;
$obj_page1=new user;

$obj_page->intro_page_id(5);
$obj_page->next_record();
$obj_page1->intro_page_id(6);
$obj_page1->next_record();

$email = $_POST['email'];

/*echo $count." ".$cart_id;
exit;*/

$obj->check_user($email); 
$obj->next_record();
$pass_exists = $obj->f('password');
if($obj->num_rows()==0){
?>		
          <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/contact-new.js"></script>
          <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>
	  <div style="width: 260px; float: left; margin: 0 0 0 21px;">
                    	<h1 style="font: normal 22px/22px Arial, Helvetica, sans-serif; padding: 0; margin: 0; color: #000000;"><?php echo ORSHOW;?></h1>
                    </div> 
	       <div class="clear"></div>
	 <form method="post" action="" enctype="multipart/form-data" name="contact" id="contact" autocomplete = "off">
                        <input type="hidden" name="aid" id="aid" value="">
			<table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                          <tr>
                            <td style="padding-left: 18px;"><?php echo PASS;?>
			    <div style="float: right; margin: 0 39 16 0px;">
			    <img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="margin: 0 5px;"/>
			    </div>
			    </td>
                            <td><input type="password" name="password" id="password" class="textbg_grey required" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_pass"></span><span id="result"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo CON_PASS;?> <span style="color:red;">*</span></td>
                			<td><input type="password" name="con_password" id="con_password" class="textbg_grey required" equalto="#password" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_con_pass"></span></td>
                          </tr>
			  
			  <tr style="height: 40px;">
			      <td></td>
			      <td></td>
			  </tr>
			  
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
                            	 <span class="question" id="tip1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="width:16px; float: right; margin: 2px 48px 5px 0px;" /></span></td>
                            <td><input type="text" name="email" id="email" class="textbg_grey required email" style="width: 190px;" value="<?php echo $email;?>" readonly /><br/><div class="clear"></div><span class="err" id="email_err"></span> </td>
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
                              <td>
                                  
                              </td>
                              <td>
                                <div class="g-recaptcha" data-sitekey="6Le4MAsUAAAAAPwZhwVvMIXcQVIieF3ltoMXHa2H"></div>
                                <label class="captcha_error error" style="display: none;">Please verify that you are human</label>
                              </td>
                          </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/privacy-terms" style="color:#00F;"><?php echo PRIVIACY;?></a></td>
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


<?php
}
else
{
   if($pass_exists==""){
   //$_SESSION['ses_admin_id'] = $obj->f('admin_id');
   //$_SESSION['name'] = $obj->f('fname')." ".$obj->f('lname');
?>
        <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/contact.js"></script>
        <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/pass_strength_script.js"></script>
	<div style="width: 260px; float: left; margin: 0 0 0 21px;">
                    	<h1 style="font: normal 22px/22px Arial, Helvetica, sans-serif; padding: 0; margin: 0; color: #000000;"><?php echo ORSHOW;?></h1>
                    </div> 
	       <div class="clear"></div> 
	 <form method="post" action="" enctype="multipart/form-data" name="contact" id="contact" autocomplete = "off">
                        <input type="hidden" name="aid" id="aid" value="<?php echo $obj->f('admin_id');?>">
			<table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                          <tr>
                            <td style="padding-left: 16px;"><?php echo PASS;?>
			    <!--<div style="width: 100px; float: left; margin: 23px 6px 24px 30px;">-->
			    <img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="margin: 0 5px;" />
			    <!--</div>-->
			    </td>
                            <td><input type="password" name="password" id="password" class="textbg_grey required" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_pass"></span><span id="result"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 16px;"><?php echo CON_PASS;?> <span style="color:red;">*</span></td>
                			<td><input type="password" name="con_password" id="con_password" class="textbg_grey required" equalto="#password" style="width: 190px;"/><br/><div class="clear"></div> <span class="err" id="err_con_pass"></span></td>
                          </tr>
			  
			  <tr style="height: 40px;">
			      <td></td>
			      <td></td>
			  </tr>
			  
			  <tr>
                            <td style="padding-left: 18px;"><?php echo ACCOUNT_TYPE;?>:</td>
                            <td>
                                <span style="margin-right:1px;"><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/<?php echo $obj_page->f('page_link')?>" target="_blank"><?php echo PERSONAL;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode1" checked="checked" value="0" <?php if($obj->f('account_type')==0){ echo "checked";}?> /></span> or
                                <span style="margin-left:10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/aboutkpasapp/<?php echo $obj_page1->f('page_link')?>" target="_blank"><?php echo PROFESSIONAL;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode2" value="1" <?php if($obj->f('account_type')==1){ echo "checked";}?> /></span>                            </td>
                          </tr>
                          <tr>
                            <td width="18%" style="padding-left: 18px;"><?php echo FIRST_NAME;?> <span style="color:red;">*</span></td>
                            <td width="82%"><input type="text" name="fname" id="fname" class="textbg_grey required" style="width: 190px;" value="<?php echo $obj->f('fname');?>"/><br/><div class="clear"></div> <span class="err" id="err_name"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo LAST_NAME;?> <span style="color:red;">*</span></td>
                         	<td><input type="text" name="lname" id="lname" class="textbg_grey required" style="width: 190px;" value="<?php echo $obj->f('lname');?>"/> <br/><div class="clear"></div><span class="err" id="err_lname"></span></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo EMAIL;?> 
                            	 <span class="question" id="tip1"><img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif " border="0"  style="margin: 0 5px;" /></span></td>
                            <td><input type="text" name="email" id="email" class="textbg_grey required email" style="width: 190px;" value="<?php echo $obj->f('email');?>" readonly/><br/><div class="clear"></div><span class="err" id="email_err"></span> </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo CELL_PHONE;?> #</td>
                            <td><input type="text" name="phone" id="phone" class="textbg_grey" style="width: 190px;" value="<?php echo $obj->f('phone');?>"/></td>
                          </tr>
                          <tr>
                            <td style="padding-left: 18px;"><?php echo LANG;?></td>
                            <td style="padding: 4px 0 0 7px;">
                                <select name="language" id="language" class="textbg_grey" style="width: 199px;">
                                    <option value="English" <?php if($obj->f('language')=="English"){?> selected="selected" <?php } ?>>English</option>
                                    <option value="Spanish" <?php if($obj->f('language')=="Spanish"){?> selected="selected" <?php } ?>>espa&#241;ol</option>
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
										
                                    $obj_country->countries_list();
                                    while($obj_country->next_record()){
                                ?>
                                    <option value="<?php echo $obj_country->f('id');?>" <?php if($obj->f('country_id')==$obj_country->f('id')){ echo $sel; } ?>><?php echo $obj_country->f('nicename')?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <input type="hidden" name="country_code" id="country_code" value="<?php echo $county_val;?>"  />
                             </td>
                          </tr>

                            <tr>
                                <td>
                                    
                                </td>
                                <td>
                                    <div class="g-recaptcha" data-sitekey="6Le4MAsUAAAAAPwZhwVvMIXcQVIieF3ltoMXHa2H"></div>
                                    <label class="captcha_error error" style="display: none;">Please verify that you are human</label>
                                </td>
                            </tr>
                          
                          <tr>
                            <td style="padding-left: 18px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/privacy-terms" style="color:#00F;"><?php echo PRIVIACY;?></a></td>
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
<?php
}
else
{
?>

   <div style="font: normal 14px/20px Arial, Helvetica, sans-serif; margin: 10px 0 10px 21px;">
	 <?php
	 if($obj->f('activate_status')==1){
	       if($_SESSION['langSessId']=='eng'){
		  echo "A KPasapp account is associated with this email address. for your security, you must sign in now to continue.";
		  }elseif($_SESSION['langSessId']=='spn'){
		    echo "Una cuenta KPasapp est&aacute; asociada con esta direcci&oacute;n de correo electr&oacute;nico. Para su seguridad, debe registrarse para continuar.";
		    }
	       
	       ?>
	       
	       <form method="post" action="" enctype="multipart/form-data" name="signin" id="signin" autocomplete="off">
                    <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
                    <table width="100%" align="center"  border="0" cellpadding="4" cellspacing="4" style="width: 400px; float: left; margin: 10px auto 0 20px; background: #f5f5f5; border: 1px solid #CCCCCC; padding: 7px;">
                      <tr>
                        <td width="13%" id="text_email" style="text-align: left; padding: 8px; text-transform: none; font-size: 12px;"></td>
                <td width="87%" style="padding: 8px;"><input type="hidden" name="email_cell"  id="email_cell" class="textbg_grey" value="<?php echo $email;?>" tabindex="1" /></td>
                      </tr>
                      <tr>
                        <td style="text-align: left;  text-transform: none; font-size: 12px; padding: 8px;"><?php echo PASS?></td>
                        <td style="padding: 8px;"><input type="password" name="pass_signin" value="" id="pass_signin" tabindex="2" style="width:220px; height:26px; border-radius:5px;"/> </td>
                      </tr>
                      <tr>
                        <td style="text-align: left;  text-transform: none; font-size: 12px; padding: 8px;">&nbsp;</td>
                        <td style="padding: 8px;"><a href="<?php echo $obj_base_path->base_path(); ?>/forgot_password.php" style="text-decoration: underline; color:#0066CC;"><?php echo FORGOT?></a></td>
                      </tr>
                      
                     <tr>
                      <td style="text-align: left; text-transform: none; padding: 8px; font-size: 12px;"></td>
                    <td  style="padding: 8px;"><input type="submit" name="submit11" id="submit11" value="<?php echo SIGNIN?>" class="btn1_sudip" tabindex="3" style="cursor:pointer; float: left;" /></td>
                     </tr>
                    </table>
     </form>

	       
	       <?php
	       
	 }
	 else
	 {
	       echo "This account has been signed up but is waiting for validation. Please check your messages.<br>
Do you want to resend the validation instructions?<br>
Please <a href='".$obj_base_path->base_path()."/thankyou.php?resend=true&aid=".$obj->f('admin_id')."'>click here</a> to resend validation instructions.";
	 }
	       ?>
   </div>

<?php
}
}
?>
<div style="display:none">
<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="http://kpasapp.us8.list-manage.com/subscribe/post?u=130e6654487fe713844d189db&amp;id=e429b6d314" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
	<label for="mce-EMAIL">Subscribe to our mailing list</label>
	<input type="email" value="<?php echo $email;?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_130e6654487fe713844d189db_e429b6d314" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
</form>
</div>

<!--End mc_embed_signup-->
</div>
           
           
<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>