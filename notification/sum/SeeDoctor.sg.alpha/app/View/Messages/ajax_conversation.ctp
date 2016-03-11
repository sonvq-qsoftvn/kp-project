<!------For Send Message End----->
			
		<!------For Messages Show Start----->
                
               
		<?php
                
                
		if(count($all_messages))
		{
			//$to_user_details['username']='admin';
                       /// $logged_user_details['username']='admin';
		
		foreach($all_messages as $value)
		{
		
			if($value['User']['id']==$to_user_details['id']  && $value['User']['user_type']==$to_user_details['user_type'] )
			{
				
		?>
                <div id='message_content'>  
			<div class="msg_list_out">
				<div class="right" style='border-radius:0% 0% 0% 0%'>
					<?php
						if(isset($to_user_details['profile_image']) && $to_user_details['profile_image']!='' && (file_exists("frontend/uploads/profile_image/".$to_user_details['profile_image'])))
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/uploads/profile_image/thumbimage/<?php echo $to_user_details['profile_image'] ?>">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/images/no-avatar.jpg">
						<?php
						}
						?>
						<h4><?php echo $to_user_details['username'];?></h4>
						<!--<img src="images/pic9.jpg" />--></div>
				<div class="middleown"  <?php if($m_id==$value['Message']['id']){ ?>style="box-shadow: 0 0 5px #000;"<?php }?> id="middle_<?php echo $value['Message']['id'];?>">
				<div class="add_msg"><?php //echo $this->Html->image('../frontend/images/icon31.jpg',array('alt'=>'')); ?></div>
				<h4 style='color:tomato;'><?php echo $value['Messagecontent']['subject'];?></h4>
				<p><?php echo $value['Messagecontent']['message'];?></p>
				</div>
				<div class="days_ago">
				<?php $ret_str=($this->Functions->calculate_time_gap(date('Y-m-d H:i:s'),$value['Messagecontent']['datesent']));if($ret_str['Y']!=0||$ret_str['M']!=0){echo "Nearly ";} if($ret_str['Y']!=0){ echo $ret_str['Y'].' Year'; if($ret_str['Y']>1){echo 's';}}if($ret_str['M']!=0){ echo ' '.$ret_str['M'].' Month'; if($ret_str['M']>1){echo 's';}}if($ret_str['d']!=0){ echo ' '.$ret_str['d'].' Day'; if($ret_str['d']>1){echo 's ';}}if($ret_str['h']!=0){ echo ' '.$ret_str['h'].' Hour'; if($ret_str['h']>1){echo 's ';}}if($ret_str['m']!=0){ echo ' '.$ret_str['m'].' Minute'; if($ret_str['m']>1){echo 's ';}}if($ret_str['Y']!=0||$ret_str['M']!=0||$ret_str['d']!=0||$ret_str['h']!=0||$ret_str['m']!=0){echo ' ago ';}else{echo 'Just Now';}?>
				</div>
			</div>
              
		<?php
			}
			else
			{
			
		?>
			
			<div class="msg_list_in">
				<div class="left" style='border-radius:0% 0% 0% 0%'>
					<?php
						if($value['User']['profile_image']!='' && (file_exists("frontend/uploads/profile_image/".$value['User']['profile_image'])))
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/uploads/profile_image/thumbimage/<?php echo $value['User']['profile_image'] ?>">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo $this->webroot; ?>frontend/images/no-avatar.jpg">
						<?php
						}
						?>
						<h4><?php echo $logged_user_details['User']['username'];?></h4>
						<!--<img src="images/pic8.jpg" />--></div>
                            <div class="middle" <?php if($m_id==$value['Message']['id']){ ?>style="box-shadow: 0 0 7px #000;"<?php }?>  id="middle_<?php echo $value['Message']['id'];?>">
				<div class="add_msg"><?php //echo $this->Html->image('../frontend/images/icon31.jpg',array('alt'=>'')); ?></div>
				<h4 style='color:tomato;'><?php echo $value['Messagecontent']['subject'];?></h4>
				<p><?php echo $value['Messagecontent']['message'];?></p>
				
				</div>
				<div class="days_ago">
				<?php $ret_str=($this->Functions->calculate_time_gap(date('Y-m-d H:i:s'),$value['Messagecontent']['datesent']));if($ret_str['Y']!=0||$ret_str['M']!=0){echo "Nearly ";} if($ret_str['Y']!=0){ echo $ret_str['Y'].' Year'; if($ret_str['Y']>1){echo 's';}}if($ret_str['M']!=0){ echo ' '.$ret_str['M'].' Month'; if($ret_str['M']>1){echo 's';}}if($ret_str['d']!=0){ echo ' '.$ret_str['d'].' Day'; if($ret_str['d']>1){echo 's ';}}if($ret_str['h']!=0){ echo ' '.$ret_str['h'].' Hour'; if($ret_str['h']>1){echo 's ';}}if($ret_str['m']!=0){ echo ' '.$ret_str['m'].' Minute'; if($ret_str['m']>1){echo 's ';}}if($ret_str['Y']!=0||$ret_str['M']!=0||$ret_str['d']!=0||$ret_str['h']!=0||$ret_str['m']!=0){echo ' ago ';}else{echo 'Just Now';}?>
				</div>
			</div>
                    
		  </div>	
			
		<?php
			}
		}
		}
		?>