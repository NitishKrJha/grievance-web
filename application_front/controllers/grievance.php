<?php
class Grievance extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'grievance';
		$this->load->model('ModelCommon');
		$this->load->model('ModelGrievance');
	}
	
	public function index()
	{
        $this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
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
		$param['sortField'] 		= $this->input->request('sortField','grievances.id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','10');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$data['list']		= $this->ModelGrievance->getList($config,$start,$param,$memberId);
		
		$data['startRecord'] 	= $start;
		$data['module']			= "Grievance List";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('GLIST');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//pr($data);
        $elements = array();
		$elements['header'] = 'layout/header';
		$element_data['header'] = $data;
		$elements['main'] = 'grievance/index';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function detail($id=0)
	{
		$this->functions->checkUser($this->controller.'/detail/'.$id,true);
		$memberId = $this->nsession->userdata('member_session_id');
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
	   
		$data['detail'] = $this->ModelGrievance->getDetailById($id);
		if(empty($data['detail'])){
			$this->nsession->set_userdata('errmsg','You have requested for invalid Page');
			redirect(base_url($this->controller.'/index/'));
			return;
		}
        $elements = array();
		$elements['header'] = 'layout/header';
		$element_data['header'] = $data;
		$elements['main'] = 'grievance/detail';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function add()
	{
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['departments'] = $this->ModelCommon->getAllDatalist('department',array('status'=>'1'));
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
       
        $elements = array();
		$elements['header'] = 'layout/header';
		$element_data['header'] = $data;
		$elements['main'] = 'grievance/add';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function doAdd(){
        $response=array();
        if(!$this->input->post('subject')){
            $data = array('status' => false, 'message' => 'Subject is blank','data'=>array());
            // $this->response($data);
        }else if(!$this->input->post('body')){
            $data = array('status' => false, 'message' => 'Body is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('department_id')){
            $data = array('status' => false, 'message' => 'department is blank','data'=>array());
            // $this->response($data);
        }else if(!$_FILES['file']['name']){
			$data = array('status' => false, 'message' => 'Please upload a valid file','data'=>array());
            // $this->response($data);
		}else{
			//pr($_FILES);
			$member_session_id=$this->nsession->userdata('member_session_id');
			$file             = $_FILES['file']['name'];
			$config['upload_path'] 	 = file_upload_absolute_path().'grievance/';
			$config['allowed_types'] = 'jpeg|pdf|doc|docx|png';
			$config['file_name']     = md5(date('Y-m-d H:i:s')).md5($member_session_id);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')) {
				$this->nsession->set_userdata('errmsg',$this->upload->display_errors());
				$data = array('status' => false, 'message' => 'Please upload a valid file','data'=>array());
            	redirect(base_url('grievance/index'));
			} else {
				$upload_data = $this->upload->data();
			}
			if($upload_data['file_name']) {
				$file_name = $upload_data['file_name'];
				$file_type = $upload_data['file_type'];
			}

            $subject=$this->input->post('subject');
			$department_id=$this->input->post('department_id');
			$query=$this->input->post('body');
			$email=($this->input->post('optional_email'))?$this->input->post('optional_email'):'';
			$phone=($this->input->post('optional_phone'))?$this->input->post('optional_phone'):'';
			$date=date('Y-m-d H:i:s');
			
			$insert_data=array(
				'subject'=>$subject,
				'query'=>$query,
				'department_id'=>$department_id,
				'optional_phone'=>$phone,
				'optional_email'=>$email,
				'created_date'=>$date,
				'created_by'=>$member_session_id,
				'modified_date'=>$date,
				'status'=>'0'
			);
			if(isset($file_name)){
				$insert_data['file_name']=$file_name;
				$insert_data['file_type']=$file_type;
			}
			$result=$this->ModelCommon->insertData('grievances',$insert_data);
			$data = array('status' => true, 'message' => 'Added Successfully');
			$this->nsession->set_userdata('succmsg',$data['message']);
			// $this->response($data);
		}
		if($data['status']==true){
			$this->nsession->set_userdata('succmsg',$data['message']);
		}else{
			$this->nsession->set_userdata('errmsg',$data['message']);
		}
		redirect(base_url('grievance/index'));
	}
	
	function response($data){
        echo json_encode($data); die();
    }

}
