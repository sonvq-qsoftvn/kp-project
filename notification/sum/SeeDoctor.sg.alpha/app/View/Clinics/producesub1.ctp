<?php

     if($all_sub_specialities!=array())
     {
          $html = '<select name="subtype" id="subtype" class="custom-select">';
          foreach($all_sub_specialities as $k=>$v)
          {
               //$options_arr[$v['Speciality']['id']]=$v['Speciality']['specialities_name'];
               if($v['Speciality']['id'] == $sub_type_id){$sec='selected';}else{$sec='';}
               $html .='<option '.$sec.' value="'.$v['Speciality']['id'].'">'.$v['Speciality']['specialities_name'].'</option>';
          }
          $html .='</select>';
          
          echo $html;
          //echo $this->Form->input('subtype',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'subtype','options'=> $options_arr, 'default' => $sub_type_id,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'custom-select'));
     }
     else
     {
          $options_arr[]='No subspeciality found';
          
          echo $this->Form->input('subtype',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'subtype', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'custom-select'));
     }
?>