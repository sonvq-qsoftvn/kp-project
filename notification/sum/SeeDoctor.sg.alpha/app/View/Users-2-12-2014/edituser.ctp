<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinicmanagers">Users</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Add User</a> 
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
        
        <span>Add User Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('User',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                         <?php
                                   echo $this->Form->input('id',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'class' => 'input-fluid', 'id' => 'id'));
                                   
                                   echo $this->Form->input('password',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'class' => 'input-fluid', 'id' => 'password'));
                                   echo $this->Form->input('confirm_pass',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'class' => 'input-fluid', 'id' => 'confirm_pass', 'value' => $conf_password));
                          ?>
                    
                        <fieldset>

                            <div class="control-group">
                                <label class="control-label" for="username">User Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('username',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'username'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="email">Email*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('email',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'email'));
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="confirm_pass">Gender*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('gender',array('legend'=>FALSE,'label' => FALSE, 'div' => FALSE, 'type' => 'radio','before' =>'<label class=\'radio\'>',
    'after' => '</label>',
    'between' => '&nbsp;&nbsp;',
    'separator' => '</label><label class=\'radio\'>', 'class' => 'input-fluid','id' => 'gender','options'=>array('M'=>'Male','F'=>'Female')));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="date_of_birth">D.O.B.*:</label>

                                <div class="controls">
                                    <?php
                                    
                                    echo $this->Form->input('date_of_birth',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-medium', 'id' => 'date_of_birth','value'=>($date_of_birth)?$date_of_birth:date('Y/m/d')));
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/users'">Cancel</button>
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
                        
                        un=document.getElementById('username').value;
                        p=document.getElementById('password').value;
                        cp=document.getElementById('confirm_pass').value;
                        e=document.getElementById('email').value;
                        gm=document.getElementById('genderM').checked;
                        gf=document.getElementById('genderF').checked;
                        dob=document.getElementById('date_of_birth').value;
                       
                        var alphaExp = /^[a-zA-Z]+$/;
                        var re = /^[a-zA-Z0-9_]+$/;
                        var emailExp=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                        var phExp=/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
                        if (un=='')
                        {
                                    alert('Username field can\'t be null');
                                    document.getElementById('username').focus();
                                    status=0;
                        }
                        else if (!un.match(re))
                        {
                                 alert('Only alphabets,numbers and underscore allowed in username');
                                 document.getElementById('username').focus();
                                 status=0;   
                        }
                        else if (e=='')
                        {
                                    alert('Email field can\'t be null');
                                    document.getElementById('email').focus();
                                    status=0;
                        }
                        else if (!e.match(emailExp))
                        {
                                 alert('Invalid Email');
                                 document.getElementById('email').focus();
                                 status=0;   
                        }
                        else if (p=='')
                        {
                                    alert('Password field can\'t be null');
                                    document.getElementById('password').focus();
                                    status=0;
                        }
                        else if (p.length<8)
                        {
                                 alert('Password must be  minimum 8 characters long');
                                 document.getElementById('password').focus();
                                 status=0;   
                        }
                        else if (p==un)
                        {
                                    alert('Password must not be same with username');
                                    document.getElementById('password').focus();
                                    status=0;      
                        }
                        else if (cp=='')
                        {
                                    alert('Confirm password field can\'t be null');
                                    document.getElementById('confirm_pass').focus();
                                    status=0;
                        }
                        else if (p!=cp)
                        {
                                    alert('Confirm password must match with password');
                                    document.getElementById('confirm_pass').focus();
                                    status=0;      
                        }
                        else if (!gm&&!gf)
                        {
                                    alert('Please select atleast one gender');
                                    document.getElementById('genderM').focus();
                                    status=0;
                                    
                        }
                        else if (dob=='')
                        {
                                    alert('Date of birth invalid');
                                    document.getElementById('date_of_birth').focus();
                                    status=0;         
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>