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

$busi_obj = new User;
$faq_busi = new User;
//print_r($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

// Get Business Info
$busi_obj->getBusinessInfoById($_SESSION['ses_admin_id']);
$busi_obj->next_record();
//echo 1;exit;

if(isset($_POST['hid_edit']))
{
	//print_r($_POST);exit;
	
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$mobile_code=$_POST["mobile_code"];
	$phone_code=$_POST["phone_code"];
	$propphone=$_POST["propphone"];
	$us_phone=$_POST["us_phone"];
	$nextel=$_POST["nextel"];
	$country_id=$_POST["country_id"];
	$country_code=$_POST["country_code"];
	$language=$_POST["language"];
	$province=$_POST["province"];
	$county=$_POST["county"];
	$city=$_POST["city"];
	$account_type=$_POST["account_type"];
	$address=$_POST["address"];
	$postal_code=$_POST["postal_code"];
	
	$bus_name=$_POST["bus_name"];
	$bus_display_name=$_POST["bus_display_name"];
	$bus_email=$_POST["bus_email"];
	$bus_phone=$_POST["bus_phone"];
	$bus_propphone=$_POST["bus_propphone"];
	$bus_us_phone=$_POST["bus_us_phone"];
	$bus_nextel=$_POST["bus_nextel"];
	$bus_country_id=$_POST["bus_country_id"];
	$bus_country_code=$_POST["bus_country_code"];
	$bus_language=$_POST["bus_language"];
	$bus_province=$_POST["bus_province"];
	$bus_county=$_POST["bus_county"];
	$bus_city=$_POST["bus_city"];
	$bus_address=$_POST["bus_address"];
	$bus_postal_code=$_POST["bus_postal_code"];
	$bus_mobile_code=$_POST["bus_mobile_code"];
	$bus_phone_code=$_POST["bus_phone_code"];
	
	$tax_id_num=$_POST["tax_id_num"];
	
	if(isset($_POST["act_event"]) && $_POST["act_event"]==1) $act_event=$_POST["act_event"]; else $act_event=0;
	if(isset($_POST["act_venue"]) && $_POST["act_venue"]==1) $act_venue=$_POST["act_venue"]; else $act_venue=0;
	if(isset($_POST["act_perform"]) && $_POST["act_perform"]==1) $act_perform=$_POST["act_perform"]; else $act_perform=0;
	if(isset($_POST["act_provider"]) && $_POST["act_provider"]==1) $act_provider=$_POST["act_provider"]; else $act_provider=0;
	if(isset($_POST["act_sponser"]) && $_POST["act_sponser"]==1) $act_sponser=$_POST["act_sponser"]; else $act_sponser=0;
	
	$website=$_POST["website"];
	
	
	$faq->checkEmailexists($email,$_SESSION['ses_admin_id']);

	if(!$faq->num_rows() > 0 ) 
	{	
		//print_r($_POST);exit;
		
		$edit_admin->edit_admin_details($account_type,$fname,$lname,$email,$phone,$propphone,$us_phone,$nextel,$country_id,$country_code,$language,$province,$county,$city,$address,$postal_code,$_SESSION['ses_admin_id'],$mobile_code,$phone_code);

		
		$faq_busi->checkBusinessInfo($_SESSION['ses_admin_id']);
		//echo $faq_busi->num_rows();exit;
		
		if($faq_busi->num_rows() > 0 ) 
		{
			$faq_busi->edit_admin_business_info($bus_name,$bus_display_name,$bus_email,$bus_phone,$bus_propphone,$bus_us_phone,$bus_nextel,$bus_country_id,$bus_country_code,$bus_language,$bus_province,$bus_county,$bus_city,$bus_address,$bus_postal_code,$tax_id_num,$act_event,$act_venue,$act_perform,$act_provider,$act_sponser,$website,$_SESSION['ses_admin_id'],$bus_mobile_code,$bus_phone_code);
		}
		else
		{
			$faq_busi->add_admin_business_info($bus_name,$bus_display_name,$bus_email,$bus_phone,$bus_propphone,$bus_us_phone,$bus_nextel,$bus_country_id,$bus_country_code,$bus_language,$bus_province,$bus_county,$bus_city,$bus_address,$bus_postal_code,$tax_id_num,$act_event,$act_venue,$act_perform,$act_provider,$act_sponser,$website,$_SESSION['ses_admin_id'],$bus_mobile_code,$bus_phone_code);
		}
		
		
		$_SESSION['lang_change'] = 1;
		
		if($account_type==0)
		{
			//redirect
			header("Location:".$obj_base_path->base_path()."/userprofile");
			exit;
		}
		else if($_POST['set_param']==1){
			//redirect
			header("Location:".$obj_base_path->base_path()."/professional_preference");
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

function bus_setCountryCode()
{
	sendData = {"country_id":$('#country_id').val()};
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_set_country_code.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#bus_country_code").val(data);
	   }
	 });
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/ajax_state_bycountry.php",
	   cache: false,
	   type: "POST",
	   data: sendData,   
	   success: function(data){
	   $("#div_bus_state_display").html(data);
	   }
	 });
}
</script>
<script language="javascript" type="text/javascript">
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
   //  $('#div_venue_display').html('<select name="venue" class="selectbg12" style="width:205px; margin-left:5px;"><option value="">Venue</option></select>');
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
function checkReg()
{
	var msg ='';
	var msg1 ='';
	if($('#fname').val() == '') msg +="<?php echo PL_ENTER." ".FIRST_NAME;?>\n";
	if($('#lname').val() == '') msg +="<?php echo PL_ENTER." ".LAST_NAME;?>\n";
	if($('#email').val() == '') msg +="<?php echo PL_ENTER." ".PRIMARY_EMAIL;?>\n";
	if($('#language').val() == '') msg +="<?php echo PL_ENTER." ".LANGUAGE;?>\n";
	if($('#province').val() == '') msg +="<?php echo PL_ENTER." ".STATE;?>\n";
	if($('#county').val() == '') msg +="<?php echo PL_ENTER." ".COUNTY;?>\n";
	if($('#city').val() == '') msg +="<?php echo PL_ENTER." ".CITY;?>\n";
	if($('#address').val() == '') msg +="<?php echo PL_ENTER." ".ADDRESS;?>\n";
	if($('#postal_code').val() == '') msg +="<?php echo PL_ENTER." ".POSTAL_CODE;?>\n";
	
	if($('#bus_name').val() == '') msg1 +="<?php echo PL_ENTER." ".LEGAL_BUS_NAME." ".IN_BUSS_INFO;?>\n";
	if($('#bus_display_name').val() == '') msg1 +="<?php echo PL_ENTER." ".DISPLAY_NAME." ".IN_BUSS_INFO;?>\n";
	if($('#bus_province').val() == '') msg1 +="<?php echo PL_ENTER." ".STATE." ".IN_BUSS_INFO;?>\n"; 
	if($('#bus_email').val() == '') msg1 +="<?php echo PL_ENTER." ".PRIMARY_EMAIL." ".IN_BUSS_INFO;?>\n"; 
	if($('#bus_county').val() == '') msg1 +="<?php echo PL_ENTER." ".COUNTY." ".IN_BUSS_INFO;?>\n"; 
	if($('#bus_city').val() == '') msg1 +="<?php echo PL_ENTER." ".CITY." ".IN_BUSS_INFO;?>\n";
	if($('#bus_address').val() == '') msg1 +="<?php echo PL_ENTER." ".ADDRESS." ".IN_BUSS_INFO;?>\n";
	if($('#bus_postal_code').val() == '') msg1 +="<?php echo PL_ENTER." ".POSTAL_CODE." ".IN_BUSS_INFO;?>\n";
	
	
	
	
	if(msg!=''){ alert(msg); return false; }
	else
	{
		if(msg1!=''){ alert(msg1); return false; }
		else
		$('#edit_pro').submit();
	}
	
}


function submitbut(param)
{
	$('#set_param').val(param);
	checkReg();
}

function redirectPage(param)
{
	$('#set_param').val(param);
	//$('#edit_pro').submit();
	window.location = "<?php echo $obj_base_path->base_path(); ?>/ajax_folder/acctype_upd.php?param="+param;
}

function getpersoninfo(chb)
{
	if(chb.checked==1)
	{
		$('#bus_name').val($('#fname').val());
		$('#bus_display_name').val($('#lname').val());
		$('#bus_email').val($('#email').val());
		$('#bus_phone').val($('#phone').val());
		$('#bus_propphone').val($('#propphone').val());
		$('#bus_us_phone').val($('#us_phone').val());
		$('#bus_nextel').val($('#nextel').val());
		$('#bus_country_code').val($('#fname').val());
		$('#bus_country_id').val($('#country_id').val());
		$('#bus_language').val($('#language').val());
		$('#bus_province').val($('#province').val());
		$('#bus_county').val($('#county').val());
		$('#bus_city').val($('#city').val());
		$('#bus_address').val($('#address').val());
		$('#bus_postal_code').val($('#postal_code').val());
		$('#bus_mobile_code').val($('#mobile_code').val());
		$('#bus_phone_code').val($('#phone_code').val());
	}
}
</script>

<script>
function isUrl() {
	var s = $('#website').val();
	if(s!=""){
		var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		if(!regexp.test(s)){
			<?php if($_SESSION['langSessId']=="spn"){ ?>
			alert("url inválida")
			<?php } else {?>
			alert("invalid url");
			<?php } ?>
			
			$('#website').val('');
			$('#website').focus();
		}
	}
}

function checkPhone(text_field_name){
	if($('#'+text_field_name).val()!="")
	{
		if(!$('#'+text_field_name).val().match(/^[0-9 \-]+$/))
		{
			<?php if($_SESSION['langSessId']=="spn"){ ?>
			alert("Por favor, sólo introducir caracteres numéricos, espacios o guiones! (Se permite la entrada:0-9,,-)")
			<?php } else {?>
			alert("Please only enter numeric characters,space or dash! (Allowed input:0-9,,-)")
			<?php } ?>
			$('#'+text_field_name).focus();
			$('#'+text_field_name).val('');
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
             <div class="blue_boxh"><p style="font-size: 28px; line-height: 30px;">
			 <?php echo MYKPASAPP."<br/><span>".PROFPRO."</span>";?>
             </p>
             </div>
             <div class="blue_boxr" style="width: 754px;">
               <ul>
                <li><a class="here" href="<?php echo $obj_base_path->base_path(); ?>/professional_userprofile">
                <?php echo ACCOUNT;?><!--Account--></a></li>
                <li><a href="<?php echo $obj_base_path->base_path(); ?>/professional_preference"><?php echo PREFERENCES;?><!--Preferences--></a></li>
                <li><a href="<?php echo $obj_base_path->base_path(); ?>/professional_payment"><?php echo PAYMENT;?><!--Payment--></a></li>
               </ul>
             </div>
          </div>
          <div class="clear"></div>                    
            <div style="width: 976px; float: none; margin: 0 auto;">
            <div class="clear"></div>    
            <div style="font:14px/20px Arial,Helvetica,sans-serif;"><?php echo ACCOUNT_INFO;?></div>
            <div style="font:14px/20px Arial,Helvetica,sans-serif;" id="showStatus"></div>
              <form method="post" action="" enctype="multipart/form-data" name="edit_pro" id="edit_pro" autocomplete = "off" onsubmit="return checkReg();">
              <input type="hidden" name="hid_edit" id="hid_edit" value="1" />
              <input type="hidden" name="set_param" id="set_param" value="" />
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td><table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" class="prefer_pro1">
                      <tr>
                        <td colspan="2"><span style="font-size:18px;"><?php echo CONTACT_INFORMATION;?></span></td>
                      </tr>
                      <tr>
                        <td><?php echo ACCOUNT_TYPE;?></td>
                        <td>
                            <span style="margin-right:1px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/<?php echo $obj_page->f('page_link')?>" target="_blank" style="text-decoration:underline;"><?php echo Personal;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" id="pincode1"  value="0"  onclick="redirectPage(0)" /></span> <?php echo OR_TXT;?>
                            <span style="margin-left:10px;"><a href="<?php echo $obj_base_path->base_path(); ?>/about/<?php echo $obj_page1->f('page_link')?>" target="_blank" style="text-decoration:underline;"><?php echo Professional;?></a>&nbsp;&nbsp;<input type="radio" name="account_type" checked="checked"  id="pincode2" value="1" onclick="displayOther()"  /></span></td>
                      </tr>
                      <tr>
                        <td width="27%"><?php echo FIRST_NAME;?> <span style="color:red;">*</span></td>
                            <td width="73%"><input type="text" name="fname" id="fname" class="textbg_grey required" value="<?php echo $obj->f('fname')?>" style="width: 190px;"/><span class="err" id="err_name"></span></td>
                      </tr>
                      <tr>
                        <td><?php echo LAST_NAME;?><span style="color:red;">*</span></td>
                        <td>
                            <input type="text" name="lname" id="lname" class="textbg_grey required" value="<?php echo $obj->f('lname');?>" style="width: 190px;"/><span class="err" id="err_lname"></span></td>
                      </tr>						  
                      <tr>
                        <td><?php echo PRIMARY_EMAIL;?><span style="color:red;">*</span></td>
                        <td>
                        <input type="text" name="email" id="email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('email')?>" onblur="return IsEmail();" readonly="readonly" />
                        <input type="hidden" id="email_orig_hid" value="<?php echo $obj->f('email')?>"/>                    </td>
                      </tr>
                                                  
                      <tr>
                        <td><?php echo CELL_PHONE;?></td>
                        <td>
                            <select name="mobile_code" id="mobile_code" class="textbg_grey" style="width:125px; margin-left:5px;">
                            <?php
                                 $obj_cntry = new user;
                                $sel = "selected='selected'";
                                 $obj_cntry->countries_list();
                                    while($obj_cntry->next_record()){
                            ?>
                                <option value="<?php echo $obj_cntry->f('iso');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $obj->f('mobile_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $obj->f('mobile_code')==''){ echo $sel; } else if($obj->f('mobile_code') == $obj_cntry->f('iso')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                            <?php
                                }
                            ?>    
                            </select>
        
                            <input type="text" name="phone" id="phone" style="width: 150px;" class="textbg_grey" value="<?php echo $obj->f('mobile')?>" onblur="checkPhone('phone')" />
                            <div id="sh_alt_phn" style="color:red; margin-left:6px;"></div></td>
                      </tr>
                      
                      <tr>
                        <td><?php echo PROP_PHONE;?></td>
                        <td>
                            <select name="phone_code" id="phone_code" class="textbg_grey" style="width:125px; margin-left:5px;">
                            <?php
                                 $obj_cntry = new user;
                                $sel = "selected='selected'";
                                 $obj_cntry->countries_list();
                                    while($obj_cntry->next_record()){
                            ?>
                                <option value="<?php echo $obj_cntry->f('iso');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $obj->f('phone_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $obj->f('phone_code')==''){ echo $sel; } else if($obj->f('phone_code')==$obj_cntry->f('iso')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                            <?php
                                }
                            ?>    
                            </select>
        
                            <input type="text" name="propphone" id="propphone" style="width:150px;" class="textbg_grey" value="<?php echo $obj->f('phone')?>" onblur="checkPhone('propphone')" />
                                                    
                         </td>
                      </tr>
                      
                      <tr>
                        <td><?php echo US_PHONE_NEXTEL;?></td>
                        <td><input type="text" name="us_phone" id="us_phone" class="textbg_grey required" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('us_phone')?>" /></td>
                      </tr>
                      
                      <tr>
                        <td><?php echo NEXTEL;?></td>
                        <td>
                        <input type="text" name="nextel" id="nextel" class="textbg_grey required" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('nextel')?>" />
                        </td>
                      </tr>
                      
                      <?php if($_SESSION['login_mode']=="site"){?>
                      <tr>
                        <td><?php echo PASSWORD;?> </td>
                        <td><div style="padding:6px; cursor:pointer;" id="change_pass"><?php echo CHANGE_PASSWORD;?></div>
                        <div style="padding:6px;" id="pass_show">
                            <table style="border:none; padding:4px;">
                            <tr>
                            <td style="border:none; padding:4px;"><?php echo CURRENT;?>:<!--Current--> </td>
                            <td style="border:none; padding:4px;">
                            <input type="hidden" id="pass_orig_hid" value="<?php echo $obj->f('rem_password');?>"/>
                            <input type="password" value="" name="current_pass" id="current_pass" />
                            <div id="sh_current_pass" style="color:red; margin-left:6px;"></div>                        </td>
                            </tr>
                            <tr>
                            <td style="border:none; padding:4px;"><?php echo _NEW;?>:<!--New--> </td>
                            <td style="border:none; padding:4px;"><input type="password" value="" name="new_pass" id="new_pass" /></td>
                            </tr>
                            <tr>
                            <td style="border:none; padding:4px;"><?php echo RETYPENEW;?>: <!--Retype New--></td>
                            <td style="border:none; padding:4px;"><input type="password" value="" name="re_pass" id="re_pass" />
                            <div id="sh_new_pass" style="color:red; margin-left:6px;"></div>                        </td>
                            </tr>	
                            <tr>
                            <td style="border:none; padding:4px;"><input class="event_save19" type="button" name="save" id="save" value="<?php echo SAVECHANGE;?>" onclick="save_password(1)" /></td>
                            <td style="border:none; padding:4px;"><input class="event_save19" type="button" name="cancel" id="cancelP" value="<?php echo CANCEL;?>" /></td>
                            </tr>
                            </table>
                            <div class="clear"></div><span class="err" id="ncell_err"></span>                    </div>                    </td>
                      </tr>
                      <?php } ?>
                                        
                      <tr>
                        <td><?php echo COUNTRY;?><span style="color:red;">*</span></td>
                        <td>
                            <select name="country_id" id="country_id" onchange="setCountryCode()" class="textbg_grey" style="width:205px; margin-left:5px;">
                            <?php
                                $value_code = '';
                                $sel = "selected='selected'";
                                if($_SESSION['langSessId']=="spn")
                                    $value_code = "value='52'";
                                else
                                    $value_code = "value='1'";
                                    
                                $obj_country->countries_list();
                                while($obj_country->next_record()){
                            ?>
                                <option value="<?php echo $obj_country->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $obj->f('country_id')==0){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $obj->f('country_id')==0){ echo $sel; } else if($obj->f('country_id')==$obj_country->f('id')) { echo $sel;}  ?>><?php echo $obj_country->f('nicename');?></option>
                            <?php
                            }
                            ?>
                            </select>
                            <input type="hidden" name="country_code" id="country_code" <?php echo $value_code;?>  /></td>
                      </tr>
                      <tr>
                        <td><?php echo LANGUAGE;?> <span style="color:red;">*</span></td>
                        <td>
                        <select name="language" id="language" class="textbg_grey" style="width:205px; margin-left:5px;">
                        <option value="English" <?php if($obj->f('language')=="English"){?> selected="selected"<?php } ?>>
                        <?php echo "English";?><!--English-->
                        </option>
                        <option value="Spanish" <?php if($obj->f('language')=="Spanish"){?> selected="selected"<?php } ?>>
                        <?php echo "espa&#241;ol";?><!--Spanish-->
                        </option>
                        </select>
                         <span class="err" id="err_lname"></span></td>
                      </tr>
                      <tr>
                        <td><?php echo STATE;?><span style="color:red;" id="star1">*</span></td>
                        <td>
                          <div id="div_state_display">
                           <select name="province" id="province" class="selectbg12"  style="width:205px; margin-left:5px;">
						   <?php /*?> onChange = "getCounty(this.value, '');" <?php */?>
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
                          </div></td>
                      </tr>
                      
                      <tr>
                        <td><?php echo COUNTY;?><span style="color:red;" id="star2">*</span></td>
                        <td>
                            <div id="div_county_display">
                               <?php /*?> <select name="county" id="county" class="textbg_grey" onchange="getCity(this.value,'');" style="width:205px; margin-left:5px;">
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
                                 </select><?php */?>
                                 
                              <input type="text" name="county" id="county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('county')?>" />
                             </div>
                        </td>
                      </tr>
                      
                      <tr>
                        <td><?php echo CITY;?><span style="color:red;" id="star3">*</span></td>
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
                                    <option value=<?php echo $obj_getcity->f("id")?> <?php if($obj->f('city')==$obj_getcity->f('id')){?> selected="selected"<?php }?>><?php echo $obj_getcity->f('city_name')?></option>
                              <?php
                                    }
                              ?>
                              </select>
                        </div><?php */?>
                      </td>
                      </tr>
                      <tr>
                        <td><?php echo ADDRESS;?><span style="color:red;">*</span></td>
                        <td>
                        <textarea name="address" id="address" style="width:210px; padding: 4px; background: #f5f5f5; border: 1px solid #CCCCCC;margin-left: 6px;"><?php echo $obj->f('address')?></textarea></td>
                      </tr>
                      <tr>
                        <td><?php echo POSTAL_CODE;?><span style="color:red;">*</span></td>
                        <td>
                        <input type="text" name="postal_code" id="postal_code" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $obj->f('postal_code')?>" /></td>
                      </tr>
                      <tr>
                      <td colspan="2" style="height: 310px;">&nbsp;</td>
                      </tr>
                     
                      <?php /*?><tr>
                        <td colspan="2" style="text-align:left; padding-left: 132px;"><input type="button" name="submit1" id="submit1" value="<?php echo NEXT;?>" style="cursor:pointer;" class="event_save" onclick="redirectPage(1)" />
                        <span style="margin-left:10px;"><input type="button" name="submit1" id="submit1" value="<?php echo SAVE_EXIT;?>" style=" cursor:pointer;"  class="event_save"  onclick="redirectPage(2)" /></span></td>
                      </tr><?php */?>                    
                    
                      
                 	</table></td> 
                    
                    
                    <!------------------------------Business information---------------------------------------->
                    
                    
                    
                   <td align="left" valign="top">
                   <table width="100%" align="left" border="0" cellpadding="4" cellspacing="0" class="prefer_pro">
                      <tr>
                        <td colspan="2"><span style="font-size:18px;"><?php echo BUSINESS_INFORMATION;?></span></td>
                      </tr>
                    <tr>
                    <td colspan="2">
                    <input type="checkbox" name="bus_info" id="bus_info" class="required email" value="1" style="width: auto;padding-top:10px;" onclick="getpersoninfo(this)" />
                     <?php echo CHECKALL;?></td>
                    </tr>
                    <tr>
                    <td width="35%"><?php echo LEGAL_BUS_NAME;?> <span style="color:red;">*</span></td>
                        <td width="65%"><input type="text" name="bus_name" id="bus_name" class="textbg_grey required" value="<?php echo $busi_obj->f('busi_name')?>" style="width: 190px;"/><span class="err" id="err_name"></span></td>
                    </tr>
                    <tr>
                    <td><?php echo DISPLAY_NAME;?><span style="color:red;">*</span></td>
                    <td>
                    <input type="text" name="bus_display_name" id="bus_display_name" class="textbg_grey required" value="<?php echo $busi_obj->f('busi_display_name');?>" style="width: 190px;"/> <span class="err" id="err_lname"></span>
                    </td>
                    </tr>						  
                    
                    <tr>
                    <td><?php echo PRIMARY_EMAIL;?><span style="color:red;">*</span></td>
                    <td>
                    <input type="text" name="bus_email" id="bus_email" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_primary_email')?>" onblur="return IsEmail();" readonly="readonly" />
                    </td>
                    </tr>
                    <tr>
                        <td><?php echo CELL_PHONE;?></td>
                        <td>
                            <select name="bus_mobile_code" id="bus_mobile_code" class="textbg_grey" style="width:125px; margin-left:5px;" >
                            <?php
                                 $obj_cntry_bus = new user;
                                $sel = "selected='selected'";
                                 $obj_cntry_bus->countries_list();
                                    while($obj_cntry_bus->next_record()){
                            ?>
                                <option value="<?php echo $obj_cntry_bus->f('iso');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry_bus->f('id')==138 && $busi_obj->f('bus_mobile_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry_bus->f('id')==226 && $busi_obj->f('bus_mobile_code')==''){ echo $sel; } else if($busi_obj->f('bus_mobile_code')==$obj_cntry_bus->f('iso')) { echo $sel;}  ?>><?php echo $obj_cntry_bus->f('phonecode')." - ".$obj_cntry_bus->f('nicename');?></option>
                            <?php
                                }
                            ?>    
                            </select>
                            <input type="text" name="bus_phone" id="bus_phone" style="width: 100px;" class="textbg_grey" value="<?php echo $busi_obj->f('busi_mobile')?>" onblur="checkPhone('bus_phone')"/>
                         </td>
                      </tr>
                      
                      <tr>
                        <td><?php echo PROP_PHONE;?></td>
                        <td>
                            <select name="bus_phone_code" id="bus_phone_code" class="textbg_grey" style="width:125px; margin-left:5px;">
                            <?php
                                 $obj_cntry = new user;
                                 $sel = "selected='selected'";
                                 $obj_cntry->countries_list();
                                    while($obj_cntry->next_record()){
                            ?>
                                <option value="<?php echo $obj_cntry->f('iso');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_cntry->f('id')==138 && $busi_obj->f('bus_phone_code')==''){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_cntry->f('id')==226 && $busi_obj->f('bus_phone_code')==''){ echo $sel; } else if($busi_obj->f('bus_phone_code')==$obj_cntry->f('iso')) { echo $sel;}  ?>><?php echo $obj_cntry->f('phonecode')." - ".$obj_cntry->f('nicename');?></option>
                            <?php
                                }
                            ?>    
                            </select>
                            <input type="text" name="bus_propphone" id="bus_propphone" style="width: 100px;" class="textbg_grey" value="<?php echo $busi_obj->f('busi_phone')?>" onblur="checkPhone('bus_propphone')" />
                                                    
                            <div id="sh_alt_phn1" style="color:red; margin-left:6px;"></div></td>
                      </tr>
                      <tr>
                        <td><?php echo US_PHONE_NEXTEL;?></td>
                        <td>
                        <input type="text" name="bus_us_phone" id="bus_us_phone" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_us_phone')?>" />
                        </td>
                      </tr>
                      
                      <tr>
                        <td><?php echo NEXTEL;?></td>
                        <td>
                        <input type="text" name="bus_nextel" id="bus_nextel" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_nextel')?>" />
                        </td>
                      </tr>
                    
                    <tr>
                        <td><?php echo COUNTRY;?><span style="color:red;">*</span></td>
                        <td>
                        <select name="bus_country_id" id="bus_country_id" onchange="bus_setCountryCode()" class="textbg_grey" style="width:205px; margin-left:5px;">
                        <?php
                            $bus_value_code = '';
                            $sel = "selected='selected'";
                            if($_SESSION['langSessId']=="spn")
                                $bus_value_code = "value='52'";
                            else
                                $bus_value_code = "value='1'";
                                
                            $obj_country->countries_list();
                            while($obj_country->next_record()){
                        ?>
                            <option value="<?php echo $obj_country->f('id');?>" <?php if($_SESSION['langSessId']=="spn" && $obj_country->f('id')==138 && $busi_obj->f('busi_country_id')==0){ echo $sel; } else if($_SESSION['langSessId']=="eng" && $obj_country->f('id')==226 && $busi_obj->f('busi_country_id')==0){ echo $sel; } else if($busi_obj->f('busi_country_id')==$obj_country->f('id')) { echo $sel;}  ?>><?php echo $obj_country->f('nicename');?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <input type="hidden" name="bus_country_code" id="bus_country_code" <?php echo $bus_value_code;?>  />                    </td>
                    </tr>
                    <!--<tr>
                    	<td><?php echo LANGUAGE;?> <span style="color:red;">*</span></td>
                    	<td>
                        <select name="bus_language" id="bus_language" class="textbg_grey" style="width:205px; margin-left:5px;">
                            <option value="English" <?php if($busi_obj->f('busi_lang')=="English"){?> selected="selected"<?php } ?>><?php echo ENGL;?></option>
                            <option value="Spanish" <?php if($busi_obj->f('busi_lang')=="Spanish"){?> selected="selected"<?php } ?>><?php echo SPAL;?></option>
                        </select>
                    <input type="text" name="bus_language" id="bus_language"  /></td>
                    </tr>-->
                    <tr>
                    <td><input type="hidden" name="bus_language" id="bus_language"  /><?php echo STATE;?><span style="color:red; " id="star1">*</span></td>
                    <td>
                    <div id="div_bus_state_display">
                    <select name="bus_province" id="bus_province" class="selectbg12"  style="width:205px; margin-left:5px;">
                        <option value="">State</option>
                        <?php
						if($busi_obj->f('busi_country_id')=="")
							$cntry = $obj->f('country_id');
						else
							$cntry = $busi_obj->f('busi_country_id');
                          $obj_venuestate->getStateById($cntry);
                          while($row = $obj_venuestate->next_record())
                          {
                          ?>
                          <option value="<?php echo $obj_venuestate->f('id');?>" <?php if($busi_obj->f('busi_province')==$obj_venuestate->f('id')){?> selected="selected"<?php }?>>
                            <?php echo $obj_venuestate->f('state_name');?></option>
                            <?php
                          }
                          ?>
                    </select>
                    </div>
                    </td>
                    </tr>
                    <tr>
                    <td><?php echo COUNTY;?><span style="color:red;" id="star2">*</span></td>
                    <td>
                    <div id="div_county_display">
                        
                       <input type="text" name="bus_county" id="bus_county" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_county')?>" />   
                         
                     </div>
                    </td>
                    </tr>
                    <tr>
                    <td><?php echo CITY;?><span style="color:red;" id="star3">*</span></td>
                    <td>
                    <div id="div_city_display">
                   
                    <input type="text" name="bus_city" id="bus_city" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_city')?>" /> 
                    
                    </div>                    
                    </td>
                    </tr>
                    <tr>
                    <td><?php echo ADDRESS;?><span style="color:red;">*</span></td>
                    <td><textarea name="bus_address" id="bus_address" style="width:210px; padding: 4px; background: #f5f5f5; border: 1px solid #CCCCCC;margin-left: 6px;"><?php echo $busi_obj->f('busi_address')?></textarea></td>
                    </tr>
                    <tr>
                        <td><?php echo POSTAL_CODE;?><span style="color:red;">*</span></td>
                        <td><input type="text" name="bus_postal_code" id="bus_postal_code" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_postal_code')?>" /></td>
                    </tr>
                    <tr>
                    <td><strong><?php echo TAX_ID_NUM;?></strong><br /><?php  if($_SESSION['langSessId']=="eng"){?><span style="font-size:12px;"><?php echo USONLY;?></span><?php } ?></td>
                    <td><input type="text" name="tax_id_num" id="tax_id_num" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_tax_id_num')?>" /></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo ACTIVITY;?></strong><br /><span style="font-size:12px;"><?php echo CATA;?></span></td>
                        <td>
                        <div><input type="checkbox" name="act_event" id="act_event" value="1" <?php if($busi_obj->f('busi_acti_event_mgmt')==1) {?> checked="checked" <?php }?>  /> &nbsp;&nbsp; <?php echo EVENT_MANAGER;?></div>
                        <div><input type="checkbox" name="act_venue" id="act_venue" value="1" <?php if($busi_obj->f('busi_acti_venue_mgmt')==1) {?> checked="checked" <?php }?>  /> &nbsp;&nbsp; <?php echo VENUE_MANAGER;?></div>
                        <div><input type="checkbox" name="act_perform" id="act_perform" value="1" <?php if($busi_obj->f('busi_acti_performer')==1) {?> checked="checked" <?php }?>  /> &nbsp;&nbsp; <?php echo PERFORMER;?></div>
                        <div><input type="checkbox" name="act_provider" id="act_provider" value="1" <?php if($busi_obj->f('busi_acti_provider')==1) {?> checked="checked" <?php }?>  /> &nbsp;&nbsp; <?php echo PROVIDER;?></div>
                        <div><input type="checkbox" name="act_sponser" id="act_sponser" value="1" <?php if($busi_obj->f('busi_acti_sponsor')==1) {?> checked="checked" <?php }?>  /> &nbsp;&nbsp; <?php echo SPONSER;?></div>
                        </td>
                    </tr>
                    <tr>
                    <td><strong><?php echo WEBSITEURL;?></strong></td>
                    <td><input type="text" name="website" id="website" class="textbg_grey" style="width: 190px; margin-right: 6px;" value="<?php echo $busi_obj->f('busi_website')?>" onblur="isUrl()" /></td>
                    </tr>
                   <tr>
                    <td colspan="2"><!--<input type="checkbox" name="terms_condition" id="terms_condition" value="1" />--><?php echo TERMS_CONDITION;?></td>
                    </tr>
                    <tr>
                    
                    <td colspan="2" style="text-align:left; padding-left: 109px;"><input type="button" name="submit1" id="submit1" value="<?php echo NEXT;?>" style="cursor:pointer;" class="event_save" onclick="submitbut(1)" />
                    <span style="margin-left:10px;"><input type="button" name="submit1" id="submit1" value="<?php echo SAVE_EXIT;?>" style=" cursor:pointer;"  class="event_save"  onclick="submitbut(2)" /></span>

</td>
                    </tr>
                   </table></td>
                 </tr>
               </table> 
                              	
              </form>                    
            </div>
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
