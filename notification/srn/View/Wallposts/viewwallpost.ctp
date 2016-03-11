<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinicmanagers">View Wallpost</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        
                    </li>
                </ul>
            </div>
        </div>

<section id="utopia-wizard-form" class="utopia-widget utopia-form-box">
    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>View Wallpost</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <!-------Coding For Image----->

<?php
if(isset($edit_wall_post[0]['Wallpost']['attachment_image']) && $edit_wall_post[0]['Wallpost']['attachment_image']!="")
$post_img = $this->Html->image('../frontend/uploads/wallpost/'.$edit_wall_post[0]['Wallpost']['attachment_image'],array('alt'=>'post_image'));
else
$post_img = '';
?>
<!--------Coding for  image End------>
   <?php echo $this->Form->create('Wallpost',$settings=array('class'=>'form-horizontal','id'=>'wall_post','name'=>'wall_post','enctype'=>'multipart/form-data')); ?>
                    
                     
                        <fieldset>

						<div class="control-group">
                                <label class="control-label" for="username">Post Title:</label>

                                <div class="controls">
                                  <?php
									echo $this->Form->input('post_title',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'post_title','value'=>$edit_wall_post[0]['Wallpost']['post_title'],'disabled'));
									?>   
                                </div>
                            </div>
							
							<div class="control-group">
                                <label class="control-label" for="username">Post:</label>

                                <div class="controls">
                                  <?php
                        echo $this->Form->input('post_main_text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'input-fluid ck_editor', 'id' => 'post_main_text','rows'=>'10','cols'=>'20','value'=>$edit_wall_post[0]['Wallpost']['post_main_text'],'disabled'));
                        ?>
						
                                </div>
                            </div>
                            
                            
                            
                             <div class="control-group">
                                <label class="control-label" for="username">Author Name:</label>

                                <div class="controls">
                                  <?php
									echo $this->Form->input('name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'post_title','value'=>ucwords($edit_wall_post[0]['Wallpost']['alias_fname'].' '.$edit_wall_post[0]['Wallpost']['alias_lname']),'disabled'));
			?>   
             
                                </div>
                            </div>
                            
                             <div class="control-group">
                                <label class="control-label" for="username">Designation:</label>

                                <div class="controls">
                                  <?php
									echo $this->Form->input('designation',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'post_title','value'=>ucwords($edit_wall_post[0]['Wallpost']['alias_designation']),'disabled'));
			?>   
            
                                </div>
                            </div>
                            
                            <div class="utopia-from-action">
                                <button onclick="window.location.href='<?php echo BASE_URL;?>administrator/wallposts'" type="button" class="btn btn-primary span5">Back</button>
                            </div>
                            
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--script for form validation-->
