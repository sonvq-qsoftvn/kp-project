<?php
class AppointmentsController extends AppController
{
	public $helpers = array('Html', 'Form', 'Paginator', 'WeeklyCalendar', 'Calendar', 'WeeklyCalendarClinic', 'ClinicCalendar'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator', 'WeeklyCalendar', 'Calendar', 'WeeklyCalendarClinic', 'ClinicCalendar'); //loading necessary components
	//models used
	public $uses=array('Appointment','Clinic','Openinghour','User', 'Sitesetting', 'Openinghour', 'Specialitie', 'Clinicexception', 'Cliniclike', 'Appointmentmsg');
       
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

	//Appointments :: Tabular view
	
	public function index()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the clinic id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			if($this->Session->check('msg'))
			{
				$msg=$this->Session->read('msg'); //picking up the msg
				$this->Session->delete('msg');
			}
			else
			{
				$msg='';
			}
			$this->layout='admin'; //loading admin layout
			$this->set('title_for_layout','Approve Appointments By You'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			
			//binding models for inner join
			
			$this->Appointment->bindModel(array(
						'belongsTo' => array(
							'User' => array(
											'foreignKey'=>false,
									      	'className'=>'User'
						),
						'Oh'=>array(		'foreignKey'=>false,
									      	'className'=>'Openinghour'
						),
						'Clinic'=>array(		'foreignKey'=>false,
									      	'className'=>'Clinic'
						),
					)
				),false
			);
			
			$current_date=date('Y-m-d');
			
			//=======================================pagination =====================================================================
			
			$pagination_arr=array(
			'conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$id.'" and Appointment.status="2" and Appointment.date>="'.$current_date.'"'),
			'limit' => 5,
			'order' => array('Appointment.date' => 'desc'));
			$this->Paginator->settings = $pagination_arr;
			$data = $this->Paginator->paginate('Appointment');
			
			//=======================================END pagination =====================================================================
			
			$this->set('all_appointments',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
			$this->set('clinicid',$id);
			$this->set('clinicname',$clinic['Clinic']['name']);
			
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//======================================= Appointments :: Delete =========================================================================================
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function deleteappointment()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
				
			//////////////////////////////////////////////////////////////////////////////////////////////	
			///////////////////////      validating clinic id      ///////////////////////////////////////	
			//////////////////////////////////////////////////////////////////////////////////////////////
			
			if(isset($this->params->query['clinicid']))
			{
				$clinicid=$this->params->query['clinicid']; //picking up the clinic id
			}
			
			if($clinicid==null||$clinicid==''||$clinicid==0||!$clinicid)
			{
				$this->Session->write('msg','editinvalid');			
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($clinicid);
			
			//checking whether clinic with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');		
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////    validating appointment id   ///////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(isset($this->params->query['appointmentid']))
			{
				$id=$this->params->query['appointmentid']; //picking up the appointment id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');			
				return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);  //if null or zero sending to listing page
			}
			
			//============binding models for inner join==================
			
			$this->Appointment->bindModel(
						      array(
								'belongsTo' => array(
								'User' => array(
									'foreignKey'=>false,
									'className'=>'User'
									),
								'Oh'=>array(
									'foreignKey'=>false,
									'className'=>'Openinghour'
									),
								'Clinic'=>array(
									'foreignKey'=>false,
									'className'=>'Clinic'
									),
								)
							),false
						);
			
			$appointment = $this->Appointment->find('all',array('conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$clinicid.'" and Appointment.id="'.$id.'"')));
			
			
			//========checking whether content with supplied id exists or not?===========
			
			if (!$appointment)
			{
				$this->Session->write('msg','Sorry this is a wrong request!');		
			?>
				<script>
				window.history.back();
				</script>
			<?php
			}
			
			//=============codes for deletion starts=========
			
			if ($this->Appointment->delete($id))
			{
				$this->Session->write('msg','Appoinment Deleted Successfull ');	
			?>
			<script>
			window.history.back();
			</script>
			<?php
			
				//return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);
			
			}
			//================codes for deletion ends=================
			
			$this->Session->write('msg','Sorry appoinment Delete is fail please try again !');
			?>
			<script>
			window.history.back();
			</script>
			<?php
			//return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);
			
			
		}
		else
		{
			$this->Session->write('msg','Please login !');
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	
	


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//======================================= Appointments :: Add =========================================================================================
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		
	public function addappointment()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			
			//////////////////////////////////////////////////////////////////////////////////////////////	
			///////////////////////      validating clinic id      ///////////////////////////////////////	
			//////////////////////////////////////////////////////////////////////////////////////////////
			
			if(isset($this->params->query['clinicid']))
			{
				$clinicid=$this->params->query['clinicid']; //picking up the clinic id
			}
			
			if($clinicid==null||$clinicid==''||$clinicid==0||!$clinicid)
			{
				$this->Session->write('msg','editinvalid');			
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($clinicid);
			
			//checking whether clinic with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');		
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
						
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Add APPOINTMENT FORM'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','clinics');
			$this->set('isformpage',1);
			$this->set('all_users',$this->User->find('all',array('conditions'=>'User.status=1')));
			$this->set('clinicid',$clinicid);
			$this->set('clinicname',$clinic['Clinic']['name']);
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				
				$this->Appointment->create();
				
				//creating array for save data
				
				$data_to_be_saved=$this->request->data;
				if(isset($this->request->data['multiplier']))
				$data_to_be_saved['Appointment']['multiplier']=$this->request->data['multiplier'];
				$data_to_be_saved['Appointment']['slotid']=$this->request->data['cancelledslotid'];
				$data_to_be_saved['Appointment']['status']='2';
				//serversid validation starts
				
				$error_status=0;
				if($data_to_be_saved['Appointment']['uid']=='')
				{
					$msg[]='Please select an user email id';
					$error_status=1;
				}
				if($data_to_be_saved['Appointment']['date']=='')
				{
					$msg[]='Please select an date';
					$error_status=1;
				}
				if(!isset($this->request->data['cancelledslotid']))
				{
					$msg[]='Please select a slot';
					$error_status=1;
				}
			
				//serverside validation ends
				
				if($error_status==0)
				{
					if ($this->Appointment->save($data_to_be_saved))
					{
						$this->Session->write('msg','addsuccess');	
						return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);
			
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);
				}
				$this->set('msg',$msg);
				 
				
			
			}
			else
			{
				$this->set('msg',array());
			}
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}

	// finding slotlist for an particular opening hour
	
	function slotlist2()
	{
			$slotid='';
			$dt='';
			if(isset($this->params->query['slotid']))
			{
				$slotid=$this->params->query['slotid']; //picking up the slot id

			}

			
			if(isset($this->params->query['dt']))
			{
				$dt=$this->params->query['dt']; //picking up the date

			}

			$this->layout='';
			
			$all_slots=$this->Appointment->find('all',array('conditions'=>'slotid="'.$slotid.'" and date="'.$dt.'"'));
			$the_opening_hour=$this->Openinghour->find('first',array('conditions'=>array('id'=>$slotid)));
			$this->set('the_opening_hour',$the_opening_hour);
			$this->set('all_slots',$all_slots);
			$this->set('breakup',15);
		
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//========================================ownerappointment (appoinment which already approved by clinic owner)===========================
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	function ownerappointment()
	{
	
	
		//===============================checking admin login======================
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; 	//====picking up the clinic id====
			}
			
			//=======checking whether id is not null or 0==========
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//========checking whether clinic with supplied id exists or not?=======
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics'); 	 //===if null or zero sending to listing page===
			}
			if($this->Session->check('msg'))
			{
				$msg=$this->Session->read('msg');	 //=======picking up the msg====
				$this->Session->delete('msg');
			}
			else
			{
				$msg='';
			}
			$this->layout='admin'; 	//loading admin layout
			$this->set('title_for_layout','Clinic approve Appointments'); 	// setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			
			//binding models for inner join
			
			$this->Appointment->bindModel(
						array(
							'belongsTo' => array(
							'User' => array(
									'foreignKey'=>false,
									'className'=>'User'
									),
							'Oh'=>array(	'foreignKey'=>false,
									'className'=>'Openinghour'
									),
							'Clinic'=>array(
									'foreignKey'=>false,
									'className'=>'Clinic'
									),
							)
						),false
						);
			
			$current_date=date('Y-m-d');
			
			//=======================================pagination =====================================================================
			
			$pagination_arr=array(
			'conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$id.'" and Appointment.status="1" and Appointment.date>="'.$current_date.'"'),
			'limit' => 5,
			'order' => array('Appointment.date' => 'desc'));
			$this->Paginator->settings = $pagination_arr;
			$data = $this->Paginator->paginate('Appointment');
			
			//=======================================END pagination =====================================================================
			
			$this->set('all_appointments',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
			$this->set('clinicid',$id);
			$this->set('clinicname',$clinic['Clinic']['name']);
			
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}	
	

	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//========================================Clinic peinding appoinment (appoinments which is not approved by clinic owner)===========================
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function clinicpendingappoinment()
	{
		//===============================checking admin login======================
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; 	//====picking up the clinic id====
			}
			
			//=======checking whether id is not null or 0==========
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//========checking whether clinic with supplied id exists or not?=======
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics'); 	 //===if null or zero sending to listing page===
			}
			if($this->Session->check('msg'))
			{
				$msg=$this->Session->read('msg');	 //=======picking up the msg====
				$this->Session->delete('msg');
			}
			else
			{
				$msg='';
			}
			$this->layout='admin'; 	//loading admin layout
			$this->set('title_for_layout','Pending Appointments'); 	// setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			
			//binding models for inner join
			
			$this->Appointment->bindModel(
						array(
							'belongsTo' => array(
							'User' => array(
									'foreignKey'=>false,
									'className'=>'User'
									),
							'Oh'=>array(
									'foreignKey'=>false,
									'className'=>'Openinghour'
									),
							'Clinic'=>array(
									'foreignKey'=>false,
									 'className'=>'Clinic'
									),
							)
						),false
						);
			
			$current_date=date('Y-m-d');
			
			//=======================================pagination =====================================================================
			
			$pagination_arr=array(
			'conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$id.'" and Appointment.status="0" and Appointment.date>="'.$current_date.'"'),
			'limit' => 5,
			'order' => array('Appointment.date' => 'desc'));
			$this->Paginator->settings = $pagination_arr;
			$data = $this->Paginator->paginate('Appointment');
			
			//=======================================END pagination =====================================================================
			
			$this->set('all_appointments',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
			$this->set('clinicid',$id);
			$this->set('clinicname',$clinic['Clinic']['name']);
			
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}	
		
	}
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//===============================CHANHGE STATUS ( APPROVE & DISAPPROVE )==================================================
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function changestatus()
	{
		
		//===============================checking admin login======================
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; 	//====picking up the clinic id====
				$appointmentid=$this->params->query['appointmentid'];
				$status=$this->params->query['status'];
			}
			
			//=======checking whether id is not null or 0==========
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//========checking whether clinic with supplied id exists or not?=======
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics'); 	 //===if null or zero sending to listing page===
			}
			if($this->Session->check('msg'))
			{
				$msg=$this->Session->read('msg');	 //=======picking up the msg====
				$this->Session->delete('msg');
			}
			else
			{
				$msg='';
			}
			//binding models for inner join
			
			$this->Appointment->bindModel(
						array(
							'belongsTo' => array(
							'User' => array(
									'foreignKey'=>false,
									'className'=>'User'
									),
							'Oh'=>array(
									'foreignKey'=>false,
									'className'=>'Openinghour'
									),
							'Clinic'=>array(
									'foreignKey'=>false,
									 'className'=>'Clinic'
									),
							
							)
						),false
						);
						    
			$count_val=$this->Appointment->find('count',array('conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$id.'"  and Appointment.id="'.$appointmentid.'"' )));
			
		//==================================Ststus change===========================================
			if(!empty($count_val) && !empty($clinic) )
			{
				//============ststus Checking========================
				if($status=='1'){$change_status=2;}
				elseif($status=='2'){$change_status=1;}
				
				
				$this->Appointment->id = $appointmentid;
				if($this->Appointment->saveField('status',$change_status))
				{
				
				//========================page redirection after change status======================================	
				if($status=='1')
				{
					
				$this->Session->write('msg','A new appoinmet is approve by you');	
				return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$id);
			
				}elseif($status=='2'){
				
				$this->Session->write('msg','Appoinmet disapprove successfull');	
				return $this->redirect(BASE_URL.'administrator/clinicownerappointments	?clinicid='.$id);
			
				}
				
				//========================End page redirection after change status======================================	
					
				}else{
				$this->Session->write('msg','Sorry Please try again !');	
				return $this->redirect(BASE_URL.'administrator/clinicownerappointments?clinicid='.$id);	
					
				}	
				
			//==================================END Ststus change===========================================
			
			}else{
				$this->Session->write('msg','Sorry Please try again');	
				return $this->redirect(BASE_URL.'administrator/clinicownerappointments?clinicid='.$id);	
					
			}
			
			
		}
		else
		{
			$this->Session->write('msg','Sorry you have no access !');	
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}	
		
	}
	
	
		
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//===============================PAST APPOINMENT (FROM CURRENT DATE)==================================================
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
	function pastappoinment()
	{
		
		
		//===============================checking admin login======================
		
		
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the clinic id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			if($this->Session->check('msg'))
			{
				$msg=$this->Session->read('msg'); //picking up the msg
				$this->Session->delete('msg');
			}
			else
			{
				$msg='';
			}
			$this->layout='admin'; //loading admin layout
			$this->set('title_for_layout','Past Appointments '); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			
			//binding models for inner join
			
			$this->Appointment->bindModel(array(
						'belongsTo' => array(
							'User' => array(
											'foreignKey'=>false,
									      	'className'=>'User'
						),
						'Oh'=>array(		'foreignKey'=>false,
									      	'className'=>'Openinghour'
						),
						'Clinic'=>array(		'foreignKey'=>false,
									      	'className'=>'Clinic'
						),
					)
				),false
			);
			
			$current_date=date('Y-m-d');
			
			//=======================================pagination =====================================================================
			
			$pagination_arr=array(
			'conditions'=>array('Appointment.uid=User.id and Appointment.slotid=Oh.id and Oh.clinicid=Clinic.id and Clinic.id="'.$id.'" and Appointment.date<"'.$current_date.'"'),
			'limit' => 5,
			'order' => array('Appointment.date' => 'desc'));
			$this->Paginator->settings = $pagination_arr;
			$data = $this->Paginator->paginate('Appointment');
			
			//=======================================END pagination =====================================================================
			
			$this->set('all_appointments',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
			$this->set('clinicid',$id);
			$this->set('clinicname',$clinic['Clinic']['name']);
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//===============SHOW RECENT APPOINMENTS OF USERS (FROM CURRENT DATE)=================//
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
	function appointments()
	{
		//------------------------------create captcha value-------------------------------------
		$captcha_val=chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
		@session_start();
		$this->Session->delete('captcha_val');
		$this->Session->write('captcha_val',$captcha_val);
		
		$page_limit = 5; $id = 0; $clinic_name = $clinic_cond = '';
		
		$this->layout='frontend'; //loading  layout
		$this->set('SITENAME','Booked Appointments'); 
		$this->set('METATITLE','Booked Appointments'); 
		$this->set('METADATA','Showing your booked appointments');
		
		//===============================checking user login======================
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if(isset($this->params->named['clinic']))
			{
				$id=$this->params->named['clinic']; //picking up the clinic id
				
				$clinic = $this->Clinic->findById($id);
			
				//checking whether clinic exists or not?
				
				if (!$clinic)
				{
					$this->Session->setFlash(
						'We can not find the clinic you want. Please try again.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					//return $this->redirect(BASE_URL);  //if clinic not exists, sending to clinic listing page
				}
				else
				{
					$clinic_name = $clinic['Clinic']['name'];
				}
			}
			
			if($this->request->data('show_type')==1){
				$this->set('show_type', 1);
				$condition = '>=';
			}
			elseif($this->request->data('show_type')==2){
				$this->set('show_type', 2);
				$condition = '<';
			}
			else{
				$this->set('show_type', 1);
				$condition = '>=';
			}
			
			//binding models for inner join
			
			$this->Appointment->bindModel(array(
						'belongsTo' => array(
							'User' => array(
											'foreignKey'=>false,
									      	'className'=>'User'
						),
						'Oh'=>array(		'foreignKey'=>false,
									      	'className'=>'Openinghour'
						),
						'Clinic'=>array(		'foreignKey'=>false,
									      	'className'=>'Clinic'
						),
					)
				),false
			);
			
			$current_date=date('Y-m-d');
			
			//condition check for specific clinic appointments
			if($id > 0 && !empty($clinic)){
				$clinic_cond = 'and Clinic.id = "'.$id.'"';
			}
			
			
			//condition check for specific date of appointments
			if($this->request->data('appointment_date'))
			{
				$current_date = date('Y-m-d', strtotime($this->request->data('appointment_date')));
				$condition = '=';
			}
				
			//condition check for specific clinic appointments	
			if($this->request->data('clinic_id'))
			{
				$clinic_cond .= 'Appointment.date = '.date('Y-m-d', strtotime($this->request->data('appointment_date')));
			}
			
			//=======================================pagination =====================================================================
			
			$pagination_arr=array( 'conditions' => array( 'Appointment.uid = User.id and Appointment.slotid = Oh.id and Oh.clinicid = Clinic.id '.$clinic_cond.' and Appointment.date '.$condition.' "'.$current_date.'"' ),
							   'limit' => $page_limit,
			                       'order' => array('Appointment.date' => 'desc')
							);
			$this->Paginator->settings = $pagination_arr;
			$data = $this->Paginator->paginate('Appointment');
			
			//=======================================END pagination =====================================================================
			
			$this->set('all_appointments',$data);
			$this->set('page_limit', $page_limit);
			
			
			
			//pr($data);
			
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}	

	//Start of appointment details function
	public function appointments_details()
	{
		$det='';
		$this->autoRender = false; // We don't render a view in this example
		$this->request->onlyAllow('ajax'); // No direct access via browser URL
	  
		if($this->params->named['id'])
		{
			$app_details = $this->Appointment->find('first',array('conditions'=>'id="'.$this->params->named['id'].'"'));
			$slot_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$app_details['Appointment']['uid'].'"'));
			
			$det = '<select name="slots" class="custom-select"><option value="">Select a slot</option>';
			foreach($slot_details as $slots)
			{
				if($slots['Openinghour']['id']==$app_details['Appointment']['slotid']){$sec='selected';}else{$sec='';}
				$det .= '<option '.$sec.' value="'.$slots['Openinghour']['id'].'">'.$slots['Openinghour']['fromhour'].'.'.$slots['Openinghour']['fromminutes'].' - '.$slots['Openinghour']['tohour'].'.'.$slots['Openinghour']['tominutes'].'</option>';
				
			}
			$det .= '</select>';
			
			return date('m/d/Y', strtotime($app_details['Appointment']['date'])).'|@|'.$app_details['Appointment']['slotid'].'|@|'.$det;
		}
	}
	
	//Start function of booking appointments user//
	public function book_appointment()
	{
		$req_date = $total = $status = '';
		
		$this->layout='frontend'; //loading  layout
		$this->set('SITENAME','Book An Appointment'); 
		$this->set('METATITLE','Book An Appointment'); 
		$this->set('METADATA','Book a new appointment');
		
		//===============================checking user login======================
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if(isset($this->params->named['clinic']) && $this->params->named['clinic'] >0) $clinic_id = $this->params->named['clinic'];
			else $clinic_id = 0;
			
			if($clinic_id > 0)
			{
				$clinic_ext = $this->Clinic->find('count',array('conditions'=>'id="'.$clinic_id.'"'));
				
				if($clinic_ext==0)
				{
					$this->Session->setFlash(
						'Clinic not found. Please try another.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'clinics/clintlist');  //if no clinic sending to appointment page
				}
				else
				{
					$dia = date ("d"); $mes = date ("n"); $ano = date ("Y");
					
					$current_month = date('m');
					$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$clinic_id.'"'));
					
					$clinic_open_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$clinic_id.'"', 'group' => array('day')));
					$days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
					$day_avilable = array();
					
					foreach($clinic_open_details as $clinic_open)
					{
						$day_avilable[] = 	$days[($clinic_open['Openinghour']['day'])-1];
					}
					
					if(empty($day_avilable)){
						$total = '';
						$status = 0;
					}
					else
					{	
						$total = 'Clinic opens on '.implode(', ', $day_avilable);
						$status = 1;
					}
					
					
					if(isset($this->params->named['cal']))
						$cal_type = $this->params->named['cal'];
					else
						$cal_type = 'month';
					
					if($this->request->data('cal_date') || $this->request->data('cal_month') || $this->request->data('cal_year'))
					{
						$dia = ($this->request->data('cal_date')) ? $this->request->data('cal_date') : date ("d");
						$mes = ($this->request->data('cal_month')) ? $this->request->data('cal_month') : date ("n");
						$ano = ($this->request->data('cal_year')) ? $this->request->data('cal_year') : date ("Y");
						
						if($this->request->data('req_type')==2)
						{
							$req_date = date('m/d/Y', strtotime($this->request->data('req_date')));
						}
					}
					
					$this->set('dia', $dia);
					$this->set('mes', $mes);
					$this->set('ano', $ano);
					
					$this->set('clinic_details', $clinic_details);
					$this->set('cal_type', $cal_type);
					$this->set('req_date', $req_date);
					
					$this->set('sec_clinic', $clinic_id);
					$this->set('clinic_open_status_msg', $total);
					$this->set('clinic_open_status', $status);
				}
			}
			else
			{
				$this->Session->setFlash(
					'Please choose a clinic to book an appointment',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'clinics/clintlist');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
		
	}
	
	//Get clinic opening dates
	public function clinic_date_details()
	{
		$det='';
		$this->autoRender = false; // We don't render a view in this example
		$this->request->onlyAllow('ajax'); // No direct access via browser URL
	  
		if($this->params->named['id'])
		{
			$clinic_open_details = $this->Openinghour->find('all',array('conditions'=>'clinicid="'.$this->params->named['id'].'"', 'group' => array('day')));
			$days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
			$day_avilable = array();
			
			foreach($clinic_open_details as $clinic_open)
			{
				$day_avilable[] = 	$days[($clinic_open['Openinghour']['day'])-1];
			}
			
			if(empty($day_avilable)){
				$total = 'This clinic is not avilable for booking yet.';
				$status = 0;
			}
			else
			{
				if(count($day_avilable) > 1)
					$concat = ' are avilable';
				else
					$concat = ' is avilable';
					
				$total = implode(', ', $day_avilable).$concat;
				$status = 1;
			}
			
			return $total.'@'.$status;
		}
	}
	
	//Gathering information for booking appointment
	function start_booking()
	{
		$this->autoRender = false; // We don't render a view in this example
		$this->request->onlyAllow('ajax'); // No direct access via browser URL
		
		//------------------------------create captcha value-------------------------------------
		$captcha_val=chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
		@session_start();
		$this->Session->delete('captcha_val');
		$this->Session->write('captcha_val',$captcha_val);
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if ($this->request->is(array('post', 'put')))
			{
				$clinic_id 		= $this->request->data('clinic_id');
				$booking_date 		= $this->request->data('booking_date');
				$booking_start_time = $this->request->data('booking_start_time');
				$booking_end_time 	= $this->request->data('booking_end_time');
				$open_slot_id 		= $this->request->data('open_slot_id');
				$slot_multiplier	= $this->request->data('slot_multiplier');
				
				$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$clinic_id.'"'));
				$booking_date_fn = date('m/d/Y', strtotime($booking_date));
				
				$user_details = $this->User->find('first',array('conditions'=>'id="'.$this->Session->read('reid_user_uid').'"'));
				
				$booking_time = $booking_start_time.' - '.$booking_end_time;
				
				return '1'.'|@|'.$clinic_details['Clinic']['name'].'|@|'.$booking_date_fn.'|@|'.$booking_time.'|@|'.$booking_start_time.'|@|'.$booking_end_time.'|@|'.$open_slot_id.'|@|'.$slot_multiplier;
			}
			else
			{
				return '2|@|No appointment booking information found. Please try again';  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return '2|@|You are logged out. Please login again to continue';  //if no clinic sending to appointment page
		}
	}
	
	//Start function of complete booking
	public function complete_booking()
	{
		$uid = $this->Session->read('reid_user_uid');
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if ($this->request->is(array('post', 'put')))
			{
				$clinic_id 		= $this->request->data('clinic_id');
				$booking_date 		= $this->request->data('booking_date');
				$booking_start_time = $this->request->data('booking_start_time');
				$booking_end_time 	= $this->request->data('booking_end_time');
				$open_slot_id 		= $this->request->data('booking_slot_id');
				$slot_multiplier	= $this->request->data('booking_slot_multiplier');
				$message 			= $this->request->data('booking_reason');
				
				$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$clinic_id.'"'));
				$booking_date_fn = date('m/d/Y', strtotime($booking_date));
				
				$user_details = $this->User->find('first',array('conditions'=>'id="'.$this->Session->read('reid_user_uid').'"'));
				
				if($user_details['User']['first_name'])
					$user_name = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
				else
					$user_name = $user_details['User']['username'];
				
				$booking_time = $booking_start_time.' - '.$booking_end_time;
				
				if($this->request->data('book_user_type') == 1)
					$uid = $this->Session->read('reid_user_uid');
				elseif($this->request->data('book_user_type') == 2)
					$uid = $this->request->data('user_sec');
				else
					$uid = $this->Session->read('reid_user_uid');
				
				$data_to_be_saved['uid']			=	$uid;
				$data_to_be_saved['clinic_id']	=	$clinic_id;
				$data_to_be_saved['date']		=	date('Y-m-d', strtotime($booking_date));
				$data_to_be_saved['slotid']		=	$open_slot_id;
				$data_to_be_saved['multiplier']	=	$slot_multiplier;
				$data_to_be_saved['mesage']		=	$message;
				$data_to_be_saved['added_on']		=    date('Y-m-d H:i:s');
				
				if($this->request->data('book_user_type') == 1) //for normal booking
					$data_to_be_saved['status']		=	0;
				elseif($this->request->data('book_user_type') == 2) //for clinic manager booking, we confirmed this booking
					$data_to_be_saved['status']		=	2;
				else
					$data_to_be_saved['status']		=	0;
				
				$this->Appointment->create();
				if($this->Appointment->save($data_to_be_saved))
				{
					$appointment_id  = $this->Appointment->getLastInsertId();
					
					$this->Session->setFlash(
						'Appointment booked successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					
					if($this->request->data('book_user_type') == 1)
					{
						//notification to clinic manager
						$msg = 'You have a new pending appointment, booked by '.$user_name.' on '.$booking_date.'('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') at <a href="'.BASE_URL.'appointments/clinic_appointments">'.$clinic_details['Clinic']['name'].'</a>.';
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $clinic_details['Clinic']['clinicmanagersid'];
						$data_save['reciver_type'] 			= 2;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg;
						$data_save['added_date'] 			= date('Y-m-d');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						//notification to user
						$msg1 = 'Your appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.$booking_date.' ('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') is booked successfully. However it\'s pending for approveal, you will be notified when it confirmed.';
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $this->Session->read('reid_user_uid');
						$data_save['reciver_type'] 			= 1;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg1;
						$data_save['added_date'] 			= date('Y-m-d H:i:s');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					}
					elseif($this->request->data('book_user_type') == 2)
					{
						$msg = 'You have a new appointment on '.$booking_date.' ('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') at <a href="'.BASE_URL.'appointments/clinic_appointments">'.$clinic_details['Clinic']['name'].'</a>.';
						
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $this->request->data('user_sec');
						$data_save['reciver_type'] 			= 1;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg;
						$data_save['added_date'] 			= date('Y-m-d H:i:s');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
					}
					else
					{
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					}
				}
				else
				{
					$this->Session->setFlash(
						'Failed to book your appointment. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					if($this->request->data('book_user_type') == 1)
						return $this->redirect(BASE_URL.'appointments/book_appointment/clinic:'.$clinic_id.'/cal:week');  
					elseif($this->request->data('book_user_type') == 2)
						return $this->redirect(BASE_URL.'appointments/clinic_appointments');  
					else
						return $this->redirect(BASE_URL.'appointments/book_appointment/clinic:'.$clinic_id.'/cal:week');  
				}
			}
			else
			{
				$this->Session->setFlash(
					'Please choose a clinic to book an appointment',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				
				if($this->request->data('book_user_type') == 1)
					return $this->redirect(BASE_URL.'appointments/appointments');  
				elseif($this->request->data('book_user_type') == 2)
					return $this->redirect(BASE_URL.'appointments/clinic_appointments');  
				else
					return $this->redirect(BASE_URL.'appointments/appointments'); 
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if no clinic sending to appointment page
		}
	}
	
	
	//List of all appointments for clinic master
	public function clinic_appointments()
	{
		$page_limit = 5; $id = 0; $clinic_name = $clinic_cond = '';
		
		$this->layout='frontend'; //loading  layout
		$this->set('SITENAME','All clinics appointments'); 
		$this->set('METATITLE','All clinics appointments'); 
		$this->set('METADATA','Showing appointments of all your clinics');
                
                
                //===================================auto complate===================================
                
                
                
                $suggested_names= $this->Clinic->find('list',array('fields'=>array('Clinic.name')));	
										
		//pr($suggested_names);				
							$i=0;
							$x='';
							foreach($suggested_names as $k=>$v)
							{
								if($i!=0)
								{$x.= ',';}
								$x.= "'".$v."'";
								$i++;
							}
								
				$this->set('dat',$x);
                
                
		
		//===============================checking user login======================
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			//binding models for inner join
			
			$clinic_manger_id = $this->Session->read('reid_user_uid');
			
			if ($this->request->is(array('post', 'put')))
			{
				$clinic_cond = "Clinic.name LIKE '%".$this->request->data('clinic_name')."%'";
			}
			
			// we prepare our query, the cakephp way!
			$this->paginate = array(
			    'conditions' => array('Clinic.clinicmanagersid' => $clinic_manger_id, 'status' => 1, $clinic_cond),
			    'limit' => $page_limit,
			    'order' => array('Clinic.name' => 'asc')
			);
			
			// we are using the 'Clinic' model
			$all_clinics = $this->paginate('Clinic');
			
			if(!empty($all_clinics))
			{
				foreach($all_clinics as $k=>$all_clinic)
				{
					$speciality_info = $this->Specialitie->find('first',array('conditions'=>'Specialitie.id="'.$all_clinic['Clinic']['type'].'"'));
					
					$total_appointments = $this->Appointment->find('all',array('conditions'=>'Appointment.clinic_id="'.$all_clinic['Clinic']['id'].'"'));
					
					$data[$k][] = $all_clinic;
					$data[$k][] = $total_appointments;
					$data[$k][] = $speciality_info;
				}
			}
			else
			{
				$data = array();
			}
			
			$this->set('all_appointments',$data);
			$this->set('page_limit', $page_limit);
			$this->set('request_clinic', $this->request->data('clinic_name'));
			$this->set('show_type', 0);
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	public function calculate_all_dates($d)
	{
		
		$arr=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		$d_day=date('l',strtotime($d));
		$x=array_search($d_day,$arr);
		$return_arr=array();
		$return_arr[$x]=$d;
		for($i=$x-1,$count=1;$i>=0;$i--,$count++)
		{
			$datetime = new DateTime($d);
			$datetime->modify('-'.$count.' day');

			$return_arr[$i]=$datetime->format('Y-m-d');
		}
		for($i=$x+1,$count=1;$i<=6;$i++,$count++)
		{
			$datetime = new DateTime($d);
			$datetime->modify('+'.$count.' day');

			$return_arr[$i]=$datetime->format('Y-m-d');
		}
		//pr($return_arr);
		//exit;
		return $return_arr;
		
	}
	//list of clinic and their details from clinic manager view
	public function clinic_appointment_details()
	{
		//-----------------create captcha value---------------------------//
		$captcha_val=chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
		@session_start();
		$this->Session->delete('captcha_val');
		$this->Session->write('captcha_val',$captcha_val);
		// end///
		
		/*-------------All active user start-----------------*/
		
		$all_active_users = $this->User->find('all', array('conditions'=>'status=1','user_type=1','order'=>array('User.username'=>'desc')));
		
		$user_array = '';
		foreach($all_active_users as $each_user)
		{
			$user_array .= '<option value="'.$each_user['User']['id'].'">'.ucwords($each_user['User']['username']).'</option>';
		}
		$this->set('user_array', $user_array);
		//exit;
		/*------------All active user start---------------*/
		if(!isset($this->params->named['date']))
		{
			$the_date=date('Y-m-d');
		}
		else
		{
			$the_date=$this->params->named['date'];
		}
		$all_dates=$this->calculate_all_dates($the_date);
		$this->set('all_dates',$all_dates);
		$this->set('the_date',$the_date);
		$page_limit = 5; $id = 0; $clinic_name = $clinic_cond = $all_liked_users = $user_details = $user_array = '';
		
		$this->layout='frontend'; //loading  layout
		$this->set('SITENAME','All appointments'); 
		$this->set('METATITLE','All appointments'); 
		$this->set('METADATA','Showing appointments of your clinic');
		
		//===============================checking user login======================
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			$req_date = '';
			
			if($this->params->named['id'])
			{
				$id = $this->params->named['id'];
				
				$clinic = $this->Clinic->findById($id);
			
				//checking whether clinic exists or not?
				
				if (!$clinic)
				{
					$this->Session->setFlash(
						'We can not find the clinic you want. Please try again.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if clinic not exists, sending to clinic listing page
				}
				else
				{
					$clinic_name = $clinic['Clinic']['name'];
				}
				
				/*===== Appointment table and user bind =====*/
				$this->Appointment->bindModel(array(
						'belongsTo' => array(
							'User' => array('foreignKey' => 'uid',
									      'className'=>'User'
						)
					)
				)
			);
				$appo_datas = $this->Appointment->find('all',array('conditions'=>array('clinic_id'=>$id,'date >='=>$all_dates[0],'date <='=>$all_dates[6])));
				//pr($appo_datas);
				
				$appointments=array();
				foreach($appo_datas as $k=>$v)
				{
					$appointments[$v['Appointment']['rownum']][array_search($v['Appointment']['date'],$all_dates)]=$v['Appointment'];
					$appointments[$v['Appointment']['rownum']][array_search($v['Appointment']['date'],$all_dates)]['user_details']=$v['User'];
					
				}
				$this->set('appointments',$appointments);
				
				$current_date=date('Y-m-d');
				
				//condition check for specific clinic appointments
				if($id > 0 && !empty($clinic)){
					$clinic_cond = 'and Clinic.id = "'.$id.'"';
				}
				
				
				//condition check for specific date of appointments
				if($this->request->data('appointment_date'))
				{
					$current_date = date('Y-m-d', strtotime($this->request->data('appointment_date')));
					$condition = '=';
				}
				
				
				
/*==============================*/
				
				
				/*=========*/
				$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$id.'"'));
				
				
				$this->set('clinic_details', $clinic_details);
				
				$this->set('clinic_id', $id);
				$this->set('opening_hours',$this->Openinghour->find('all',array('conditions'=>array('clinicid'=>$id))));
				/*
				 *CALCULATE the time intervals here for days(0-6)
				 */
				
				/*******Determine slots for particular day*********/
				
				
				///////////////////////////////////////////////
				$this->set('time_arr',array('0'=>15,'1'=>15,'2'=>15,'3'=>15,'4'=>10,'5'=>10,'6'=>10));
			}
			else
			{
				$this->Session->setFlash(
					'Please choose a clinic to view its appointment',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
		
		
		/*-------25-11-2014------*/
		
	}
	
	//Confirm an appointment
	public function confirm_appointment()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if($this->params->named['clinic'])
			{
				if($this->params->named['id'])
				{
					$data_to_dave['id'] = $this->params->named['id'];
					$data_to_dave['status'] = 2;
					
					$appointment_details = $this->Appointment->find('first', array('conditions'=>'id="'.$this->params->named['id'].'"'));
					
					$clinic_details = $this->Clinic->find('first', array('conditions'=>'id="'.$appointment_details['Appointment']['clinic_id'].'"'));
					
					if($this->Appointment->save($data_to_dave))
					{
						$this->Session->setFlash(
							'Successfully confirmed this appointment.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
						
						if($this->Session->read('reid_user_type') == 1)
						{
							//notification to clinic manager
							$msg1 = 'User confirmed appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.date('m/d/Y', strtotime($appointment_details['Appointment']['date'])).'.';
							
							$data_save['sender_id'] 				= 0;
							$data_save['sender_type'] 			= 0;
							$data_save['reciver_id'] 			= $clinic_details['Clinic']['clinicmanagersid'];
							$data_save['reciver_type'] 			= 1;
							$data_save['appointment_id'] 			= $appointment_details['Appointment']['id'];
							$data_save['status'] 				= 1;
							$data_save['send_notification'] 		= 1;
							$data_save['message'] 				= $msg1;
							$data_save['added_date'] 			= date('Y-m-d H:i:s');
							$data_save['send_notification_count'] 	= 1;
							
							$this->Appointmentmsg->create();
							$this->Appointmentmsg->save($data_save);
							
							return $this->redirect(BASE_URL.'appointments/appointments/appointments');
						}
						else
						{
							//notification to user
							$msg1 = 'Your appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.date('m/d/Y', strtotime($appointment_details['Appointment']['date'])).' is confirmed.';
							
							$data_save['sender_id'] 				= 0;
							$data_save['sender_type'] 			= 0;
							$data_save['reciver_id'] 			= $appointment_details['Appointment']['uid'];
							$data_save['reciver_type'] 			= 1;
							$data_save['appointment_id'] 			= $appointment_details['Appointment']['id'];
							$data_save['status'] 				= 1;
							$data_save['send_notification'] 		= 1;
							$data_save['message'] 				= $msg1;
							$data_save['added_date'] 			= date('Y-m-d H:i:s');
							$data_save['send_notification_count'] 	= 1;
							
							$this->Appointmentmsg->create();
							$this->Appointmentmsg->save($data_save);
							
							return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->params->named['clinic'].'/cal:week');
						}
					}
					else
					{
						$this->Session->setFlash(
							'Sorry, failed to conform this appointment. Please try again',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->params->named['clinic'].'/cal:week');  //if no clinic sending to appointment page
					}
				}
				else
				{
					$this->Session->setFlash(
						'Sorry, no appointment found. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
				}
			}
			else
			{
				$this->Session->setFlash(
					'Sorry, no appointment found. Please try again',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments/');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	
	//Block a slot for a specific day fromclinic manager
	public function blook_app_slot()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if($this->params->named['clinic'])
			{
				if($this->params->named['slot_id'] && $this->params->named['slot_pos'])
				{
					$data_to_dave['exceptiondate'] = date('Y-m-d', $this->params->named['date']);
					$data_to_dave['clinicid'] = $this->params->named['clinic'];
					$data_to_dave['cancelledslotid'] = $this->params->named['slot_id'];
					$data_to_dave['slot_multiplier'] = $this->params->named['slot_pos'];
					
					if($this->Clinicexception->save($data_to_dave))
					{
						$this->Session->setFlash(
							'Successfully blocked this appointment slot.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
						return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->params->named['clinic'].'/cal:week');  //if no clinic sending to appointment page
					}
					else
					{
						$this->Session->setFlash(
							'Sorry, failed to conform this appointment. Please try again',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->params->named['clinic'].'/cal:week');  //if no clinic sending to appointment page
					}
				}
				else
				{
					$this->Session->setFlash(
						'Sorry, no appointment found. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
				}
			}
			else
			{
				$this->Session->setFlash(
					'Sorry, no appointment found. Please try again',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments/');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	
	//Function to delete appointment
	function delete_appointment()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if($this->params->named['id'])
			{
				$appointment_details = $this->Appointment->find('first', array('conditions'=>'id="'.$this->params->named['id'].'"'));
					
				$clinic_details = $this->Clinic->find('first', array('conditions'=>'id="'.$appointment_details['Appointment']['clinic_id'].'"'));
				
				if($this->Appointment->delete($this->params->named['id']))
				{
					//notification to user
					$msg1 = 'Your appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.date('m/d/Y', strtotime($appointment_details['Appointment']['date'])).' is canceled. Please book another appointment.';
					
					$data_save['sender_id'] 				= 0;
					$data_save['sender_type'] 			= 0;
					$data_save['reciver_id'] 			= $appointment_details['Appointment']['uid'];
					$data_save['reciver_type'] 			= 1;
					$data_save['appointment_id'] 			= 0;
					$data_save['status'] 				= 1;
					$data_save['send_notification'] 		= 1;
					$data_save['message'] 				= $msg1;
					$data_save['added_date'] 			= date('Y-m-d H:i:s');
					$data_save['send_notification_count'] 	= 1;
					
					$this->Appointmentmsg->create();
					$this->Appointmentmsg->save($data_save);
					
					$this->Session->setFlash(
						'Appointment deleted successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					
					if($this->Session->read('reid_user_type') == 1)
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					else
						return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
				}
				else
				{
					$this->Session->setFlash(
						'Sorry, failed to delete appointment. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					if($this->Session->read('reid_user_type') == 1)
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					else
						return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
				}
			}
			else
			{
				$this->Session->setFlash(
					'Sorry, no appointment found. Please try again',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	
	//delete exception slots
	function delete_exception()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if($this->params->named['id'] > 0 && $this->params->named['clinic'] > 0)
			{
				if($this->Clinicexception->delete($this->params->named['id']))
				{
					$this->Session->setFlash(
						'Successfully open this slot.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->params->named['clinic'].'/cal:week');  //if no clinic sending to appointment page
				}
				else
				{
					$this->Session->setFlash(
						'Sorry, failed to open this slot. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/'.$this->params->named['clinic'].'/cal:week');  //if no clinic sending to appointment page
				}
			}
			else
			{
				$this->Session->setFlash(
					'Sorry, no details found. Please try again',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	
	
	//function for edit booking status
	public function edit_booking()
	{
		$opening_slots = '<option value="">Select a booking slot</option>'; $slot_ids = array();
		
		$this->autoRender = false; // We don't render a view in this example
		$this->request->onlyAllow('ajax'); // No direct access via browser URL
		
		//------------------------------create captcha value-------------------------------------
		$captcha_val=chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
		@session_start();
		$this->Session->delete('captcha_val');
		$this->Session->write('captcha_val',$captcha_val);
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if ($this->request->is(array('post', 'put')))
			{
				$clinic_id 		= $this->request->data('clinic_id');
				$appointment_id 	= $this->request->data('appointment_id');
				$booking_start_time = $this->request->data('start_time');
				
				$appointment_details = $this->Appointment->find('first',array('conditions'=>'id="'.$appointment_id.'"'));
				
				$booking_date 		= $appointment_details['Appointment']['date'];
				$open_slot_id 		= $appointment_details['Appointment']['slotid'];
				$slot_multiplier	= $appointment_details['Appointment']['multiplier'];
				
				//$clinic_id 		= '6';
				//$booking_date 		= '2014-11-12';
				//$booking_start_time = '06:15';
				//$booking_end_time 	= '06:30';
				//$open_slot_id 		= '3';
				//$slot_multiplier	= '2';
				//$appointment_id 	= '34';
				
				$booking_date_fn = date('d/m/Y', strtotime($booking_date));
				
				$booking_date_num = date('N', strtotime($booking_date));
				
				$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$clinic_id.'"'));
				$time_diff = $clinic_details['Clinic']['slot_time_diff'];
				
				$user_details = $this->User->find('first',array('conditions'=>'id="'.$this->Session->read('reid_user_uid').'"'));
				
				if($user_details['User']['first_name'])
					$username = $user_details['User']['first_name'].' '.$user_details['User']['last_name'];
				else
					$username = $user_details['User']['username'];
				
				$current_slots = $this->Openinghour->find('all',array('conditions'=>'clinicid = "'.$clinic_id.'" AND day = "'.$booking_date_num.'"'));
				
				foreach($current_slots as $s=>$current_slot)
				{
					$slot_time_hr_s = $current_slot['Openinghour']['fromhour'];
					$slot_time_min_s = $current_slot['Openinghour']['fromminutes'];
					
					$slot_time_hr_e = $current_slot['Openinghour']['tohour'];
					$slot_time_min_e = $current_slot['Openinghour']['tominutes'];
					
					$booked_time_hr_e = $slot_time_hr_s;
					$booked_time_min_e = $slot_time_min_s + (floor($time_diff * $slot_multiplier));
					if($booked_time_min_e >= 60)
					{
						$booked_time_hr_e = $booked_time_hr_e + floor( $booked_time_min_e / 60 );
						$booked_time_min_e = floor( $booked_time_min_e % 60 );
					}
					
					$find_exceptions = $this->Clinicexception->find('all',array('conditions'=>'clinicid = "'.$clinic_id.'" AND exceptiondate = "'.$booking_date.'" AND cancelledslotid = "'.$current_slot['Openinghour']['id'].'"'));
					
					if(!empty($find_exceptions))
					{
						foreach($find_exceptions as $find_exception)
						{
							$slot_ids[] = $find_exception['Clinicexception']['slot_multiplier'];
						}
					}
					
					$slot_id = 0;
					
					for ($i = $slot_time_hr_s; $i < $slot_time_hr_e; $i++)
                         {
						$inner_loops = floor(60 / $time_diff);
							
						if($inner_loops > 1)
						{
							for($t=1;  $t<=$inner_loops; $t++)
							{
								$slot_id++;
								
								$start_time = date('H:i', strtotime($i.':'.(($time_diff * $t) - $time_diff)));
								if(($time_diff * $t) == 60)
									$end_time = date('H:i', strtotime(($i+1).':00'));
								else
									$end_time = date('H:i', strtotime($i.':'.($time_diff * $t)));
								
								if(($booking_start_time != $start_time))
								{
									if(!in_array($slot_id, $slot_ids))
									{
										$opening_slots .= '<option value="'.$current_slot['Openinghour']['id'].'-'.$slot_id.'" >'.$start_time.' to '.$end_time.'</option>';
									}
								}
							}
						}
					}
				}
				
				return '1'.'|@|'.$username.'|@|'.date('m/d/Y', strtotime($booking_date)).'|@|'.$opening_slots;
			}
			else
			{
				return '2|@|No appointment booking information found. Please try again.';  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return '2|@|You are logged out. Please login again to continue';  //if no clinic sending to appointment page
		}
	}
	
	//reshedule appointment
	public function reshedule_appointment()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			if($this->request->data('booking_id_re'))
			{
				$booking_det = $this->request->data('booking_time_re');
				$booking_det_ar = explode('-', $booking_det);
				
				$slot_id 			= trim($booking_det_ar[0]);
				$slot_multiplier 	= trim($booking_det_ar[1]);
				
				$appointment_details = $this->Appointment->find('first',array('conditions'=>'id="'.$this->request->data('booking_id_re').'"'));
				
				if($slot_id > 0 && $slot_multiplier > 0)
				{
					$data_saved['id'] 		 = $this->request->data('booking_id_re');
					$data_saved['slotid'] 	 = $slot_id;
					$data_saved['multiplier'] = $slot_multiplier;
					
					if($this->Session->read('reid_user_type') == 1)
						$data_saved['status']     = 0;
					else
						$data_saved['status']     = 1;
					
					if($this->Appointment->save($data_saved))
					{
						$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$this->request->data('clinic_id').'"'));
						
						if($this->Session->read('reid_user_type') == 1)
						{
							//notification to clinic manager
							$msg1 = 'User have resheduled an appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.$this->request->data('booking_date').'. Please check new appointment time and confirm to continue.';
							
							$data_save['sender_id'] 				= 0;
							$data_save['sender_type'] 			= 0;
							$data_save['reciver_id'] 			= $clinic_details['Clinic']['clinicmanagersid'];
							$data_save['reciver_type'] 			= 1;
							$data_save['appointment_id'] 			= $appointment_details['Appointment']['id'];
							$data_save['status'] 				= 1;
							$data_save['send_notification'] 		= 1;
							$data_save['message'] 				= $msg1;
							$data_save['added_date'] 			= date('Y-m-d H:i:s');
							$data_save['send_notification_count'] 	= 1;
							
							$this->Appointmentmsg->create();
							$this->Appointmentmsg->save($data_save);
							
							$this->Session->setFlash(
								'Appointment resheduled successfully.',
								'default',
								array('class' => 'page_top_success'),
								'update_error'
							);
							return $this->redirect(BASE_URL.'appointments/appointments/appointments');
						}
						else
						{
							//notification to user
							$msg1 = 'Your appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.$this->request->data('booking_date').' is resheduled. Please check new appointment time and confirm to continue.';
							$data_save['sender_id'] 				= 0;
							$data_save['sender_type'] 			= 0;
							$data_save['reciver_id'] 			= $appointment_details['Appointment']['uid'];
							$data_save['reciver_type'] 			= 1;
							$data_save['appointment_id'] 			= $appointment_details['Appointment']['id'];
							$data_save['status'] 				= 1;
							$data_save['send_notification'] 		= 1;
							$data_save['message'] 				= $msg1;
							$data_save['added_date'] 			= date('Y-m-d H:i:s');
							$data_save['send_notification_count'] 	= 1;
							
							$this->Appointmentmsg->create();
							$this->Appointmentmsg->save($data_save);
							
							$this->Session->setFlash(
								'Appointment resheduled successfully.',
								'default',
								array('class' => 'page_top_success'),
								'update_error'
							);
							return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->request->data('clinic_id').'/cal:week');
						}
					}
					else
					{
						$this->Session->setFlash(
							'Failed to reshedule appointment',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->request->data('clinic_id').'/cal:week');  
					}
				}
				else
				{
					$this->Session->setFlash(
						'Failed to reshedule appointment',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					return $this->redirect(BASE_URL.'appointments/clinic_appointment_details/id:'.$this->request->data('clinic_id').'/cal:week');  
				}
			}
			else
			{
				$this->Session->setFlash(
					'Please choose a clinic to book an appointment',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
			}
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);  //if no clinic sending to appointment page
		}
	}
	
	
	/**============Save booking  in table============**/
	
	
	function saveBooking()
	{
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
		//pr($this->request->data);
		
		//exit;
		
		//$this->Appointment->create();
				
				//creating array for save data
				$clinicid = $this->request->data['clinic_id'];
				$clinic_details = $this->Clinic->find('first',array('conditions'=>'id="'.$clinicid.'"'));
				
				$data_to_be_saved=$this->request->data;
				if(isset($this->request->data['rownum']))
				$data_to_be_saved['Appointment']['rownum']=$this->request->data['rownum'];
				$data_to_be_saved['Appointment']['uid']=$this->request->data['uid'];
				$data_to_be_saved['Appointment']['clinic_id']=$this->request->data['clinic_id'];
				$data_to_be_saved['Appointment']['mesage']=$this->request->data['msg'];
				$data_to_be_saved['Appointment']['date']=$this->request->data['booking_date'];
				$data_to_be_saved['Appointment']['added_on']=date('Y-m-d H:i:s');
				if($this->request->data['book_user_type']==2) /*the clinic manager*/
				{
					$data_to_be_saved['Appointment']['status']=1;/*Need approval from user*/
				}
				elseif($this->request->data['book_user_type']==1)
				{
						$data_to_be_saved['Appointment']['status']=0;/*/*Need approval from Clinicmanager*/*/
				}
				
				//serversid validation starts
				
				$error_status=0;
				if($data_to_be_saved['Appointment']['uid']=='')
				{
					$msg[]='Please select an user name';
					$error_status=1;
				}
				if($data_to_be_saved['Appointment']['date']=='')
				{
					$msg[]='Please select an date';
					$error_status=1;
				}
				
			
				//serverside validation ends
				
				if($error_status==0)
				{
					if ($this->Appointment->save($data_to_be_saved))
					{
						
					$appointment_id  = $this->Appointment->getLastInsertId();
					
					$this->Session->setFlash(
						'Appointment booked successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					
					if($this->request->data('book_user_type') == 1)
					{
						//notification to clinic manager
						$msg = 'You have a new pending appointment, booked by '.$user_name.' on '.$booking_date.'('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') at <a href="'.BASE_URL.'appointments/clinic_appointments">'.$clinic_details['Clinic']['name'].'</a>.';
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $clinic_details['Clinic']['clinicmanagersid'];
						$data_save['reciver_type'] 			= 2;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg;
						$data_save['added_date'] 			= date('Y-m-d');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						//notification to user
						$msg1 = 'Your appointment at <a href="'.BASE_URL.'clinics/clincwall/'.$clinic_details['Clinic']['id'].'">'.$clinic_details['Clinic']['name'].'</a> on '.$booking_date.' ('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') is booked successfully. However it\'s pending for approveal, you will be notified when it confirmed.';
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $this->Session->read('reid_user_uid');
						$data_save['reciver_type'] 			= 1;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg1;
						$data_save['added_date'] 			= date('Y-m-d H:i:s');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					}
					elseif($this->request->data('book_user_type') == 2)
					{
						$msg = 'You have a new appointment on '.$booking_date.' ('.$this->request->data('booking_start_time').' to '.$this->request->data('booking_end_time').') at <a href="'.BASE_URL.'appointments/clinic_appointments">'.$clinic_details['Clinic']['name'].'</a>.';
						
						$data_save['sender_id'] 				= 0;
						$data_save['sender_type'] 			= 0;
						$data_save['reciver_id'] 			= $this->request->data('uid');
						$data_save['reciver_type'] 			= 1;
						$data_save['appointment_id'] 			= $appointment_id;
						$data_save['status'] 				= 1;
						$data_save['send_notification'] 		= 1;
						$data_save['message'] 				= $msg;
						$data_save['added_date'] 			= date('Y-m-d H:i:s');
						$data_save['send_notification_count'] 	= 1;
						
						$this->Appointmentmsg->create();
						$this->Appointmentmsg->save($data_save);
						
						return $this->redirect(BASE_URL.'appointments/clinic_appointments');  //if no clinic sending to appointment page
					}
					else
					{
						return $this->redirect(BASE_URL.'appointments/appointments');  //if no clinic sending to appointment page
					}
				
				
				
				
				
				
						/*$this->Session->write('msg','addsuccess');	
						return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);*/
			
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/appointments?clinicid='.$clinicid);
				}
				$this->set('msg',$msg);
				 
				
			
		}
			else
			{
				$this->set('msg',array());
			}
		
	}
	
	
	function bookedAppointment()
	{
		$this->autoRender = false;
		$appointment_id = $this->request->data['appoinment_id'];
		$this->Appointment->updateAll(array('Appointment.status' => 2),array('Appointment.id' => $appointment_id));
		echo 1;
	}
	function toCancelAppointment()
	{
		$this->autoRender = false;
		$appointment_id = $this->request->data['appoinment_id'];
		$this->Appointment->delete($appointment_id);
		$this->Appointmentmsg->deleteAll(array('appointment_id' => $appointment_id));
		echo 1;
	}
	
	/*Blocked Exception*/
	function blockException()
	{
		$this->autoRender = false;
		
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
		//pr($this->request->data);
		
		//exit;
		
				
				//creating array for save data
				$clinicid = $this->request->data['clinic_id'];
				
				$data_to_be_saved=$this->request->data;
				if(isset($this->request->data['rownum']))
				$data_to_be_saved['Clinicexception']['rownum']=$this->request->data['rownum'];
				$data_to_be_saved['Clinicexception']['exceptiondate']=$this->request->data['exception_date'];
				$data_to_be_saved['Clinicexception']['clinicid']=$this->request->data['clinic_id'];
				$data_to_be_saved['Clinicexception']['type']=0; /*----- Block Exception Thats Why "Type = 0" -----*/
				
				if($this->Clinicexception->save($data_to_be_saved))
				{
					echo 1; /* 1 = success;, means save into database clinicexceptions table*/
				}
				
			
			
		}
			else
			{
				echo "Please login to blocked exception.";
			}
		
	}
}
?>
