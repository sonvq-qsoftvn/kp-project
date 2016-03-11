	<?php echo $this->Html->script('../frontend/js/ckeditor/ckeditor.js'); ?>
	<script>
		$(document).ready(function(){
			//---------------------------------form validation for user-----------------------------------------//
			$('#form_save').click(function(){	
				$("#user_reg_form").validate({
					rules: {
							clinic_name: 	 "required",
							license_number: "required",
							phone_number:   "required",
							clinic_url: {
										required: true,
										url: true
									},
							address: "required"
						},
						messages: {
							clinic_name: "Please enter your clinic name",
							license_number: "Please enter your license number",
							phone_number:"Please secect your phone number",
							clinic_url: {
								required: "Please enter your clinic url",
								url: "Please enter your valid url"
							},
							address: "Please enter address"
						},
						submitHandler: function(form) {
						//form.submit();
					}
				});
			});
			
			CKEDITOR.replace('address');
			CKEDITOR.replace('about');
		});
		
		function ajax_sub(id,u)
		{
			var xmlhttp;
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4)
				{
					document.getElementById("sub").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET",u+'?specialityid='+id,true);
			xmlhttp.send();
		}
		
		function chooseFile() {
			$("#fileInput").click();
		}
		
		function chage_name(val){
			if(val != '')
				$('#file_data').html(val);
			else
				$('#file_data').html('No File Selected');
		}
	</script>
	<?php
		if(isset($this->request->data['logo']))
			$profile_img = $this->Html->image('../admin/uploads/'.$this->request->data['logo'],array('alt'=>'logo image'));
		else
			$profile_img = $this->Html->image('../frontend/images/na.jpg',array('alt'=>''));
	?>
		
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Edit Clinic</h2> </div></div>
		<div class="container">
			<div class="inner-gapbox-1">
				<?php echo $this->Session->flash('update_error'); //Showing the error/success message ?>
				<form name='user_reg_form' id='user_reg_form' action='<?php echo BASE_URL;?>users/clinic_settings' method='post' enctype='multipart/form-data' >
					<input type="hidden" name="clinic_id" id="clinic_id" value="<?php echo $this->params->named['id']; ?>" />
					<input type="hidden" name="clinicmanagersid" id="clinicmanagersid" value="<?php echo $this->Session->read('reid_user_uid'); ?>" />
					<div class="add_clinic">
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">&nbsp;</label>
								<div class="col-xs-12 col-md-9">
									<div class="clinic_pic"><?php echo $profile_img ?></div>
									<div class="upload_clinic_pic">
										<h2>Upload <br>Image</h2>
										<div style="height:0px;visibility: hidden;"><input type="file" onchange="chage_name(this.value)" name="fileInput" id="fileInput" /></div>
										<button type="button" type="button" onclick="chooseFile();">Browse</button>
										<span id="file_data">No File Selected</span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Clinic Name<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><input type="text" name="clinic_name" placeholder="Enter clinic name" class="user-in" value="<?php echo ($this->request->data['name'])?$this->request->data['name']:''; ?>"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">License Number<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><input type="text" name="license" placeholder="Enter license number" value="<?php echo ($this->request->data['license'])?$this->request->data['license']:''; ?>" class="user-in"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Hand Phone Number<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon" style="border-radius: 0">+65</div>
											<input class="user-in form-control" style="height: 38px;" type="text" name="handphone" placeholder="Enter phone number" value="<?php echo ($this->request->data['handphone'])?str_replace('65', '', $this->request->data['handphone']):''; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Clinic url<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><input type="text" name="url" placeholder="Enter clinic url" value="<?php echo ($this->request->data['url'])?$this->request->data['url']:''; ?>" class="user-in"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Address<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><textarea rows="5" cols="5" name="address" id="address" placeholder="Enter address" class="user-in-area ck_editor"><?php echo ($this->request->data['address'])?$this->request->data['address']:''; ?></textarea></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Clinic Speciality<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<select name="type" class="custom-select">
										<option>Select clinic Speciality</option>
										<?php
											foreach($all_base_specialities as $k=>$v)
											{
												$selet=($v['Speciality']['id']==$this->request->data['type'])?'selected':'';
												echo '<option '.$selet.' onchange="ajax_sub(this.value,\''.BASE_URL.'administrator/producesub\')" value="'.$v['Speciality']['id'].'" >'.$v['Speciality']['specialities_name'].'</option>';
											}
											
											//echo $this->Form->input('type',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'type', 'options'=>$options_arr2,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'chzn-select-deselect','onchange'=>'ajax_sub(this.value,"'.BASE_URL.'administrator/producesub")'));
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Clinic Sub Speciality<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<select name="subtype" class="custom-select">
										<option value="">Select Sub Speciality</option>
										<?php
											if(is_array($all_sub_specialities))
											{
												foreach($all_sub_specialities as $k1=>$v1)
												{
													$selet1=($v1['Speciality']['id']==$this->request->data['subtype'])?'selected':'';
													echo '<option '.$selet1.' value="'.$v1['Speciality']['id'].'" >'.$v1['Speciality']['specialities_name'].'</option>';
												}
												//echo $this->Form->input('subtype',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'subtype', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'chzn-select-deselect'));
											}
											else
											{
												echo $this->Form->input('subtype',array('label' => FALSE, 'div' => FALSE, 'type' => 'txt', 'class' => 'user-in', 'id' => 'subtype', 'value' => $this->request->data['subtype']));
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">About<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><textarea rows="5" cols="5" name="about" id="about" placeholder="Enter address" class="user-in-area ck_editor"><?php echo ($this->request->data['about'])?$this->request->data['about']:''; ?></textarea></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Waiting Time<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9"><input type="text" name="waitingtime" placeholder="Enter waiting time" value="<?php echo ($this->request->data['waitingtime'])?$this->request->data['waitingtime']:''; ?>" class="user-in"></div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
								<div class="col-xs-12 col-md-9 pdb">
									<span class="checkitem"><input type="checkbox" value="1" <?php echo ($this->request->data['displaywaiting']==1)?'checked="checked"':''; ?> name="displaywaiting"> Display waiting time on clinic wall</span>
									<span class="checkitem"><input type="checkbox" name="allowpost" <?php echo ($this->request->data['allowpost']==1)?'checked="checked"':''; ?> value="1"> Allow users to post on clinic wall?</span>
									<span class="checkitem"><input type="checkbox" name="lockwall" <?php echo ($this->request->data['lockwall']==1)?'checked="checked"':''; ?> value="1"> Lock clinic wall?</span>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Insurances<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<select name="insurances[]" multiple="multiple" class="listbox">
										<?php
											$checked_arr=array();//items to be kept selected 
											if(!empty($current_insurances))
											{
												foreach($current_insurances as $v)
												{
													$checked_arr[]=$v[Insurancetoclinic][insuranceid];
												}
											}
											
											//creating the dropdown
											foreach($all_insurances as $k2=>$v2)
											{
										?>
											<option <?php if(gettype(array_search($v2['Insurance']['id'],$checked_arr))!='boolean'){?>selected='selected'<?php }?> value="<?php echo $v2['Insurance']['id'];?>"><?php echo $v2['Insurance']['insurances_name'];?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
								<div class="col-xs-12 col-md-9">
									<button class="save">Save Changes</button>
									<?php echo $this->Html->link('Cancel', array('controller' => 'clinics', 'action' => 'clintlist'), array('class' => 'cancel')); ?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
	    </section>
