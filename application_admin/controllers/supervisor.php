<?php
 //error_reporting(E_ALL);
class Supervisor extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'supervisor';
		$this->load->model('ModelSupervisor');
	}

	function index()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/index/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','20');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['recordset'] 		= $this->ModelSupervisor->getList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "supervisor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_supervisor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'supervisor/index';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function addedit($id = 0)
	{
		$this->functions->checkAdmin($this->controller.'/');
		//if add or edit
		$startRecord  	= 0;
		$contentId 		= $this->uri->segment(3, 0);
		$page 			= $this->uri->segment(4, 0);

		if($page > 0)
			$startRecord = $page;

		$page = $startRecord;

		$data['controller'] 		= $this->controller;
		$data['action'] 			= "Add";
		$data['params']['page'] 	= $page;
		$data['do_addedit_link']	= base_url($this->controller."/do_addedit/".$id."/".$page."/");
		$data['back_link']			= base_url($this->controller."/index/");
		$data['allcountry']		= $this->ModelSupervisor->getCountry();
		$data['id']=$id;
		if($contentId > 0)
		{
			$data['id']	= $id;
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelSupervisor->getSingle($contentId);
			
			if(is_array($rs))
			{
				foreach($rs as $key => $val)
				{
					if(!is_numeric($key))
					{
						$data[$key] = $val;
					}
				}
			}
		}else{
			$data['action'] 	= "Add";
			$data['id']			= 0;
		}
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'supervisor/add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	function do_addedit()
	{
		
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		//pr($_FILES);
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$password = $this->randomPassword();
			$data['first_name'] 	     = ($this->input->post('first_name'))?$this->input->post('first_name'):'';
			$data['middle_name'] 	     = ($this->input->post('middle_name'))?$this->input->post('middle_name'):'';
			$data['last_name'] 	     = ($this->input->post('last_name'))?$this->input->post('last_name'):'';
			$data['email']       = $this->input->post('email');
			$data['phone']       = $this->input->post('phone');
			$data['crn']    = ($this->input->post('crn'))?$this->input->post('crn'):'';
			$data['doj']    = ($this->input->post('doj'))?date('Y-m-d',strtotime($this->input->post('doj'))):'';
			$data['department']    = ($this->input->post('department'))?$this->input->post('department'):'';
			$data['member_type'] = 2;
			$data['created']     = date('Y-m-d H:i:s');
			$data['is_active']   = 1;
			$data['password']   = md5($password);
			$data['country']    = ($this->input->post('country_id'))?$this->input->post('country_id'):'';
            $data['state']    	= ($this->input->post('state_id'))?$this->input->post('state_id'):'';
            $data['city']    = ($this->input->post('city_id'))?$this->input->post('city_id'):'';
			$data['zip']    = ($this->input->post('zip'))?$this->input->post('zip'):'';
		}else{
			$data['first_name'] 	     = ($this->input->post('first_name'))?$this->input->post('first_name'):'';
			$data['middle_name'] 	     = ($this->input->post('middle_name'))?$this->input->post('middle_name'):'';
			$data['last_name'] 	     = ($this->input->post('last_name'))?$this->input->post('last_name'):'';
            $data['doj']    = ($this->input->post('doj'))?date('Y-m-d',strtotime($this->input->post('doj'))):'';
			$data['department']    = ($this->input->post('department'))?$this->input->post('department'):'';			
			$data['modified'] 			= date('Y-m-d H:i:s');
			$data['country']    = $this->input->post('country_id');
            $data['state']    = $this->input->post('state_id');
            $data['city']    = $this->input->post('city_id');
            $data['zip']    = $this->input->post('zip');
		}
		
		
		
		if($_FILES['picture']['name'])
        {
			//pr($_FILES);
			$memberImage             = $_FILES['picture']['name'];
			$fileMemberImage         = time().$memberImage;
			$config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name']     = $fileMemberImage;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('picture')) {
				$this->nsession->set_userdata('errmsg',$this->upload->display_errors());
				redirect(base_url('supervisor/addedit/'.$contentId));
				return true;
			} else {
				$upload_data = array('upload_data' => $this->upload->data());
				$dataSet = $this->upload->data();
				$Imgdata = $this->upload->data();
				$source_path = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"];
				$target_path = file_upload_absolute_path() . '/profile_pic/tmp/' . $dataSet["file_name"];
				$configer = array(
					'image_library' => 'gd2',
					'source_image' => $source_path,
					'new_image' => $target_path,
					'maintain_ratio' => TRUE,
					'create_thumb' => TRUE,
					'width' => 280,
					'height' => 280
				);
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				$Imgdata['thamble_image'] = $dataSet['file_name'];
			}
			if($upload_data['upload_data']['file_name']) {
				$implodeData = explode('.',$upload_data['upload_data']['file_name']);
				$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
				$data['picture'] = 'profile_pic/'.$upload_data['upload_data']['file_name'];
				$data['crop_profile_image'] = 'profile_pic/tmp/'.$thumbImgNme;
			}
		}

        
		
		if($contentId==0){
			//pr($data);
			
			$result = $this->ModelSupervisor->addContent($data,$Imgdata);
			
			$to 				= $data['email'];
			$subject			='Supervisor Registration';
			$body='<tr><td>Hi,</td></tr>
					<tr style="background:#fff;"><td>We have added you as a supervisor . </td></tr>
					<tr><td>CRN: '.$data['crn'].'</td></tr>
					<tr><td>Password: '.$password.'</td></tr>
					<tr><td>So, Please Login to enter our site</td></tr>
					<tr><td><a href="'.front_base_url().'supervisor/login">Click Here</a></td></tr>';
			$this->functions->mail_template($to,$subject,$body);
			$this->nsession->set_userdata('succmsg','supervisor added successfully.');
			redirect(base_url($this->controller));
			
		}else{
			
			//pr($data);
			
			$this->ModelSupervisor->editContent($data,$contentId,$Imgdata);
			
			
			if(count($_FILES["certificate"]["name"])>0)
			{
				$config["upload_path"] = file_upload_absolute_path().'supervisor_certificate/';
				$config["allowed_types"] = 'gif|jpg|png';
				$this->upload->initialize($config);
				for($count = 0; $count<count($_FILES["certificate"]["name"]); $count++)
				{
					$_FILES["certificates"]["name"]      = time().$_FILES["certificate"]["name"][$count];
					$_FILES["certificates"]["type"]      = $_FILES["certificate"]["type"][$count];
					$_FILES["certificates"]["tmp_name"]  = $_FILES["certificate"]["tmp_name"][$count];
					$_FILES["certificates"]["error"]     = $_FILES["certificate"]["error"][$count];
					$_FILES["certificates"]["size"]      = $_FILES["certificate"]["size"][$count];
					if($this->upload->do_upload('certificates'))
					{
						//$certificateData[] = $this->upload->data();
						$Imgdata1 = $this->upload->data();
						
						$certificateData[$count]['certificate'] = file_upload_base_url().'supervisor_certificate/'.$Imgdata1["file_name"];
						$certificateData[$count]['member_id'] = $contentId;
						//$this->ModelSupervisor->addcertificate($certificateData);
					}
				}
				
			}
			
			//pr($certificateData); 
			if($certificateData){
			
				$this->ModelSupervisor->addcertificate($certificateData);
			
			}
			
			$this->nsession->set_userdata('succmsg','supervisor updated successfully.');
			redirect(base_url($this->controller));
		}
	}

	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelSupervisor->activate($id);
		 $result = $this->ModelSupervisor->getsingle_empdata($id);
		 $email 		= $result->email;
		 $first_name 	= $result->name;
		 $to 			= $email;
		 $subject 		= 'MMR Account Activated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		$this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully supervisor Activated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelSupervisor->inactive($id);
		 $result 		= $this->ModelSupervisor->getsingle_empdata($id);
		 $email 			= $result->email;
		 $first_name 		= $result->name;
		 $to 				= $email;
		 $subject		='MMR Account deactivated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		$this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully supervisor Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function viewdetails($id){
		if($id){
			$rs = $this->ModelSupervisor->getSingle($id);
			//pr($rs);
			//$row = $rs->fields;
			if(is_array($rs))
			{
				foreach($rs as $key => $val)
				{
					if(!is_numeric($key))
					{
						$data[$key] = $val;
					}
				}
			}
			$data['succmsg'] = $this->nsession->userdata('succmsg');
			$data['errmsg'] = $this->nsession->userdata('errmsg');
			$this->nsession->set_userdata('succmsg', "");
			$this->nsession->set_userdata('errmsg', "");
			$elements = array();
			$elements['menu'] = 'menu/index';
			$elements['topmenu'] = 'menu/topmenu';
			$elements['main'] = 'supervisor/view_details';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}

	}
	public function emailExist($id=0){
		$email_id = $this->input->post('email');
		$return = $this->ModelSupervisor->checkEmail($email_id,$id);
		if(count($return)!=''){
			$error = "false";
		}else{
			$error = "true";
		}
		echo $error;
	}
	public function phoneExist($id=0){
		$phone = $this->input->post('phone');
		$return = $this->ModelSupervisor->checkPhone($phone,$id);
		if(count($return)!=''){
			$error = "false";
		}else{
			$error = "true";
		}
		echo $error;
	}
	public function crnExist($id=0){
		$crn = $this->input->post('crn');
		$return = $this->ModelSupervisor->checkCrn($crn,$id);
		if(count($return)!=''){
			$error = "false";
		}else{
			$error = "true";
		}
		echo $error;
	}
	public function do_delete(){
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelSupervisor->doDeleteMemeber($id);
		$result 		= $this->ModelSupervisor->getsingle_empdata($id);
		$email 			= $result->email;
		$first_name = $result->first_name;

		$to 				= $email;
		$subject		='KSC Account deleted';
		$body='<tr><td>Hi,</td></tr>
				<tr><td>Name : '.$first_name.'</td></tr>
				<tr style="background:#fff;"><td>Your account has been deleted from ksc rent.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully account deleted.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function delete($id){
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelSupervisor->delete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully supervisor deleted.');
		redirect(base_url($this->controller."/index/"));
	}
	
	function delete_certificate($id,$member_id){
	
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelSupervisor->delete_certificate($id);
		$this->nsession->set_userdata('succmsg', 'Successfully supervisor deleted.');
		redirect(base_url($this->controller."/addedit/".$member_id."/0"));
	}
	
	function getCountry()
	{
	   $catId = $this->input->post('country_id');		
	   echo json_encode($this->functions->getAllTable('states','id,name','country_id',$catId));
	}
	
	function getCity()
	{
	   $catId= $this->input->post('state_id');
	   echo json_encode($this->functions->getAllTable('cities','id,name','state_id',$catId));
	}

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	 

}
?>
