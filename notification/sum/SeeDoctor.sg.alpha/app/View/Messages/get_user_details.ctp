<?php if(isset($to_dta_all[0]['User']['id']))
{
    ?>
    <div class="col-xs-12 col-sm-12 col-md-4 msg_composer_main">
                	<div class="msg_composer">
					<div class="left">
						
						<?php
						if($to_dta_all[0]['User']['profile_image']!='' && (file_exists("frontend/uploads/profile_image/".$to_dta_all[0]['User']['profile_image'])))
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/uploads/profile_image/thumbimage/<?php echo $to_dta_all[0]['User']['profile_image'] ?>">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/images/no-avatar.jpg">
						<?php
						}
						?>
					</div>
			
                        <div class="right">
                    		<h2><?php if(isset($to_dta_all[0]['User']['username'])) {echo $to_dta_all[0]['User']['username'];}?></h2>
				<p><?php if($to_dta_all[0]['User']['user_type']==2){echo "Clinic Manager";}
				elseif($to_dta_all[0]['User']['user_type']==1){echo "User";}?></p>
                        </div>
			
                    </div>
                </div>
    <?php }
    else{
        ?>
        <div class="col-xs-12 col-sm-12 col-md-4 msg_composer_main">
                	<div class="msg_composer">
					<div class="left">
						
						<?php
						if(isset($to_dta_all[0]['Admin']['profile_image']) && (file_exists("frontend/uploads/profile_image/".$to_dta_all[0]['Admin']['profile_image'])))
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/uploads/profile_image/thumbimage/<?php echo $to_dta_all[0]['Admin']['profile_image'] ?>">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/images/no-avatar.jpg">
						<?php
						}
						?>
					</div>
			
                        <div class="right">
                    		<h2><?php if(isset($to_dta_all[0]['Admin']['username'])) {echo $to_dta_all[0]['Admin']['username'];}?></h2>
				<p><?php echo "Superadmin"; ?></p>
                        </div>
			
                    </div>
                </div>
        
        <?php } ?>