
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
		
		function add_clinic()
		{
			window.location = '<?php BASE_URL.'clinics/clintlist/show:all'; ?>'
		}
		
	</script>

	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Clinic</h2></div></div>
		<div class="container">
			<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
			<!-- Showing the success message -->
			 <span style="padding: 4px;"><?php echo $this->Session->flash('opening_updated'); ?></span>
			<div class="inner-gapbox-1">
				<?php
					if($this->Session->read('reid_user_type')==1)
					{
						if($show_type == 'all'){
							$backcolor = 'background-color:#fff'; $backcolor1='';
						}
						else{
							$backcolor1 = 'background-color:#fff'; $backcolor='';
						}
				?>
						<!--<div class="orchard-surgery new_padding">
							<div class="orchard-buttons">
								<button class="book_appointment" style="<?php //echo $backcolor; ?>" onclick="window.location = '<?php //echo BASE_URL.'clinics/clintlist/'; ?>'">Liked Clinics</button>
								
								<button class="book_appointment" style="<?php //echo $backcolor1; ?>" onclick="window.location = '<?php //cho BASE_URL.'clinics/clintlist/show:all'; ?>'">All Clinics</button>
							</div>
							<div class="clearfix"></div>
						</div>-->
				<?php
					}
					else
					{
				?>
						<div class="orchard-surgery new_padding">
							<div class="orchard-buttons">
								<?php echo $this->Html->link('Add Clinic', array('controller' => 'users', 'action' => 'addclinicfont'), array('class' => 'book_appointment')); ?>
							</div>
							<div class="clearfix"></div>
						</div>
				<?php
					}
					?>
			 
			 
				<div class="rgeistration-wrapp" id="add_clinic" style="display: none;">
					<div id="user_form">
						<form name="user_pass_form" id="user_pass_form" action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="user_id" id="user_id" value="6">
							
							<div class="form-row">
								<div class="col-md-4"><input type="password" name="password" id="password1" placeholder="Password" value="" class="user-in"></div>
							</div>
							<div class="clearfix"></div>
							<div class="button-wrapp">
								<div class="butt-reg"><button class="regisyer-butt" id="user_passw_btn">Search</button></div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			
				<!--<div style="padding-top: 30px;"></div>-->
				<div class="client_info_main">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="client_info">
					<tr class="client_info_title">
						<td class="col-1">&nbsp;</td>
						<td class="col-2">Clinic Name</td>
						<?php
							if($this->Session->read('reid_user_type')==1)
							{
								if($show_type == 'all')
								{
									echo '<td class="col-3">Total Likes</td>';
									if($loged_user_type==1){ echo '<td class="col-4">Option</td>'; } 
								}
								else
								{
						?>		
									<td class="col-3">
										Liked Date
										<a href="#" class="downarrow"><?php echo $this->Html->image('../frontend/images/downarrow.png',array('alt'=>'')); ?></a>
									</td>
						<?php
									if($loged_user_type==1){ echo '<td class="col-4">Unlike</td>'; } 
								}
							}
							elseif($this->Session->read('reid_user_type')==2)
							{
						?>
								<td class="col-3">Liked Count</td>
								<td class="col-3">Status</td>
								<td class="col-4">Options</td>
						<?php
							}
						?>
					</tr>
					<?php
						$i=1;
						$clinics=$clinic;
						
						if(!empty($clinics))
						{
							foreach($clinics as $clinic)
							{
								if($i%2==0){$class='client_info_cont_y_bar';}else{$class='client_info_cont_g_bar';}
					?>
							<tr class="<?php echo $class; ?>">
								<td class="col-1"><?php echo $i; ?></td>
								<td class="col-2">
									<?php  echo $this->Html->link( $clinic['Clinic']['name'], array('controller' => 'clinics', 'action' => 'clincwall/'.$clinic['Clinic']['id'])); ?>
								</td>
								<?php
									if($this->Session->read('reid_user_type')==1)
									{
										if($show_type == 'all')
										{
											if($clinic['Clinic']['likes']>0)
												$likes = ($clinic['Clinic']['likes']>1)?$clinic['Clinic']['likes'].' Likes':$clinic['Clinic']['likes'].' Like';
											else
												$likes = 'No likes yet';
												
											echo '<td class="col-3">'.$likes.'</td>';
											
											if(!empty($clinic['Cliniclike']) && $clinic['Cliniclike']['user_id']==$this->Session->read('reid_user_uid'))
											{
												echo '<td class="col-4"><a href="javascript:void(0)" onclick="unlike(\''.$clinic['Cliniclike']['id'].'\')">'.$this->Html->image('../frontend/images/thunbdown.ong.png',array('alt'=>'')).'</a></td>';
											}
											else
											{
												echo '<td class="col-4"><a href="javascript:void(0)" onclick="like(\''.$clinic['Clinic']['id'].'\')">'.$this->Html->image('../frontend/images/thunbup.ong.png',array('alt'=>'')).'</a></td>';
											}
										}
										else
										{
								?>
											<td class="col-3"><?php echo date('j F Y',strtotime($clinic['Cliniclike']['added_date'])) ?></td>
								<?php
											if($loged_user_type==1)
											{
									?>
												<td class="col-3"><a href="javascript:void(0)" onclick="unlike('<?php echo $clinic['Cliniclike']['id'] ?>')"><?php echo $this->Html->image('../frontend/images/thunbdown.ong.png',array('alt'=>'')); ?></a></td>
									<?php
											}
										}
									}
									elseif($this->Session->read('reid_user_type')==2)
									{
										$pr_add = (isset($clinic['Clinic']['total_likes']) && $clinic['Clinic']['total_likes'] > 1)?$clinic['Clinic']['total_likes'].' Likes':$clinic['Clinic']['total_likes'].' Like';
								?>
										<td class="col-3"><?php echo (isset($clinic['Clinic']['total_likes']) && $clinic['Clinic']['total_likes'] > 0)?$pr_add:'No likes yet'; ?></td>
										<td class="col-3"><?php echo ($clinic['Clinic']['status']==1)?'<span class="label label-success">Approved</span>':'<span class="label label-danger">Pending approval</span>'; ?></td>
										<td class="col-4">
											<?php if($clinic['Clinic']['status']==1){ ?>
												<span>
													<a href='<?php echo BASE_URL.'clinics/setopeninghours/clinicid:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../frontend/images/clock.png", array("alt"=>"Opening Hour", 'title' => 'Opening Hour')) ?></a>
												</span>
											<?php 	} ?>
											
											<?php if($clinic['Clinic']['status']==1){ ?>
												<span>
													<a href='<?php echo BASE_URL.'users/clinic_settings/id:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/gear.png", array("alt"=>"Edit", 'title' => 'Edit')) ?></a>
												</span>
											<?php 	} ?>
											<span>
												<a onclick="return confirm('Are you sure to delete this clinic?')" href='<?php echo BASE_URL.'users/clinic_delete/id:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/trash_can.png", array("alt"=>"Delete", 'title' => 'Delete')) ?></a>
											</span>
											<?php if($clinic['Clinic']['status']==1){ ?>
												<span>
													<a href='<?php echo BASE_URL.'clinics/list_doctor/id:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/user.png", array("alt"=>"Manage Doctors", 'title' => 'Manage Doctors')) ?></a>
												</span>
											<?php 	} ?>
										</td>
								<?php
									}
								?>
							</tr>
						<?php
								$i++;
							}
						}
						else
						{
							echo '<tr class="client_info_cont_g_bar">
								<td class="col-1">&nbsp;</td>
								<td class="col-2">No clinics found.</td>
								<td class="col-3">&nbsp;</td>
								<td class="col-3">&nbsp;</td>
								<td class="col-4">&nbsp;</td>
							</tr>';
						}
					?>
				</table>
                </div>
				
				<div class="span6">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul>
                                                            <?php
                                                                
                                                                if($this->Paginator->hasPrev())
								{
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->prev(
                                                                  ' ←',
                                                                  $options=array('tag'=>'li','class'=>'prev','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'prev disabled')
                                                                );
								}
                                                                // Shows the page numbers
                                                                echo $this->Paginator->numbers($options=array('tag'=>'li','separator'=>'','currentTag'=>'a','currentClass'=>'active'));
                                                                if($this->Paginator->hasNext())
								{
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->next(
                                                                  '→ ',
                                                                  $options=array('tag'=>'li','class'=>'next','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'next disabled')
                                                                );
								}
                                                            ?>
                                                </ul>
                                    </div>
                                </div>
				
			</div>
		</div>
	  </section>