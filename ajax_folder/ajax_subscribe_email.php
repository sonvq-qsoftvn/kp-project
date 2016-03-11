<?php
session_start();
//ajax event price level
include("../class/db_mysql.inc");
include("../class/user_class.php");
include("../class/pagination.class.php");
include("../class/class.phpmailer.php");
$obj_base_path = new DB_Sql;

$obj_email_check = new user;
//$obj_add_altemail = new user;
//$obj_getDtls = new user;
//$obj_sendmail = new user;
//$obj_del_altemail = new user;
//$obj_save = new user;

$email = $_POST['email'];
$lang = $_POST['lang'];
//echo $lang;
if($email=="")
{
	if($_SESSION['langSessId']=="eng"){echo "Please provide email id";}elseif($_SESSION['langSessId']=="spn"){ echo "Proporcione correo electrónico de identificación";}
}
else
{
$obj_email_check->GetThisEmail($email);
$obj_email_check->next_record();

//=================================================//.
if($obj_email_check->num_rows()==0)
 {
   $new_id=$obj_email_check->save_subscribe_email($email,$lang);
   if($new_id>0)
    {
	if($_SESSION['langSessId']=="eng"){echo "Thank you for your subscription";}elseif($_SESSION['langSessId']=="spn"){ echo "Gracias por su suscripción";}
	?>
	<script type="text/javascript">
	$("#mc-embedded-subscribe-form").submit();
	//window.location.href = '<?php echo $obj_base_path->base_path(); ?>';
	</script>
	<?php
    }
 }
else if($obj_email_check->num_rows()>0)
 {
	if($_SESSION['langSessId']=="eng"){echo "You are already subscribed";}elseif($_SESSION['langSessId']=="spn"){ echo "Usted ya está suscrito";} 
 }
//=================================================//
}

?>		
  
		  
