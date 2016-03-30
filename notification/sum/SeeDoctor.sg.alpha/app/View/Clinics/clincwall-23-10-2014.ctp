<?php
	/* 
	 * To change this license header, choose License Headers in Project Properties.
	 * To change this template file, choose Tools | Templates
	 * and open the template in the editor.
	 */
?>


	<script type="text/javascript">
		function unlike(id)
		{
			$.ajax({
				url:'<?php echo BASE_URL ?>clinics/ajx_unlike',
				type:'post',
				data: 'id='+id,
				complete:function(data1){
					window.location.reload(true);
				}
			});
		}
		
		function like(id)
		{
			$.ajax({
				url:'<?php echo BASE_URL ?>clinics/ajx_like',
				type:'post',
				data: 'client_id='+id,
				complete:function(data1){
                         window.location.reload(true);
                    }
			});
		}
                
		function hide_img(id)
		{
			$('#div_'+id).show();
		}
        
		function show_img(id)
		{
             $('#div_'+id).hide();     
		}    
	</script>

	<section class="emai-registration">
		<div class="banner">
			<div class="container pro">
				<div class="orchard-surgery">
					<h1><strong> <?php echo (isset($client_all_detail[0]['Clinic']['name']))?$client_all_detail[0]['Clinic']['name']:'Clinic'; ?></strong></h1>
					<p>
						<?php
							echo (isset($Specialitie_category[0]['Speciality']['specialities_name']))?$Specialitie_category[0]['Speciality']['specialities_name']:'Medical specialty';
							if(isset($Specialitie_sub_category) && !empty($Specialitie_sub_category))
							{ 
								foreach($Specialitie_sub_category as $Specialitie_sub_category){
									echo  $sub_cat_special =', '. $Specialitie_sub_category['Speciality']['specialities_name'];
								}
							} 
						?>
					</p>
					<ul>
						<li>
							<?php echo (isset($client_all_detail[0]['Clinic']['address']))?$client_all_detail[0]['Clinic']['address']:'No address' ?>
						</li>
						<li>
							Opening Hours:
							<br>
							<?php
								$all_opening_keys=array();
								if(!empty($oping_time))
								{
									foreach($oping_time as $key=>$val)
									{
							?>
										<br />
							<?php
							echo $key;
							$all_opening_keys[]=$key; ?> :
							<?php
										for($i=0,$iteration=0;$i<count($val);$i++) 
										{
											if($iteration!=0)
												echo ', ';
											$iteration++;
											echo $sub_cat_special =$val[$i]; 
										}
									}
								}
								else
								{
									echo '<strong>Opening time is not found!</strong>';
							  
								}
							?>
							<br/>
							<?php
								$all_keys=implode(', ',$all_opening_keys);
								$all_opening_keys=explode(', ',$all_keys);
							
								for($i=0,$iteration=0; $i<count($days); $i++)
								{
									if(gettype(array_search($days[$i],$all_opening_keys))!='boolean')
									    continue;
									
									if($iteration!=0)
										echo ', ';
										
									$iteration++;
									echo $days[$i];
									
									if(($i+1) == count($days))
										echo (count($days) > 1)?' are closed':' closed';
								}
								
								if($likes_count>0)
									echo ($likes_count>1)?'<br><br>'.$likes_count.' Likes':'<br><br>'.$likes_count.' Like';
								else
									echo '<br><br>No likes yet';
							?>
						</li>
					</ul>
					<div class="orchard-buttons">
						<button type="button" class="book_appointment">Book Appointment</button>
						<?php
							if($loged_user_type==1)
							{   
								if($count_like_user==0)    
								{
						?>
									<button type="button" class="link" onclick="like('<?php if(isset($client_all_detail[0]['Clinic']['id'])) echo $client_all_detail[0]['Clinic']['id'] ?>')">Like</button>
		
						<?php 
								}
								else
								{
						?>
									<button type="button" class="unlink" onclick="unlike('<?php echo ($Cliniclike_id)?$Cliniclike_id:0; ?>')">Unlike</button>       
						<?php
								}
							}
						?>
					</div>
				</div>
				<div class="banner_slider banner_slider_wall">
					<ul class="bxslider">
						<li><?php echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?>   </li>
						<li><?php echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?>   </li>
						<li><?php echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?>   </li>
						<li><?php echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?>   </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="seedoctor_orchardsurg">
			<div class="container">
				<div class="seedoctor_orchardsurg_title">
					<h2>
						<?php echo (isset($client_all_detail[0]['Clinic']['url']))?'<a href="'.$client_all_detail[0]['Clinic']['url'].'">'.$client_all_detail[0]['Clinic']['url'].'/<span>orchardsurg</span></a>':'No link yet' ?>
					</h2>
			</div>
			<div class="seedoctor_orchardsurg_para">
				<?php
					echo (isset($client_all_detail[0]['Clinic']['logo']))?$this->Html->image('../admin/uploads/thumb/'.$client_all_detail[0]['Clinic']['logo'],array('alt'=>'')):$this->Html->image('../frontend/images/na.jpg',array('alt'=>''));
				?>
				<br />
				<p><?php if(isset($client_all_detail[0]['Clinic']['about'])) echo $client_all_detail[0]['Clinic']['about'] ?></p>
				<br />
				<p class="gray">We are the best clinic in Singapore</p>
			</div>
			<div class="seedoctor_orchardsurg_items">
				<div class="col-sm-4 col-md-4 appointment_module1">appointment<br>module</div>
				<div class="col-sm-4 col-md-4">
					<div class="see-orc">
						<?php
							$todays_day=date('D'); 
							foreach($oping_time as $key=>$val)
							{
								if(gettype(strstr($key, $todays_day))!='boolean')   
								{
									$time_array= $val;
									break;
								}
							}
							
							$time_status=0;
							
							if(!empty($time_array))
							{
								foreach($time_array as $time_arrays)
								{
									$temp_time=explode('-',$time_arrays);
									$current_time_date= date('H:i');
	    
									if($current_time_date<=$temp_time[1] &&  $current_time_date>=$temp_time[0])
									{
										$time_status=1;
										break;
									}
								}  
							}
						?>
						<div class="see-orc-left"> <?php echo $this->Html->image('../frontend/images/icon15.jpg',array('alt'=>'')); ?> </div>
						<div class="see-orc-right">
							<?php
								if($time_status==1)
								{
							?>
									<h2>Currently Open</h2>
									<p>We are open now!</p>
						    <?php
								}
								else
								{
							?>
									<h2>Currently Closed</h2>
									<p>We are Closed now!</p>
						    <?php } ?>
						</div>
					</div>
					<?php
						if(isset($client_all_detail[0]['Clinic']['displaywaiting']) && $client_all_detail[0]['Clinic']['displaywaiting']==1)
						{
					?>
							<div class="see-orc">
								<div class="see-orc-left"><?php echo $this->Html->image('../frontend/images/icon16.jpg',array('alt'=>'')); ?> </div>
								<div class="see-orc-right">
									<h2>Waiting Time</h2>
									<p>
										<?php echo ($client_all_detail[0]['Clinic']['displaywaiting'])?$client_all_detail[0]['Clinic']['displaywaiting']:'Between 0 to 15 minutes.'; ?></p>
								</div>
							</div>
				<?php  	} ?>      
					<div class="see-orc">
						<div class="see-orc-left"> <?php echo $this->Html->image('../frontend/images/icon17.jpg',array('alt'=>'')); ?></div>
						<div class="see-orc-right">
							<h2>Insurance Eligibility</h2>
							<p>
								<?php
									if( !empty($current_insurances))
									{ 
										foreach($current_insurances as $current_insuranc){ 
											echo  $sub_cat_special =$current_insuranc['Insurance']['insurances_name'].',' ;
										}
									} 
								?>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 appointment_module">appointment<br>module</div>
				<div class="col-sm-4 col-md-4">                
					<div class="see-orc">
						<div class="see-orc-left"><?php echo $this->Html->image('../frontend/images/icon18.jpg',array('alt'=>'')); ?></div>
						<div class="see-orc-right">
							<h2>Contact us</h2>
							<?php
								echo ($user_phone_no)?'<p>Phone: +'.$user_phone_no.'</p>':'No information yet';
								echo ($user_phone_no)?'<button type="" name="">Message Me</button>':'';
							?>
					    </div>
					</div>
					<div class="see-orc">
						<div class="see-orc-left"><?php echo $this->Html->image('../frontend/images/icon19.jpg',array('alt'=>'')); ?></div>
						<div class="see-orc-right">
							<h2>Book an Appointment</h2>
							<p>Hassle-free and no extra charges!</p>
						</div>
					</div>
					<div class="see-orc">
						<div class="see-orc-left"><?php echo $this->Html->image('../frontend/images/icon20.jpg',array('alt'=>'')); ?></div>
						<div class="see-orc-right">
							<h2>Company Eligibility</h2>
							<p>
								<?php
									if( !empty($current_insurances))
									{ 
										$i=0;
										foreach($current_eligibi as $current_eligibis)
										{ 
											if($i!=0)
											    echo ',';
											echo  $sub_cat_special =$current_eligibis['Eligibility']['name'];
											$i++;
										}
									} 
								?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wall_map">
	<!--      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3675.1892630768243!2d-43.18861099999999!3d-22.906388999999997!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x997f69432920f9%3A0x2f63f7fa11c4029c!2sParque+Campo+de+Santana!5e0!3m2!1sen!2sin!4v1411983531391" frameborder="0" style="border:0"></iframe>-->
		<iframe  src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php if(isset($client_all_detail[0]['Clinic']['address'])) echo strip_tags($client_all_detail[0]['Clinic']['address']) ?>&amp;aq=0&amp;oq=kol&amp;&amp;sspn=0.63665,1.352692&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo (isset($client_all_detail[0]['Clinic']['address']))?strip_tags($client_all_detail[0]['Clinic']['address']):'Singapore'; ?>&amp;&amp;spn=0.63658,1.352692&amp;t=m&amp;z=10&amp;output=embed"></iframe>       
	</div>
	<div class="our_doctors">
		<div class="container">
			<div class="our_doctors_title"><h2>Our Doctors</h2></div>
			<div class="our_doctors_para">
				<p>We are experienced surgeons who have practised in multiple institutions locally and overseas. Our main areas of expertise 
				include: colorectal cancers, screening endoscopy, chronic inflammatory disorders and perianal disease.</p>
			</div>
		 
			<div class="our_doctors_items">
				<?php
					$my_id=0;
					foreach($doctor as $doctors)
					{
				?>
						<div class="col-md-3 col-sm-6" my_id="<?php echo ++$my_id;?>">
							<div class="doctor_pic" onmouseover="hide_img(<?php echo $my_id;?>)">           
								<?php
									if(isset($doctors['Doctor']['img']) && $doctors['Doctor']['img']!="")
										echo $this->Html->image('../admin/uploads/'.$doctors['Doctor']['img'],array('width'=>'233px','height'=>'199px','alt'=>'')); 
									else
										echo $this->Html->image('../frontend/images/na.jpg',array('alt'=>''));
								?>
								<div  id="div_<?php echo $my_id;?>" style='display:none;' onmouseout="show_img('<?php echo $my_id;?>')" >
									<h2><?php echo $doctors['Doctor']['qualification'].''.$doctors['Doctor']['qualification'] ; ?></h2>
									<!--<p>Special interests: <?php echo $doctors['Doctor']['qualification'].''.$doctors['Doctor']['qualification'] ; ?></p>-->
								</div>
							</div>
							<h2>Dr <?php echo $doctors['Doctor']['f_name'].''.$doctors['Doctor']['l_name'] ; ?></h2>
							<p><?php echo $doctors['Doctor']['title']; ?></p>
						</div>
			<?php 	}  ?>  
			</div>
		</div>
	</div>
	
	<div class="reviews">
		<div class="container">
			<div class="reviews_icon">
				<?php echo $this->Html->image('../frontend/images/icon21.jpg',array('alt'=>'')); ?>
			</div>
			
			<div class="reviews_main">
				<div class="reviews_section">
					<div class="reviews_title">
						<div class="pro_pic"><?php echo $this->Html->image('../frontend/images/pic1.jpg',array('alt'=>'')); ?></div>
						<div class="pro_info">
							<h2>Lorem ipsum</h2>
							<p>Admin Staff</p>
							<span>Yesterday at 3.12 PM</span>
						</div>
					</div>
					<div>Add post</div>
					<div class="pro_cont">
						<p>Donec tortor enim, elementum ut pretium at, consectetur quis ante. Suspendisse potenti. Proin vitae sem ultrices, vehicula justo sit amet, tristique mauris.</p>
					</div>
					<div class="pro_ad_cont">
						<div class="pro_ad_cont_pic">
							<?php echo $this->Html->image('../frontend/images/pic2.jpg',array('alt'=>'')); ?>
						</div>
						<div class="pro_ad_cont_info">
							<h2>Lorem ipsum consectetur</h2>
							<p>Nulla ullamcorper egestas nunceget finibus porta mauris</p>
							<span><a href="#">www.seedoctor.sg/lorem ipsum</a></span>
						</div>
					</div>
					<div class="pro_comm_shr">
						<?php echo $this->Html->image('../frontend/images/icon24.jpg',array('alt'=>'')); ?>
						99 Comment  <?php echo $this->Html->image('../frontend/images/icon30.jpg',array('alt'=>'')); ?>
						<span>Share on Facebook</span>
					</div>
					<div class="pro_comment">
						<div class="pro_comment_pic">
						    <?php echo $this->Html->image('../frontend/images/pic3.jpg',array('alt'=>'')); ?>
						</div>
						<div class="pro_comment_text">
							<strong>Proin Auctor:</strong> Proin auctor lectus eget lorem fringilla, sed placer 
							<?php echo $this->Html->image('../frontend/images/icon25.jpg',array('alt'=>'')); ?>
						</div>
					</div>
					<div class="pro_comment">
						<div class="pro_comment_pic"><?php echo $this->Html->image('../frontend/images/pic4.jpg',array('alt'=>'')); ?></div>
						<div class="pro_comment_text">
							<strong>Proin Auctor:</strong> Proin auctor lectus eget lorem fringilla, sed placer
							<?php echo $this->Html->image('../frontend/images/icon25.jpg',array('alt'=>'')); ?>
						</div>
						<div class="pro_new_comment">
							<div class="pro_comment_pic">
								<?php echo $this->Html->image('../frontend/images/pic5.jpg',array('alt'=>'')); ?>
							</div>
							<div class="pro_comment_text">
								<textarea rows="5" cols="5" name="" placeholder="Write a comment..."></textarea>
								<a href="#"><?php echo $this->Html->image('../frontend/images/icon27.jpg',array('alt'=>'')); ?></a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="reviews_main">
					<div class="reviews_section">
						<div class="reviews_title">
							<div class="pro_pic"><?php echo $this->Html->image('../frontend/images/pic6.jpg',array('alt'=>'')); ?></div>
							<div class="pro_info">
								<h2>Lorem ipsum</h2>
								<p>Admin Staff</p>
								<span>Yesterday at 3.12 PM</span>
							</div>
						</div>
						<div class="pro_cont">
							<p>Donec tortor enim, elementum ut pretium at, consectetur quis ante. Suspendisse potenti. Proin vitae sem ultrices, vehicula justo sit amet, tristique mauris.</p>
						</div>
						<div class="pro_comm_shr">
						    
						
						    <?php echo $this->Html->image('../frontend/images/imagesicon24.jpg',array('alt'=>'')); ?>
						    99 Comment
						    
						   
							 <?php echo $this->Html->image('../frontend/images/icon30.jpg',array('alt'=>'')); ?>
						    <span>Share on Facebook</span>
						</div>
						<div class="pro_comment">
							<div class="pro_comment_pic">
							   
							   <?php echo $this->Html->image('../frontend/images/pic3.jpg',array('alt'=>'')); ?>
							  
							   
						    </div>
						    <div class="pro_comment_text"><strong>Proin Auctor:</strong> Proin auctor lectus eget lorem fringilla, sed placer
							  
							   <?php echo $this->Html->image('../frontend/images/icon25.jpg',array('alt'=>'')); ?>
							  
							   
						    </div>
						</div>
						<div class="pro_comment">
							<div class="pro_comment_pic">
							   <?php echo $this->Html->image('../frontend/images/pic4.jpg',array('alt'=>'')); ?>
							  
							   
						    </div>
			   <div class="pro_comment_text"><strong>Proin Auctor:</strong> Proin auctor lectus eget lorem fringilla, sed placer
				  
				<?php echo $this->Html->image('../frontend/images/icon25.jpg',array('alt'=>'')); ?>
				
				  
				  
			   </div>
						</div>
						<div class="pro_new_comment">
							<div class="pro_comment_pic">
							   <?php echo $this->Html->image('../frontend/images/pic5.jpg',array('alt'=>'')); ?>
							
						    </div>
						    <div class="pro_comment_text"><textarea rows="5" cols="5" name="" placeholder="Write a comment..."></textarea><a href="#">
								 <?php echo $this->Html->image('../frontend/images/icon27.jpg',array('alt'=>'')); ?>
								 
							   </a></div>
						</div>
					</div>
				</div>
		 </div>
	</div>
	<div class="getin_touch">
	    <div class="container">
	    <div class="getin_touch_title">
			    <h2>Our Services</h2>
		 </div>
		 <div class="getin_touch_para">
		    <p>We manage the following:</p>
		    </div>
		 <div class="getin_touch_items">
		    <div class="col-md-6 col-sm-6 col-xs-12">
			    <ul class="getin_touch_left">
				    <li><a href="#">Anorectal Disease</a></li>
				   <li><a href="#">Anal Fistulas</a></li>
				   <li><a href="#">Diverticulosis</a></li>
				   <li><a href="#">Colorectal Cancer</a></li>
				   <li><a href="#">Colonoscopy</a></li>
				   <li><a href="#">FOBT screening</a></li>
				   <li><a href="#">Inflammatory Bowel Disease</a></li>
				   <li><a href="#">Irritable Bowel Syndrome</a></li>
				   <li><a href="#">Robotic Surgery</a></li>
			    </ul>
			</div>
			
			<?php //pr($Specialitie_category); ?>
			
			<div class="col-md-2 col-sm-2 col-xs-12">
			    <ul class="getin_touch_middle">
				    <li><a href="#">
						 
						<?php echo $this->Html->image('../frontend/images/facebook_icon.jpg',array('alt'=>'')); ?>
						
					  </a></li>
				   <li><a href="#">
						   <?php echo $this->Html->image('../frontend/images/twitter_icon.jpg',array('alt'=>'')); ?>
						
						 
					  </a></li>
				   <li><a href="#">
						 <?php echo $this->Html->image('../frontend/images/youtube_icon.jpg',array('alt'=>'')); ?>
						 </a></li>
				   <li><a href="#">
						 <?php echo $this->Html->image('../frontend/images/google_plus_icon.jpg',array('alt'=>'')); ?>
						
						 
					  </a></li>
			    </ul>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
			    <div class="getin_touch_right">
					  
					  <?php echo $this->Html->image('../frontend/images/mobile_img1.jpg',array('alt'=>'')); ?>
				    
			    </div>
			</div>
		 </div>
	  </div>
	</div>
   </section>

        <style>   
        .showme{ 
display: none;
}
.showhim:hover .showme{
display : block;
}

</style>