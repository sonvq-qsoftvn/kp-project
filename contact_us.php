<?php
include('include/user_inc.php');

$lang = $_REQUEST['lang'];

$objintro = new user;
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($lang == "en") {
    $social_lang = "en_US";
} else {
    $social_lang = "es_ES";
}

if($_SESSION['langSessId']=='eng') {
	$_SESSION['set_lang_terms'] = 'en';
} else {
	$_SESSION['set_lang_terms'] = 'es';
}

$correctURL = $obj_base_path->base_path()."/es/contactenos/";

if($_REQUEST['lang']=="")
{	
	if($_SESSION['langSessId']=='eng') {
		$correctURL = $obj_base_path->base_path()."/en/contact-us/";
		header("location: " . $correctURL);
		exit;
	} else{
		$correctURL = $obj_base_path->base_path()."/es/contactenos/";
		header("location: " . $correctURL);
		exit;
	}
	
} else if($_REQUEST['lang']!="" && $_REQUEST['lang']!=$_SESSION['set_lang_terms']) {
	if($_SESSION['langSessId']=='eng') {
        $_SESSION['set_lang_terms'] = 'en';
		$correctURL = $obj_base_path->base_path()."/en/contact-us/";
		header("location: " . $correctURL);
		exit;
	} else{ 
        $_SESSION['set_lang_terms'] = 'es';
		$correctURL = $obj_base_path->base_path()."/es/contactenos/";
		header("location: " . $correctURL);
		exit;
	}	
}


if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_REQUEST['contact_submit']))) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

	if (empty($first_name) || empty($last_name) || empty($email) || empty($message)) {     
		$msg = "Please fill in mandatory fields";
		$_SESSION['msg_type'] = 'error';
        $_SESSION['msg'] = $msg;
	} else if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format";
		$_SESSION['msg_type'] = 'error';
        $_SESSION['msg'] = $msg;
    } else {
        $objectContactPdo = new pdoDatabase();
	
        $result = $objectContactPdo->insertContactForm($first_name, $last_name, $email, $message);

        if ($result) {
            header("location:" . $correctURL);
            $msg = "Contact form successfully sent.";
            $_SESSION['msg_type'] = 'success';
            $_SESSION['msg'] = $msg;
            exit();
        } else {
            header("location:" . $correctURL);
            $msg = "An error occurs, please try again later!";
            $_SESSION['msg_type'] = 'error';
            $_SESSION['msg'] = $msg;
            exit();
        }
    }	    
}

/* ----------------------------------------------------------------------- */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta itemscope itemtype="http://schema.org/Article" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
            <?= CONTACT_US_TITLE ?>
        </title>
        <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

        <link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
        <?php include("include/analyticstracking.php") ?> <!-----for google analytics--------->
    </head>

    <body>

        <?php include("include/secondary_header.php"); ?>
        <?php include("include/menu_header.php"); ?>

        <style>
            .blue_boxr .previewbtn, .blue_boxr .nextbtn {
                width: 20%;
                font-size:  14px;
                color: #fff;
            }
            .blue_boxr .previewbtn {
                float:  left;
                text-align: left;
                margin: 20px 0 0 0;
            }
            .blue_boxr .nextbtn {
                width: 16%;
                float:  right;
                text-align: right;
                margin: 20px 0 0 0;
            }
            .blue_boxr .previewbtn a, .blue_boxr .nextbtn a{
                font-size:  14px;
                line-height: 20px;
                color: #fff;
                font-weight: bold;
                text-decoration: none;
                cursor: pointer;
                margin: 0;
                padding: 0;
                display: block;
            }
            .blue_boxr .content_info {
                width: 54%;
                margin: 11px 0 0 1%;
                float:  left;
                font-size:  14px;
                color: #fff;
                font-weight: bold;
            }
            #contact_form {
                margin-top: 15px;
                margin-bottom: 15px;
            }
            #contact_form .form-row {
                margin-bottom: 10px;
            }
            #contact_form .form-row label {
                width: 20%;
                display: inline-block;
            }
            #contact_form input, #contact_form textarea {
                padding: 5px;
                box-sizing: border-box;
                width: 50%;
            }
            #contact_form #contact_submit {
                background: url(../images/bgbtn.gif) repeat-x scroll center bottom #23446D;
                border: 0 none;
                color: #FFFFFF;
                cursor: pointer;
                display: inline-block;
                font: bold 14px/24px Arial,Helvetica,sans-serif;
                height: 24px;
                margin-bottom: 30px;
                margin-top: 10px;
                margin-left: 20%;
                outline: medium none;
                padding: 0 10px;
                text-align: center;
                width: auto;
            }
			.cheese_box .Tchai_box .message_success {
				color: green;
				font-weight: bold;
			}
			.cheese_box .Tchai_box .message_error {
				color: red;
				font-weight: bold;
			}
            .contact-form-page .blue_box1 {
                width: 100% !important;
            }
        </style>

        <div id="maindiv" class="contact-form-page">	
            <div class="clear"></div>
            <div class="body_bg">    	
                <div class="clear"></div>
                <div class="container">
                    <div class="left_panel bg" >
                        <div class="cheese_box">
                            <div class="blue_box1">
                                <div class="blue_boxh">
                                    <p>
                                        <?= CONTACT_US_TITLE ?>
                                    </p>
                                </div>		  
                            </div>
                            <div class="clear"></div>
                            <div class="Tchai_box" style="width: auto;"> 
								<?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) : ?>
									<p class="message_<?php echo $_SESSION['msg_type']; ?>">
										<?php echo $_SESSION['msg']; ?>
									</p>
                                    <?php 
                                        $_SESSION['msg_type'] = '';
                                        $_SESSION['msg'] = '';
                                    ?>
								<?php endif; ?>
                                <form action="" method="POST" id="contact_form">
                                    <div class="form-row">
                                        <label>
                                            <?= FORM_FRIST_NAME ?>    
                                        </label>
                                        <input type="text" value="<?php if(isset($_POST['first_name'])){echo $_POST['first_name'];} ?>" required="true" name="first_name" placeholder="<?= FORM_FRIST_NAME ?>" />
                                    </div>
                                    <div class="form-row">
                                        <label>
                                            <?= FORM_LAST_NAME ?> 
                                        </label>
                                        <input type="text" value="<?php if(isset($_POST['last_name'])){echo $_POST['last_name'];} ?>" required="true" name="last_name" placeholder="<?= FORM_LAST_NAME ?>" />                                
                                    </div>
                                    <div class="form-row">
                                        <label>
                                            <?= FORM_EMAIL ?> 
                                        </label>
                                        <input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" required="true" name="email" placeholder="<?= FORM_EMAIL ?>" />                                
                                    </div>
                                    <div class="form-row">
                                        <label>
                                            <?= FORM_MESSAGE ?> 
                                        </label>
                                        <textarea placeholder="<?= FORM_MESSAGE ?>" rows="4" name="message" required="true"><?php if(isset($_POST['message'])){echo $_POST['message'];} ?></textarea>
                                    </div>
                                    <div class="form-row">
                                        <button type="submit" name="contact_submit" id="contact_submit"><?= FORM_SEND ?></button>
                                    </div>
                                </form>
                            </div>		 
                        </div>
                        <div class="clear"></div>
                        <?php require(__DIR__ . '/include/selection_button_social.php'); ?>

                    </div>
                    <?php include("include/frontend_rightsidebar.php"); ?>
                    <div class="clear"></div>                
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <?php include("include/frontend_footer.php"); ?>
    </body>
</html>
