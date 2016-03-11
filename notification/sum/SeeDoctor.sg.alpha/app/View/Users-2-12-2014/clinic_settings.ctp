	<?php echo $this->Html->script('../frontend/js/ckeditor/ckeditor.js'); ?>
	<script>
		$(document).ready(function(){
			//---------------------------------form validation for user-----------------------------------------//
			CKEDITOR.replace('address');
			CKEDITOR.replace('about');
		});
		
		function cheking_validation()
		{
			$("#user_reg_form").validate({
				rules: {
						//fileInput: {
						//	required: true,
						//	extension: "jpg|jpeg|png|ico|JPG|JPEG|PNG|ISO"
						//},
						clinic_name: 	 "required",
						license: "required",
						handphone:   {
									required: true,
									minlength: 10
							},
						url: {
									required: true,
									url: true
								},
						address: "required",
						type: "required",
						about: "required",
						"insurances[]": "required",
						"eligibilities[]": "required"
					},
					messages: {
						//fileInput: "Invalid image format only (jpg,jpeg,png,ico) are allowed",
						clinic_name: "Please enter your clinic name",
						license: "Please enter your license number",
						handphone:{
							required: "Please secect your phone number",
							minlength: "Please enter 10 digit number"
						},
						url: {
							required: "Please enter your clinic url",
							url: "Please enter your valid url"
						},
						address: "Please enter address",
						type: "Please select medical speciality type",
						about: "Please enter about",
						"insurances[]": "Please select insurances",
						"eligibilities[]": "Please select eligibilities",
					},
					submitHandler: function(form) {
						var address = $('#address').val();
						var error = 0;
						if (address.search(/\S/)==-1) {
							$('#address-error').html('Please enter address'); $('#address-error').show(); $('#about-error').show();
							error = 1;
						}
						
						var about = $('#about').val();
						if (about.search(/\S/)==-1) {
							$('#about-error').html('"Please enter about'); $('#address-error').show(); $('#about-error').show();
							error = 1;
						}
						
						//alert(error);
						if (error == 0) {
							form.submit();
						}
					}
			});
		}
		
		function ajax_sub(id)
		{
			var u='<?php echo BASE_URL ?>clinics/producesub1';
			var sub_type_id = $('#sub_type_id').val();  
			var xmlhttp;
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4)
				{
					document.getElementById("sub").innerHTML=xmlhttp.responseText;
					$("#subtype").each(function(){
						$(this).wrap( "<span class='select-wrapper'></span>" );
						$(this).after("<span class='holder'></span>");
					});
					
					$("#subtype").change(function(){
						var selectedOption = $(this).find(":selected").text();
						$(this).next(".holder").text(selectedOption);
					}).trigger('change');
				}
			}
			xmlhttp.open("GET",u+'?specialityid='+id+'&sub_type_id='+clinic_id,true);
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
					
					<input type="hidden" name="sub_type_id" id="sub_type_id" value="<?php echo $this->request->data['subtype']; ?>" />
					
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
											<input class="user-in form-control" style="height: 38px;" type="text" name="handphone" placeholder="Enter phone number" value="<?php echo ($this->request->data['handphone'])?preg_replace('/65/', '', $this->request->data['handphone'], 1):''; ?>">
										</div>
										<label id="handphone-error" class="error" for="handphone"></label>
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
								<label class="col-xs-12 col-md-3">Clinic Speciality<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<select name="type" class="custom-select" onchange="ajax_sub(this.value)">
										<option value="">Select clinic Speciality</option>
										<?php
											$seleted_name = '';
											foreach($all_base_specialities as $k=>$v)
											{
												$selet=($v['Speciality']['id']==$this->request->data['type'])?'selected':'';
												if($v['Speciality']['id']==$this->request->data['type']){
													$seleted_name=$v['Speciality']['specialities_name'];
												}
												echo '<option '.$selet.' value="'.$v['Speciality']['id'].'" >'.$v['Speciality']['specialities_name'].'</option>';
											}
										?>
									</select>
									<label id="type-error" class="error" for="type"></label>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Clinic Sub Speciality1 :</label>
								<div class="col-xs-12 col-md-9" id='sub'>
									<?php
										if(is_array($all_sub_specialities))
										{
											$seleted_name = '';
									?>
											<select name="subtype" id="subtype" class="custom-select">
												<option value="">Select Sub Speciality</option>
												<?php
													foreach($all_sub_specialities as $k1=>$v1)
													{
														$selet1=($v1['Speciality']['id']==$this->request->data['subtype'])?'selected':'';
														if($v1['Speciality']['id']==$this->request->data['type']){
															$seleted_name=$v1['Speciality']['specialities_name'];
														}
														echo '<option '.$selet1.' value="'.$v1['Speciality']['id'].'" >'.$v1['Speciality']['specialities_name'].'</option>';
													}
												?>
											</select>
									<?php
										}
										else
										{
											echo $this->Form->input('subtype',array('label' => FALSE, 'div' => FALSE, 'type' => 'txt', 'class' => 'user-in', 'id' => 'subtype', 'value' => $this->request->data['subtype']));
										}
									?>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Address<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<textarea rows="5" cols="5" name="address" id="address" placeholder="Enter address" class="user-in-area ck_editor"><?php echo ($this->request->data['address'])?$this->request->data['address']:''; ?></textarea>
									<label id="address-error" class="error" for="address"></label>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">About<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<textarea rows="5" cols="5" name="about" id="about" placeholder="Enter about" class="user-in-area ck_editor"><?php echo ($this->request->data['about'])?$this->request->data['about']:''; ?></textarea>
									<label id="about-error" class="error" for="about"></label>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Waiting Time :</label>
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
								<label class="col-xs-12 col-md-3">Eligibilities<sup>*</sup> :</label>
								<div class="col-xs-12 col-md-9">
									<select name="eligibilities[]" multiple="multiple" class="listbox">
										<?php
											$checked_arr=array();//items to be kept selected 
											if(!empty($current_eligibility))
											{
												foreach($current_eligibility as $v)
												{
													$checked_arr[]=$v[Eligibilitieclinc][eligibiliti_id];
												}
											}
											
											//creating the dropdown
											foreach($all_eligibility as $k2=>$v2)
											{
										?>
											<option <?php if(gettype(array_search($v2['Eligibilitie']['id'],$checked_arr))!='boolean'){?>selected='selected'<?php }?> value="<?php echo $v2['Eligibilitie']['id'];?>"><?php echo $v2['Eligibilitie']['name'];?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
						</div>
                        <div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3">Tags<sup></sup> :</label>
								<div class="col-xs-12 col-md-9">
									<textarea rows="5" cols="5" name="tags" id="tags" placeholder="Tags" class="user-in-area ck_editor"><?php echo ($this->request->data['tags'])?$this->request->data['tags']:''; ?></textarea>
									
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="row">
								<label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
								<div class="col-xs-12 col-md-9">
									<button class="save" id="form_save" onclick="cheking_validation()">Save Changes</button>
									<?php echo $this->Html->link('Cancel', array('controller' => 'clinics', 'action' => 'clintlist'), array('class' => 'cancel')); ?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
	    </section>
