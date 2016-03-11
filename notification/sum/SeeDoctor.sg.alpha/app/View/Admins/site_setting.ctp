<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    
                    <li class='active disabled'>
                        <a href="#" >Site settings</a> 
                    </li>
                </ul>
            </div>
        </div>
<!-- Error Message section Starts-->

<?php
if($msg=='changefailure')
{
?>
            <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Internal Error Occured</h4>
                        Sorry settings Not Updated !!!
            </div>
<?php            
}
else if($msg=='changesuccess')
{
?>
            <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <strong>Success!</strong>
                        Settings Successfully updated!!!
            </div>
<?php            
}
?>
<!-- Error Message section Ends-->
<?php
if($msg==array())
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
        
        <span>Site settings Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Admin',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="oldpass">Sitename*:</label>

                                <div class="controls">
                                    <input type='text' name='SITENAME' value="<?php echo $SITENAME ?>" class='input-fluid' id='sitename' />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="newpass">Metatitle*:</label>

                                <div class="controls">
                                    <input type='text' name='METATITLE' value="<?php echo $METATITLE ?>" class='input-fluid' id='metatitle' />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="connewpass">Metadetails*:</label>

                                <div class="controls">
                                   <textarea name='METADATA' class='input-fluid' id='metadetails'><?php echo $METADATA ?></textarea>
                                </div>
                            </div>
                            
                              <!--<div class="control-group">
                                <label class="control-label" for="connewpass">Contact Address *:</label>

                                <div class="controls">
                                   <textarea name='contact_address' class='input-fluid' id='contact_address'><?php echo $contact_address ?></textarea>
                                </div>
                            </div>
                              
                              <div class="control-group">
                                <label class="control-label" for="connewpass">Contact Phone No *:</label>

                                <div class="controls">
                                   <input type='text' name='contact_phone' value="<?php echo $contact_phone ?>" class='input-fluid' id='contact_phone' />
                                </div>
                            </div>-->
                              
                              <div class="control-group">
                                <label class="control-label" for="connewpass">Site Email Id *:</label>

                                <div class="controls">
                                    <input type='text' name='site_mail_id' value="<?php echo $site_mail_id ?>" class='input-fluid' id='site_mail_id' />
                                </div>
                            </div>
                              
                              <div class="control-group">
                                <label class="control-label" for="connewpass">Contact Email Id *:</label>

                                <div class="controls">
                                    <input type='text' name='contact_email_id' value="<?php echo $contact_email_id ?>" class='input-fluid' id='contact_email_id' />
                                </div>
                            </div>
                            
                              <div class="control-group">
                                <label class="control-label" for="connewpass">User record (Front)*:</label>

                                <div class="controls">
                                    <input type='text' name='user_record' value="<?php echo $user_record ?>" class='input-fluid' id='user_record' />
                                </div>
                            </div>
                              
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Facebook Link *:</label>

                                <div class="controls">
                                    <input type='text' name='Facebook_Link' value="<?php echo $Facebook_Link ?>" class='input-fluid' id='Facebook_Link' />
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Twitter Link *:</label>

                                <div class="controls">
                                    <input type='text' name='TWITTER_LINK' value="<?php echo $TWITTER_LINK ?>" class='input-fluid' id='TWITTER_LINK' />
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Youtube Link *:</label>

                                <div class="controls">
                                    <input type='text' name='YOUTUBE_LINK' value="<?php echo $YOUTUBE_LINK ?>" class='input-fluid' id='YOUTUBE_LINK' />
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Google+ Link *:</label>

                                <div class="controls">
                                    <input type='text' name='GOOGLE_LINK' value="<?php echo $GOOGLE_LINK ?>" class='input-fluid' id='GOOGLE_LINK' />
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Facebook app id *:</label>

                                <div class="controls">
                                    <input type='text' name='facebook_app_id' value="<?php echo $facebook_app_id ?>" class='input-fluid' id='facebook_app_id' />
                                </div>
                            </div>
                               
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Get In Touch Text *:</label>

                                <div class="controls">
                                    <textarea name='GIT_TEXT' class='input-fluid' id='GIT_TEXT' ><?php echo htmlentities($GIT_TEXT) ?></textarea>
                                </div>
                            </div>
                               
                               <!--<div class="control-group">
                                <label class="control-label" for="connewpass">Featured In Text *:</label>

                                <div class="controls">
                                    <textarea name='FEVENT_TEXT' class='input-fluid' id='FEVENT_TEXT' ><?php echo htmlentities($FEVENT_TEXT) ?></textarea>
                                </div>
                            </div>-->
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">File upload limit *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="4" name='max_file_uplimit' value="<?php echo $max_file_uplimit ?>" class='input-fluid' id='max_file_uplimit' />
                                    <label>Only numbers are allow</label>
                                </div>
                            </div>
                               
                               <!--<div class="control-group">
                                <label class="control-label" for="connewpass">Get In Touch Content *:</label>

                                <div class="controls">
                                    <textarea name='GIT_CONT' class='input-fluid' id='GIT_CONT' ><?php echo htmlentities($GIT_CONT) ?></textarea>
                                </div>
                            </div>-->
                               
                               <!--<div class="control-group">
                                <label class="control-label" for="connewpass">Get advice *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="100" name='get_advice' value="<?php echo $get_advice ?>" class='input-fluid' id='get_advice' />
                                    <label>Maximum 100 characters</label>
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Share your story *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="100" name='share_story' value="<?php echo $share_story ?>" class='input-fluid' id='share_story' />
                                    <label>Maximum 100 characters</label>
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Homeowner profile *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="200" name='homeowner_profil' value="<?php echo $homeowner_profile ?>" class='input-fluid' id='homeowner_profil' />
                                    <label>Maximum 200 characters</label>
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Professional profile *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="200" name='professional_profil' value="<?php echo $professional_profile ?>" class='input-fluid' id='professional_profil' />
                                    <label>Maximum 200 characters</label>
                                </div>
                            </div>
                               
                               <div class="control-group">
                                <label class="control-label" for="connewpass">Contact us page *:</label>

                                <div class="controls">
                                    <input type='text' maxlength="200" name='contact_text' value="<?php echo $contact_text ?>" class='input-fluid' id='contact_text' />
                                    <label>Maximum 200 characters</label>
                                </div>
                            </div>-->
                               
                                
                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator'">Cancel</button>
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
                        
                        var sn=document.getElementById('sitename').value;
                        var mt=document.getElementById('metatitle').value;
                        var md=document.getElementById('metadetails').value;
                        //var ca=document.getElementById('contact_address').value;
                        var sm=document.getElementById('site_mail_id').value;
                        var ce=document.getElementById('contact_email_id').value;
                        var ur=document.getElementById('user_record').value;
                        var fl=document.getElementById('Facebook_Link').value;
                        var tl=document.getElementById('TWITTER_LINK').value;
                        var yl=document.getElementById('YOUTUBE_LINK').value;
                        var fai=document.getElementById('facebook_app_id').value;
                        
                        var gl=document.getElementById('GOOGLE_LINK').value;
                        var gt=document.getElementById('GIT_TEXT').value;
                        var ft=document.getElementById('FEVENT_TEXT').value;
                        var gc=document.getElementById('GIT_CONT').value;
                       
                        
                        if (sn.search(/\S/)==-1)
                        {
                                    alert('Please enter sitename');
                                    document.getElementById('sitename').focus();
                                    status=0;
                        }
                        else if (mt.search(/\S/)==-1)
                        {
                                    alert('Please enter metatitle');
                                    document.getElementById('metatitle').focus();
                                    status=0;
                        }
                        else if (md.search(/\S/)==-1)
                        {
                                    alert('Please enter metadetails');
                                    document.getElementById('metadetails').focus();
                                    status=0;
                        }
                        else if (sm.search(/\S/)==-1)
                        {
                                    alert('Please enter site main id');
                                    document.getElementById('site_mail_id').focus();
                                    status=0;
                        }
                        else if (ce.search(/\S/)==-1)
                        {
                                    alert('Please enter contact email id');
                                    document.getElementById('contact_email_id').focus();
                                    status=0;
                        }
                        else if (ur.search(/\S/)==-1)
                        {
                                    alert('Please enter user record');
                                    document.getElementById('user_record').focus();
                                    status=0;
                        }
                        else if (fl.search(/\S/)==-1)
                        {
                                    alert('Please enter facebook link');
                                    document.getElementById('Facebook_Link').focus();
                                    status=0;
                        }
                        else if (tl.search(/\S/)==-1)
                        {
                                    alert('Please enter twitter link');
                                    document.getElementById('TWITTER_LINK').focus();
                                    status=0;
                        }
                        else if (gl.search(/\S/)==-1)
                        {
                                    alert('Please enter google link');
                                    document.getElementById('GOOGLE_LINK').focus();
                                    status=0;
                        }
                        else if (yl.search(/\S/)==-1)
                        {
                                    alert('Please enter youtube link');
                                    document.getElementById('YOUTUBE_LINK').focus();
                                    status=0;
                        }
                        else if (fai.search(/\S/)==-1)
                        {
                                    alert('Please enter facebook app id');
                                    document.getElementById('facebook_app_id').focus();
                                    status=0;
                        }
                        else if (gt.search(/\S/)==-1)
                        {
                                    alert('Please enter get in touch text');
                                    document.getElementById('GIT_TEXT').focus();
                                    status=0;
                        }
                        else if (ft.search(/\S/)==-1)
                        {
                                    alert('Please enter Featured In Text');
                                    document.getElementById('FEVENT_TEXT').focus();
                                    status=0;
                        }
                        else if (gc.search(/\S/)==-1)
                        {
                                    alert('Please enter Get In Touch Content ');
                                    document.getElementById('GIT_CONT').focus();
                                    status=0;
                        }
                        //alert('arijit '+status);
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
                
                        
            }
</script>