<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
    
  function cheking_validation()
		{
                    
                    
                   
			$("#add_doctor_form").validate({
				rules: {
						f_name: "required",
						l_name: "required",
						
						title: "required",
						qualification: "required",
						
					},
					messages: {
						f_name: "Please enter your doctor first name",
						l_name: "Please enter your doctor last name",
						title:"Please Enter Doctor title",
                                                qualification:"Please Enter doctor qualification",
						
					},
					submitHandler: function(form) {
						form.submit();
					}
			});
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
    




<section class="emai-registration">
      <div class="topheading-box">
    <div class="container">
          <h2>Add Doctor</h2>
        </div>
     </div>
    
    
      <?php echo $this->Form->create('Doctor',$settings=array('class'=>'form-horizontal','id'=>'add_doctor_form','name'=>'add_doctor_form','enctype'=>'multipart/form-data')); ?>
    
      <div class="container">
    <div class="inner-gapbox-1">
      <div class="add_clinic">
         <div class="form-row">
            <div class="row">
                <label class="col-xs-12 col-md-3">&nbsp;</label>
                <div class="col-xs-12 col-md-9">
                	<div class="clinic_pic"><?php echo $this->Html->image('../frontend/images/na.jpg',array('alt'=>'')); ?></div>
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
                <label class="col-xs-12 col-md-3">Doctor First Name <sup>*</sup> :</label>
                <div class="col-xs-12 col-md-9"><input type="text" name="f_name" id="f_name" class="user-in"></div>
               
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <label class="col-xs-12 col-md-3">Doctor Last Name <sup>*</sup> :</label>
                <div class="col-xs-12 col-md-9"><input type="text" name="l_name" id="l_name" class="user-in"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <label class="col-xs-12 col-md-3">Doctor Title<sup>*</sup> :</label>
                <div class="col-xs-12 col-md-9"><input type="text" name="title" id="title"  class="user-in"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="row">
                <label class="col-xs-12 col-md-3">Doctor Qualification<sup>*</sup> :</label>
                <div class="col-xs-12 col-md-9"><input type="text" name="qualification" id="qualification" class="user-in"></div>
            </div>
        </div>
          
          <div class="form-row">
        	<div class="row">
        		<label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
                <div class="col-xs-12 col-md-9">
            		<button class="save" id="form_save" onclick="cheking_validation()">Save Changes</button>
                	<!--<button class="cancel">Cancel</button>-->
			<input type="reset" value="Cancel" class="cancel"/>
                </div>
               </div>
            </div>  
      
        <div class="clearfix"></div>
      </div>
        </div>
  </div>
    
    <?php echo $this->Form->end(); ?>
   
    
    </section>


<style >
.error {
    color: #FD2A02;
    font-weight: normal;
}

</style>