<?php
App::uses('CakeEmail', 'Network/Email');
class ClinicsController extends AppController  
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
			$this->set('title_for_layout','Manage Clinics'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
                        
               //binding models for inner join
			$this->Clinic->bindModel(array(
						'belongsTo' => array(
							'Cm' => array('foreignKey' => 'clinicmanagersid',
									      'className'=>'User'
						)
					)
				)
			);
			
			$this->paginate['conditions']='Clinic.status=1';
               $this->Paginator->settings = $this->paginate;
               $data = $this->Paginator->paginate('Clinic');
			$this->set('all_clinics',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	
	//Disapproved Clinics :: Tabular view
	
	public function disapprovedclinics()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['msg']))
			{
				$msg=$this->params->query['msg']; //picking up the msg
			}
			else
			{
				$msg='';
			}
			
			$this->layout='admin'; //loading admin layout
			$this->set('title_for_layout','Manage Disapproved Clinics'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
                        
               //binding models for inner join
			$this->Clinic->bindModel(array(
						'belongsTo' => array(
							'Cm' => array('foreignKey' => 'clinicmanagersid',
									     'className'=>'User'
						)
					)
				)
			);
			
			$this->paginate['conditions']='Clinic.status=0';
			$this->Paginator->settings = $this->paginate;
			$data = $this->Paginator->paginate('Clinic');
			$this->set('all_clinics',$data);
			$this->set('left_sidebar_selected','clinics');
			$this->set('msg',$msg);
			
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	
	//Clinics :: approve clinic
	
	public function approve()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the insurance id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/disapprovedclinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic  with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/disapprovedclinics');  //if null or zero sending to listing page
			}
			
				$data_to_be_saved['Clinic']['id']= $id;
				$data_to_be_saved['Clinic']['status']=1;
				$data_to_be_saved['Clinic']['send_notification']=1; //After Admin Approved send notification updated.
					if ($this->Clinic->save($data_to_be_saved))
					{
						$dataclinic=$this->Clinic->findById($id);
						$dataclinicmanager=$this->User->findById($dataclinic['Clinic']['clinicmanagersid']);
						$mail_msg="<div style='width:80%;'>Hello ".$dataclinicmanager['User']['first_name']." ".$dataclinicmanager['User']['last_name'].",<p>Your clinic bearing the name <b>".$dataclinic['Clinic']['name']."</b> is now approved by the admin and as such would be shown at the frontend from now on.</p><p>Thanks &regards,<br/>SeeDoctor.sg Team</p></div>";
						$Email = new CakeEmail();
						
						$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
						$Email->to($dataclinicmanager['User']['email']);
						$Email->subject('SeeDoctor.sg Notifications: Clinic Approved');
						$Email->emailFormat('html');
						$Email->send($mail_msg);
						$this->Session->write('msg','approvesuccess');	
						return $this->redirect(BASE_URL.'administrator/clinics');
					}
					$this->Session->write('msg','approvefailure');	
					return $this->redirect(BASE_URL.'administrator/disapprovedclinics');
				
                }
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	
	//Clinics :: approve clinic
	
	public function disapprove()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the insurance id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');					
				return $this->redirect(BASE_URL.'administrator/approvedclinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic  with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/approvedclinics?msg=editnoclinic');  //if null or zero sending to listing page
			}
			
				$data_to_be_saved['Clinic']['id']= $id;
				$data_to_be_saved['Clinic']['status']=0;
				
					if ($this->Clinic->save($data_to_be_saved))
					{
						$dataclinic=$this->Clinic->findById($id);
						$dataclinicmanager=$this->User->findById($dataclinic['Clinic']['clinicmanagersid']);
						$mail_msg="<div style='width:80%;'>Hello ".$dataclinicmanager['User']['first_name']." ".$dataclinicmanager['User']['last_name'].",<p>Your clinic bearing the name <b>".$dataclinic['Clinic']['name']."</b> is now disapproved by the admin and as such would not be shown at the frontend from now on. Please contact admin for further details.</p><p>Thanks &regards,<br/>SeeDoctor.sg Team</p></div>";
						
						$Email = new CakeEmail();
						$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
						$Email->to($dataclinicmanager['User']['email']);
						$Email->subject('SeeDoctor.sg Notifications: Clinic Disapproved');
						$Email->emailFormat('html');
						$Email->send($mail_msg);
						$this->Session->write('msg','disapprovesuccess');
						return $this->redirect(BASE_URL.'administrator/disapprovedclinics');
					}
					
					$this->Session->write('msg','disapprovefailure');
					
					return $this->redirect(BASE_URL.'administrator/clinics');
				
                }
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}

	
	
	//Clinics :: Delete Clinic
	
	public function deleteclinic()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the content id
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
			
			//codes for deletion starts
			
			if ($this->Clinic->delete($id))
			{
				$dataclinic=$clinic;
				$dataclinicmanager=$this->User->findById($dataclinic['Clinic']['clinicmanagersid']);
				
				$mail_msg="<div style='width:80%;'>Hello ".$dataclinicmanager['User']['first_name']." ".$dataclinicmanager['User']['last_name'].",<p>Your clinic bearing the name <b>".$dataclinic['Clinic']['name']."</b> is deleted by the admin. Please contact admin for further details.</p><p>Thanks &regards,<br/>SeeDoctor.sg Team</p></div>";
				$Email = new CakeEmail();
				
				$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
				$Email->to($dataclinicmanager['User']['email']);
				$Email->subject('SeeDoctor.sg Notifications: Clinic Deleted');
				$Email->emailFormat('html');
				$Email->send($mail_msg);
						
				$this->Session->write('msg','deletesuccess');
				return $this->redirect(BASE_URL.'administrator/clinics');
			
			}
			$this->Session->write('msg','deletefailure');
			return $this->redirect(BASE_URL.'administrator/clinics');
			//codes for deletion ends
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	
	//Clinics :: Add clinic Page
	
	public function addclinic()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Add Clinic Form'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','clinics');
			$this->set('isformpage',1);
			//if ckeditor exists in forms sending their ids
			$this->set('ckeditor_ids',array('address'));
			$this->set('all_owners',$this->User->find('all',array('conditions'=>'status=1 and user_type=2')));
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				$this->Clinic->create();
				
				//creating array for save data
				
				$data_to_be_saved=$this->request->data;
				$data_to_be_saved['Clinic']['dateadded']=date('Y-m-d h:i:s');
				$data_to_be_saved['Clinic']['datelastmodified']=$data_to_be_saved['Clinic']['dateadded'];
				$data_to_be_saved['Clinic']['status']=1;
				
				$data_to_be_saved['Clinic']['handphone']='65'.$data_to_be_saved['Clinic']['handphone'];
				//serverside validation starts
				$data_to_be_saved['Clinic']['send_notification']=1; //Superadmin create clinic for clinic manager or for own
				$error_status=0;
				if($data_to_be_saved['Clinic']['name']=='')
				{
					$msg[]='Please enter clinic name';
					$error_status=1;
				}
				if($data_to_be_saved['Clinic']['clinicmanagersid']=='')
				{
					$msg[]='Please select a clinc';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['license']=='')
				{
					$msg[]='Please enter license';
					$error_status=1;
				}
				
				//checking if license exists
				
				$n=$this->Clinic->find('count',array('conditions'=>'license="'.$data_to_be_saved['Clinic']['license'].'"'));
				if($n!=0)
				{
					$msg[]='License already exists';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['address']=='')
				{
					$msg[]='Please enter clinic address';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['handphone']==''||strlen($data_to_be_saved['Clinic']['handphone'])!=10||!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/', $data_to_be_saved['Clinic']['handphone']))
				{
					$msg[]='Invalid handphone';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['url']==''||!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data_to_be_saved['Clinic']['url']))
				{
					$msg[]='Invalid clinic url';
					$error_status=1;
				}
				
				//checking if url exists
				
				$n=$this->Clinic->find('count',array('conditions'=>'url="'.$data_to_be_saved['Clinic']['url'].'"'));
				if($n!=0)
				{
					$msg[]='This url is already registered to a different clinic';
					$error_status=1;
				}
				
				//serverside validation ends
				
				if($error_status==0)
				{
					if ($this->Clinic->save($data_to_be_saved))
					{
						$dataclinic=$data_to_be_saved;
						$dataclinicmanager=$this->User->findById($dataclinic['Clinic']['clinicmanagersid']);
						$mail_msg="<div style='width:80%;'>Hello ".$dataclinicmanager['User']['first_name']." ".$dataclinicmanager['User']['last_name'].",<p>Your clinic bearing the name <b>".$dataclinic['Clinic']['name']."</b> is created and approved by the admin.You can now manage the details from your manage clinic section. </p><p>Thanks &regards,<br/>SeeDoctor.sg Team</p></div>";
						$Email = new CakeEmail();
						
						$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
						$Email->to($dataclinicmanager['User']['email']);
						$Email->subject('SeeDoctor.sg Notifications: Clinic Created And Approved ');
						$Email->emailFormat('html');
						$Email->send($mail_msg);
						
						$this->Session->write('msg','addsuccess');
						return $this->redirect(BASE_URL.'administrator/clinics');
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/clinics');	
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
	
	//Clinics :: Clinic settings page
	
	public function clinicsettings()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the  id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');				
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic  with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Edit clinic Form'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','clinics');
			$this->set('isformpage',1);
			//if ckeditor exists in forms sending their ids
			$this->set('ckeditor_ids',array('address','about'));
			$this->set('all_owners',$this->User->find('all',array('conditions'=>'status=1')));
			$this->set('all_base_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_status=1 and specialities_parent_id=1')));
			$this->set('all_sub_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_status=1 and specialities_parent_id='.$clinic['Clinic']['type'].' and specialities_parent_id!=0')));
			
			//$all_eligibilities=$this->Eligibilitie->find('all',array('conditions'=>'status=1 and eligibilities_parent_id!=0'));
			//pr($all_eligibilities);
		
			$this->Eligibilitie->bindModel(array('hasMany'=>array('SubCategory'=>array('className'=>'Eligibilitie','foreignKey'=>'eligibilities_parent_id','conditions'=>array('SubCategory.status'=>1)))));
			$all_parent_category = $this->Eligibilitie->find('all', array('conditions' => array('Eligibilitie.eligibilities_parent_id'=>1,'Eligibilitie.status'=>1)));
			//  pr($all_parent_category);
		
		     	$this->set('parent_cat_options',$all_parent_category);
			
			$current_eligibility = $this->Eligibilitieclinc->find('all',array('conditions'=>'clinc_id='.$id));
			//pr($current_eligibility);die;
			$this->set('current_eligibility',$current_eligibility);
			
			//getting the insurances of this clinic presently stored in the database
			/*========insurance parents and sub========*/
			$this->Insurance->bindModel(array('hasMany'=>array('SubInsurance'=>array('className'=>'Insurance','foreignKey'=>'insurance_parent_id','conditions'=>array('SubInsurance.insurances_status'=>1)))));
                     $all_parent_insurances = $this->Insurance->find('all', array('conditions' => array('Insurance.insurance_parent_id'=>1,'Insurance.insurances_status'=>1)));
		   
		     	$this->set('all_parent_insurances',$all_parent_insurances);
			/*========insurance parents and sub========*/
			
			/*=========Insurance to clinic start=========*/
			$current_insurances=$this->Insurancetoclinic->find('all',array('conditions'=>'clinicid="'.$id.'"'));
			$this->set('current_insurances',$current_insurances);
			/*=========Insurance to clinic start=========*/
			
			//setting values ends
			if ($this->request->is(array('post', 'put')))
			{
				$this->Clinic->id = $id;
				$data_to_be_saved=($this->request->data);
				//modifying save data
				$data_to_be_saved['Clinic']['datelastmodified']=date('Y-m-d h:i:s');
				$data_to_be_saved['Clinic']['handphone']='65'.$data_to_be_saved['Clinic']['handphone'];
				$data_to_be_saved['Clinic']['logo']=$clinic['Clinic']['logo'];
				$data_to_be_saved['Clinic']['tags']=$data_to_be_saved['Clinic']['tags'];
				$data_to_be_saved['Clinic']['waitingtime']=$data_to_be_saved['Clinic']['waitingtime'];
				
				
				if(isset($this->request->data['display_waiting']))
				{
					$data_to_be_saved['Clinic']['displaywaiting']	=1;
				}
				else
				{
					$data_to_be_saved['Clinic']['displaywaiting']	=0;
				}
				if(isset($this->request->data['lock_wall']))
				{
					$data_to_be_saved['Clinic']['lockwall']	=1;
				}
				else
				{
					$data_to_be_saved['Clinic']['lockwall']	=0;
				}
				if(isset($this->request->data['allow_post']))
				{
					$data_to_be_saved['Clinic']['allowpost']	=1;
				}
				else
				{
					$data_to_be_saved['Clinic']['allowpost']	=0;
				}
				//serverside validation starts
				
				$error_status=0;
				if($data_to_be_saved['Clinic']['name']=='')
				{
					$msg[]='Please enter clinic name';
					$error_status=1;
				}
				if($data_to_be_saved['Clinic']['clinicmanagersid']=='')
				{
					$msg[]='Please select a clinc manager';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['license']=='')
				{
					$msg[]='Please enter license';
					$error_status=1;
				}
				
				//checking if license exists
				
				$n=$this->Clinic->find('count',array('conditions'=>'license="'.$data_to_be_saved['Clinic']['license'].'" and id!="'.$id.'"'));
				
        
				if($n!=0)
				{
					$msg[]='License already exists';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['address']=='')
				{
					$msg[]='Please enter clinic address';
					$error_status=1;
				}
				//if($data_to_be_saved['Clinic']['handphone']==''||strlen($data_to_be_saved['Clinic']['handphone'])!=10||!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/', $data_to_be_saved['Clinic']['handphone']))
				//{
				//	$msg[]='Invalid handphone';
				//	$error_status=1;
				//}
				if($data_to_be_saved['Clinic']['url']==''||!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data_to_be_saved['Clinic']['url']))
				{
					$msg[]='Invalid clinic url';
					$error_status=1;
				}
				
				//checking if url exists
				
				$n=$this->Clinic->find('count',array('conditions'=>'url="'.$data_to_be_saved['Clinic']['url'].'" and id!="'.$id.'"'));
				if($n!=0)
				{
					$msg[]='This url is already registered to a different clinic';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['type']==''||$data_to_be_saved['Clinic']['type']==0)
				{
					$msg[]='Please enter speciality';
					$error_status=1;
				}
				if($data_to_be_saved['Clinic']['about']=='')
				{
					$msg[]='Please enter about';
					$error_status=1;
				}
				if(count($this->request->data['insurances'])==0)
				{
					$msg[]='Please select atleast one insurance';
					$current_insurances=array();
					$this->set('current_insurances',$current_insurances);
					$error_status=1;
				}
				//upload logo image
				
				if($_FILES['logo']['name']!='')
				{
					$portitions_arr=explode('.',$_FILES['logo']['name']);
					$n=count($portitions_arr);
					$extension=$portitions_arr[$n-1];
					if($extension=='jpg'||$extension=='JPG'||$extension=='JPEG'||$extension=='jpeg'||$extension=='PNG'||$extension=='png'||$extension=='gif'||$extension=='GIF'||$extension=='ico'||$extension=='ICO')
					{
						if($_FILES['logo']['size']>2*1024*1024)
						{
							$msg[]='Please upload logo image of size 2MB maximum';
							$error_status=1;	
						}
						else
						{
							$exe_img = $this->Clinic->find('first',array('conditions'=>'id ="'.$id.'"'));
							
							if(isset($exe_img['Clinic']['logo']))
							{
								$unlink_path = "./admin/uploads/".$exe_img['Clinic']['logo'];
								$unlink_path_thumb = "./admin/uploads/thumb/".$exe_img['Clinic']['logo'];
								@unlink($unlink_path); @unlink($unlink_path_thumb);
							}
							
							$filename=$_FILES['logo']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['logo']['tmp_name'];
							$filename=rand(100,999).time().$id.'.'.$ext;
							$folder="./admin/uploads/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry logo file upload failed.Please try again.....';
								
								$error_status=1;
							}
							else
							{
								$target_path = "./admin/uploads/thumb/".$filename;
								$source_path = $path;
								$this->Sitesetting->thumbnail($target_path, $source_path, 350, 350, '');
								$data_to_be_saved['Clinic']['logo']=$filename;
							}	
						}
					}
					else
					{
						$msg[]='Please upload logo image of following extensions only.<ul><li>jpeg</li><li>jpg</li><li>png</li><li>gif</li><li>ico</li></ul>';
							
						$error_status=1;
					}
					
				}
				
					
				
				//serverside validation ends
				if($error_status==0)
				{
					//deleting them from database
					foreach($current_insurances as $v)
					{
						$this->Insurancetoclinic->delete($v['Insurancetoclinic']['id']);
					}
					
					//inserting the selected insurances
					foreach($this->request->data['insurances'] as $v)
					{
						$this->Insurancetoclinic->create();
						
						echo $v;
						$data_to_be_saved2['Insurancetoclinic']['insuranceid']=$v;
						$data_to_be_saved2['Insurancetoclinic']['clinicid']=$id;
						$this->Insurancetoclinic->save($data_to_be_saved2);
					}
					
					
					//saving eligibilities
					if(!empty($this->request->data['eligibilities']))
					{
						//deleting them from database
						foreach($current_eligibility as $v)
						{
							$this->Eligibilitieclinc->delete($v['Eligibilitieclinc']['id']);
						}
						
						//inserting the selected insurances
						foreach($this->request->data['eligibilities'] as $v)
						{
							$this->Eligibilitieclinc->create();
							$data_to_be_saved3['Eligibilitieclinc']['eligibiliti_id']=$v;
							$data_to_be_saved3['Eligibilitieclinc']['clinc_id']=$id;
							$this->Eligibilitieclinc->save($data_to_be_saved3);
						}
					}
					/*===========Address logitude And latitude set========*/
					/*if($data_to_be_saved['Clinic']['address']!='')
					{
						
						$address = $data_to_be_saved['Clinic']['address'];
						$address = str_replace(PHP_EOL, '', $address);
						$address = str_replace(array(' ', '<', '>', '&', '{', '}', '*','@','#','$','%','^','(',')',':',';','\'','/','|','!'), array('+'), $address);
						//echo "add= ".$address;
						$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
						$json = json_decode($json);
						$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
						$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
						$data_to_be_saved['Clinic']['lat'] = $lat;
						$data_to_be_saved['Clinic']['lon'] = $long;
					}*/
					//saving settings
					if ($this->Clinic->save($data_to_be_saved))
					{
						$this->Session->write('msg','editsuccess');
						return $this->redirect(BASE_URL.'administrator/clinics');
					}
					$this->Session->write('msg','editfailure');
					return $this->redirect(BASE_URL.'administrator/clinics');
				}
				
				$this->set('msg',$msg);
				$this->request->data = $data_to_be_saved;
			}
			else
			{
				$this->set('msg',array());
			}
			if (!$this->request->data)
			{	
				$this->request->data = $clinic;
			}
                }
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	//ajax function for producing sub specialities
	function producesub()
	{
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='';
			$id=$this->params->query['specialityid'];
			$this->set('all_sub_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_parent_id="'.$id.'"')));
			//$all_sub_specialities = $this->Speciality->find('all',array('conditions'=>'specialities_parent_id="'.$id.'"'));
			
			//echo $all_sub_specialities;
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page	
		}
		
	}
	
	function producesub1()
	{
		$this->layout='';
		
		$id=$this->params->query['specialityid'];
		$sub_type_id=$this->params->query['sub_type_id'];
		
		$all_sub_specialities = $this->Speciality->find('all',array('conditions'=>'specialities_parent_id="'.$id.'"'));
		$this->set('all_sub_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_parent_id="'.$id.'"')));
		$this->set('sub_type_id', $sub_type_id);
		//echo $all_sub_specialities;
	}
	//openning hours management
	function openinghours()
	{
		
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['clinicid']))
			{
				$id=$this->params->query['clinicid']; //picking up the  id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');				
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic  with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'administrator/clinics');  //if null or zero sending to listing page
			}
			
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Opening Hours'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','clinics');
			$this->set('isformpage',1);
			$msg=array();
			//finding all slots and arranging them in array
			$slots_arr=array();
			for($i=1;$i<=7;$i++)
			{
				$slots_arr[$i]=$this->Openinghour->find('all',array('conditions'=>'clinicid="'.$id.'" and day="'.$i.'"','order'=>array('day'=>'asc','fromhour'=>'asc')));
			}
			$this->set('slots_arr',$slots_arr);
			$r=$this->Openinghour->find('first',array('fields'=>'max(id) as mx'));
			$maxid=$r[0]['mx'];
			if($maxid=='')
			{
				$maxid=0;
			}
			$this->set('maxid',$maxid);
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				
				$this->Openinghour->deleteAll(array('clinicid' => $id));
				for($i=1;$i<=7;$i++)
				{
					$n=$this->request->data['number_of_'.$i.'_slots'];
					for($j=1;$j<=$n;$j++)
					{
						//checking if the current slot is being deleted
						//if status==0 then user wants to delete hence continue
						
						if($this->request->data['status_'.$i.'_'.$j]==0)
						{
							continue;
						}
						else
						{
							$arr['Openinghour']['id']=$this->request->data['id_'.$i.'_'.$j];
							$arr['Openinghour']['day']=$i;
							$arr['Openinghour']['clinicid']=$id;
							$arr['Openinghour']['fromhour']=$this->request->data['from_hours_'.$i.'_'.$j];
							$arr['Openinghour']['tohour']=$this->request->data['to_hours_'.$i.'_'.$j];
							$arr['Openinghour']['fromminutes']=$this->request->data['from_minutes_'.$i.'_'.$j];
							$arr['Openinghour']['tominutes']=$this->request->data['to_minutes_'.$i.'_'.$j];
							$this->Openinghour->create();
							
							$this->Openinghour->save($arr);
						}
						
							
						
						
					}
				}
				$this->Session->write('msg','editsuccess');
				return $this->redirect(BASE_URL.'administrator/clinics');
			}
			$this->set('msg',$msg);
                }
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	
	}
	
	

        
     public function clintlist()
	{
		//checking whether logged or not
		
		$total_likes = 0; $client_detalts_n = $client_detalts_n1 = array(); $show_type = '';
		
          $this->set('METADATA','clienclist'); //defining the login page title
			
		$this->set('METATITLE','clinclist');
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1))
		{
			$loged_user_id =$this->Session->read('reid_user_uid');
		  
			$loged_user_type =$this->Session->read('reid_user_type');
			
			$this->layout='frontend';
			 
			//content for meta name = Description
			 
			if($loged_user_type==2)
			{
		$client_detalts= $this->Clinic->find('all',array('conditions'=>'clinicmanagersid="'.$loged_user_id.'"', 'order'=>array(
                                                         'Clinic.status DESC',
                                               
                                               ), )
                                        
                                        
                                        );
				foreach($client_detalts as $clinics)
				{
					$total_likes=$this->Cliniclikes->find('count',
                                                array('conditions'=>'clinic_id="'.$clinics['Clinic']['id'].'"')
                                                
                                                );
					//$total_likes = $this->Sitesetting->getTotalLikes($clinics['Clinic']['id']);
					$clinics['Clinic']['total_likes']=$total_likes;
					$client_detalts_n1[] = $clinics;
				}
			}
			else
			{
				//$client_detalts= $this->Clinic->find('all',array('conditions'=>'clinicmanagersid="'.$loged_user_id.'"'));
                    
				$show_type = (isset($this->params->named['show']))?$this->params->named['show']:'';
                 
				if($show_type=='all'){
					
					$client_detalts_n = $this->Clinic->find("all", array("conditions" => array("Clinic.status=1")), array( 'order' => array('Clinic.like' => 'desc')));
					foreach($client_detalts_n as $client_detalts)
					{
						$client_detalts['Cliniclike']=array();
						
						$liked = $this->Cliniclike->find("count", array("conditions" => array("Cliniclike.clinic_id = ".$client_detalts['Clinic']['id'], "Cliniclike.user_id" => $loged_user_id)));
						
						if($liked>0){
							$like_det = $this->Cliniclike->find("first", array("conditions" => array("Cliniclike.clinic_id = ".$client_detalts['Clinic']['id'], "Cliniclike.user_id" => $loged_user_id)));
							
							$client_detalts['Cliniclike'] = $like_det['Cliniclike'];
						}
						
						$client_detalts_n1[] = $client_detalts;
					}
				}
				else{
					
					$this->Clinic->bindModel(array(
								'belongsTo' => array(
									'Cliniclike' => array('foreignKey' => false,
												 'className'=>'Cliniclike'
								)
									
								
							)
						),false
					);
					
					$client_detalts_n1 = $this->Clinic->find("all", array("conditions" => array("Clinic.id=Cliniclike.clinic_id", 'Cliniclike.like' => 1, 'Cliniclike.user_id' => $loged_user_id)), array( 'order' => array('Cliniclike.added_date' => 'desc')));
				}
			}
			
			$this->set('show_type',$show_type);
			$this->set('clinic',$client_detalts_n1);
			$this->set('loged_user_type',$loged_user_type);
		}
		else
		{
			$this->Session->setFlash(
				   'Please login..',
				   'default',
				   array('class' => 'error'),
				   'login_error'
			   );
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
        
        
        
     public function clincwall($id,$my_comment_id=false)
	{
		$this->set('METADATA','clienclist'); //defining the login page title
		$this->set('METATITLE','clinclist');
            $this->set('my_comment_id',$my_comment_id);
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1))
		{
			/*For Wall Posts*/
			//$wall_post = $this->Wallpost->find('all', array('conditions' => array('Wallpost.clinic_id' => $id,'Wallpost.status' => 1),'order' => array( 'Wallpost.id DESC')));

		$this->Clinic->bindModel(array('belongsTo' => array('Wallpost' => array('foreignKey' =>false,'className'=>'Wallpost','type'=>'INNER',
		'conditions'=>array('Wallpost.clinic_id=Clinic.id','Wallpost.clinic_id' => $id,'Wallpost.status' => 1),'order'=>array('Wallpost.id DESC')))
					),true);
		
		 	$wall_post=$this->Clinic->find('all');
	    		$this->set('wall_post',$wall_post);
			//pr($wall_post);

			/*For Wall Posts End*/
			/*For Wall Comment Start*/

			foreach ($wall_post as $key=>$value) {
				//echo $value['Wallpost']['id'];
				//exit;
//$comment[$value['Wallpost']['id']] = $this->Comment->find('all', array('conditions' => array('Comment.post_id' => $value['Wallpost']['id'])));
	$comment[$value['Wallpost']['id']] =   $this->Comment->find('all',
                array('fields'=>array('u.*','Comment.*'),'joins' => array(
                                       array('table' => 'users',
					     
					     'alias' => 'u',
                                             'type' => 'left',
                                             //'foreignKey' => false,
                                             'conditions'=> array('Comment.user_id = u.id')
                                        )
                                 ),
                       'conditions'=>array('Comment.post_id' => $value['Wallpost']['id'],'Comment.status = 1')
                ));
				  
				  
				  
				  
				    }


			if(!empty($comment))
			{
				$this->set('comments',$comment);
			}	    
			//pr($comment);exit;
			/*For Wall Comment End*/
			
			$clinic_check = $this->Clinic->find('count', array('conditions' => array('Clinic.id' => $id)));
			
			if($clinic_check ==0)
			{
				return $this->redirect(BASE_URL.'clinics/clintlist');	
			}
			
			$this->layout='frontend';
			$client_all_detail= $this->Clinic->find('all',array('conditions'=>'id="'.$id.'"'));
			$this->set('client_all_detail',$client_all_detail);
			$type_id= $client_all_detail[0]['Clinic']['type'];
			$sub_type_id= $client_all_detail[0]['Clinic']['subtype'];
			$Specialitie_category= $this->Speciality->find('all',array('conditions'=>'id="'.$type_id.'" and specialities_status=1'));
			$Specialitie_sub_category= $this->Speciality->find('all',array('conditions'=>'id="'.$sub_type_id.'" and specialities_status=1 and  specialities_parent_id!=0'));
                        
			$this->set('Specialitie_category',$Specialitie_category);
			
			$this->set('Specialitie_sub_category',$Specialitie_sub_category);
			
			$this->Insurancetoclinic->bindModel(array(
					'belongsTo' => array(
						'Insurance' => array('foreignKey' => false,'className'=>'Insurance')
					)
				),false
			);
                     
			$current_insurances=$this->Insurancetoclinic->find('all',array('conditions'=>'Insurancetoclinic.insuranceid=Insurance.id and Insurancetoclinic.clinicid="'.$id.'"'));

			$this->set('current_insurances',$current_insurances);
               $clic_doctor= $this->Doctor->find('all',array('conditions'=>'clinic_id`="'.$id.'"'));
               $this->set('doctor',$clic_doctor); 
  
			//*********************************** Openinghour *********************************************//                      
                        
               $current_Openinghour=$this->Openinghour->find('all',array('conditions'=>'Openinghour.clinicid="'.$id.'"','order'=>array('Openinghour.fromhour','Openinghour.day ASC')));
               $listarray=array();
               $day_array= array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'); 
                      
			foreach($current_Openinghour as $current_Openinghours)
			{
				
			    $listarray[$day_array[($current_Openinghours['Openinghour']['day'])-1]][]= date("g:i a",strtotime(sprintf('%02d', $current_Openinghours['Openinghour']['fromhour']).':'.sprintf('%02d',$current_Openinghours['Openinghour']['fromminutes']))).'-'.date("g:i a",strtotime(sprintf('%02d',$current_Openinghours['Openinghour']['tohour']).':'.sprintf('%02d',$current_Openinghours['Openinghour']['tominutes'])));
			}
         
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
                        
                        
                       // pr($new_array);
    
               $this->set('oping_time', $new_array); 
               $this->set('days', $day_array); 
               $clinicmanagersid= $client_all_detail[0]['Clinic']['clinicmanagersid'];
               $current_user=$this->User->find('first',array('conditions'=>'User.id="'.$id.'"'));
                 
               if(isset($current_user['User']['phone_number']))
                    $user_phone_no =   $current_user['User']['phone_number'];
               else
                    $user_phone_no = "";
				
               $this->set('user_phone_no', $user_phone_no); 
               $clicn_likes=$this->Cliniclike->find('all',array('conditions'=>array('Cliniclike.clinic_id'=>$id,'like'=>1)));
                  
               $click_like= count($clicn_likes);
                   
               $this->set('likes_count', $click_like);
			
			$clinic_like_id = 0;
			if($this->Session->read('reid_user_type')==1)
			{
				$clinic_like_id_query = $this->Cliniclike->find('first',array('conditions'=>array('Cliniclike.clinic_id'=>$id,'Cliniclike.user_id'=>$this->Session->read('reid_user_uid'))));
				if(!empty($clinic_like_id_query))
				{
					$clinic_like_id = $clinic_like_id_query['Cliniclike']['id'];
				}
			}
			
			$this->set('Cliniclike_id', $clinic_like_id);
			
			$get_days = getdate();
    
			$get_day_name = $get_days['weekday'];
			
			if('Monday'==$get_day_name)                               
			{
			    $day_id= 1;
			}
			elseif ('Tuesday'==$get_day_name)
			{
                                  
                                    $day_id= 2;
         
                              }elseif ('Wednesday'==$get_day_name) {
                                    $day_id= 3;
                
                               }elseif ('Thursday'==$get_day_name) {
                                   
                                     $day_id= 4;
                
                               }elseif ('Friday'==$get_day_name) {
                                   
                                     $day_id= 5;
                
                               }elseif ('Saturday'==$get_day_name) {
                                   
                                     $day_id= 6;
                
                               }elseif ('Sunday'==$get_day_name) {
                                   
                                     $day_id= 7;
                
                               }          
                   
                    $this->loadModel('Eligibilitieclinc');
                    $this->loadModel('Eligibility');
                               
                   
             $this->Eligibilitieclinc->bindModel(array(
						'belongsTo' => array(
							'Eligibility' => array('foreignKey' => false,
									      'className'=>'Eligibility'
						)
							
						
					)
				),false
			);
                        
              
                        
 $current_eligibi=$this->Eligibilitieclinc->find('all',array('conditions'=>'Eligibilitieclinc.eligibiliti_id=Eligibility.id and Eligibilitieclinc. 	clinc_id ="'.$id.'" and Eligibility.status=1 '));
               
       
     $this->set('current_eligibi', $current_eligibi);
     
     
     
       $loged_user_type =$this->Session->read('reid_user_type');
          
        
           
           $loged_user_id =$this->Session->read('reid_user_uid');
           
           if($loged_user_type==1)
           {
               
             
               $clicn_count=$this->Cliniclike->find('first',array('conditions'=>array('Cliniclike.clinic_id'=>$id,'Cliniclike.like'=>1,'Cliniclike.user_id'=>$loged_user_id)));
               
               
            $count_like = count($clicn_count);
         
            $this->set('count_like_user', $count_like);
          
           
           }
          
              
             $this->set('loged_user_type', $loged_user_type);
             $this->set('clinic_id',$id);
                }else{
                    
                    
                   $this->Session->setFlash(
						'Please login..',
						'default',
						 array('class' => 'error'),
						'login_error'
					);
                    
			
			return $this->redirect(BASE_URL);  //if not logged sending to login page
                        
                    
                }
         }
         
         
         
         
		function ajx_like()
		{
			$this->loadModel('Cliniclike');
			$loged_user_id = $this->Session->read('reid_user_uid');
			$id = $this->request->data('client_id');
		   
			if($id)
			{
				$savebale_data['Cliniclike']['clinic_id']=$id;
				$savebale_data['Cliniclike']['user_id']=$loged_user_id;
				$savebale_data['Cliniclike']['like']=1;
				$savebale_data['Cliniclike']['send_notification']=1;
				$savebale_data['Cliniclike']['added_date']=date('Y-m-d');
				
				if($this->Cliniclike->save($savebale_data))
				{
					$currently_liked_q  = $this->Clinic->find('first', array('conditions'=>'id="'.$id.'"'));
					$currently_liked = $currently_liked_q['Clinic']['likes'];
					$currently_liked=$currently_liked+1;
					
					$update_data['Clinic']['id']=$id;
					$update_data['Clinic']['likes']=$currently_liked;
					$this->Clinic->save($update_data);
				}
			}
			
			$this->autoRender = false; 
		}
         
		function ajx_unlike($s_id=0)
		{
			$this->loadModel('Cliniclike');
			$id = $this->request->data('id');
			if($id)
			{
				$clinic_id = $this->Cliniclike->find('first', array('conditions'=>'id="'.$id.'"'));
				if($this->Cliniclike->delete($id))
				{
					$currently_liked_q  = $this->Clinic->find('first', array('conditions'=>'id="'.$clinic_id['Cliniclike']['clinic_id'].'"'));
					$currently_liked = $currently_liked_q['Clinic']['likes'];
					//$currently_liked=$currently_liked-1;
					
					$update_data['Clinic']['id']=$currently_liked_q['Clinic']['id'];
					$update_data['Clinic']['likes']=($currently_liked-1);
					$this->Clinic->save($update_data);
				}
			}
			$this->autoRender = false; 
		}
         
   function add_doctor()
   {
       
       
       
        $this->set('METADATA','Add Doctor'); //defining the login page title
			
	$this->set('METATITLE','Add Doctor');
        
				 $id=$this->params->named['id']; //picking up the  id
                          
                                 $this->layout='frontend';
                                 
                                  //=================================================== doctor image=========================
                                  
                                
                                  
                                  
                                  
                                  if( isset($_FILES['fileInput']['name']) &&   $_FILES['fileInput']['name']!='')
						{
						$last_image=$this->Doctor->find('first', array('fields' => array('img'), 'conditions' => array('Doctor.clinic_id' => $id)));
							if( isset($last_image['Doctor']['img']) && $last_image['Doctor']['img'])
							{
								$img_path = "./admin/uploads/".$last_image['Clinic']['img'];
								@unlink($img_path);
							}
							
							$filename=$_FILES['fileInput']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['fileInput']['tmp_name'];
							$filename=rand(100,999).time().$id.'.'.$ext;
							$folder="./admin/uploads/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry! failed to upload image. Please try again.';
								$error_status=1;
							}
							
                                                }else{
                                                    
                                                    
                                                    $filename="";
                                                    
                                                    
                                                }
						
         //======================================================================================================
                                                
                                                
                                   if(!empty($this->request->data))  
                                   {
                                         
         
                                         $arr['Doctor']['f_name']=$this->request->data['f_name'];
                                         $arr['Doctor']['l_name']=$this->request->data['l_name'];
                                         $arr['Doctor']['qualification']=$this->request->data['qualification'];
                                         $arr['Doctor']['title']=$this->request->data['title'];                                       
                                         $arr['Doctor']['clinic_id']=$id;
                                         $arr['Doctor']['img']=$filename;
                                         
                                        
                                         
                                         
                                         $this->Doctor->save($arr);
                                         
                                          $this->Session->setFlash(
						'Doctor Add successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
                                         
                                        return $this->redirect(BASE_URL.'clinics/list_doctor/id:'.$id); 
                                   }  
   
                                   
   }
   
   
   function list_doctor()
   {
        $this->set('METADATA','Add Doctor'); //defining the login page title		
        $this->set('METATITLE','Add Doctor');

        $id=$this->params->named['id']; //picking up the  id
        $this->layout='frontend';
        $doctor_list=$this->Doctor->find('all', array('conditions' => array('Doctor.clinic_id' => $id),'order'=>array('Doctor.id DESC')));
      

         $this->set('clinc_id',$id);
        $this->set('doctor_list',$doctor_list);
     
    
   }
   
   
     function edit_doctor()
     {
       
        $this->set('METADATA','Add Doctor'); //defining the login page title		
        $this->set('METATITLE','Add Doctor');

        $id=$this->params->named['id']; //picking up the  id
        $this->layout='frontend';

        $doctor_list=$this->Doctor->find('first', array('conditions' => array('Doctor.id' => $id)));
        
        
        
         if( isset($_FILES['fileInput']['name']) &&   $_FILES['fileInput']['name']!='')
						{
						$last_image=$this->Doctor->find('first', array('fields' => array('img'), 'conditions' => array('Doctor.clinic_id' => $id)));
							if( isset($last_image['Doctor']['img']) && $last_image['Doctor']['img'])
							{
								$img_path = "./admin/uploads/".$last_image['Doctor']['img'];
								@unlink($img_path);
							}
							
							$filename=$_FILES['fileInput']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['fileInput']['tmp_name'];
							$filename=rand(100,999).time().$id.'.'.$ext;
							$folder="./admin/uploads/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry! failed to upload image. Please try again.';
								$error_status=1;
							}
							
                                                }else{
                                                    
                                                    
                                                    $filename=$doctor_list['Doctor']['img'];
                                                    
                                                    
                                                }
        
       
        
        if(!empty($this->request->data))  
                                   {
                                         
         
                                         $arr['Doctor']['f_name']=$this->request->data['f_name'];
                                         $arr['Doctor']['l_name']=$this->request->data['l_name'];
                                         $arr['Doctor']['qualification']=$this->request->data['qualification'];
                                         $arr['Doctor']['title']=$this->request->data['title'];                                       
                                         $arr['Doctor']['id']=$id;
                                         $arr['Doctor']['img']=$filename;
                                         
                                        
                                         
                                         
                                         $this->Doctor->save($arr);
                                         
                                         $this->Session->setFlash(
						'Doctor update successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
                                         
                                      return $this->redirect(BASE_URL.'clinics/list_doctor/id:'.$doctor_list['Doctor']['clinic_id']);   
                                   }  
        
        
        
        $this->set('clinc_id',$id);
        $this->set('doctor_list',$doctor_list);
        
        
         
     
    
   }
   
   
   function delete_doctor()
   {
       
       
       $msg=array();
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
			
				$doctor_id = $this->params->named['id'];
				
				//deleting clinic image from database
                                $doctor_clinc_id=$this->Doctor->find('first', array('fields' => array('clinic_id'), 'conditions' => array('Doctor.id' => $doctor_id)));
                                
				$last_image=$this->Doctor->find('first', array('fields' => array('img'), 'conditions' => array('Doctor.id' => $doctor_id)));
				if(!empty($last_image))
				{
					if($last_image['Doctor']['img']){
						$img_path = "./admin/uploads/".$last_image['Doctor']['img'];
						@unlink($img_path);
					}
				}
				
				
				
				//deleting clinic from database
				if($this->Doctor->delete($doctor_id)){
					$this->Session->setFlash(
						'Doctor deleted successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'clinics/list_doctor/id:'.$doctor_clinc_id['Doctor']['clinic_id']); 
				}
				else{
					$this->Session->setFlash(
						'Failed to delete Doctor. Please try again.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'clinics/list_doctor/id:'.$doctor_clinc_id['Doctor']['clinic_id']);  //if not logged sending to login page
				}
			
			
                }
       
       
       
   }
   
   function addwallpost($clinic_id)
   {
	$this->layout='frontend';
	
	/*logged in user details*/
	$logged_user_id=$this->Session->read('reid_user_uid');
	$user_details = $this->User->find('all', array('conditions' => array('User.id' => $logged_user_id)));
	$this->set('user_details',$user_details);
	$this->set('clinic_id',$clinic_id);
				
	if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
	 
	if ($this->request->is(array('post', 'put')))
			{
				$this->Wallpost->create();
				
				//creating array for save data
				
	//================================== Wall Attachment Image Start ===============================//
                               
                                  
			$destination1 = realpath('../../app/webroot/frontend/uploads/wallpost/') . '/';
			$destination2 = realpath('../../app/webroot/frontend/uploads/wallpost/thumbimage') . '/';
			if(isset($this->data['Wallpost']['attachment_image']['name']) && $this->data['Wallpost']['attachment_image']['name']!="")
			 {
				$allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg','image/png','application/octet-stream');
				$file= $this->data['Wallpost']['attachment_image'];
				$this->data['Wallpost']['attachment_image']['tmp_name'];
				$filename = time(). $this->data['Wallpost']['attachment_image']['name'];
				$file['name']= $filename;
				$result1 = $this->Upload->upload($file, $destination1, null, array('type' => 'resize', 'size' => array('100%', '100%'),'output' => 'jpg'));								  				$result2 = $this->Upload->upload($file, $destination2, null, array('type' => 'resize', 'size' => array('518', '300'), 'output' => 'jpg'));
			 }
					  
	
        //===================================== Wall Attachment Image End====================================//
				
				
				/*if clinic manager does not give any alias user info */
				if($this->request->data['Wallpost']['alias_fname']=='' && $this->request->data['Wallpost']['alias_lname']=='' && $this->request->data['Wallpost']['alias_designation']=='')
				 {
					$this->request->data['Wallpost']['alias_fname']=$user_details[0]['User']['first_name'];
					$this->request->data['Wallpost']['alias_lname']=$user_details[0]['User']['last_name'];
					$this->request->data['Wallpost']['alias_designation']="Clinic Manager";
				 }
				$data_to_be_saved['Wallpost']['user_id']=$this->Session->read('reid_user_uid');
				$data_to_be_saved['Wallpost']['clinic_id']=$clinic_id;
				$data_to_be_saved['Wallpost']['alias_fname']=$this->request->data['Wallpost']['alias_fname'];
				$data_to_be_saved['Wallpost']['alias_lname']=$this->request->data['Wallpost']['alias_lname'];
				$data_to_be_saved['Wallpost']['alias_designation']=$this->request->data['Wallpost']['alias_designation'];
				$data_to_be_saved['Wallpost']['post_title']=$this->request->data['Wallpost']['post_title'];
				$data_to_be_saved['Wallpost']['post_main_text']=$this->request->data['Wallpost']['post_main_text'];
				$data_to_be_saved['Wallpost']['attachment_heading']=$this->request->data['Wallpost']['attachment_heading'];
				$data_to_be_saved['Wallpost']['attachment_text']=$this->request->data['Wallpost']['attachment_text'];
				$data_to_be_saved['Wallpost']['attachment_url']=$this->request->data['Wallpost']['attachment_url'];
				$data_to_be_saved['Wallpost']['post_create_time']=date('Y-m-d H:i:s');
				$data_to_be_saved['Wallpost']['post_modify_time']=date('Y-m-d H:i:s');
				$data_to_be_saved['Wallpost']['status']=1;
				if(isset($filename))
				{
					$data_to_be_saved['Wallpost']['attachment_image']= $filename;
				}
				if($this->Session->read('reid_user_type')==2)//For Clinic Manager
				{
					$data_to_be_saved['Wallpost']['send_notification']= 0;	
				}
				elseif($this->Session->read('reid_user_type')==1)//For User
				{
					$data_to_be_saved['Wallpost']['send_notification']= 1;	
				}
				/*Save all input data into database*/	
				$this->Wallpost->save($data_to_be_saved);
				
				/*********SESSION MESSAGE AFTER SAVE THE POST********/
				$this->Session->setFlash(
						'Wallpost added successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
				return $this->redirect(BASE_URL.'clinics/clincwall/'.$clinic_id);
		
			}
	
		}
	
   }
   
   
   function editwallpost($post_id)
   {
	$this->layout='frontend';
	
	if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!='') && $this->Session->read('reid_user_type')==2)
		{
		/*For Wall Posts*/
			$edit_wall_post = $this->Wallpost->find('all', array('conditions' => array('Wallpost.id' => $post_id)));
			$clinic_id = $edit_wall_post[0]['Wallpost']['clinic_id'];
			$this->set('edit_wall_post',$edit_wall_post);
		/*For Wall Posts End*/
		
		/*--------------*/
		
		
			$destination1 = realpath('../../app/webroot/frontend/uploads/wallpost/') . '/';
			$destination2 = realpath('../../app/webroot/frontend/uploads/wallpost/thumbimage') . '/';
			if(isset($this->data['Wallpost']['attachment_image']['name']) && $this->data['Wallpost']['attachment_image']['name']!="")
			 {
				/*Unlink Image*/
				$org_img_path = "../../app/webroot/frontend/uploads/wallpost/".$edit_wall_post[0]['Wallpost']['attachment_image'];
				@unlink($org_img_path);
				$thumb_img_path = "../../app/webroot/frontend/uploads/wallpost/thumbimage/".$edit_wall_post[0]['Wallpost']['attachment_image'];
				@unlink($thumb_img_path);
				/*Unlink Image end*/
				
				$allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg','image/png','application/octet-stream');
				$file= $this->data['Wallpost']['attachment_image'];
				$this->data['Wallpost']['attachment_image']['tmp_name'];
				$filename = time(). $this->data['Wallpost']['attachment_image']['name'];
				$file['name']= $filename;
				$result1 = $this->Upload->upload($file, $destination1, null, array('type' => 'resize', 'size' => array('100%', '100%'),'output' => 'jpg'));		       $result2 = $this->Upload->upload($file, $destination2, null, array('type' => 'resize', 'size' => array('518', '300'), 'output' => 'jpg'));
			 }
			else
			{
				$filename=$edit_wall_post[0]['Wallpost']['attachment_image'];
			}
				
		
        
			if(!empty($this->request->data))  
			{
                                if($this->request->data['Wallpost']['alias_fname']=='' && $this->request->data['Wallpost']['alias_lname']=='' && $this->request->data['Wallpost']['alias_designation']=='')
				 {
					$this->request->data['Wallpost']['alias_fname']=$user_details[0]['User']['first_name'];
					$this->request->data['Wallpost']['alias_lname']=$user_details[0]['User']['last_name'];
					$this->request->data['Wallpost']['alias_designation']="Clinic Manager";
				 }
				$data_to_be_saved['Wallpost']['user_id']=$this->Session->read('reid_user_uid');
				//$data_to_be_saved['Wallpost']['clinic_id']=$clinic_id;
				$data_to_be_saved['Wallpost']['id']=$post_id;
				$data_to_be_saved['Wallpost']['alias_fname']=$this->request->data['Wallpost']['alias_fname'];
				$data_to_be_saved['Wallpost']['alias_lname']=$this->request->data['Wallpost']['alias_lname'];
				$data_to_be_saved['Wallpost']['alias_designation']=$this->request->data['Wallpost']['alias_designation'];
				$data_to_be_saved['Wallpost']['post_main_text']=$this->request->data['Wallpost']['post_main_text'];
				$data_to_be_saved['Wallpost']['attachment_heading']=$this->request->data['Wallpost']['attachment_heading'];
				$data_to_be_saved['Wallpost']['attachment_text']=$this->request->data['Wallpost']['attachment_text'];
				$data_to_be_saved['Wallpost']['attachment_url']=$this->request->data['Wallpost']['attachment_url'];
				//$data_to_be_saved['Wallpost']['post_create_time']=date('Y-m-d H:i:s');
				$data_to_be_saved['Wallpost']['post_modify_time']=date('Y-m-d H:i:s');
				$data_to_be_saved['Wallpost']['status']=1;
				$data_to_be_saved['Wallpost']['attachment_image']= $filename;
				/*----Update post table-----*/
				$this->Wallpost->save($data_to_be_saved);
				/*----Session message Update post table-----*/
				$this->Session->setFlash(
						'Wallpost updated successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
				return $this->redirect(BASE_URL.'clinics/clincwall/'.$clinic_id);
				
			}
		}
   }
         
	 
  /********Comment Section*********/
  
  function save_comment()
  {
	$this->layout='frontend';
	
	if(!empty($this->request->data))  
	{
		$wallpost_owner = $this->Wallpost->find('first', array('conditions' => array('Wallpost.id' => $this->request->data['post_id'])));
		$wallpost_owner_id = $wallpost_owner['Wallpost']['user_id'];
		if($this->request->data['comment_id']=="")
		{
		$this->Comment->create();	
		$data_to_be_saved['Comment']['clinic_id']=$this->request->data['clinic_id'];
		$data_to_be_saved['Comment']['post_id']=$this->request->data['post_id'];
		$data_to_be_saved['Comment']['user_id']=$this->request->data['user_id'];
		$data_to_be_saved['Comment']['comment']=$this->request->data['comment'];
		$data_to_be_saved['Comment']['posted_date']=date('Y-m-d H:i:s');
		if($wallpost_owner_id != $this->Session->read('reid_user_uid'))
		{
			$data_to_be_saved['Comment']['send_notification']=1;
		}
		else
		{
			$data_to_be_saved['Comment']['send_notification']=0;
		}
		$this->Comment->save($data_to_be_saved);
		return $this->redirect(BASE_URL.'clinics/clincwall/'.$data_to_be_saved['Comment']['clinic_id'].'/'.$this->Comment->id);
		}
		else
		{
		$data_to_be_saved['Comment']['id']=$this->request->data['comment_id'];
		$data_to_be_saved['Comment']['comment']=$this->request->data['comment'];
		$this->Comment->save($data_to_be_saved);
		return $this->redirect(BASE_URL.'clinics/clincwall/'.$this->request->data['clinic_id'].'/'.$this->request->data['comment_id']);
		}
	}
	
  }
  
  function delete_comment()
  {
   $this->layout='ajax';
	
	$comment_id = $this->request->data['comment_id'];
	$clinic_id = $this->request->data['clinic_id'];
	
	if(!empty($comment_id))  
	{
		$data_to_be_saved['Comment']['id']=$comment_id;
		$data_to_be_saved['Comment']['status']=0;
		$this->Comment->save($data_to_be_saved);
		echo "Comment Successfully Deleted.";
					
		//return $this->redirect(BASE_URL.'clinics/clincwall/'.$clinic_id);
	}
	
	$this->autoRender=false;
    
  }
 

function deletewallpost($post_id,$clinic_id)
  {
   $this->layout='frontend';
		
	if(!empty($post_id))  
	{
		$data_to_be_saved['Wallpost']['id']=$post_id;
		$data_to_be_saved['Wallpost']['status']=0;
		$this->Wallpost->save($data_to_be_saved);
							
		return $this->redirect(BASE_URL.'clinics/clincwall/'.$clinic_id);
	}

  } 
  
  function notificationlike()
  {
	$this->layout='ajax';
	
	$clinicmanager_id = $this->request->data['client_id'];
	//echo $clinicmanager_id;
		
	if(!empty($clinicmanager_id))  
	{
		/*for like notification*/
		$clinic_details = $this->Clinic->find('first', array('conditions' => array('Clinic.clinicmanagersid' => $clinicmanager_id)));
		$clinic_id	= $clinic_details['Clinic']['id'];
		
		$this->Cliniclike->updateAll(array('Cliniclike.send_notification' => 2),array('Cliniclike.clinic_id' => $clinic_id,'Cliniclike.send_notification' => 1));
		echo "Like Notification.";
		/*for like notification end*/
		
		/*for approved notification*/
			
		$this->Clinic->updateAll(array('Clinic.send_notification' => 2),array('Clinic.clinicmanagersid' => $clinicmanager_id,'Clinic.send_notification' => 1));
		echo "Approved Notification.";
		
		/*for approved notification End*/
		
		/*For user Post notification Start*/
		$clinic_details_by_manager = $this->Clinic->find('all', array('conditions' => array('Clinic.clinicmanagersid' => $clinicmanager_id)));
		//pr($clinic_details_by_manager);
		for($i=0;$i<sizeof($clinic_details_by_manager);$i++)
		{
			//echo $clinic_details_by_manager[$i]['Clinic']['id'];
			$this->Wallpost->updateAll(array('Wallpost.send_notification' => 2),array('Wallpost.clinic_id' => $clinic_details_by_manager[$i]['Clinic']['id'],'Wallpost.send_notification' => 1));
		}
		echo "Post Notification.";
		//exit;
		/*for user Post notification End*/
		
		/*For reply post notification start*/
		
		$post_details = $this->Wallpost->find('all', array('conditions' => array('Wallpost.user_id' => $clinicmanager_id)));
		//pr($post_details);
		for($i=0;$i<sizeof($post_details);$i++)
		{
			//echo $clinic_details_by_manager[$i]['Clinic']['id'];
			$this->Comment->updateAll(array('Comment.send_notification' => 2),array('Comment.post_id' => $post_details[$i]['Wallpost']['id'],'Comment.send_notification' => 1));
		}
		echo "Reply Post Notification.";
		/*For reply post notification end*/
	}
	
	$this->autoRender=false;
	
	
  }

	//Function for setting opening hour of clinics
	public function setopeninghours()
	{
	
		//checking whether logged or not
		
		//setting values for view page starts	
		$this->layout='frontend'; //loading frontend layout
		$this->set('METADATA','SeeDoctor.sg : Opening Hours'); //defining the login page title
		$this->set('METATITLE','SeeDoctor.sg : Opening Hours');
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1))
		{
			//pr($this->params);
			//echo "cld= ".$this->params->named['clinicid'];
			//exit;
			if(isset($this->params->named['clinicid']))
			{
				$id=$this->params->named['clinicid']; //picking up the  id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');				
				return $this->redirect(BASE_URL.'clinics/clintlist');  //if null or zero sending to listing page
			}
			
			$clinic = $this->Clinic->findById($id);
			
			//checking whether clinic  with supplied id exists or not?
			
			if (!$clinic)
			{
				$this->Session->write('msg','editnoclinic');	
				return $this->redirect(BASE_URL.'clinics/clintlist');  //if null or zero sending to listing page
			}
			
			
			$msg=array();
			//finding all slots and arranging them in array
			$slots_arr=array();
			for($i=1;$i<=7;$i++)
			{
				$slots_arr[$i]=$this->Openinghour->find('all',array('conditions'=>'clinicid="'.$id.'" and day="'.$i.'"','order'=>array('day'=>'asc','fromhour'=>'asc')));
			}
			$this->set('slots_arr',$slots_arr);
			$r=$this->Openinghour->find('first',array('fields'=>'max(id) as mx'));
			$maxid=$r[0]['mx'];
			if($maxid=='')
			{
				$maxid=0;
			}
			$this->set('maxid',$maxid);
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				
				$this->Openinghour->deleteAll(array('clinicid' => $id));
				for($i=1;$i<=7;$i++)
				{
					$n=$this->request->data['number_of_'.$i.'_slots'];
					for($j=1;$j<=$n;$j++)
					{
						//checking if the current slot is being deleted
						//if status==0 then user wants to delete hence continue
						
						if($this->request->data['status_'.$i.'_'.$j]==0)
						{
							continue;
						}
						else
						{
							$arr['Openinghour']['id']=$this->request->data['id_'.$i.'_'.$j];
							$arr['Openinghour']['day']=$i;
							$arr['Openinghour']['clinicid']=$id;
							$arr['Openinghour']['fromhour']=sprintf('%02d', $this->request->data['from_hours_'.$i.'_'.$j]);
							$arr['Openinghour']['tohour']=sprintf('%02d', $this->request->data['to_hours_'.$i.'_'.$j]);
							$arr['Openinghour']['fromminutes']=sprintf('%02d', $this->request->data['from_minutes_'.$i.'_'.$j]);
							$arr['Openinghour']['tominutes']=sprintf('%02d', $this->request->data['to_minutes_'.$i.'_'.$j]);
							
							$this->Openinghour->create();
							
							$this->Openinghour->save($arr);
							
						}
						
						
					}
				}
				            
				$this->Session->setFlash('Opening hour successfully updated for '.$clinic['Clinic']['name'],'default',array('class' => 'page_top_success'),'opening_updated');
				return $this->redirect(BASE_URL.'clinics/clintlist');
			}
			$this->set('msg',$msg);
                }
		else
		{
			
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
		
	}
}



?>
