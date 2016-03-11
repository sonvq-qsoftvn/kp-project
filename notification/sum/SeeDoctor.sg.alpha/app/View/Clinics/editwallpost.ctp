<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo '<pre>';
//print_r($edit_wall_post);
//exit;
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
<!-------Coding For Image----->

<?php
if(isset($edit_wall_post[0]['Wallpost']['attachment_image']) && $edit_wall_post[0]['Wallpost']['attachment_image']!="")
$post_img = $this->Html->image('../frontend/uploads/wallpost/'.$edit_wall_post[0]['Wallpost']['attachment_image'],array('alt'=>'post_image'));
else
$post_img = '';
?>
<!--------Coding for  image End------>
   <?php echo $this->Form->create('Wallpost',$settings=array('class'=>'form-horizontal','id'=>'wall_post','name'=>'wall_post','enctype'=>'multipart/form-data')); ?>
   
<div class="container">
    <div class="inner-gapbox-1">
      <div class="add_clinic">
       
 
 
			<div class="form-row">
			<div class="row">
			<label class="col-xs-12 col-md-3">Topic Title*:</label>
			<div class="col-xs-12 col-md-9">
			<?php
			echo $this->Form->input('post_title',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'post_title','value'=>$edit_wall_post[0]['Wallpost']['post_title']));
			?>
			</div>
			</div>
			</div>
 
 
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Topic*:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('post_main_text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'user-in-area', 'id' => 'post_main_text','rows'=>'5','cols'=>'5','value'=>$edit_wall_post[0]['Wallpost']['post_main_text']));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Alias First Name:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_fname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_fname','value'=>$edit_wall_post[0]['Wallpost']['alias_fname']));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Alias Last Name:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_lname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_lname','value'=>$edit_wall_post[0]['Wallpost']['alias_lname']));?>
                        </div>
                        </div>
                        </div>
                                                     
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Alias Designation:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('alias_designation',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'alias_designation','value'=>$edit_wall_post[0]['Wallpost']['alias_designation']));
                        ?>
                        </div>
                        </div>
                        </div>
                                                      
                        
                        
                        <!------------------>
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Image:</label>
                        <div class="col-xs-12 col-md-9">
                        <div class="clinic_pic"><?php echo $post_img; ?></div>
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
                                                
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Heading:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_heading',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'attachment_heading','value'=>$edit_wall_post[0]['Wallpost']['attachment_heading']));
                        ?>
                        </div>
                        </div>
                        </div>
                        
                        
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Text:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'user-in-area', 'id' => 'attachment_text','value'=>$edit_wall_post[0]['Wallpost']['attachment_text'],'rows'=>'5','cols'=>'5'));
                        ?>
			
                        </div>
                        </div>
                        </div>
                                                    
                        <div class="form-row">
                        <div class="row">
                        <label class="col-xs-12 col-md-3">Attachment Url:</label>
                        <div class="col-xs-12 col-md-9">
                        <?php
                        echo $this->Form->input('attachment_url',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'user-in', 'id' => 'attachment_url','value'=>$edit_wall_post[0]['Wallpost']['attachment_url']));
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
              

