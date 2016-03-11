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
          <h2>Doctor List</h2>
        </div>
          
          <div class="container">
          
        </div>
     </div>

   
    
<div class="container">
      <div class="inner-gapbox-1">
	    <div class="orchard-surgery new_padding">
							<div class="orchard-buttons">
								<?php echo $this->Html->link('Add Doctor', array('controller' => 'clinics', 'action' => 'add_doctor/id:'.$clinc_id), array('class' => 'book_appointment')); ?>
							</div>
							<div class="clearfix"></div>
						</div>
      </div>
    
    <span style="padding: 4px;"><?php echo $this->Session->flash('update_error'); //Showing the error/success message ?></span>
    
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="client_info">
            <tr class="client_info_title">
		  <td class="col-1"></td>
		  <td class="col-2">Title</td>
                <td class="col-3">Doctor's Name</td>
                <td class="col-4">Image</td>
                <td class="col-5">Qualification </td>
                <td class="col-6">Options</td>
                
            </tr>
            
            <?php if(!empty($doctor_list))
            {    $i=1;
                 foreach($doctor_list as $doctor_lists)
                 {
                  
                ?>
        
            <tr class="client_info_cont_g_bar">
                <td class="col-1"><strong><?php echo $i ?></strong></td>
		   <td class="col-2"><?php echo $doctor_lists['Doctor']['title'] ?></td>
                <td class="col-3"><?php echo $doctor_lists['Doctor']['f_name'].' '.$doctor_lists['Doctor']['l_name'] ?></td>
               
               <?php  if( isset($doctor_lists['Doctor']['img']) && $doctor_lists['Doctor']['img']!="")
               {
                   ?>
            
                <td class="col-4"><?php echo $this->Html->image('../admin/uploads/'.$doctor_lists['Doctor']['img'],array('width'=>'126px','height'=>'126px','alt'=>'')); ?></td>
                
               <?php }else{ ?> 
                
                 <td class="col-4"><?php echo $this->Html->image('../frontend/images/na.jpg',array('alt'=>'')); ?></td>
                
               <?php } ?>
                
                <td class="col-5"><?php echo $doctor_lists['Doctor']['qualification'] ?></td>
                
                
                 <td class="col-6">
                <span>
	<a href='<?php echo BASE_URL.'clinics/edit_doctor/id:'.$doctor_lists['Doctor']['id'] ?>'>
            <?php echo $this->Html->image("../admin/img/icons/gear.png", array("alt"=>"Edit", 'title' => 'Edit')) ?></a>
											</span>
                     
										
										<span>
											<a onclick="return confirm('Are you sure to delete this doctor?')" href='<?php echo BASE_URL.'clinics/delete_doctor/id:'.$doctor_lists['Doctor']['id'] ?>'><?php echo $this->Html->image("../admin/img/icons/trash_can.png", array("alt"=>"Delete", 'title' => 'Delete')) ?></a>
										</span>
                
                </td>
                
                
               
            
                 <?php $i++; }  } ?>
                
               
                
                
                
            </tr>
        </table>
	
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