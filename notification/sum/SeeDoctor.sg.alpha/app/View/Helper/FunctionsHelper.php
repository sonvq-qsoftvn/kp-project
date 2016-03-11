<?php
App::uses('AppHelper', 'View/Helper');

class FunctionsHelper extends AppHelper {
    public function calculate_time_gap($d1, $d2)
    {
       $tot_sec= strtotime($d1)-strtotime($d2);
       
       $ret_str['s']=$tot_sec%60;
       $tot_min=(int)$tot_sec/60;
       
       $ret_str['m']=$tot_min%60;
       $tot_h=(int)$tot_min/60;
       
       $ret_str['h']=$tot_h%24;
       $tot_d=(int)$tot_h/24;
       
       $ret_str['d']=$tot_d%30;
       $tot_M=(int)$tot_d/30;
       
       $ret_str['M']=$tot_M%12;
       
       $ret_str['Y']=(int)$tot_M/12;
       
       return $ret_str;
    }
}
?>