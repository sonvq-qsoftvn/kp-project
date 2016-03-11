<?php

//==========================For indivial user===============================
 if(isset($one_user) && $one_user=='one_user' && $one_user!='' )
   {
  
   $options_arr=array();

   if($selected_user!=array())
   { 
      foreach($selected_user as $k=>$v)
      {
   
         $options_arr[$v['User']['id']]=$v['User']['username'];
      }
      
    ?>  
      <div class="control-group">
      <label class="control-label" for="select_sender_name">Select Sender name*:</label>
      <div class="controls"> 
      
       <?php  
         echo $this->Form->input('recever',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' =>'recever', 'options'=>$options_arr,'style'=>'width:35%;','data-placeholder'=>'Select Recever','class'=>'chzn-select-deselect'));
      ?>
      </div>
      </div>
      <?php
   
   }
   }
 
 /////////////////////////////////////////////////////////////////////////////////////////
 //==========================END For indivial user===============================
 
 ///////////////////////////////////////////////////////////////////////////////////////////
 
 //==========================For indivial clinic manager===============================
 
 else if( isset($one_manager) && $one_manager=='one_manager' && $one_manager!='' )
   {
  
   $options_arr=array();

   if($selected_manager!=array())
   { 
    foreach($selected_manager as $k=>$v)
    {

      $options_arr[$v['User']['id']]=$v['User']['username'];
    }
    ?>
    <div class="control-group">
      <label class="control-label" for="select_sender_name">Select Sender name*:</label>
      <div class="controls">
    
  <?php
  echo $this->Form->input('recever',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' =>'recever', 'options'=>$options_arr,'style'=>'width:35%;','data-placeholder'=>'Select Recever','class'=>'chzn-select-deselect'));
   }
  ?>
  </div>
  </div>
  <?php
   
   }else{
  ?>
  <input type="hidden" name="recever" id="recever" value="none">  
  <?php    
   }
 
 ///////////////////////////////////////////////////////////////////////////////////////////
 
 //==========================End For indivial clinic manager===============================
 
 ///////////////////////////////////////////////////////////////////////////////////////////
  
  
if(isset($last_insert_id) && $last_insert_id>0)
   {
   ?>
    <input type="hidden" name="form_id_update" id="form_id_update" value="<?php echo $last_insert_id ;?>">  
      
 <?php
  }  
   
 ?>