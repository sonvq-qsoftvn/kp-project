<?php
include('include/user_inc.php');
//print_r($_SESSION);

$obj_user=new user;
$obj_add=new user;
$obj_add_social=new user;
$obj_edit=new user;
$obj_edit_social=new user;
$obj_check_add=new user;
$obj_check_add_social=new user;

if($_SESSION['ses_admin_id']==""){
	header("Location:".$obj_base_path->base_path()."");
	exit;
}


$obj_user->getAdminById($_SESSION['ses_admin_id']);
$obj_user->next_record();

if($_SESSION['lang_change']==1){
	$_SESSION['lang_change'] = 0;
?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script>
$(document).ready(function(){
	<?php
	if($obj_user->f('language')=="Spanish")
		$set_lang = "spn";
	else
		$set_lang = "eng";
	?>
	$('#languageId').val('<?php echo $set_lang;?>');
	//$('#languageId').val('spn');
	$('#frmlanguage').submit();
});
</script>
<?php
}

// check already added
$obj_check_add_social->checkAlreadyadded($_SESSION['ses_admin_id']);
$obj_check_add_social->next_record();


// check already added
$obj_check_add->checkPreference($_SESSION['ses_admin_id']);
$obj_check_add->next_record();

if($obj_check_add->f('category')){
	$savedCat = explode(",",$obj_check_add->f('category'));
}

if($obj_check_add->f('county')){
	$savedcounty = explode(",",$obj_check_add->f('county'));
}
//print_r($savedcounty);

if( isset($_POST['hid_reset_password']) )
{
	if($_POST['weekly_newsletter']!="")
		$weekly_newsletter = $_POST['weekly_newsletter'];
	else
		$weekly_newsletter = 0;
	
	if($_POST['daily_alert']!="")
		$daily_alert = $_POST['daily_alert'];
	else
		$daily_alert = 0;
	
	if($_POST['fan_alert']!="")
		$fan_alert = $_POST['fan_alert'];
	else
		$fan_alert = 0;
	
	if($_POST['spcl_event_alert']!="")
		$spcl_event_alert = $_POST['spcl_event_alert'];
	else
		$spcl_event_alert = 0;
	
	if($_POST['send_notification_to_email']!="")
		$send_notification_to_email = $_POST['send_notification_to_email'];
	else
		$send_notification_to_email = 0;
	
	if($_POST['send_notification_to_phone']!="")
		$send_notification_to_phone = $_POST['send_notification_to_phone'];
	else
		$send_notification_to_phone = 0;
	
	if($_POST['send_notification_to_links']!="")
		$send_notification_to_links = $_POST['send_notification_to_links'];
	else
		$send_notification_to_links = 0;
		
		
	// SOCAIL NETWORK ======================================================================
	
		
	if($_POST['facebook_page']!="")
		$facebook_page = $_POST['facebook_page'];
	else
		$facebook_page = 0;
	
	if($_POST['twitter_account']!="")
		$twitter_account = $_POST['twitter_account'];
	else
		$twitter_account = 0;
	
	if($_POST['google_account']!="")
		$google_account = $_POST['google_account'];
	else
		$google_account = 0;
		
		if($obj_check_add_social->num_rows()){
			// Edit
			$obj_edit_social->editSocialNetworkUser($facebook_page,addslashes($_POST['facebook_page_text']),$twitter_account,addslashes($_POST['twitter_account_text']),$google_account,addslashes($_POST['google_account_text']),$_SESSION['ses_admin_id']);
	}
	else{
			// Add Social Network
			$obj_add_social->addSocialNetworkUser($facebook_page,addslashes($_POST['facebook_page_text']),$twitter_account,addslashes($_POST['twitter_account_text']),$google_account,addslashes($_POST['google_account_text']),$_SESSION['ses_admin_id']);
	}
	
	// SOCAIL NETWORK ======================================================================
	
	if($_POST['maincat']!=""){
		$allCat = '';
		foreach($_POST['maincat'] as $eachCat){
			$allCat.= $eachCat.",";
		}
		$allCat = substr($allCat, 0, -1);
	}
	
	//print_r($_POST['county_id']);
	if($_POST['county_id']!=""){
		$county_id = '';
		foreach($_POST['county_id'] as $eachcounty){
			if($eachcounty!="ALL")
			$county_id.= $eachcounty.",";
		}
		$county_id = substr($county_id, 0, -1);
	}
	//echo $county_id;exit;
	
	
	if($obj_check_add->num_rows()){
		
		// Edit
		$obj_edit->editPreferenceUser($weekly_newsletter,$daily_alert,$fan_alert,$spcl_event_alert,$send_notification_to_email,$send_notification_to_phone,$send_notification_to_links,$allCat,$county_id,$_POST['state_id'],$_SESSION['ses_admin_id']);
	}
	else{
		
		// Add Social Network
		$obj_add->addPreferenceUser($weekly_newsletter,$daily_alert,$fan_alert,$spcl_event_alert,$send_notification_to_email,$send_notification_to_phone,$send_notification_to_links,$allCat,$county_id,$_POST['state_id'],$_SESSION['ses_admin_id']);
	}
	
	 if($_POST['set_param']==1){
		//redirect
		header("Location:".$obj_base_path->base_path()."/userprofile");
		exit;
	}
	else{
		header("Location:".$obj_base_path->base_path()."");
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Personal Preference</title>

<?php
if(!$obj_check_add->num_rows()){
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	SelectAll();
	document.getElementById("chk").checked=true;
	checkAllfun();
})
</script>
<?php
}
?>
<script language="javascript" type="text/javascript">
function getCounty(stateid)
{
	 data = "state_id="+stateid;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_multi_get_county_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}
function checkAllfun(){
	
	var checkbox = document.getElementsByName('maincat[]');
	var ln = checkbox.length;
	if(document.getElementById("chk").checked==true)
	{
		for(var k=1;k<=ln;k++)
		{
			ID = "maincat"+k;
			document.getElementById(ID).checked = true;
		}
		
	}
	else
	{
		for(var j=1;j<=ln;j++)
		{
			ID = "maincat"+j;
			document.getElementById(ID).checked = false;
		}
		
	}
}
function SelectAll(){
	$('#county_id').find('option').each(function() {
		$(this).attr('selected', 'selected');
     });

	//$('#county_id option').attr('selected', 'selected');
}
function redirectPage(param)
{
	/*if(document.getElementById("terms_condition").checked == false) 
    {
        alert ('You didn\'t choose terms and conditon.');
		document.getElementById("terms_condition").focus();
        return false;
 	}*/
	$('#set_param').val(param);
	$('#personal_pre').submit();
}


</script>



<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
	
  <div class="clear"></div>
	<div class="body_bg">
    	
    	<div class="clear"></div>
    	<div class="container">
	       <div class="left_panel bg" style="width:978px;">
                <div class="blue_box1" style="width:976px;">
                 <div class="blue_boxh">
                    <p style="font-size: 28px; line-height: 30px;"><?php echo MYKPASAPP."<br/><span>".PERSSONAL."</span>";?></p>
                 </div>
                 <div class="blue_boxr" style="width: 754px;">
                   <ul>
                       <li><a href="<?php echo $obj_base_path->base_path(); ?>/userprofile"><?php echo ACCOUNT; ?><!--Account--></a></li>
                       <li><a href="<?php echo $obj_base_path->base_path(); ?>/personal_preference" class="here"><?php echo PREFERENCES; ?><!--Preferences--></a></li>
                       <!--<li><a href="<?php echo $obj_base_path->base_path(); ?>/social_network">Social Networks</a></li>-->
                   </ul>
                 </div>
                </div>
                <div class="clear"></div>                
                <div style="width: 976px; float: none; margin: 0 auto;">                    
					<div class="clear"></div>									
                    <form method="post" action="" enctype="multipart/form-data" name="personal_pre" id="personal_pre" autocomplete = "off">
                    <input type="hidden" name="hid_reset_password" id="hid_reset_password" value="1" />
                  <input type="hidden" name="set_param" id="set_param" value="" />

                    <table width="100%" align="left" border="0" cellpadding="4" cellspacing="4" class="prefer_box">
					<tr>
					<td colspan="2"><h1><?php echo MY_SOCIAL_NETWORK;?></h1></td>
					</tr>
					<tr>
					<td colspan="2"><?php /*?><?php if($_SESSION['preference_msg']){?>                    
                      <div style="width: 494px; float: left; margin: 0 auto 0 23px;">
                        <h1 class="h1show"><?php echo $_SESSION['preference_msg']; $_SESSION['preference_msg'] = '';?></h1>
                  </div>
                    <?php } ?><?php */?>
                    <div class="clear"></div>
                    <div class="showHeading"><?php echo SETUP_SOCIAL;?></div></td>
					</tr>
					 <tr>
					 <td colspan="2">					 
					   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                        <td width="36%"><?php echo FACEBOOK_PAGE;?></td>
                        <td width="64%">https://www.facebook.com/<input type="text" name="facebook_page_text" id="facebook_page_text" class="textbg_grey" placeholder="username only"  style="width:117px;" value="<?php echo $obj_check_add_social->f('facebook_page_text');?>"/><input type="checkbox" name="facebook_page" id="facebook_page" value="1" <?php if($obj_check_add_social->num_rows()){ if($obj_check_add_social->f('facebook_page')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/></td>
                      </tr>
                        <tr>
                        <td><?php echo TWITTER_ACCOUNT;?></td>
                        <td>https://twitter.com/<input type="text" name="twitter_account_text" id="twitter_account_text" class="textbg_grey" style="width:169px;" placeholder="username only" value="<?php echo $obj_check_add_social->f('twitter_account_text');?>" /><input type="checkbox" name="twitter_account" id="twitter_account" value="1" <?php if($obj_check_add_social->num_rows()){ if($obj_check_add_social->f('twitter_account')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/></td>
                      </tr>
                     <tr>
                        <td><?php echo GOOGLE_ACCOUNT;?></td>
                        <td>https://plus.google.com/<input type="text" name="google_account_text" id="google_account_text" class="textbg_grey" style="width:132px;"  placeholder="username only" value="<?php echo $obj_check_add_social->f('google_account_text');?>" /><input type="checkbox" name="google_account" id="google_account" value="1" <?php if($obj_check_add_social->num_rows()){ if($obj_check_add_social->f('google_account')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/></td>
                      </tr>
                       </table></td>
					 </tr>
					<tr>
					<td colspan="2" style="padding: 14px 0 0 0;"><h1><?php echo MY_NOTIFICATION_ALERT?></h1></td>
					</tr>
					<tr>
					<td colspan="2"><?php if($_SESSION['preference_msg']){?>                    
                      <div style="width: 494px; float: left; margin: 0 auto 0 23px;">
                        <h1 class="h1show"><?php echo $_SESSION['preference_msg']; $_SESSION['preference_msg'] = '';?></h1>
                  </div>
                    <?php } ?>
                    <div class="clear"></div>
                    <div class="showHeading"><?php echo SETUP_PREFERNCE;?></div></td>
					</tr>
					<tr>
                        <td colspan="2"><p><?php echo SUBSCRIBE_TO;?> </p></td>                       
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="weekly_newsletter" id="weekly_newsletter" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('weekly_newsletter')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo WEEKLY_NEWSLETTER;?></td>
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="daily_alert" id="daily_alert" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('daily_alert')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo DAILY_ALERTS;?></td>
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="fan_alert" id="fan_alert" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('fan_alert')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo FAN_ALERT;?></td>
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="spcl_event_alert" id="spcl_event_alert" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('spcl_event_alert')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo SPECIAL_EVENT_ALERT;?></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding: 18px 0  0 0;"><p><?php echo SEND_NOTICATION_TO;?></p></td>                       
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="send_notification_to_email" id="send_notification_to_email" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('send_notification_to_email')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo EMAIL_ADDRESS_PER.' "'.$obj_user->f('email').'"';?> </td>
                      </tr>
                      <tr>
                        <td colspan="2"><input type="checkbox" name="send_notification_to_phone" id="send_notification_to_phone" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('send_notification_to_phone')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>/> <?php echo CELL_PHONE_PER.' '.$obj_user->f('phone');?></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="send_notification_to_links" id="send_notification_to_links" value="1" <?php if($obj_check_add->num_rows()){ if($obj_check_add->f('send_notification_to_links')==1){?> checked="checked" <?php } }else{ echo 'checked="checked"';  } ?>  /> <?php echo MY_LINK_SOCAIL_NETWORK;?></td>
                      </tr>
					  <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                    </table>
                    <table width="100%" align="right" border="0" cellpadding="4" cellspacing="4" class="prefer_box2">
                     <tr style="height:25px;">
                        <td width="22%" style="padding-left: 18px;"><p><?php echo EVENT_CATEGORY;?></p></td>
                        <td width="28%">&nbsp;</td>
                      </tr>
                     <tr>
                        <td colspan="2" style="padding-left: 35px;">
                        <div class="check_box">						
						<input type="checkbox" name="chk" id="chk" onClick="checkAllfun()" /><?php echo ALL;?></div>
                        	<?php 
								$obj_cat = new user;
								$obj_cat->allEventParentCategoryList();
								if($obj_cat->num_rows()){
									$sl_no = 1;
									while($obj_cat->next_record()){
										if($obj_cat->f('category_name')=="Private")
											continue;
							?>			
									<div class="check_box"><input type="checkbox" name="maincat[]" id="maincat<?php echo $sl_no;?>" value="<?php echo $obj_cat->f('category_id');?>" <?php if(in_array($obj_cat->f('category_id'),$savedCat)) { echo 'checked'; }?> />
								<?php if($_SESSION['langSessId']=="spn")
                                    echo $obj_cat->f('category_name_sp')."&nbsp;";
                                else
                                    echo $obj_cat->f('category_name')."&nbsp;";
									$sl_no++;
									}
								}
								
							?></div>
                        </td>
                      </tr>
                     <tr style="height:25px;">
                        <td style="padding-left: 18px;"><p><?php echo PREFER_STATES;?></p></td>
                        <td>&nbsp;</td>
                      </tr>
                     <tr>
                        <td style="padding-left: 28px;" colspan="2">
                        	<?php 
								$obj_state = new user;
								$obj_state->getVenueState();
								$sel = 'selected="selected"';
							?>			
                            <select name="state_id"  class="field_bg24" id="state_id" onChange="getCounty(this.value);">
                                <option value="">Select State</option>
                                <?php 
                                    if($obj_state->num_rows()){
                                        while($obj_state->next_record()){
                                ?>
                                    <option value="<?php echo $obj_state->f('id');?>" <?php if(!$obj_check_add->num_rows()){ if($obj_state->f('state_name')=="Baja California Sur"){ echo $sel;} } else { if($obj_state->f('id')==$obj_check_add->f('state')) echo $sel; } ?>><?php echo $obj_state->f('state_name');?></option>
                                <?php
                                        }
                                    }
                                 ?>			
                            </select>	
                        </td>
                      </tr>
                     <tr style="height:25px;">
                        <td style="padding-left: 18px;"><p><?php echo PREFER_COUNTIES;?></p></td>
                        <td>&nbsp;</td>
                      </tr>
                     <tr>
                        <td style="padding-left: 28px;" colspan="2">
						<span style="margin:0 0 0 10px; font: bold 12px/18px Arial, Helvetica, sans-serif; cursor:pointer;"><input type="checkbox" name="all_county" id="all_county" value="checkbox" style="padding: 0; margin: 0;"  onClick="SelectAll()"/> <?php echo ALL_COUNTY;?></span>
						<div class="clear"></div>
                       	<span id="div_county_display">
                          <select name="county_id[]" id="county_id" class="selectbg12" multiple="multiple" style="width:255px; margin: 0; height:94px;">
							<?php
                            $obj_getcounty = new user;
							if(!$obj_check_add->num_rows())
	                            $obj_getcounty->getCountyNameByState(1732);
							else
								 $obj_getcounty->getCountyNameByState($obj_check_add->f('state'));
								 
                            while($obj_getcounty->next_record())
                            {
                            ?>
                            <option value=<?php echo $obj_getcounty->f("id")?> <?php if(in_array($obj_getcounty->f('id'),$savedcounty)) { echo 'selected="selected"'; }?>><?php echo $obj_getcounty->f('county_name')?></option>
                            <?php
                            }
                            ?>
                        </select>	  
                      </span>
                      </td>
                   </tr>
                   <tr>
                   	<td>
                       <div style="width:415px">
                        <!--<input id="terms_condition" type="checkbox" value="1" name="terms_condition">-->
                       <?php echo TERMS_CONDITION?>
                       </div>
                   	</td>
                   </tr>
                    </table>
					<div class="clear"></div>
					<div style="width: auto; margin: 0px auto 0 545px; float: left;"><input type="button" name="submit1" id="submit1" value="<?php echo PREVIOUS;?>" class="event_save" style="cursor:pointer; float: left;" onClick="redirectPage(1)" /> <input type="button" name="submit1" id="submit1" value="<?php echo SAVE_EXIT;?>" class="event_save" style="cursor:pointer; float: right;" onClick="redirectPage(2)" /></div>
                </form>                    
                </div>
                <div class="clear"></div>
           </div>
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