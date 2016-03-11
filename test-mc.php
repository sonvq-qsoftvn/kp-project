<?php
include('include/user_inc.php');
$venue_id = $_REQUEST['venue_id'];

//create object

$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;


// Venue Details
$obj_venue->venue_details_venueid($venue_id);
$obj_venue->next_record();


//print_r($_SESSION);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venue</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>




<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="http://kpasapp.us8.list-manage.com/subscribe/post?u=130e6654487fe713844d189db&amp;id=e429b6d314" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
	<label for="mce-EMAIL">Subscribe to our mailing list</label>
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_130e6654487fe713844d189db_e429b6d314" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
</form>
</div>




<script language="javascript" type="text/javascript">

$('#checkAll').click(function () {   
    alert("hi!");
     $('input:checkbox').prop('checked', this.checked);    
 });
</script>
</head>
<body>
<input type="checkbox" id="checkAll" > Check All
    <hr />
    <input type="checkbox" id="checkItem"> Item 1
    <input type="checkbox" id="checkItem"> Item 2 
    <input type="checkbox" id="checkItem"> Item3
    
    </body>
</html>