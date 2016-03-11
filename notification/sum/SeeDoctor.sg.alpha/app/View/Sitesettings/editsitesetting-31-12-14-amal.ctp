<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/sitesettings">Site Setting For Pages</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Edit Site Setting</a> 
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
        
        <span>Edit Site Setting Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Sitesetting',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                        <fieldset>
                           
                            <div class="control-group">
                                <label class="control-label" for="field_title">Field Title*:</label>

                                <div class="controls">
                                    
                                    <?php
                                    echo $this->Form->input('field_title',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'field_title'));
                                    ?>
                                    
                                </div>
                            </div>
                           
                            <div class="control-group">
                                <label class="control-label" for="field_value">Field Content*:</label>

                                <div class="controls">
                                    
                                    <?php echo $this->Form->input('field_value',array('type' => 'textarea','id' => 'field_value','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                    
                                    
                                </div>
                            </div>

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" onclick="window.location.href='<?php echo BASE_URL;?>administrator/sitesettings'" type="button">Cancel</button>
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
                        
                        pt=document.getElementById('field_title').value;
                       
                        pc=CKEDITOR.instances.field_value.getData();
                       
                        
                        if (pt=='')
                        {
                                    alert('Please input feild title');
                                    document.getElementById('field_title').focus();
                                    status=0;
                        }
                        else if (pc=='')
                        {
                                    alert('Please input feild content');
                                    document.getElementById('field_value').focus();
                                    status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>