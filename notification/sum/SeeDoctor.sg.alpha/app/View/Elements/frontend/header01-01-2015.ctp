<script>
												window.fbAsyncInit = function() {
													FB.init({
															appId: '<?php echo isset($facebook_app_id)?$facebook_app_id:''; ?>', 
															cookie: true,
															xfbml: true,
															oauth: true
														});
												};
												
												(function() {
													var e = document.createElement('script');
													e.async = true;
													e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';
													document.getElementById('fb-root').appendChild(e);
												}());
												
												function myfunc(type)
												{
													FB.login(function(response) {
														window.location.href = '<?php echo BASE_URL ;?>facebook_login';
													}, {scope:'email'});
												}
											</script>




<?php
//print_r($like_notification);
//print_r($clinic_approved_notification);
//pr(isset($post_notification));
//echo count($post_notification);
//echo count($message_notification);
//echo "w=".count($message_notification);
//echo count($like_notification);
$total_notification=0;
if(!empty($like_notification) || !empty($clinic_approved_notification) || !empty($post_notification) || !empty($reply_post_notification) || !empty($message_notification))
	{

	$total_notification = count($like_notification)+count($clinic_approved_notification)+count($post_notification)+count($reply_post_notification)+count($message_notification);
	}
	//echo "po= ".$total_notification;
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $SITENAME; ?></title>
	<meta name="title" content="<?php echo $METATITLE; ?>">
	<meta name="description" content="<?php echo $METADATA; ?>">
	<?php echo $this->Element('frontend/link_styles_and_js'); ?>
</head>
	
	<body>
		<header>
			<section class="topheader">
				<div class="container">
					<div class="row login-main">
						<div class="logg">
							<ul>
								<?php
									if($this->Session->read('reid_user_uid')>0)
									{
								?>
										<li><a href="<?php echo BASE_URL;?>messages/MessageInbox"><?php echo $this->Html->image('../frontend/images/icon45.jpg',array('alt'=>'logo image')); ?> Inbox <?php if($unread_messages){?>(<?php echo $unread_messages;?>)<?php }else{?>&nbsp;&nbsp;&nbsp;&nbsp;<?php }?></a></li>
							
							<li><a href="javascript:ShowDiv('<?php echo $this->Session->read('reid_user_uid');?>')"><?php echo $this->Html->image('../frontend/images/icon45.jpg',array('alt'=>'logo image')); ?> Notifications (<?php echo $total_notification;?>)</a>
							
							<div class="noti">
	<div id="slimtest1"><?php
	
	if(!empty($like_notification_details))
	{
		foreach($like_notification_details as $likeValNoti)
		{
		?>
		<p><a href="<?php echo BASE_URL.'clinics/clincwall/'.$likeValNoti['Clinic']['id']; ?>"><?php echo $likeValNoti['User']['username'];?> like your <?php  echo $likeValNoti['Clinic']['name'];?> clinic. </a></p>
		<?php
		}
	}
	?>
	<?php
	if(!empty($clinic_approved_notification_details))
	{
		foreach($clinic_approved_notification_details as $clinicApprovedVal)
		{
		?>
		<p><a href="<?php echo BASE_URL.'clinics/clincwall/'.$clinicApprovedVal['Clinic']['id']; ?>"> Your clinic <?php echo $clinicApprovedVal['Clinic']['name'];?> has been approved and is now Live. </a></p>
		<?php
		} 
	}
	if(!empty($post_notification_details))
	{
		foreach($post_notification_details as $postnotiVal)
		{
		?>
		
		<p><a href="<?php echo BASE_URL.'clinics/clincwall/'.$postnotiVal['Clinic']['id']; ?>"><?php echo $postnotiVal['User']['username'];?> has posted on your clinic <?php echo $postnotiVal['Clinic']['name'];?> wall page on <?php echo date("d-m-Y h:i:s A",strtotime($postnotiVal['Wallpost']['post_create_time'])) ;?> </a></p>
		<?php
		} 	
	}
	if(!empty($reply_post_notification_details))
	{
		foreach($reply_post_notification_details as $replypostnotiVal)
		{
		?>
		
		<p><a href="<?php echo BASE_URL.'clinics/clincwall/'.$replypostnotiVal['Comment']['clinic_id'].'/'.$replypostnotiVal['Comment']['id']; ?>"> You have received a reply on your post <?php echo $replypostnotiVal['Wallpost']['post_title'];?> from <?php echo $replypostnotiVal['User']['username'];?> </a></p>
		<?php
		} 	
	}
	if(!empty($message_notification_details))
	{
		foreach($message_notification_details as $messagenotiVal)
		{
			/*user type checking*/
			if($messagenotiVal['Messagecontent']['fromtype'] == 'superadmin')
			{
				$allUser = $messagenotiVal[0]['Admin']['username'];
				$url_user = 'superadmin';
			}
			else
			{
				$allUser = $messagenotiVal[0]['User']['username'];
				if($messagenotiVal[0]['User']['user_type']==1)
				{
					$url_user = 'user';	
				}
				else
				{
					$url_user = 'Clinicmanager';
				}
			}
		?>
		
		<p><a href="<?php echo BASE_URL.'messages/conversation/'.$messagenotiVal['Messagecontent']['fromid'].'/'.$url_user.'/'.$messagenotiVal['Message']['id'];?>/thismsg"> You have received a private message from <?php echo $allUser.' '.$messagenotiVal['Messagecontent']['subject'].' on '.date("d-m-Y h:i:s A",strtotime($messagenotiVal['Messagecontent']['datesent']));?> </a></p>
		<?php
		}
		
	}
	?></div>
</div>
							
							
							</li>
										
		<li><a href="<?php echo BASE_URL.'users/userprofile';?>"><?php echo $this->Html->image('../frontend/images/icon47.jpg',array('alt'=>'logo image')); ?> <?php echo $logged_user_name; ?></a></li>
			
								<?php		
										echo '<li>'.$this->Html->link('My Account', array('controller' => 'users', 'action' => 'userprofile')).'</li>';
										echo '<li>'.$this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'last')).'</li>';
									}
									else
									{
										echo '<li><a href="javascript:void(0)" id="log">Login </a></li>';
										echo '<li>'.$this->Html->link('Register For Free', array('controller' => 'register'), array('class' => 'last')).'</li>';
									}
								?>
							</ul>
						</div>
						<div class="login">
							<div class="login_form_close"><img src="<?php echo BASE_URL;?>/frontend/images/close.png" alt="" title="Close"></div>
							<div class="loginform">
								<h2>Login</h2>
								<?php echo $this->Form->create('User', array('name'=>'login_form', 'id'=>'login_form', 'action' => 'logincheck')); ?>
									<div class="login_field">
										<?php
											echo $this->Session->flash('login_error'); //Showing the error/success message
										
											echo $this->Form->input('', array('name' => 'token', 'id' => 'token', 'value' => ($this->Session->read('user_login_token'))?$this->Session->read('user_login_token'):0, 'type' => 'hidden'));
											echo $this->Form->input('', array('name' => 'is_email', 'id' => 'is_email', 'value' => 0, 'type' => 'hidden'));
											echo $this->Form->input('', array('name' => 'username', 'id' => 'username', 'required' => 'true', 'type' => 'text', 'class' => 'user-in', 'placeholder' => 'Email / Username :', 'value' => (isset($reid_user_username))?$reid_user_username:'', 'onblur'=>"check_type(this.val);"));
											echo $this->Form->input('', array('name' => 'password', 'id' => 'password', 'required' => 'true', 'type' => 'password', 'class' => 'user-in', 'placeholder' => 'Password :' , 'value' => (isset($reid_user_password))?$reid_user_password:''));
										?>
									</div>
									<div class="login_link">
										<?php echo $this->Html->link('Forgot Password', array('controller' => 'users', 'action' => 'forgotpassword')); ?>
										|
										<?php echo $this->Html->link('Signup Now!', array('controller' => 'register')); ?>
									</div>
									<div class="login_remember_me">
										<?php echo $this->Form->input('Remember Me', array('name' => 'remember_me', 'id' => 'remember_me', 'type' => 'checkbox', 'value' => (isset($remember_me) && $remember_me == 'on')?$remember_me:1, 'checked' => (isset($remember_me))?'true':'', 'div'=>array('class'=>'new_checkbox'))); ?>
									</div>
									<div class="login_button">
										<div class="butt-log"><button class="login-butt" id="user_login">Login</button></div>
										<div class="or">OR</div>
										<div id="fb-root"></div>
										<div class="fb-in">
											<a href="javascript:myfunc('fblogin');" class='zocial facebook'>
												<img src="<?php echo BASE_URL;?>/frontend/images/facebook-in.png" />
											</a>
											<!--<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>-->
											
											
										</div>
									</div>
								<?php  echo $this->Form->end();?>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="clearfix"></div>
			
<!------DIV SHOW HIDE----------->
<style>
.noti
{
	display: none;
}
</style>

<script>
function ShowDiv(id)
{
	
	//alert("hh");
	$.ajax({
		url:'<?php echo BASE_URL ?>clinics/notificationlike',
		type:'post',
		data: 'client_id='+id,
		success:function(data1)
		{
			//alert(data1);
		//window.location.reload(true); 
                }
	});
	$('.noti').slideToggle();
}
jQuery(document).ready(function(){
$(function(){
    $('#slimtest1').slimScroll({
        height: '250px'
    });
});
});
</script>
