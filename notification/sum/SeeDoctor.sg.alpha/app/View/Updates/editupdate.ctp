<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/updatesfromtheheart">Updates</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Edit Update</a> 
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
        
        <span>Edit Update Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Update',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                        <fieldset>

                            <div class="control-group">
                                <label class="control-label" for="username">Updates Content*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('text',array('label' => FALSE, 'div' => FALSE, 'type' => 'textarea', 'class' => 'input-fluid ckeditor', 'id' => 'text'));
                                    ?>
                                    
                                </div>
                            </div>

                            

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/updatesfromtheheart'">Cancel</button>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--script for form validation-->
<script>
            //form validation
            
            function do_validate()
            {
                        status=1;
                        
                        t=CKEDITOR.instances.text.getData();
                        if (t=='')
                        {
                                    alert('Update Content field can\'t be null');
                                    document.getElementById('text').focus();
                                    status=0;
                        }
               
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>