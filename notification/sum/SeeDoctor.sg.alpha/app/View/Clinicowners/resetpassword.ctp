            <div class="span6">
                        
                        <div class="utopia-login">
                        <h1>SeeDoctor.sg Clinic Owner</h1>
                        <form action="<?php echo BASE_URL;?>clinicmanager/resetpassword/" method="post" class="utopia">
                            
                            
                                    
                            <div class="control-group">
                                <label class="control-label" for="email">Email-id*:</label>

                                <div class="controls">
                                    <input type='text' name='email' class='input-fluid' id='oldpass' />
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <label class="control-label" for="newpass">New Password*:</label>

                                <div class="controls">
                                    <input type='password' name='newpass' class='input-fluid' id='newpass' />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="connewpass">Confirm New Password*:</label>

                                <div class="controls">
                                    <input type='password' name='connewpass' class='input-fluid' id='connewpass' />
                                </div>
                            </div>
                            

                            
                            <ul class="utopia-login-action">
                                <li>
                                    <input type="submit" class="btn span4" value="Submit" name='login_submit'>
                                    
                                </li>
                            </ul>           
                            
                            
                        </form>
                        </div>
            </div>


<script>
            //form validation
            
            function do_validate()
            {
               
                        status=1;
                        op=document.getElementById('oldpass').value;
                         
                        np=document.getElementById('newpass').value;
                        cnp=document.getElementById('connewpass').value;
                       
                        var smallletter = /[a-z]/;
                        var capsletter=/[A-Z]/;
                        var number = /[0-9]/;
                        
                        var validop = number.test(op) && smallletter.test(op) && capsletter.test(op);
                        var validnp = number.test(np) && smallletter.test(np) && capsletter.test(np);
                        
                        if (op=='')
                        {
                                    alert('Please enter old password');
                                    document.getElementById('oldpass').focus();
                                    status=0;
                        }
                        else if (!validop)
                        {
                                    alert('Old password must have atleast one number,one uppercase and one lower case letter');
                                    document.getElementById('oldpass').focus();
                                    status=0;
                        }
                        else if (op.length<8)
                        {
                            alert('Old password must be atleast 8 characters long');
                            document.getElementById('oldpass').focus();
                            status=0;
                        }
                        else if (np=='')
                        {
                                    alert('Please enter new password');
                                    document.getElementById('newpass').focus();
                                    status=0;
                        }
                        else if (!validnp)
                        {
                                    alert('New password must have atleast one number,one uppercase and one lower case letter');
                                    document.getElementById('newpass').focus();
                                    status=0;
                        }
                        else if (np.length<8)
                        {
                            alert('New password must be atleast 8 characters long');
                            document.getElementById('newpass').focus();
                            status=0;
                        }
                        else if (np!=cnp)
                        {
                            alert('Confirm password doesnot match with new password');
                             document.getElementById('connewpass').focus();
                            status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
                
                        
            }
</script>