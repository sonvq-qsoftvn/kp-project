<?php
App::uses('CakeEmail', 'Network/Email');
class AdminsController extends AppController
{
	public $helpers = array('Html', 'Form'); //loading necessary helpers
	public $components=array('Session','Cookie'); //loading necessary components
	public $uses=array('Admin','User','Clinicmanager','Clinic','Featurein');//models used
		
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		//no cache code starts
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		//no cache code ends
	}
	

	
	//function for going to login page
	
	public function index() 
	{
		$msg='';
		$data_arr=$this->params->query;
		if($this->Session->check('status'))
		{
			if($this->Session->read('status')=='Invalid')
			{
				$msg='Invalid USername Or Password';
			}
			
			$this->Session->delete('msg');
		}
			
		
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{

			return $this->redirect(BASE_URL.'administrator/dashboard'); //if already logged in send to dashboard
		}
		else
		{
			$this->layout='admin_login'; //loading the login page layout
			
			$this->set('title_for_layout','Login'); //defining the login page title
			
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
			//setting cookie for 1 year if remember me is on
			
			if($this->Cookie->check('reid_admin_username'))
			{
				$username=$this->Cookie->read('reid_admin_username');
				
			}
			else
			{
				$username='';
			}
			if($this->Cookie->check('reid_admin_password'))
			{
				$password=$this->Cookie->read('reid_admin_password');
			}
			else
			{
				$password='';
			}
			
			//setting cookie ends
			
			$token=rand(1000,9999).time(); //creating random login token for authentication
			$this->Session->write('login_token',$token); // setting the login token in session
			
			//sending values to the page
			
			$this->set('login_token',$token); 
			$this->set('reid_admin_username',$username);
			$this->set('reid_admin_password',$password);
			if($this->Cookie->check('reid_admin_username')&&$this->Cookie->check('reid_admin_password'))
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
	
	//login authentication
	
	public function logincheck()
	{
		$data_arr=array();
		
		$data_arr=$this->request->data; //picking all the requested data
		
		//checking whether the post call is made, the submit button is the login button and the authentication token is valid
		
		if($_SERVER['REQUEST_METHOD'] === 'POST'&&$this->Session->read('login_token')==$data_arr['token']&&$data_arr['login_submit']=='Login')
		{
			//if remember me is on setting username and password in cookie
			
			if($data_arr['remember_me']=='on')
			{
				
				if($this->Cookie->check('reid_admin_username'))
				{
					$this->Cookie->delete('reid_admin_username');
				
				}
				
				$this->Cookie->write('reid_admin_username',$data_arr['username'],false,31536000);
				
				if($this->Cookie->check('reid_admin_password'))
				{
					$this->Cookie->delete('reid_admin_password');
				}
				
				$this->Cookie->write('reid_admin_password',$data_arr['password'],false,31536000);
				
				
			}
			
			
			$this->Session->delete('login_token'); //destroying authentication token
			
			
			$u=$data_arr['username'];
			$p=md5($data_arr['password']); //hashing the password
			
			$n_user = $this->Admin->find('count', array('conditions' => array('Admin.username' => $u,'Admin.password'=>$p)));
			if($n_user==1)
			{
				$user_details=$this->Admin->find('all', array('conditions' => array('Admin.username' => $u,'Admin.password'=>$p)));
				$uid=$user_details[0]['Admin']['id'];
				$role=$user_details[0]['Admin']['role'];
				$this->Session->write('reid_admin_logged',1);
				$this->Session->write('reid_admin_uid',$uid);
				$this->Session->write('reid_admin_urole',$role);
				$this->Admin->save(array('id'=>$uid,'last_login'=>date('Y-m-d h:i:s')));
				return $this->redirect(BASE_URL.'administrator/dashboard');
			}
			else
			{
				$this->Session->write('status','Invalid');	
				return $this->redirect(BASE_URL.'administrator');

			}
		}
		else
		{
			$this->Session->delete('login_token'); //destroying authentication token	
			
			return $this->redirect(BASE_URL.'administrator');
		}
		
	}
	public function dashboard()
	{
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			$this->set('title_for_layout','Dashboard'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','dashboard'); //identifier of selected menu item in left menu
			
			//total no. of users
			
			$tnru=$this->User->find('count',array('conditions'=>array('status'=>'1','user_type'=>'1')));
			$this->set('tnru',$tnru);
			
			//total no. of clinic owners
			
			$tnco=$this->User->find('count',array('conditions'=>array('status'=>'1','user_type'=>'2')));
			$this->set('tnco',$tnco);
			
			
			//total no. of approved clinics
			
			$tnac=$this->Clinic->find('count',array('conditions'=>'status=1'));
			$this->set('tnac',$tnac);
			
			
			//total no. of disapproved/pending clinics
			
			$tndac=$this->Clinic->find('count',array('conditions'=>'status=0'));
			$this->set('tndac',$tndac);
			
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	public function logout()
	{
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->Session->delete('reid_admin_logged');
			$this->Session->delete('reid_admin_uid');
			$this->Session->delete('reid_admin_urole');
			return $this->redirect(BASE_URL.'administrator');
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
	}
	//Admin settings : change password
	public function changepassword()
	{
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			if($this->Session->check('message'))
			{
				$message=$this->Session->read('message'); //picking up the msg
				$this->Session->delete('message');
			}
			else
			{
				$message='';
			}
			$this->set('message',$message);
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Change Password'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','dashboard');
			$this->set('isformpage',1);
			
			if($this->request->is(array('post', 'put')))
			{
				$admin = $this->Admin->findById($this->Session->read('reid_admin_uid'));
				$oldpass=$this->request->data['oldpass'];
				$newpass=$this->request->data['newpass'];
				$connewpass=$this->request->data['connewpass'];
				
				//regex definitions
				$smallletter = "/[a-z]/";
				$capsletter="/[A-Z]/";
				$number = "/[0-9]/";
				
				//server side validation starts
				$error_status=0;
				if($oldpass==''||md5($oldpass)!=$admin['Admin']['password']||strlen($oldpass)<8||!(preg_match($smallletter,$oldpass)&&preg_match($capsletter,$oldpass)&&preg_match($number,$oldpass)))
				{
					$msg[]='Invalid old password';
					$error_status=1;
				}
				if($newpass==''||strlen($newpass)<8||!(preg_match($smallletter,$newpass)&&preg_match($capsletter,$newpass)&&preg_match($number,$newpass)))
				{
					$msg[]='New password must be atleast 8 characters long and must contain atleast one small letter, capital letter and a number';
					$error_status=1;
				}
				if($newpass!=$connewpass)
				{
					$msg[]='Confirm password doesnot match with new password';
					$error_status=1;	
				}
				if($error_status==0)
				{
					$save_arr['Admin']=array('id'=>$this->Session->read('reid_admin_uid'),'password'=>md5($newpass),'modified'=>date('Y-m-d h:i:s'));
					
				
				
					if ($this->Admin->save($save_arr))
					{
						$this->Session->write('message','changesuccess');	
						return $this->redirect(BASE_URL.'administrator/changepassword');
					}
					$this->Session->write('message','changefailure');
					return $this->redirect(BASE_URL.'administrator/changepassword');
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
	
	//======================================FORGOT PASSWORD====================================================================

	
	public function forgotpassword()
	{
		$this->layout='clinicowner_password'; //loading the login page layout
	
		$this->set('title_for_layout','Forgot Password'); //defining the login page title
		$this->set('meta_description_content','SeeDoctor.sg Manager Panel'); //content for meta name = Description
		$this->set('msg','');
		
		if($this->Session->check('message'))
		{
			$this->set('msg',$this->Session->read('message'));
			$this->Session->delete('message');
		}
		
		if($this->request->is(array('post', 'put'))  && !empty($this->request->data))
		{ 
			//===========================fetch value according to given Email_id===============================================
			$user_email_id=$this->request->data['email'];
			$owner_name=$this->request->data['username'];
			
			$owner = $this->Admin->find("count",array('conditions' => array('admin_email' =>$user_email_id , 'username'=>$owner_name)));
		
			if($owner=='1')
			{
				$owner_details=$this->Admin->find("all",array('conditions' => array('admin_email' =>$user_email_id , 'username'=>$owner_name)));
			
				//=======================make randam password=============================================
				$rand_pass=$this->generate_password(8);
				$md5_rand_pass=md5($rand_pass); //==make md5 randam pass==
				
				//======================Update Rand Password=========================================
				$this->Admin->id = $owner_details[0]['Admin']['id'];
				if($this->Admin->saveField('password',$md5_rand_pass))
				{
					//======================END Update Rand Password=======================================
					
					echo $mail_msg='<div style="float: left; margin-bottom: 12px; padding:0 0 10px 10px; font: 14px/20px Arial,Helvetica,sans-serif; background: none repeat scroll 0 0 linen; border-bottom:solid 1px #ccc;">
									<p style="">
									    Hello &nbsp;<a href="#" style="">Super admin</a>
									    
									</p>
				
									<p style="font: 12px/18px Arial,Helvetica,sans-serif; margin-top: 0px; margin: 14px 0; padding-right:10px; width:430px;">
									    Your SeeDoctor.sg Password is &nbsp;'.$rand_pass.' 
									</p>
									
									<div style="color: #555; width:98%;">
										&copy; 2014 SeeDoctor.sg... All Rights Reserved.
									</div> 
					
								</div>';
					//exit;
				
					$Email = new CakeEmail();
					$Email->from('arijit.modak.unified@gmail.com');
					$Email->to($owner_details[0]['Admin']['admin_email']);
					//$Email->to('arijit.modak.unified@gmail.com');
					$Email->subject('SeeDoctor.sg Forgot Password');
					$Email->emailFormat('html');
					$Email->send($mail_msg);
					
					//==================create Success msg=============================
					$msg="Your password is now successfully reset and your new password is sent to your email id";
					$this->Session->write('message',$msg);
					
					return $this->redirect(BASE_URL.'admins/forgotpassword');
				}
				else
				{
					//==================create failure msg=============================
					$msg="Please try again";
					$this->Session->write('message',$msg);
					
					return $this->redirect(BASE_URL.'admins/forgotpassword?message=servererror');
				}     
			}
			else
			{
				//==================create failure msg=============================
				$msg="Wrong User Name or Email Id";
				$this->Session->write('message',$msg);
				
				return $this->redirect(BASE_URL.'admins/forgotpassword');
			}
		}
	}

	//======================================END FORGOT PASSWORD==============================================================
	
	//======================================Randam Password Generator==================================================
	function generate_password($length)
	{
		$chars_small = "abcdefghijklmnopqrstuvwxyz";
		$chars_big="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$int_val="0123456789";
		$special_car="!@#$%^&*/><~";
	
		$rand_chars_small	=substr( str_shuffle( $chars_small ), 0, 2 );
		$rand_chars_big		=substr( str_shuffle( $chars_big ), 0, 2 );
		$rand_int_val		=substr( str_shuffle( $int_val ), 0, 2 );
		$rand_special_car	=substr( str_shuffle( $special_car ), 0, 2 );

		$final_rand_val=$rand_chars_small.$rand_chars_big.$rand_int_val.$rand_special_car;

		$password = substr(str_shuffle( $final_rand_val ), 0, $length );
		return $password;
	
	}	
	
	
	
	
	
}
?>