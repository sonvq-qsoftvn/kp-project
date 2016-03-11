<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<section class="emai-registration">
    <div class="topheading-box">
       <div class="container">
             <h2>Message</h2>
       </div>
    </div>
      <div class="container">
      	<div class="msg_container">
            <div class="msg_nav">
                <ul>
                   <li class="inbox_active"> <a href="<?php echo BASE_URL;?>messages/inbox_message" > Inbox</a>         
                    </li>
                    <li class="compose"><a href="#">Compose</a></li>
                    <li class="outbox"><a href="<?php echo BASE_URL;?>messages/outbox_message" >Outbox</a></li>                     
                    <li class="draft"><a href="<?php echo BASE_URL;?>messages/draft_message">Draft</a></li>
                </ul>
                <div class="all_msg">
                    <select class="custom-select" style="width:220px;">
                        <option value="">All Messages (5)</option>
                        <option value="">test 1</option>
                        <option value="">test 2</option>
                        <option value="">test 3</option>
                    </select>
                </div>
            </div>
            <div class="msg_table">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="msg_info">
                 
                 
              <?php if(!empty($all_messages_inbox)) 
                  {
        
                    foreach($all_messages_inbox as $all_messages_inboxs)
                    {
       
                 ?>   
                 
                <tr class="msg_info_cont">
                    <td class="col-1"><div class="pic">
                          <?php echo $this->Html->image('../frontend/images/pic11.jpg',array('alt'=>'')); ?>                   
                        </div><div class="picdetails"><?php echo $all_messages_inboxs['Messagecontent']['fromuname'] ?><br>1 days ago</div></td>
                    
                    
                    <td class="col-2"><?php echo $all_messages_inboxs['Messagecontent']['message'] ?></td>
                    <td class="col-3">
                        <?php echo $this->Html->image('../frontend/images/icon36.jpg',array('alt'=>'')); ?> 
                         
                        
                        <div><?php echo  date('d.m.Y',strtotime($all_messages_inboxs['Messagecontent']['datesent']))?></div></td>
                    <td class="col-4"> <?php echo $this->Html->image('../frontend/images/icon37.jpg',array('alt'=>'')); ?> <div>09.30 AM</div></td>
                    <td class="col-5"><span><a href="#">
                                <?php echo $this->Html->image('../frontend/images/icon35.jpg',array('alt'=>'')); ?> 
                               
                            </a></span><span><a href="#">
                                <?php echo $this->Html->image('../frontend/images/icon34.jpg',array('alt'=>'')); ?>     
                                    
                               
                            </a></span><span><a href="#" class="initialism rescheduleapp_open">
                                    
                                   <?php echo $this->Html->image('../frontend/images/icon33.jpg',array('alt'=>'')); ?>  
                                    
                                </a></span></td>
                </tr>
                
                
                  <?php } } ?>
                
               
            </table>
           </div>
           <div class="msg_table_pagination">
           
           	
               
<!--               <a href="#" class="prev">&nbsp;</a>
           	<a href="#" class="page_active">1</a>
                <a href="#" class="page">2</a>
                <a href="#" class="page">3</a>
                <a href="#" class="page">4</a>
                <a href="#" class="page">5</a>
                <a href="#" class="next">&nbsp;</a>-->
                
                
                
                  <?php
                                                                
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->prev(
                                                                  '<',
                                                                  $options=array('class'=>'prev','disabledTag'=>'a'),
                                                                  null,
                                                                  array('disabledTag'=>'a','class'=>'prev disabled')
                                                                );
                                                                
                                                                // Shows the page numbers
                                                                echo $this->Paginator->numbers($options=array('separator'=>'','currentTag'=>'a','currentClass'=>'page active'));
                                                                
                                                                // Shows the next and previous links
                                                                echo $this->Paginator->next(
                                                                  '> ',
                                                                  $options=array('class'=>'next','disabledTag'=>'a'),
                                                                  null,
                                                                  array('disabledTag'=>'a','class'=>'next disabled')
                                                                );
                    
                                                            ?>
                
                
                 
        </div>
            
           
            
            
            
      </div>
          
          
          
         
          
          
    </section>
