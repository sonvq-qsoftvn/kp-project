                        <div class="user-panel header-divider">
                            <div class="user-info">
                                <?php
					echo $this->Html->image('../admin/img/icons/user.png',array('alt'=>''));
				?>
                                <a href="#">Admin user</a>
                            </div>

                            <div class="user-dropbox">
                                <ul>
                                    <!--
				    <li class="user"><a href="#">Profile</a></li>
                                    <li class="settings"><a href="#">Account Settings</a></li>
                                    <li class="theme-changer dark-theme"><a href="javascript:reload()" class="dark" rel="<?php echo BASE_URL.'app/webroot/admin/';?>css/themes/utopia-dark2e13.css?v18" >Dark theme</a></li>
                                    <li class="theme-changer white-theme"><a href="javascript:reload()" class="white" rel="<?php echo BASE_URL.'app/webroot/admin/';?>css/utopia-whitee5a5.css?v19" >White theme</a></li>
                                    <li class="theme-changer wooden-theme"><a href="javascript:reload()" class="wooden" rel="<?php echo BASE_URL.'app/webroot/admin/';?>css/themes/utopia-wooden.css" >Wooden theme</a></li>
                                    !-->
				    <li class="theme-changer wooden-theme"><a href="<?php echo BASE_URL;?>">View Site</a></li>
				    
				    <li class="settings"><a href="<?php echo BASE_URL.'administrator/';?>changepassword">Change Password</a></li>
				    <li class="logout"><a href="<?php echo BASE_URL.'administrator/';?>logout">Logout</a></li>
                                </ul>
                            </div>

                        </div><!-- User panel end -->