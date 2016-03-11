
<section class="emai-registration">
    <div class="topheading-box">
       <div class="container">
             <h2>Message</h2>
       </div>
    </div>
    
      <div class="container">
	<h4 style='color:red;'><?php echo $this->Session->flash();?></h4>
      	<div class="msg_container">
            <div class="msg_nav">
             <!--   <ul>
                    <li class="inbox_active"><a href="<?php echo BASE_URL;?>messages/MessageInbox">Inbox</a></li>
                    <li class="compose"><a href="<?php echo BASE_URL;?>messages/conversation/9/Clinicmanager">Compose</a></li>
                    <li class="outbox"><a href="<?php echo BASE_URL;?>messages/MessageOutbox" >Outbox</a></li>
                    <li class="draft"><a href="<?php echo BASE_URL;?>messages/MessageTrash">Trash</a></li>
                </ul>-->
	    <?php echo $this->element("frontend/message_tab");?>
		
               <!-- <div class="all_msg">
                    <select class="custom-select" style="width:220px;">
                        <option value="">All Messages (5)</option>
                        <option value="">test 1</option>
                        <option value="">test 2</option>
                        <option value="">test 3</option>
                    </select>
                </div>-->
            </div>
            <div class="msg_table">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="msg_info">
                 
                 
              <?php if(!empty($all_messages_inbox)) 
                  {
       
                    foreach($all_messages_inbox as $all_messages_inboxs)
                    {
			//pr($all_messages_inboxs);
			
       
                 ?>   
                 
                <tr class="msg_info_cont">
                    <td class="col-1"><div class="picdetails"><b style='color:#522900;'><?php if($all_messages_inboxs['Messagecontent']['fromtype']=='superadmin'){echo ($from_users['admin'][$all_messages_inboxs['Messagecontent']['fromid']]['Admin']['admin_email']); ?></b><br/><font style='color:#CC5252'><?php echo ucfirst('superadmin');}else{ $all_types=array('User','Clinic Manager');echo ($from_users['user'][$all_messages_inboxs['Messagecontent']['fromid']]['User']['email']); ?></b><br/><font style='color:#CC5252'><?php echo ucfirst($all_types[$from_users['user'][$all_messages_inboxs['Messagecontent']['fromid']]['User']['user_type']-1]); }?></font><br><font style='color:#003300'><?php $ret_str=($this->Functions->calculate_time_gap(date('Y-m-d H:i:s'),$all_messages_inboxs['Messagecontent']['datesent']));if($ret_str['Y']!=0||$ret_str['M']!=0){echo "Nearly ";} if($ret_str['Y']!=0){ echo $ret_str['Y'].' Year'; if($ret_str['Y']>1){echo 's';}}if($ret_str['M']!=0){ echo ' '.$ret_str['M'].' Month'; if($ret_str['M']>1){echo 's';}}if($ret_str['d']!=0){ echo ' '.$ret_str['d'].' Day'; if($ret_str['d']>1){echo 's ';}}if($ret_str['h']!=0){ echo ' '.$ret_str['h'].' Hour'; if($ret_str['h']>1){echo 's ';}}if($ret_str['m']!=0){ echo ' '.$ret_str['m'].' Minute'; if($ret_str['m']>1){echo 's ';}}if($ret_str['Y']!=0||$ret_str['M']!=0||$ret_str['d']!=0||$ret_str['h']!=0||$ret_str['m']!=0){echo ' ago ';}else{echo 'Just Now';}?></font></div></td>
                    
                    
                    <td class="col-2"><a href="<?php echo BASE_URL;?>messages/conversation/<?php echo $all_messages_inboxs['Messagecontent']['fromid'];?>/<?php echo $all_messages_inboxs['Messagecontent']['fromtype'];?>/<?php echo $all_messages_inboxs['Message']['id'];?>/thismsg"><?php echo $all_messages_inboxs['Messagecontent']['subject'] ?></a></td>
                    <td class="col-3">
                        <?php echo $this->Html->image('../frontend/images/icon36.jpg',array('alt'=>'')); ?> 
                         
                        
                        <div><?php echo  date('d.m.Y',strtotime($all_messages_inboxs['Messagecontent']['datesent']))?></div></td>
                    <td class="col-4"> <?php echo $this->Html->image('../frontend/images/icon37.jpg',array('alt'=>'')); ?> <div><?php echo  date('h.i  A',strtotime($all_messages_inboxs['Messagecontent']['datesent']))?></div></td>
                    <td class="col-5">
			<span>
			    <a href="<?php echo BASE_URL;?>messages/conversation/<?php echo $all_messages_inboxs['Messagecontent']['fromid'];?>/<?php echo $all_messages_inboxs['Messagecontent']['fromtype'];?>/<?php echo $all_messages_inboxs['Message']['id'];?>/thismsg"><?php echo $this->Html->image('../frontend/images/icon35.jpg',array('alt'=>'')); ?></a>
                         </span>
			<!--<span><a href="#">
                                <?php //echo $this->Html->image('../frontend/images/icon34.jpg',array('alt'=>'')); ?>   
                            </a></span>-->
                        
                        <span><a onclick="return confirm('Are you sure to delete this Message?')"  href="<?php echo BASE_URL.'messages/MessageDelete/id:'.$all_messages_inboxs['Message']['id'] ?>" class="initialism rescheduleapp_open">
                                    
                                   <?php echo $this->Html->image('../frontend/images/icon33.jpg',array('alt'=>'')); ?>  
                                    
                                </a></span>
                    </td>
                </tr>
                
                
                  <?php } }
		  else
		  {
		    echo "<h3 style='padding-left:30px;'>No message in inbox</h3>";
		  }
		  ?>
                
               
            </table>
           </div>
          
	   
	   <div class="span6">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul>
                                                            <?php
                                                                
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->prev(
                                                                  ' ←',
                                                                  $options=array('tag'=>'li','class'=>'prev','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'prev disabled')
                                                                );
                                                                
                                                                // Shows the page numbers
                                                                echo $this->Paginator->numbers($options=array('tag'=>'li','separator'=>'','currentTag'=>'a','currentClass'=>'active'));
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->next(
                                                                  '→ ',
                                                                  $options=array('tag'=>'li','class'=>'next','disabledTag'=>'a'),
                                                                  null,
                                                                  array('tag'=>'li','disabledTag'=>'a','class'=>'next disabled')
                                                                );
                    
                                                            ?>
                                                </ul>
                                    </div>
                                </div>
          
      </div>
          
 
          
    </section>
