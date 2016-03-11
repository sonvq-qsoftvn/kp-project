//payment success page
<?php
//payment success page
include('include/user_inc.php');

//create object
$obj_setting=new user;
$obj_edit=new user;
$obj=new user;
$obj_user=new user;
$obj_mail=new user;
$obj_res_acc=new user;

//setting detail
$obj_setting->admin_setting();
$obj_setting->next_record();

$order_number="123456";
$event_name="Festival de Cine de Todos Santos";
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Completed</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<?php include("include/analyticstracking.php")?> <!-----for google analytics--------->
</head>
<body>

<!--header-->
<?php require("include/secondary_header.php");?>
<?php require("include/menu_header.php");?>
<!--header-->

<div id="maindiv">
	<div class="clear"></div>
	<div class="body_bg">
   		<div class="clear"></div>
    	<div class="container">
<!--            <div class="blue_box1" style="width: 976px;"><div class="blue_boxh"><p>Success</p></div> -->
            <div class="blue_box1" ><div class="blue_boxh"><p>Order Completed</p></div></div>
<!--        	<div class="left_panel bg" style="width:978px;"> -->
        	<div class="left_panel bg">
            <div class="clear"></div>
            <div class="clear"></div>

<?php
	echo "<pre>"; 
	//var_dump(get_defined_vars());
	print_r(get_defined_vars()); 
	echo "</pre><br>";
?>
<?php	
	if($_SESSION['langSessId'] == 'eng') 
	{
		echo "<strong>Thank you for your order</strong><br>";
		echo "your order number is: " .$order_number. "<br>";
		Echo "You will receive shortly an email confirmation with a form to select the functions you wish to attend. Please fill out this form and email it back to us.<br>";
		Echo "If you do not receive the confirmation email within 5 minutes please check your Spam or Junk folders to ensure safe delivery.<br>";
		echo "If you think that there has been a problem with delivery of the email please contact us at info@kpasapp.com<br>";
		echo "We look forward to seeing you at " .$event_name."<br>";
	}
	else
	{
		echo "Gracias por su pedido.<br>";
		echo "Su referencia es: " .$order_number. "<br>";
		echo "En breve recibirás un email de confirmación con un formulario para seleccionar las funciones que desea asistir.<br>";
		echo "Por favor, rellene este formulario y enviarlo por correo electrónico de nuevo a nosotros tan pronto como sea posible para garantizar asientos.<br>";
		echo "Si usted no recibe el correo electrónico de confirmación dentro de los 5 minutos, por favor revise su carpeta de spam o basura para garantizar la entrega segura.<br>";
		echo "Si usted cree que ha habido un problema con la entrega del correo electrónico, por favor contacte con nosotros en info@kpasapp.com <br>";
		echo "Esperamos verle en " .$event_name. "<br>";
	}
?>	
					   
		</div>
	    </div>
	</div>
    </div>
</div>
</body>
</html>

