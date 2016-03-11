<?php
include('include/user_inc.php');

$obj = new user;
$obj_country = new user;
$obj_venuestate = new user;

$email = $_POST['email'];

/*echo $count." ".$cart_id;
exit;*/

$obj->check_user($email); 
$obj->next_record();
$pass_exists = $obj->f('password');
if($obj->num_rows()==0){
?>		
	    <input type="hidden" name="action" id="action" value="save" />
            <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
               <tr>
                <td width="23%" style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "First Name";}elseif($_SESSION['langSessId']=='spn'){echo "Nombre";} ?> <span style="color:red;">*</span></td>
                    <td width="77%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="" style="width: 190px;"/><span class="err" id="err_fname" style="color:red;"></span></td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Last Name";}elseif($_SESSION['langSessId']=='spn'){ echo "Apellido";} ?><span style="color:red;">*</span></td>
                <td>
                    <input type="text" name="lname" id="lname" class="textbg_grey required" value="" style="width: 190px;"/>
                    <span class="err" id="err_lname" style="color:red;"></span>
                </td>
              </tr>						  
              
                                          
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Mobile#";}elseif($_SESSION['langSessId']=='spn'){ echo "m&#243;vil";}?></td>
                <td>
                    <select name="mobile_code" id="mobile_code" class="textbg_grey" style="width:155px; margin-left:5px;">
                    <?php
                         $obj_cntry = new user;
                        $sel = "selected='selected'";
                         $obj_cntry->countries_list();
                            while($obj_cntry->next_record()){
                    ?>
                        <option value="<?php echo $obj_cntry->f('phonecode');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $obj->f('mobile_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $obj->f('mobile_code')==''){ echo $sel; } else if($obj->f('mobile_code')==$obj_cntry->f('phonecode')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                    <?php
                        }
                    ?>    
                    </select>

                  <input type="text" name="phone" id="phone" class="textbg_grey" value="" style="width: 190px;" onKeyUp="checkPhone()" />
                                            
                    <div id="sh_alt_phn" style="color:red; margin-left:6px;"></div>
                </td>
              </tr>
              
              
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Country";}elseif($_SESSION['langSessId']=='spn'){ echo "Pa&#237;s";}?><span style="color:red;">*</span></td>
                <td>
                    <select name="country_id" id="country_id" onChange="setCountryCode()" class="textbg_grey" style="width:205px;margin-left:5px;">
                    <?php
                        $value_code = '';
                        $sel = "selected='selected'";
                        if($_SESSION['langSessId']=="spn")
			{
                           //$value_code = "value='52'";
                           $value_code = '52';
			}
                        else
			{
                           //$value_code = "value='1'";
                            $value_code = '1';
			}
                        
                        // check country code for per user
                        if($obj->f('country_code')!="" && $obj->f('country_code')!=0)
                            $value_code = $obj->f('country_code');
                            
                        $obj_country->countries_list();
                        while($obj_country->next_record()){
                    ?>
                        <option value="<?php echo $obj_country->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $obj->f('country_id')==0){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $obj->f('country_id')==0){ echo $sel; } else if($obj->f('country_id')==$obj_country->f('id')) { echo $sel;}  ?>><?php echo $obj_country->f('nicename');?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="hidden" name="country_code" id="country_code" value="<?php echo $value_code;?>" />
		    <span class="err" id="err_country" style="color:red;"></span>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "State";}elseif($_SESSION['langSessId']=='spn'){ echo "Estado";}?><span style="color:red;" id="star1">*</span></td>
                <td>
                  <div id="div_state_display">
                   <select name="province" id="province" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">State</option>
                        <?php
			  if($_SESSION['langSessId']=='eng')
			      $temp_country=226;
			  elseif($_SESSION['langSessId']=='spn')
			      $temp_country=138;
			  
			   $selectcountry = $obj->f('country_id') ? $obj->f('country_id') : $temp_country ;
			   
                          $obj_venuestate->getStateById($selectcountry);
                          while($row = $obj_venuestate->next_record())
                          {
                          ?>
                          <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('province')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_venuestate->f('state_name');?></option>
                            <?php
                          }
                          ?>
                    </select>
		    <span class="err" id="err_province" style="color:red;"></span>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "County";}elseif($_SESSION['langSessId']=='spn'){ echo "Municipio";}?></td>
                <td>
                    <input type="text" name="county" id="county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "City";}elseif($_SESSION['langSessId']=='spn'){ echo "Ciudad";}?><span style="color:red; " id="star3">*</span></td>
                <td>
                      <input type="text" name="city" id="city" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="" />  <span class="err" id="err_city" style="color:red;"></span>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Address";}elseif($_SESSION['langSessId']=='spn'){ echo "Direcci&#243;n";}?><span style="color:red;">*</span></td>
                <td>
                <textarea name="address" id="address" style="width:210px; margin-left: 6px;"></textarea>
		<span class="err" id="err_address" style="color:red;"></span>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Postal Code";}elseif($_SESSION['langSessId']=='spn'){ echo "C&#243;digo Postal";}?><span style="color:red;">*</span></td>
                <td>
                <input type="text" name="postal_code" id="postal_code" class="textbg_grey" style="width: 190px; margin-right:6px;" value="" />
		<span class="err" id="err_postal_code" style="color:red;"></span>
                </td>
              </tr>
              
              
              <!--<tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Password";}elseif($_SESSION['langSessId']=='spn'){ echo "Contrase&#241;a";}?><span style="color:red;">*</span></td>
                <td>
                <input type="password" name="password" id="password" class="textbg_grey" style="width: 190px; margin-right:6px;" value="" /><span class="err" id="err_password" style="color:red;"></span>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Retype password";}elseif($_SESSION['langSessId']=='spn'){ echo "Vuelva a escribir la contrase&#241;a";}?><span style="color:red;">*</span></td>
                <td>
                <input type="password" name="re_pass" id="re_pass" class="textbg_grey" style="width: 190px; margin-right:6px;" value="" /><span class="err" id="err_re_pass" style="color:red;"></span>
                </td>
              </tr>-->
              
              <tr>
                <td colspan="2">
		    <?php if($_SESSION['langSessId']=='eng'){?>
		    <input type="submit" name="submit" class="btn1_sudip" value="Save" onclick="return validate();" />
		    <?php }elseif($_SESSION['langSessId']=='spn'){?>
                <input type="submit" name="submit" class="btn1_sudip" value="Guardar" onclick="return validate();" />
                 <?php }?>
		</td>
              </tr>
              
            </table>  

<?php
}
else if($pass_exists=="" || $obj->f('activate_status') == 0){
   $_SESSION['ses_admin_id'] = $obj->f('admin_id');
   $_SESSION['name'] = $obj->f('fname')." ".$obj->f('lname');
?>
      <input type="hidden" name="pay_edit" id="pay_edit" value="1">
      <input type="hidden" name="pay_eid" id="pay_eid" value="<?php echo $e_id;?>">
      <input type="hidden" name="language" id="language" value="<?php echo $obj->f('language')?>" />
      <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
	 
	 <input type="hidden" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" <?php if($_SESSION['ses_admin_id'] != ''){echo "readonly";}?>/>
	 <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>
	 
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
	   <!--<tr>
	     <td style="padding-left: 18px;"><?php if($_SESSION['langSessId']=='eng'){echo "Primary Email";}elseif($_SESSION['langSessId']=='spn'){ echo "Correo Electr&oacute;nico";} ?><span style="color:red;">*</span></td>
	     <td>
	     <input type="text" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" <?php if($_SESSION['ses_admin_id'] != ''){echo "readonly";}?>/>
	     <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>
	     </td>
	   </tr>-->
				       
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
else
{
?>
	<div>
	 <?php if($_SESSION['langSessId']=='eng'){
		  echo "A KPasapp account is associated with this email address. for your security, you must sign in now to continue.";
		  }elseif($_SESSION['langSessId']=='spn'){
		    echo "Una cuenta KPasapp est&aacute; asociada con esta direcci&oacute;n de correo electr&oacute;nico. Para su seguridad, debe registrarse para continuar.";
		    } ?>
	</div>
      <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
	 <tr>
	     <td width="23%" style="padding-left: 18px;">
	     <?php if($_SESSION['langSessId']=='eng'){
		 echo "Password";
		 }elseif($_SESSION['langSessId']=='spn'){
		      echo "Contrase&#241;a";
		      } ?><span style="color:red;">*</span>
		      <br />
		      <a href="<?php echo $obj_base_path->base_path(); ?>/forgot_password.php">
		      <?php if($_SESSION['langSessId']=='eng'){
		 echo "Forgot password?";
		 }elseif($_SESSION['langSessId']=='spn'){
		      echo "Olvidado?";
		      } ?>
		      </a></td>
	     <td>
	     <input type="password" name="pass_signin" id="pass_signin" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="" /><span class="err" id="err_log_pass" style="color:red;"></span>
	     </td>
	 </tr>
	 <tr>
	     <td colspan="2">
		     <input type="submit" name="Submit" value="<?php if($_SESSION['langSessId']=='eng') {?>Sign in<?php }elseif($_SESSION['langSessId']=='spn'){?>Entrar<?php }?>" class="btn1_sudip" onclick="return validate_new();" />
	     </td>
	 </tr>
     </table>
      <input type="hidden" name="hid_sign" id="hid_sign" value="1" />
<?php
}
?>