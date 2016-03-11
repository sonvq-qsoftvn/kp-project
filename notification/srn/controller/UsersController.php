<?php

App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'fblogin', array('file' => 'fblogin' . DS . 'Facebook.php'));

class UsersController extends AppController
{
	public $helpers = array('Html', 'Form', 'Paginator', 'Facebook.Facebook'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator'); //loading necessary components
	
	//models used
var $uses=array('User', 'Sitesetting', 'Clinicmanager', 'Clinic', 'Clinicmanager', 'Insurance', 'Speciality', 'Insurancetoclinic', 'Eligibilitie', 'Eligibilitieclinc', 'ForgotPassReq','Doctor','Wallpost');
	
	//declaring paginator options
	public $paginate = array(
		'limit' => 5,
		'order' => array('User.fname' => 'asc'));
        
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

	//General Users :: Tabular view
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
			$this->set('title_for_layout','Manage General Users'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			$this->User->find('all',array('conditions'=>array('status'=>'1','user_type'=>'1')));
			 
               $paginate = array('limit' => 5,'order' => array('User.id' => 'DESC'));
			$this->Paginator->settings = $paginate;
			$data = $this->Paginator->paginate('User', array('User.user_type' => '1'));
               $this->set('all_users',$data);
			$this->set('left_sidebar_selected','users');
			$this->set('msg',$msg);
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	//General Users :: Delete general Users
	
	public function deleteuser()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['userid']))
			{
				$id=$this->params->query['userid']; //picking up the user id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');						
				return $this->redirect(BASE_URL.'administrator/users');  //if null or zero sending to listing page
			}
			
			$user = $this->User->findById($id);
			
			//checking whether user with supplied id exists or not?
			
			if (!$user)
			{
				$this->Session->write('msg','editnouser');	
				return $this->redirect(BASE_URL.'administrator/users');  //if null or zero sending to listing page
			}
			
			//codes for deletion starts
			
			if ($this->User->delete($id))
			{
				$this->Session->write('msg','deletesuccess');	
				return $this->redirect(BASE_URL.'administrator/users');
			
			}
			$this->Session->write('msg','deletefailure');	
			return $this->redirect(BASE_URL.'administrator/users');
			//codes for deletion ends
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	
	//Users :: Add user Page
	
	public function adduser()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Add User Form'); // setting  title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','users');
			$this->set('isformpage',1);
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				$this->User->create();
				
				//creating array for save data
				
				$data_to_be_saved=$this->request->data;
				$data_to_be_saved['User']['date_created']=date('Y-m-d h:i:s');
				$data_to_be_saved['User']['user_type'] = 1;
				$data_to_be_saved['User']['status'] = 1;
				//serverside validation starts
				
				$error_status=0;
				
				if($data_to_be_saved['User']['username']==''||!preg_match('/^[a-zA-Z0-9_]+$/',$data_to_be_saved['User']['username']))
				{
					$msg[]='Invalid user name';
					$error_status=1;
				}
				
				//checking if username exists
				
				$n=$this->User->find('count',array('conditions'=>'username="'.$data_to_be_saved['User']['username'].'"'));
				if($n!=0)
				{
					$msg[]='Username already exists';
					$error_status=1;
				}
				
				if($data_to_be_saved['User']['email']==''||!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$data_to_be_saved['User']['email']))
				{
					$msg[]='Invalid email id';
					$error_status=1;
				}
				
				//checking if email exists
				
				$n=$this->User->find('count',array('conditions'=>'email="'.$data_to_be_saved['User']['email'].'"'));
				if($n!=0)
				{
					$msg[]='Email Id already exists';
					$error_status=1;
				}
				if($data_to_be_saved['User']['password']==''||strlen($data_to_be_saved['User']['password'])<8||$data_to_be_saved['User']['password']==$data_to_be_saved['User']['username'])
				{
					$msg[]='Invalid password.Password must be atleast 8 characters long and should not be equal with username';
					$error_status=1;
				}
				if(!($data_to_be_saved['User']['gender']=='M'||$data_to_be_saved['User']['gender']=='F'))
				{
					$msg[]='You must select a gender';
					$error_status=1;
				}
				if($data_to_be_saved['User']['date_of_birth']=='')
				{
					$msg[]='Invalid dob';
					$error_status=1;
				}
				
				//serverside validation ends
				
				if($error_status==0)
				{
					$pass_before_md5=$data_to_be_saved['User']['password'];
					$data_to_be_saved['User']['password']=md5($pass_before_md5);
					if ($this->User->save($data_to_be_saved))
					{
						$mail_msg="<div style='width:80%;'>Hello ".$data_to_be_saved['User']['username'].",<p>Welcome to Seedoctor.sg. Your account as a general user has been created. You can login using the following details:<table><tr><td>Username</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td>".$data_to_be_saved['User']['username']."</td></tr><tr><td>Password</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td>".$pass_before_md5."</td></tr></table></p></div>";
						$Email = new CakeEmail();
						
						$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
						$Email->to($data_to_be_saved['User']['email']);
						$Email->subject('Account Creation Notification');
						$Email->emailFormat('html');
						$Email->send($mail_msg);
						$this->Session->write('msg','addsuccess');
						return $this->redirect(BASE_URL.'administrator/users');
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/users');	
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
	
	//Users :: Edit user Page
	
	public function edituser()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if(isset($this->params->query['userid']))
			{
				$id=$this->params->query['userid']; //picking up the user id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');				
				return $this->redirect(BASE_URL.'administrator/users?');  //if null or zero sending to listing page
			}
			
			$user = $this->User->findById($id);
			
			//checking whether user with supplied id exists or not?
			
			if (!$user)
			{
				
				$this->Session->write('msg','editnouser');		
				return $this->redirect(BASE_URL.'administrator/users');  //if null or zero sending to listing page
			}
			
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Edit User Form'); // setting  title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','users');
			$this->set('isformpage',1);
			
			//setting values ends
			if ($this->request->is(array('post', 'put')))
			{
				$this->User->id = $id;
				$data_to_be_saved=($this->request->data);
				$data_to_be_saved['User']['date_last_modified']=date('Y-m-d h:i:s');
								//serversid validation starts
				
				$error_status=0;
				
				if($data_to_be_saved['User']['username']==''||!preg_match('/^[a-zA-Z0-9_]+$/',$data_to_be_saved['User']['username']))
				{
					$msg[]='Invalid user name';
					$error_status=1;
				}
				
				//checking if username exists
				
				$n=$this->User->find('count',array('conditions'=>'username="'.$data_to_be_saved['User']['username'].'" and id!="'.$id.'"'));
				if($n!=0)
				{
					$msg[]='Username already exists';
					$error_status=1;
				}
				
				if($data_to_be_saved['User']['email']==''||!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$data_to_be_saved['User']['email']))
				{
					$msg[]='Invalid email id';
					$error_status=1;
				}
				
				//checking if email exists
				
				$n=$this->User->find('count',array('conditions'=>'email="'.$data_to_be_saved['User']['email'].'" and id!="'.$id.'"'));
				if($n!=0)
				{
					$msg[]='Email Id already exists';
					$error_status=1;
				}
				
				if(!($data_to_be_saved['User']['gender']=='M'||$data_to_be_saved['User']['gender']=='F'))
				{
					$msg[]='You must select a gender';
					$error_status=1;
				}
				if($data_to_be_saved['User']['date_of_birth']=='')
				{
					$msg[]='Invalid dob';
					$error_status=1;
				}
				
				//serverside validation ends
				if($error_status==0)
				{
				
				
					if ($this->User->save($data_to_be_saved))
					{
						$this->Session->write('msg','editsuccess');		
						return $this->redirect(BASE_URL.'administrator/users');
					}
					$this->Session->write('msg','editfailure');	
					return $this->redirect(BASE_URL.'administrator/users');
				}
				$this->set('msg',$msg);
			}
			else
			{
				$this->set('msg',array());
			}
			if (!$this->request->data)
			{
				$this->request->data = $user;
				$this->set('date_of_birth',(isset($user['User']['date_of_birth']))?date('Y/m/d', strtotime($user['User']['date_of_birth'])):date('Y/m/d'));
				$this->set('conf_password',$user['User']['password']);
			}
                }
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	
	//////////////////////Codes below this point is for temporarry use and subject to change
	
	// Start of Home function for index page
	
	function home()
	{
		$this->layout='frontend';
		
		/*FOR DOCTOR SEARCH DETAILS START*/
		/*FOR SPECIALITIES DROP DOWN START*/
		$specialities_detail_doctor= $this->Speciality->find('list',array('fields'=>array('id','specialities_name'),'conditions'=>'type=0 and specialities_parent_id=1','order'=>array('specialities_name ASC')));
		
      
		$sub_arr_doc=array();
		foreach($specialities_detail_doctor as $key=>$valSpecialityDoc)
		{
		$specialities_detail_doctor_arr[$key.'_par']=$valSpecialityDoc;	
$tmp_doc= $this->Speciality->find('list',array('fields'=>array('id','specialities_name'),'conditions'=>'specialities_parent_id="'.$key.'"','order'=>array('specialities_name ASC')));
	
			if(!empty($tmp_doc))
			{
				foreach($tmp_doc as $k2=>$v2)
				{
				$specialities_detail_doctor_arr[$k2.'_sub']='&nbsp;&nbsp;--'.$v2;	
				}
			}
		}
		$this->set('specialities_detail_doctor_arr',$specialities_detail_doctor_arr);
	//pr($specialities_detail_doctor_arr);
	//exit;
		/*FOR SPECIALITIES DROP DOWN END*/
		
		
		/*FOR DOCTOR SEARCH DETAILS END*/
		
		
		/*FOR DENTIST SEARCH DETAILS START*/
	           /*FOR SPECIALITIES DROP DOWN START*/
		$specialities_detail= $this->Speciality->find('list',array('fields'=>array('id','specialities_name'),'conditions'=>'type=1 and specialities_parent_id=1'));
		
      
		$sub_arr=array();
		foreach($specialities_detail as $key=>$valSpeciality)
		{
		$specialities_detail_arr[$key.'_par']=$valSpeciality;	
$tmp= $this->Speciality->find('list',array('fields'=>array('id','specialities_name'),'conditions'=>'specialities_parent_id="'.$key.'"','order'=>array('specialities_name ASC')));
	
			if(!empty($tmp))
			{
				foreach($tmp as $k2=>$v2)
				{
				$specialities_detail_arr[$k2.'_sub']='&nbsp;&nbsp;--'.$v2;	
				}
			}
		}
		$this->set('specialities_detail_arr',$specialities_detail_arr);
	//pr($specialities_detail_arr);
	//exit;
		   /*FOR SPECIALITIES DROP DOWN END*/
		   
		   
		   /*FOR INSURANCE DROP DOWN START*/
		/*$insurance_detail= $this->Insurance->find('list',array('fields'=>array('id','insurances_name'),'conditions'=>'insurances_status=1','order'=>array('insurances_name ASC')));
		//pr($insurance_detail);
		//exit;
		$this->set('insurance_detail',$insurance_detail);*/
           
		   /*FOR INSURANCE DROP DOWN START*/
		$insurance_detail_doctor= $this->Insurance->find('list',array('fields'=>array('id','insurances_name'),'conditions'=>'insurance_parent_id=1','order'=>array('insurances_name ASC')));
		
      
		$sub_arr_doc=array();
		foreach($insurance_detail_doctor as $key=>$valInsuranceDoc)
		{
		$insurance_detail_doctor_arr[$key]=$valInsuranceDoc;	
$tmp_doc= $this->Insurance->find('list',array('fields'=>array('id','insurances_name'),'conditions'=>'insurance_parent_id="'.$key.'"','order'=>array('insurances_name ASC')));
	
			if(!empty($tmp_doc))
			{
				foreach($tmp_doc as $k2=>$v2)
				{
				$insurance_detail_doctor_arr[$k2]='&nbsp;&nbsp;--'.$v2;	
				}
			}
		}
		$this->set('insurance_detail_doctor_arr',$insurance_detail_doctor_arr);
	
		/*FOR INSURANCE DROP DOWN END*/
		
		 /*FOR COPAYMENT ELIGIBILITY DROP DOWN START*/
		$eligibility_detail_doctor= $this->Eligibilitie->find('list',array('fields'=>array('id','name'),'conditions'=>'eligibilities_parent_id=1','order'=>array('name ASC')));
		
      
		$sub_arr_doc=array();
		foreach($eligibility_detail_doctor as $key=>$valInsuranceDoc)
		{
		$eligibility_detail_doctor_arr[$key]=$valInsuranceDoc;	
$tmp_doc= $this->Eligibilitie->find('list',array('fields'=>array('id','name'),'conditions'=>'eligibilities_parent_id="'.$key.'"','order'=>array('name ASC')));
	
			if(!empty($tmp_doc))
			{
				foreach($tmp_doc as $k2=>$v2)
				{
				$eligibility_detail_doctor_arr[$k2]='&nbsp;&nbsp;--'.$v2;	
				}
			}
		}
		$this->set('eligibility_detail_doctor_arr',$eligibility_detail_doctor_arr);
	
		/*FOR COPAYMENT ELIGIBILITY DROP DOWN END*/
				
           /*----------------Uto complete search  clinic name and doctors name--------*/     
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
			
                                                        
                       $suggested_names= $this->Doctor->find('list',array('fields'=>array('Doctor.f_name')));	
										
		//pr($suggested_names);				
							$i=0;
							$y='';
							foreach($suggested_names as $k=>$v)
							{
								if($i!=0)
								{$y.= ',';}
								$y.= "'".$v."'";
								$i++;
							}
                                                        
                                                        
                        $suggested_names= $this->Doctor->find('list',array('fields'=>array('Doctor.l_name')));	
										
		//pr($suggested_names);				
							$i=0;
							$z='';
							foreach($suggested_names as $k=>$v)
							{
								if($i!=0)
								{$z.= ',';}
								$z.= "'".$v."'";
								$i++;
							}                                    
                                                        
                                                        
                                                        if($y!="")
                                                        {
                                                            
                                                           $total_data = $x.','.$y.''.$z;  
                                                            
                                                        }else{
                                                            
                                                            
                                                           $total_data = $x;
                                                            
                                                        }
                                                        
                                                      
                                                       
                                                      
                                                    
                                                        
                                                        
				$this->set('dat',$total_data);
                
		
		   
		   /*FOR INSURANCE DROP DOWN END*/
		   
		/*FOR DENTIST SEARCH DETAILS END*/
		
		/*--------FEATURED EVENTS [WALL POSTS IN FRONT END] START--------*/
		$this->Wallpost->bindModel(array(
						'belongsTo' => array(
							'Clinic' => array('foreignKey' =>false,'className'=>'Clinic','conditions'=>array("Wallpost.clinic_id=Clinic.id and Wallpost.status = 1" ),'type' => 'INNER'),
									)
				)
			,false);
		$all_wallposts = $this->Wallpost->find('all',array('conditions'=>'featured=1'));
		//pr($all_wallposts);
		$this->set('all_wallposts',$all_wallposts);
		/*--------FEATURED IN [DOCTORS SHOW IN FRONT END] END--------*/
		
		/*--------FEATURED IN [DOCTORS SHOW IN FRONT END] START--------*/
		
		$all_doctors = $this->Doctor->find('all',array('conditions'=>'featured=1'));
		//pr($all_doctors);
		$this->set('all_doctors',$all_doctors);
		/*--------FEATURED IN [DOCTORS SHOW IN FRONT END] END--------*/
	}
	
	
	
	// End of Home function for index page
	
	// Start of Registration function for index page
	
	function register()
	{
		$components = array('Facebook.Connect');
		
		//------------------------------create captcha value-------------------------------------
		$captcha_val=chr(rand(65,90)).rand(0,9).chr(rand(65,90)).rand(0,9).chr(rand(65,90));
		@session_start();
		$this->Session->delete('captcha_val');
		$this->Session->write('captcha_val',$captcha_val);	

		//------------------------------END create captcha value-------------------------------------

		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			return $this->redirect(BASE_URL.'users/userprofile'); //if already logged in send to dashboard
		}
		
		$this->layout='frontend';
		if ($this->request->is(array('post', 'put')))
		{
			$this->User->create();
			
			//creating array for save data
			//echo '<pre>'; print_r($this->request->data); echo '</pre>';
			
			$data_to_be_saved['User']=$this->request->data;
			
			if($this->request->data('facebook_id'))
				$data_to_be_saved['User']['facebook_id']=$this->request->data('facebook_id');
			else
				$data_to_be_saved['User']['facebook_id']=0;
			
			$data_to_be_saved['User']['date_created']=date('Y-m-d h:i:s');
			
			if($this->request->data('user_type'))
				$data_to_be_saved['User']['user_type']=$this->request->data('user_type');
			else
				$data_to_be_saved['User']['user_type']=1;
			
			$data_to_be_saved['User']['status']=1;
			
			///echo '<pre>'; print_r($data_to_be_saved); echo '</pre>';die;
			
			//serverside validation starts
			$error_status=0;
			
			if($data_to_be_saved['User']['username']==''||!preg_match('/^[a-zA-Z0-9_]+$/',$data_to_be_saved['User']['username']))
			{
				$msg[]='Invalid user name';
				$error_status=1;
			}
			
			//checking if username exists
			
			$n=$this->User->find('count',array('conditions'=>'username="'.$data_to_be_saved['User']['username'].'"'));
			if($n!=0)
			{
				$msg[]='Username already exists';
				$error_status=1;
			}
			
			if($data_to_be_saved['User']['email']==''||!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$data_to_be_saved['User']['email']))
			{
				$msg[]='Invalid email id';
				$error_status=1;
			}
			
			//checking if email exists
			
			$n=$this->User->find('count',array('conditions'=>'email="'.$data_to_be_saved['User']['email'].'"'));
			if($n!=0)
			{
				$msg[]='Email Id already exists';
				$error_status=1;
			}
			
			if($data_to_be_saved['User']['facebook_id']==0)
			{
				if($data_to_be_saved['User']['password1'] == '' || strlen($data_to_be_saved['User']['password1']) < 8 || $data_to_be_saved['User']['password1']==$data_to_be_saved['User']['username'] )
				{
					$msg[]='Invalid password. Password must be atleast 8 characters long and should not be equal with username';
					$error_status=1;
				}
			}
			
			if(!($data_to_be_saved['User']['gender'] == 'M' || $data_to_be_saved['User']['gender'] == 'F'))
			{
				$msg[]='You must select a gender';
				$error_status=1;
			}
			
			if($data_to_be_saved['User']['date_of_birth'] == '')
			{
				$msg[]='Invalid date of birth';
				$error_status=1;
			}
			
			//serverside validation ends
			
			if($error_status==0)
			{
				$pass_before_md5=$data_to_be_saved['User']['password1'];
				$data_to_be_saved['User']['password']=md5($pass_before_md5);
				$data_to_be_saved['User']['date_of_birth'] = date('Y-m-d', strtotime($data_to_be_saved['User']['date_of_birth']));
				
				if ($this->User->save($data_to_be_saved))
				{
					$mail_msg="<div style='width:80%;'>Hello ".$data_to_be_saved['User']['username'].",<p>Welcome to Seedoctor.sg. Your account as a general user has been created. You can login using the following details:<table><tr><td>Username</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td>".$data_to_be_saved['User']['username']."</td></tr><tr><td>Password</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td><td>".$pass_before_md5."</td></tr></table></p></div>";
					$Email = new CakeEmail();
					
					$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
					$Email->to($data_to_be_saved['User']['email']);
					$Email->subject('Account Creation Notification');
					$Email->emailFormat('html');
					$Email->send($mail_msg);
					//echo "<script>alert('Registration completed. Please check your email for further instructions....');</scrip>";
					
					$msg = "Registration successful. Welcome to ";
					$this->set('msg',$msg);
					
					return $this->redirect(BASE_URL.'contents/showcontent');
				}
				else
				{
					$this->Session->setFlash(
						'Failed to register. Please try again',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					); 
				}
			}
			else
			{
				//echo 'arijit error <pre>'; print_r($msg); echo '</pre>';
				$this->Session->setFlash(
					implode('<br>', $msg),
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
			}
		}
	}
	
	// End of Registration function for index page
	
	// Start of login page function ---- not needed currently
	
	public function login() 
	{
		$msg='';
		$data_arr=$this->params->query;
		
		if(isset($data_arr['status']))
		{
			if($data_arr['status']=='Invalid')
			{
				$msg='Invalid USername Or Password';
			}
		}
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			return $this->redirect(BASE_URL.'dashboard'); //if already logged in send to dashboard
		}
		else
		{
			$this->layout='frontend'; //loading the login page layout
			
			$this->set('title_for_layout','User Login'); //defining the login page title
			
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			//setting cookie for 1 year if remember me is on
			
			if($this->Cookie->check('reid_user_username'))
			{
				$username=$this->Cookie->read('reid_user_username');
				
			}
			else
			{
				$username='';
			}
			if($this->Cookie->check('reid_user_password'))
			{
				$password=$this->Cookie->read('reid_user_password');
			}
			else
			{
				$password='';
			}
			
			//setting cookie ends
			
			$token=rand(1000,9999).time(); //creating random login token for authentication
			$this->Session->write('user_login_token',$token); // setting the login token in session
			
			//sending values to the page
			
			$this->set('user_login_token',$token); 
			$this->set('reid_user_username',$username);
			$this->set('reid_user_password',$password);
			if($this->Cookie->check('reid_reid_username')&&$this->Cookie->check('reid_reid_password'))
			{
				$this->set('remember_me','on');
			}
			else
			{
				$this->set('remember_me','off');
			}
			$this->set('msg',$msg);
			
			//sending value ends
		}
		
	}
	
	// End of login page function ---- not needed currently
	
	// Start of login authenticate function 
	
	public function logincheck()
	{
		$data_arr=array();
		
		$data_arr=$this->request->data; //picking all the requested data
		
		//checking whether the post call is made, the submit button is the login button and the authentication token is valid
		
		if($_SERVER['REQUEST_METHOD'] === 'POST' && $this->Session->read('user_login_token') == $data_arr['token'] )
		{
			$this->Session->delete('user_login_token'); //destroying authentication token
			
			$u=$data_arr['username'];
			
			$p=md5($data_arr['password']); //hashing the password
			
			if($data_arr['is_email']==1)
				$n_user = $this->User->find('count', array('conditions' => array('User.email' => $u,'User.password'=>$p)));
			else
				$n_user = $this->User->find('count', array('conditions' => array('User.username' => $u,'User.password'=>$p)));
				
			if($n_user==1)
			{
				//if remember me is on setting username and password in cookie
			
				if($data_arr['remember_me']=='on' || $data_arr['remember_me']=='1')
				{
					if($this->Cookie->check('reid_user_username'))
					{
						$this->Cookie->delete('reid_user_username');
					}
					
					$this->Cookie->write('reid_user_username',$data_arr['username'], false, 31536000);
					
					if($this->Cookie->check('reid_user_password'))
					{
						$this->Cookie->delete('reid_user_password');
					}
					
					$this->Cookie->write('reid_user_password',$data_arr['password'], false, 31536000);
				}
				
				if($data_arr['is_email']==1)
					$user_details=$this->User->find('all', array('conditions' => array('User.email' => $u,'User.password'=>$p)));
				else
					$user_details=$this->User->find('all', array('conditions' => array('User.username' => $u,'User.password'=>$p)));
					
				$uid=$user_details[0]['User']['id'];
				
				$this->Session->write('reid_user_logged',1);
				$this->Session->write('reid_user_uid',$uid);
				$this->Session->write('reid_user_type',$user_details[0]['User']['user_type']);
				$this->Session->write('reid_user_login_type','normal');
				
				return $this->redirect(BASE_URL.'userprofile');
			}
			else
			{
				$this->Session->setFlash(
					'Invalid login details. Please try again',
					'default',
					array('class' => 'error'),
					'login_error'
				);
				
				return $this->redirect(BASE_URL);
			}
		}
		else
		{
			$this->Session->delete('user_login_token'); //destroying authentication token	
			
			return $this->redirect(BASE_URL);
		}
		
	}
	
	// End of login authenticate function 
	
	// Start of dashboard function 
	
	public function dashboard()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			$this->layout='frontend'; //loading  layout
			$user_details=$this->User->find('all', array('conditions' => array('User.id' => $this->Session->read('reid_user_uid'))));
			$uname=$user_details[0]['User']['username'];
			$this->set('uname',$uname);
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
	
	// End of dashboard function
	
	// Start of logout function 
	
	public function logout()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			//session_destroy();
			$this->Session->delete('reid_user_logged');
			$this->Session->delete('reid_user_uid');
			$this->Session->delete('reid_user_login_type');
			return $this->redirect(BASE_URL);
		}
		else
		{
			return $this->redirect(BASE_URL);  //if not logged sending to login page
		}
	}
	
	// End of logout function 

	// Start of Facebook register function 
	
	public function facebook_register()
	{
	     $facebook = new Facebook;
		
		$user=$facebook->getuser(); 
		
		if ($user) 
		{
		     try{ $user_profile = $facebook->api('/'.$user);} 
			catch (FacebookApiException $e)
			{
				$this->Session->setFlash(
					'Failed to obtain facebook data. Please try again after logging into facebook',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				
				$this->redirect(BASE_URL.'register');
			}			
			
			if(isset($user_profile))
			{
				//pr($user_profile);die;
				
				$user_type = (isset($this->params->query['type']))?$this->params->query['type']:1;
				
				$error_status=0;
				$fb_id=$mail=$gender=$birthday=$username=$conditions=$birthday='';
				
				// Setting user type to general user if not specified otherwise
				if(isset($this->params->query['type']))
					$user_type=$this->params->query['type'];
				else
					$user_type=1;
				
				$fb_id 	= (isset($user_profile['id']))?$user_profile['id']:'';
				$mail 	= (isset($user_profile['email']))?$user_profile['email']:'';
				$gender 	= (isset($user_profile['gender']))?substr($user_profile['gender'], 0, 1):'';
				$birthday = (isset($user_profile['birthday']))?$user_profile['birthday']:'';
				$first_name = (isset($user_profile['first_name']))?$user_profile['first_name']:'';
				$last_name = (isset($user_profile['last_name']))?$user_profile['last_name']:'';
				
				if($mail)
				{
					$email_det=explode('@', $mail);
					$username=$email_det[0].'_facebook'; // Generating username from email
					$username=str_replace('.', '_', $username);
				}
				else
				{
					$username=(isset($user_profile['first_name']))?$user_profile['first_name'].'_facebook':$fb_id;
				}
				
				$conditions = "User.facebook_id = '".$fb_id."'";
				
				$user_count = $this->User->find('count',array('conditions'=>array($conditions))); 
			    
				if($user_count==0)
				{
					$n=$this->User->find('count',array('conditions'=>'username="'.$username.'"')); //checking for same username
					if($n!=0)
					{
						$msg[]='Username already exists';
						$error_status=1;
					}
					
					$n1=$this->User->find('count',array('conditions'=>'email="'.$mail.'"')); //checking for same email
					if($n!=0)
					{
						$msg[]='Email Id already exists';
						$error_status=1;
					}
					
					$n2=$this->User->find('count',array('conditions'=>'facebook_id="'.$fb_id.'"')); //checking for same facebook id
					if($n!=0)
					{
						$msg[]='Facebook Id already exists';
						$error_status=1;
					}
					
					if($error_status == 0)
					{
						$this->User->create();
						
						//creating array for save data
						if($user_type==2)
						{
							$data_to_be_saved1['User']['first_name'] = $first_name;
							$data_to_be_saved1['User']['last_name'] = $last_name;
						}
						
						$data_to_be_saved1['User']['username'] = $username;
						$data_to_be_saved1['User']['email'] = $mail;
						$data_to_be_saved1['User']['gender'] = ucwords($gender);
						$data_to_be_saved1['User']['date_of_birth'] = date('Y-m-d', strtotime($birthday));
						$data_to_be_saved1['User']['status'] = 1;
						$data_to_be_saved1['User']['user_type']=$user_type;
						$data_to_be_saved1['User']['date_created']=date('Y-m-d h:i:s');
						$data_to_be_saved1['User']['facebook_id']=$fb_id;
						
						if($this->User->save($data_to_be_saved1))
						{
							$mail_msg="<div style='width:80%;'>Hello ".$data_to_be_saved1['User']['username'].",<p>Welcome to Seedoctor.sg. Your account as a general user has been created.</p></div>";
						
							$Email = new CakeEmail();
							$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
							$Email->to($mail);
							$Email->subject('Account Creation Notification');
							$Email->emailFormat('html');
							$Email->send($mail_msg);
							
							$this->Session->setFlash(
								'You are successfully registered into our site.',
								'default',
								array('class' => 'page_top_success'),
								'update_error'
							);
							
							$this->redirect(BASE_URL."users/get_fb_id?fb_id=".$fb_id."&fb_name=".$user_profile['name']);
						}
						else
						{
							$this->Session->setFlash(
								'Sorry! registration failed. Please try again',
								'default',
								array('class' => 'page_top_error'),
								'update_error'
							);
							
							return $this->redirect(BASE_URL."users/register");
						}
					}
					else
					{
						$this->Session->setFlash(
							implode('<br>', $msg),
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						$this->redirect(BASE_URL);
					}
				}
				else
				{
					return $this->redirect(BASE_URL."users/get_fb_id?fb_id=".$fb_id."&fb_name=".$user_profile['name']);
				}
				
				return $this->redirect(BASE_URL);
		 	}
			else 
			{
				$this->Session->setFlash(
					'Failed to obtain facebook data. Please try again',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				
				$this->redirect(BASE_URL.'register');
					    
				exit;			
			}
		}
		else 
		{
			//$auth_config['scope'] = 'email'; 
			//$auth_config['display'] = 'popup';
			//
			//$data['login_url'] = $facebook->getLoginUrl($auth_config);
			
			$this->Session->setFlash(
				'Failed to obtain facebook data. Please try after logging in facebook.',
				'default',
				array('class' => 'page_top_error'),
				'update_error'
			);
			
			$this->redirect(BASE_URL.'register');
			
			exit;	
		}
	}
	//Facebook register function end
	
	
	// Start of Facebook login function 
	
	public function facebook_login()
	{
	     $facebook = new Facebook;
		
		$user=$facebook->getuser(); 
		//pr($user);exit;
		if ($user) 
		{
		     try{ $user_profile = $facebook->api('/'.$user);} 
			catch (FacebookApiException $e)
			{
				$this->Session->setFlash(
					'Failed to obtain facebook data. Please try again after logging into facebook',
					'default',
					array('class' => 'error'),
					'login_error'
				);
				
				$this->redirect(BASE_URL);
			}			
			
			if(isset($user_profile))
			{
				$error_status=0;
				$fb_id=$mail=$gender=$birthday=$username=$conditions=$birthday='';
				
				// Setting user type to general user if not specified otherwise
				if(isset($this->params->query['type']))
					$user_type=$this->params->query['type'];
				else
					$user_type=1;
				
				$fb_id 	= (isset($user_profile['id']))?$user_profile['id']:'';
				$mail 	= (isset($user_profile['email']))?$user_profile['email']:'';
				$gender 	= (isset($user_profile['gender']))?$user_profile['gender']:'';
				$birthday = (isset($user_profile['birthday']))?$user_profile['birthday']:'';
				$first_name = (isset($user_profile['first_name']))?$user_profile['first_name']:'';
				$last_name = (isset($user_profile['last_name']))?$user_profile['last_name']:'';
				
				if($mail)
				{
					$email_det=explode('@', $mail);
					$username=$email_det[0].'_facebook'; // Generating username from email
					$username=str_replace('.', '_', $username);
				}
				else
				{
					$username=(isset($user_profile['first_name']))?$user_profile['first_name'].'_facebook':$fb_id;
				}
				
				$conditions = "User.facebook_id = '".$fb_id."'";
				
				$user_count = $this->User->find('count',array('conditions'=>array($conditions))); 
			    
				if($user_count==0)
				{
					$n=$this->User->find('count',array('conditions'=>'username="'.$username.'"')); //checking for same username
					if($n!=0)
					{
						$msg[]='Username already exists';
						$error_status=1;
					}
					
					$n1=$this->User->find('count',array('conditions'=>'email="'.$mail.'"')); //checking for same email
					if($n!=0)
					{
						$msg[]='Email Id already exists';
						$error_status=1;
					}
					
					$n2=$this->User->find('count',array('conditions'=>'facebook_id="'.$fb_id.'"')); //checking for same facebook id
					if($n!=0)
					{
						$msg[]='Facebook Id already exists';
						$error_status=1;
					}
					
					if($error_status == 0)
					{
						$this->request->data['username'] = $username;
						$this->request->data['first_name'] = $first_name;
						$this->request->data['last_name'] = $last_name;
						$this->request->data['email'] = $mail;
						$this->request->data['gender'] = ucwords($gender);
						$this->request->data['status'] = 1;
						$this->request->data['date_of_birth'] = date('Y-m-d', strtotime($birthday));
						$this->request->data['facebook_id'] = $fb_id;
						
						$this->Session->setFlash(
							'Almost done. Please choose an user type to complete registration.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
						$this->layout='frontend'; //loading layout
					}
					else
					{
						$this->Session->setFlash(
							implode('<br>', $msg),
							'default',
							array('class' => 'error'),
							'login_error'
						);
						$this->redirect(BASE_URL);
					}
				}
				else
				{
					return $this->redirect(BASE_URL."users/get_fb_id?fb_id=".$fb_id."&fb_name=".$user_profile['name']);
				}
		 	}
			else 
			{
				$this->Session->setFlash(
					'Failed to obtain facebook data. Please try again',
					'default',
					array('class' => 'error'),
					'login_error'
				);
				
				$this->redirect(BASE_URL);
					    
				exit;			
			}
		}
		else 
		{
			//$auth_config['scope'] = 'email, birthday'; 
			//$auth_config['display'] = 'popup';
			//
			//$data['login_url'] = $facebook->getLoginUrl($auth_config);
			
			$this->Session->setFlash(
				'Failed to obtain facebook data. Please try after logging in facebook.',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			
			$this->redirect(BASE_URL);
		}
	}
	//Facebook login end
	
	
	//Facebook login auth
	public function get_fb_id()
	{
		$facebook_id=$this->params->query['fb_id'];
		$name=$this->params->query['fb_name'];
	      
		$conditions = "User.facebook_id = '".$facebook_id."'";
		$user_details = $this->User->find('first',array('conditions'=>array($conditions)));
		
		$uid=$user_details['User']['id'];
		
		$this->Session->write('reid_user_logged',1);
		$this->Session->write('reid_user_uid',$uid);
		$this->Session->write('reid_user_type',$user_details['User']['user_type']);
		$this->Session->write('reid_user_login_type','fb');
		$this->Session->write('reid_user_name',$name);
		
		$this->redirect(BASE_URL.'userprofile');
	}
	//Facebook login auth
	
	// Start of user profile function 	

	public function userprofile()
	{
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged') == 1) && ($this->Session->read('reid_user_uid') !='' ))
		{
			$this->layout='frontend'; //loading layout
			
			$user_details=$this->User->find('all', array('conditions' => array('User.id' => $this->Session->read('reid_user_uid'))));
			
			if(!empty($user_details))
			{
				$id = $user_details[0]['User']['id'];
				$username = $user_details[0]['User']['username'];
				$first_name = $user_details[0]['User']['first_name'];
				$last_name = $user_details[0]['User']['last_name'];
				$email = $user_details[0]['User']['email'];
				$gender = $user_details[0]['User']['gender'];
				$date_of_birth = $user_details[0]['User']['date_of_birth'];
				$phone_number = $user_details[0]['User']['phone_number'];
				$user_type = $user_details[0]['User']['user_type'];
				$facebook_id = $user_details[0]['User']['facebook_id'];
				
				$this->set('id',$id);
				$this->set('username',$username);
				$this->set('first_name',$first_name);
				$this->set('last_name',$last_name);
				$this->set('email',$email);
				$this->set('gender',$gender);
				$this->set('date_of_birth',$date_of_birth);
				$this->set('phone_number',$phone_number);
				$this->set('user_type',$user_type);
				$this->set('facebook_id', $facebook_id);
			}
			
			$this->set('profile_details',$user_details);
		}
		else
		{
			$this->Session->setFlash(
				'Please login to continue',
				'default',
				array('class' => 'error'),
				'login_error'
			);
			return $this->redirect(BASE_URL);
		}
	}
	
	// End of user profile function 		
	
	// Start of update of user profile function 		
	
	public function userupdate()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			$this->layout='frontend'; //loading  layout
		
			if ($this->request->is(array('post', 'put')))
			{
				$data_arr=$this->request->data; //picking all the posted data
				
				//serverside validation starts
				$error_status=0;
				
				if($data_arr['username']==''||!preg_match('/^[a-zA-Z0-9_]+$/',$data_arr['username']))
				{
					$msg[]='Invalid user name';
					$error_status=1;
				}
				
				//checking if username exists
				
				$n=$this->User->find('count',array('conditions'=> array('username="'.$data_arr['username'].'"', 'NOT' => array('id' => $data_arr['id']))));
				if($n!=0)
				{
					$msg[]='Username already exists';
					$error_status=1;
				}
				
				if($data_arr['email']==''||!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$data_arr['email']))
				{
					$msg[]='Invalid email id';
					$error_status=1;
				}
				
				//checking if email exists
				
				$n=$this->User->find('count',array('conditions'=> array('email="'.$data_arr['email'].'"', 'NOT' => array('id' => $data_arr['id']))));
				if($n!=0)
				{
					$msg[]='Email Id already exists';
					$error_status=1;
				}
				
				if(!($data_arr['gender'] == 'M' || $data_arr['gender'] == 'F'))
				{
					$msg[]='You must select a gender';
					$error_status=1;
				}
				
				if($data_arr['date_of_birth'] == '')
				{
					$msg[]='Invalid date of birth';
					$error_status=1;
				}
				
				//serverside validation ends
				
				if($error_status==0)
				{
					$data['User']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
					$data['User']['email']=(isset($data_arr['email']))?$data_arr['email']:'';
					$data['User']['username']=(isset($data_arr['username']))?$data_arr['username']:'';
					$data['User']['date_of_birth']=(isset($data_arr['date_of_birth']))?date('Y-m-d', strtotime($data_arr['date_of_birth'])):'';	
					$data['User']['gender']=(isset($data_arr['gender']))?$data_arr['gender']:'';
					
					//For clinic Manager
					$data['User']['first_name']=(isset($data_arr['first_name']))?$data_arr['first_name']:'';
					$data['User']['last_name']=(isset($data_arr['last_name']))?$data_arr['last_name']:'';
					$data['User']['phone_number']=(isset($data_arr['phone_number']))?$data_arr['phone_number']:'';
					
					if($this->User->save($data))
					{
						//if($data_arr['user_type']==2)
						//{
						//	$data1['Clinicmanager']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
						//	$data1['Clinicmanager']['clinicmanagers_email']=(isset($data_arr['email']))?$data_arr['email']:'';
						//	$data1['Clinicmanager']['clinicmanagers_username']=(isset($data_arr['username']))?$data_arr['username']:'';
						//	$data1['Clinicmanager']['clinicmanagers_date_of_birth']=(isset($data_arr['date_of_birth']))?date('Y-m-d', strtotime($data_arr['date_of_birth'])):'';	
						//	$data1['Clinicmanager']['clinicmanagers_gender']=(isset($data_arr['gender']))?$data_arr['gender']:'';
						//	
						//	//For clinic Manager
						//	$data1['Clinicmanager']['clinicmanagers_fname']=(isset($data_arr['first_name']))?$data_arr['first_name']:'';
						//	$data1['Clinicmanager']['clinicmanagers_lname']=(isset($data_arr['last_name']))?$data_arr['last_name']:'';
						//	$data1['Clinicmanager']['clinicmanagers_hand_phone']=(isset($data_arr['phone_number']))?$data_arr['phone_number']:'';
						//	
						//	$this->Clinicmanager->save($data1);
						//}
						
						$this->Session->setFlash(
							'Account details updated successfully.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
					}
					else{
						$this->Session->setFlash(
							'Failed to update account details. Please try again..',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
					}
				}
				else
				{
					$this->Session->setFlash(
						implode('<br> ', $msg),
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
				}
				
				return $this->redirect(BASE_URL.'userprofile');
			}
			else
			{
				return $this->redirect(BASE_URL.'userprofile');  //if no request data found
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
	
	// End of update of user profile function
	
	// Start of function change password
	
	public function changepassword()
	{
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			$this->layout='frontend'; //loading  layout
		
			if ($this->request->is(array('post', 'put')))
			{
				$data_arr=$this->request->data; //picking all the posted data
				
				//serverside validation starts
				$error_status=0;
				
				//if($data_arr['password'] == '' || strlen($data_arr['password']) < 8 || $data_arr['password']==$data_arr['username'] )
				//{
				//	$msg[]='Invalid password. Password must be atleast 8 characters long and should not be equal with username';
				//	$error_status=1;
				//}
				
				//serverside validation ends
				
				if($error_status==0)
				{
					$data['User']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
					$data['User']['password'] = (isset($data_arr['password']))?md5($data_arr['password']):'';
					
					if($this->User->save($data))
					{
						//if($data_arr['user_type'] == 2)
						//{
						//	$data1['Clinicmanager']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
						//	$data1['Clinicmanager']['clinicmanagers_password']=(isset($data_arr['password']))?md5($data_arr['password']):'';
						//	
						//	$this->Clinicmanager->save($data1);
						//}
						
						$this->Session->setFlash(
							'Password updated successfully.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
					}
					else{
						$this->Session->setFlash(
							'Failed to update password. Please try again..',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
					}
				}
				else
				{
					$this->Session->setFlash(
						implode('<br> ', $msg),
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
				}
				
				return $this->redirect(BASE_URL.'userprofile');
			}
			else
			{
				return $this->redirect(BASE_URL.'userprofile');  //if no request data found
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
	
	// Start of forgot password function
	public function forgotpassword()
	{
		$this->layout='frontend'; //loading  layout
		$this->set('page_show_type',1);
		$this->set('page_show_type1',0);
		$error_status = 0;
		
		if($this->Session->check('reid_user_logged')&&$this->Session->check('reid_user_uid')&&($this->Session->read('reid_user_logged')==1)&&($this->Session->read('reid_user_uid')!=''))
		{
			return $this->redirect(BASE_URL.'userprofile'); 
		}
		
		if ($this->request->is(array('post', 'put')))
		{
			$data_arr=$this->request->data; //picking all the posted data
			$this->set('page_show_type',1);
			
			if($data_arr['page_type']==1)
			{
				if($data_arr['email']==''||!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$data_arr['email']))
				{
					$msg[]='Invalid email id';
					$error_status=1;
				}

				if($error_status == 0)
				{
					$n=$this->User->find('count',array('conditions'=> 'email="'.$data_arr['email'].'"'));
					if($n > 0)
					{
						$user_details=$this->User->find('all', array('conditions' => array('User.email' => $data_arr['email'])));
						
						if(!empty($user_details[0]['User']['facebook_id']))
						{
							$this->Session->setFlash(
								'You are not authorised to use this feature.',
								'default',
								array('class' => 'page_top_error'),
								'update_error'
							);
							
							return $this->redirect(BASE_URL.'forgotpassword');  //if not logged sending to login page
						}
						else
						{
							$already_sent_chk =  $this->ForgotPassReq->find('count', array('conditions' => array('ForgotPassReq.user_id' => $user_details[0]['User']['id'])));
							if($already_sent_chk > 0)
							{
								$already_sent_det =  $this->ForgotPassReq->find('first', array('conditions' => array('ForgotPassReq.user_id' => $user_details[0]['User']['id'])));
								$data_update_chk['ForgotPassReq']['id'] = $already_sent_det['ForgotPassReq']['id'];
								$data_update_chk['ForgotPassReq']['added_date'] = date('Y-m-d');
								$data_update_chk['ForgotPassReq']['status'] = 1;
								$this->ForgotPassReq->save($data_update_chk);
							}
							else
							{
								$data_update_chk['ForgotPassReq']['user_id'] = $user_details[0]['User']['id'];
								$data_update_chk['ForgotPassReq']['added_date'] = date('Y-m-d');
								$data_update_chk['ForgotPassReq']['status'] = 1;
								$this->ForgotPassReq->save($data_update_chk);
							}
							
							$link = BASE_URL.'users/forgotpassword/user:'.base64_encode($user_details[0]['User']['id']);
							
							$user_name = ($user_details[0]['User']['user_type']==1)?$user_details[0]['User']['username']:ucwords($user_details[0]['User']['first_name'].' '.$user_details[0]['User']['last_name']);
							
							$mail_msg="<div style='width:80%;'>
										Hello ".$user_details[0]['User']['username'].",
										<p> Your have requested for password cahnge.</p>
										<p> Please click the bellow link to change your password</p>
										<p> Reset Password : <a href='".$link."'>".$link."</a></p>
									</div>";
							
							$Email = new CakeEmail();
							$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
							$Email->to($data_arr['email']);
							$Email->subject('Request for changing password');
							$Email->emailFormat('html');
							$Email->send($mail_msg);
							
							$this->Session->setFlash(
								'We have send you an email containing a link to change your password.',
								'default',
								array('class' => 'page_top_success'),
								'update_error'
							);
							$this->set('page_show_type1',1);
							//return $this->redirect(BASE_URL.'forgotpassword');  //if not logged sending to login page
						}
					}
					else
					{
						$this->Session->setFlash(
							'We can not find any user associated with this email id. Please try with another email id.',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						
						return $this->redirect(BASE_URL.'forgotpassword');  //if not logged sending to login page
					}
				}
				else
				{
					$this->Session->setFlash(
						implode('<br>', $msg),
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'forgotpassword');  //if not logged sending to login page
				}
			}
			elseif($data_arr['page_type']==2)
			{
				$data['User']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
				$data['User']['password'] = (isset($data_arr['password']))?md5($data_arr['password']):'';
				
				if($this->User->save($data))
				{
					//if($data_arr['user_type'] == 2)
					//{
					//	$data1['Clinicmanager']['id'] = (isset($data_arr['id']))?$data_arr['id']:'';
					//	$data1['Clinicmanager']['clinicmanagers_password']=(isset($data_arr['password']))?md5($data_arr['password']):'';
					//	
					//	$this->Clinicmanager->save($data1);
					//}
					
					$this->Session->setFlash(
						'Password updated successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					$this->set('page_show_type1',1);
				}
				else{
					$this->Session->setFlash(
						'Failed to update password. Please try again..',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
				}
			}
		}
		elseif(isset($this->params->named['user']))
		{
			$user_id = (isset($this->params->named['user']))?$this->params->named['user']:'';
			$n=$this->User->find('count',array('conditions'=> 'id="'.base64_decode($user_id).'"'));
			
			if($n > 0)
			{
				$user_details=$this->User->find('all', array('conditions' => array('User.id' => base64_decode($user_id))));
				
				if($user_details[0]['User']['id'] > 0)
				{
					$already_sent_chk =  $this->ForgotPassReq->find('count', array('conditions' => array('ForgotPassReq.user_id' => $user_details[0]['User']['id'])));
					if($already_sent_chk > 0)
					{
						$already_sent_det =  $this->ForgotPassReq->find('first', array('conditions' => array('ForgotPassReq.user_id' => $user_details[0]['User']['id'])));
						if($already_sent_det['ForgotPassReq']['status']==1)
						{
							$data_update_chk['ForgotPassReq']['id'] = $already_sent_det['ForgotPassReq']['id'];
							$data_update_chk['ForgotPassReq']['status'] = 0;
							$this->ForgotPassReq->save($data_update_chk);
							
							$this->set('user_id',$user_details[0]['User']['id']);
							$this->set('user_type',$user_details[0]['User']['user_type']);
							$this->set('page_show_type',2);
						}
						else
						{
							$this->Session->setFlash(
								'This link is expired or not valid. Please validate your mail id again for a new link.',
								'default',
								array('class' => 'page_top_error'),
								'update_error'
							);
							$this->set('page_show_type1',1);
						}
					}
					else
					{
						$this->Session->setFlash(
							'This link is expired or not valid. Please validate your mail id again for a new link.',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						$this->set('page_show_type1',1);
					}
				}
				else
				{
					$this->Session->setFlash(
						'We can not find your details. Please make sure you click on right link.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					$this->set('page_show_type1',1);
				}
			}
		}
	}
	// End of forgot password function
	
	//Function to add clinic in fontend
	public function addclinicfont()
	{
		$msg=array();
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
			$this->layout='frontend'; //loading  layout
			$user_details=$this->User->find('all', array('conditions' => array('User.id' => $this->Session->read('reid_user_uid'))));
			$this->set('user_details',$user_details);
			
			if ($this->request->is(array('post', 'put')))
			{
				//setting values for view page starts
				$this->set('title_for_layout','Add Clinic Form'); // setting dashboard title
				$this->set('meta_description_content','SeeDoctor.sg'); //content for meta name = Descriptio
				//setting values ends
				
				$this->Clinic->create();
				echo $this->Session->check('reid_user_uid');
				//creating array for save data
				$data_to_be_saved['Clinic']['clinicmanagersid']=$this->request->data('clinicmanagersid');
				$data_to_be_saved['Clinic']['name']=$this->request->data('clinic_name');
				$data_to_be_saved['Clinic']['license']=$this->request->data('license_number');
				$data_to_be_saved['Clinic']['handphone']=$this->request->data('phone_number');
				$data_to_be_saved['Clinic']['url']=$this->request->data('clinic_url');
				$data_to_be_saved['Clinic']['address']=$this->request->data('address');
				
				
				$data_to_be_saved['Clinic']['dateadded']=date('Y-m-d h:i:s');
				$data_to_be_saved['Clinic']['status']=0;
				
				//serverside validation starts
				
				$error_status=0;
				if($data_to_be_saved['Clinic']['name']=='')
				{
					$msg[]='Please enter clinic name';
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
					$msg[]='License number already exists';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['address']=='')
				{
					$msg[]='Please enter clinic address';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['handphone']=='' || strlen($data_to_be_saved['Clinic']['handphone'])!=10 || !preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/', $data_to_be_saved['Clinic']['handphone']))
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
				
				if(strpos($data_to_be_saved['Clinic']['handphone'], '65', 1))
					$data_to_be_saved['Clinic']['handphone']=$data_to_be_saved['Clinic']['handphone'];
				else
					$data_to_be_saved['Clinic']['handphone']='65'.$data_to_be_saved['Clinic']['handphone'];
				
				//echo '<pre>'; pr($msg); echo '</pre>'.$error_status;die;
				
				if($error_status==0)
				{
					if ($this->Clinic->save($data_to_be_saved))
					{
						$dataclinicmanager=$this->User->findById($data_to_be_saved['Clinic']['clinicmanagersid']);
						
						$mail_msg="<div style='width:80%;'>Hello ".$dataclinicmanager['User']['first_name']." ".$dataclinicmanager['User']['last_name'].",<p>Your clinic bearing the name <b>".$data_to_be_saved['Clinic']['name']."</b> is created and approved by the admin.You can now manage the details from your manage clinic section. </p><p>Thanks &regards,<br/>SeeDoctor.sg Team</p></div>";
						$Email = new CakeEmail();
						
						$Email->from(array('ayan.unified@gmail.com' => 'SeeDoctor.sg'));
						$Email->to($dataclinicmanager['User']['email']);
						$Email->subject('SeeDoctor.sg Notifications: Clinic Created And Approved ');
						$Email->emailFormat('html');
						$Email->send($mail_msg);
						
						$this->Session->setFlash(
							'Clinic added successfully, wait for admin approval for further process.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
						
						return $this->redirect(BASE_URL.'clinics/clintlist');
					}
					else
					{
						$this->Session->setFlash(
							'Sorry! failed to add clinic. Please try again',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						//return $this->redirect(BASE_URL.'clinics/clintlist');	
					}
				}
				else
				{
					$this->Session->setFlash(
						implode('<br>', $msg),
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
				}
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
	//End of add clinic function //
	
	
	
	//Start of edit function of clinics//
	public function clinic_settings()
	{
		$msg=array();
		
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
			if(!$this->request->data)
				$clinic_id  = (isset($this->params->named['id']))?$this->params->named['id']:'0';
			else
				$clinic_id  = $this->request->data('clinic_id');
			
			$this->layout='frontend'; //loading  layout
			$user_details=$this->User->find('all', array('conditions' => array('User.id' => $this->Session->read('reid_user_uid'))));
			
			$clinic_check = $this->Clinic->find('count', array('conditions' => array('Clinic.id' => $clinic_id)));
			if($clinic_check ==0)
			{
				return $this->redirect(BASE_URL.'clinics/clintlist');	
			}
			
			$clinic_detils=$this->Clinic->find('all', array('conditions' => array('Clinic.id' => $clinic_id)));
			
			if(!empty($clinic_detils) && (!$this->request->data)){
				$this->request->data = $clinic_detils[0]['Clinic'];
			}
			
			//setting values for view page starts
			//$this->set('ckeditor_ids',array('address','about')); //if ckeditor exists in forms sending their ids
			$this->set('user_details',$user_details);
			$this->set('title_for_layout','Add Clinic Form'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg'); //content for meta name = Descriptio
			$this->set('all_owners',$this->User->find('all',array('conditions'=>'status=1')));
			$this->set('all_insurances',$this->Insurance->find('all',array('conditions'=>'insurances_status=1')));
			$this->set('all_base_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_status=1 and specialities_parent_id=1')));
			
			if(!empty($clinic_detils[0]['Clinic']['type'])){
				$this->set('all_sub_specialities',$this->Speciality->find('all',array('conditions'=>'specialities_status=1 and specialities_parent_id='.$clinic_detils[0]['Clinic']['type'].' and specialities_parent_id!=0')));
			}
			else{
				$this->set('all_sub_specialities', '');
			}
			
			
			$this->set('all_eligibility',$this->Eligibilitie->find('all',array('conditions'=>'status=1')));
			$current_eligibility = $this->Eligibilitieclinc->find('all',array('conditions'=>'clinc_id='.$clinic_id));
			$this->set('current_eligibility',$current_eligibility);
			
			//getting the insurances of this clinic presently stored in the database
			$current_insurances=$this->Insurancetoclinic->find('all',array('conditions'=>'clinicid="'.$clinic_id.'"'));
			$this->set('current_insurances',$current_insurances);
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				$clinic_id = $this->request->data('clinic_id');
				
				$this->Clinic->create();
				
				//creating array for save data
				$data_to_be_saved['Clinic']['id']=$clinic_id;
				$data_to_be_saved['Clinic']['clinicmanagersid']=$this->request->data('clinicmanagersid');
				
				$data_to_be_saved['Clinic']['name']=$this->request->data('clinic_name');
				$data_to_be_saved['Clinic']['license']=$this->request->data('license');
				$data_to_be_saved['Clinic']['handphone']=$this->request->data('handphone');
				$data_to_be_saved['Clinic']['url']=$this->request->data('url');
				$data_to_be_saved['Clinic']['address']=$this->request->data('address');
				$data_to_be_saved['Clinic']['type']=$this->request->data('type');
				$data_to_be_saved['Clinic']['subtype']=$this->request->data('subtype');
				$data_to_be_saved['Clinic']['about']=$this->request->data('about');
				$data_to_be_saved['Clinic']['waitingtime']=$this->request->data('waitingtime');
				$data_to_be_saved['Clinic']['tags']=$this->request->data('tags');
				
				$data_to_be_saved['Clinic']['displaywaiting']=isset($this->request->data['displaywaiting'])?$this->request->data('displaywaiting'):0;
				$data_to_be_saved['Clinic']['allowpost']=isset($this->request->data['allowpost'])?$this->request->data('allowpost'):0;
				$data_to_be_saved['Clinic']['lockwall']=isset($this->request->data['lockwall'])?$this->request->data['lockwall']:0;
				
				//$data_to_be_saved['Clinic']['logo']=$this->request->data('fileInput');
				
				$data_to_be_saved['Clinic']['status']=1;
				
				//serverside validation starts
				
				$error_status=0;
				if($data_to_be_saved['Clinic']['name']=='')
				{
					$msg[]='Please enter clinic name';
					$error_status=1;
				}
				if($data_to_be_saved['Clinic']['clinicmanagersid']=='')
				{
					$msg[]='Clinc manager not found';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['license']=='')
				{
					$msg[]='Please enter license';
					$error_status=1;
				}
				
				//checking if license exists
				$n=$this->Clinic->find('count',array('conditions'=> array('license="'.$data_to_be_saved['Clinic']['license'].'"', 'NOT' => array('id' => $clinic_id))));
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
				
				if($data_to_be_saved['Clinic']['handphone']=='' || strlen($data_to_be_saved['Clinic']['handphone'])!=10||!preg_match('/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/', $data_to_be_saved['Clinic']['handphone']))
				{
					$msg[]='Invalid phone number';
					$error_status=1;
				}
				
				if($data_to_be_saved['Clinic']['url']==''||!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data_to_be_saved['Clinic']['url']))
				{
					$msg[]='Invalid clinic url';
					$error_status=1;
				}
				
				//checking if url exists
				$n=$this->Clinic->find('count',array('conditions'=> array('url="'.$data_to_be_saved['Clinic']['url'].'"', 'NOT' => array('id' => $clinic_id))));
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
				
				if($_FILES['fileInput']['name'] !='' )
				{
					$portitions_arr=explode('.',$_FILES['fileInput']['name']);
					$n=count($portitions_arr);
					$extension=$portitions_arr[$n-1];
					
					if($extension=='jpg'|| $extension=='JPG'||$extension=='JPEG'||$extension=='jpeg'||$extension=='PNG'||$extension=='png'||$extension=='gif'||$extension=='GIF'||$extension=='ico'||$extension=='ICO')
					{
						
					}
					else
					{
						$msg[]='Please upload logo image with (jpg or jpeg or png or gif or ico) extensions only.';
						$error_status=1;
					}
					
					if($_FILES['fileInput']['size']>2*1024*1024)
					{
						$msg[]='Maximum upload limit of logo image is 2MB.';
						$error_status=1;	
					}
				}
				
				//serverside validation ends
				
				if(mb_strpos($data_to_be_saved['Clinic']['handphone'], '65', 1)==1){
					if(strlen($data_to_be_saved['Clinic']['handphone'])==10){
						$data_to_be_saved['Clinic']['handphone']='65'.$this->request->data('handphone');
					}
					else{
						$data_to_be_saved['Clinic']['handphone']=$this->request->data('handphone');
					}
				}
				else{
					$data_to_be_saved['Clinic']['handphone']='65'.$this->request->data('handphone');
				}
				
				//echo '<pre>'; pr($data_to_be_saved); die;
				
				if($error_status==0)
				{
					$current_insurances=$this->Insurancetoclinic->find('all',array('conditions'=>'clinicid="'.$clinic_id.'"','order' => array('id' => 'DESC')));
					if ($this->Clinic->save($data_to_be_saved))
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
							$data_to_be_saved2['Insurancetoclinic']['insuranceid']=$v;
							$data_to_be_saved2['Insurancetoclinic']['clinicid']=$clinic_id;
							$this->Insurancetoclinic->save($data_to_be_saved2);
						
						}
						
						//deleting them from database
						foreach($current_eligibility as $v)
						{
							$this->Eligibilitieclinc->delete($v['Eligibilitieclinc']['id']);
						}
						
						//inserting the selected insurances
						foreach($this->request->data['eligibilities'] as $v)
						{
							$this->Eligibilitieclinc->create();
							$data_to_be_saved2['Eligibilitieclinc']['eligibiliti_id']=$v;
							$data_to_be_saved2['Eligibilitieclinc']['clinc_id']=$clinic_id;
							$this->Eligibilitieclinc->save($data_to_be_saved2);
						}
						
						//upload logo image
						if($_FILES['fileInput']['name']!='')
						{
							$last_image=$this->Clinic->find('first', array('fields' => array('logo'), 'conditions' => array('Clinic.id' => $clinic_id)));
							if($last_image['Clinic']['logo'])
							{
								$img_path = "./admin/uploads/".$last_image['Clinic']['logo'];
								$img_path_thumb = "./admin/uploads/thumb/".$last_image['Clinic']['logo'];
								@unlink($img_path); @unlink($img_path_thumb);
							}
							
							$filename=$_FILES['fileInput']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['fileInput']['tmp_name'];
							$filename=rand(100,999).time().$clinic_id.'.'.$ext;
							$folder="./admin/uploads/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry! failed to upload image. Please try again.';
								$error_status=1;
							}
							else
							{
								$data_to_be_saved1['Clinic']['id']=$clinic_id;
								$data_to_be_saved1['Clinic']['logo']=$filename;
								$this->Clinic->save($data_to_be_saved1);
								
								$target_path = "./admin/uploads/thumb/".$filename;
								$source_path = $path;
								$this->Sitesetting->thumbnail($target_path, $source_path, 350, 350, '');
							}
						}
						
						//$dataclinicmanager=$this->Clinicmanager->findById($data_to_be_saved['Clinic']['clinicmanagersid']);
						
						$this->Session->setFlash(
							'Clinic details updated successfully.',
							'default',
							array('class' => 'page_top_success'),
							'update_error'
						);
						
						return $this->redirect(BASE_URL.'clinics/clintlist');
					}
					else
					{
						$this->Session->setFlash(
							'Sorry! failed to update clinic. Please try again',
							'default',
							array('class' => 'page_top_error'),
							'update_error'
						);
						return $this->redirect(BASE_URL.'clinics/clintlist/id:'.$clinic_id);	
					}
				}
				else
				{
					$this->Session->setFlash(
						implode('<br>', $msg),
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'clinics/clintlist/id:'.$clinic_id);
				}
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
			return $this->redirect(BASE_URL.'users/clinic_settings/id:'.$clinic_id);  //if not logged sending to login page
		}
	}
	//End of edit clinic function//
	
	
	//Start of delete clinic function//
	public function clinic_delete()
	{
		$msg=array();
		if($this->Session->check('reid_user_logged') && $this->Session->check('reid_user_uid') && ($this->Session->read('reid_user_logged')==1) && ($this->Session->read('reid_user_uid')!=''))
		{
			$n=$this->Clinic->find('count',array('conditions'=> array('clinicmanagersid="'.$this->Session->read('reid_user_uid').'"')));
			if($n > 0)
			{
				$clinic_id = $this->params->named['id'];
				
				//deleting clinic image from database
				$last_image=$this->Clinic->find('first', array('fields' => array('logo'), 'conditions' => array('Clinic.id' => $clinic_id)));
				if(!empty($last_image))
				{
					if($last_image['Clinic']['logo']){
						$img_path = "./admin/uploads/".$last_image['Clinic']['logo'];
						@unlink($img_path);
					}
				}
				
				$current_insurances=$this->Insurancetoclinic->find('all',array('conditions'=>'clinicid="'.$clinic_id.'"'));
				if(!empty($current_insurances))
				{
					//deleting clinic insurences from database
					foreach($current_insurances as $v)
					{
						$this->Insurancetoclinic->delete($v['Insurancetoclinic']['id']);
					}
				}
				
				//deleting clinic from database
				if($this->Clinic->delete($clinic_id)){
					$this->Session->setFlash(
						'Clinic deleted successfully.',
						'default',
						array('class' => 'page_top_success'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'clinics/clintlist'); 
				}
				else{
					$this->Session->setFlash(
						'Failed to delete clinic. Please try again.',
						'default',
						array('class' => 'page_top_error'),
						'update_error'
					);
					
					return $this->redirect(BASE_URL.'clinics/clintlist');  //if not logged sending to login page
				}
			}
			else
			{
				$this->Session->setFlash(
					'You are not authorised to perform this action.',
					'default',
					array('class' => 'page_top_error'),
					'update_error'
				);
				return $this->redirect(BASE_URL.'users/clinic_settings/id:'.$clinic_id);  //if not logged sending to login page
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
			return $this->redirect(BASE_URL.'users/clinic_settings/id:'.$clinic_id);  //if not logged sending to login page
		}
	}
	
	
	/*-------Search--------*/
	
	//function search()
	//{
	//	echo "hello";
	//	echo $this->params;
	//}
}
?>
