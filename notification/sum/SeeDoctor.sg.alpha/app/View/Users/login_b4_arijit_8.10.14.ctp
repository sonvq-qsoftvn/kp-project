<script>
$(function() {
	$('#date_of_birth').datepick({maxDate: '2004-12-31', dateFormat: 'yyyy-mm-dd'});
	
});


</script>
<div id="fb-root"></div>
<div class="span6">
                    <div class="utopia-login">
                        <h1>SeeDoctor.sg User Access</h1>
                        <form action="<?php echo BASE_URL;?>logincheck" method="post" class="utopia">
                            <input type='hidden' name='token' value='<?php echo $user_login_token;?>'>
                            <label>Username:</label>
                            <input type="text" value="<?php echo $reid_user_username;?>" class="span12 utopia-fluid-input validate[required]" name='username' autocomplete="off">

                            <label>Password:</label>
                            <input type="password" class="span12 utopia-fluid-input validate[required]" value="<?php echo $reid_user_password;?>" name='password' autocomplete="off">

                            <ul class="utopia-login-action" style='list-style-type: none;'>
                                <li>
                                    <input type="submit" class="btn span4" value="Login" name='login_submit'>
                                    <div class="pull-right"><input type="checkbox" name='remember_me' value='on' <?php if($remember_me=='on'){?>checked='checked'<?php }?>> Remember me!</div>
                               
                                </li>
                            </ul>

                            
                        </form>
                    </div>
                </div>
 <div class="sign_facebook">
			    <?php echo  ucfirst(__d('index', 'sign_in_with', true));?>:
			    
			    
			    
			    <a href="javascript:myfunc('fblogin');" class='zocial facebook'>Sign in with facebook</a></div>
                        </div>
                        <script>
                        window.fbAsyncInit = function() {
                            
                            FB.init({
                            appId: '278048352382827', 

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
 function myfunc(type) {
                            FB.login(function(response) {

                            window.location.href = '<?php echo BASE_URL ;?>facebook_login';
                                    

                            }, {scope:'user_location,user_hometown,email,read_stream,publish_stream,user_birthday,offline_access,create_event,rsvp_event,friends_events'});
                            }
                            </script>
