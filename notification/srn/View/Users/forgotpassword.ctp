<script>
	$(document).ready(function(){
		//---------------------------------form validation for user-----------------------------------------//
		
		$('#user_register_btn').click(function(){	
			$("#user_forgot_pass_form").validate({
				rules: {
						email: {
                                        required: true,
                                        email: true
                                   }
					},
					messages: {
						email: "Please enter your email id"
					},
					submitHandler: function(form) {
					form.submit();
				}
			});
		});  
 
          $('#user_passw_btn').click(function(){	
               $("#user_pass_form").validate({
				rules: {
						password: {
									required: true,
									minlength: 8
								},
						re_password:{ required: true}
					},
					messages: {
						password: {
							required: "Please provide a password",
							minlength: "Your password must be at least 8 characters long"
						},
						re_password: {
							required: "Please provide password again."
							//equalTo: "Both passwords must be same."
						}
					},
					submitHandler: function(form) {
                              var pass=$('#password1').val();
                              var cpass= $('#re_password').val();
                              var error=0
                              //alert(pass+' '+cpass);
                              if (pass != cpass) {
                                   $('#re_password-error').html('Both password must be same');
                                   $('#re_password-error').show();
                                   error =1; 
                              }
                              else{
                                   error =0;
                              }
                              
                              if (error==0) {
                                   form.submit();
                              }
                         }
			});
          });
          
		//---------------------------------END form validation for user-----------------------------------------
	});
</script>


	<section class="emai-registration">
		<!--<div class="topheading-box"><div class="container"><h2>User Profile</h2></div></div>-->
		<div class="container">
			<div class="inner-gapbox-1">
                    <?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
                    
                    <?php
                         if($page_show_type == 1 && $page_show_type1 == 0)
                         {
                    ?>
                              <div class="heading-box">
                                   <div class="regi-heading">
                                        <span class="email2"><?php echo $this->Html->image('../frontend/images/password.png',array('alt'=>'')); ?></span>
                                        Forgot Password
                                   </div>
                                   <div class="clearfix"></div>
                              </div>
                         
                              <div class="rgeistration-wrapp">
                                   <div id="user_form">
                                        <form name='user_forgot_pass_form' id='user_forgot_pass_form' action='<?php echo BASE_URL;?>forgotpassword' method='post' enctype='multipart/form-data' >
                                             <input type="hidden" name="page_type" id="page_type" value="<?php echo (isset($page_show_type))?$page_show_type:'1'; ?>" />
                                             
                                             <div class="form-row">
                                                  <div class="col-md-4"><input type="text" name="email" placeholder="Email" value="" class="user-in"></div>
                                             </div>
                                             <div class="clearfix"></div>
                                             <div class="button-wrapp">
                                                  <div class="butt-reg"><button class="regisyer-butt" id="user_register_btn"  >Validate</button></div>
                                                  <div class="clearfix"></div>
                                             </div>
                                             <div class="clearfix"></div>
                                        </form>
                                   </div>
                              </div>
                    <?php
                         }
                         elseif($page_show_type == 2 && $page_show_type1 == 0)
                         {
                    ?>
                              <div class="heading-box">
                                   <div class="regi-heading">
                                        <span class="email2"><?php echo $this->Html->image('../frontend/images/password.png',array('alt'=>'')); ?></span>
                                        Change Password
                                   </div>
                                   <div class="clearfix"></div>
                              </div>
                    
                              <div class="rgeistration-wrapp">
                                   <div id="user_form">
                                        <form name='user_pass_form' id='user_pass_form' action='<?php echo BASE_URL;?>forgotpassword' method='post' enctype='multipart/form-data' >
                                             <input type="hidden" name="id" id="id" value="<?php echo (isset($user_id))?$user_id:''; ?>" />
                                             <input type="hidden" name="user_type" id="user_type" value="<?php echo (isset($user_type))?$user_type:''; ?>" />
                                             <input type="hidden" name="page_type" id="page_type" value="<?php echo (isset($page_show_type))?$page_show_type:'1'; ?>" />
                                             
                                             <div class="form-row">
                                                  <div class="col-md-4"><input type="password" name="password" id="password1" placeholder="Password" value="" class="user-in" /></div>
                                             </div>
                                             <div class="form-row">
                                                  <div class="col-md-4">
                                                       <input type="password" name="re_password" id="re_password" value="" placeholder="Re-Enter Password" class="user-in" />
                                                       <label id="re_password-error" class="error"></label>
                                                  </div>
                                             </div>
                                             <div class="clearfix"></div>
                                             <div class="button-wrapp">
                                                  <div class="butt-reg"><button class="regisyer-butt" id="user_passw_btn">Change Password</button></div>
                                                  <div class="clearfix"></div>
                                             </div>
                                             <div class="clearfix"></div>
                                        </form>
                                   </div>
                              </div>
                    <?php
                         }
                    ?>
			</div>
	    </div>
	</section>
