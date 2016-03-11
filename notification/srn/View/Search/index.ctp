<?php
//echo "sumitra search";
//pr($search);
?>
<section class="emai-registration">
    <div class="topheading-box">
       <div class="container">
             <h2>Clinic</h2>
       </div>
    </div>
      <div class="container">
        
    <?php if(!empty($search) && ($search!='')) 
        { ?>
            
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="client_info">
            
            <tr class="client_info_title">
                <td class="col-1">&nbsp;</td>
                <td class="col-2">Clinic Name</td>
                <td class="col-3">Specialities</td>
                <td class="col-4">Closed/Open <!--<a href="#" class="downarrow"><img src="images/downarrow.png" alt=""></a>--></td>
                <td class="col-4">Like/Unlike</td>
            </tr>
           <?php
       
           App::import("Model", "ClickDoctor"); 
           // here PublicHoliday is model name, change with your own Model name
            $Openinghour_time_slot = new ClickDoctor();
        
            
           $i=1;
           foreach($search as $data)
           {?>
            <tr class="client_info_cont_g_bar">
            <td class="col-1"><?php echo  $i;?></td>
            <td class="col-2"><a href='<?php echo BASE_URL.'clinics/clincwall/'.$data['Clinic']['id'] ?>'><?php echo $data['Clinic']['name']?></a></td>
            <td class="col-3"><?php echo $data['Speciality']['specialities_name']?></td>
            
            
            <td class="col-4"><?php 
            $get_days = getdate();
        
            $openig_hours_result=  $Openinghour_time_slot->Openinghour_time_slot($data['Clinic']['id']);
           // pr($openig_hours_result);
            
                $listarray=array();
               $day_array= array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'); 
            
            foreach($openig_hours_result as $current_Openinghours)
			{
				
			    $listarray[$day_array[($current_Openinghours['openinghours']['day'])-1]][]= date("g:i a",strtotime(sprintf('%02d', $current_Openinghours['openinghours']['fromhour']).':'.sprintf('%02d',$current_Openinghours['openinghours']['fromminutes']))).'-'.date("g:i a",strtotime(sprintf('%02d',$current_Openinghours['openinghours']['tohour']).':'.sprintf('%02d',$current_Openinghours['openinghours']['tominutes'])));
			}
                        
                       // pr($listarray);  exit;
                        
			$new_array=array();
			$covered_keys=array();
			foreach($listarray as $key=>$val)
			{
				if(gettype(array_search($key,$covered_keys))!='boolean')
				{
				    continue;
				}
				$tmp_keys=array();
                                
                                
				foreach($listarray as $key2=>$val2)
				{
                                    
                                 
                                    
					if($val==$val2)
					{
						$tmp_keys[]=$key2;
						$covered_keys[]=$key2;
					}
				}
				
				$new_key=implode(', ',$tmp_keys);
				$new_array[$new_key]=$val;
			}
            
   
            
                                     $todays_day=date('D'); 

                                           foreach($new_array as $key=>$val_x)
                                           {
                                               
                                            
                                               
                                               
                                                   if(gettype(strstr($key, $todays_day))!='boolean')   
                                                   {
                                                       
                                            
                                                           $time_array= $val_x;
                                                           
                                                           
                          if(!empty($time_array))
                                    {
                                        
                              
                                            foreach($time_array as $time_arrays)
                                            {
                                                    $temp_time=explode('-',$time_arrays);
                                                    
                                                    $current_time_date= date('H:i');
                                                    
                                              
                                                    if($current_time_date<=$temp_time[1] &&  $current_time_date>=$temp_time[0])
                                                    {
                                                            $time_status=1;
                                                            break;
                                                    }else{
                                                        
                                                         $time_status=0;
                                                        
                                                    }
                                            }  
                                    }
                                                     
                                                           break;
                                                           
                                             
                                                   }else{
                                                       
                                                        $time_status=0;
                                                       
                                                       
                                                   }
                                                   
                                           }
                                           
                                          
                                           
                                          
                                           
                                           //pr($time_array);
                                           
                                  
							
                                   
                                    
                                              
                                                     ?>
                
                                                    <?php 
                                               
								if($time_status==1)
								{
                                                                    
                                                                    ?>
							       
                                                                 <span class="label label-success">Open</span>
                                                                 
                                                                 
								<?php	
								}
								else
								{
						                 ?>
                                                                            <span class="label label-danger">Closed</span>
									 
									
					                           <?php
                                                                   
                                                                   
                                                                     } 
                                         
                                                                   ?>        
                    
            
            </td>
            
            
            
            <td class="col-4">
 <?php
 
             if($data['Clinic']['likes']==0)
             {
                 
              echo 'No likes yet';    
                 
             }else{
                 
               echo $data['Clinic']['likes'];  
                 
                 
             }
 
 
 ?>
            </td>
            </tr>
            <?php
            $i++;
            } ?>
            
        </table>
        
        <?php
        } //if search result is not empty
        else
        {
        ?>
            <span style="padding: 4px;"><div  class="page_top_success">No Clinic Found.</div></span>
        <?php
        }
        ?>
      </div>
    </section>