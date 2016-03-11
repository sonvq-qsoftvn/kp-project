<script>
		  function img_res_change(args) {
				    if (args == 'C') {
							 $('#img_res_type').html('Preferred image resolution 150X30px');
				    }
				    else if (args == 'B') {
							 $('#img_res_type').html('Preferred image resolution 360X460px');
				    }
				    else if (args == 'F') {
							 $('#img_res_type').html('Preferred image resolution 320X350px');
				    }
				    else{
							 $('#img_res_type').html('Please upload square image for better visuality.');
				    }
		  }
</script>

<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/  </span><a href="<?php echo BASE_URL;?>administrator/listfeaturein">Feature Image</a> <span class="divider">/  </span>
                    </li>
                    
                    <li class='active disabled'>
                        <a href="#" >Add Featured In Company</a> 
                    </li>
                </ul>
            </div>
        </div>
<?php
if($msg!=array())
{
?>
<div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        <ul>
                                    
                        <?php
                        foreach($msg as $k=>$v)
                        {
                        ?>
                                                <li><?php echo $v;?></li>
                                    
                        <?php
                                    
                        }
                        ?>
                        </ul>
            </div>
<?php
}
?>

<section id="utopia-wizard-form" class="utopia-widget utopia-form-box">
    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>Add Company Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Companylogo',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="company_name">Name*:</label>

                                <div class="controls">
                                   
                                    <?php
                                    echo $this->Form->input('company_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'company_name'));
                                    ?>
                                    
                                </div>
                            </div>
                            
				    <div class="control-group">
                                <label class="control-label" for="company_name">Image Type*:</label>

                                                                
                                     <div class="controls">
                                    <?php
							 $options = $options1 = array();
							 if($total_company_logo < 5)
							 {
									   $options['C'] = 'Featured Company Logo';
							 }
							 else{
									   $options1[] = '<input type="hidden" id="image_typeC" value="C">Maximum number of upload limit reached for Company Logos'; 
							 }
							 if($total_banner_logo < 5)
							 {
									   $options['B'] = 'Main Banner Image';
							 }
							 else{
									   $options1[] = '<input type="hidden" id="image_typeB" value="B">Maximum number of upload limit reached for Main Banner Images'; 
							 }
							 if($total_banner_logo < 1)
							 {
									   $options['F'] = 'GET IN TOUCH Image';
							 }
							 else{
									   $options1[] = '<input type="hidden" id="image_typeF" value="F">Maximum number of upload limit reached for GET IN TOUCH Image'; 
							 }
							 
							 if(!empty($options))
							 {
		  							   echo $this->Form->input('image_type',array('legend'=>FALSE,'label' => FALSE, 'div' => FALSE, 'type' => 'radio','before' =>'<label class=\'radio\'>',
			 'after' => '</label>',
			 'between' => '&nbsp;&nbsp;',
			 'separator' => '</label><label class=\'radio\'>', 'class' => 'input-fluid','id' => 'image_type','options'=> $options, 'onchange' => 'img_res_change(this.value)'));
									   echo implode('<br>', $options1);
									   
							 }
							 else{
									   echo 'Maximum number of upload limit reached for Company Logos, Banner Images & GET IN TOUCH Image.<br>';
							 }

                                    ?>
                                </div>
                            </div>

					   
                            <div class="control-group">
                                <label class="control-label" for="company_logo">Image*:</label>

                                <div class="controls">
				    <input class='input-fluid' id='company_logo' name='company_logo' type='file'/>
                                   <p id="img_res_type">Please upload square image for better visuality.</p>
                                </div>
                            </div>
                            
				

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type='button' onclick="window.location.href='<?php echo BASE_URL;?>administrator/listfeaturein'">Cancel</button>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
            //form validation
            
            function do_validate()
            {
                        var status=1;
                        var sn=document.getElementById('company_name').value;
                        var spi=document.getElementById('company_logo').value;
			var cl=document.getElementById('image_typeC').checked; /*Company Logo*/
                        var bi=document.getElementById('image_typeB').checked;/* Banner Image*/
			var fi=document.getElementById('image_typeF').checked;/* Footer Image*/
                        if (sn=='')
                        {
                                    alert('Please enter company name');
                                    document.getElementById('company_name').focus();
                                    status=0;
                        }
                        else if (spi=='')
                        {
                                    alert('Select company logo');
                                    document.getElementById('company_logo').focus();
                                    status=0;
                        }
			
			else if (!cl&&!bi&&!fi)
                        {
                                    alert('Please select atleast one image type');
                                    document.getElementById('image_typeC').focus();
                                    status=0;
                                    
                        }
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>