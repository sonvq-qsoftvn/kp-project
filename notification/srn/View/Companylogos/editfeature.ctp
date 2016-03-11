<?php
//$feature=$this->request->data;
pr($feature);
?>
<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    
                    <li class='active disabled'>
                        <a href="#" >Edit Featured In Company Logo</a> 
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
        
        <span>Edit Featured In Company Logo Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                   <?php echo $this->Form->create('Companylogo',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
				   
                    <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="company_name">Company Name*:</label>

                                <div class="controls">
                                     <?php
                                    echo $this->Form->input('company_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'company_name','value'=>$feature['Companylogo']['company_name']));
                                    ?>
                                   
                                    
                                </div>
                            </div>
							
							 <div class="control-group">
                                   <label class="control-label" for="old image">Existing Image:</label>
                                   <div class="controls">
                                        <?php
                                             if($feature['Companylogo']['company_logo']=='')
                                             {
                                                  echo "No image presently";
                                             }
                                             else
                                             {
           echo $this->Html->image('../admin/company_logo/thumb_company_logo/'.$feature['Companylogo']['company_logo'],array('alt'=>'logo'));
                                             }
                                        ?>
                                   </div>
                              </div>

                              
							  <div class="control-group">
                                <label class="control-label" for="company_logo">Company Logo*:</label>

                                <div class="controls">
                                  <input class='input-fluid' id='company_logo' name='company_logo' type='file'/>
                                </div>
							 </div>
							  
                            <div class="control-group">
                                <label class="control-label" for="company_name">Image Type*:</label>

                                                                
                                     <div class="controls">
                                    <?php
									/*if($feature['Companylogo']['company_logo']=='C'){$chk="checked='checked'";}
									else if($feature['Companylogo']['company_logo']=='C'){$chk="checked='checked'";}*/
                                  //echo"aaa=". $feature['Companylogo']['company_logo'];
								    ?>
                             <label class="radio">Company Logo</label>        
<input type="radio" name="image_type" value="C" class="input-fluid" id="image_typeC" <?php if($feature['Companylogo']['image_type']=='C'){echo 'checked';}?>>
 <label class="radio">Banner Image</label>
 <input type="radio" name="image_type" value="B" class="input-fluid" id="image_typeB" <?php if($feature['Companylogo']['image_type']=='B'){echo 'checked';}?>>
                                                                 
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
                        status=1;
                        sn=document.getElementById('company_name').value;
                        spi=document.getElementById('company_logo').value;
						cl=document.getElementById('image_typeC').checked; /*Company Logo*/
                        bi=document.getElementById('image_typeB').checked;/* Banner Image*/
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
						else if (!cl&&!bi)
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