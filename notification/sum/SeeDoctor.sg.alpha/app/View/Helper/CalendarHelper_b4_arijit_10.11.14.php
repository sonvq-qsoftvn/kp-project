<?php
     /**
     *@author  Xu Ding
     *@email   thedilab@gmail.com
     *@website http://www.StarTutorial.com
     **/
     class CalendarHelper extends Helper
     {  
          /********************* PROPERTY ********************/
          private $Openinghour;
          
          private $Appointment;
          
          private $Clinic;
          
          private $sec_clinic;
          
          private $TimeDiff;
          
          private $clinic_id;
          
          private $dayLabels = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
           
          private $currentYear=0;
           
          private $currentMonth=0;
           
          private $currentDay=0;
           
          private $currentDate=null;
           
          private $daysInMonth=0;
           
          private $naviHref= null;
          
          public $year = null;
          
          public $month = null;
          
          
          /**
           * Constructor
          */
          public function __construct(){
               //App::import("Model", array('Appointment','Clinic','Openinghour','User', 'Sitesetting', 'Openinghour'));
               $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
               $this->Openinghour = ClassRegistry::init('Openinghour');
               $this->Appointment = ClassRegistry::init('Appointment');
               $this->Clinic = ClassRegistry::init('Clinic');
          }
       
           
          /********************* PUBLIC **********************/  
            
          /**
          * print out the calendar
          */
          public function show($sec_clinic)
          {
               $this->clinic_id = $sec_clinic;
               $clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$this->clinic_id.'"'));
               $this->TimeDiff = $clinic_details['Clinic']['slot_time_diff'];
               
               $year = $month = null;
               
               if(null==$year && isset($_REQUEST['cal_year'])){
                   $year = $_REQUEST['cal_year'];
               }
               else if(null==$year){
                   $year = date("Y",time());  
               }          
            
               if(null==$month&&isset($_REQUEST['cal_month'])){
                   $month = $_REQUEST['cal_month'];
               }
               else if(null==$month){
                   $month = date("m",time());
               }                  
            
               $this->currentYear=$year;
                
               $this->currentMonth=$month;
                
               $this->daysInMonth=$this->_daysInMonth($month,$year);  
               
               $clinic_open_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->clinic_id.'"', 'group' => array('day')));
               $days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
               $day_avilable = array();
               
               foreach($clinic_open_details as $clinic_open)
               {
                    $day_avilable[] = 	$days[($clinic_open['Openinghour']['day'])-1];
               }
               
               $content='<div class="container_inner">'.
                              $this->_createNavi().
                              '<div class="monthly_appointment_table">'.
                                        '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="monthly_appointment_info">
                                             <tr class="monthly_appointment_info_title">'.$this->_createLabels().'</tr>';   
                                             //$content.='<div class="clear"></div>';     
                                             //$content.='<ul class="dates">';    
                                          
                                             $weeksInMonth = $this->_weeksInMonth($month,$year);
                                             // Create weeks in a month
                                             for( $i=0; $i<$weeksInMonth; $i++ ){
                                                  //Create days in a week
                                                  $content .= '<tr class="monthly_appointment_info_cont">';
                                                  for($j=1;$j<=7;$j++){
                                                      $content.= $this->_showDay(($i*7+$j), $day_avilable);
                                                  }
                                                  $content .= '</tr>';
                                             }
                                             //$content.='</ul>';
                                        $content.='</table>';
                                   $content.='<div class="clear"></div>';     
                              $content.='</div>';
                         $content.='</div>';
          return $content;   
     }
     
     /********************* PRIVATE **********************/ 
     /**
     * create the li element for ul
     */
     private function _showDay($cellNumber, $day_avilable)
     {
          $sec_class = $sec_class1 = $pl = $onclick_link = $onclick_style = ''; $slot_txt = '&nbsp'; $f_total_slots = 0;
          
          if($this->currentDay==0)
          {
               $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
               if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                   $this->currentDay=1;
               }
          }
         
          if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
               $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
               $cellContent = $this->currentDay;
               $this->currentDay++;   
          }
          else{
               $this->currentDate =null;
               $cellContent=null;
          }
          
          if(isset($_REQUEST['req_date']))
               $date_sec = date('d', strtotime($_REQUEST['req_date']));
          else
               $date_sec = date('d');
               
          if($cellContent==$date_sec)
               $sec_class = 'y_back';
          
          $date_name = date('l', strtotime($this->currentDate));
          $day_num = date('N', strtotime($this->currentDate));
          
          if(in_array($date_name, $day_avilable))
          {
               if($this->currentDate >= date('Y-m-d'))
               {
                    $sec_class1 = ''; $total_slots = 0;
                    
                    $clinic_opening_slots = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->clinic_id.'" AND day = "'.$day_num.'"'));
                    foreach($clinic_opening_slots as $c=>$clinic_opening_slot)
                    {
                         $slot_start = date('Y-m-d H:i', strtotime($this->currentDate.' '.$clinic_opening_slot['Openinghour']['fromhour'].':'.$clinic_opening_slot['Openinghour']['fromminutes']));
                         
                         $slot_end = date('Y-m-d H:i', strtotime($this->currentDate.' '.$clinic_opening_slot['Openinghour']['tohour'].':'.$clinic_opening_slot['Openinghour']['tominutes']));
                         
                         $all = round((strtotime($slot_end) - strtotime($slot_start)) / 60);
                         $h = floor ($all / 60);
                         $m = floor ($all / 60 * 60);
                         
                         $total_slots = $total_slots + floor( $m / $this->TimeDiff );
                         $f_total_slots = $total_slots;
                         
                         $booked_slots = $this->Appointment->find('count',array('conditions'=>'clinic_id="'.$this->clinic_id.'" AND slotid = "'.$clinic_opening_slot['Openinghour']['id'].'" AND date = "'.$this->currentDate.'"'));
                         
                         if($booked_slots > 0){ 
                              $total_slots = $total_slots - $booked_slots;
                         }
                         
                         //echo $this->currentDate.' '.$date_name.' '.(strtotime($slot_end) - strtotime($slot_start)).' '.$all.' '.$h.' '.$m.' '.($m / $this->TimeDiff).'<br>';
                    }
                    
                    if($total_slots >0)
                    {
                         $pl = ($total_slots > 1)?'s':'';
                         $slot_txt = ''.$total_slots.' Appointment Slot'.$pl.' Available';
                    }
                    
                    if($f_total_slots == $booked_slots){
                         $sec_class1 = 'r_back';
                         $slot_txt = 'Already Full';
                    }
                    
                    $click_d = date('d', strtotime($this->currentDate));
                    $click_m = date('m', strtotime($this->currentDate));
                    $click_y = date('Y', strtotime($this->currentDate));
                    
                    $onclick_link = 'onclick="change_cal_month_n(\''.$click_m.'\',\''.$click_y.'\',\''.$click_d.'\', \'week\')"';
                    $onclick_style = 'style="cursor: pointer;"';
               }
               else
               {
                    $sec_class1 = 'gg_back';
               }
          }
          else
          {
               if($this->currentDate)
                    $sec_class1 = 'gg_back';
          }
          
          return '<td '.$onclick_link.' '.$onclick_style.' id="td-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).($cellContent==null?'coll g_back':'coll').' '.$sec_class.' '.$sec_class1.'">'.$cellContent.' <span>'.$slot_txt.'</span></td>';
     }
     
     /**
     * create navigation
     */
     private function _createNavi(){
          
          $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
           
          $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
           
          $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
           
          $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
           
          return '<div class="month_title">'.
                    '<div class="month_is">'.date('F - Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</div>'.
                    '<div class="monthly_appointment_page">
                         <form name="cal_navigation" id="cal_navigation" action="'.BASE_URL.'appointments/book_appointment/clinic:'.$this->clinic_id.'/cal:month" method="post">
                              <input type="hidden" name="cal_date" id="cal_date" value="" />
                              <input type="hidden" name="cal_month" id="cal_month" value="" />
                              <input type="hidden" name="cal_year" id="cal_year" value="" />
                              <input type="hidden" name="req_type" id="req_type" value="1" />
                              <input type="hidden" name="req_date" id="req_date" value="'.date('m/d/Y').'" />
                              
                              <a href="javascript:void(0)" onclick="change_cal_month(\''.sprintf("%02d", $preMonth).'\',\''.sprintf("%02d", $preYear).'\', \'\')" class="left_arrow"><img src="'.BASE_URL.'frontend/images/monthly_left_arrow.png'.'" alt="previous" /></a>
                              <a href="javascript:void(0)" onclick="change_cal_month(\''.sprintf("%02d", $nextMonth).'\',\''.sprintf("%02d", $nextYear).'\', \'\')" class="right_arrow"><img src="'.BASE_URL.'frontend/images/monthly_right_arrow.png'.'" alt="next" /></a>
                         </form>
                    </div>'.
               '</div>';
     }
         
     /**
     * create calendar week labels
     */
     private function _createLabels()
     {  
          $content='';
          
          foreach($this->dayLabels as $index=>$label){
              $content.='<td class="'.($label==6?'end title':'start title').' coll">'.$label.'</td>';
          }
          
         return $content;
     }
     
     /**
     * calculate number of weeks in a particular month
     */
     private function _weeksInMonth($month=null,$year=null)
     {
          if( null==($year) ) {
              $year =  date("Y",time()); 
          }
           
          if(null==($month)) {
              $month = date("m",time());
          }
           
          // find number of days in this month
          $daysInMonths = $this->_daysInMonth($month,$year);
           
          $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
           
          $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
           
          $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
           
          if($monthEndingDay<$monthStartDay){
              $numOfweeks++;
          }
          
          return $numOfweeks;
     }
 
     /**
     * calculate number of days in a particular month
     */
     private function _daysInMonth($month=null,$year=null)
     {
          if(null==($year))
              $year =  date("Y",time()); 
   
          if(null==($month))
              $month = date("m",time());
              
          return date('t',strtotime($year.'-'.$month.'-01'));
     }
}
//- See more at: http://www.startutorial.com/articles/view/how-to-build-a-web-calendar-in-php#sthash.q7TuWFbG.dpuf