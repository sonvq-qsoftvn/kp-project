<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinicmanagers">Clinic Managers</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Add Clinic Manager</a> 
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
        
        <span>Add Clinic Manager Form</span>
    </div>
    
<img src="<?php echo BASE_URL?>Clinicmanager/captcha_fetch"  />

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Clinicmanager',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation'));
                   
                    ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_fname">First Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_fname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'clinicmanagers_fname'));
                                    
                                    ?>
                                    
                                </div>
                                                                
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_lname">Last Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_lname',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'clinicmanagers_lname'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_username">User Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_username',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'clinicmanagers_username'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_email">Email*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_email',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'clinicmanagers_email'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_password">Password*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_password',array('label' => FALSE, 'div' => FALSE, 'type' => 'password', 'class' => 'input-fluid', 'id' => 'clinicmanagers_password'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="confirm_pass">Confirm Password*:</label>

                                <div class="controls">
                                    <input type='password' class='input-valid' id='confirm_pass' style='width:80%;'/>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="confirm_pass">Gender*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_gender',array('legend'=>FALSE,'label' => FALSE, 'div' => FALSE, 'type' => 'radio','before' =>'<label class=\'radio\'>',
    'after' => '</label>',
    'between' => '&nbsp;&nbsp;',
    'separator' => '</label><label class=\'radio\'>', 'class' => 'input-fluid','id' => 'clinicmanagers_gender','options'=>array('M'=>'Male','F'=>'Female')));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_date_of_birth">D.O.B.*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_date_of_birth',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-medium', 'id' => 'clinicmanagers_date_of_birth','value'=>date('1990/06/13')));
                                    ?>
                                 
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmanagers_hand_phone">Hand Phone Number*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('clinicmanagers_hand_phone',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'clinicmanagers_hand_phone'));
                                    ?>
                                    
                                    
                                </div>
                            </div>

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinicmanagers'">Cancel</button>
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
                        fn=document.getElementById('clinicmanagers_fname').value;
                        ln=document.getElementById('clinicmanagers_lname').value;
                        un=document.getElementById('clinicmanagers_username').value;
                        p=document.getElementById('clinicmanagers_password').value;
                        cp=document.getElementById('confirm_pass').value;
                        e=document.getElementById('clinicmanagers_email').value;
                        gm=document.getElementById('clinicmanagers_genderM').checked;
                        gf=document.getElementById('clinicmanagers_genderF').checked;
                        dob=document.getElementById('clinicmanagers_date_of_birth').value;
                        hp=document.getElementById('clinicmanagers_hand_phone').value;
                        var alphaExp = /^[a-zA-Z]+$/;
                        var re = /^[a-zA-Z0-9_]+$/;
                        var emailExp=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                        var phExp=/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
                        if (fn=='')
                        {
                                    alert('First name field can\'t be null');
                                    document.getElementById('clinicmanagers_fname').focus();
                                    status=0;
                        }
                        else if (!fn.match(alphaExp))
                        {
                                 alert('Only alphabets allowed in firstname');
                                 document.getElementById('clinicmanagers_fname').focus();
                                 status=0;   
                        }
                        else if (ln=='')
                        {
                                    alert('Last name field can\'t be null');
                                    document.getElementById('clinicmanagers_lname').focus();
                                    status=0;
                        }
                        else if (!ln.match(alphaExp))
                        {
                                 alert('Only alphabets allowed in lastname');
                                 document.getElementById('clinicmanagers_lname').focus();
                                 status=0;   
                        }
                        else if (un=='')
                        {
                                    alert('Username field can\'t be null');
                                    document.getElementById('clinicmanagers_username').focus();
                                    status=0;
                        }
                        else if (!un.match(re))
                        {
                                 alert('Only alphabets,numbers and underscore allowed in username');
                                 document.getElementById('clinicmanagers_username').focus();
                                 status=0;   
                        }
                        else if (e=='')
                        {
                                    alert('Email field can\'t be null');
                                    document.getElementById('clinicmanagers_email').focus();
                                    status=0;
                        }
                        else if (!e.match(emailExp))
                        {
                                 alert('Invalid Email');
                                 document.getElementById('clinicmanagers_email').focus();
                                 status=0;   
                        }
                        else if (p=='')
                        {
                                    alert('Password field can\'t be null');
                                    document.getElementById('clinicmanagers_password').focus();
                                    status=0;
                        }
                        else if (p.length<8)
                        {
                                 alert('Password must be  minimum 8 characters long');
                                 document.getElementById('clinicmanagers_password').focus();
                                 status=0;   
                        }
                        else if (p==un||p==fn||p==ln)
                        {
                                    alert('Password must not be same with username, firstname, or last name');
                                    document.getElementById('clinicmanagers_password').focus();
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
                                    document.getElementById('clinicmanagers_genderM').focus();
                                    status=0;
                                    
                        }
                        else if (dob=='')
                        {
                                    alert('Date of birth invalid');
                                    document.getElementById('clinicmanagers_date_of_birth').focus();
                                    status=0;         
                        }
                        else if (hp=='')
                        {
                                    alert('Hand phone field can\'t be null');
                                    document.getElementById('clinicmanagers_hand_phone').focus();
                                    status=0;
                        }
                        else if (!hp.match(phExp))
                        {
                                 alert('Invalid hand phone');
                                 document.getElementById('clinicmanagers_hand_phone').focus();
                                 status=0;   
                        }
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>

