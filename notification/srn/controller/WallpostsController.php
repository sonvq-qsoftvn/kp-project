<?php
App::uses('CakeEmail', 'Network/Email');
class WallpostsController extends AppController  
{
	public $helpers = array('Html', 'Form', 'Paginator','Functions'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator','Upload'); //loading necessary components
	
	//models used 
	var $uses=array('Clinic','Clinicmanager','Speciality','Insurance','Insurancetoclinic','Openinghour','Sitesetting','Cliniclike','Doctor','Openinghour','User', 'Cliniclikes', 'Eligibilitie', 'Eligibilitieclinc','Wallpost','Comment');
        //declaring paginator options
        public $paginate = array(
        'limit' => 10,
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

	//Wallpost :: Tabular view
	
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
			$this->set('title_for_layout','Manage Wallpost'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
                        
               //binding models for inner join
			 $this->Wallpost->bindModel(array(
						'belongsTo' => array(
							'Clinic' => array('foreignKey' =>false,'className'=>'Clinic','conditions'=>array("Wallpost.clinic_id=Clinic.id and Wallpost.status = 1" ),'type' => 'INNER'),
				'User'=>array('foreignKey' =>false,'className'=>'User','conditions'=>array("User.id=Wallpost.user_id and User.status=1"),'type' => 'INNER'),
					)
				)
			,false);
			 
			
			$this->paginate['conditions']='Clinic.status=1';
               $this->Paginator->settings = $this->paginate;
               $data = $this->Paginator->paginate('Wallpost');
			  // pr($data);
			  // exit;
			$this->set('all_wallposts',$data);
			$this->set('left_sidebar_selected','wallposts');
			$this->set('msg',$msg);
		}
		else
		{
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	
	//Wallpost :: Tabular view
	
	//Featured Wallpost...
	
	public function featured()
	{
		$this->layout='ajax';
		$this->autoRender=false;
		//checking whether logged or not
		
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			
			$wallpost_id=$this->request->data['post_id'];
			$status=$this->request->data['status'];
			/*======change the satus of featured for update start======*/
			
			$totalwallpost = $this->Wallpost->find('count', array('conditions' => array('Wallpost.featured' => $status)));
			
			//if($totalwallpost < 4  || $status ==0)
			//{
				$this->Wallpost->updateAll(array('Wallpost.featured' => $status),array('Wallpost.id' => $wallpost_id));
				//pr($this->Doctor->getDataSource()->getLog(TRUE));
				echo "Wallpost featured for home page successfully updated.";
			//}
			/*else
			{
				echo "Limit exceeded.\n You can not featured more than four wallpost for home page.";
			}*/
			
			
		}
	}
	/*---featuredE nd-----*/
	
	/*Show Wall post View--*/
function viewwallpost()
   {
	
	$post_id = $this->params->query['postid'];
	if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			$this->set('title_for_layout','View Wallpost'); // setting title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			
		/*For Wall Posts*/
			$edit_wall_post = $this->Wallpost->find('all', array('conditions' => array('Wallpost.id' => $post_id)));
			$clinic_id = $edit_wall_post[0]['Wallpost']['clinic_id'];
			$this->set('edit_wall_post',$edit_wall_post);
			//pr($edit_wall_post);
		/*For Wall Posts End*/
		}
   }
   
   
}
	?>