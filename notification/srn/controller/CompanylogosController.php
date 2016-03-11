<?php
class CompanylogosController extends AppController
{
	public $helpers = array('Html', 'Form', 'Paginator'); //loading necessary helpers
	public $components=array('Session','Cookie','Paginator','Upload'); //loading necessary components
	
     //declaring paginator options
     public $paginate = array(
        'limit' => 5,
        'order' => array('Companylogo.company_name' => 'asc'));
        
	//models used
	var $uses=array('Content', 'Sitesetting', 'Companylogo');
	
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

	//CMS For Pages :: Tabular view
	
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
			$this->set('title_for_layout','Images For Home'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
                        $this->Paginator->settings = $this->paginate;

                        $data = $this->Paginator->paginate('Companylogo');
                        $this->set('all_home_images',$data);
			$this->set('left_sidebar_selected','listfeaturein');
			$this->set('msg',$msg);
			
		}
		else
		{
			
			return $this->redirect(BASE_URL.'administrator');  //if not logged sending to login page
		}
		
	}
	
	//CMS For Pages :: Edit Company logo Page

	function addfeature()
	{
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Add Feature In'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','listfeaturein');
					
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				$this->Companylogo->create();
				
				//creating array for save data
				
				$data_to_be_saved=$this->request->data;
				$data_to_be_saved['Companylogo']['company_name']=$this->request->data['Companylogo']['company_name'];
				//$data_to_be_saved['Companylogo']['company_logo']=$this->request->data['company_logo'];
				$data_to_be_saved['Companylogo']['created_date']=date('Y-m-d h:i:s');
				
				
				$error_status=0;
				if($data_to_be_saved['Companylogo']['company_name']=='')
				{
					$msg[]='Please enter company name';
					$error_status=1;
				}
				
				if($_FILES['company_logo']['name']!='')
				{
					$portitions_arr=explode('.',$_FILES['company_logo']['name']);
					$n=count($portitions_arr);
					$extension=$portitions_arr[$n-1];
					if($extension=='jpg'||$extension=='JPG'||$extension=='JPEG'||$extension=='jpeg'||$extension=='PNG'||$extension=='png'||$extension=='gif'||$extension=='GIF'||$extension=='ico'||$extension=='ICO')
					{
						if($_FILES['company_logo']['size']>2*1024*1024)
						{
							$msg[]='Please upload company logo  of size 2MB maximum';
							$error_status=1;	
						}
						else
						{
										
							$filename=$_FILES['company_logo']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['company_logo']['tmp_name'];
							$filename=rand(100,999).time().'.'.$ext;
							$folder="./admin/company_logo/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry company logo file upload failed.Please try again.....';
								
								$error_status=1;
							}
							else
							{
								$target_path = "./admin/company_logo/thumb_company_logo/".$filename;
								$medium_target_path = "./admin/company_logo/medium_company_logo/".$filename;
								$source_path = $path;
								$this->Sitesetting->thumbnail($target_path, $source_path,  '150','150', '');
								$this->Sitesetting->thumbnail($medium_target_path, $source_path, '462','462', '');
				
								$data_to_be_saved['Companylogo']['company_logo']=$filename;
							}	
						}
					}
					else
					{
						$msg[]='Please upload company logo of following extensions only.<ul><li>jpeg</li><li>jpg</li><li>png</li><li>gif</li><li>ico</li></ul>';
							
						$error_status=1;
					}
					
				}
				//Logo  code end..//
				//serverside validation ends
				
				if($error_status==0)
				{
					if ($this->Companylogo->save($data_to_be_saved))
					{
						$this->Session->write('msg','addsuccess');
						return $this->redirect(BASE_URL.'administrator/listfeaturein');
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/listfeaturein');	
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
	
	/*-----Edit Image Start-----*/
	
function editfeature()
	{
		if($this->Session->check('reid_admin_logged')&&$this->Session->check('reid_admin_uid')&&($this->Session->read('reid_admin_logged')==1)&&($this->Session->read('reid_admin_uid')!=''))
		{
			$this->layout='admin'; //loading admin layout
			//pr($this->params->query);
			if(isset($this->params->query['logoid']))
			{
				$id=$this->params->query['logoid']; //picking up the  id
			}
			
			//checking whether id is not null or 0
			
			if($id==null||$id==''||$id==0||!$id)
			{
				$this->Session->write('msg','editinvalid');				
				return $this->redirect(BASE_URL.'administrator/listfeaturein');  //if null or zero sending to listing page
			}
			
			$feature = $this->Companylogo->findById($id);
			$this->set('feature',$feature);
			//checking whether clinic  with supplied id exists or not?
			
			
			if (!$feature)
			{
				$this->Session->write('msg','editnofeature');	
				return $this->redirect(BASE_URL.'administrator/listfeaturein');  //if null or zero sending to listing page
			}
			
			
			//setting values for view page starts
			
			$this->set('title_for_layout','Edit Feature In'); // setting dashboard title
			$this->set('meta_description_content','SeeDoctor.sg Admin Panel'); //content for meta name = Description
			$this->set('left_sidebar_selected','listfeaturein');
			
			//setting values ends
			
			if ($this->request->is(array('post', 'put')))
			{
				$this->Companylogo->create();
				
				//creating array for save data
				
				$data_to_be_saved=$this->request->data;
				$data_to_be_saved['Companylogo']['company_name']=$this->request->data['Companylogo']['company_name'];
				//$data_to_be_saved['Companylogo']['company_logo']=$this->request->data['company_logo'];
				$data_to_be_saved['Companylogo']['created_date']=date('Y-m-d h:i:s');
				
				
				$error_status=0;
				if($data_to_be_saved['Companylogo']['company_name']=='')
				{
					$msg[]='Please enter company name';
					$error_status=1;
				}
				
				if($_FILES['company_logo']['name']!='')
				{
					$portitions_arr=explode('.',$_FILES['company_logo']['name']);
					$n=count($portitions_arr);
					$extension=$portitions_arr[$n-1];
					if($extension=='jpg'||$extension=='JPG'||$extension=='JPEG'||$extension=='jpeg'||$extension=='PNG'||$extension=='png'||$extension=='gif'||$extension=='GIF'||$extension=='ico'||$extension=='ICO')
					{
						if($_FILES['company_logo']['size']>2*1024*1024)
						{
							$msg[]='Please upload company logo  of size 2MB maximum';
							$error_status=1;	
						}
						else
						{
										
							$filename=$_FILES['company_logo']['name'];
							$file_arr=explode('.',$filename);
							$ext=$file_arr[count($file_arr)-1];
							$tmp=$_FILES['company_logo']['tmp_name'];
							$filename=rand(100,999).time().'.'.$ext;
							$folder="./admin/company_logo/";
							$path=$folder.$filename;
							if(!move_uploaded_file($tmp,$path))
							{
								$msg[]='Sorry company logo file upload failed.Please try again.....';
								
								$error_status=1;
							}
							else
							{
								$target_path = "./admin/company_logo/thumb_company_logo/".$filename;
								$medium_target_path = "./admin/company_logo/medium_company_logo/".$filename;
								$source_path = $path;
								$this->Sitesetting->thumbnail($target_path, $source_path,  '150','150', '');
								$this->Sitesetting->thumbnail($medium_target_path, $source_path, '462','462', '');
				
								$data_to_be_saved['Companylogo']['company_logo']=$filename;
							}	
						}
					}
					else
					{
						$msg[]='Please upload company logo of following extensions only.<ul><li>jpeg</li><li>jpg</li><li>png</li><li>gif</li><li>ico</li></ul>';
							
						$error_status=1;
					}
					
				}
				//Logo  code end..//
				//serverside validation ends
				
				if($error_status==0)
				{
					if ($this->Companylogo->save($data_to_be_saved))
					{
						$this->Session->write('msg','addsuccess');
						return $this->redirect(BASE_URL.'administrator/listfeaturein');
					}
					$this->Session->write('msg','addfailure');
					return $this->redirect(BASE_URL.'administrator/listfeaturein');	
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
	
	/*---- Edit Image End-----*/
	
	/*----------------------------------------------------------------------------------------------------------------------------------------*/
	

}
?>