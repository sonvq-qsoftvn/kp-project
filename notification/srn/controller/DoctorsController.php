<?php
App::uses('CakeEmail', 'Network/Email');
class DoctorsController extends AppController  
{
	public $helpers = array('Html', 'Form', 'Paginator','Functions'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator','Upload'); //loading necessary components
	
	//models used 
	var $uses=array('Clinic','Clinicmanager','Speciality','Insurance','Insurancetoclinic','Openinghour','Sitesetting','Cliniclike','Doctor','Openinghour','User', 'Cliniclikes', 'Eligibilitie', 'Eligibilitieclinc','Wallpost','Comment');
        //declaring paginator options
        public $paginate = array(
        'limit' => 5,
        'order' => array('Clinic.name' => 'asc'));
        
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
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
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
			$this->set('title_for_layout','Manage Doctors'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
                        
               //binding models for inner join
			 $this->Doctor->bindModel(array(
						'belongsTo' => array(
							'Clinic' => array('foreignKey' => 'clinic_id','conditions'=>array('Doctor.active' => 1)
						)
					)
				)
			);
			
			$this->paginate['conditions']='Doctor.active=1';
               $this->Paginator->settings = $this->paginate;
               $data = $this->Paginator->paginate('Doctor');
			  // pr($data);
			$this->set('all_doctors',$data);
			$this->set('left_sidebar_selected','doctors');
			$this->set('msg',$msg);
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	
	//Disapproved Clinics :: Tabular view
	
	//Featured doctors...
	
	public function featured()
	{
		$this->layout='ajax';
		$this->autoRender=false;
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$doctor_id=$this->request->data['doctor_id'];
			$status=$this->request->data['status'];
			/*======change the satus of featured for update start======*/
			
			$totaldoctors = $this->Doctor->find('count', array('conditions' => array('Doctor.featured' => $status)));
			//pr($this->Doctor->getDataSource()->getLog(TRUE));
			if($totaldoctors < 4  || $status ==0)
			{
				$this->Doctor->updateAll(array('Doctor.featured' => $status),array('Doctor.id' => $doctor_id));
				//pr($this->Doctor->getDataSource()->getLog(TRUE));
				echo "Doctor featured for home page successfully updated.";
			}
			else
			{
				echo "Limit exceeded.\n You can not featured more than four doctors for home page.";
			}
			
			
		}
	}
	/*---featuredEnd-----*/

}
	?>