<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/cmsforpages">CMS For Pages</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Edit Content</a> 
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
        
        <span>Edit Content Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Content',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="page_name">Page Name*:</label>

                                <div class="controls">
                                    
                                    <?php
                                    echo $this->Form->input('page_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'page_name'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="page_title">Page Title*:</label>

                                <div class="controls">
                                    
                                    <?php
                                    echo $this->Form->input('page_title',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'page_title'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content_for_meta_description">Content For Meta Description:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('content_for_meta_description',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'content_for_meta_description'));
                                    ?>
                                    
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="page_title">Page Content*:</label>

                                <div class="controls">
                                    
                                    <?php echo $this->Form->input('content',array('type' => 'textarea','id' => 'content','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                    
                                    
                                </div>
                            </div>

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" onclick="window.location.href='<?php echo BASE_URL;?>administrator/cmsforpages'" type="button">Cancel</button>
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
                        pn=document.getElementById('page_name').value;
                        pt=document.getElementById('page_title').value;
                       
                        pc=CKEDITOR.instances.content.getData();
                       
                        
                        if (pn=='')
                        {
                                    alert('Please input page name');
                                    document.getElementById('page_name').focus();
                                    status=0;
                        }
                        else if (pt=='')
                        {
                                    alert('Please input page title');
                                    document.getElementById('page_title').focus();
                                    status=0;
                        }
                        else if (pc=='')
                        {
                                    alert('Please input page Content');
                                    document.getElementById('content').focus();
                                    status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>