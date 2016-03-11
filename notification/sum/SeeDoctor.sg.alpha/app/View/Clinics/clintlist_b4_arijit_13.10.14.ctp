	<script type="text/javascript">
		function unlike(id)
		{
			$.ajax({
				url:'<?php echo BASE_URL ?>clinics/ajx_unlike',
				type:'post',
				data: 'client_id='+id,
				complete:function(data1){}
			});
		}
	</script>

	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Clinic</h2></div></div>
		<div class="container">
			<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
			<div class="new_add_but">
				<?php echo $this->Html->link('Add Clinic', array('controller' => 'users', 'action' => 'addclinicfont'), array()); ?>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="client_info">
				<tr class="client_info_title">
					<td class="col-1">&nbsp;</td>
					<td class="col-2">Clinic Name</td>
					<?php
						if($this->Session->read('reid_user_type'==1))
						{
					?>		
							<td class="col-3">
								Liked Date
								<a href="#" class="downarrow"><?php echo $this->Html->image('../frontend/images/downarrow.png',array('alt'=>'')); ?></a>
							</td>
							<td class="col-3">Options</td>
					<?php
							if($loged_user_type==1){ echo '<td class="col-4">Unlike</td>'; } 
						}
						elseif($this->Session->read('reid_user_type')==2)
						{
					?>
							<td class="col-3">Liked Count</td>
							<td class="col-3">Options</td>
					<?php
						}
					?>
				</tr>
				<?php
					$i=1;
					foreach($clinic as $clinic)
					{
				?>
						<tr class="client_info_cont_g_bar">
							<td class="col-1"><?php echo $i; ?></td>
							<td class="col-2">
								<?php  echo $this->Html->link( $clinic['Clinic']['name'], array('controller' => 'clinics', 'action' => 'clincwall/'.$clinic['Clinic']['id'])); ?>
							</td>
							<?php
								if($this->Session->read('reid_user_type')==1)
								{
							?>
									<td class="col-3"><?php echo date('j F Y',strtotime($clinic['Clinic']['dateadded'])) ?></td>
							<?php
									if($loged_user_type==1)
									{
							?>
										<td class="col-4"><a href="javascript:void(0)" onclick="unlike(<?php echo $clinic['Clinic']['id'] ?>)"><?php echo $this->Html->image('../frontend/images/thunbdown.ong.png',array('alt'=>'')); ?></a></td>
							<?php
									}
								}
								elseif($this->Session->read('reid_user_type')==2)
								{
							?>
									<td class="col-5">2300</td>
									<td class="col-5">
										<span>
											<a href='<?php echo BASE_URL.'users/clinic_settings/id:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/gear.png", array("alt"=>"Edit", 'title' => 'Edit')) ?></a>
										</span>
										<span>
											<!--<a href='<?php echo BASE_URL.'users/clinic_delete/id:'.$clinic['Clinic']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/trash_can.png", array("alt"=>"Delete", 'title' => 'Delete')) ?></a>-->
										</span>
									</td>
							<?php
									
								}
							?>
						</tr>
				<?php
						$i++;
					}
				?>
	  <!--            <tr class="client_info_cont_y_bar">
				   <td class="col-1">2</td>
				   <td class="col-2">Tan Plastic Surgery Clinic</td>
				   <td class="col-3">10 April 2014</td>
				   <td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>
			    </tr>
			    <tr class="client_info_cont_g_bar">
				   <td class="col-1">3</td>
				   <td class="col-2">Tan's Surgery</td>
				   <td class="col-3">15 March 2014</td>
				   <td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>
			    </tr>
			    <tr class="client_info_cont_y_bar">
				   <td class="col-1">4</td>
				   <td class="col-2">Tan Plastic Surgery Clinic</td>
				   <td class="col-3">10 April 2014</td>
				   <td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>
			    </tr>
			    <tr class="client_info_cont_g_bar">
				   <td class="col-1">5</td>
				   <td class="col-2">Tan's Surgery</td>
				   <td class="col-3">15 March 2014</td>
				   <td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>
			    </tr>
			    <tr class="client_info_cont_y_bar">
				   <td class="col-1">6</td>
				   <td class="col-2">Tan Plastic Surgery Clinic</td>
				   <td class="col-3">10 April 2014</td>
				   <td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>
			    </tr>-->
			</table>
		</div>
	  </section>