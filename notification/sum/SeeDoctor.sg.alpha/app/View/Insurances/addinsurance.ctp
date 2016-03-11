<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/insurancemaster">Insurance Master</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Add Insurance</a> 
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
        
        <span>Add Insurance Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Insurance',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="insurances_name">Insurance Name*:</label>

                                <div class="controls">
                                    
                                    <?php
                                    echo $this->Form->input('insurances_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'insurances_name'));
                                    ?>
                                    
                                </div>
                            </div>
                            
                         <div class="control-group utopia-chosen-label">
                                <label class="control-label" for="insurance_parent_id">Select Parent:</label>

                                <div class="controls">
                                    <?php
                                        $options_arr=array();
                                       foreach($all_insurance as $k=>$v)
                                        {
                                           $options_arr[$v['Insurance']['id']]=$v['Insurance']['insurances_name'];
                                        }
                                         
                                        echo $this->Form->input('insurance_parent_id',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'insurance_parent_id', 'options'=>$options_arr,'tabindex'=>7,'style'=>'width:60%;','data-placeholder'=>'Parent Insurance','class'=>'chzn-select-deselect'));
                                    ?>
                                    
                                </div>
                        </div>

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/insurancemaster'">Cancel</button>
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
                        inn=document.getElementById('insurances_name').value;

                        if (inn=='')
                        {
                                    alert('Insurance name field can\'t be null');
                                    document.getElementById('insurances_name').focus();
                                    status=0;
                        }
    
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>