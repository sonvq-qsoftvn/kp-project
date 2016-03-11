<?php
include('include/user_inc.php');
//print_r($_SESSION);

$page_path = explode("/",$_SERVER['REQUEST_URI']);
$page_name = $page_path[count($page_path)-1];

$obj=new user;
$obj_country=new user;
$obj1=new user;
$obj_sendmail=new user;
$faq = new User;
$edit_admin= new User;
$obj_venuestate= new User;
$obj_getcounty = new user;
$obj_altmail = new user;
$obj_altphn = new user;
$obj_del_altemail = new user;
$obj_page = new user;
$obj_page1 = new user;
$obj_coun = new user;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<title>Profile Setting</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />

<?php
//print_r($_SESSION);

if($_SESSION['ses_admin_id']==""){
	header("Location:".$obj_base_path->base_path()."/index");
}

// Get alternate Email id
$obj_altmail->getalternateEmail($_SESSION['ses_admin_id']);
$obj_altmail->next_record();

$obj->getAdminById($_SESSION['ses_admin_id']);
$obj->next_record();
//echo 1;exit;

	
// change language when activated..
if($_SESSION['activate_lang_change']==1){
	$_SESSION['activate_lang_change'] = 0;
?>
<script>
	$(document).ready(function(){
		<?php
		if($obj->f('language')=="Spanish")
			$set_lang = "spn";
		else
			$set_lang = "eng";
		?>
		$('#languageId').val('<?php echo $set_lang;?>');
		$('#frmlanguage').submit();
	});
</script>

<?php
}


$obj_altphn->getalternatePhone($_SESSION['ses_admin_id']);
$obj_altphn->next_record();

// Get Country Name
$obj_coun->countries_byid($obj->f('country_id'));
$obj_coun->next_record();

if(isset($_POST['hid_edit']))
{
	//print_r($_POST);exit;
	
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$mobile_code=$_POST["mobile_code"];
	$country_id=$_POST["country_id"];
	$country_code=$_POST["country_code"];
	$province=$_POST["province"];
	$county=$_POST["county"];
	$city=$_POST["city"];
	$account_type=$_POST["account_type"];
	$language=$_POST["language"];
	$address=$_POST["address"];
	$postal_code=$_POST["postal_code"];
	
	
	$faq->checkEmailexists($email,$_SESSION['ses_admin_id']) ;

	if(!$faq->num_rows() > 0 ) 
	{
		$edit_admin->edit_admin_details($account_type,$fname,$lname,$email,$phone,'','','',$country_id,$country_code,$language,$province,$county,$city,$address,$postal_code,$_SESSION['ses_admin_id'],$mobile_code,'');
	
		$_SESSION['lang_change'] = 1;
		if($account_type==1)
		{
			//redirect
			header("Location:".$obj_base_path->base_path()."/professional_userprofile");
			exit;
		}
		else if($_POST['set_param']==1){
			//redirect
			header("Location:".$obj_base_path->base_path()."/personal_preference");
			exit;
		}
		else{
			header("Location:".$obj_base_path->base_path()."");
			exit;
		}

	}
	else
	{
		$_SESSION['login_msg'] = "Email Id Already Exists!";
		header("Location:".$obj_base_path->base_path()."/userprofile");
		exit;
	}
}


// get url of the pages
$obj_page->intro_page_id(5);
$obj_page->next_record();
$obj_page1->intro_page_id(6);
$obj_page1->next_record();


?>

  
<script type="text/javascript">

<?php
	if($obj->f('account_type')!=0){
?>
$(document).ready(function(){

	document.getElementById('pincode2').checked = true;
	$('#prof_types').show();
})
<?php
	}
?>
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

function getCounty(stateid,venue_county)
{
     //$('#div_city_display').html('<select name="venue_city" class="selectbg12" style="width:205px; margin-left:5px;"><option value="">City</option></select>');
	 data = "state_id="+stateid+"&venue_county="+venue_county;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_get_county_list.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_county_display").html(data);
	   }
	 });
}

function getCity(countyid,venue_city)
{
     $('#div_venue_display').html('<select name="venue" class="selectbg12" style="width:205px; margin-left:5px;"><option value="">Venue</option></select>');
	 data = "county_id="+countyid+"&venue_city_list="+venue_city;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_city.php",
	   cache: false,
	   type: "POST",
	   data: data,   
	   success: function(data){ 
	   $("#div_city_display").html(data);
	   }
	 });
}


function save_email()
{
	sendData = {"nemail":$('#nemail').val()};
	//alert($('#nemail').val());
	if($('#nemail').val() == ''){
		alert("Enter Optional Email");
	}
	else
	{
		 /*$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_set_country_code.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
		   $("#country_code").val(data);
		   }
		 });*/
	 }
}


$(document).ready(function(){
	$("#email_show").hide();
	$("#cell_show").hide();
	$("#pass_show").hide();
	
	$("#anotherEmail").click(function(){
	  $("#email_show").show('500');
	});
	
	$("#anotherCell").click(function(){
	  $("#cell_show").show('500');
	});
	
	$("#change_pass").click(function(){
	  $("#pass_show").show('500');
	});
	
	$("#cancelP").click(function(){
	  $("#pass_show").hide('500');
	});
	
	$("#cancelC").click(function(){
	  $("#cell_show").hide('500');
	});
	
	$("#cancelE").click(function(){
	  $("#email_show").hide('500');
	});
	
	$(".clear_primary").click(function(){
	  $("#altername_email").val('');
	});
	$(".clear_phn").click(function(){
	  $("#phone").val('');
	});
	
	$(".clear_alt_phn").click(function(){
	  $("#alt_phone").val('');
	});
})


function IsEmail() {
  var email = $('#email').val();
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  //alert(regex.test(email));
  
  if(regex.test(email) == false){
  	$('#email_err').html("Incorrect Email!");
  }
  
  return regex.test(email);
}


function delAltEmail()
{
	sendData = {"altername_email":$('#altername_email').val(),"mode":"del"};

	if($('#altername_email').val() == ''){
		$('#sh_alt_email').html("Please Enter Email");
	}
	else
	{
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			  window.location = "";
		   }
		 });
	 }
}

function save_alternate_email(param)
{
	if($('#altername_email').val() == ''){
		$('#sh_alt_email').html("Please Enter Email");
		setTimeout('$("#sh_alt_email").html("")',3000);
		return false;
	}
	
	if(param==1){
		sendData = {"altername_email":$('#altername_email').val(),"mode":"add"};
		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				  $('#show_alt_email').hide();
				  $('#show_alt_email_extra').show();
				  
				  // Show Status
				  <?php if($_SESSION['langSessId']=="spn"){?>
				 $('#showStatus').html("<p>Un correo electrónico de confirmación ha sido enviado a esa dirección. Por favor, confirme su solicitud haciendo clic en el enlace del correo electrónico.</p>")
				 <?php } else { ?>
				 $('#showStatus').html("<p>A confirmation email has been sent to that address. Please confirm your request by clicking on the link in the email.</p>")
				 <?php } ?>
				  
			   }
		   }
		 });
	}
	
	if(param==2)
	{
		sendData = {"altername_email":$('#altername_email').val(),"mode":"save"};
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				 <?php if($_SESSION['langSessId']=="spn"){?>
				 $('#sh_alt_email').html("<p>Altername dirección de correo electrónico guardado.</p>");
				 <?php } else { ?>
				 $('#sh_alt_email').html("<p>Altername Email address saved.</p>");
				 <?php } ?>
				 setTimeout('$("#sh_alt_email").html("")',3000);
			   }
		   }
		 });
	}
	
	if(param==3)
	{
	
		var oldm = $('#email').val();
		var altm = $('#altername_email').val();
		sendData = {"altername_email":$('#altername_email').val(),"mode":"make_primary","old_email":$('#email_orig_hid').val()};
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				 <?php if($_SESSION['langSessId']=="spn"){?>
				 $('#sh_alt_email').html("<p>Correo electrónico de verificación enviado a la adición de dirección de correo electrónico:</p>");
				 <?php } else { ?>
				 $('#sh_alt_email').html("<p>Verification email sent to added email address:</p>");
				 <?php } ?>
				 setTimeout('$("#sh_alt_email").html("")',3000);
			   }
			   else{
			   
			    <?php if($_SESSION['langSessId']=="spn"){?>
				 $('#sh_alt_email').html("<p>"+altm+" ya se utiliza como correo principal de otra cuenta KPasapp. Utilice otra dirección de correo electrónico alternativa.</p>");
				 <?php } else { ?>
				 $('#sh_alt_email').html("<p>"+altm+" is already used as primary email of another KPasapp account. Please use another alternate email address.</p>");
				 <?php } ?>
				 setTimeout('$("#sh_alt_email").html("")',3000);
			   }
		   }
		 });
	}
}
function save_phone(param){
	if($('#phone').val() == ''){
		$('#sh_alt_phn').html("Please Enter Phone");
		setTimeout('$("#sh_alt_phn").html("")',3000);
		return false;
	}
	
	if(param==1){
		sendData = {"phone":$('#phone').val(),"mode":"add"};
		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_phone.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				  $('#show_alt_phone').hide();
				  $('#show_alt_phn_extra').show();
			   }
		   }
		 });
	}
	
	if(param==2){
		sendData = {"phone":$('#phone').val(),"mode":"save"};
		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_phone.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				  $('#show_alt_phone').hide();
				  $('#show_alt_phn_extra').show();
			   }
		   }
		 });
	}
}
function save_alt_phone(param)
{
	if($('#alt_phone').val() == ''){
		$('#sh_alternate_phn').html("Please Enter Phone");
		setTimeout('$("#sh_alternate_phn").html("")',3000);
		return false;
	}
	
	if(param==1){
		sendData = {"alt_phone":$('#alt_phone').val(),"mode":"add"};
		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate_phone.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				  $('#show_alternate_phone').hide();
				  $('#show_alternate_phone_extra').show();
			   }
		   }
		 });
	}
	
	if(param==2)
	{
		sendData = {"alt_phone":$('#alt_phone').val(),"mode":"save"};
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate_phone.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				 <?php if($_SESSION['langSessId']=="spn"){?>
				 $('#sh_alternate_phn').html("<p>Altername Phone Number saved.</p>");
				 <?php } else { ?>
				 $('#sh_alternate_phn').html("<p>Altername Phone Number saved.</p>");
				 <?php } ?>
				 setTimeout('$("#sh_alternate_phn").html("")',3000);
			   }
		   }
		 });
	}

}

function delAltPhone()
{
	sendData = {"alt_phone":$('#alt_phone').val(),"mode":"del"};

	if($('#alt_phone').val() == ''){
		$('#sh_alternate_phn').html("Please Enter Alternate Phone");
	}
	else
	{
		 $.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_alternate_phone.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			  window.location = "";
		   }
		 });
	 }
}

function save_password(param)
{
	if($('#current_pass').val() == ''){
		$('#sh_current_pass').html("Please Enter Password");
		setTimeout('$("#sh_current_pass").html("")',3000);
		return false;
	}
	if($('#current_pass').val() != $('#pass_orig_hid').val()){
		$('#sh_current_pass').html("Please Enter Old Password");
		setTimeout('$("#sh_current_pass").html("")',3000);
		return false;
	}
	if($('#new_pass').val() == ''){
		$('#sh_new_pass').html("Please Enter New Password");
		setTimeout('$("#sh_new_pass").html("")',3000);
		return false;
	}
	if($('#re_pass').val() == '' || $('#re_pass').val() != $('#new_pass').val()){
		$('#sh_new_pass').html("Please Re-Enter Password");
		setTimeout('$("#sh_new_pass").html("")',3000);
		return false;
	}
	
	
	
	if(param==1){
		sendData = {"password":$('#new_pass').val(),"mode":"save"};
		$.ajax({ 
		   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/save_password.php",
		   cache: false,
		   type: "POST",
		   data: sendData,   
		   success: function(data){
			   if(data==1){
				  $('#sh_new_pass').html('Password Saved');
				  setTimeout('$("#sh_new_pass").html("")',3000);
				  $('#re_pass').val('');
				  $('#current_pass').val('');
				  $('#new_pass').val('');
			   }
		   }
		 });
	}
	
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
	window.location = "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/acctype_upd.php?param="+param;
	//$('#edit_pro').submit();
}
function checkPhone(){
	if($('#phone').val()!="")
	{
		if(!$('#phone').val().match(/^[0-9 \-]+$/))
		{
			<?php if($_SESSION['langSessId']=="spn"){ ?>
			alert("Por favor, sólo introducir caracteres numéricos, espacios o guiones! (Se permite la entrada:0-9,,-)")
			<?php } else {?>
			alert("Please only enter numeric characters,space or dash! (Allowed input:0-9,,-)")
			<?php } ?>
			$('#phone').focus();
			$('#phone').val('');
		}
	}
}

</script>
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
             <div class="blue_boxh">
                <p style="font-size: 28px; line-height: 30px;"><?php echo MYKPASAPP."<br/><span>".PERSSONAL."</span>";?></p>
             </div>
             <div class="blue_boxr" style="width: 754px;">
               <ul>
                   <li><a class="here" href="<?php echo $obj_base_path->base_path(); ?>/userprofile" <?php if($page_name=="userprofile") {?>  <?php } ?>><?php echo ACCOUNT; ?><!--Account--></a></li>
                   <li><a href="<?php echo $obj_base_path->base_path(); ?>/personal_preference"><?php echo PREFERENCES; ?><!--Preferences--></a></li>
                  <!-- <li><a href="<?php echo $obj_base_path->base_path(); ?>/social_network">Social Networks</a></li>-->
               </ul>
             </div>
            </div>
            <div class="clear"></div>
            
            <div style="width: 976px; float: none; margin: 0 auto;">	
            <div class="Tchai_box1" style="width: 570px; margin: 18px auto; border-left: 0x solid #CCCCCC; float: left;">
            
                <?php if($_SESSION['login_msg']){?>
                <div style="width: 494px; float: left; margin: 0 auto 0 23px;">
                    <h1 class="h1show"><?php echo $_SESSION['login_msg']; $_SESSION['login_msg'] = '';?></h1>
                </div>
                <?php } ?>
                
                
                <div class="clear"></div>

              <form method="post" action="" enctype="multipart/form-data" name="edit_pro" id="edit_pro" autocomplete = "off" onsubmit="return IsEmail();">
              <input type="hidden" name="hid_edit" id="hid_edit" value="1" />
              <input type="hidden" name="set_param" id="set_param" value="" />
                <table width="100%" align="center" border="0" cellpadding="4" cellspacing="4" style="border-collapse:separate;">
                   <tr>
                    <td colspan="2"><div class="text_top"><?php echo ACCOUNT_INFO;?></div></td>
                   </tr>
                   <tr>
                    <td colspan="2"><div class="text_top" id="showStatus"></div></td>
                  </tr>
                  <tr>
                    <td style="padding-left: 18px;"><?php echo ACCOUNT_TYPE;?></td>
                    <td>
                        
                        <span style="margin-right:1px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/<?php echo $obj_page->f('page_link')?>" target="_blank" style="text-decoration:underline;"><?php echo Personal;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode1" checked="checked" value="0"  /></span> <?php echo OR_TXT;?>
                        <span style="margin-left:10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/<?php echo $obj_page1->f('page_link')?>" target="_blank" style="text-decoration:underline;"><?php echo Professional;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode2" value="1" onclick="redirectPage(1)"  /></span>                            
                    </td>
                  </tr>
                  <tr>
                <td width="23%" style="padding-left: 18px;"><?php echo FIRST_NAME;?> <span style="color:red;">*</span></td>
                    <td width="77%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="<?php echo $obj->f('fname')?>" style="width: 190px;"/><br/><span class="err" id="err_name"></span></td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo LAST_NAME;?><span style="color:red;">*</span></td>
                <td>
                    <input type="text" name="lname" id="lname" class="textbg_grey required" value="<?php echo $obj->f('lname');?>" style="width: 190px;"/> <br/>
                    <span class="err" id="err_lname"></span>
                </td>
              </tr>						  
              <tr>
                <td style="padding-left: 18px;"><?php echo PRIMARY_EMAIL;?></td>
                <td>
                <input type="text" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" onblur="return IsEmail();" readonly="readonly" />
                <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>
                </td>
              </tr>
                                          
              <tr>
                <td style="padding-left: 18px;"><?php echo CELL_PHONE;?></td>
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

                  <input type="text" name="phone" id="phone" class="textbg_grey" value="<?php echo $obj->f('mobile')?>" style="width: 190px;" onkeyup="checkPhone()" />
                     <!-- <span id="show_alt_phone" <?php if($obj->f('phone')){?> style="display:none;"<?php } ?>>
                    <input type="button" name="save" id="save" class="event_save19" value="Add" onclick="save_phone(1)" style="margin: 0 0 0 10px;" />
                    <input type="button" name="cancel" id="cancelE" value="Cancel" class="event_save19 clear_phn"/><img src="<?php echo $obj_base_path->base_path(); ?>/images/question3_mark.gif" border="0" style="margin: 2px 5px;"/>
                    </span>-->
                    
                                            
                    <div id="sh_alt_phn" style="color:red; margin-left:6px;"></div>
                </td>
              </tr>
              <?php if($_SESSION['login_mode']=="site"){?>
              <tr>
                <td style="padding-left: 18px;"><?php echo PASSWORD;?> </td>
                <td><div style="padding:6px; cursor:pointer;width:130px;" id="change_pass"><?php echo CHANGE_PASSWORD;?></div>
                <div style="padding:6px;" id="pass_show">
                    <table style="border:none; padding:4px;">
                    <tr>
                    <td style="border:none; padding:4px;"><?php echo CURRENT?>: </td>
                    <td style="border:none; padding:4px;">
                    <input type="hidden" id="pass_orig_hid" value="<?php echo $obj->f('rem_password')?>"/>
                    <input type="password" value="" name="current_pass" id="current_pass" />
                    <div id="sh_current_pass" style="color:red; margin-left:6px;"></div>
                    </td>
                    </tr>
                    <tr>
                    <td style="border:none; padding:4px;"><?php echo _NEW?>: </td>
                    <td style="border:none; padding:4px;"><input type="password" value="" name="new_pass" id="new_pass" /></td>
                    </tr>
                    <tr>
                    <td style="border:none; padding:4px;"><?php echo RETYPENEW?>: </td>
                    <td style="border:none; padding:4px;"><input type="password" value="" name="re_pass" id="re_pass" />
                    <div id="sh_new_pass" style="color:red; margin-left:6px;"></div>
                    </td>
                    </tr>	
                    <tr>
                    <td style="border:none; padding:4px;"><input class="event_save19" type="button" name="save" id="save" value="<?php echo SAVECHANGE?>" onclick="save_password(1)" /></td>
                    <td style="border:none; padding:4px;"><input class="event_save19" type="button" name="cancel" id="cancelP" value="<?php echo CANCEL?>" /></td>
                    </tr>
                    </table>
                    <div class="clear"></div><span class="err" id="ncell_err"></span> 
                </div>
                </td>
              </tr>
              <?php } ?>
              <tr>
                <td style="padding-left: 18px;"><?php echo LANGUAGE;?> <span style="color:red;">*</span></td>
                <td>
                <select name="language" id="language" class="textbg_grey" style="width:205px; margin-left:5px;">
                <option value="English" <?php if($obj->f('language')=="English"){?> selected="selected"<?php } ?>><?php echo ENGL;?></option>
                <option value="Spanish" <?php if($obj->f('language')=="Spanish"){?> selected="selected"<?php } ?>><?php echo SPAL;?></option>
                </select>
                 <br/><span class="err" id="err_lname"></span></td>
              </tr>
              
              <tr>
                <td style="padding-left: 18px;"><?php echo COUNTRY;?><span style="color:red;">*</span></td>
                <td>
                    <select name="country_id" id="country_id" onchange="setCountryCode()" class="textbg_grey" style="width:205px;margin-left:5px;">
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
                        <option value="<?php echo $obj_country->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $obj->f('country_id')==0){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $obj->f('country_id')==0){ echo $sel; } else if($obj->f('country_id')==$obj_country->f('id')) { echo $sel;}  ?>><?php echo $obj_country->f('nicename');?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="hidden" name="country_code" id="country_code" value="<?php echo $value_code;?>" />
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo STATE;?><span style="color:red; display:none;" id="star1">*</span></td>
                <td>
                  <div id="div_state_display">
                   <select name="province" id="province" class="selectbg12" style="width:205px; margin-left:5px;">
                        <option value="">State</option>
                        <?php
                          $obj_venuestate->getStateById($obj->f('country_id'));
                          while($row = $obj_venuestate->next_record())
                          {
                          ?>
                          <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($obj->f('province')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_venuestate->f('state_name');?></option>
                            <?php
                          }
                          ?>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo COUNTY;?><span style="color:red; display:none;" id="star2">*</span></td>
                <td>
                    <input type="text" name="county" id="county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('county')?>" />
                    <?php /*?><div id="div_county_display">
                        <select name="county" id="county" class="textbg_grey" onchange="getCity(this.value,'');" style="width:205px; margin-left:5px;">
                          <option value="">County</option>
                           <?php
                            $obj_getcounty->getCountyNameByState($obj->f('province'));
                            while($obj_getcounty->next_record())
                            {
                            ?>
                            <option value=<?php echo $obj_getcounty->f("id")?> <?php if($obj->f('county')==$obj_getcounty->f('id')){?> selected="selected"<?php }?> >
                            <?php echo $obj_getcounty->f('county_name')?></option>
                            <?php
                            }
                      ?>
                         </select>
                     </div><?php */?>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo CITY;?><span style="color:red; display:none;" id="star3">*</span></td>
                <td>
                      <input type="text" name="city" id="city" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('city')?>" />  
                    <?php /*?><div id="div_city_display">
                      <select name="city" id="city" class="textbg_grey" style="width:205px; margin-left:5px;">
                      <option value="">City</option>
                       <?php
                            $obj_getcity = new user;
                            $obj_getcity->getCityNameByCounty($obj->f('county'));
                            while($obj_getcity->next_record())
                            {
                            ?>
                            <option value=<?php echo $obj_getcity->f("id")?> <?php if($obj->f('city')==$obj_getcity->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_getcity->f('city_name')?></option>
                            <?php
                            }
                      ?>
                      </select>
                    </div><?php */?>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo ADDRESS;?></td>
                <td>
                <textarea name="address" id="address" style="width:210px; margin-left: 6px;"><?php echo $obj->f('address')?></textarea>
                </td>
              </tr>
              <tr>
                <td style="padding-left: 18px;"><?php echo POSTAL_CODE;?></td>
                <td>
                <input type="text" name="postal_code" id="postal_code" class="textbg_grey" style="width: 190px; margin-right:6px;" value="<?php echo $obj->f('postal_code')?>" />
                </td>
              </tr>
              <tr>
                  <td colspan="2">
                 <span style="margin-left:14px;"><!--<input id="terms_condition" type="checkbox" value="1" name="terms_condition">--><?php echo TERMS_CONDITION?></span>
                  </td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:left; padding-left: 15px;"><input type="button" name="submit1" id="submit1" value="<?php echo NEXT;?>" style="cursor:pointer;" class="event_save" onclick="redirectPage(1)" />
                <span style="margin-left:10px;"><input type="button" name="submit1" id="submit1" value="<?php echo SAVE_EXIT;?>" style=" cursor:pointer;"  class="event_save"  onclick="redirectPage(2)" /></span></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
              </form>
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
<?php include("include/frontend_footer.php");?>
</div>


</body>

</html>
