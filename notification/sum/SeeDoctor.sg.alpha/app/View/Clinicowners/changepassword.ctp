<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>clinicmanager/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    
                    <li class='active disabled'>
                        <a href="#" >Change Password</a> 
                    </li>
                </ul>
            </div>
        </div>
<!-- Error Message section Starts-->

<?php
if($message=='changefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Internal Error Occured</h4>
                        Sorry Password Not Updated !!!
            </div>
<?php            
}
else if($message=='changesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Password Successfully updated!!!
            </div>
<?php            
}
?>
<!-- Error Message section Ends-->
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
        
        <span>Change Password Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Clinicowner',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="oldpass">Old Password*:</label>

                                <div class="controls">
                                    <input type='password' name='oldpass' class='input-fluid' id='oldpass' />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="newpass">New Password*:</label>

                                <div class="controls">
                                    <input type='password' name='newpass' class='input-fluid' id='newpass' />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="connewpass">Confirm New Password*:</label>

                                <div class="controls">
                                    <input type='password' name='connewpass' class='input-fluid' id='connewpass' />
                                </div>
                            </div>
                            

                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>clinicmanager'">Cancel</button>
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
                        op=document.getElementById('oldpass').value;
                         
                        np=document.getElementById('newpass').value;
                        cnp=document.getElementById('connewpass').value;
                       
                        var smallletter = /[a-z]/;
                        var capsletter=/[A-Z]/;
                        var number = /[0-9]/;
                        
                        var validop = number.test(op) && smallletter.test(op) && capsletter.test(op);
                        var validnp = number.test(np) && smallletter.test(np) && capsletter.test(np);
                        
                        if (op=='')
                        {
                                    alert('Please enter old password');
                                    document.getElementById('oldpass').focus();
                                    status=0;
                        }
                        else if (!validop)
                        {
                                    alert('Old password must have atleast one number,one uppercase and one lower case letter');
                                    document.getElementById('oldpass').focus();
                                    status=0;
                        }
                        else if (op.length<8)
                        {
                            alert('Old password must be atleast 8 characters long');
                            document.getElementById('oldpass').focus();
                            status=0;
                        }
                        else if (np=='')
                        {
                                    alert('Please enter new password');
                                    document.getElementById('newpass').focus();
                                    status=0;
                        }
                        else if (!validnp)
                        {
                                    alert('New password must have atleast one number,one uppercase and one lower case letter');
                                    document.getElementById('newpass').focus();
                                    status=0;
                        }
                        else if (np.length<8)
                        {
                            alert('New password must be atleast 8 characters long');
                            document.getElementById('newpass').focus();
                            status=0;
                        }
                        else if (np!=cnp)
                        {
                            alert('Confirm password doesnot match with new password');
                             document.getElementById('connewpass').focus();
                            status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
                
                        
            }
</script>