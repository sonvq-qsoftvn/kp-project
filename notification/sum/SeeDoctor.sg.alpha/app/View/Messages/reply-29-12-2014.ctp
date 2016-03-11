<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">|</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Reply Message</a> 
                    </li>
                    
                </ul>
            </div>
        </div>


<section id="utopia-wizard-form" class="utopia-widget utopia-form-box">
    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>Reply Message</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Message',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation', 'method'=>'post' )); ?>
                        
                        <fieldset>
                                   
                            <div class="control-group">
                                <label class="control-label" for="select_type"><!--Select Type*:--></label>

                                <div class="controls">
                                    
                                    <?php
                                    if(isset($reply_data_msg) && !empty($reply_data_msg['Message']))
                                    {
                                                $type="";
                                                $name="";
                                                $user_id="";
                                                $id=$reply_data_msg['Message']['id'];
                                         if($reply_data_msg['User']['id']!='')
                                         {
                                                $type='user';
                                                $name=$reply_data_msg['User']['username'];
                                                $user_id=$reply_data_msg['User']['id'];
                                                
                                         }       
                                         else if($reply_data_msg['Clinicmanager']['id']!='')
                                                {
                                                            $type='Clinicmanager';
                                                            $name=$reply_data_msg['Clinicmanager']['clinicmanagers_username'];
                                                             $user_id=$reply_data_msg['Clinicmanager']['id'];
                                                             
                                                            
                                                }
                                                
                                       
                                      // echo $this->Form->input('type',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'select_type', 'options'=>$type,'style'=>'width:35%; display:none;','data-placeholder'=>'Select Type','class'=>'chzn-select-deselect'));
                                     echo $this->Form->input('type',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'value'=>$type, 'class' => 'input-fluid', 'id' =>'select_type','readonly' => 'readonly' )); 
                                                                           
                                    
                                    ?> 
                                    
                                </div>
                            </div>
                            
                            
                            <!-------------Ajax Div For select user--------------->
                                    
                        <div class="control-group">
                                <label class="control-label" for="select_sender_name"><!--Select Sender name*:--></label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('sender_name',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'value'=>$name, 'class' => 'input-fluid', 'id' =>'sender_name','readonly' => 'readonly' )); 
                                    ?>
                                    
                                </div>
                            </div>
                       
                               <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">    
                               <input type="hidden" name="message_id" id="message_id" value="<?php echo $id; ?>">     
                        
                        
                         <?php }?>
                        <!-------------End Ajax Div- -------------->     
                             
                             <?php
                             if(isset($reply_data_msg) && $reply_data_msg['Messagecontent']['subject'])
                             {
                               $subject=$reply_data_msg['Messagecontent']['subject'];     
                             }else{
                                $subject="";    
                             }
                             ?>
                           
                             
                            <div class="control-group">
                                <label class="control-label" for="subject">Subject:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('subject',array('label' => FALSE, 'div' => FALSE,'value'=>$subject, 'type' => 'text', 'class' => 'input-fluid', 'id' =>'subject','readonly' => 'readonly' )); 
                                    ?>
                                    
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="message">Message*:</label>

                                <div class="controls">
                                    
                                    
                                    <?php echo $this->Form->input('messagebody',array('type' => 'textarea','id' => 'messagebody','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' =>'input-fluid ck_editor')); ?>
                                    
                                </div>
                            </div>
                              
                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Send</button>
                               <button class="btn span5" onclick="window.location.href='<?php echo BASE_URL;?>administrator'" type="button">Cancel</button>
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
                       var subject=document.getElementById('subject').value;
                       
                      var messagebody=CKEDITOR.instances.messagebody.getData();
                       
                       //alert(messagebody);
                         
                        if (subject=='')
                        {
                                    alert('Please give a subjet');
                                    document.getElementById('subject').focus();
                                    status=0;
                        }
                        else if (messagebody=='')
                        {
                                    alert('Please input message Content');
                                    document.getElementById('messagebody').focus();
                                    status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>






