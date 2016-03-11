<div class="span6">
                    <div class="utopia-login">
                        <h1>SeeDoctor.sg Clinic Owner</h1>
                        <form action="<?php echo BASE_URL;?>clinicmanager/logincheck" method="post" class="utopia">
                            <input type='hidden' name='token' value='<?php echo $login_token;?>'>
                            <label>User Name:</label>
                            <input type="text" value="<?php echo $reid_clinicowners_username;?>" class="span12 utopia-fluid-input validate[required]" name='username' autocomplete="off">

                            <label>Password:</label>
                            <input type="password" class="span12 utopia-fluid-input validate[required]" value="<?php echo $reid_clinicowners_password;?>" name='password' autocomplete="off">

                            <ul class="utopia-login-action">
                                <li>
                                    <input type="submit" class="btn span4" value="Login" name='login_submit'>
                                    <div class="pull-right"><input type="checkbox" name='remember_me' value='on' <?php if($remember_me=='on'){?>checked='checked'<?php }?>> Remember me!</div>
                                </li>
                            </ul>

                            <label><a href="<?php echo BASE_URL.'clinicmanager/forgotpassword'?>">Forgot your password?</a></label>
                        </form>
                    </div>
                </div>
