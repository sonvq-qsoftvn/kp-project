<?php
                                        if($all_sub_specialities!=array())
                                        {
                                                foreach($all_sub_specialities as $k=>$v)
                                                {
                                                   $options_arr[$v['Speciality']['id']]=$v['Speciality']['specialities_name'];
                                                }
                                                echo $this->Form->input('subtype',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'subtype', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'chzn-select-deselect'));
                                        }
                                        else
                                        {
                                               echo $this->Form->input('subtype',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'class' => 'input-fluid', 'id' => 'subtype','value'=>'0'))."No subspeciality for the selected speciality";
                                        }
?>