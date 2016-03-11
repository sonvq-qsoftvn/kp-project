<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($this->Session->read('reid_user_type')==2)
{
    $user_role = 'Clinic Manager';
}
elseif($this->Session->read('reid_user_type')==1)
{
    $user_role = 'User';
}
//echo $user_role;
?>
	
<script>
	$(document).ready(function(){
			//---------------------------------form validation for user-----------------------------------------//
      $('#form_save').click(function(){
	
	   $("#wall_post").validate({
				
				  rules: {
						post_title: "required",
                                                post_main_text: "required",
						
						
					},
					messages: {
						post_title: "Please enter post title.",
						post_main_text: "Please enter post text.",
						
					},
					submitHandler: function(form) {
						form.submit();
					}
			});
		});  
	});
</script>
   
<!--//  function cheking_validation()
//		{
//                    
//                    alert("hello");
//                   
//			$("#wall_post").validate({
//				rules: {
//						post_main_text: "required",
//						
//						
//					},
//					messages: {
//						f_name: "Please enter post text.",
//						
//						
//					},
//					submitHandler: function(form) {
//						form.submit();
//					}
//			});
//		}  -->
    
   
    
    
<script>
function chooseFile() {
    
                       $("#attachment_image").click();
                   
		    }
                    
    function chage_name(val){
			if(val != '')
				$('#file_data').html(val);
			else
				$('#file_data').html('No File Selected');
		}                
                    

</script>
  
   <?php echo $this->Form->create('Wallpost',$settings=array('class'=>'form-horizontal','id'=>'wall_post','name'=>'wall_post','enctype'=>'multipart/form-data')); ?>
   
<div class="container">
    <div class="inner-gapbox-1">
      <div class="add_clinic">
       
 
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Post Title*:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('post_title',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'post_title'));
                        ?>
                        </div>
                        </div>
                        </div>
 
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Post Main Text*:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('post_main_text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'user-in-area', 'id' => 'post_main_text','rows'=>'5','cols'=>'5'));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Posted By First Name:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_fname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_fname','value'=>$user_details[0]['User']['first_name']));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Posted By Last Name:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_lname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_lname','value'=>$user_details[0]['User']['last_name']));?>
                        </div>
                        </div>
                        </div>
                                                     
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Posted By Designation:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_designation',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_designation','value'=>$user_role));
                        ?>
                        </div>
                        </div>
                        </div>
                                                      
                        
                        
                        <!------------------>
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Image:</label>
                        <div class="col-xs-12 col-md-9">
                        <div class="clinic_pic"><?php echo $this->Html->image('../frontend/images/na.jpg',array('alt'=>'')); ?></div>
                        <div class="upload_clinic_pic">
                        <h2>Attach<br>Image</h2>
                        <div style="height:0px;visibility: hidden;"><?php
                        echo $this->Form->input('attachment_image', array('type'=>'file','onchange'=>"chage_name(this.value)",'id'=>'attachment_image'));
                        ?> </div>
                        <button type="button" type="button" onclick="chooseFile();">Browse</button>
                        <span id="file_data">No File Selected</span>
                        </div>
                        </div>
                        </div>
                        </div>
                        <!--------------------->
                                       
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Heading:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_heading',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'attachment_heading'));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Text:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'user-in-area', 'id' => 'attachment_text','rows'=>'5','cols'=>'5'));
                        ?>
                                              
                        </div>
                        </div>
                        </div>
                                                    
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Url:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_url',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'attachment_url'));
                        ?>
                        </div>
                        </div>
                        </div>
                         
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3 btn-label">&nbsp;</label>
                        <div class="col-xs-12 col-md-9">
                       <!-- <button class="save" id="form_save" onclick="cheking_validation()">Save Changes</button>-->
		       <button class="save" id="form_save">Save Changes</button>
                        <button class="cancel">Cancel</button>
                        </div>
                        </div>
                        </div>                           
                          
                       
        </div>
         </div>
            </div>
                    <?php echo $this->Form->end(); ?>
              

