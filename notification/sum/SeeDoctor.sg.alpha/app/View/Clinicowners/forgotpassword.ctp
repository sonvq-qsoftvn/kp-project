

<div class="span6">
                    <div class="utopia-login">
                        <h1>SeeDoctor.sg Clinic Owner</h1>
                        <form action="<?php echo BASE_URL;?>clinicmanager/forgotpassword" method="post" class="utopia" id="utopia">
                            
                            <label>User Name:</label>
                            <input type="text" value="" class="span12 utopia-fluid-input validate[required,custom[onlyLetterNumber]]" name='username' id="username" autocomplete="off">

                            <label>Email-id:</label>
                            <input type="text" class="span12 utopia-fluid-input validate[required,custom[email] ]" value="" name='email' id="email" autocomplete="off">
                             <ul class="utopia-login-action">
                                <li>
                                    <input type="submit" class="btn span4" value="Submit" name='login_submit'">
                                    
                                </li>
                            </ul>           
                            
                            
                         </form>
                    </div>
                </div>
