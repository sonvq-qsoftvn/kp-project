<?php
     /**
      * EasyWeeklyCalClass V 1.0. A class that generates a weekly schedule easily configurable *
      * @author Ruben Crespo Alvarez [rumailster@gmail.com] http://peachep.wordpress.com
     */
     //CalendarComponent
     class WeeklyCalendarClinicHelper extends Helper
     {
          /**
           * Constructor
          */
          
          private $dia;
          private $mes;
          private $ano;
          private $date;
          private $Openinghour;
          private $Appointment;
          private $clinic_id;
          private $TimeDiff;
          
          //public function __construct($dia, $mes, $ano){
          //     $this->dia = $dia;
          //     $this->mes = $mes;
          //     $this->ano = $ano;
          //   // $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
          //}
          
          function EasyWeeklyCalClass ($dia, $mes, $ano, $clinic_id)
          {
               $hora = $min = $seg = null;
               
               $this->dia = $dia;
               $this->mes = $mes;
               $this->ano = $ano;
               $this->date = $this->showDate ($hora, $min, $seg, $mes, $dia, $ano);
               
               $this->Openinghour       = ClassRegistry::init('Openinghour');
               $this->Appointment       = ClassRegistry::init('Appointment');
               $this->User              = ClassRegistry::init('User');
               $this->Clinicexception   = ClassRegistry::init('Clinicexception');
               $this->Clinic   = ClassRegistry::init('Clinic');
               
               $clinic_details = $this->Clinic->find('first', array('conditions'=>'id="'.$clinic_id.'"'));
               
               $this->clinic_id = ($clinic_id)?$clinic_id:6;
               //$this->TimeDiff = ($clinic_details['Clinic']['slot_time_diff'])?$clinic_details['Clinic']['slot_time_diff']:15; 
               $this->TimeDiff =5;
               $this->TimeDiffNew = 15;
          }

          public function showCalendar ()
          {
               $Output = '';
               //$Output .= $this->buttonsWeek ($this->dia, $this->mes, $this->ano, $this->date["numDiasMes"]);
               $Output .= $this->buttons ($this->dia, $this->mes, $this->ano, $this->date["numDiasMes"]);
               $Output .= "<table class='manage_appointment_info' border='0' cellspacing='0' cellpadding='0' width='100%'>";
               $Output .= $this->WeekTable ($this->date ["diaMes"], $this->date ["diaSemana"], $this->date["numDiasMes"], $this->date["nombreMes"], $this->dia, $this->mes, $this->ano);
               $Output .= "</table>";
       
               return $Output;
          }
    
          function WeeksInMonth ($mes, $leapYear, $firstDay)
          {
               if ($mes == 1 or $mes == 3 or $mes == 5 or $mes == 7 or $mes == 8 or $mes == 10 or $mes == 12)
               {
                    if ($firstDay > 5) {
                        return 6;
                    }
                    else {
                        return 5;
                    }
               }
               
               else if ($mes == 4 or $mes == 6 or $mes == 9 or $mes == 11)
               {
                    if ($firstDay == 7) {
                        return 6;
                    }
                    else {
                        return 5;
                    }
               }
               
               else if ($mes == 2)
               {
                    if ($leapYear == "0" and $firstDay == 1) {
                        return 4;
                    }else{
                        return 5;
                    }
               }
          }

          function showDate ($hora, $min, $seg, $mes, $dia, $ano)
          {
               $fecha = mktime ($hora, $min, $seg, $mes, $dia, $ano);
       
               $cal ["diaMes"] = date ("d", $fecha);
               $cal ["nombreMes"] = date ("F", $fecha);
               $cal ["numDiasMes"] = date ("t", $fecha); 
               
               if (date ("w", $fecha) == "0"){
                   $cal ["diaSemana"] = 7;
               }
               else {
                   $cal ["diaSemana"] = date ("w", $fecha);
               }
               
               $cal ["nombreDiaSem"] = date ("l", $fecha);
               $cal ["leapYear"] = date ("L", $fecha);
              
               return $cal;
          }
    
          function dayName ($dia)
          {
               if ($dia == 1)
               {
                   $Output = "Monday";
               } else if ($dia == 2) {
                   $Output = "Tuesday";
               } else if ($dia == 3) {
                   $Output = "Wednesday";
               } else if ($dia == 4) {
                   $Output = "Thursday";
               } else if ($dia == 5) {
                   $Output = "Friday";
               } else if ($dia == 6) {
                   $Output = "Saturday";
               } else if ($dia == 7) {
                   $Output = "Sunday";
               }
      
               return $Output;
          }
           
          function previousMonth ($dia, $mes, $ano)
          {
               $hora = $min = $seg = null;
               
               $mes = $mes-1;
               $mes= $this->showDate ($hora, $min, $seg, $mes, $dia, $ano);
               return $mes;
          }
          
          function nextMonth ($dia, $mes, $ano)
          {
               $hora = $min = $seg = null;
               
               $mes = $mes+1;
               $mes= $this->showDate ("10", "00", "00", $mes, 1, $ano);
               return $mes;
          }
        
          function numberOfWeek ($dia, $mes, $ano)
          {
               $hora = $min = $seg = null;
               
               $firstDay = $this->showDate ($hora, $min, $seg, $mes, 1, $ano);
               $numberOfWeek = ceil (($dia + ($firstDay ["diaSemana"]-1)) / 7);
               return $numberOfWeek;
          }

          function WeekTable ($diaMes, $diaSemana, $numDiasMes, $nombreMes, $dia, $mes, $ano)
          {
               $Output = $start_time = $end_time = $current_ploted_dates = $sec_class = $sec_class1 = $inner_cont = $slot_pos = $slot_pos_details = $slot_time_hr_s = $slot_time_min_s = $booked_time_hr = $booked_time_min = $booked_time_fn = $app_end_time = $booked_slots = $today_name = $all_open_slots_details = $today_opening_hrs = $today_closing_hrs = '';
               
               $slot_id = 0;
               
               $hora = $min = $seg = $cambio = $previousMonth = null;
               
               if ($diaSemana == 0)
               {
                   $diaSemana = 7;
               }
                  
               $n = $inner_loops = 0;
              
               /*NUMBER OF WEEKS AND WEEK NUMBER*/      
               $WeekNumber = $this->showDate ($hora, $min, $seg, $mes, 1, $ano);    
               $WeeksInMonth = $this->WeeksInMonth ($mes, $WeekNumber["leapYear"], $WeekNumber["diaSemana"]); 
               $numberOfWeek = $this->numberOfWeek ($dia, $mes, $ano);
               
               $clinic_open_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->clinic_id.'"', 'group' => array('day')));
               $days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
               $day_avilable = array();
               
               foreach($clinic_open_details as $clinic_open)
               {
                    $day_avilable[] = 	$days[($clinic_open['Openinghour']['day'])-1];
               }
               
               //pr($day_avilable);
               
               $Output .="<tr class='manage_appointment_info_title'>
                              <td class='coll'>Appointment Slot</td>";
       
                              $resta = $diaSemana - 1;
                              $diaMes = $diaMes - $resta;
                      
                              //To reach the selected day
                              for ($i=1; $i < $diaSemana; $i++)
                              {
                                   if ($diaMes < 1)
                                   {
                                        $previousMonth = $this->previousMonth ($dia, $mes, $ano);
                                        $diasAnterior = $previousMonth ["numDiasMes"];
                                        $nameAnterior = $previousMonth ["nombreMes"];
                                             
                                        if ($mes == 1) {
                                            $mesVar = 12;
                                            $anoVar = $ano - 1;
                                        }
                                        else {
                                           $mesVar = $mes - 1;
                                           $anoVar = $ano;
                                        }
                                             
                                        $cambio = 1;
                                        $diaMes = $diasAnterior + $diaMes;
                                   }
                                   else
                                   {
                                        if ($cambio != 1)
                                        {
                                            $nameAnterior = $nombreMes;
                                            $mesVar = $mes;
                                            $anoVar = $ano;
                                        }
                                   }
               
                                   if ($diaMes == $dia) {
                                       $Output .="<td class='coll y_back'>".$this->dayName ($i)." <br> ".date('m.d.Y', strtotime($dia.'-'.$mes.'-'.$ano))." </th>";
                                       $current_ploted_dates[] = date('Y-m-d', strtotime($dia.'-'.$mes.'-'.$ano));
                                   }
                                   else{
                                       $Output .="<td class='coll'>".$this->dayName ($i)." <br> ".date('m.d.Y', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar))." </th>";
                                       $current_ploted_dates[] = date('Y-m-d', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar));
                                   }
               
                                   $diaEnlace[$n]["dia"] = $diaMes;
                                   $diaEnlace[$n]["mes"] = $mesVar;
                                   $diaEnlace[$n]["ano"] = $anoVar;
                       
                                   if ($diaMes == $previousMonth["numDiasMes"]){
                                       $diaMes = 1;
                                       $cambio = 0;
                                   }
                                   else{
                                       $diaMes ++;
                                   }
                       
                                   $n++;
                              }
                              
                              //Resume from the selected day
                              for ($diaSemana; $diaSemana <= 7; $diaSemana++)
                              {
                                   if ($diaMes > $numDiasMes)
                                   {
                                        $mesS = $this->nextMonth ($dia, $mes, $ano);
                                        $nameSiguiente = $mesS ["nombreMes"];
                                        if ($mes == 12) {
                                            $mesVar = 1;
                                            $anoVar = $ano + 1;
                                        }
                                        else {
                                            $mesVar = $mes + 1;
                                        }
                        
                                        $cambio = 1;
                                        $diaMes = 1;
                                   } 
                                   else
                                   {
                                        if ($cambio != 1)
                                        {
                                            $nameSiguiente = $nombreMes;
                                            $mesVar = $mes;
                                            $anoVar = $ano;
                                        }
                                   }
               
                                   if ($diaMes == $dia) {
                                       $Output .="<td class='coll y_back'>".$this->dayName ($diaSemana)." <br> ".date('m.d.Y', strtotime($dia.'-'.$mes.'-'.$ano))." </th>";
                                       $current_ploted_dates[] = date('Y-m-d', strtotime($dia.'-'.$mes.'-'.$ano));
                                       
                                       $today_name = date('N', strtotime($dia.'-'.$mes.'-'.$ano));
                                   }
                                   else{
                                       $Output .="<td class='coll'>".$this->dayName ($diaSemana)." <br> ".date('m.d.Y', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar))." </th>";
                                       $current_ploted_dates[] = date('Y-m-d', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar));
                                       
                                       $today_name = date('N', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar));
                                   }
                       
                                   $diaEnlace[$n]["dia"] = $diaMes;
                                   $diaEnlace[$n]["mes"] = $mesVar;
                                   $diaEnlace[$n]["ano"] = $anoVar;
                                   $n++;
                       
                                   $diaMes ++;
                              }

                         $Output .="</tr>";
       
                         //pr($current_ploted_dates);
                         $actime_slot=15/5;
                         $slot_multiplier = 0; $c1 = array(); $d1 = $exception_chks = array();
                         
                              $start=strtotime('00:00');
                              $end=strtotime('23:55');
                              
                        for ($i=$start;$i<=$end;$i = $i + 5*60)
                              {
                              
                              $is_in_slot = $current_slot_id = 0; $open_slot_id = '';
                              
                              //$inner_loops = floor(60 / $this->TimeDiff);
                              
                              //if($inner_loops > 1)
                              //{
                              //     for($t=1,$rowspan_valid=1;  $t<=$inner_loops; $t++,$rowspan_valid++)
                              //     {
                                        //$start_time = date('H:i', strtotime($i.':'.(($this->TimeDiff * $t) - $this->TimeDiff)));
                                        //if(($this->TimeDiff * $t) == 60)
                                        //     $end_time = date('H:i', strtotime(($i+1).':00'));
                                        //else
                                        //     $end_time = date('H:i', strtotime($i.':'.($this->TimeDiff * $t)));
                                        
                                        //echo $inner_loops.' '.$this->TimeDiff.' '.$start_time.' '.$end_time.'<br>'; g_back
                                        
                                        $Output .="<tr class='manage_appointment_info_cont'>";
                                   
                                             $Output .="<td class='coll col-1'><span>From</span>: ".date('H:i',$i)."<br><span>To</span>: ".date('H:i',$i + 5*60)."</td>";
                                             
                                             for ($n=0; $n<=6; $n++)
                                             {
                                                  $last_slot_id[$n] = 0;
                                                  
                                                  $all_open_slots_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->clinic_id.'" AND day = "'.($n+1).'"'));
                                                  pr($all_open_slots_details);
                                                  foreach($all_open_slots_details as $c=>$all_open_slot)
                                                  {
                                                       $slot_start_hr = strtotime($all_open_slot['Openinghour']['fromhour'].':'.$all_open_slot['Openinghour']['fromminutes']);
                                                       $slot_end_hr = strtotime($all_open_slot['Openinghour']['tohour'].':'.$all_open_slot['Openinghour']['tominutes']);
                                                       $current_time = strtotime($start_time);
                                                       
                                                       if(($slot_start_hr <= $current_time) && ($current_time < $slot_end_hr)){
                                                            
                                                            $is_in_slot = 1; $open_slot_id = $all_open_slot['Openinghour']['id']; $last_slot_id[$n] = $all_open_slot['Openinghour']['id'];
                                                            //continue;
                                                            $current_slot_id = $all_open_slot['Openinghour']['id'];
                                                            
                                                            if(array_key_exists($current_slot_id, $c1)){
                                                                 $c1[$all_open_slot['Openinghour']['id']] = $c1[$all_open_slot['Openinghour']['id']] + 1;
                                                            }
                                                            else{
                                                                 $c1[$current_slot_id] = 0;
                                                            }
                                                            break;
                                                       }
                                                       else{
                                                            $is_in_slot = 0; $open_slot_id = ''; 
                                                       }
                                                  }
                                                  
                                                  $slot_id++;
                                                  
                                                  if($is_in_slot == 1)
                                                  {
                                                       if(isset($c1[$current_slot_id])){  $slot_multiplier = $c1[$current_slot_id] + 1; }
                                                       
                                                       //if($current_ploted_dates[$n] < date('Y-m-d'))
                                                       //{
                                                       //     $sec_class = 'g_back'; $inner_cont = '';
                                                       //}
                                                       //else
                                                       //{
                                                            $date_name = date('l', strtotime($current_ploted_dates[$n]));
                                                            $day_num = date('N', strtotime($current_ploted_dates[$n]));
                                                            
                                                            if(in_array($date_name, $day_avilable))
                                                            {
                                                                 if($current_ploted_dates[$n] < date('Y-m-d'))
                                                                 {
                                                                      $sec_class = 'g_back'; $inner_cont = '';
                                                                 }
                                                                 else
                                                                 {
                                                                      $sec_class = ''; $inner_cont = "<a href='javascript:void(0)' onclick='booking_appointment(\"".$this->clinic_id."\", \"".$current_ploted_dates[$n]."\", \"".$start_time."\", \"".$end_time."\", \"".$open_slot_id."\", \"".$slot_multiplier."\")' class='initialism makeanappointment_open icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon1.png'></a><a href='javascript:confirm_block(\"".BASE_URL.'appointments/blook_app_slot/clinic:'.$this->clinic_id.'/date:'.strtotime($current_ploted_dates[$n]).'/slot_id:'.$open_slot_id."/slot_pos:".$slot_multiplier."\")' class='icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon2.png'></a>";
                                                                 }
                                                            }
                                                            else
                                                            {
                                                                 $sec_class = 'g_back'; $inner_cont = '';
                                                            }
                                                            
                                                            $booked_slots = $this->Appointment->find('all',array('conditions'=>'clinic_id="'.$this->clinic_id.'" AND date = "'.$current_ploted_dates[$n].'"'));
                                                            if(!empty($booked_slots))
                                                            {
                                                                 foreach($booked_slots as $slots)
                                                                 {
                                                                      $user_details = $this->User->find('first',  array('conditions' => array('id' => $slots['Appointment']['uid'])));
                                                                      if($user_details['User']['first_name'])
                                                                           $user_name = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
                                                                      else
                                                                           $user_name = $user_details['User']['username'];
                                                                           
                                                                      if(strlen($user_name > 13))
                                                                           $user_name = substr($user_name, 0, 13).'...';
                                                                      
                                                                      if($user_details['User']['phone_number'])
                                                                           $phone_number = '<a class="" style="color:#fff" href="tel:'.$user_details['User']['phone_number'].'" >'.$user_details['User']['phone_number'].'</a>';
                                                                      else
                                                                           $phone_number = '';
                                                                      
                                                                      $slot_pos = $slots['Appointment']['slotid'];
                                                                      $slot_pos_details = $this->Openinghour->find('first',array('conditions'=>'id="'.$slot_pos.'"'));
                                                                      $slot_time_hr_s = $slot_pos_details['Openinghour']['fromhour'];
                                                                      $slot_time_min_s = $slot_pos_details['Openinghour']['fromminutes'];
                                                                      
                                                                      $booked_time_hr = $slot_time_hr_s;
                                                                      $booked_time_min = $slot_time_min_s + (floor($this->TimeDiff * $slots['Appointment']['multiplier']));
                                                                      if($booked_time_min >= 60)
                                                                      {
                                                                           $booked_time_hr = $booked_time_hr + floor( $booked_time_min / 60 );
                                                                           $booked_time_min = floor( $booked_time_min % 60 );
                                                                      }
                                                                      
                                                                      $booked_time_fn = date('H:i', strtotime($booked_time_hr.':'.$booked_time_min));
                                                                      
                                                                      $app_end_time = strtotime($booked_time_fn);
                                                                      
                                                                      if(strtotime($end_time) == $app_end_time)
                                                                      {
                                                                           if($slots['Appointment']['status'] == 2)
                                                                           {
                                                                                $sec_class = 'r_back';
                                                                                $inner_cont = "<a href='javascript:void(0)' onclick='reshedule_appointment_fnc(".$this->clinic_id.", \"".$start_time."\", ".$slots['Appointment']['id'].")' class='initialism rescheduleappointment_open icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon3.png'></a><a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon4.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                                                                                if($current_ploted_dates[$n] < date('Y-m-d'))
                                                                                {
                                                                                     $sec_class = 'r_back';
                                                                                     $inner_cont = '<span>'.$user_name.'<br>'.$phone_number.'</span>';
                                                                                }
                                                                           }
                                                                           elseif($slots['Appointment']['status'] == 1)
                                                                           {
                                                                                $sec_class = 'y_back';
                                                                                $inner_cont = "<a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon6.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                                                                                
                                                                                if($current_ploted_dates[$n] < date('Y-m-d'))
                                                                                {
                                                                                     $sec_class = 'r_back';
                                                                                     $inner_cont = '<span>Not confirmed<br>'.$user_name.'<br>'.$phone_number.'</span>';
                                                                                }
                                                                           }
                                                                           else
                                                                           {
                                                                                $sec_class = 'y_back';
                                                                                $inner_cont = "<a href='Javascript:confirm_appointment(\"".BASE_URL.'appointments/confirm_appointment/clinic:'.$this->clinic_id.'/id:'.$slots['Appointment']['id']."\")' class='icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon5.png'></a><a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon6.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                                                                                
                                                                                if($current_ploted_dates[$n] < date('Y-m-d'))
                                                                                {
                                                                                     $sec_class = 'y_back';
                                                                                     $inner_cont = '<span>Not confirmed<br>'.$user_name.'<br>'.$phone_number.'</span>';
                                                                                }
                                                                           }
                                                                      }
                                                                 }
                                                            }
                                                            
                                                            $exception_chks = $this->Clinicexception->find('all', array('conditions'=>'clinicid="'.$this->clinic_id.'" AND exceptiondate = "'.$current_ploted_dates[$n].'" AND cancelledslotid = "'.$current_slot_id.'"'));
                                                            
                                                            if(!empty($exception_chks))
                                                            {
                                                                 foreach($exception_chks as $exception_chk)
                                                                 {
                                                                      if($exception_chk['Clinicexception']['slot_multiplier'] == $slot_multiplier)
                                                                      {
                                                                           if($current_ploted_dates[$n] < date('Y-m-d'))
                                                                           {
                                                                                $sec_class = 'g_back'; $inner_cont = '';
                                                                           }
                                                                           else
                                                                           {
                                                                                $sec_class = 'g_back'; $inner_cont = '<a href="javascript:void(0)" onclick="confirm_remove_exp(\''.BASE_URL.'appointments/delete_exception/clinic:'.$this->clinic_id.'/id:'.$exception_chk['Clinicexception']['id'].'\')"><img src="'.BASE_URL.'images/manageinfo_icon7.png"></a>';
                                                                           }
                                                                      }
                                                                 }
                                                            }
                                                       //}
                                                  }
                                                  else
                                                  {
                                                       $sec_class = 'g_back'; $inner_cont = '';
                                                  }
                                                  
                                                  $Output .= "<td class='coll ".$sec_class."'>".$inner_cont."</td>";
                                             }
                                        $Output .="</tr>";
                                   //}
                              //}
                              //else
                              //{
                              //     $start_time = date('H:i', strtotime($i.':00'));
                              //     $end_time = date('H:i', strtotime(($i+1).':00'));
                              //     
                              //     $Output .="<tr class='manage_appointment_info_cont'>";
                              //
                              //          $Output .="<td class='coll col-1'><span>From</span>: ".$start_time."<br><span>To</span>: ".$end_time."</td>";
                              //          for ($n=0; $n<=6; $n++)
                              //          {
                              //               $last_slot_id[$n] = 0;
                              //                    
                              //               $all_open_slots_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->clinic_id.'" AND day = "'.($n+1).'"'));
                              //               foreach($all_open_slots_details as $c=>$all_open_slot)
                              //               {
                              //                    $slot_start_hr = strtotime($all_open_slot['Openinghour']['fromhour'].':'.$all_open_slot['Openinghour']['fromminutes']);
                              //                    $slot_end_hr = strtotime($all_open_slot['Openinghour']['tohour'].':'.$all_open_slot['Openinghour']['tominutes']);
                              //                    $current_time = strtotime($start_time);
                              //                    
                              //                    if(($slot_start_hr <= $current_time) && ($current_time < $slot_end_hr)){
                              //                         
                              //                         $is_in_slot = 1; $open_slot_id = $all_open_slot['Openinghour']['id']; $last_slot_id[$n] = $all_open_slot['Openinghour']['id'];
                              //                         //continue;
                              //                         $current_slot_id = $all_open_slot['Openinghour']['id'];
                              //                         
                              //                         if(array_key_exists($current_slot_id, $c1)){
                              //                              $c1[$all_open_slot['Openinghour']['id']] = $c1[$all_open_slot['Openinghour']['id']] + 1;
                              //                         }
                              //                         else{
                              //                              $c1[$current_slot_id] = 0;
                              //                         }
                              //                         break;
                              //                    }
                              //                    else{
                              //                         $is_in_slot = 0; $open_slot_id = ''; 
                              //                    }
                              //               }
                              //               
                              //               $slot_id++;
                              //               
                              //               if($is_in_slot == 1)
                              //               {
                              //                    if(isset($c1[$current_slot_id])){  $slot_multiplier = $c1[$current_slot_id] + 1; }
                              //                    
                              //                    if($current_ploted_dates[$n] < date('Y-m-d'))
                              //                    {
                              //                         $sec_class = 'g_back'; $inner_cont = '';
                              //                    }
                              //                    else
                              //                    {
                              //                         $date_name = date('l', strtotime($current_ploted_dates[$n]));
                              //                         $day_num = date('N', strtotime($current_ploted_dates[$n]));
                              //                         
                              //                         if(in_array($date_name, $day_avilable))
                              //                         {
                              //                              $sec_class = ''; $inner_cont = "<a href='javascript:void(0)' onclick='booking_appointment(\"".$this->clinic_id."\", \"".$current_ploted_dates[$n]."\", \"".$start_time."\", \"".$end_time."\", \"".$open_slot_id."\", \"".$slot_multiplier."\")' class='initialism makeanappointment_open icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon1.png'></a><a href='javascript:confirm_block(\"".BASE_URL.'appointments/blook_app_slot/clinic:'.$this->clinic_id.'/date:'.strtotime($current_ploted_dates[$n]).'/slot_id:'.$open_slot_id."/slot_pos:".$slot_multiplier."\")' class='icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon2.png'></a>";
                              //                         }
                              //                         else
                              //                         {
                              //                              $sec_class = 'g_back'; $inner_cont = '';
                              //                         }
                              //                         
                              //                         $booked_slots = $this->Appointment->find('all',array('conditions'=>'clinic_id="'.$this->clinic_id.'" AND date = "'.$current_ploted_dates[$n].'"'));
                              //                         if(!empty($booked_slots))
                              //                         {
                              //                              foreach($booked_slots as $slots)
                              //                              {
                              //                                   $user_details = $this->User->find('first',  array('conditions' => array('id' => $slots['Appointment']['uid'])));
                              //                                   if($user_details['User']['first_name'])
                              //                                        $user_name = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
                              //                                   else
                              //                                        $user_name = $user_details['User']['username'];
                              //                                        
                              //                                   if(strlen($user_name > 13))
                              //                                        $user_name = substr($user_name, 0, 13).'...';
                              //                                   
                              //                                   if($user_details['User']['phone_number'])
                              //                                        $phone_number = '<a class="" style="color:#fff" href="tel:'.$user_details['User']['phone_number'].'" >'.$user_details['User']['phone_number'].'</a>';
                              //                                   else
                              //                                        $phone_number = '';
                              //                                   
                              //                                   $slot_pos = $slots['Appointment']['slotid'];
                              //                                   $slot_pos_details = $this->Openinghour->find('first',array('conditions'=>'id="'.$slot_pos.'"'));
                              //                                   $slot_time_hr_s = $slot_pos_details['Openinghour']['fromhour'];
                              //                                   $slot_time_min_s = $slot_pos_details['Openinghour']['fromminutes'];
                              //                                   
                              //                                   $booked_time_hr = $slot_time_hr_s;
                              //                                   $booked_time_min = $slot_time_min_s + (floor($this->TimeDiff * $slots['Appointment']['multiplier']));
                              //                                   if($booked_time_min >= 60)
                              //                                   {
                              //                                        $booked_time_hr = $booked_time_hr + floor( $booked_time_min / 60 );
                              //                                        $booked_time_min = floor( $booked_time_min % 60 );
                              //                                   }
                              //                                   
                              //                                   $booked_time_fn = date('H:i', strtotime($booked_time_hr.':'.$booked_time_min));
                              //                                   
                              //                                   $app_end_time = strtotime($booked_time_fn);
                              //                                   
                              //                                   if(strtotime($end_time) == $app_end_time)
                              //                                   {
                              //                                        if($slots['Appointment']['status'] == 2){
                              //                                             $sec_class = 'r_back';
                              //                                             $inner_cont = "<a href='javascript:void(0)' onclick='reshedule_appointment_fnc(".$this->clinic_id.", \"".$start_time."\", ".$slots['Appointment']['id'].");' class='initialism rescheduleappointment_open icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon3.png'></a><a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon4.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                              //                                        }
                              //                                        elseif($slots['Appointment']['status'] == 1)
                              //                                        {
                              //                                             $sec_class = 'y_back';
                              //                                             $inner_cont = "<a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon6.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                              //                                        }
                              //                                        else
                              //                                        {
                              //                                             $sec_class = 'y_back';
                              //                                             $inner_cont = "<a href='Javascript:confirm_appointment(\"".BASE_URL.'appointments/confirm_appointment/clinic:'.$this->clinic_id.'/id:'.$slots['Appointment']['id']."\")' class='icon1'><img src='".BASE_URL."frontend/images/manageinfo_icon5.png'></a><a href='Javascript:void(0)' onclick='confirm_delete(\"".BASE_URL.'appointments/delete_appointment/id:'.$slots['Appointment']['id']."\")' class='icon2'><img src='".BASE_URL."frontend/images/manageinfo_icon6.png'></a><span>".$user_name."<br>".$phone_number."</span>";
                              //                                        }
                              //                                   }
                              //                              }
                              //                         }
                              //                         
                              //                         $exception_chks = $this->Clinicexception->find('all', array('conditions'=>'clinicid="'.$this->clinic_id.'" AND exceptiondate = "'.$current_ploted_dates[$n].'" AND cancelledslotid = "'.$current_slot_id.'"'));
                              //                         
                              //                         if(!empty($exception_chks))
                              //                         {
                              //                              foreach($exception_chks as $exception_chk)
                              //                              {
                              //                                   if($exception_chk['Clinicexception']['slot_multiplier'] == $slot_multiplier){
                              //                                        $sec_class = 'g_back'; $inner_cont = '<a href="#"><img src="'.BASE_URL.'images/manageinfo_icon7.png"></a>';
                              //                                   }
                              //                              }
                              //                         }
                              //                    }
                              //               }
                              //               else
                              //               {
                              //                    $sec_class = 'g_back'; $inner_cont = '';
                              //               }
                              //               
                              //               $Output .= "<td class='coll ".$sec_class."'>".$inner_cont."</td>";
                              //          }
                              //     
                              //     $Output .="</tr>";
                              //}
                         }
          
               return $Output;
          }

          function generate_time($open_slot_id, $current_date, $slot_id, $start_time, $end_time, $slot_multiplier)
          {
               $is_in_slot = 1;
               
               if($is_in_slot == 1)
               { 
                    if($current_date < date('Y-m-d'))
                    {
                         $sec_class = 'g_back'; $inner_cont = '';
                    }
                    else
                    {
                         $date_name = date('l', strtotime($current_date));
                         $day_num = date('N', strtotime($current_date));
                         
                         if(in_array($date_name, $day_avilable))
                         {
                              $sec_class = ''; $inner_cont = "<a id='".$slot_id."' href='javascript:void(0)' onclick='booking_appointment(\"".$this->clinic_id."\", \"".$current_date."\", \"".$start_time."\", \"".$end_time."\", \"".$open_slot_id."\", \"".$slot_multiplier."\")' class='initialism makeanappointment_open'><img src='".BASE_URL."frontend/images/manageinfo_icon1.png'></a>";
                         }
                         else
                         {
                              $sec_class = 'g_back'; $inner_cont = '';
                         }
                         
                         $booked_slots = $this->Appointment->find('all',array('conditions'=>'clinic_id="'.$this->clinic_id.'" AND date = "'.$current_date.'"'));
                         if(!empty($booked_slots))
                         {
                              foreach($booked_slots as $slots)
                              {
                                   $slot_pos = $slots['Appointment']['slotid'];
                                   $slot_pos_details = $this->Openinghour->find('first',array('conditions'=>'id="'.$slot_pos.'"'));
                                   $slot_time_hr_s = $slot_pos_details['Openinghour']['fromhour'];
                                   $slot_time_min_s = $slot_pos_details['Openinghour']['fromminutes'];
                                   
                                   $booked_time_hr = $slot_time_hr_s;
                                   $booked_time_min = $slot_time_min_s + (floor($this->TimeDiff * $slots['Appointment']['multiplier']));
                                   if($booked_time_min >= 60)
                                   {
                                        $booked_time_hr = $booked_time_hr + floor( $booked_time_min / 60 );
                                        $booked_time_min = floor( $booked_time_min % 60 );
                                   }
                                   
                                   $booked_time_fn = date('H:i', strtotime($booked_time_hr.':'.$booked_time_min));
                                   
                                   $app_end_time = strtotime($booked_time_fn);
                                   
                                   if(strtotime($end_time) == $app_end_time)
                                   {
                                        if($slots['Appointment']['status'] == 2){
                                             $sec_class = 'r_back'; $inner_cont = '<span>Booked</span>';
                                        }
                                        else{
                                             $sec_class = 'y_back'; $inner_cont = '<span>Pending</span>';
                                        }
                                   }
                              }
                         }
                    }
               }
               else
               {
                    $sec_class = 'g_back'; $inner_cont = '';
               }
               
               $Output .= "<td class='coll ".$sec_class."'>".$inner_cont."</td>";
               
               return $Output;
          }
          
          function buttonsWeek ($dia, $mes, $ano, $numDiasMes)
          {
               $thisMonth= $this->showDate ($hora, $min, $seg, $mes, $dia, $ano);
               $thisMontOne = $this->showDate ($hora, $min, $seg, $mes, 1, $ano);
               $previousMonth = $this->previousMonth ($dia, $mes, $ano);
               $WeeksInMonth = $this->WeeksInMonth ($mes, $thisMonth["leapYear"], $thisMonth["diaSemana"]);
               $numberOfWeek = $this->numberOfWeek ($dia, $mes, $ano);      
               $diasRestan = (7 - $thisMonth["diaSemana"]);
       
               //BOTON ANT
               if ($dia <= 7)
               {
                    $ant = $previousMonth["numDiasMes"] - (($thisMontOne["diaSemana"]-1)) + 1;
                    $mesAnt = $mes - 1;

                    if ($mes == 1) {
                        $anoAnt = $ano-1;
                        $mesAnt = 12;
                    }
                    else {
                        $anoAnt = $ano;
                    }
               }
               else
               {
                    $ant = $dia - ($thisMonth["diaSemana"] + 6);
                    $mesAnt= $mes;
                    $anoAnt = $ano;
               }

               //BOTON POST
               if ($numberOfWeek == $WeeksInMonth)
               {
                    $post="1";
                    $mesPost=$mes+1;
        
                    if ($mes == 12){
                         $anoPost = $ano+1;
                         $mesPost = 1;
                    }
                    else {
                         $anoPost = $ano;
                    }
               }
               else
               {
                    $post=$dia+($diasRestan+1);
                    $mesPost=$mes;
                    $anoPost = $ano;
               }


               $Output .= "<p style='font-weight:bold; font-size:0.8em;'>
                              <a href='".$PHP_SELF."?dia=".$ant."&mes=".$mesAnt."&ano=".$anoAnt."'>&laquo; previous week</a> |
                              <a href='".$PHP_SELF."?dia=".$post."&mes=".$mesPost."&ano=".$anoPost."'>next week &raquo;</a>
                          </p>";
       
               return $Output;
          }

          function buttons ($dia, $mes, $ano, $numDiasMes)
          {
               $Output = $PHP_SELF = '';
               
               $previousMonth = $this->previousMonth ($dia, $mes, $ano);
               $nextMonth = $this->nextMonth ($dia, $mes, $ano);
       
               $ant= $dia-1;
       
               //BOTON ANT
               if ($dia == 1)
               {
                    $ant = $previousMonth ["numDiasMes"];
                    $mesAnt = $mes - 1;
        
                    if ($mes == 1){
                        $anoAnt = $ano-1;
                        $mesAnt = 12;
                    }
                    else {
                        $anoAnt = $ano;
                    }
               }
               else{
                    $ant = $dia - 1;
                    $mesAnt= $mes;
                    $anoAnt = $ano;
               }

               //BOTON POST
               if ($dia == $numDiasMes)
               {
                    $post="1";
                    $mesPost=$mes+1;
        
                    if ($mes == 12){
                        $anoPost = $ano+1;
                        $mesPost = 1;
                    }
                    else {
                        $anoPost = $ano;
                    }
               }
               else
               {
                    $post=$dia+1;
                    $mesPost=$mes;
                    $anoPost = $ano;
               }
                
               $Output .= "<div class='manage_appointment_page'>
                              <form name='cal_navigation' id='cal_navigation' action='".BASE_URL."appointments/clinic_appointment_details/id:".$this->clinic_id."/cal:week' method='post''>
                                   <input type='hidden' name='cal_date' id='cal_date' value='' />
                                   <input type='hidden' name='cal_month' id='cal_month' value='' />
                                   <input type='hidden' name='cal_year' id='cal_year' value='' />
                                   <input type='hidden' name='req_type' id='req_type' value='1' />
                                   <input type='hidden' name='req_date' id='req_date' value='".date('m/d/Y')."' />
                                   
                                   <a class='left_arrow' onclick='change_cal_month(\"".$mesAnt."\",\"".$anoAnt."\", \"".$ant."\")' href='javascript:void(0)' ><img src='".BASE_URL."frontend/images/manage_left_arrow.png'></a>
                                   <a class='right_arrow' onclick='change_cal_month(\"".$mesPost."\",\"".$anoPost."\", \"".$post."\")' href='javascript:void(0)'><img src='".BASE_URL."frontend/images/manage_right_arrow.png'></a>
                              </form>
                          </div>";

               return $Output;
          }
     }    //End of WeeklyCalendar Class


?>