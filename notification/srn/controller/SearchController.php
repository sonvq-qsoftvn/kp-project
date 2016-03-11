<?php
App::uses('CakeEmail', 'Network/Email');
class SearchController extends AppController  
{
	public $helpers = array('Html', 'Form', 'Paginator','Functions'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator','Upload'); //loading necessary components
	
	//models used 
	var $uses=array('Clinic','Clinicmanager','Speciality','Insurance','Insurancetoclinic','Openinghour','Sitesetting','Cliniclike','Doctor','Openinghour','User', 'Cliniclikes', 'Eligibilitie', 'Eligibilitieclinc','Wallpost','Comment','ClickDoctor');
        //declaring paginator options
        public $paginate = array(
        'limit' => 1,
        'order' => array('ClickDoctor' => 'asc'));
        
        //before filter function
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		//no cache code starts
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
            
		//no cache code ends
                
                //Load all site settings data
		$settings_datas = $this->Sitesetting->find('all');
		
		foreach($settings_datas as $settings_data)
		{
			$this->set($settings_data['Sitesetting']['field_name'], $settings_data['Sitesetting']['field_value']);
		}
	}

	//Clinics :: Tabular view
	
	public function index()
	{
		$this->layout='frontend';
		//echo "hello";
		//echo $this->query['specialist'];
		//pr($this->params['params']);
		//pr($this->Clinic->query("SELECT * FROM clinics,cliniclikes Where clinics.id=cliniclikes.clinic_id"));
		if(isset($this->request))
		{
			//echo $this->request->query['clinic_doc'];
			//echo $this->request->query['specialist'];
			//echo $this->request->query['near'];
			//echo $this->request->query['curr_open'];
			//echo $this->request->query['24_hr'];
			//echo $this->request->query['insurance'];
			//$clinic_doc = $this->request->query['clinic_doc'];
			//echo $this->request->query['sp_type'];
			//$from="`clinics`as c,`doctors` as d";
			
			 $order = "  id DESC";
			 
			/*Opening hours*/
			$curr_day=Date("D");
                        
                       // pr($curr_day);
                        
                       // exit;
			//echo $curr_day;
			if($curr_day=='Mon')
			$day='1';
			else if($curr_day=='Tue')
			$day='2';
			else if($curr_day=='Wed')
			$day='3';
			else if($curr_day=='Thu')
			$day='4';
			else if($curr_day=='Fri')
			$day='5';
			else if($curr_day=='Sat')
			$day='6';
			else if($curr_day=='Sun')
			$day='7';
			
			/*Timimg*/
			$curr_hr=Date("H");
			$curr_min=Date("i");
			//echo $curr_hr;
			//echo $curr_min;
			
			//echo $curr_min;
			//$today_date=date('Y-m-d');
			//$today_date_time=date('Y-m-d '.$curr_time);
			//echo "o= ".$today_date;
			//echo "p1= ".strtotime($today_date_time);
			//echo "p= ".strtotime($today_date.' 21:10');
			
			//echo $curr_time;
			//echo strtotime($curr_time);
			/*Timing*/
			
			/*Opening hours*/
			
		
			
			/*----specialist type start----*/
			$sp_type = $this->request->query['sp_type'];
			$col_type = 'type';
			$from = "";// ,specialities as Speciality
			$conditions=""; //and Speciality.id=Clinic.type and Speciality.type = $sp_type
			$get_distance = "";
			$having = "";
			/*----specialist type end-----*/
			
			/**********----------Latitude Longitude Calcualtion bu Address or Pin Code Start------------**********/
			if(!empty($this->request->query['near']))
			{
				$address=$this->request->query['near'];
				$address = str_replace(array(' ', '<', '>', '&', '{', '}', '*','@','#','$','%','^','(',')',':',';','\'','/','|','!'), array('+'), $address);
				//echo "add= ".$address;
				$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
				$json = json_decode($json);
				$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
				$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
				//echo '<br>';
				//echo $lat;
				//echo '<br>';
				//echo $long;
				
				$get_distance = " ,( 3959 * acos( cos( radians('".$lat."') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('".$long."') )+ sin( radians('".$lat."') ) * sin( radians( lat ) ) ) ) AS distance ";
				$having=" HAVING distance <=10 ";
				//echo $get_distance;
			}
		/**********----------Latitude Longitude Calcualtion bu Address or Pin Code Start------------**********/

			/*---For Dentist Search With Nothing(Blank Search) Start---*/
			if($this->request->query['clinic_doc']=='' && $this->request->query['specialist']=='' && $this->request->query['near']=='' && isset($this->request->query['curr_open']) && isset($this->request->query['24_hr']) && $this->request->query['insurance']=='')
			 {
			 //$sp_type= $this->request->query['sp_type'];
			  //echo "dfgdfgdfg ".$sp_type;
                            
			 $from = "";// ,specialities as Speciality
			 $conditions=""; //and Speciality.id=Clinic.type and Speciality.type = $sp_type
			 //  and Openinghour.clinicid=Clinic.id and Openingxhour.day=$day  and $curr_time >= fromhour and tohour >= $curr_time//
			 }
			/*---For Dentist Search With Nothing(Blank Search) End---*/
			
			/*---For Dentist Search With (Specialities Search) Start---*/
			 if(!empty($this->request->query['specialist']) || ($this->request->query['specialist']!=''))
			 {
				//echo "hhh";
				$specialities_id_arr = explode('_',$this->request->query['specialist']);
				
				$specialities_id = $specialities_id_arr[0];
				$specialities_param = $specialities_id_arr[1];

				if($specialities_param == 'par')
				{
					$col_type='type';
				}
				else if($specialities_param == 'sub')
				{
					$col_type='subtype';
				}
				$from.= "";
				$conditions.= " and Speciality.id =$specialities_id";// and Speciality.id = Clinic.$col_type 

			 }
			/*---For Dentist Search With (Specialities Search) End---*/

			/*--------IF Current Open Search OR 24hrs Open Search SET THE FROM TABLE START--------*/
			if((isset($this->request->query['curr_open'])) || (isset($this->request->query['24_hr'])))
			{
				$from.= " INNER JOIN openinghours as Openinghour ON(Clinic.id=Openinghour.clinicid)";
			}
			/*-------IF Current Open Search OR 24hrs Open Search SET THE FROM TABLE END------*/
			/*---For Dentist Search With (Current Open Search) Start---*/
			 if(isset($this->request->query['curr_open']))
			 {
				//echo "curr_open";
				$current_open=$this->request->query['curr_open'];
				
				$conditions.= " and Openinghour.day = $day and ((Openinghour.fromhour<$curr_hr and Openinghour.tohour>$curr_hr)or((Openinghour.fromhour=$curr_hr and Openinghour.fromminutes<=$curr_min)or(Openinghour.tohour=$curr_hr and Openinghour.tominutes>=$curr_min)))";
				//echo $from;

			 }
			/*---For Dentist Search With (Current Open Search) End---*/

                         /*---For Dentist Search With (24hrs Open Search) Start---*/
                        
			 if(isset($this->request->query['24_hr']))
			 {
                            
				//echo "curr_open";
				$current_open=$this->request->query['24_hr'];
				
				$conditions.= " and Openinghour.day = ".$day." and ((Openinghour.fromhour = 00 and Openinghour.tohour = 23  and Openinghour.fromminutes = 00 and Openinghour.tominutes = 59))";
				//echo $from;

			 }
			/*---For Dentist Search With (24 hrs Search) End---*/
                         
			/*---For Dentist Search With (Insurance Search) Start---*/
			 if(!empty($this->request->query['insurance']) || ($this->request->query['insurance']!=''))
			 {
				
				$insurance_id=$this->request->query['insurance'];
				//echo "insid= ".$insurance_id;
				$from.= " INNER JOIN insurancetoclinics as Insurancetoclinic ON (Clinic.id=Insurancetoclinic.clinicid)";
				$conditions.= " AND Insurancetoclinic.insuranceid=$insurance_id";
				//echo $from;

			 }
			/*---For Dentist Search With (Insurance Search) End---*/

			/*---For Dentist Search With (Client or Doctor Name Search) Start---*/			 
			 if(!empty($this->request->query['clinic_doc']) || ($this->request->query['clinic_doc']!=''))
			 {
				$clinic_doc = $this->request->query['clinic_doc'];
				$from.= "  left join `doctors` as Doctor on (Clinic.id=Doctor.clinic_id)";
				//echo $from ;
				$conditions.= "  and ((Clinic.name like '%$clinic_doc%') or((Doctor.f_name  like '%$clinic_doc%') or (Doctor.l_name  like '%$clinic_doc%'))) group by Clinic.name"; //and Speciality.type = $sp_type
				
				
			 }
			 /*---For Dentist Search With (Client or Doctor Name Search) End---*/

        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'limit' => 1,
            'order' => $order
        );


       // $search_arr = $this->Paginator->paginate('ClickDoctor');
    //  echo  $num_count = $this->ClickDoctor->paginateCount($conditions);
	$search_arr = $this->ClickDoctor->paginateCount($conditions,$from,$sp_type,$get_distance,$having,$col_type);
			
			//$query= "SELECT * FROM ".$from." where c.status=1 ".$where;
			//$h = $this->ClickDoctor->allSearch($where);
			//pr($search_arr); 
			$this->set('search',$search_arr);
		}
		
		
		
		
	}
	
	
	

}
?>
