<?php
     /**
      * EasyWeeklyCalClass V 1.0. A class that generates a weekly schedule easily configurable *
      * @author Ruben Crespo Alvarez [rumailster@gmail.com] http://peachep.wordpress.com
     */
     //CalendarComponent
     class WeeklyCalendarHelper extends Helper
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
          
          function EasyWeeklyCalClass ($dia, $mes, $ano)
          {
               $hora = $min = $seg = null;
               
               $this->dia = $dia;
               $this->mes = $mes;
               $this->ano = $ano;
               $this->date = $this->showDate ($hora, $min, $seg, $mes, $dia, $ano);
               
               $this->Openinghour = ClassRegistry::init('Openinghour');
               $this->Appointment = ClassRegistry::init('Appointment');
               $this->clinic_id = 6;
               $this->TimeDiff = 15;
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
               $Output = $start_time = $end_time = $current_ploted_dates = $sec_class = $sec_class1 = $inner_cont = ''; $slot_id = 0;
               
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
                                   }
                                   else{
                                       $Output .="<td class='coll'>".$this->dayName ($diaSemana)." <br> ".date('m.d.Y', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar))." </th>";
                                       $current_ploted_dates[] = date('Y-m-d', strtotime($diaMes.'-'.$mesVar.'-'.$anoVar));
                                   }
                       
                                   $diaEnlace[$n]["dia"] = $diaMes;
                                   $diaEnlace[$n]["mes"] = $mesVar;
                                   $diaEnlace[$n]["ano"] = $anoVar;
                                   $n++;
                       
                                   $diaMes ++;
                              }

                         $Output .="</tr>";
       
                         //pr($current_ploted_dates);
       
                         for ($i=0; $i < 24;$i++)
                         {
                              $inner_loops = floor(60 / $this->TimeDiff);
                              
                              if($inner_loops > 1)
                              {
                                   for($t=1;  $t<=$inner_loops; $t++)
                                   {
                                        $start_time = date('H:i', strtotime($i.':'.(($this->TimeDiff * $t) - $this->TimeDiff)));
                                        if(($this->TimeDiff * $t) == 60)
                                             $end_time = date('H:i', strtotime(($i+1).':00'));
                                        else
                                             $end_time = date('H:i', strtotime($i.':'.($this->TimeDiff * $t)));
                                        
                                        //echo $inner_loops.' '.$this->TimeDiff.' '.$start_time.' '.$end_time.'<br>'; g_back
                                        
                                        $Output .="<tr class='manage_appointment_info_cont'>";
                                   
                                             $Output .="<td class='coll col-1'><span>From</span>: ".$start_time."<br><span>To</span>: ".$end_time."</td>";
                                             for ($n=0; $n<=6; $n++)
                                             {
                                                  $slot_id++;
                                                  
                                                  if($current_ploted_dates[$n] < date('Y-m-d'))
                                                  {
                                                       $sec_class = 'g_back'; $inner_cont = '';
                                                  }
                                                  else
                                                  {
                                                       $date_name = date('l', strtotime($current_ploted_dates[$n]));
                                                       $day_num = date('N', strtotime($current_ploted_dates[$n]));
                                                       
                                                       $booked_slots = $this->Appointment->find('all',array('conditions'=>'clinic_id="'.$this->clinic_id.'" AND date = "'.$current_ploted_dates[$n].'"'));
                                                       if(in_array($date_name, $day_avilable))
                                                       {
                                                            $sec_class = ''; $inner_cont = "<a id='".$slot_id."' href='javascript:void(0)' class='initialism makeanappointment_open'><img src='".BASE_URL."frontend/images/manageinfo_icon1.png'></a>";
                                                       }
                                                       else
                                                       {
                                                            $sec_class = 'g_back'; $inner_cont = '';
                                                       }
                                                  }
                                                  
                                                  $Output .= "<td class='coll ".$sec_class."'>".$inner_cont."</td>";
                                             }
                                        $Output .="</tr>";
                                   }
                              }
                              else
                              {
                                   $Output .="<tr class='manage_appointment_info_cont'>";
                              
                                        $Output .="<td class='coll col-1'>".date('h:i a', strtotime($i.':00'))."</td>";
                                        for ($n=0; $n<=6; $n++)
                                        {
                                            $Output .= "<td class='coll'><a href='#' class='initialism makeanappointment_open'><img src='".BASE_URL."frontend/images/manageinfo_icon1.png'></a></td>";
                                        }
                                   
                                   $Output .="</tr>";
                              }
                         }
          
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
                              <form name='cal_navigation' id='cal_navigation' action='".BASE_URL."appointments/book_appointment/cal:week' method='post''>
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