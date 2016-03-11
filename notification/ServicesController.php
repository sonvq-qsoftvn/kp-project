<?php
/**
 * Web Service controller.
 *
 * @package       app.Controller
 * @author         
 * @company       Unified Infotech Pvt Ltd
 */
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'Braintree', array('file' => 'braintree' . DS . 'lib' . DS . 'Braintree.php'));
//require_once 'lib/Braintree.php';

class ServicesController extends AppController {
    
    var $name = 'Services';
    var $uses=array('Sitesetting','User','DeviceTable','University','Subject','SubjectCode','UserToUniversity','TutorCourse','TutorDegree','SubjectProfessor','Grade','HomeState','Degree','DegreeSubject','School','Transaction','StudentProfile','MerchantAccountDetails','HomeState','Year','Major','StudentTutorRelation','TutorRating','CourseRating');
   
    
    public $components=array('Session','Cookie','Paginator','Upload','CommonFunction','Qimage'); //loading necessary components
//before filter function
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->autoRender=false;
        $this->layout="";       
        $settings_datas = $this->Sitesetting->find('all');
		//pr($settings_datas);exit;
		foreach($settings_datas as $settings_data)
		{
			$this->set($settings_data['Sitesetting']['field_name'], $settings_data['Sitesetting']['field_value']);
			define($settings_data['Sitesetting']['field_name'], $settings_data['Sitesetting']['field_value']);
		
		}
		
		
	}
        
  
function appify_a_result_array($arr,$mod,$concat_befores=array(),$concat_afters=array(),$remove_index=array(),$image_check=array(),$concat_before=array())

    {
	
	
    $result=array();
    foreach($arr as $k=>$v)
    {
        
        $result[$k]=$v[$mod];
        if(!empty($remove_index))
        {
        foreach($remove_index as $r_i=>$r_v)
        {
            unset($result[$k][$r_v]);
        }
        }
        
          
        
        if(!empty($concat_befores))
        {
        foreach($concat_befores as $i=>$i_v)
        {
	    
	    
            $result[$k][$i]=$i_v.$result[$k][$i];
	    
	    
        }
        }
        if(!empty($concat_afters))
        {
        foreach($concat_afters as $i=>$i_v)
        {
            $result[$k][$i]=$result[$k][$i].$i_v;
        }
        }
        if(!empty($image_check))
        {
        foreach($image_check as $r_i=>$r_v)
        {
            if(isset($result[$k][$r_i]))
            {
            if($result[$k][$r_i] == $concat_befores[$r_i])
            {
                $result[$k][$r_i]=$r_v;
            }
            }
        
        }
        }
        if(!empty($image_check))
        {
        foreach($image_check as $r_i=>$r_v)
        {
            if(isset($result[$k][$r_i]))
            {
		
            $tmp_res_arr=explode(BASE_URL,$result[$k][$r_i]);
            if(!file_exists('./'.$tmp_res_arr[1]))
            {
                $result[$k][$r_i]=$r_v;
            }
            }
        
        }
        }
        if(!empty($concat_before))
        {
        foreach($concat_before as $i=>$i_v)
        {
            $result[$k][$i]=$i_v.$result[$k][$i];
        }
        }

    }
    return $result;
    }



/********************Module 1*********************/

/***********Registration/Login/Activation For Tutor Start**************/
        public function tutorRegistration()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                
              
                    $first_name = isset($this->request->data['first_name'])?trim($this->request->data['first_name']):"";
                    $last_name = isset($this->request->data['last_name'])?trim($this->request->data['last_name']):"";
                    $email = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                    
                    $charge_per_hour = isset($this->request->data['charge_per_hour'])?($this->request->data['charge_per_hour']):"";
                    $password = isset($this->request->data['password'])?($this->request->data['password']):"";
                  
                    $device_id = isset($this->request->data['device_id'])?($this->request->data['device_id']):"";
                    $user_type= isset($this->request->data['user_type'])?($this->request->data['user_type']):"";
                    $university_id= isset($this->request->data['university_id'])?($this->request->data['university_id']):"";


                    $error_status=0;
                   
                    
                    /* Null Field Checking Start */
                    if($first_name =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Firstname required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    else if($last_name =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Lastname required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    else if($email =='')
                    {
                        
                        $json_msg = array('status'=>0,'msg'=>'Email Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    else if($charge_per_hour =='')
                    { 
                        $json_msg = array('status'=>0,'msg'=>'Charge Per Hour required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($password =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Password required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    /*For user end*/
                    if(isset($email) && isset($user_type))
                    { 
                        //echo $user_type;
                        $n_user_email = $this->User->find('count', array('conditions' => array('User.user_type'=>$user_type,'User.email_id' => $email)));

                      // pr($this->User->getDataSource()->getLog(TRUE));exit();
                                if($n_user_email > 0)
                                {
                                    $json_msg = array('status'=>0,'msg'=>'This email address has already been registered as a tutor.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
                    }

                   
                    /* Null Field Checking End */
                    
                    if($error_status==0)
                    {
                        $email_validate_code = rand(0,9999999);


                        $data_to_be_saved['User']['first_name'] = $first_name;
                        $data_to_be_saved['User']['last_name'] = $last_name;
                        $data_to_be_saved['User']['email_id'] = $email;
                        $data_to_be_saved['User']['email_v_code'] = $email_validate_code;
                        $data_to_be_saved['User']['user_type'] = $user_type;
                        $data_to_be_saved['User']['charge_per_hour'] = $charge_per_hour;
                        $data_to_be_saved['User']['password'] = md5($password);
                        $data_to_be_saved['User']['raw_password'] = $password;
                        $data_to_be_saved['User']['status'] = 0;
                        $data_to_be_saved['User']['admin_status'] = 1;
                       
                        $data_to_be_saved['User']['created'] = date('Y-m-d h:i:s');
                        $data_to_be_saved['User']['modified'] = date('Y-m-d h:i:s');
                        
                        if ($this->User->save($data_to_be_saved))
                        {
                            $last_id = $this->User->getLastInsertId();

                            $data_to_be_saved1['DeviceTable']['user_id'] = $last_id;
                            $data_to_be_saved1['DeviceTable']['device_id'] = $device_id;
                            $data_to_be_saved1['DeviceTable']['status'] = 0;
                            $data_to_be_saved1['DeviceTable']['created'] = date('Y-m-d h:i:s');
                            $data_to_be_saved1['DeviceTable']['modified'] = date('Y-m-d h:i:s');

                            if ($this->DeviceTable->save($data_to_be_saved1))
                            {
                                $last_id = $this->User->getLastInsertId();

                                $data_to_be_saved2['UserToUniversity']['user_id'] = $last_id;
                                $data_to_be_saved2['UserToUniversity']['university_id'] = $university_id;
                                $data_to_be_saved2['UserToUniversity']['tutorat_university'] = $university_id;
                                $data_to_be_saved2['UserToUniversity']['created'] = date('Y-m-d h:i:s');
                                $data_to_be_saved2['UserToUniversity']['modified'] = date('Y-m-d h:i:s');

                                if ($this->UserToUniversity->save($data_to_be_saved2)) 
                                {
				    $send_arr = array($email_validate_code,$email,$user_type,$data_to_be_saved['User']['first_name'],$data_to_be_saved['User']['email_id'],$password);
				    $param = implode("@@",$send_arr);
				    $cmd = "wget -bq --spider ".BASE_URL."services/teacher_mail?parameter=".$param;
				    shell_exec(escapeshellcmd($cmd));
				    //@mail('sumitra.unified@gmail.com','after Shellexec','param= '.$param);
				    
				    
                                   //$activation_link = BASE_URL."/activateTutor?rand_id=".base64_encode($email_validate_code)."&email_id=".base64_encode($email)."&user_type=".base64_encode($user_type);
                                   //
                                   // $mail_msg="<div style='width:80%;'>Hello ".ucfirst($data_to_be_saved['User']['first_name']).",
                                   // <br/>
                                   // <table>
                                   // <tr><td>Please complete your registration now by clicking on the link below or copying it into your browser.</td></tr>
                                   // <tr><td><a href='".$activation_link."'>".$activation_link."</a></td></tr>
                                   // <br/><br/>
                                   // <tr><td>Your login details:</td></tr>
                                   // 
                                   // <tr><td>Email &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$data_to_be_saved['User']['email_id']."</td></tr>
                                   // <tr><td>Password &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$password."</td></tr>
                                   // <br/>
                                   // <tr><td>Please contact us at ......... if you require any further assistance.</td></tr>
                                   // <br/>
                                   // <tr><td>Warmest Regards,</td></tr>
                                   // <tr><td>TutorApp Team</td></tr>
                                   // 
                                   // </table></p></div>";
                                   // 
                                   // $Email = new CakeEmail();
                                   // 
                                   // $Email->from(array(site_mail_id => 'TutorApp'));
                                   // $Email->to($data_to_be_saved['User']['email_id']);
                                   // $Email->subject('TutorApp Account Verification');
                                   // $Email->emailFormat('html');
                                   // $Email->send($mail_msg);
                                    //@mail('sumitra.unified@gmail.com','user Activation'.$data_to_be_saved['User']['email'],'mailmsg= '.$mail_msg);
                                    //echo "<script>alert('Registration completed. Please check your email for further instructions....');</scrip>";
                                    
                                    $msg = "Registration successful. Welcome to ";
                                    $this->set('msg',$msg);
                                    $json_msg = array('status'=>1,'msg'=>'Thanks for registering your profile as a tutor! Please confirm your email to fully activate your account.')  ;
                                    echo json_encode($json_msg);
                                    exit; 
                                }
                                else
                                {
                                    $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                    echo json_encode($json_msg);
                                    exit;   
                                }
                                
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                        echo json_encode($json_msg);
                        exit;
                    }
                    
            }
        }

// +++++++++++++++++++++++++++++++++++++++++++ Mail Send Teacher Amit +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function teacher_mail()
	{
	   $send_arr = $_REQUEST['parameter'];
	   $all_data = explode("@@",$send_arr);
	   
	   $email_validate_code = $all_data[0];
	   $email 		= $all_data[1];
	   $user_type 		= $all_data[2];
	   $first_name 		= $all_data[3];
	   $email_id 		= $all_data[4];
	   $password 		= $all_data[5];
	   
	   //@mail('sumitra.unified@gmail.com','teacher_mail_call','all_data= '.$all_data);
	    $activation_link = BASE_URL."activateTutor?rand_id=".base64_encode($email_validate_code)."&email_id=".base64_encode($email)."&user_type=".base64_encode($user_type);
                                
	    $mail_msg="<div style='width:80%;'>Hello ".ucfirst($first_name).",
	    <br/>
	    <table>
	    <tr><td>Please complete your registration now by clicking on the link below or copying it into your browser.</td></tr>
	    <tr><td><a href='".$activation_link."'>".$activation_link."</a></td></tr>
	    <br/><br/>
	    <tr><td>Your login details:</td></tr>
	    
	    <tr><td>Email &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$email_id."</td></tr>
	    <tr><td>Password &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$password."</td></tr>
	    <br/>
	    <tr><td>Please contact us at ......... if you require any further assistance.</td></tr>
	    <br/>
	    <tr><td>Warmest Regards,</td></tr>
	    <tr><td>TutorApp Team</td></tr>
	    
	    </table></p></div>";
	    
	    $Email = new CakeEmail();
	    
	    $Email->from(array(site_mail_id => 'TutorApp'));
	    $Email->to($email_id);//$data_to_be_saved['User']['email_id']
	    $Email->subject('TutorApp Account Verification');
	    $Email->emailFormat('html');
	    $Email->send($mail_msg);
	    //@mail('sumitra.unified@gmail.com','last','mailmsg= '.$mail_msg);
	}
	
// +++++++++++++++++++++++++++++++++++++++++++ Mail Send Amit +++++++++++++++++++++++++++++++++++++++++++++++++++++++++


        public function activateTutor()
        {
            //pr($this->params['url']);exit();
            if($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                $rand_id=base64_decode($this->params['url']['rand_id']);
                //
                $email_id=base64_decode($this->params['url']['email_id']);
                $user_type=base64_decode($this->params['url']['user_type']);
                //echo $email_id;exit();
                $error_status=0;
                if(isset($email_id) && isset($rand_id) && isset($user_type))
                {

                    $n_user_email = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type)));
                    

                    if($n_user_email=0)
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid email ID')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    else
                    {
                        $this_user=$this->User->find('first', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type)));
                        if($this_user['User']['email_v_code']!=$rand_id)
                        {
                             //$json_msg = array('status'=>0,'msg'=>'Account already activated')  ;
                             //echo json_encode($json_msg);
                            echo "Account already activated";
                             //$error_status=1;
                             exit;
                        }
                        elseif($this_user['User']['email_v_code']==0)
                        {
                            //$json_msg = array('status'=>0,'msg'=>'Account already activated')  ;
                            //echo json_encode($json_msg);
                            echo "Account already activated";
                           // $error_status=1;
                            exit;
                        }
                    }

                        if($error_status==0)
                        {
                            $data_to_be_saved=array('User.email_v_code'=>0,'User.status'=>1,'User.modified'=>'"'.date('Y-m-d h:i:s').'"'); 
                            if ($this->User->updateAll($data_to_be_saved,array('User.email_id'=>$email_id,'User.user_type'=>$user_type)))
                                
                            {
                                //$json_msg = array('status'=>1,'msg'=>'Account Activated Successfully')  ;
                                //echo json_encode($json_msg);
                                echo "Account Activated Successfully";
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            }

                        }

                }
                else
                {   
                    $json_msg = array('status'=>0,'msg'=>'Invalid Data')  ;
                    echo json_encode($json_msg);
                    exit;

                }
            
            }
        }


        public function tutorLogin()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $email_id = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                $password = isset($this->request->data['password'])?trim($this->request->data['password']):"";
                $user_type = isset($this->request->data['user_type'])?trim($this->request->data['user_type']):"";

                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($email_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Email Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($password =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Password Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($email_id) && isset($password))
                {


                        $n_user_all = $this->User->find('first', array('conditions' => array('User.email_id'  => $email_id,'User.user_type'=>$user_type,'User.password'=>md5($password))));






                        $n_user = $this->User->find('count', array('conditions' => array('User.email_id'  => $email_id,'User.user_type'=>$user_type,'User.password'=>md5($password))));
                        //echo "<pre>";
                        //print_r($n_user_all);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Invalid email or password.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {
                            $n_user_status = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type,'User.status'=>1)));
                            //pr($this->User->getDataSource()->getLog(TRUE));exit;
                            if($n_user_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please confirm your email to activate your account.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {
                                $n_user_admin_status = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type,'User.admin_status'=>1)));
                                //echo $n_user ;exit();
                                if($n_user_admin_status==0)
                                {   
                                    $json_msg = array('status'=>0,'msg'=>'Account blocked by admin')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
                                else
                                {
                                    // $n_user_id = $this->User->Field('id', array('conditions' => array('User.email_id' => $email_id)));
                                    //$n_user_id = $this->User->find('first', array('fields'=>array('id'),'conditions' => array('User.email_id' => $email_id)));
                                   //print_r($n_user_id);exit();
                                    $device=$this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user_all['User']['id'],'DeviceTable.device_id'=>$device_id)));
                                    
                                    if($device!=0)
                                    {
                                        
                                        $data_to_be_saved1=array('DeviceTable.status'=>1,'DeviceTable.modified'=>'"'.date('Y-m-d h:i:s').'"'); 
                                        if ($this->DeviceTable->updateAll($data_to_be_saved1,array('DeviceTable.user_id'=>$n_user_all['User']['id'],'DeviceTable.device_id'=>$device_id)))
                                            
                                        {
                                            $new_array = array(
                                                'belongsTo'=>array('UserToUniversity' => array('foreignKey' =>false,'className'=>'UserToUniversity','conditions'=>array("UserToUniversity.user_id=User.id")),'University' => array('foreignKey' =>false,'className'=>'University','conditions'=>array("University.id=UserToUniversity.university_id"))));

                                            $this->User->bindModel($new_array,false);

                                            $n_user_details = $this->User->find('all', array('conditions' => array('User.id'  => $n_user_all['User']['id'])));

                                            $json_msg = array('status'=>1,'tutor_profile_details'=>$n_user_details,'msg'=>'login Successfully')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }

                                    }
                                    else
                                    {
                                        $data_to_be_saved['DeviceTable']['user_id'] = $n_user_all['User']['id'];
                                        $data_to_be_saved['DeviceTable']['device_id'] = $device_id;
                                        $data_to_be_saved['DeviceTable']['status'] = 1;
                                        $data_to_be_saved['DeviceTable']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved['DeviceTable']['modified'] = date('Y-m-d h:i:s');
                                        if ($this->DeviceTable->save($data_to_be_saved))
                                        {


                                            $new_array = array(
                                                'belongsTo'=>array('UserToUniversity' => array('foreignKey' =>false,'className'=>'UserToUniversity','conditions'=>array("UserToUniversity.user_id=User.id")),'University' => array('foreignKey' =>false,'className'=>'University','conditions'=>array("University.id=UserToUniversity.university_id"))));
                                            $this->User->bindModel($new_array,false);

                                            $n_user_details = $this->User->find('all', array('conditions' => array('User.id'  => $n_user_all['User']['id'])));

                                            $json_msg = array('status'=>1,'tutor_profile_details'=>$n_user_details,'msg'=>'login Successfully')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'some error occured')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                        }  
                                    }
                                }
                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
                

            }

            
        }

        public function tutorLogout()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $email_id = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                $user_type = isset($this->request->data['user_type'])?trim($this->request->data['user_type']):"";
                $error_status=0; 
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($email_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Email Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    if(isset($email_id) && isset($user_type))
                    {

                        $user_id = $this->User->find('first', array('fields'=>array('id'),'conditions' => array('User.email_id'=>$email_id,'User.user_type' => $user_type)));
                        $loggedin_user = $this->DeviceTable->find('first', array('fields'=>array('id'),'conditions' => array('DeviceTable.user_id'  => $user_id['User']['id'],'DeviceTable.device_id'=>$device_id)));
                        //echo "<pre>";
                        //print_r($loggedin_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($error_status==0)
                        {
                           $data_to_be_saved=array('DeviceTable.status'=>0,'DeviceTable.modified'=>'"'.date('Y-m-d h:i:s').'"'); 
                            if ($this->DeviceTable->updateAll($data_to_be_saved,array('DeviceTable.user_id'=>$user_id['User']['id'],'DeviceTable.id'=>$loggedin_user['DeviceTable']['id'])))
                                
                            {
                                $json_msg = array('status'=>1,'msg'=>'logout Successfully')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            } 
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                        
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                


                    
            }
        }



/***********Registration/Login/Activation For Student Start**************/

        
        public function studentRegistration()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                
              
                    $first_name = isset($this->request->data['first_name'])?trim($this->request->data['first_name']):"";
                    $last_name = isset($this->request->data['last_name'])?trim($this->request->data['last_name']):"";
                    $email = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                    
                    
                    $password = isset($this->request->data['password'])?($this->request->data['password']):"";
                  
                    $device_id = isset($this->request->data['device_id'])?($this->request->data['device_id']):"";
                    $user_type= isset($this->request->data['user_type'])?($this->request->data['user_type']):"";
                   
                    $error_status=0;

                    
                    /* Null Field Checking Start */
                    if($first_name =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Firstname required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    else if($last_name =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Lastname required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    else if($email =='')
                    {
                        
                        $json_msg = array('status'=>0,'msg'=>'Email Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    else if($password =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Password required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    // else if($university_id =='')
                    // {
                    //     $json_msg = array('status'=>0,'msg'=>'University Id Required')  ;
                    //     echo json_encode($json_msg);
                    //     $error_status=1;
                    //     exit;
                                
                    // }

                   
                    /* Null Field Checking End */


                    /*For user end*/
                    if(isset($email) && isset($user_type))
                    { 
                        //echo $user_type;
                        $n_user_email = $this->User->find('count', array('conditions' => array('User.user_type'=>$user_type,'User.email_id' => $email)));

                      // pr($this->User->getDataSource()->getLog(TRUE));exit();
                                if($n_user_email > 0)
                                {
                                    $json_msg = array('status'=>0,'msg'=>'This email address has already been registered as a student.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
                    }
                    
                    if($error_status==0)
                    {
                        $email_validate_code = rand(0,9999999);


                        $data_to_be_saved['User']['first_name'] = $first_name;
                        $data_to_be_saved['User']['last_name'] = $last_name;
                        $data_to_be_saved['User']['email_id'] = $email;
                        $data_to_be_saved['User']['email_v_code'] = $email_validate_code;
                        $data_to_be_saved['User']['user_type'] = $user_type;

                        $data_to_be_saved['User']['password'] = md5($password);
                        $data_to_be_saved['User']['raw_password'] = $password;
                        $data_to_be_saved['User']['status'] = 0;
                        $data_to_be_saved['User']['admin_status'] = 1;
                       
                        $data_to_be_saved['User']['created'] = date('Y-m-d h:i:s');
                        $data_to_be_saved['User']['modified'] = date('Y-m-d h:i:s');
                        
                        if ($this->User->save($data_to_be_saved))
                        {
                            $last_id = $this->User->getLastInsertId();

                            $data_to_be_saved1['DeviceTable']['user_id'] = $last_id;
                            $data_to_be_saved1['DeviceTable']['device_id'] = $device_id;
                            $data_to_be_saved1['DeviceTable']['status'] = 0;
                            $data_to_be_saved1['DeviceTable']['created'] = date('Y-m-d h:i:s');
                            $data_to_be_saved1['DeviceTable']['modified'] = date('Y-m-d h:i:s');

                            if ($this->DeviceTable->save($data_to_be_saved1))
                            {
                               // $last_id = $this->User->getLastInsertId();

                                //$data_to_be_saved2['UserToUniversity']['user_id'] = $last_id;
                                //$data_to_be_saved2['UserToUniversity']['university_id'] = $university_id;
                                
                                //$data_to_be_saved2['UserToUniversity']['created'] = date('Y-m-d h:i:s');
                                //$data_to_be_saved2['UserToUniversity']['modified'] = date('Y-m-d h:i:s');

                               // if ($this->UserToUniversity->save($data_to_be_saved2)) 
                                //{
				
				$send_arr = array($email_validate_code,$email,$user_type,$data_to_be_saved['User']['first_name'],$data_to_be_saved['User']['email_id'],$password);
				$param = implode("@@",$send_arr);
				$cmd = "wget -bq --spider ".BASE_URL."services/student_mail?parameter=".$param;
				shell_exec(escapeshellcmd($cmd));
				
                                   //$activation_link = BASE_URL."/activateStudent?rand_id=".base64_encode($email_validate_code)."&email_id=".base64_encode($email)."&user_type=".base64_encode($user_type);
                                   //
                                   // $mail_msg="<div style='width:80%;'>Hello ".ucfirst($data_to_be_saved['User']['first_name']).",
                                   // <br/>
                                   // <table>
                                   // <tr><td>Please complete your registration now by clicking on the link below or copying it into your browser.</td></tr>
                                   // <tr><td><a href='".$activation_link."'>".$activation_link."</a></td></tr>
                                   // <br/><br/>
                                   // <tr><td>Your login details:</td></tr>
                                   // 
                                   // <tr><td>Email &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$data_to_be_saved['User']['email_id']."</td></tr>
                                   // <tr><td>Password &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$password."</td></tr>
                                   // <br/>
                                   // <tr><td>Please contact us at ......... if you require any further assistance.</td></tr>
                                   // <br/>
                                   // <tr><td>Warmest Regards,</td></tr>
                                   // <tr><td>TutorApp Team</td></tr>
                                   // 
                                   // </table></p></div>";
                                   // 
                                   // $Email = new CakeEmail();
                                   // 
                                   // $Email->from(array(site_mail_id => 'TutorApp'));
                                   // $Email->to($data_to_be_saved['User']['email_id']);
                                   // $Email->subject('TutorApp Account Verification');
                                   // $Email->emailFormat('html');
                                   // $Email->send($mail_msg);
                                    //@mail('sumitra.unified@gmail.com','user Activation'.$data_to_be_saved['User']['email'],'mailmsg= '.$mail_msg);
                                    //echo "<script>alert('Registration completed. Please check your email for further instructions....');</scrip>";
                                    
                                    $msg = "Registration successful. Welcome to ";
                                    $this->set('msg',$msg);
                                    $json_msg = array('status'=>1,'msg'=>'Thanks for registering your profile as a student! Please confirm your email to fully activate your account.')  ;
                                    echo json_encode($json_msg);
                                    exit; 
                                //}
                                //else
                                //{
                                //    $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                 //   echo json_encode($json_msg);
                                //    exit;   
                                //}
                                
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                        echo json_encode($json_msg);
                        exit;
                    }
                    
            }
        }

// +++++++++++++++++++++++++++++++++++++++++++ Mail Send Amit +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function student_mail(){
	   
	   //$send_arr = array($email_validate_code,$email,$user_type,$data_to_be_saved['User']['first_name'],$data_to_be_saved['User']['email_id'],$password);
	   $send_arr = $_REQUEST['parameter'];
	   $all_data = explode("@@",$send_arr);
	   
	   $email_validate_code = $all_data[0];
	   $email 		= $all_data[1];
	   $user_type 		= $all_data[2];
	   $first_name 		= $all_data[3];
	   $email_id 		= $all_data[4];
	   $password 		= $all_data[5];
	   
	    $activation_link = BASE_URL."activateStudent?rand_id=".base64_encode($email_validate_code)."&email_id=".base64_encode($email)."&user_type=".base64_encode($user_type);
                                
	    $mail_msg="<div style='width:80%;'>Hello ".ucfirst($first_name).",
	    <br/>
	    <table>
	    <tr><td>Please complete your registration now by clicking on the link below or copying it into your browser.</td></tr>
	    <tr><td><a href='".$activation_link."'>".$activation_link."</a></td></tr>
	    <br/><br/>
	    <tr><td>Your login details:</td></tr>
	    
	    <tr><td>Email &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$email_id."</td></tr>
	    <tr><td>Password &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;".$password."</td></tr>
	    <br/>
	    <tr><td>Please contact us at ......... if you require any further assistance.</td></tr>
	    <br/>
	    <tr><td>Warmest Regards,</td></tr>
	    <tr><td>TutorApp Team</td></tr>
	    
	    </table></p></div>";
	    
	    $Email = new CakeEmail();
	    
	    $Email->from(array(site_mail_id => 'TutorApp'));
	    $Email->to($email_id);
	    $Email->subject('TutorApp Account Verification');
	    $Email->emailFormat('html');
	    $Email->send($mail_msg);
	}
	
// +++++++++++++++++++++++++++++++++++++++++++ Mail Send Amit +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
        public function activateStudent()
        {
            //pr($this->params['url']);exit();
            if($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                $rand_id=base64_decode($this->params['url']['rand_id']);
                $email_id=base64_decode($this->params['url']['email_id']);
                $user_type=base64_decode($this->params['url']['user_type']);
                $error_status=0;
                if(isset($email_id) && isset($rand_id))
                {

                    $n_user_email = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type)));
                    

                    if($n_user_email==0)
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid email ID')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    else
                    {
                        $this_user=$this->User->find('first', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type)));
                        if($this_user['User']['email_v_code']!=$rand_id)
                        {
                             //$json_msg = array('status'=>0,'msg'=>'Account already activated')  ;
                            // echo json_encode($json_msg);
                            echo "Account already activated";
                             $error_status=1;
                             exit;
                        }
                        elseif($this_user['User']['email_v_code']==0)
                        {
                            //$json_msg = array('status'=>0,'msg'=>'Account already activated')  ;
                            //echo json_encode($json_msg);
                            echo "Account already activated";
                            $error_status=1;
                            exit;
                        }
                    }

                        if($error_status==0)
                        {
                            $data_to_be_saved=array('User.email_v_code'=>0,'User.status'=>1,'User.modified'=>'"'.date('Y-m-d h:i:s').'"');
                            // $data_to_be_saved['User']['email_v_code'] = 0;
                            // $data_to_be_saved['User']['status'] = 1;
                            // $data_to_be_saved['User']['modified'] = date('Y-m-d h:i:s'); 
                            if ($this->User->updateAll($data_to_be_saved,array('User.email_id'=>$email_id,'User.user_type'=>$user_type)))
                                
                            {
                                //$json_msg = array('status'=>1,'msg'=>'Account Activated Successfully')  ;
                                //echo json_encode($json_msg);
                                echo "Account Activated Successfully";
                                exit;
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            }

                        }

                }
                else
                {   
                    $json_msg = array('status'=>0,'msg'=>'Invalid Data')  ;
                    echo json_encode($json_msg);
                    exit;

                }
            
            }
        }

        public function studentLogin()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $email_id = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                $password = isset($this->request->data['password'])?trim($this->request->data['password']):"";
                $user_type = isset($this->request->data['user_type'])?trim($this->request->data['user_type']):"";

                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($email_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Email Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($password =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Password Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($email_id) && isset($password))
                {


                        $n_user_all = $this->User->find('first', array('conditions' => array('User.email_id'  => $email_id,'User.user_type'=>$user_type,'User.password'=>md5($password))));



                        $n_user = $this->User->find('count', array('conditions' => array('User.email_id'  => $email_id,'User.user_type'=>$user_type,'User.password'=>md5($password))));
                        //echo "<pre>";
                        //print_r($n_user_all);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Invalid email or password.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {
                            $n_user_status = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type,'User.status'=>1)));
                            //pr($this->User->getDataSource()->getLog(TRUE));exit;
                            if($n_user_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please confirm your email to activate your account.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {
                                $n_user_admin_status = $this->User->find('count', array('conditions' => array('User.email_id' => $email_id,'User.user_type'=>$user_type,'User.admin_status'=>1)));
                                //echo $n_user ;exit();
                                if($n_user_admin_status==0)
                                {   
                                    $json_msg = array('status'=>0,'msg'=>'Account blocked by admin')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
                                else
                                {
                                    // $n_user_id = $this->User->Field('id', array('conditions' => array('User.email_id' => $email_id)));
                                    //$n_user_id = $this->User->find('first', array('fields'=>array('id'),'conditions' => array('User.email_id' => $email_id)));
                                   //print_r($n_user_id);exit();
                                    $device=$this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user_all['User']['id'],'DeviceTable.device_id'=>$device_id)));
                                    //echo $device;exit();
                                    if($device!=0)
                                    {
                                        
                                        $data_to_be_saved1=array('DeviceTable.status'=>1,'DeviceTable.modified'=>'"'.date('Y-m-d h:i:s').'"'); 
                                        if ($this->DeviceTable->updateAll($data_to_be_saved1,array('DeviceTable.user_id'=>$n_user_all['User']['id'],'DeviceTable.device_id'=>$device_id)))
                                            
                                        {

                                            $new_array = array(
                                                'belongsTo'=>array('UserToUniversity' => array('foreignKey' =>false,'className'=>'UserToUniversity','conditions'=>array("UserToUniversity.user_id=User.id")),'University' => array('foreignKey' =>false,'className'=>'University','conditions'=>array("University.id=UserToUniversity.university_id"))));
                                            $this->User->bindModel($new_array,false);
                                            $n_user_details = $this->User->find('all', array('conditions' => array('User.id'  => $n_user_all['User']['id'])));

                                            $json_msg = array('status'=>1,'student_profile_details'=>$n_user_details,'msg'=>'login Successfully')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }

                                    }
                                    else
                                    {
                                        $data_to_be_saved['DeviceTable']['user_id'] = $n_user_all['User']['id'];
                                        $data_to_be_saved['DeviceTable']['device_id'] = $device_id;
                                        $data_to_be_saved['DeviceTable']['status'] = 1;
                                        $data_to_be_saved['DeviceTable']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved['DeviceTable']['modified'] = date('Y-m-d h:i:s');
                                        if ($this->DeviceTable->save($data_to_be_saved))
                                        {
                                            $new_array = array(
                                                'belongsTo'=>array('UserToUniversity' => array('foreignKey' =>false,'className'=>'UserToUniversity','conditions'=>array("UserToUniversity.user_id=User.id")),'University' => array('foreignKey' =>false,'className'=>'University','conditions'=>array("University.id=UserToUniversity.university_id"))));
                                            
                                            $this->User->bindModel($new_array,false);

                                            $n_user_details = $this->User->find('all', array('conditions' => array('User.id'  => $n_user_all['User']['id'])));

                                            $json_msg = array('status'=>1,'student_profile_details'=>$n_user_details,'msg'=>'login Successfully')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'some error occured')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                        }  
                                    }
                                }
                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
                

            }

            
        }
        public function studentLogout()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $email_id = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                $user_type = isset($this->request->data['user_type'])?trim($this->request->data['user_type']):"";
                $error_status=0; 
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($email_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Email Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($user_type =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Type Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

                    if(isset($email_id) && isset($user_type))
                    {

                        $user_id = $this->User->find('first', array('fields'=>array('id'),'conditions' => array('User.email_id'=>$email_id,'User.user_type' => $user_type)));
                        $loggedin_user = $this->DeviceTable->find('first', array('fields'=>array('id'),'conditions' => array('DeviceTable.user_id'  => $user_id['User']['id'],'DeviceTable.device_id'=>$device_id)));
                        //echo "<pre>";
                        //print_r($loggedin_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($error_status==0)
                        {
                           $data_to_be_saved=array('DeviceTable.status'=>0,'DeviceTable.modified'=>'"'.date('Y-m-d h:i:s').'"'); 
                            if ($this->DeviceTable->updateAll($data_to_be_saved,array('DeviceTable.user_id'=>$user_id['User']['id'],'DeviceTable.id'=>$loggedin_user['DeviceTable']['id'])))
                                
                            {
                                $json_msg = array('status'=>1,'msg'=>'logout Successfully')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occurred.')  ;
                                echo json_encode($json_msg);
                                exit;
                            } 
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                        
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                


                    
            }
        }

/**************University List/subjectList/SubjectCodeLIst***************/
        public function universityList()
        {
            $page=(isset($this->request->data['page'])&&($this->request->data['page']!=''))?($this->request->data['page']):1;
            $limit=10; 
            $cond = array('University.status' => 1);
            $cnt = $this->University->find("count",array('fields'=>array('University.*'),'conditions'=>$cond,'order'=>array('University.university_name'=>'Asc'))); 
            if(ceil($cnt/$limit)>=$page)
            {
                $this->request->params['named']['page'] = $page;
                //$this->set('clinics', $this->Paginator->paginate()); 
                $this->Paginator->settings = array('fields'=>array('id','university_name'),'conditions'=>array($cond),'order'=>array('University.id'=>'Asc'),'limit' => $limit);
                $get_university=$this->Paginator->paginate('University');
                
                if(!empty($get_university))
                {
                
                $json_msg = array('status'=>1,'next'=>($page+1),'max_page'=>ceil($cnt/$limit),'get_university'=>$this->appify_a_result_array($get_university,'University'),'msg'=>'All universityList')  ;
                //echo "<pre>";
                //print_r($json_msg);exit();
                echo json_encode($json_msg);
                exit;
                }
                else
                {
                $json_msg = array('status'=>0,'msg'=>'No University found')  ;
                echo json_encode($json_msg);
                exit;
                }
            }
            else
            {
                $json_msg = array('status'=>0,'msg'=>'No such University page')  ;
                echo json_encode($json_msg);
                exit;
            }        
        }
	
	/*public function schoolList()
        {
            $page=(isset($this->request->data['page'])&&($this->request->data['page']!=''))?($this->request->data['page']):1;
            $limit=10; 
            $cond = array('School.status' => 1);
            $cnt = $this->School->find("count",array('fields'=>array('School.*'),'conditions'=>$cond,'order'=>array('School.school_name'=>'Asc'))); 
            if(ceil($cnt/$limit)>=$page)
            {
                $this->request->params['named']['page'] = $page;
                //$this->set('clinics', $this->Paginator->paginate()); 
                $this->Paginator->settings = array('fields'=>array('id','school_name'),'conditions'=>array($cond),'order'=>array('School.id'=>'Asc'),'limit' => $limit);
                $get_school=$this->Paginator->paginate('School');
                
                if(!empty($get_school))
                {
                
                $json_msg = array('status'=>1,'next'=>($page+1),'max_page'=>ceil($cnt/$limit),'get_school'=>$this->appify_a_result_array($get_school,'School'),'msg'=>'All schoolList')  ;
                //echo "<pre>";
                //print_r($json_msg);exit();
                echo json_encode($json_msg);
                exit;
                }
                else
                {
                $json_msg = array('status'=>0,'msg'=>'No School found')  ;
                echo json_encode($json_msg);
                exit;
                }
            }
            else
            {
                $json_msg = array('status'=>0,'msg'=>'No such School page')  ;
                echo json_encode($json_msg);
                exit;
            }        
        }*/
	

        public function subjectList()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
                $error_status=0;
                /* Null Field Checking Start */
                    if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    if($error_status==0)
                    {
                        $page=(isset($this->request->data['page'])&&($this->request->data['page']!=''))?($this->request->data['page']):1;
                        $limit=10; 
                        $cond = array('Subject.university_id'=>$university_id,'Subject.status' => 1);
                        $cnt = $this->Subject->find("count",array('fields'=>array('Subject.*'),'conditions'=>$cond,'order'=>array('Subject.subject_name'=>'Asc'))); 
                        if(ceil($cnt/$limit)>=$page)
                        {
                            $this->request->params['named']['page'] = $page;
                            //$this->set('clinics', $this->Paginator->paginate()); 
                            $this->Paginator->settings = array('fields'=>array('id','subject_name'),'conditions'=>array($cond),'order'=>array('Subject.subject_name'=>'Asc'),'limit' => $limit);
                            $get_subject=$this->Paginator->paginate('Subject');
                            
                            if(!empty($get_subject))
                            {
                            
                                $json_msg = array('status'=>1,'next'=>($page+1),'max_page'=>ceil($cnt/$limit),'get_subject'=>$this->appify_a_result_array($get_subject,'Subject'),'msg'=>'Get All SubjectList')  ;
                                //echo "<pre>";
                                //print_r($json_msg);exit();
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'No Subject found')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'No such Subject found')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                    }
                    else
                    {
                            $json_msg = array('status'=>0,'msg'=>'Some Error Occured')  ;
                            echo json_encode($json_msg);
                            exit;
                    }

                     
            }
                   
        }

        public function subjectCodeList()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
                $subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
                $error_status=0;
                /* Null Field Checking Start */
                    if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    if($subject_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Please choose a valid subject.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    if($error_status==0)
                    {
                        $page=(isset($this->request->data['page'])&&($this->request->data['page']!=''))?($this->request->data['page']):1;
                        $limit=10; 
                        $cond = array('SubjectCode.university_id'=>$university_id,'SubjectCode.subject_id'=>$subject_id,'SubjectCode.status' => 1);
                       // print_r($cond);exit();
                        $cnt = $this->SubjectCode->find("count",array('fields'=>array('SubjectCode.*'),'conditions'=>$cond,'order'=>array('SubjectCode.sub_code'=>'Asc')));
                        //print_r($cnt);exit(); 
                        //pr($this->SubjectCode->getDataSource()->getLog(TRUE));exit;
                        if(ceil($cnt/$limit)>=$page)
                        {
                            $this->request->params['named']['page'] = $page;
                            //$this->set('clinics', $this->Paginator->paginate()); 
                            $this->Paginator->settings = array('fields'=>array('id','sub_code'),'conditions'=>array($cond),'order'=>array('SubjectCode.sub_code'=>'Asc'),'limit' => $limit);
                            $get_subject_code=$this->Paginator->paginate('SubjectCode');
                            
                            if(!empty($get_subject_code))
                            {
                            
                                $json_msg = array('status'=>1,'next'=>($page+1),'max_page'=>ceil($cnt/$limit),'get_subject_code'=>$this->appify_a_result_array($get_subject_code,'SubjectCode'),'msg'=>'All SubjectCodeList')  ;
                                //echo "<pre>";
                                //print_r($json_msg);exit();
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'No SubjectCode found')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'No such SubjectCode found')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                    }
                    else
                    {
                            $json_msg = array('status'=>0,'msg'=>'Some Error Occured')  ;
                            echo json_encode($json_msg);
                            exit;
                    }

                     
            }
                   
        }

        public function subProfessorList()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
                $subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
                $subject_code_id = isset($this->request->data['subject_code_id'])?trim($this->request->data['subject_code_id']):"";
                $error_status=0;
                /* Null Field Checking Start */
                    if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                    if($subject_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Please choose a valid subject.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }
                     if($subject_code_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Please choose a valid subject code.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }


                    if($error_status==0)
                    {
                        $page=(isset($this->request->data['page'])&&($this->request->data['page']!=''))?($this->request->data['page']):1;
                        $limit=10; 
                        $cond = array('SubjectProfessor.university_id'=>$university_id,'SubjectProfessor.subject_id'=>$subject_id,'SubjectProfessor.subject_code_id'=>$subject_code_id,'SubjectProfessor.status' => 1);
                       // print_r($cond);exit();
                        $cnt = $this->SubjectProfessor->find("count",array('fields'=>array('SubjectProfessor.*'),'conditions'=>$cond,'order'=>array('SubjectProfessor.professor_name'=>'Asc')));
                        //print_r($cnt);exit(); 
                        //pr($this->SubjectCode->getDataSource()->getLog(TRUE));exit;
                        if(ceil($cnt/$limit)>=$page)
                        {
                            $this->request->params['named']['page'] = $page;
                            //$this->set('clinics', $this->Paginator->paginate()); 
                            $this->Paginator->settings = array('fields'=>array('id','professor_name'),'conditions'=>array($cond),'order'=>array('SubjectProfessor.professor_name'=>'Asc'),'limit' => $limit);
                            $get_subject_professor=$this->Paginator->paginate('SubjectProfessor');
                            
                            if(!empty($get_subject_professor))
                            {
                            
                                $json_msg = array('status'=>1,'next'=>($page+1),'max_page'=>ceil($cnt/$limit),'get_subject_professor'=>$this->appify_a_result_array($get_subject_professor,'SubjectProfessor'),'msg'=>'All Professor List')  ;
                                //echo "<pre>";
                                //print_r($json_msg);exit();
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $json_msg = array('status'=>0,'msg'=>'No Professor  found')  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }
                        else
                        {
                            $json_msg = array('status'=>0,'msg'=>'No such professor found')  ;
                            echo json_encode($json_msg);
                            exit;
                        }
                    }
                    else
                    {
                            $json_msg = array('status'=>0,'msg'=>'Some Error Occured')  ;
                            echo json_encode($json_msg);
                            exit;
                    }

                     
            }
                   
        }

        function forgotPassword()
        {
               if($_SERVER['REQUEST_METHOD'] === 'POST')
               {
                    $email = isset($this->request->data['email'])?trim($this->request->data['email']):"";
                    $user_type = isset($this->request->data['user_type'])?trim($this->request->data['user_type']):"";

                    $cond=array('User.email_id'=>$email,'User.user_type'=>$user_type);

                    $user_details = $this->User->find('first',array('conditions'=>$cond));
                    
                        if($email !="" && !empty($user_details))    
                        {
                            $mail_msg="<div style='width:80%;'>
                                        Hello ".ucfirst($user_details['User']['first_name']).",
                                        
                                        
                                        <br/>
                                        <p>Your login details:</p>
                                        <p>Username : ".$user_details['User']['email_id']."</p>
                                        <p>Password : ".$user_details['User']['raw_password']."</p>
                                        
                                        <p>Warmest Regards,<p/>
                                        <p>TutorApp Team<p/>
                                        
                                        
                                        </div>";
                            
                            $Email = new CakeEmail();
                            $Email->from(array(site_mail_id => 'TutorApp'));
                            $Email->to($user_details['User']['email_id']);
                            $Email->subject('TutorApp Password');
                            $Email->emailFormat('html');
                            if($Email->send($mail_msg))
                            {
                                //@mail('sumitra.unified@gmail.com','pass reset'.$user_details['User']['username'].$update_password,'mailmsg= '.$mail_msg);
                                $message = 'Password has been sent.Please check your email.';
                                $json_msg = array('status'=>1,'msg'=>$message)  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                            else
                            {
                                $message = 'Error,Email not sent.';
                                $json_msg = array('status'=>0,'msg'=>$message)  ;
                                echo json_encode($json_msg);
                                exit;
                            }
                        }     
                        else
                        {
                        $json_msg = array('status'=>0,'msg'=>'No user found')  ;
                        echo json_encode($json_msg);
                        exit;
                        }
                }
        }

        


/********************Module 2*********************/


        public function getTutorProfile()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($device_id) && isset($user_id))
                {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>2,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {     
                                $this->User->bindModel(

                                    array(
                                            "hasOne"=>array(
                                                    "UserToUniversity"=>array(
                                                        'className'=>"UserToUniversity",
                                                        'foreignKey'=>"user_id"
                                                            )
                                                    ),
                                              "belongsTo"=>array(
                                                    "University"=>array(
                                                        'className'=>"University",
                                                        'foreignKey'=>false,
                                                       
                                                        )
                                              ) 

                                           
                                        ),false
                                    );

                                $data=$this->User->find('all',array('conditions'=>array('User.id'=>$n_user['User']['id'],"University.id=UserToUniversity.university_id")));
                                $data1=$this->User->find('all',array('conditions'=>array('User.id'=>$n_user['User']['id'],"University.id=UserToUniversity.tutorat_university")));

                                $course_count=$this->TutorCourse->find('count',array('conditions'=>array('TutorCourse.user_id'=>$n_user['User']['id'])));
                                //$course_count_active=$this->TutorCourse->find('all',array('conditions'=>array('TutorCourse.user_id'=>$n_user['User']['id'],'TutorCourse.availibility'=>1)));
                                //pr($this->User->getDataSource()->getLog(TRUE));exit;
                               // pr($course_count_active);exit();
                                $degree_count=$this->TutorDegree->find('count',array('conditions'=>array('TutorDegree.user_id'=>$n_user['User']['id'])));
                                $university_list=$this->University->find('all');
                                $home_state_list=$this->HomeState->find('all');
                                $data[0]['User']['thumb'] = $data[0]['User']['prof_image'];
                                //echo $data[0]['User']['prof_image'];
                                //pr($data);exit;
                                $json_msg = array('status'=>1,'msg'=>'Tutor profile successfully fetched!!!','data'=>array(
                                'tutor_details'=>$this->appify_a_result_array($data,'User',array('prof_image'=>BASE_URL.'uploads/ProfImage/'),array(),array(),array(),array('thumb'=>BASE_URL.'uploads/ProfImage/thumb/')),
                                'current_university'=>$this->appify_a_result_array($data,'University'),
                                'tutor_at_university'=>$this->appify_a_result_array($data1,'University'),
                                'course_count'=>$course_count,
                                //'course_count_active'=>$this->appify_a_result_array($course_count_active,'TutorCourse'),
                                'degree_count'=>$degree_count,
                                'university_list'=>$this->appify_a_result_array($university_list,'University'),
                                'home_state_list'=>$this->appify_a_result_array($home_state_list,'HomeState')

                                )) ;
                                echo json_encode($json_msg);
                                exit;

                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
                

            }
        }

    /* GETTING ALL DETAILS OF TUTOR PROFILE  START */	
	
	public function getTutorProfileDetails()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($device_id) && isset($user_id))
                {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>2,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {     
                                $this->User->bindModel(

                                    array(
                                            "hasOne"=>array(
                                                    "UserToUniversity"=>array(
                                                        'className'=>"UserToUniversity",
                                                        'foreignKey'=>"user_id"
                                                            )
                                                    ),
                                              "belongsTo"=>array(
                                                    "University"=>array(
                                                        'className'=>"University",
                                                        'foreignKey'=>false,
                                                       
                                                        )
                                              )

                                           
                                        ),false
                                    );
				
				/* For tutor course mapping with others End */
				
				$this->TutorCourse->bindModel(

                                                array(

                                                    "belongsTo"=>array(
                                                        "University"=>array('foreignKey'=>false,
                                                        'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
                                                        'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
                                                        'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
                                                        'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
                                                                    
                                                            )
                                                        ),false
                                                                          

                                             );
                             
                                    $data3=$this->TutorCourse->find('all',array('fields'=>array('Subject.id','Subject.subject_name','SubjectCode.sub_code','SubjectCode.id','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.user_id'=>$user_id,'TutorCourse.availibility'=>'1')));
				 /* For tutor course mapping with others end */  

                                $data=$this->User->find('all',array('conditions'=>array('User.id'=>$n_user['User']['id'],"University.id=UserToUniversity.university_id")));
                                $data1=$this->User->find('all',array('conditions'=>array('User.id'=>$n_user['User']['id'],"University.id=UserToUniversity.tutorat_university")));

                                $course_count=$this->TutorCourse->find('count',array('conditions'=>array('TutorCourse.user_id'=>$n_user['User']['id'])));
                          
                                $degree_count=$this->TutorDegree->find('count',array('conditions'=>array('TutorDegree.user_id'=>$n_user['User']['id'])));
                                $university_list=$this->University->find('all');
                                $home_state_list=$this->HomeState->find('all');
				if(!empty($data))
				{
				    if(file_exists("uploads/ProfImage/".$data[0]['User']['prof_image']))
				    {
					$data[0]['User']['prof_image']=$data[0]['User']['prof_image'];
					$data[0]['User']['thumb'] = $data[0]['User']['prof_image'];
				    }
				    else
				    {
					$data[0]['User']['prof_image']="";
					$data[0]['User']['thumb'] = "";
				    }
				}
				
                               
				// Tutor has submerchant or not checking //
				$has_submerchant = $this->MerchantAccountDetails->find('first', array('conditions' => array('MerchantAccountDetails.user_id'=>$user_id)));
				if(!empty($has_submerchant))
				{
				    $submerchant_id = $has_submerchant['MerchantAccountDetails']['sub_merchant_id'];
				}
				else
				{
				      $submerchant_id = "";
				}
				//pr($has_submerchant);exit;
                                $json_msg = array('status'=>1,'msg'=>'Tutor profile successfully fetched!!!','data'=>array(
                                'tutor_details'=>$this->appify_a_result_array($data,'User',array('prof_image'=>BASE_URL.'uploads/ProfImage/'),array(),array(),array(),array('thumb'=>BASE_URL.'uploads/ProfImage/thumb/')),
                                'course_count'=>$course_count,
                                'degree_count'=>$degree_count,
				'all_details'=>$data3,
				'submerchant_id'=>$submerchant_id
                                )) ;
                                echo json_encode($json_msg);
                                exit;

                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
                

            }
        }
    /* GETTING ALL DETAILS OF TUTOR PROFILE  END */
    
    /* UPDATE TUTOR PROFILE START */
    
        public function tutorUpdateProfile()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $gender = isset($this->request->data['gender'])?trim($this->request->data['gender']):"";

                $date_of_birth = isset($this->request->data['date_of_birth'])?trim($this->request->data['date_of_birth']):"";
                $home_state = isset($this->request->data['home_state'])?trim($this->request->data['home_state']):"";
                $current_university = isset($this->request->data['current_university'])?trim($this->request->data['current_university']):"";


                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($gender =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Gender Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($date_of_birth =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Date Of Birth Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($home_state =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Home State Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($current_university =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Current University Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                    if(isset($device_id) && isset($user_id))
                    {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {   
                                $data_to_be_saved=array('User.gender'=> '"' . $gender . '"','User.date_of_birth'=>'"' . $date_of_birth . '"','User.home_state'=>'"' . $home_state . '"','User.edit_status'=>1,'User.modified'=>'"'.date('Y-m-d h:i:s').'"'); 

                                if ($this->User->updateAll($data_to_be_saved,array('User.id' =>$user_id)))
                                        
                                {
                                    $data_to_be_saved1=array('UserToUniversity.university_id'=>$current_university,'UserToUniversity.modified'=>'"'.date('Y-m-d h:i:s').'"');
                                    if ($this->UserToUniversity->updateAll($data_to_be_saved1,array('UserToUniversity.user_id' => $user_id)))
                                    {
                                        $json_msg = array('status'=>1,'msg'=>'Tutor profile updated successfully.')  ;
                                        echo json_encode($json_msg);
                                        exit; 
                                    }
                                    else
                                    {
                                       $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occured.')  ;
                                        echo json_encode($json_msg);
                                        exit;  
                                    }
   
                                }
                                else
                                {
                                    $json_msg = array('status'=>0,'msg'=>'Data not saved.Some error occured.')  ;
                                    echo json_encode($json_msg);
                                    exit; 
                                }

                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                

            }

            
        }
    
    /* UPDATE TUTOR PROFILE START */
    
    /* UPLOADING IMAGE OR QUOTE FOR TUTOR START */
        public function tutorUpdateProfilePicQuote()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
		

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $fileInput = (!empty($_FILES['fileInput']['name']))?trim($_FILES['fileInput']['name']):"";

                $quote = isset($this->request->data['quote'])?trim($this->request->data['quote']):"";


                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    


                    
                   // echo ($user_type);exit();
                    if(isset($device_id) && isset($user_id))
                    {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {
				$last_image=$this->User->find('first', array('fields' => array('prof_image','profile_quotes'), 'conditions' => array('User.id' => $user_id)));
				$filename = ($last_image['User']['prof_image']!="")?$last_image['User']['prof_image']:'';
				//echo $quote; exit;
				$quote = ($quote!="")?$quote:$last_image['User']['profile_quotes'];
				//echo $quote; exit;
				if($fileInput !='')
				{				    
                                    if($last_image['User']['prof_image'])
                                    {
                                        //pr($last_image['User']['prof_image']);exit();
                                        $img_path = "./uploads/ProfImage/".$last_image['User']['prof_image'];
                                        $img_path_thumb = "./uploads/ProfImage/thumb/".$last_image['User']['prof_image'];
                                        $img_path_mobile = "./uploads/ProfImage/mobile/".$last_image['User']['prof_image'];
                                        @unlink($img_path); @unlink($img_path_thumb);@unlink($img_path_mobile);
                                    }
                                
				    $filename=$_FILES['fileInput']['name'];
				    $file_arr=explode('.',$filename);
				    $ext=$file_arr[count($file_arr)-1];
				    $tmp=$_FILES['fileInput']['tmp_name'];
				    $filename=rand(100,999).time().$user_id.'.'.$ext;
				    $folder="./uploads/ProfImage/";
				    $thumb_path="./uploads/ProfImage/thumb/";
				    $mobile_path="./uploads/ProfImage/mobile/";
				    $path=$folder.$filename;
                                    if(!move_uploaded_file($tmp,$path))
                                    {
                                        $error_status =1;
                                        $return_arr=array('status'=>0,'msg'=>'File not uploaded.');
                                        echo json_encode($return_arr);
                                        exit;
                                    }
                                    else
                                    {
                                        $thumb=array('file'=>$folder.$filename,'width'=>'50','height'=>'60','output'=>$thumb_path,'proportional'=>true); // thumb image
                                        $mobile=array('file'=>$folder.$filename,'width'=>'275','height'=>'260','output'=>$mobile_path,'proportional'=>true);  //large image             
                                        $thumb_create=$this->Qimage->resize($thumb);
                                        $mobile_create=$this->Qimage->resize($mobile);
                
                                
                                        $data_to_be_saved=array('User.prof_image'=>'"' . $filename . '"','User.profile_quotes'=>'"'.$quote.'"');
                                        //$target_path = "./uploads/Thumb/".$filename;
                                        //$source_path = $path;
                                        //$this->Qimage->resize( $target_path);
                                        $error_status = 0;
                                    }
				}
				else
				{
				    $data_to_be_saved=array('User.prof_image'=>'"' . $filename . '"','User.profile_quotes'=>'"'.$quote.'"');

				}
                           
                                if ($this->User->updateAll($data_to_be_saved,array('User.id' => $user_id)))
                                {

                                        $json_msg = array('status'=>1,'msg'=>'Profile updated successfully')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                }
                                else
                                {
                                        $json_msg = array('status'=>0,'msg'=>'Data not Saved Some error occurred.')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                }

                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                

            }
        }
    /* UPLOADING IMAGE OR QUOTE FOR TUTOR END */
    
/********************Tutor Course*********************/
	   
        public function getCourseList()
        {
           if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($device_id) && isset($user_id))
                {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {     
                                 $this->TutorCourse->bindModel(

                                                array(

                                                    "belongsTo"=>array(
                                                        "University"=>array('foreignKey'=>false,
                                                        'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
                                                        'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
                                                        'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
                                                        'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
                                                                    
                                                            )
                                                        ),false
                                                                          

                                             );
                             
                                    $data=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.id','TutorCourse.grade','TutorCourse.university_id','TutorCourse.availibility','Subject.id','Subject.subject_name','SubjectCode.sub_code','SubjectCode.id','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.user_id'=>$user_id,'TutorCourse.status'=>1 )));
                                    $json_msg = array('status'=>1,'msg'=>'Tutor profile successfully fetched!!!','data'=>$data) ;
                                    echo json_encode($json_msg);
                                    exit;
                               
                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
                

            } 
        }

        public function tutorAddCourse()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
                $subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
                $subject_name = isset($this->request->data['subject_name'])?trim($this->request->data['subject_name']):"";
                $subject_code_id = isset($this->request->data['subject_code_id'])?trim($this->request->data['subject_code_id']):"";
                $subject_code_name = isset($this->request->data['subject_code_name'])?trim($this->request->data['subject_code_name']):"";
                $subject_professor_id = isset($this->request->data['subject_professor_id'])?trim($this->request->data['subject_professor_id']):"";
                $subject_professor_name = isset($this->request->data['subject_professor_name'])?trim($this->request->data['subject_professor_name']):"";
                $grade = isset($this->request->data['grade'])?trim($this->request->data['grade']):"";


                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($grade =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Grade Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

		    //echo ($user_type);exit();
                    if(isset($device_id) && isset($user_id))
                    {
			
			$already_exist = $this->TutorCourse->find('count', array('conditions' => array('TutorCourse.university_id'=>$university_id,'TutorCourse.subject_id'=>$subject_id,'TutorCourse.subject_code_id'=>$subject_code_id,'TutorCourse.subject_professor_id'=>$subject_professor_id,'TutorCourse.user_id'=>$user_id)));
			
			//echo $already_exist; exit;
			if($already_exist > 0)
			{
			    $json_msg = array('status'=>2,'msg'=>'Course already added. Tap the course in your list to edit details.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
			}
			
                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {   
                                if($subject_id=='' && $subject_code_id=='' && $subject_professor_id=='')
                                {   
                                    if($subject_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                     if($subject_code_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Code name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                     if($subject_professor_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    $data_to_be_saved['Subject']['university_id'] =$university_id;
                                    $data_to_be_saved['Subject']['subject_name'] = $subject_name;
                                    $data_to_be_saved['Subject']['status'] = 0;
                                    $data_to_be_saved['Subject']['created'] = date('Y-m-d h:i:s');
                                    $data_to_be_saved['Subject']['modified'] = date('Y-m-d h:i:s');
                                    if ($this->Subject->save($data_to_be_saved))
                                    {
                                        $new_subject_id=$this->Subject->getLastInsertID();

                                        $data_to_be_saved1['SubjectCode']['university_id'] =$university_id;
                                        $data_to_be_saved1['SubjectCode']['subject_id'] =$new_subject_id;

                                        $data_to_be_saved1['SubjectCode']['sub_code'] = $subject_code_name;
                                        $data_to_be_saved1['SubjectCode']['status'] = 0;
                                        $data_to_be_saved1['SubjectCode']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved1['SubjectCode']['modified'] = date('Y-m-d h:i:s');
                                        if($this->SubjectCode->save($data_to_be_saved1))
                                        {
                                            $new_subject_code_id=$this->SubjectCode->getLastInsertID();

                                            $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                            $data_to_be_saved2['SubjectProfessor']['subject_id'] = $new_subject_id;
                                            $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $new_subject_code_id;
                                            $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                            $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                            $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                            $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                            if($this->SubjectProfessor->save($data_to_be_saved2))
                                            {
                                                $new_professor_id=$this->SubjectProfessor->getLastInsertID();

                                                $data_to_course2['TutorCourse']['user_id']=$user_id;
                                                $data_to_course2['TutorCourse']['university_id']=$university_id;
                                                $data_to_course2['TutorCourse']['subject_id']=$new_subject_id;
                                                $data_to_course2['TutorCourse']['subject_code_id']=$new_subject_code_id;
                                                $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                                $data_to_course2['TutorCourse']['grade']=$grade;
                                                $data_to_course2['TutorCourse']['status']=0;
                                                $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                                $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                                if ($this->TutorCourse->save($data_to_course2))
                                                {
                                                    $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not saved in tutor as new entry.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;   
                                                }

                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject_professor.')  ;
                                                echo json_encode($json_msg);
                                                exit; 
                                            }
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject_code.')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject.')  ;
                                        echo json_encode($json_msg);
                                        exit; 
                                    }
                                }
                                else if($subject_code_id=='' && $subject_professor_id=='')
                                {   
                                    if($subject_code_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Code name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    if($subject_professor_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    $data_to_be_saved1['SubjectCode']['university_id'] =$university_id;
                                    $data_to_be_saved1['SubjectCode']['subject_id'] =$subject_id;
                                    $data_to_be_saved1['SubjectCode']['sub_code'] = $subject_code_name;
                                    $data_to_be_saved1['SubjectCode']['status'] = 0;
                                    $data_to_be_saved1['SubjectCode']['created'] = date('Y-m-d h:i:s');
                                    $data_to_be_saved1['SubjectCode']['modified'] = date('Y-m-d h:i:s');
                                    if($this->SubjectCode->save($data_to_be_saved1))
                                    {
                                        $new_subject_code_id=$this->SubjectCode->getLastInsertID();

                                        $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_id'] = $subject_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $new_subject_code_id;
                                        $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                        $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                        $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                        if($this->SubjectProfessor->save($data_to_be_saved2))
                                        {
                                            $new_professor_id=$this->SubjectProfessor->getLastInsertID();

                                            $data_to_course2['TutorCourse']['user_id']=$user_id;
                                            $data_to_course2['TutorCourse']['university_id']=$university_id;
                                            $data_to_course2['TutorCourse']['subject_id']=$subject_id;
                                            $data_to_course2['TutorCourse']['subject_code_id']=$new_subject_code_id;
                                            $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                            $data_to_course2['TutorCourse']['grade']=$grade;
                                            $data_to_course2['TutorCourse']['status']=0;
                                            $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                            $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                            if ($this->TutorCourse->save($data_to_course2))
                                            {
                                                $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not saved in tutor as new entry.')  ;
                                                echo json_encode($json_msg);
                                                exit;   
                                            }

                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject_professor.')  ;
                                            echo json_encode($json_msg);
                                            exit; 
                                        }
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject_code.')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                    }
                                    
                                    
                                }
                                else if($subject_professor_id=='')
                                {
                                    
                                        if($subject_professor_name =='')
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                        }
                                        $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_id'] = $subject_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $subject_code_id;
                                        $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                        $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                        $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                        if($this->SubjectProfessor->save($data_to_be_saved2))
                                        {
                                            $new_professor_id=$this->SubjectProfessor->getLastInsertID();

                                            $data_to_course2['TutorCourse']['user_id']=$user_id;
                                            $data_to_course2['TutorCourse']['university_id']=$university_id;
                                            $data_to_course2['TutorCourse']['subject_id']=$subject_id;
                                            $data_to_course2['TutorCourse']['subject_code_id']=$subject_code_id;
                                            $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                            $data_to_course2['TutorCourse']['grade']=$grade;
                                            $data_to_course2['TutorCourse']['status']=0;
                                            $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                            $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                            if ($this->TutorCourse->save($data_to_course2))
                                            {
                                                $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not saved in tutor as new entry.')  ;
                                                echo json_encode($json_msg);
                                                exit;   
                                            }

                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not saved in Subject_professor.')  ;
                                            echo json_encode($json_msg);
                                            exit; 
                                        }
                                    
                                   
                                }
                                else
                                {
                                    $data_to_course['TutorCourse']['user_id']=$user_id;
                                    $data_to_course['TutorCourse']['university_id']=$university_id;
                                    $data_to_course['TutorCourse']['subject_id']=$subject_id;
                                    $data_to_course['TutorCourse']['subject_code_id']=$subject_code_id;
                                    $data_to_course['TutorCourse']['subject_professor_id']=$subject_professor_id;
                                    $data_to_course['TutorCourse']['grade']=$grade;
                                    $data_to_course['TutorCourse']['status']=1;
                                    $data_to_course['TutorCourse']['created']=date('Y-m-d h:i:s');
                                    $data_to_course['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                    if ($this->TutorCourse->save($data_to_course))
                                    {
                                        $json_msg = array('status'=>1,'msg'=>'Course added successfully')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in tutor.')  ;
                                        echo json_encode($json_msg);
                                        exit;   
                                    }
                                }

                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
            }
            
        }

        public function courseOnOff()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $course_id = isset($this->request->data['course_id'])?trim($this->request->data['course_id']):"";
                $course_id_arr=explode(',', $course_id);
                //pr($course_id_arr);exit();
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    //else if($course_id =='')
                    //{
                    //    $json_msg = array('status'=>0,'msg'=>'Course Id Required')  ;
                    //    echo json_encode($json_msg);
                    //    $error_status=1;
                    //    exit;
                    //            
                    //}
                    

                    if(isset($device_id) && isset($user_id))
                    {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {   
                                $data_to_be_reset=array('TutorCourse.availibility'=>0);
                                if($this->TutorCourse->updateAll($data_to_be_reset,array('TutorCourse.user_id'=>$user_id)))
                                {
                                        $data_to_be_saved=array('TutorCourse.availibility'=>1); 

                                        for($i=0;$i<sizeof($course_id_arr);$i++);
                                        {
                                         //pr($course_id_arr);exit();
                                            $this->TutorCourse->updateAll($data_to_be_saved,array('TutorCourse.id' =>$course_id_arr,'TutorCourse.user_id'=>$user_id));
                                                $error_status=0;
                                        }
                                            if ($error_status==0)
                                            {
                                                $json_msg = array('status'=>1,'msg'=>'changed successfully.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'not changed.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                }
                                else
                                {
                                    $json_msg = array('status'=>0,'msg'=>'not reset.')  ;
                                    echo json_encode($json_msg);
                                    exit;
                                }
                                 

                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                

            } 
        }
/********************Tutor Degree*********************/

        public function schoolDegreeSubjectList()
        {
                
                $school_list=$this->School->find('all',array('fields'=>array('School.id','School.school_name'),'conditions'=>array('School.status'=>1)));

                $degree_list=$this->Degree->find('all',array('fields'=>array('Degree.id','Degree.name'),'conditions'=>array('Degree.status'=>1)));

                $degree_subject_list=$this->DegreeSubject->find('all',array('fields'=>array('DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('DegreeSubject.status'=>1)));

                
                $json_msg = array('status'=>1,'msg'=>'data successfully fetched!!!','data'=>array(

                'school_list'=>$this->appify_a_result_array($school_list,'School'),

                'degree_list'=>$this->appify_a_result_array($degree_list,'Degree'),

                'degree_subject_list'=>$this->appify_a_result_array($degree_subject_list,'DegreeSubject')
                
                )) ;
                echo json_encode($json_msg);
                exit;
        }

        public function getDegreeList()
        {
           if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($device_id) && isset($user_id))
                {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {     
                                 $this->TutorDegree->bindModel(

                                                array(

                                                    "belongsTo"=>array(
                                                        "School"=>array('foreignKey'=>false,
                                                        'className'=>"School",'conditions' => array("TutorDegree.school_id=School.id"), 'type' => 'LEFT'),
                                                        'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
                                                        'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
                                                                    
                                                            )
                                                        ),false
                                             );
                             
                                    $data=$this->TutorDegree->find('all',array('fields'=>array('TutorDegree.id','TutorDegree.completion','TutorDegree.year','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('TutorDegree.user_id'=>$user_id,'TutorDegree.status'=>1)));
                                    $json_msg = array('status'=>1,'msg'=>'Tutor profile successfully fetched!!!','data'=>$data) ;
                                    echo json_encode($json_msg);
                                    exit;
                               
                            }
                        }
                }
                else
                {
                    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                    echo json_encode($json_msg);
                    exit;
 
                }
            } 
        }

        public function tutorAddDegree()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                $completion = isset($this->request->data['completion'])?trim($this->request->data['completion']):"";
                $degree = isset($this->request->data['degree'])?trim($this->request->data['degree']):"";
                $year = isset($this->request->data['year'])?trim($this->request->data['year']):"";
                $school_id = isset($this->request->data['school_id'])?trim($this->request->data['school_id']):"";
                $school_name = isset($this->request->data['school_name'])?trim($this->request->data['school_name']):"";
                $degree_subject_id = isset($this->request->data['degree_subject_id'])?trim($this->request->data['degree_subject_id']):"";
                $degree_subject_name = isset($this->request->data['degree_subject_name'])?trim($this->request->data['degree_subject_name']):"";

                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($completion =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Completion Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($degree =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Degree Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($year =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Year Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                    if(isset($device_id) && isset($user_id))
                    {
			
			$already_exist = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.school_id'=>$school_id,'TutorDegree.degree_id'=>$degree,'TutorDegree.degree_subject_id'=>$degree_subject_id,'TutorDegree.user_id'=>$user_id)));
			
			if($already_exist >0)
			{
			    $json_msg = array('status'=>2,'msg'=>'Degree already added. Tap the course in your list to edit details.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
			}
			
                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            { 
                                $n_degree_ear = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Earned')));
                                $n_degree_pur = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Pursuing')));
				//echo $n_degree_ear;
				//echo $n_degree_pur;
				//exit();
                                //pr($n_degree_pur);
				$n_degree_ear_plus = 0;
				$n_degree_pur_plus = 0;
				
				if($completion=="Earned"){
				    $n_degree_ear_plus = $n_degree_ear + 1;
				}
				if($completion=="Pursuing"){
				    $n_degree_pur_plus = $n_degree_pur + 1;
				}
				
				if($n_degree_ear_plus >2)
                                {
                                    $json_msg = array('status'=>0,'msg'=>' You can add up to 2 current majors and up to 2 degrees earned for a maximum of four degrees earned or pursued.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
				if($n_degree_pur_plus >2)
                                {
                                    $json_msg = array('status'=>0,'msg'=>' You can add up to 2 current majors and up to 2 degrees earned for a maximum of four degrees earned or pursued.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
				
                                if((($n_degree_ear)+($n_degree_pur))>=4)
                                {
                                    $json_msg = array('status'=>0,'msg'=>' You can add up to 2 current majors and up to 2 degrees earned for a maximum of four degrees earned or pursued.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
				
				if($error_status==0)
                                {
                                    $n_degree_cond = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id)));
                                    if($n_degree_cond>4)
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'You have already added 4 Major degrees.')  ;
                                        echo json_encode($json_msg);
                                        $error_status=1;
                                        exit; 
                                    }
                                    else
                                    {
                                            if($school_id=='' && $degree_subject_id!='')
                                            {   
                                                if($school_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter School name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }
                                                else if($degree_subject_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any degree subject')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                            
                                                }
                                                 
                                                
                                                $data_to_be_saved['School']['school_name'] = $school_name;
                                                $data_to_be_saved['School']['status'] = 0;
                                                $data_to_be_saved['School']['created_date'] = date('Y-m-d h:i:s');
                                                //$data_to_be_saved['University']['modified'] = date('Y-m-d h:i:s');
                                                if ($this->School->save($data_to_be_saved))
                                                {
                                                    $new_school_id=$this->School->getLastInsertID();

                                                    $data_to_be_saved1['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved1['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved1['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved1['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved1['TutorDegree']['school_id'] = $new_school_id;
                                                    $data_to_be_saved1['TutorDegree']['degree_subject_id'] = $degree_subject_id;
                                                    $data_to_be_saved1['TutorDegree']['status'] = 0;
                                                    $data_to_be_saved1['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved1))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'New Degree added successfully.Please wait for verify.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in degree table.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not saved in School.')  ;
                                                    echo json_encode($json_msg);
                                                    exit; 
                                                }
                                            }
                                            else if($school_id!='' && $degree_subject_id=='')
                                            {   
                                                
                                        
                                               
                                                $data_to_be_saved['DegreeSubject']['name'] =$degree_subject_name;
                                                $data_to_be_saved['DegreeSubject']['status'] =0;
                                                $data_to_be_saved['DegreeSubject']['created'] = date('Y-m-d h:i:s');

                                               
                                                if($this->DegreeSubject->save($data_to_be_saved))
                                                {
                                                    $new_degree_subject_id=$this->DegreeSubject->getLastInsertID();

                                                    $data_to_be_saved1['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved1['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved1['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved1['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved1['TutorDegree']['school_id'] = $school_id;
                                                    $data_to_be_saved1['TutorDegree']['degree_subject_id'] = $new_degree_subject_id;
                                                    $data_to_be_saved1['TutorDegree']['status'] = 0;
                                                    $data_to_be_saved1['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved1))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'New Degree added successfully.Please wait for verify.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in degree table.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not saved in DegreeSubject table.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;
                                                }
                                                
                                                
                                            }
                                            else if($school_id=='' && $degree_subject_id=='')
                                            {
                                                
                                                if($school_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter School name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }
                                                else if($degree_subject_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter degree Subject name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }

                                                $data_to_be_saved['School']['school_name'] = $school_name;
                                                $data_to_be_saved['School']['status'] = 0;
                                                $data_to_be_saved['School']['created_date'] = date('Y-m-d h:i:s');    
                                                if ($this->School->save($data_to_be_saved))
                                                {
                                                    
                                                        $data_to_be_saved1['DegreeSubject']['name'] =$degree_subject_name;
                                                        $data_to_be_saved1['DegreeSubject']['status'] =0;
                                                        $data_to_be_saved1['DegreeSubject']['created'] = date('Y-m-d h:i:s');

                                                       
                                                        if($this->DegreeSubject->save($data_to_be_saved1))
                                                        {   
                                                            $new_school_id=$this->School->getLastInsertID();
                                                            

                                                            $new_degree_subject_id=$this->DegreeSubject->getLastInsertID();
                                                            //pr($new_school_id);pr($new_degree_subject_id);exit();
                                                            $data_to_be_saved2['TutorDegree']['user_id'] =$user_id;
                                                            $data_to_be_saved2['TutorDegree']['completion'] =$completion;
                                                            $data_to_be_saved2['TutorDegree']['year'] =$year;
                                                            $data_to_be_saved2['TutorDegree']['degree_id'] = $degree;

                                                            $data_to_be_saved2['TutorDegree']['school_id'] = $new_school_id;
                                                            $data_to_be_saved2['TutorDegree']['degree_subject_id'] = $new_degree_subject_id;
                                                            $data_to_be_saved2['TutorDegree']['status'] = 0;
                                                            $data_to_be_saved2['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                           // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                            if($this->TutorDegree->save($data_to_be_saved2))
                                                            {
                                                                $json_msg = array('status'=>1,'msg'=>'New Degree added successfully.Please wait for verify.')  ;
                                                                echo json_encode($json_msg);
                                                                exit;
                                                            }
                                                            else
                                                            {
                                                                $json_msg = array('status'=>0,'msg'=>'Data not saved in degree table.')  ;
                                                                echo json_encode($json_msg);
                                                                exit;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $json_msg = array('status'=>0,'msg'=>'Data not saved in DegreeSubject table.')  ;
                                                            echo json_encode($json_msg);
                                                            exit;
                                                        }
                                                    
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not saved in School.')  ;
                                                    echo json_encode($json_msg);
                                                    exit; 
                                                }
                                               
                                            }
                                            else if($school_id!='' && $degree_subject_id!='')
                                            {

                                                if($school_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any school')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                }

                                                else if($degree_subject_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any degree subject')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                            
                                                }
                                                    $data_to_be_saved['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved['TutorDegree']['school_id'] = $school_id;
                                                    $data_to_be_saved['TutorDegree']['degree_subject_id'] = $degree_subject_id;
                                                    $data_to_be_saved['TutorDegree']['status'] = 1;
                                                    $data_to_be_saved['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'Major/degree added sucessfully.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not saved in degree table.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                            }
                                    }
                                }
                               
                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
                

            }
        }
	
	
    /********** 3RD MILE STONE START **********/
	
    public function allTutorProfileEdit()  /* ALL DATA OF TUTOR FETCHED WITH THIS SERVICE. */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }


                    
                   // echo ($user_type);exit();
                if(isset($device_id) && isset($user_id))
                {

                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>2,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
			    else
			    {
				$this->TutorCourse->bindModel(
						array(
				    
						    "belongsTo"=>array(
							"University"=>array('foreignKey'=>false,
							'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
							'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
							'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
							'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
								    
							    )
							),false
							    
					     );
    
		    $data_all_course=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.status'=>1,'TutorCourse.availibility'=>1,'TutorCourse.user_id'=>$user_id)));
				
				
				$this->TutorDegree->bindModel(

                                                array(

                                                    "belongsTo"=>array(
                                                        "School"=>array('foreignKey'=>false,
                                                        'className'=>"School",'conditions' => array("TutorDegree.school_id=School.id"), 'type' => 'LEFT'),
                                                        'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
                                                        'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
                                                                    
                                                            )
                                                        ),false
                                                 
                                             );
                             
                                    $data_all_degree=$this->TutorDegree->find('all',array('fields'=>array('TutorDegree.*','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('TutorDegree.user_id'=>$user_id,'TutorDegree.status'=>1)));
				    
				if($n_user['User']['prof_image']!='')
				$n_user['User']['prof_image']=BASE_URL.'uploads/ProfImage/'.$n_user['User']['prof_image'];
				$show_all['user_details']=$n_user;
				$show_all['tutor_course_details']=$data_all_course;
				$show_all['tutor_degree_details']=$data_all_degree;
				
				//pr($show_all); exit;
				if(!empty($show_all))
				{
				    $json_msg = array('status'=>1,'msg'=>'All data fetched of tutor.','data'=>$show_all)  ;
				    echo json_encode($json_msg);
				    exit;
				}
				else
				{
				    $json_msg = array('status'=>0,'msg'=>'No data found.')  ;
				    echo json_encode($json_msg);
				    exit;
				}
				
			    }
			    
			}
		}
		else
		{
		    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		    echo json_encode($json_msg);
		    exit;
 
		}
	    }
    }
    
    
    public function editUserDetails()
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $user_id 	    = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $user_name 	    = isset($this->request->data['user_name'])?trim($this->request->data['user_name']):"";
	    $charge 	    = isset($this->request->data['charge_per_hour'])?trim($this->request->data['charge_per_hour']):"";
	    $profile_quotes = isset($this->request->data['profile_quotes'])?trim($this->request->data['profile_quotes']):"";
	    $device_id 	    = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;  
	    }
	    else if($user_name =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Username Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($charge =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Charges per hour required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit; 
	    }
	    else if($profile_quotes =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Profile quotes required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;  
	    }
	    
	    /* FIRST NAME AND LAST NAME  MAKING FROM USERNAME */
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		//pr($n_user);exit();
		//pr($this->User->getDataSource()->getLog(TRUE));exit;
		//echo $n_user ;exit();
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
    
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$username_arr = explode(' ',$user_name);
			$first_name	  = $username_arr[0];	
			$last_name	  = $username_arr[1];
			
			$this->request->data['id'] 	       = $user_id;
			$this->request->data['first_name'] = $first_name;
			$this->request->data['last_name']  = $last_name;
			
			$data_to_be_saved = $this->request->data;
			//pr($data_to_be_saved); exit;
			if($this->User->save($data_to_be_saved))
			{
			    $json_msg = array('status'=>1,'msg'=>'Profile updated successfully.')  ;
			    echo json_encode($json_msg);
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'Profile not updated.Please try again.')  ;
			    echo json_encode($json_msg);
			}
			exit;
		    }
		}
	    }
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;

	    }
    	}
	    
    }
    
    public function tutorEditCourseUpdate()
    {
	
	if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
                $subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
                $subject_name = isset($this->request->data['subject_name'])?trim($this->request->data['subject_name']):"";
                $subject_code_id = isset($this->request->data['subject_code_id'])?trim($this->request->data['subject_code_id']):"";
                $subject_code_name = isset($this->request->data['subject_code_name'])?trim($this->request->data['subject_code_name']):"";
                $subject_professor_id = isset($this->request->data['subject_professor_id'])?trim($this->request->data['subject_professor_id']):"";
                $subject_professor_name = isset($this->request->data['subject_professor_name'])?trim($this->request->data['subject_professor_name']):"";
                $grade = isset($this->request->data['grade'])?trim($this->request->data['grade']):"";
		$course_id = isset($this->request->data['course_id'])?trim($this->request->data['course_id']):"";


                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
		    
		    else if($course_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Course Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
		    
                    else if($grade =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Grade Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($university_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'University Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

		    //echo ($user_type);exit();
                    if(isset($device_id) && isset($user_id))
                    {
			$already_exist = $this->TutorCourse->find('count', array('conditions' => array('TutorCourse.subject_id'=>$subject_id,'TutorCourse.subject_code_id'=>$subject_code_id,'TutorCourse.subject_professor_id'=>$subject_professor_id,'TutorCourse.user_id'=>$user_id,'TutorCourse.id !='=>$course_id)));
			
			if($already_exist >0)
			{
			    $json_msg = array('status'=>2,'msg'=>'Course already added. Tap the course in your list to edit details.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
			}
			
                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        //pr($n_user);exit();
                        //pr($this->User->getDataSource()->getLog(TRUE));exit;
                        //echo $n_user ;exit();
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            {   
                                if($subject_id=='' && $subject_code_id=='' && $subject_professor_id=='')
                                {   
                                    if($subject_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                     if($subject_code_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Code name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                     if($subject_professor_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    $data_to_be_saved['Subject']['university_id'] =$university_id;
                                    $data_to_be_saved['Subject']['subject_name'] = $subject_name;
                                    $data_to_be_saved['Subject']['status'] = 0;
                                    $data_to_be_saved['Subject']['created'] = date('Y-m-d h:i:s');
                                    $data_to_be_saved['Subject']['modified'] = date('Y-m-d h:i:s');
                                    if ($this->Subject->save($data_to_be_saved))
                                    {
                                        $new_subject_id=$this->Subject->getLastInsertID();

                                        $data_to_be_saved1['SubjectCode']['university_id'] =$university_id;
                                        $data_to_be_saved1['SubjectCode']['subject_id'] =$new_subject_id;

                                        $data_to_be_saved1['SubjectCode']['sub_code'] = $subject_code_name;
                                        $data_to_be_saved1['SubjectCode']['status'] = 0;
                                        $data_to_be_saved1['SubjectCode']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved1['SubjectCode']['modified'] = date('Y-m-d h:i:s');
                                        if($this->SubjectCode->save($data_to_be_saved1))
                                        {
                                            $new_subject_code_id=$this->SubjectCode->getLastInsertID();

                                            $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                            $data_to_be_saved2['SubjectProfessor']['subject_id'] = $new_subject_id;
                                            $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $new_subject_code_id;
                                            $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                            $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                            $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                            $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                            if($this->SubjectProfessor->save($data_to_be_saved2))
                                            {
                                                $new_professor_id=$this->SubjectProfessor->getLastInsertID();
						
						$data_to_course2['TutorCourse']['id']=$course_id;
                                                $data_to_course2['TutorCourse']['user_id']=$user_id;
                                                $data_to_course2['TutorCourse']['university_id']=$university_id;
                                                $data_to_course2['TutorCourse']['subject_id']=$new_subject_id;
                                                $data_to_course2['TutorCourse']['subject_code_id']=$new_subject_code_id;
                                                $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                                $data_to_course2['TutorCourse']['grade']=$grade;
                                                $data_to_course2['TutorCourse']['status']=0;
						$data_to_course2['TutorCourse']['verified']=0;
                                                $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                                $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                                if ($this->TutorCourse->save($data_to_course2))
                                                {
                                                    $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not updated in tutor as new entry.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;   
                                                }

                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject_professor.')  ;
                                                echo json_encode($json_msg);
                                                exit; 
                                            }
                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject_code.')  ;
                                            echo json_encode($json_msg);
                                            exit;
                                        }
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject.')  ;
                                        echo json_encode($json_msg);
                                        exit; 
                                    }
                                }
                                else if($subject_code_id=='' && $subject_professor_id=='')
                                {   
                                    if($subject_code_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Code name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    if($subject_professor_name =='')
                                    {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                    }
                                    $data_to_be_saved1['SubjectCode']['university_id'] =$university_id;
                                    $data_to_be_saved1['SubjectCode']['subject_id'] =$subject_id;
                                    $data_to_be_saved1['SubjectCode']['sub_code'] = $subject_code_name;
                                    $data_to_be_saved1['SubjectCode']['status'] = 0;
                                    $data_to_be_saved1['SubjectCode']['created'] = date('Y-m-d h:i:s');
                                    $data_to_be_saved1['SubjectCode']['modified'] = date('Y-m-d h:i:s');
                                    if($this->SubjectCode->save($data_to_be_saved1))
                                    {
                                        $new_subject_code_id=$this->SubjectCode->getLastInsertID();

                                        $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_id'] = $subject_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $new_subject_code_id;
                                        $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                        $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                        $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                        if($this->SubjectProfessor->save($data_to_be_saved2))
                                        {
                                            $new_professor_id=$this->SubjectProfessor->getLastInsertID();
					    
					    $data_to_course2['TutorCourse']['id']=$course_id;
                                            $data_to_course2['TutorCourse']['user_id']=$user_id;
                                            $data_to_course2['TutorCourse']['university_id']=$university_id;
                                            $data_to_course2['TutorCourse']['subject_id']=$subject_id;
                                            $data_to_course2['TutorCourse']['subject_code_id']=$new_subject_code_id;
                                            $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                            $data_to_course2['TutorCourse']['grade']=$grade;
                                            $data_to_course2['TutorCourse']['status']=0;
					    $data_to_course2['TutorCourse']['verified']=0;
                                            $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                            $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                            if ($this->TutorCourse->save($data_to_course2))
                                            {
                                                $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not updated in tutor as new entry.')  ;
                                                echo json_encode($json_msg);
                                                exit;   
                                            }

                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject_professor.')  ;
                                            echo json_encode($json_msg);
                                            exit; 
                                        }
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject_code.')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                    }
                                    
                                    
                                }
                                else if($subject_professor_id=='')
                                {
                                    
                                        if($subject_professor_name =='')
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Enter Subject Professor Name')  ;
                                            echo json_encode($json_msg);
                                            $error_status=1;
                                            exit;
                                        }
                                        $data_to_be_saved2['SubjectProfessor']['university_id'] =$university_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_id'] = $subject_id;
                                        $data_to_be_saved2['SubjectProfessor']['subject_code_id'] = $subject_code_id;
                                        $data_to_be_saved2['SubjectProfessor']['professor_name'] = $subject_professor_name;
                                        $data_to_be_saved2['SubjectProfessor']['status'] = 0;
                                        $data_to_be_saved2['SubjectProfessor']['created'] = date('Y-m-d h:i:s');
                                        $data_to_be_saved2['SubjectProfessor']['modified'] = date('Y-m-d h:i:s');

                                        if($this->SubjectProfessor->save($data_to_be_saved2))
                                        {
                                            $new_professor_id=$this->SubjectProfessor->getLastInsertID();
					    
					    $data_to_course2['TutorCourse']['id']=$course_id;
                                            $data_to_course2['TutorCourse']['user_id']=$user_id;
                                            $data_to_course2['TutorCourse']['university_id']=$university_id;
                                            $data_to_course2['TutorCourse']['subject_id']=$subject_id;
                                            $data_to_course2['TutorCourse']['subject_code_id']=$subject_code_id;
                                            $data_to_course2['TutorCourse']['subject_professor_id']=$new_professor_id;
                                            $data_to_course2['TutorCourse']['grade']=$grade;
                                            $data_to_course2['TutorCourse']['status']=0;
					    $data_to_course2['TutorCourse']['verified']=0;
                                            $data_to_course2['TutorCourse']['created']=date('Y-m-d h:i:s');
                                            $data_to_course2['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                            if ($this->TutorCourse->save($data_to_course2))
                                            {
                                                $json_msg = array('status'=>1,'msg'=>'New Course added successfully.Please wait for verify.')  ;
                                                echo json_encode($json_msg);
                                                exit;
                                            }
                                            else
                                            {
                                                $json_msg = array('status'=>0,'msg'=>'Data not updated in tutor as new entry.')  ;
                                                echo json_encode($json_msg);
                                                exit;   
                                            }

                                        }
                                        else
                                        {
                                            $json_msg = array('status'=>0,'msg'=>'Data not updated in Subject_professor.')  ;
                                            echo json_encode($json_msg);
                                            exit; 
                                        }
                                    
                                   
                                }
                                else
                                {
				    $data_to_course['TutorCourse']['id']=$course_id;
                                    $data_to_course['TutorCourse']['user_id']=$user_id;
                                    $data_to_course['TutorCourse']['university_id']=$university_id;
                                    $data_to_course['TutorCourse']['subject_id']=$subject_id;
                                    $data_to_course['TutorCourse']['subject_code_id']=$subject_code_id;
                                    $data_to_course['TutorCourse']['subject_professor_id']=$subject_professor_id;
                                    $data_to_course['TutorCourse']['grade']=$grade;
                                    $data_to_course['TutorCourse']['status']=1;
				    $data_to_course2['TutorCourse']['verified']=0;
                                    $data_to_course['TutorCourse']['created']=date('Y-m-d h:i:s');
                                    $data_to_course['TutorCourse']['modified']=date('Y-m-d h:i:s');
                                    if ($this->TutorCourse->save($data_to_course))
                                    {
                                        $json_msg = array('status'=>1,'msg'=>'Course updated successfully')  ;
                                        echo json_encode($json_msg);
                                        exit;
                                    }
                                    else
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in tutor.')  ;
                                        echo json_encode($json_msg);
                                        exit;   
                                    }
                                }

                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
            }
    
    
    }
    
    
    public function tutorEditCourseData()
    {
	
	if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
		$course_id = isset($this->request->data['course_id'])?trim($this->request->data['course_id']):"";
		$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
		
		if($course_id =='')
		{
		    $json_msg = array('status'=>0,'msg'=>'Course Id Required')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else if($user_id =='')
                {
		    $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
                                
                }
		
		$this->TutorCourse->bindModel(
						array(
				    
						    "belongsTo"=>array(
							"University"=>array('foreignKey'=>false,
							'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
							'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
							'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
							'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
								    
							    )
							),false
							    
					     );
    
		    $data_all=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.id'=>$course_id,'TutorCourse.status'=>1,'TutorCourse.user_id'=>$user_id)));
		    //pr($data_all);
		    if(!empty($data_all))
		    {
			$json_msg = array('status'=>1,'msg'=>'Data successfully fetched.','data'=>$data_all)  ;
			echo json_encode($json_msg);
			exit;
		    }
		    else
		    {
			$json_msg = array('status'=>0,'msg'=>'No data found.')  ;
			echo json_encode($json_msg);
			exit;
		    }
	    }
    }
    
    public function tutorEditDegreeData()
    {
	
	if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
		$degree_id = isset($this->request->data['degree_id'])?trim($this->request->data['degree_id']):"";
		$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
		
		if($degree_id =='')
		{
		    $json_msg = array('status'=>0,'msg'=>'Degree Id Required')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else if($user_id =='')
                {
		    $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
                                
                }
		
		$this->TutorDegree->bindModel(

                                                array(

                                                    "belongsTo"=>array(
                                                        "School"=>array('foreignKey'=>false,
                                                        'className'=>"School",'conditions' => array("TutorDegree.school_id=School.id"), 'type' => 'LEFT'),
                                                        'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
                                                        'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
                                                                    
                                                            )
                                                        ),false
                                                 
                                             );
                             
                                    $data_all=$this->TutorDegree->find('all',array('fields'=>array('TutorDegree.id','TutorDegree.school_id','TutorDegree.degree_id','TutorDegree.degree_subject_id','TutorDegree.completion','TutorDegree.year','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('TutorDegree.user_id'=>$user_id,'TutorDegree.id'=>$degree_id)));
				    
		    //pr($data_all);
		    if(!empty($data_all))
		    {
			$json_msg = array('status'=>1,'msg'=>'Data successfully fetched.','data'=>$data_all)  ;
			echo json_encode($json_msg);
			exit;
		    }
		    else
		    {
			$json_msg = array('status'=>0,'msg'=>'No data found.')  ;
			echo json_encode($json_msg);
			exit;
		    }
	    }
    }
    
    
    
    
    public function tutorEditDegreeUpdate()
        {
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {

		$tutor_degree_id = isset($this->request->data['tutor_degree_id'])?trim($this->request->data['tutor_degree_id']):"";
                $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
                $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
                $completion = isset($this->request->data['completion'])?trim($this->request->data['completion']):"";
                $degree = isset($this->request->data['degree'])?trim($this->request->data['degree']):"";
                $year = isset($this->request->data['year'])?trim($this->request->data['year']):"";
                $school_id = isset($this->request->data['school_id'])?trim($this->request->data['school_id']):"";
                $school_name = isset($this->request->data['school_name'])?trim($this->request->data['school_name']):"";
                $degree_subject_id = isset($this->request->data['degree_subject_id'])?trim($this->request->data['degree_subject_id']):"";
                $degree_subject_name = isset($this->request->data['degree_subject_name'])?trim($this->request->data['degree_subject_name']):"";

		
		
                $error_status=0;
                /* Null Field Checking Start */
                    if($device_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Device Id required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                    }

                    else if($user_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'User Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($completion =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Completion Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($degree =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Degree Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
                    else if($year =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Year Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }
		    else if($tutor_degree_id =='')
                    {
                        $json_msg = array('status'=>0,'msg'=>'Tutor Degree Id Required')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
                                
                    }

		    /* valid Id or not checking */
		    $tutor_id_exist = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.id'=>$tutor_degree_id)));
		    
                    if($tutor_id_exist<1)
		    {
			$json_msg = array('status'=>0,'msg'=>'Tutor Id Not Found')  ;
                        echo json_encode($json_msg);
                        $error_status=1;
                        exit;
		    }
                    
                   
                    if(isset($device_id) && isset($user_id))
                    {

			$already_exist = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.school_id'=>$school_id,'TutorDegree.degree_id'=>$degree,'TutorDegree.degree_subject_id'=>$degree_subject_id,'TutorDegree.user_id'=>$user_id)));
			
//			if($already_exist >0)
//			{
//			    $json_msg = array('status'=>2,'msg'=>'Degree already added. Tap the course in your list to edit details.')  ;
//                            echo json_encode($json_msg);
//                            $error_status=1;
//                            exit;
//			}
			
                        $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                        
                        if($n_user_status==0)
                        {
                            $json_msg = array('status'=>0,'msg'=>'Account blocked by admin.')  ;
                            echo json_encode($json_msg);
                            $error_status=1;
                            exit;
                        }
                        else
                        {

                            $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
                            
                            $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
                            //pr($n_device_status);exit();
                            if($n_device_status==0)
                            {
                                $json_msg = array('status'=>0,'msg'=>'Please log in again.')  ;
                                echo json_encode($json_msg);
                                $error_status=1;
                                exit; 
                            }
                            else
                            { 
                                $n_degree_ear = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Earned')));
                                $n_degree_pur = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Pursuing')));
				
				$n_degree_ear_plus = 0;
				$n_degree_pur_plus = 0;
				
				if($completion=="Earned")
				{
				    $n_degree_ear = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Earned','TutorDegree.id!='.$tutor_degree_id)));    
				    $n_degree_ear_plus = $n_degree_ear + 1;
				}
				if($completion=="Pursuing"){
				    
				     $n_degree_pur = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.completion'=>'Pursuing','TutorDegree.id!='.$tutor_degree_id)));
				    $n_degree_pur_plus = $n_degree_pur + 1;
				    
				}
				
				if($n_degree_ear_plus >2)
                                {
                                    $json_msg = array('status'=>0,'msg'=>' You can add up to 2 earned degrees .')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
				if($n_degree_pur_plus >2)
                                {
                                    $json_msg = array('status'=>0,'msg'=>' You can add up to 2 pursuded degrees.')  ;
                                    echo json_encode($json_msg);
                                    $error_status=1;
                                    exit;
                                }
				
				if($error_status==0)
                                {
                                    $n_degree_cond = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id)));
                                    if($n_degree_cond>4)
                                    {
                                        $json_msg = array('status'=>0,'msg'=>'You have already added 4 Major degrees.')  ;
                                        echo json_encode($json_msg);
                                        $error_status=1;
                                        exit; 
                                    }
                                    else
                                    {
                                            if($school_id=='' && $degree_subject_id!='')
                                            {   
                                                if($school_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter School name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }
                                                else if($degree_subject_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any degree subject')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                            
                                                }
                                                 
                                                
                                                $data_to_be_saved['School']['school_name'] = $school_name;
                                                $data_to_be_saved['School']['status'] = 0;
                                                $data_to_be_saved['School']['created_date'] = date('Y-m-d h:i:s');
                                                //$data_to_be_saved['University']['modified'] = date('Y-m-d h:i:s');
                                                if ($this->School->save($data_to_be_saved))
                                                {
                                                    $new_school_id=$this->School->getLastInsertID();
						    
						    $data_to_be_saved1['TutorDegree']['id'] = $tutor_degree_id;
                                                    $data_to_be_saved1['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved1['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved1['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved1['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved1['TutorDegree']['school_id'] = $new_school_id;
                                                    $data_to_be_saved1['TutorDegree']['degree_subject_id'] = $degree_subject_id;
                                                    $data_to_be_saved1['TutorDegree']['status'] = 0;
						    $data_to_be_saved1['TutorDegree']['verified'] = 0;
                                                    $data_to_be_saved1['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved1))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'Major/degree updated sucessfully.Please wait for verify.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in degree.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not updated in School.')  ;
                                                    echo json_encode($json_msg);
                                                    exit; 
                                                }
                                            }
                                            else if($school_id!='' && $degree_subject_id=='')
                                            {   
                                                
                                        
                                               
                                                $data_to_be_saved['DegreeSubject']['name'] =$degree_subject_name;
                                                $data_to_be_saved['DegreeSubject']['status'] =0;
                                                $data_to_be_saved['DegreeSubject']['created'] = date('Y-m-d h:i:s');

                                               
                                                if($this->DegreeSubject->save($data_to_be_saved))
                                                {
                                                    $new_degree_subject_id=$this->DegreeSubject->getLastInsertID();
						    
						    $data_to_be_saved1['TutorDegree']['id'] = $tutor_degree_id;
                                                    $data_to_be_saved1['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved1['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved1['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved1['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved1['TutorDegree']['school_id'] = $school_id;
                                                    $data_to_be_saved1['TutorDegree']['degree_subject_id'] = $new_degree_subject_id;
                                                    $data_to_be_saved1['TutorDegree']['status'] = 0;
						    $data_to_be_saved1['TutorDegree']['verified'] = 0;
                                                    $data_to_be_saved1['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved1))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'Major/degree updated sucessfully.Please wait for verify.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in degree.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not updated in Degree Subject.')  ;
                                                    echo json_encode($json_msg);
                                                    exit;
                                                }
                                                
                                                
                                            }
                                            else if($school_id=='' && $degree_subject_id=='')
                                            {
                                                
                                                if($school_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter School name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }
                                                else if($degree_subject_name =='')
                                                {
                                                        $json_msg = array('status'=>0,'msg'=>'Enter degree Subject name')  ;
                                                        echo json_encode($json_msg);
                                                        $error_status=1;
                                                        exit;
                                                }

                                                $data_to_be_saved['School']['school_name'] = $school_name;
                                                $data_to_be_saved['School']['status'] = 0;
                                                $data_to_be_saved['School']['created_date'] = date('Y-m-d h:i:s');    
                                                if ($this->School->save($data_to_be_saved))
                                                {
                                                    
                                                        $data_to_be_saved1['DegreeSubject']['name'] =$degree_subject_name;
                                                        $data_to_be_saved1['DegreeSubject']['status'] =0;
                                                        $data_to_be_saved1['DegreeSubject']['created'] = date('Y-m-d h:i:s');

                                                       
                                                        if($this->DegreeSubject->save($data_to_be_saved1))
                                                        {   
                                                            $new_school_id=$this->School->getLastInsertID();
                                                            

                                                            $new_degree_subject_id=$this->DegreeSubject->getLastInsertID();
                                                            //pr($new_school_id);pr($new_degree_subject_id);exit();
							    
							    $data_to_be_saved2['TutorDegree']['id'] = $tutor_degree_id;
                                                            $data_to_be_saved2['TutorDegree']['user_id'] =$user_id;
                                                            $data_to_be_saved2['TutorDegree']['completion'] =$completion;
                                                            $data_to_be_saved2['TutorDegree']['year'] =$year;
                                                            $data_to_be_saved2['TutorDegree']['degree_id'] = $degree;

                                                            $data_to_be_saved2['TutorDegree']['school_id'] = $new_school_id;
                                                            $data_to_be_saved2['TutorDegree']['degree_subject_id'] = $new_degree_subject_id;
                                                            $data_to_be_saved2['TutorDegree']['status'] = 0;
							    $data_to_be_saved2['TutorDegree']['verified'] = 0;
                                                            $data_to_be_saved2['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                           // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                            if($this->TutorDegree->save($data_to_be_saved2))
                                                            {
                                                                $json_msg = array('status'=>1,'msg'=>'Major/degree updated sucessfully.Please wait for verify.')  ;
                                                                echo json_encode($json_msg);
                                                                exit;
                                                            }
                                                            else
                                                            {
                                                                $json_msg = array('status'=>0,'msg'=>'Data not updated in degree.')  ;
                                                                echo json_encode($json_msg);
                                                                exit;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $json_msg = array('status'=>0,'msg'=>'Data not updated in Degree Subject.')  ;
                                                            echo json_encode($json_msg);
                                                            exit;
                                                        }
                                                    
                                                }
                                                else
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Data not updated in School.')  ;
                                                    echo json_encode($json_msg);
                                                    exit; 
                                                }
                                               
                                            }
                                            else if($school_id!='' && $degree_subject_id!='')
                                            {

                                                if($school_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any school')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                }

                                                else if($degree_subject_id =='')
                                                {
                                                    $json_msg = array('status'=>0,'msg'=>'Select any degree subject')  ;
                                                    echo json_encode($json_msg);
                                                    $error_status=1;
                                                    exit;
                                                            
                                                }
						
						    $data_to_be_saved['TutorDegree']['id'] = $tutor_degree_id;
                                                    $data_to_be_saved['TutorDegree']['user_id'] =$user_id;
                                                    $data_to_be_saved['TutorDegree']['completion'] =$completion;
                                                    $data_to_be_saved['TutorDegree']['year'] =$year;
                                                    $data_to_be_saved['TutorDegree']['degree_id'] = $degree;

                                                    $data_to_be_saved['TutorDegree']['school_id'] = $school_id;
                                                    $data_to_be_saved['TutorDegree']['degree_subject_id'] = $degree_subject_id;
                                                    $data_to_be_saved['TutorDegree']['status'] = 1;
						    $data_to_be_saved['TutorDegree']['verified'] = 0;
                                                    $data_to_be_saved['TutorDegree']['created'] = date('Y-m-d h:i:s');
                                                   // $data_to_be_saved1['TutorDegree']['modified'] = date('Y-m-d h:i:s');
                                                    if($this->TutorDegree->save($data_to_be_saved))
                                                    {
                                                        $json_msg = array('status'=>1,'msg'=>'Major/degree updated sucessfully.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                                    else
                                                    {
                                                        $json_msg = array('status'=>0,'msg'=>'Data not updated in degree.')  ;
                                                        echo json_encode($json_msg);
                                                        exit;
                                                    }
                                            }
                                    }
                                }
                               
                            }
                        }
                    }
                    else
                    {
                        $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
                        echo json_encode($json_msg);
                        exit;
     
                    }
            }
        }
	
	

    public function verifiedPreview() /* Verified Tutor profile*/
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {   
			$this->TutorDegree->bindModel(
    
						array(
    
						    "belongsTo"=>array(
							"School"=>array('foreignKey'=>false,
							'className'=>"School",'conditions' => array("School.id=TutorDegree.school_id"), 'type' => 'LEFT'),
							'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
							'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
							    'User' => array('foreignKey' => false, 'className' => 'User', 'conditions' => array('TutorDegree.user_id=User.id'), 'type' => 'LEFT'),       
							    )
						    ),false
						 
						);
			
		    $data= $this->TutorDegree->find("all",array('fields'=>array('User.*','TutorDegree.id','TutorDegree.completion','TutorDegree.year','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('User.id'=>$user_id)));
		    //pr($data); exit;
		    
		    for($i=0; $i<count($data);$i++)
		    {
			$data[$i]['User']['prof_image'] = BASE_URL.'uploads/ProfImage/'.$data[$i]['User']['prof_image'];
			
		    }
			if(!empty($data))
			{
			    $json_msg = array('status'=>1,'msg'=>'All data fetched.','data'=>$data);
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'No data found.')  ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    
    public function courseWithGrade() /* Verified Tutor profile*/
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {   
			$this->TutorCourse->bindModel(
    
						array(
    
						    "belongsTo"=>array(
							"University"=>array('foreignKey'=>false,
							'className'=>"University",'conditions' => array("University.id=TutorCourse.university_id"), 'type' => 'LEFT'),
							'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
							'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
							    'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
							'User' => array('foreignKey' => false, 'className' => 'User', 'conditions' => array('TutorCourse.user_id=User.id'), 'type' => 'LEFT'),       
							    )
						    ),false
						 
						);
			
			
		    $data= $this->TutorCourse->find("all",array('fields'=>array('User.*','TutorCourse.id','TutorCourse.status','TutorCourse.availibility','TutorCourse.grade','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('User.id'=>$user_id,'TutorCourse.availibility'=>1)));
		    //pr($data); exit;
		    
		    for($i=0; $i<count($data);$i++)
		    {
			$data[$i]['User']['prof_image'] = BASE_URL.'uploads/ProfImage/'.$data[$i]['User']['prof_image'];
			
		    }
			if(!empty($data))
			{
			    $json_msg = array('status'=>1,'msg'=>'All data fetched.','data'=>$data);
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'There is no available course.')  ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    
    
    /***************************/
    
    /***************************listing of unverified Degree and course Start**********************************/
    
    public function courseDegreeWithoutVerify() /* List of unverified Course and Degree */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    
	    $error_status=0;
	/* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
    
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	   // echo ($user_type);exit();
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
    
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			/* For Unverified Course list of perticular user */
			$this->TutorCourse->bindModel(
							array(
					    
							    "belongsTo"=>array(
								"University"=>array('foreignKey'=>false,
								'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
								'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
								'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
								'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
									    
								    )
								),false
								    
						     );
			
			$data_all_course=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.status'=>1,'TutorCourse.availibility'=>1,'TutorCourse.verified'=>0,'TutorCourse.user_id'=>$user_id)));
			
			/* For Unverified Degree list of perticular user */
			$this->TutorDegree->bindModel(
							array(
		    
							    "belongsTo"=>array(
								"School"=>array('foreignKey'=>false,
								'className'=>"School",'conditions' => array("TutorDegree.school_id=School.id"), 'type' => 'LEFT'),
								'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
								'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
									    
								    )
								),false
							 
						     );
			$data_all_degree = $this->TutorDegree->find('all',array('fields'=>array('TutorDegree.id','TutorDegree.completion','TutorDegree.year','TutorDegree.photo','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('TutorDegree.user_id'=>$user_id,'TutorDegree.status'=>1,'TutorDegree.verified'=>0)));
	    
	    if(!empty($data_all_course))
	    {
		for($i=0;$i<count($data_all_course);$i++)
		{
		    //pr($data_all_course[0]); exit;
		    //echo $data_all_course[0]['TutorDegree']['photo'];exit;
		    if($data_all_course[$i]['TutorCourse']['photo'] !='')
		    {
			$data_all_course[$i]['TutorCourse']['photo'] = BASE_URL.'uploads/course_photo/'.$data_all_course[$i]['TutorCourse']['photo'];
			$data_all_course[$i]['TutorCourse']['flag_status'] = 1;
		    }
		    
		    else
		    {
			$data_all_course[$i]['TutorCourse']['photo'] = BASE_URL.'img/na.jpg';
			$data_all_course[$i]['TutorCourse']['flag_status'] = 0;
		    }
		    
		}
	    }
	    $show_all['tutor_course_details']=$data_all_course;
	    
	    if(!empty($data_all_degree))
	    {
		for($i=0;$i<count($data_all_degree);$i++)
		{
		    //pr($data_all_course[0]); exit;
		    //echo $data_all_course[0]['TutorDegree']['photo'];exit;
		    if($data_all_degree[$i]['TutorDegree']['photo'] !='')
		    {
			$data_all_degree[$i]['TutorDegree']['photo'] = BASE_URL.'uploads/degree_photo/'.$data_all_degree[$i]['TutorDegree']['photo'];
			$data_all_degree[$i]['TutorDegree']['flag_status'] = 1;
		    }
		    
		    else
		    {
			$data_all_degree[$i]['TutorDegree']['photo'] = BASE_URL.'img/na.jpg';
			$data_all_degree[$i]['TutorDegree']['flag_status'] = 0;
		    }
		    
		}
	    }
	    $show_all['tutor_degree_details']=$data_all_degree;
	    $show_all['user_details']=$n_user;	
			if(!empty($show_all))
			{
			    $json_msg = array('status'=>1,'msg'=>'All data fetched of tutor.','data'=>$show_all)  ;
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'No data found.')  ;
			    echo json_encode($json_msg);
			    exit;
			}	
		    } /* Else end Device Id matched*/
		} /* Else end active by admin*/
	    }/* If End Device Id set*/
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	} /* Request Method Post End*/
    }
    
    /***************************listing of unverified Degree and course End**********************************/

public function uploadDegreeCourseImage() /* List of unverified Course and Degree */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $table = isset($this->request->data['table'])?trim($this->request->data['table']):""; /* tutor_degrees or tutor_courses*/
	    $updated_id = isset($this->request->data['updated_id'])?trim($this->request->data['updated_id']):"";
	    $fileInput = (!empty($_FILES['fileInput']['name']))?trim($_FILES['fileInput']['name']):"";
	    
	    $error_status=0;
	/* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
    
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    else if($updated_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Uploaded Id Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    else if($table =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Please Mention Course or Degree.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    if($table == 'tutor_degrees')
	    {
		$has_id = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.id'=>$updated_id,'TutorDegree.user_id'=>$user_id)));
		if($has_id == 0)
		{
		    $json_msg = array('status'=>2,'msg'=>'You are requesting for wrong Degree.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		
	    }
	    else if($table == 'tutor_courses')
	    {
		$has_id = $this->TutorCourse->find('count', array('conditions' => array('TutorCourse.id'=>$updated_id,'TutorCourse.user_id'=>$user_id)));
		if($has_id == 0)
		{
		    $json_msg = array('status'=>2,'msg'=>'You are requesting for wrong Course.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
	    }
	    
	    
	   // echo ($user_type);exit();
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			if($fileInput !='')
			{	
			    $filename=$_FILES['fileInput']['name'];
			    $file_arr=explode('.',$filename);
			    $ext=$file_arr[count($file_arr)-1];
			    $tmp=$_FILES['fileInput']['tmp_name'];
			    $filename=rand(100,999).time().$user_id.'.'.$ext;
			    if($table =='tutor_degrees')
			    {
				$folder="./uploads/tmp_folder/";
			    }
			    else if($table =='tutor_courses')
			    {
				$folder="./uploads/tmp_folder/";
			    }
			    $path=$folder.$filename;
			    if(!move_uploaded_file($tmp,$path))
			    {
				$error_status =1;
				$return_arr=array('status'=>0,'msg'=>'File not uploaded.');
				echo json_encode($return_arr);
				exit;
			    }
			    else
			    {
				$return_arr=array('status'=>1,'msg'=>'File Uploaded Successfully.','data'=>BASE_URL.$folder.$filename,'request_id'=>$updated_id,'image_name'=>$filename);
				echo json_encode($return_arr);
				exit;
			    }
			}
			else
			{
			    $error_status =1;
			    $return_arr=array('status'=>2,'msg'=>'Please select file.');
			    echo json_encode($return_arr);
			    exit;
			}
				
		    } /* Else end Device Id matched*/
		} /* Else end active by admin*/
	    }/* If End Device Id set*/
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	} /* Request Method Post End*/
    }
    
    
    public function updateAllPhoto() /* Update All the Course And Degree Photoes. */
    {
    	$srcPath = 'uploads/tmp_folder/';
	$degree_destPath = 'uploads/degree_photo/';
	$course_destPath = 'uploads/course_photo/';
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    
	    /*DATA WILL COME FROM MOBILE LIKE THIS :: 'tutor_degrees_id-tutor_degrees-image_name' or 'tutor_courses_id-tutor_courses-image_name' ==> like '45-tutor_degrees-80178254898.jpg, 46-tutor_degrees-80278254898.jpg, 10-tutor_courses-80578254898.jpg,'*/
	    $data = isset($this->request->data['all_data'])?trim($this->request->data['all_data']):"";
 
	    $error_status=0;
	/* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    else if($data =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Please Mention Course or Degree.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    
	   // echo ($user_type);exit();
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$data_arr = explode(',',$data);
			$update_err = 0;
			foreach($data_arr as $each_data)
			{
			    
			   $each_data_arr = explode('-',$each_data); //'tutor_degrees_id-tutor_degrees-image_name' or 'tutor_courses_id-tutor_courses-image_name'
			   if($each_data_arr[1]=='tutor_degrees')
			   {
				if(copy($srcPath.$each_data_arr[2],$degree_destPath.$each_data_arr[2]))
				{
				    $this->TutorDegree->updateAll(array('TutorDegree.photo'=>"'".$each_data_arr[2]."'"),array('TutorDegree.id'=>$each_data_arr[0]));
				    //pr($this->TutorDegree->getDataSource()->getLog(TRUE)); exit;
				    $update_err =1;
				    
				}
				else
				{
				    $json_msg = array('status'=>0,'msg'=>'File not uploaded.')  ;
				    echo json_encode($json_msg);
				    exit;
				}
			   }
			   else if($each_data_arr[1]=='tutor_courses')
			   {
			    
				if(copy($srcPath.$each_data_arr[2],$course_destPath.$each_data_arr[2]))
				{
				    //echo $each_data_arr[1]."upload"; exit;
				    $this->TutorCourse->updateAll(array('TutorCourse.photo'=>"'".$each_data_arr[2]."'"),array('TutorCourse.id'=>$each_data_arr[0]));
				    //pr($this->TutorCourse->getDataSource()->getLog(TRUE)); exit;
				    $update_err =1;
				}
				else
				{
				    $json_msg = array('status'=>0,'msg'=>'File not uploaded.')  ;
				    echo json_encode($json_msg);
				    exit;
				}
			   }
			}
			if($update_err == 1)
			{
			    $cmd = "wget -bq --spider ".BASE_URL."services/send_upload_mail?user_id=".$user_id;
			    shell_exec(escapeshellcmd($cmd));
			    
			    
			    $json_msg = array('status'=>1,'msg'=>'Successfully submitted for verify.Please wait for admin\'s approval')  ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } /* Else end Device Id matched*/
		} /* Else end active by admin*/
	    }/* If End Device Id set*/
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	} /* Request Method Post End*/
    }
    
     public function test_boom(){
	
	$cmd = "wget -bq --spider ".BASE_URL."services/teacher_mail?parameter=1389870@@amit.unified@gmail.com@@1@@amit@@amit.unified@gmail.com@@123456789";
	shell_exec(escapeshellcmd($cmd));
	echo BASE_URL."services/teacher_mail?parameter=1389870@@amit.unified@gmail.com@@1@@amit@@amit.unified@gmail.com@@123456789";
    }
    
    public function spider_fun(){
	
	$cmd = "wget -bq --spider ".BASE_URL."services/send_upload_mail?user_id=1";
	shell_exec(escapeshellcmd($cmd));
	echo BASE_URL."services/send_upload_mail?user_id=1";
    }
    
    public function spider_fun_test(){
	
	$arr = array(1,2,3);
	$json_en = implode("@@",$arr);
	$cmd = "wget -bq --spider ".BASE_URL."services/send_upload_mail_test?param=".$json_en;
	shell_exec(escapeshellcmd($cmd));
	echo BASE_URL."services/send_upload_mail_test?param=".$json_en;
    }
    // Send Upload Mail
    public function send_upload_mail_test(){
	
	$param = $_REQUEST['param'];
	$Email = new CakeEmail();
	$Email->from(array(site_mail_id => 'TutorApp'));
	$Email->to('amit.unified@gmail.com');
	$Email->subject('TutorApp Tutor Degree-Course Verification');
	$Email->emailFormat('html');
	$Email->send($param);
	//@mail('amit.unified@gmail.com','STutorApp Tutor Degree-Course Verification','Check Mail By spider, If I get Mail it means it runs. ');
    }
    // Send Upload Mail
    public function send_upload_mail(){
	
	$user_id = $_REQUEST['user_id'];
	
	$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
	
	$admin_user = $this->User->find('first', array('conditions' => array('User.id'=>1)));
	$mail_msg="<div style='width:80%;'><img src='".BASE_URL."img/coed_logo.jpeg'>
		    <br/>
		    Hello ".$admin_user['User']['first_name'].' '.$admin_user['User']['last_name']." ,
		    <br/>
		      <p>".$n_user['User']['first_name'].' '.$n_user['User']['last_name']." has requested himself as a tutor and requested to verify his profile.Please login to admin to verify the credentials.</p>
		    <p>Warmest Regards,<p/>
		    <p>TutorApp Team<p/>
		    </div>";
		    
	$Email = new CakeEmail();
	$Email->from(array(site_mail_id => 'TutorApp'));
	$Email->to($admin_user['User']['email_id']);
	$Email->subject('TutorApp Tutor Degree-Course Verification');
	$Email->emailFormat('html');
	$Email->send($mail_msg);
	//@mail('amit.unified@gmail.com','STutorApp Tutor Degree-Course Verification','Check Mail By spider, If I get Mail it means it runs. ');
	
    }

/***********************************/

    
    /* Delete Degree Data Start*/
    
    public function deleteDegreeData() 
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $degree_tutor_id =  isset($this->request->data['degree_tutor_id'])?trim($this->request->data['degree_tutor_id']):"";
	   
	    $error_status=0;
	/* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    else if($degree_tutor_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Please Mention Degreetutor Id.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    $tutor_degree = $this->TutorDegree->find('count', array('conditions' => array('TutorDegree.user_id'=>$user_id,'TutorDegree.id'=>$degree_tutor_id)));
	    //pr($tutor_degree); exit;
	    if($tutor_degree == 0)
	    {
		$json_msg = array('status'=>2,'msg'=>'You have no access to delete this degree.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    
	   // echo ($user_type);exit();
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$delete = $this->TutorDegree->deleteAll(array('TutorDegree.id'=>$degree_tutor_id),false);
			//echo $delete; exit;
			if($delete)
			{
			    $json_msg = array('status'=>1,'msg'=>'Degree deleted successfully.')  ;
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'Data not deleted.')  ;
			    echo json_encode($json_msg);
			    $error_status=1;
			    exit;
			    
			}
			
		    } /* Else end Device Id matched*/
		} /* Else end active by admin*/
	    }/* If End Device Id set*/
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	} /* Request Method Post End*/
    }
    
    /* Delete Degree Data End */
    
    /* Delete Course Data Start*/
    
    public function deleteCourseData() 
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $course_tutor_id =  isset($this->request->data['course_tutor_id'])?trim($this->request->data['course_tutor_id']):"";
	   
	    $error_status=0;
	/* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    else if($course_tutor_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Please Mention Coursetutor Id.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    $course_tutor = $this->TutorCourse->find('count', array('conditions' => array('TutorCourse.user_id'=>$user_id,'TutorCourse.id'=>$course_tutor_id)));
	    //pr($tutor_degree); exit;
	    if($course_tutor == 0)
	    {
		$json_msg = array('status'=>2,'msg'=>'You have no access to delete this course.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    
	   // echo ($user_type);exit();
	    if(isset($device_id) && isset($user_id))
	    {
    
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$delete = $this->TutorCourse->deleteAll(array('TutorCourse.id'=>$course_tutor_id),false);
			//echo $delete; exit;
			if($delete)
			{
			    $json_msg = array('status'=>1,'msg'=>'Course deleted successfully.')  ;
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'Course not deleted.')  ;
			    echo json_encode($json_msg);
			    $error_status=1;
			    exit;
			    
			}
			
		    } /* Else end Device Id matched*/
		} /* Else end active by admin*/
	    }/* If End Device Id set*/
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	} /* Request Method Post End*/
    }
    
    /* Delete Course Data End */
    
    
    /*************  Braintree  **********/
    
    public function braintreeConfiguration()
    {
	/*
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('jm9jkfschbbmbhjj');
	Braintree_Configuration::publicKey('ntnkm9xhpddycwbz');
	Braintree_Configuration::privateKey('6bd559c2cf1519eca65e82af52799d6b');
	*/
	/*Sharuk Sandbox Account Details*/
	
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('r2ypxrpct6hh7dx3');
	Braintree_Configuration::publicKey('tkrmbqk66qvh9sr3');
	Braintree_Configuration::privateKey('c68fa643de55b7f85d5dc74757ca1ac0');
	
    }
    
    public function clientTokenGeneration()
    {
	$this->braintreeConfiguration();
	$aCustomerId ='66334126'; //Sharuk Customer Id // can be generated from braintreegateway.com vault->New Customer
	$clientToken = Braintree_ClientToken::generate(array(
	    "customerId" => $aCustomerId
	)); //89278163 Sumitra customer Id
	
	    $json_msg = array('status'=>1,'msg'=>'Get Client Token.','clientToken'=>$clientToken)  ;
	    echo json_encode($json_msg);
	    exit;
    }
    
    public function paymentCheckout()
    {
	$srcPath = 'uploads/tmp_folder/';
	$degree_destPath = 'uploads/degree_photo/';
	$course_destPath = 'uploads/course_photo/';
	$this->braintreeConfiguration(); /* Braintree configuration details */
	$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	$nonce = isset($this->request->data['payment_method_nonce'])?trim($this->request->data['payment_method_nonce']):"";//The nonce is 	792ccbb8-068e-44a7-9031-c62a491a6de8
	$amount = isset($this->request->data['amount'])?trim($this->request->data['amount']):"";
	//$user_name = isset($this->request->data['user_name'])?trim($this->request->data['user_name']):"";
	//$email = isset($this->request->data['email'])?trim($this->request->data['email']):"";
	/*DATA WILL COME FROM MOBILE LIKE THIS :: 'tutor_degrees_id-tutor_degrees-image_name' or 'tutor_courses_id-tutor_courses-image_name' ==> like '45-tutor_degrees-80178254898.jpg, 46-tutor_degrees-80278254898.jpg, 10-tutor_courses-80578254898.jpg,'*/
	$data = isset($this->request->data['all_data'])?trim($this->request->data['all_data']):"";
	$error_status=0;
	/* Null Field Checking Start */
	if($device_id =='')
	{
	    $json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
	    echo json_encode($json_msg);
	    $error_status=1;
	    exit;
	}
	else if($user_id =='')
	{
	    $json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
	    echo json_encode($json_msg);
	    $error_status=1;
	    exit;
		    
	}
	else if($nonce =='')
	{
	    $json_msg = array('status'=>2,'msg'=>'Please Mention Nonce Token.')  ;
	    echo json_encode($json_msg);
	    $error_status=1;
	    exit;
		    
	}
	else if($amount =='')
	{
	    $json_msg = array('status'=>2,'msg'=>'Please Give Amount.')  ;
	    echo json_encode($json_msg);
	    $error_status=1;
	    exit;
		    
	}
	
       // echo ($user_type);exit();
	if(isset($device_id) && isset($user_id))
	{

	    $n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
	    
	    if($n_user_status==0)
	    {
		$json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else
	    {
		$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		
		$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		//pr($n_device_status);exit();
		if($n_device_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit; 
		}
		else
		{
		    //$username_arr = explode(' ',$user_name);
		    //pr($username_arr);
		    /*if(!empty($username_arr))
		    {
			$first_name	  = isset($username_arr[0])?$username_arr[0]:'';	
			$last_name	  = isset($username_arr[1])?$username_arr[1]:'';
		    }
		    */
		    $email = $n_user['User']['email_id'];
		    $first_name	  = $n_user['User']['first_name']; 	
		    $last_name	  = $n_user['User']['last_name'];
		    //echo $first_name.' - '.$last_name;
		    
		    $result = Braintree_Transaction::sale(array(
			"amount" => $amount,
			'paymentMethodNonce' => $nonce,
			'customer' => array(
			'id' => $user_id,
			'firstName' => $first_name,
			'lastName' => $last_name,
			'email' => $email
		      ),
			'options' => array(
			'submitForSettlement' => true
		      )
		    ));
	
		    //echo '<pre>'. pr($result).'</pre>'.'<br/>success= '.$result->success.'<br/>transaction_id = '.$result->transaction->_attributes['id'];
		    if(!empty($result))
		    {
			if($result->success) // success status sent from brain tree card payment.
			{
			    @mail('sumitra.unified@gmail.com','success','ranjita.unified@gmail.com');
			    $data_to_be_saved['Transaction']['user_id'] 	= $user_id;
			    $data_to_be_saved['Transaction']['nonce'] 		= $nonce;
			    $data_to_be_saved['Transaction']['transaction_id'] 	= $result->transaction->_attributes['id'];
			    $data_to_be_saved['Transaction']['payment_status']	= $result->transaction->_attributes['status'];
			    $data_to_be_saved['Transaction']['payment_type'] 	= $result->transaction->_attributes['type'];
			    $data_to_be_saved['Transaction']['amount'] 		= $result->transaction->_attributes['amount'];
			    $data_to_be_saved['Transaction']['currency'] 		= $result->transaction->_attributes['currencyIsoCode'];
			    $data_to_be_saved['Transaction']['merchant_acc_id'] 	= $result->transaction->_attributes['merchantAccountId'];
			    $data_to_be_saved['Transaction']['customer_first_name'] = $result->transaction->_attributes['customer']['firstName'];
			    $data_to_be_saved['Transaction']['customer_last_name']  = $result->transaction->_attributes['customer']['lastName'];
			    $data_to_be_saved['Transaction']['customer_email'] 	= $result->transaction->_attributes['customer']['email'];
			    $data_to_be_saved['Transaction']['card_type'] 		= $result->transaction->_attributes['creditCard']['cardType'];
			    $data_to_be_saved['Transaction']['last4_digit'] 	= $result->transaction->_attributes['creditCard']['last4'];
			    $data_to_be_saved['Transaction']['exp_month'] 		= $result->transaction->_attributes['creditCard']['expirationMonth'];
			    $data_to_be_saved['Transaction']['exp_year'] 		= $result->transaction->_attributes['creditCard']['expirationYear'];
			    $data_to_be_saved['Transaction']['created_date'] 	= date('Y-m-d h:i:s');
			    
			    if($this->Transaction->save($data_to_be_saved))
			    {@mail('sumitra.unified@gmail.com','save','ranjita.unified@gmail.com');
				$this->User->updateAll(array('User.paypal_status'=>1),array('User.id'=>$user_id));
				/*******************  File(Cirtificate images) updated to the database End ****************/
				if(!empty($data) && $data!="")
				{
				    $data_arr = explode(',',$data);
				    $update_err = 0;
				    foreach($data_arr as $each_data)
				    {
					if(!empty($each_data)){
					    $each_data_arr = explode('-',$each_data); //'tutor_degrees_id-tutor_degrees-image_name' or 'tutor_courses_id-tutor_courses-image_name'
					    if($each_data_arr[1]=='tutor_degrees')
					    {
						 if(copy($srcPath.$each_data_arr[2],$degree_destPath.$each_data_arr[2]))
						 {
						     $this->TutorDegree->updateAll(array('TutorDegree.photo'=>"'".$each_data_arr[2]."'"),array('TutorDegree.id'=>$each_data_arr[0]));
						     //pr($this->TutorDegree->getDataSource()->getLog(TRUE)); exit;
						     $update_err =1;
						     
						 }
					    }
					    else if($each_data_arr[1]=='tutor_courses')
					    {
						 if(copy($srcPath.$each_data_arr[2],$course_destPath.$each_data_arr[2]))
						 {
						     //echo $each_data_arr[1]."upload"; exit;
						     $this->TutorCourse->updateAll(array('TutorCourse.photo'=>"'".$each_data_arr[2]."'"),array('TutorCourse.id'=>$each_data_arr[0]));
						     //pr($this->TutorCourse->getDataSource()->getLog(TRUE)); exit;
						     $update_err =1;
						 }
					    }
					}
				       
				    }
				    
				}
				
				    $cmd = "wget -bq --spider ".BASE_URL."services/send_upload_mail?user_id=".$user_id;
				    shell_exec(escapeshellcmd($cmd));
				    
				//    $admin_user = $this->User->find('first', array('conditions' => array('User.id'=>1)));
				//    $mail_msg="<div style='width:80%;'><img src='".BASE_URL."img/coed_logo.jpeg'>
				//		<br/>
				//		Hello ".$admin_user['User']['first_name'].' '.$admin_user['User']['last_name']." ,
				//		<br/>
				//		  <p>".$n_user['User']['first_name'].' '.$n_user['User']['last_name']." has requested himself as a tutor and requested to verify his profile.Please login to admin to verify the credentials.</p>
				//		<p>Warmest Regards,<p/>
				//		<p>TutorApp Team<p/>
				//		</div>";
				//	//pr($admin_user); exit;	
				//    $Email = new CakeEmail();
				//    $Email->from(array(site_mail_id => 'TutorApp'));
				//    $Email->to($admin_user['User']['email_id']);
				//    $Email->subject('TutorApp Tutor Degree-Course Verification');
				//    $Email->emailFormat('html');
				//    $Email->send($mail_msg);
				//    @mail('sumitra.unified@gmail.com','mail gone','ranjita.unified@gmail.com');
				/******************** File(Cirtificate images) updated to the database End *********************/
				$json_msg = array('status'=>1,'msg'=>'Payment successfully completed.','data'=>$result)  ;
				echo json_encode($json_msg);
				exit; 
			    }
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>$result->message,'data'=>$result)  ;
			    echo json_encode($json_msg);
			    exit;
			}
			
		    }
		    else
		    {
			$json_msg = array('status'=>0,'msg'=>'Payment status failed.')  ;
			echo json_encode($json_msg);
			exit;
		    }
		}
	    } /* Else end active by admin*/
	}/* If End Device Id set*/
	else
	{
	    $json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
	    echo json_encode($json_msg);
	    exit;
	}
    }
    
    public function merchantCreation() /* Sub Merchant creation */
    {
	$this->braintreeConfiguration(); /* Braintree configuration details */
	$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	$first_name = isset($this->request->data['first_name'])?trim($this->request->data['first_name']):"";
	$last_name = isset($this->request->data['last_name'])?trim($this->request->data['last_name']):"";
	$email = isset($this->request->data['email'])?trim($this->request->data['email']):"";
	$dob = isset($this->request->data['dob'])?trim($this->request->data['dob']):"";
	//$phone = isset($this->request->data['phone'])?trim($this->request->data['phone']):"";
	$ssn = isset($this->request->data['ssn'])?trim($this->request->data['ssn']):"";
	$street_address = isset($this->request->data['street_address'])?trim($this->request->data['street_address']):"";
	$locality = isset($this->request->data['locality'])?trim($this->request->data['locality']):"";
	$region = isset($this->request->data['region'])?trim($this->request->data['region']):"";
	$postal_code = isset($this->request->data['postal_code'])?trim($this->request->data['postal_code']):"";
	
	$has_submerchant = $this->MerchantAccountDetails->find('count', array('conditions' => array('MerchantAccountDetails.user_id'=>$user_id)));
	//pr($has_submerchant);exit;
	if($has_submerchant>0)
	{
	    $json_msg = array('status'=>2,'msg'=>'You can not create more than one sub merchant with the same user.')  ;
	    echo json_encode($json_msg);
	    $error_status=1;
	    exit;
	}
	
	$randnumber = mt_rand(12345,99999); /* Random number for merchant id creation */
	
	$result = Braintree_MerchantAccount::create(
	array(
	    'individual' => array(
	    'firstName' => $first_name,
	    'lastName' => $last_name,
	    'email' => $email,
	    //'phone' => $phone,
	    'dateOfBirth' => $dob,
	    'ssn' => $ssn, //'456-45-4567',
	    'address' => array(
			    'streetAddress' => $street_address, //'111 Main St'
			    'locality' => $locality, //'Chicago'
			    'region' => $region, //'IL'
			    'postalCode' => $postal_code //'60622'
			    )
			),
	   'funding' => array(
	    //'descriptor' => 'Blue Ladders',
	    //'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
	    'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_EMAIL,
	    'email' => 'coeddev@gmail.com',
	    //'mobilePhone' => '5555555555',
	    //'accountNumber' => '1123581321',
	   // 'routingNumber' => '071101307'
	  ),
	  'tosAccepted' => true,
	  'masterMerchantAccountId' => "collaborativeeducationdev",//14ladders_marketplace
	  'id' => $first_name.$randnumber
	)
      );
	
	if(!empty($result))
	{
	    if($result->success)
	    {
		$data_to_be_saved['MerchantAccountDetails']['user_id'] 		= $user_id;
		$data_to_be_saved['MerchantAccountDetails']['sub_merchant_id'] 	= $result->merchantAccount->_attributes['id'];
		$data_to_be_saved['MerchantAccountDetails']['email_id'] 	= $email;
		$data_to_be_saved['MerchantAccountDetails']['first_name'] 	= $first_name;
		$data_to_be_saved['MerchantAccountDetails']['last_name'] 	= $last_name;
		$data_to_be_saved['MerchantAccountDetails']['dob'] 		= $dob;
		$data_to_be_saved['MerchantAccountDetails']['ssn'] 		= $ssn;
		$data_to_be_saved['MerchantAccountDetails']['street_address'] 	= $street_address;
		$data_to_be_saved['MerchantAccountDetails']['city'] 		= $locality;
		$data_to_be_saved['MerchantAccountDetails']['state'] 		= $region;
		$data_to_be_saved['MerchantAccountDetails']['zip_code'] 	= $postal_code;
		$data_to_be_saved['MerchantAccountDetails']['created_date'] 	= date('Y-m-d h:i:s');
		
		$this->MerchantAccountDetails->save($data_to_be_saved);
		$json_msg = array('status'=>1,'msg'=>'Merchant created successfully.','data'=>$result)  ;
		echo json_encode($json_msg);
		exit;
	    }
	    else 
	    {
		$json_msg = array('status'=>0,'msg'=>$result->_attributes['message'],'data'=>$result)  ;
		echo json_encode($json_msg);
		exit;
	    }
	}
	else
	{
	    $json_msg = array('status'=>0,'msg'=>'Transaction failed.')  ;
	    echo json_encode($json_msg);
	    exit;
	}
    }
    
    public function getVenmoAccountDetails() /* Getting Submerchant Id */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$submerchant = $this->MerchantAccountDetails->find('first', array('conditions' => array('MerchantAccountDetails.user_id'=>$user_id)));
			if(!empty($submerchant))
			{
			    //$submerchant['MerchantAccountDetails']['sub_merchant_id'];
			    $json_msg = array('status'=>1,'msg'=>'Sub Merchant account details.','data'=>$submerchant)  ;
			    echo json_encode($json_msg);
			    $error_status=1;
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>2,'msg'=>'Sub Merchant account not found.')  ;
			    echo json_encode($json_msg);
			    $error_status=1;
			    exit;
			}
		    }
		}
	    }
	}
    }
    
    
    public function paymentsubMerchantCheckout() /* Payment for Merchant and Sub merchant */
    {
	$this->braintreeConfiguration(); /* Braintree configuration details */
	$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	$nonce = isset($this->request->data['payment_method_nonce'])?trim($this->request->data['payment_method_nonce']):"";//The nonce is 	792ccbb8-068e-44a7-9031-c62a491a6de8
	$amount = isset($this->request->data['amount'])?trim($this->request->data['amount']):"";
	$service_fee_amount = isset($this->request->data['service_fee_amount'])?trim($this->request->data['service_fee_amount']):"";
	$merchant_account_id =  isset($this->request->data['merchant_account_id'])?trim($this->request->data['merchant_account_id']):"";
	//$email = isset($this->request->data['email'])?trim($this->request->data['email']):"";

	$result = Braintree_Transaction::sale(
                                     array(
                                            'merchantAccountId' => $merchant_account_id,
                                            'amount' => $amount,
                                            'paymentMethodNonce' => $nonce,
                                            'serviceFeeAmount' => $service_fee_amount
                                            )
                                     );
	if(!empty($result))
	{
	    if($result->success) // success status sent from brain tree card payment.
	    {
		$json_msg = array('status'=>1,'msg'=>'Payment successfully completed.','data'=>$result)  ;
		echo json_encode($json_msg);
		exit;
	    }
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>$result->message,'data'=>$result)  ;
		echo json_encode($json_msg);
		exit;
	    }
	    
	}
	else
	{
	    $json_msg = array('status'=>0,'msg'=>'Payment status failed.')  ;
	    echo json_encode($json_msg);
	    exit;
	}
	
    }
    
    /********************** Edit Student Profile Start ****************************/
    public function fetchStudentData()
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	  
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {   
			
			$this->User->bindModel(
						array(
    
						    "hasOne"=>array(
							
							"StudentProfile"=>array('foreignKey'=>'user_id',
							'className'=>"StudentProfile",'conditions' => array(), 'type' => 'LEFT'),
							
							
							)
						    ),false
						);
			
		    $data= $this->User->find("all",array('fields'=>array('User.id','User.first_name','User.last_name','User.email_id','User.gender','User.date_of_birth','User.home_state','StudentProfile.id','StudentProfile.user_id','StudentProfile.university_id','StudentProfile.seeking_tutor_university','StudentProfile.student_year','StudentProfile.major'),'conditions'=>array('User.id'=>$user_id)));
		    //pr($data); exit;
		    
		    for($i=0; $i<count($data);$i++)
		    {
			if($data[$i]['StudentProfile']['student_year'] !='')
			{
			    $data[$i]['User']['student_year'] = $data[$i]['StudentProfile']['student_year'];
			}
			else
			{
			   $data[$i]['User']['student_year'] = ""; 
			}
			
			if($data[$i]['StudentProfile']['major'] !='')
			{
			    $data[$i]['User']['major'] = $data[$i]['StudentProfile']['major'];
			}
			else
			{
			   $data[$i]['User']['major'] = ""; 
			}
			
			if($data[$i]['StudentProfile']['id'] !='')
			{
			    $get_university = $this->University->find("first",array('conditions'=>array('University.id'=>$data[$i]['StudentProfile']['university_id'])));
			    $get_seeking_university = $this->University->find("first",array('conditions'=>array('University.id'=>$data[$i]['StudentProfile']['seeking_tutor_university'])));
			    
			    $data[$i]['User']['student_profile_id'] = $data[$i]['StudentProfile']['id'];
			}
			else
			{
			    $data[$i]['User']['student_profile_id'] ="";
			}
			
			
			if($data[$i]['StudentProfile']['university_id'] !='')
			{
			    $data[$i]['User']['university_id'] = $get_university['University']['id'];
			    $data[$i]['User']['university'] = $get_university['University']['university_name'];
			}
			else
			{
			    $data[$i]['User']['university_id'] = "";
			    $data[$i]['User']['university'] = "";
			   // $data[$i]['User']['seeking_university'] = "";
			}
			
			if($data[$i]['StudentProfile']['seeking_tutor_university'] !='')
			{
			    $data[$i]['User']['seeking_tutor_university_id'] = $get_seeking_university['University']['id'];
			    $data[$i]['User']['seeking_tutor_university'] = $get_seeking_university['University']['university_name'];
			}
			else
			{
			    $data[$i]['User']['seeking_tutor_university_id'] = "";
			    $data[$i]['User']['seeking_tutor_university'] = "";
			}
			
			
			
		    }
			if(!empty($data))
			{
			    $json_msg = array('status'=>1,'msg'=>'All data fetched.','data'=>$data);
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $json_msg = array('status'=>0,'msg'=>'No data found.')  ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    
    public function editStudentProfile() /* Update Student profile data */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
	    $seeking_university_id = isset($this->request->data['seeking_university_id'])?trim($this->request->data['seeking_university_id']):"";
	    $student_year = isset($this->request->data['year'])?trim($this->request->data['year']):"";
	    $major = isset($this->request->data['major'])?trim($this->request->data['major']):"";
	    $gender = isset($this->request->data['gender'])?trim($this->request->data['gender']):"";
	    $dob = isset($this->request->data['dob'])?trim($this->request->data['dob']):"";
	    $home_state = isset($this->request->data['home_state'])?trim($this->request->data['home_state']):"";
	    $student_profile_id = isset($this->request->data['student_profile_id'])?trim($this->request->data['student_profile_id']):"";
	  
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$data_to_be_saved=array('User.gender'=>"'$gender'",'User.date_of_birth'=>"'$dob'",'User.home_state'=>"'$home_state'"); 
			$this->User->updateAll($data_to_be_saved,array('User.id'=>$user_id));
			
			$data_found = $this->StudentProfile->find("count",array('conditions'=>array('StudentProfile.user_id'=>$user_id)));
			
			if($data_found>0)
			{
			    $data_to_be_saved1=array('StudentProfile.university_id'=>$university_id,'StudentProfile.seeking_tutor_university'=>$seeking_university_id,'StudentProfile.student_year'=>"'$student_year'",'StudentProfile.major'=>"'$major'",'StudentProfile.modified_date'=>'"'.date('Y-m-d h:i:s').'"'); 
			    $this->StudentProfile->updateAll($data_to_be_saved1,array('StudentProfile.id'=>$student_profile_id));
			    
			    $json_msg = array('status'=>1,'msg'=>'Student profile updated successfully.') ;
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $data_to_be_saved1['StudentProfile']['user_id']=$user_id;
			    $data_to_be_saved1['StudentProfile']['university_id']=$university_id;
			    $data_to_be_saved1['StudentProfile']['seeking_tutor_university']=$seeking_university_id;
			    $data_to_be_saved1['StudentProfile']['student_year']=$student_year;
			    $data_to_be_saved1['StudentProfile']['major']=$major;
			    $data_to_be_saved1['StudentProfile']['created_date']=date('Y-m-d h:i:s');
			    $data_to_be_saved1['StudentProfile']['modified_date']=date('Y-m-d h:i:s');
			    
			    $this->StudentProfile->save($data_to_be_saved1);
			    
			    $json_msg = array('status'=>1,'msg'=>'Student profile updated successfully.') ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials.')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    

    
    public function editSubmerchant() /* Update Student profile data */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	    $university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
	    $seeking_university_id = isset($this->request->data['seeking_university_id'])?trim($this->request->data['seeking_university_id']):"";
	    $student_year = isset($this->request->data['year'])?trim($this->request->data['year']):"";
	    $major = isset($this->request->data['major'])?trim($this->request->data['major']):"";
	    $gender = isset($this->request->data['gender'])?trim($this->request->data['gender']):"";
	    $dob = isset($this->request->data['dob'])?trim($this->request->data['dob']):"";
	    $home_state = isset($this->request->data['home_state'])?trim($this->request->data['home_state']):"";
	    $student_profile_id = isset($this->request->data['student_profile_id'])?trim($this->request->data['student_profile_id']):"";
	  
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$data_to_be_saved=array('User.gender'=>"'$gender'",'User.date_of_birth'=>"'$dob'",'User.home_state'=>"'$home_state'"); 
			$this->User->updateAll($data_to_be_saved,array('User.id'=>$user_id));
			
			$data_found = $this->StudentProfile->find("count",array('conditions'=>array('StudentProfile.user_id'=>$user_id)));
			
			if($data_found>0)
			{
			    $data_to_be_saved1=array('StudentProfile.university_id'=>$university_id,'StudentProfile.seeking_tutor_university'=>$seeking_university_id,'StudentProfile.student_year'=>"'$student_year'",'StudentProfile.major'=>"'$major'",'StudentProfile.modified_date'=>'"'.date('Y-m-d h:i:s').'"'); 
			    $this->StudentProfile->updateAll($data_to_be_saved1,array('StudentProfile.id'=>$student_profile_id));
			    
			    $json_msg = array('status'=>1,'msg'=>'Student profile updated successfully.') ;
			    echo json_encode($json_msg);
			    exit;
			}
			else
			{
			    $data_to_be_saved1['StudentProfile']['user_id']=$user_id;
			    $data_to_be_saved1['StudentProfile']['university_id']=$university_id;
			    $data_to_be_saved1['StudentProfile']['seeking_tutor_university']=$seeking_university_id;
			    $data_to_be_saved1['StudentProfile']['student_year']=$student_year;
			    $data_to_be_saved1['StudentProfile']['major']=$major;
			    $data_to_be_saved1['StudentProfile']['created_date']=date('Y-m-d h:i:s');
			    $data_to_be_saved1['StudentProfile']['modified_date']=date('Y-m-d h:i:s');
			    
			    $this->StudentProfile->save($data_to_be_saved1);
			    
			    $json_msg = array('status'=>1,'msg'=>'Student profile updated successfully.') ;
			    echo json_encode($json_msg);
			    exit;
			}
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials.')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    
    public function getAllList() /* list of university,major,year,home state */
    {
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{
	    $device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
	    $user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
	   
	    $error_status=0;
	    /* Null Field Checking Start */
	    if($device_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'Device Id required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
	    }
	    else if($user_id =='')
	    {
		$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
		echo json_encode($json_msg);
		$error_status=1;
		exit;
			
	    }
	    
	    
	    if(isset($device_id) && isset($user_id))
	    {
		$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		if($n_user_status==0)
		{
		    $json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
		    echo json_encode($json_msg);
		    $error_status=1;
		    exit;
		}
		else
		{
		    $n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
		    $n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
		    //pr($n_device_status);exit();
		    if($n_device_status==0)
		    {
			$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit; 
		    }
		    else
		    {
			$n_university = $this->University->find('all', array('conditions' => array('University.status'=>1),'order'=>array('University.university_name'=>'ASC')));
			//pr($n_university); exit;
			$n_major=$this->Major->find('all', array('conditions' => array('Major.status'=>1),'order'=>array('Major.major'=>'ASC')));
			//pr($n_major); exit;
			$n_year = $this->Year->find('all', array('conditions' => array('Year.status'=>1),'order'=>array('Year.year'=>'ASC')));
			//pr($n_year); exit;
			$n_homestate = $this->HomeState->find('all', array('conditions' => array('HomeState.status'=>1),'order'=>array('HomeState.home_state'=>'ASC')));
			//pr($n_homestate); exit;
			
			$json_msg = array('status'=>1,'msg'=>'Get all data.','data'=>array(
                                
                                'university_list'=>$this->appify_a_result_array($n_university,'University'),
				'major_list'=>$this->appify_a_result_array($n_major,'Major'),
				'year_list'=>$this->appify_a_result_array($n_year,'Year'),
                                'home_state_list'=>$this->appify_a_result_array($n_homestate,'HomeState')

                                )) ;
			echo json_encode($json_msg);
			exit;
		    } //Device id found else end
		} // Active User else end
	    } // device id and  user id set if end
	    else
	    {
		$json_msg = array('status'=>0,'msg'=>'Invalid login credentials.')  ;
		echo json_encode($json_msg);
		exit;
    
	    }
	}
    }
    
    /********************* Mile Stone 5 Start 26-08-2015 *************************/
    
    public function filterLessTutor() /* Less Filter Search */
    {
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
			$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
			$university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
			$subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
			$subject_code_id = isset($this->request->data['subject_code_id'])?trim($this->request->data['subject_code_id']):"";
		   
			$error_status=0;
			/* Null Field Checking Start */
			if($university_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Please select university.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			else if($subject_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Please select subject.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			else if($subject_code_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Please select subject code.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			
			if(($device_id =='' && $user_id !='') || ($device_id !='' && $user_id ==''))
			{
			$json_msg = array('status'=>2,'msg'=>'Invalid credentials.User Id and Device Id not matched.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			if(($device_id !='') && ($user_id !=''))
			{
			$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
			if($n_user_status==0)
			{
				$json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
			}
			else
			{
				$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
				$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
				//pr($n_device_status);exit();
				if($n_device_status==0)
				{
				$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit; 
				}
			}
			}
			//else
			//{
				$this->TutorCourse->bindModel(
							array(
						
								"belongsTo"=>array(
								"University"=>array('foreignKey'=>false,
								'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
								'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
								'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
								'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
								'User' => array('foreignKey' => 'user_id', 'className' => 'User', 'conditions' => '', 'type' => 'LEFT'),
										
									)
								),false
									
							 );
		
				$data_all_course=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name','User.*'),'conditions'=>array('TutorCourse.status'=>1,'TutorCourse.availibility'=>1,'TutorCourse.university_id'=>$university_id,'TutorCourse.subject_id'=>$subject_id,'TutorCourse.subject_code_id'=>$subject_code_id)));
				//'TutorCourse.availibility'=>1,
				//pr($data_all_course); exit;	
				
					$data_all_degree = array();
				$i=0;
				foreach($data_all_course as $each_course)
				{
	
					$this->TutorDegree->bindModel(
						array(
		
							"belongsTo"=>array(
							'Degree' => array('foreignKey' => 'degree_id', 'className' => 'Degree', 'conditions' => array(), 'type' => 'LEFT'),
							)
						),false
						 );
					
					$degree_arr = $this->TutorDegree->find('all',array('fields'=>array(),'conditions'=>array('TutorDegree.user_id'=>$each_course['TutorCourse']['user_id'],'TutorDegree.status'=>1,'TutorDegree.verified'=>1)));
					//pr($degree_arr); exit;
					
					$user_degree =array();
					if(!empty($degree_arr))
					{
					foreach($degree_arr as $degree_list)
					{
						$user_degree[] = $degree_list['Degree']['name']." '".date('y',strtotime($degree_list['TutorDegree']['year']));
						//$user_degree1[] = $degree_list['Degree']['verified'];
					}
					}
					
					$user_degree = implode(',',$user_degree);
					$show_all[$i]['TutorCourse']['degree']=$user_degree;
					
					$rel = array();
					if($user_id !='')
					{
					$rel = $this->StudentTutorRelation->find("first",array('fields'=>array('StudentTutorRelation.status'),'conditions'=>array('StudentTutorRelation.student_id'=>$user_id,'StudentTutorRelation.tutor_id'=>$each_course['TutorCourse']['user_id'])));
					}
					
					
					if(!empty($rel))
					{
					$show_all[$i]['TutorCourse']['like_status']=$rel['StudentTutorRelation']['status'];
					}
					else
					{
					$show_all[$i]['TutorCourse']['like_status']="";
					}
					
					$ratings = $this->TutorRating->find("count",array('fields'=>array('TutorRating.ratings'),'conditions'=>array('TutorRating.tutor_id'=>$each_course['TutorCourse']['user_id']))); //'TutorRating.given_by'=>$user_id,
					$sum_ratings = $this->TutorRating->find("first",array('fields'=>array('sum(TutorRating.ratings) AS total_rate '),'conditions'=>array('TutorRating.tutor_id'=>$each_course['TutorCourse']['user_id'])));
					//pr($sum_ratings);
					//echo $sum_ratings[$i]['total_rate'];//exit;
					if(!empty($ratings))
					{
					$show_all[$i]['TutorCourse']['total_rating']="".$ratings."";
					$show_all[$i]['TutorCourse']['avg_rating']="".round(($sum_ratings[0]['total_rate']/$ratings),2)."";
					}
					else
					{
					$show_all[$i]['TutorCourse']['total_rating']="";
					$show_all[$i]['TutorCourse']['avg_rating']="";
					}
					
					
					
					$show_all[$i]['TutorCourse']['tutor_id']=$each_course['User']['id'];
					$show_all[$i]['TutorCourse']['tutor_rate']=$each_course['User']['charge_per_hour'];
					$show_all[$i]['TutorCourse']['profile_quotes']=$each_course['User']['profile_quotes'];
					$show_all[$i]['TutorCourse']['tutor_full_name']=$each_course['User']['first_name'];//.' '.$each_course['User']['first_name']
					if($each_course['User']['prof_image']!='' && file_exists("uploads/ProfImage/".$each_course['User']['prof_image']))
					{
					$show_all[$i]['TutorCourse']['tutor_profile_img']=BASE_URL.'uploads/ProfImage/'.$each_course['User']['prof_image'];
					}
					else
					{
					$show_all[$i]['TutorCourse']['tutor_profile_img']="";
					}
					$show_all[$i]['TutorCourse']['subject_details']=$each_course['Subject']['subject_name'].' '.$each_course['SubjectCode']['sub_code'].'-'.$each_course['SubjectProfessor']['professor_name'];
					$show_all[$i]['TutorCourse']['grade']=$each_course['TutorCourse']['grade'];
					$show_all[$i]['TutorCourse']['course_verified']=$each_course['TutorCourse']['verified'];
					$show_all[$i]['TutorCourse']['tutor_verified']=$each_course['User']['paypal_status'];
					
					$i++;
				}
				//pr($show_all); exit;
				if(!empty($show_all))
				{
					$json_msg = array('status'=>1,'msg'=>'Fetch search data.','data'=>$show_all)  ;
					echo json_encode($json_msg);
					exit;
				}
				else
				{
					$json_msg = array('status'=>0,'msg'=>'No data found.')  ;
					echo json_encode($json_msg);
					exit;
				}
		}
		}
		
		public function doRating() /* Give rating tutor from student side */
		{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			//echo "h"; exit;
			$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
			$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
			$tutor_id = isset($this->request->data['tutor_id'])?trim($this->request->data['tutor_id']):"";
			$ratings = isset($this->request->data['ratings'])?trim($this->request->data['ratings']):"";
		   
			$error_status=0;
			/* Null Field Checking Start */
			if($device_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Device Id required.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			else if($user_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			else if($tutor_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Tutor Id Required.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			else if($ratings =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Please give ratings.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			
			if(isset($device_id) && isset($user_id))
			{
			$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
			if($n_user_status==0)
			{
				$json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
			}
			else
			{
				$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
				$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
				//pr($n_device_status);exit();
				if($n_device_status==0)
				{
				$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit; 
				}
				else
				{
				$n_ratings = $this->TutorRating->find('count', array('conditions' => array('TutorRating.tutor_id'=>$tutor_id,'TutorRating.given_by'=>$user_id)));
				if($n_ratings>0)
				{
					$json_msg = array('status'=>2,'msg'=>'You already rated this tutor.')  ;
					echo json_encode($json_msg);
					$error_status=1;
					exit; 
				}
				else
				{
					$data_to_be_saved['TutorRating']['tutor_id'] = $tutor_id;
					$data_to_be_saved['TutorRating']['given_by'] = $user_id;
					$data_to_be_saved['TutorRating']['ratings']  = $ratings;
					$data_to_be_saved['TutorRating']['created']  = date('Y-m-d h:i:s');
					if($this->TutorRating->save($data_to_be_saved))
					{
					$json_msg = array('status'=>2,'msg'=>'Tutor rated successfully.')  ;
					echo json_encode($json_msg);
					$error_status=1;
					exit; 
					}
					else
					{
					$json_msg = array('status'=>2,'msg'=>'Some error occured.Unfortunately tutor not rated.')  ;
					echo json_encode($json_msg);
					$error_status=1;
					exit; 
					}
				}
				
				} //Device id found else end
			} // Active User else end
			} // device id and  user id set if end
			else
			{
			$json_msg = array('status'=>0,'msg'=>'Invalid login credentials.')  ;
			echo json_encode($json_msg);
			exit;
		
			}
		}
		}
		
		public function likeDislikeByStudent() /* Like dislike (Accepted and Rejected list) */
		{
			if($_SERVER['REQUEST_METHOD'] === 'POST')
			{
				$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
				$user_id = isset($this->request->data['student_id'])?trim($this->request->data['student_id']):"";
				$tutor_id = isset($this->request->data['tutor_id'])?trim($this->request->data['tutor_id']):"";
				$status = isset($this->request->data['status'])?trim($this->request->data['status']):"";
			   
				$error_status=0;
				/* Null Field Checking Start */
				if($device_id =='')
				{
				$json_msg = array('status'=>2,'msg'=>'Device Id required.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
				}
				else if($user_id =='')
				{
				$json_msg = array('status'=>2,'msg'=>'User Id Required.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
				}
				else if($tutor_id =='')
				{
				$json_msg = array('status'=>2,'msg'=>'Tutor Id Required.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
				}
				else if($status =='')
				{
				$json_msg = array('status'=>2,'msg'=>'Please send status.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
				}
				
				if(isset($device_id) && isset($user_id))
				{
				$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
				if($n_user_status==0)
				{
					$json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
					echo json_encode($json_msg);
					$error_status=1;
					exit;
				}
				else
				{
					$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
					$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
					//pr($n_device_status);exit();
					if($n_device_status==0)
					{
					$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
					echo json_encode($json_msg);
					$error_status=1;
					exit; 
					}
					else
					{
					$n_ratings = $this->StudentTutorRelation->find('count', array('conditions' => array('StudentTutorRelation.tutor_id'=>$tutor_id,'StudentTutorRelation.student_id'=>$user_id)));
					if($n_ratings>0)
					{
						$json_msg = array('status'=>2,'msg'=>'Tutor already in the list.')  ;
						echo json_encode($json_msg);
						$error_status=1;
						exit; 
					}
					else
					{
						$data_to_be_saved['StudentTutorRelation']['tutor_id'] = $tutor_id;
						$data_to_be_saved['StudentTutorRelation']['student_id'] = $user_id;
						$data_to_be_saved['StudentTutorRelation']['status']  = $status;
						$data_to_be_saved['StudentTutorRelation']['created']  = date('Y-m-d h:i:s');
						if($this->StudentTutorRelation->save($data_to_be_saved))
						{
						$json_msg = array('status'=>1,'msg'=>'Tutor send to the like-dislike list successfully.')  ;
						echo json_encode($json_msg);
						$error_status=1;
						exit; 
						}
						else
						{
						$json_msg = array('status'=>2,'msg'=>'Some error occured.')  ;
						echo json_encode($json_msg);
						$error_status=1;
						exit; 
						}
					}
					
					} //Device id found else end
				} // Active User else end
				} // device id and  user id set if end
				else
				{
				$json_msg = array('status'=>0,'msg'=>'Invalid login credentials.')  ;
				echo json_encode($json_msg);
				exit;
			
				}
			}
		}
		
		public function searchedTutorDetails()  /* ALL DATA OF TUTOR FETCHED WITH THIS SERVICE. */
		{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
				{
	
					$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
					$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
					
					$error_status=0;
					/* Null Field Checking Start */
						if($device_id =='')
						{
							$json_msg = array('status'=>2,'msg'=>'Device Id required')  ;
							echo json_encode($json_msg);
							$error_status=1;
							exit;
						}
	
						else if($user_id =='')
						{
							$json_msg = array('status'=>2,'msg'=>'Not a valid user.Please login again.')  ;
							echo json_encode($json_msg);
							$error_status=1;
							exit;
									
						}
	
	
						
					   // echo ($user_type);exit();
					if(isset($device_id) && isset($user_id))
					{
	
							$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
							
							if($n_user_status==0)
							{
								$json_msg = array('status'=>2,'msg'=>'Account blocked by admin.')  ;
								echo json_encode($json_msg);
								$error_status=1;
								exit;
							}
							else
							{
	
								$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
								
								$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
								//pr($n_device_status);exit();
								if($n_device_status==0)
								{
									$json_msg = array('status'=>2,'msg'=>'Please log in again.')  ;
									echo json_encode($json_msg);
									$error_status=1;
									exit; 
								}
					else
					{
					$this->TutorCourse->bindModel(
							array(
						
								"belongsTo"=>array(
								"University"=>array('foreignKey'=>false,
								'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
								'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
								'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
								'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
									)
								),false
									
							 );
		
				$data_all_course=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name'),'conditions'=>array('TutorCourse.status'=>1,'TutorCourse.availibility'=>1,'TutorCourse.user_id'=>$user_id)));
					
					$final_arr =array();
					if(!empty($data_all_course))
					{
						foreach($data_all_course as $each_course)
						{
							$course_ratings = $this->CourseRating->find("count",array('fields'=>array('CourseRating.ratings'),'conditions'=>array('CourseRating.course_id'=>$each_course['TutorCourse']['id']))); //'TutorRating.given_by'=>$user_id,
							$course_sum_ratings = $this->CourseRating->find("first",array('fields'=>array('sum(CourseRating.ratings) AS total_rate '),'conditions'=>array('CourseRating.course_id'=>$each_course['TutorCourse']['id'])));
							//pr($course_sum_ratings); exit;
							//echo $course_sum_ratings[$i]['total_rate'];//exit;
							if(!empty($course_ratings))
							{
								$show_all['TutorCourseRating']['id'] = $each_course['TutorCourse']['id'];
								$show_all['TutorCourseRating']['total_rating']="".$course_ratings."";
								$show_all['TutorCourseRating']['avg_rating']="".round(($course_sum_ratings[0]['total_rate']/$course_ratings),2)."";
							}
							else
							{
								$show_all['TutorCourseRating']['id'] = $each_course['TutorCourse']['id'];
								$show_all['TutorCourseRating']['total_rating']="";
								$show_all['TutorCourseRating']['avg_rating']="";
							}
							$final_arr[]= $show_all['TutorCourseRating'];
								
						}
					}
					
					
					$this->TutorDegree->bindModel(
	
													array(
	
														"belongsTo"=>array(
															"School"=>array('foreignKey'=>false,
															'className'=>"School",'conditions' => array("TutorDegree.school_id=School.id"), 'type' => 'LEFT'),
															'Degree' => array('foreignKey' => false, 'className' => 'Degree', 'conditions' => array('TutorDegree.degree_id=Degree.id'), 'type' => 'LEFT'),
															'DegreeSubject' => array('foreignKey' => false, 'className' => 'DegreeSubject', 'conditions' => array('TutorDegree.degree_subject_id=DegreeSubject.id'), 'type' => 'LEFT'),
																		
																)
															),false
													 
												 );
								 
										$data_all_degree=$this->TutorDegree->find('all',array('fields'=>array('TutorDegree.*','School.id','School.school_name','Degree.id','Degree.name','DegreeSubject.id','DegreeSubject.name'),'conditions'=>array('TutorDegree.user_id'=>$user_id,'TutorDegree.status'=>1)));
						
					/********** Tutor Ratings Start ***********/
					
						$ratings = $this->TutorRating->find("count",array('fields'=>array('TutorRating.ratings'),'conditions'=>array('TutorRating.tutor_id'=>$user_id))); //'TutorRating.given_by'=>$user_id,
						$sum_ratings = $this->TutorRating->find("first",array('fields'=>array('sum(TutorRating.ratings) AS total_rate '),'conditions'=>array('TutorRating.tutor_id'=>$user_id)));
						//pr($sum_ratings);
						//echo $sum_ratings[$i]['total_rate'];//exit;
						
					/********** Tutor Rating End **************/
					if($n_user['User']['prof_image']!='')
					$n_user['User']['prof_image']=BASE_URL.'uploads/ProfImage/'.$n_user['User']['prof_image'];
					$show_all['user_details']=$n_user;
					$show_all['tutor_course_details']=$data_all_course;
					$show_all['tutor_degree_details']=$data_all_degree;
					$show_all['TutorCourseRating']=$final_arr;
					
					
					
					if(!empty($ratings))
						{
						$show_all['tutor_total_rating']="".$ratings."";
						$show_all['tutor_avg_rating']="".round(($sum_ratings[0]['total_rate']/$ratings),2)."";
						}
						else
						{
						$show_all['tutor_total_rating']="";
						$show_all['tutor_avg_rating']="";
						}
						
					//pr($show_all); exit;
					if(!empty($show_all))
					{
						$json_msg = array('status'=>1,'msg'=>'All data fetched of searced tutor.','data'=>$show_all)  ;
						echo json_encode($json_msg);
						exit;
					}
					else
					{
						$json_msg = array('status'=>0,'msg'=>'No data found.')  ;
						echo json_encode($json_msg);
						exit;
					}
					
					}
					
				}
			}
			else
			{
				$json_msg = array('status'=>0,'msg'=>'Invalid login credentials')  ;
				echo json_encode($json_msg);
				exit;
	 
			}
			}
		}
		
		
		public function advanceTutorSearch() /* Advance Search */
		{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$device_id = isset($this->request->data['device_id'])?trim($this->request->data['device_id']):"";
			$user_id = isset($this->request->data['user_id'])?trim($this->request->data['user_id']):"";
			$university_id = isset($this->request->data['university_id'])?trim($this->request->data['university_id']):"";
			$subject_id = isset($this->request->data['subject_id'])?trim($this->request->data['subject_id']):"";
			$subject_code_id = isset($this->request->data['subject_code_id'])?trim($this->request->data['subject_code_id']):"";
			$min_charge = isset($this->request->data['min_charge'])?trim($this->request->data['min_charge']):"";
			$max_charge = isset($this->request->data['max_charge'])?trim($this->request->data['max_charge']):"";
			$prof = isset($this->request->data['professor_id'])?trim($this->request->data['professor_id']):"";
			$year = isset($this->request->data['year'])?trim($this->request->data['year']):"";
			$name = isset($this->request->data['name'])?trim($this->request->data['name']):"";
		   
		   	$price_short = isset($this->request->data['price'])?trim($this->request->data['price']):"";
			$short_rate = isset($this->request->data['short_rate'])?trim($this->request->data['short_rate']):"";
			
			$error_status=0;
			/* Null Field Checking Start */
			if($university_id =='')
			{
			$json_msg = array('status'=>2,'msg'=>'Please select university.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			$subject_condition = $subject_code_condition='';
			if($subject_id !='')
			{
				$subject_condition = " TutorCourse.subject_id = '".$subject_id."'";
			}
			if($subject_code_id !='')
			{
				$subject_code_condition = " TutorCourse.subject_code_id = '".$subject_code_id."'";
			}
			
			$order_condition='';
			if($price_short !='')
			{
				$order_condition = " 'order'=> array('User.charge_per_hour'=>".$price_short.")";
			}
			else if($short_rate !='')
			{
				$order_condition = " 'order'=> array('User.tutor_avg_rating'=>".$short_rate.")";
			}
			//echo $order_condition ;
			if(($device_id =='' && $user_id !='') || ($device_id !='' && $user_id ==''))
			{
			$json_msg = array('status'=>2,'msg'=>'Invalid credentials.User Id and Device Id not matched.')  ;
			echo json_encode($json_msg);
			$error_status=1;
			exit;
			}
			if(($device_id !='') && ($user_id !=''))
			{
			$n_user_status = $this->User->find('count', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
			if($n_user_status==0)
			{
				$json_msg = array('status'=>2,'msg'=>'Your account is not activated yet or you are blocked by admin.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit;
			}
			else
			{
				$n_user = $this->User->find('first', array('conditions' => array('User.id'=>$user_id,'User.status'=>1,'User.admin_status'=>1)));
				$n_device_status = $this->DeviceTable->find('count', array('conditions' => array('DeviceTable.user_id' => $n_user['User']['id'],'DeviceTable.device_id'=>$device_id,'DeviceTable.status'=>1)));
				//pr($n_device_status);exit();
				if($n_device_status==0)
				{
				$json_msg = array('status'=>2,'msg'=>'Not valid user.Please log in again.')  ;
				echo json_encode($json_msg);
				$error_status=1;
				exit; 
				}
			}
			}
			//else
			//{
				$charge_conditions = '';
				if($min_charge !='' && $max_charge !='')
				$charge_conditions = "  User.charge_per_hour >= $min_charge  AND User.charge_per_hour <= $max_charge";
				
				$prof_conditions= '';
				if($prof !='')
				$prof_conditions = "  TutorCourse.subject_professor_id = '".$prof."'";
				
				$this->TutorCourse->bindModel(
							array(
						
								"belongsTo"=>array(
								"University"=>array('foreignKey'=>false,
								'className'=>"University",'conditions' => array("TutorCourse.university_id=University.id"), 'type' => 'LEFT'),
								'Subject' => array('foreignKey' => false, 'className' => 'Subject', 'conditions' => array('TutorCourse.subject_id=Subject.id'), 'type' => 'LEFT'),
								'SubjectCode' => array('foreignKey' => false, 'className' => 'SubjectCode', 'conditions' => array('TutorCourse.subject_code_id=SubjectCode.id'), 'type' => 'LEFT'),
								'SubjectProfessor' => array('foreignKey' => false, 'className' => 'SubjectProfessor', 'conditions' => array('TutorCourse.subject_professor_id=SubjectProfessor.id'), 'type' => 'LEFT'),
								'User' => array('foreignKey' => 'user_id', 'className' => 'User', 'conditions' => '', 'type' => 'LEFT'),
										
									)
								),false
									
							 );
		
				$data_all_course=$this->TutorCourse->find('all',array('fields'=>array('TutorCourse.*','University.id','University.university_name','Subject.id','Subject.subject_name','SubjectCode.id','SubjectCode.sub_code','SubjectProfessor.id','SubjectProfessor.professor_name','User.*'),'conditions'=>array('TutorCourse.status'=>1,'TutorCourse.availibility'=>1,'TutorCourse.university_id'=>$university_id,$subject_condition,$subject_code_condition,$charge_conditions,$prof_conditions),$order_condition));
				//'TutorCourse.availibility'=>1,
				//pr($data_all_course); exit;	
				
					$data_all_degree = array();
				$i=0;
				foreach($data_all_course as $each_course)
				{
	
					$this->TutorDegree->bindModel(
						array(
		
							"belongsTo"=>array(
							'Degree' => array('foreignKey' => 'degree_id', 'className' => 'Degree', 'conditions' => array(), 'type' => 'LEFT'),
							)
						),false
						 );
					
					$degree_arr = $this->TutorDegree->find('all',array('fields'=>array(),'conditions'=>array('TutorDegree.user_id'=>$each_course['TutorCourse']['user_id'],'TutorDegree.status'=>1,'TutorDegree.verified'=>1)));
					//pr($degree_arr); exit;
					
					$user_degree =array();
					if(!empty($degree_arr))
					{
					foreach($degree_arr as $degree_list)
					{
						$user_degree[] = $degree_list['Degree']['name']." '".date('y',strtotime($degree_list['TutorDegree']['year']));
						//$user_degree1[] = $degree_list['Degree']['verified'];
					}
					}
					
					$user_degree = implode(',',$user_degree);
					$show_all[$i]['TutorCourse']['degree']=$user_degree;
					
					$rel = array();
					if($user_id !='')
					{
					$rel = $this->StudentTutorRelation->find("first",array('fields'=>array('StudentTutorRelation.status'),'conditions'=>array('StudentTutorRelation.student_id'=>$user_id,'StudentTutorRelation.tutor_id'=>$each_course['TutorCourse']['user_id'])));
					}
					
					
					if(!empty($rel))
					{
					$show_all[$i]['TutorCourse']['like_status']=$rel['StudentTutorRelation']['status'];
					}
					else
					{
					$show_all[$i]['TutorCourse']['like_status']="";
					}
					
					$ratings = $this->TutorRating->find("count",array('fields'=>array('TutorRating.ratings'),'conditions'=>array('TutorRating.tutor_id'=>$each_course['TutorCourse']['user_id']))); //'TutorRating.given_by'=>$user_id,
					$sum_ratings = $this->TutorRating->find("first",array('fields'=>array('sum(TutorRating.ratings) AS total_rate '),'conditions'=>array('TutorRating.tutor_id'=>$each_course['TutorCourse']['user_id'])));
					//pr($sum_ratings);
					//echo $sum_ratings[$i]['total_rate'];//exit;
					if(!empty($ratings))
					{
					$show_all[$i]['TutorCourse']['total_rating']="".$ratings."";
					$show_all[$i]['TutorCourse']['avg_rating']="".round(($sum_ratings[0]['total_rate']/$ratings),2)."";
					}
					else
					{
					$show_all[$i]['TutorCourse']['total_rating']="";
					$show_all[$i]['TutorCourse']['avg_rating']="";
					}
					
					
					
					$show_all[$i]['TutorCourse']['tutor_id']=$each_course['User']['id'];
					$show_all[$i]['TutorCourse']['tutor_rate']=$each_course['User']['charge_per_hour'];
					$show_all[$i]['TutorCourse']['profile_quotes']=$each_course['User']['profile_quotes'];
					$show_all[$i]['TutorCourse']['tutor_full_name']=$each_course['User']['first_name'];//.' '.$each_course['User']['first_name']
					if($each_course['User']['prof_image']!='' && file_exists("uploads/ProfImage/".$each_course['User']['prof_image']))
					{
					$show_all[$i]['TutorCourse']['tutor_profile_img']=BASE_URL.'uploads/ProfImage/'.$each_course['User']['prof_image'];
					}
					else
					{
					$show_all[$i]['TutorCourse']['tutor_profile_img']="";
					}
					$show_all[$i]['TutorCourse']['subject_details']=$each_course['Subject']['subject_name'].' '.$each_course['SubjectCode']['sub_code'].'-'.$each_course['SubjectProfessor']['professor_name'];
					$show_all[$i]['TutorCourse']['grade']=$each_course['TutorCourse']['grade'];
					$show_all[$i]['TutorCourse']['course_verified']=$each_course['TutorCourse']['verified'];
					$show_all[$i]['TutorCourse']['tutor_verified']=$each_course['User']['paypal_status'];
					
					$i++;
				}
				//pr($show_all); exit;
				if(!empty($show_all))
				{
					$json_msg = array('status'=>1,'msg'=>'Fetch search data.','data'=>$show_all)  ;
					echo json_encode($json_msg);
					exit;
				}
				else
				{
					$json_msg = array('status'=>0,'msg'=>'No data found.')  ;
					echo json_encode($json_msg);
					exit;
				}
		}
    }
	
    /********************* Mile Stone 5 End 26-08-2015 *************************/
}
?>