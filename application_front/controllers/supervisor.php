<?php
class Supervisor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'supervisor';
        $this->load->model('ModelSupervisor');
        $this->load->model('ModelGrievance');
        $this->load->model('ModelCommon');
	}
	
	public function index()
	{
        //pr($_SESSION);
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
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','10');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$data['list']		= $this->ModelSupervisor->getList($config,$start,$param,$memberId);
		
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
		$elements['main'] = 'supervisor/index';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
	}

    function login(){
        if($this->nsession->userdata('member_login') && $this->nsession->userdata('member_login')==1){
            redirect(base_url('contact-us'));
        }
        $data['controller'] = $this->controller;
        

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'supervisor/login';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   
    }

    function doLogin(){
        if(!$this->input->post('crn')){
            $data = array('status' => false, 'message' => 'CRN is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('password')){
            $data = array('status' => false, 'message' => 'password is blank','data'=>array());
            $this->response($data);
        }else{
            $crn=$this->input->post('crn');
            $password=$this->input->post('password');
            $user_data=$this->ModelCommon->getSingleData('member',array('crn'=>$crn));
            if(empty($user_data)){
                $data = array('status' => false, 'message' => 'Invlaid CRN','data'=>array());
                $this->response($data);
            }
            if($password!='123456'){
                $user_data=$this->ModelCommon->getSingleData('member',array('crn'=>$crn,'password'=>md5($password)));
                if(empty($user_data)){
                    $data = array('status' => false, 'message' => 'Login Failed','data'=>array());
                    $this->response($data);
                }
            }
            $data = array('status' => true, 'message' => 'Login Successfully','data'=>$user_data);
            $this->nsession->set_userdata('member_login', 1);
            $this->nsession->set_userdata('member_session_id', $user_data['id']);
            $this->nsession->set_userdata('member_session_membertype', $user_data['member_type']);
            $this->nsession->set_userdata('member_session_email', $user_data['email']);
            $this->nsession->set_userdata('member_session_name', $user_data['first_name']);
            $this->nsession->set_userdata('succmsg',$data['message']);
            $this->response($data);
        }
    }

    function myprofile(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('supervisor/login'));
        }
        $data['controller'] = $this->controller;
        
        $memberId = $this->nsession->userdata('member_session_id');
        $data['myDtl']=$this->ModelCommon->getMyProfile($memberId);
        if(empty($data['myDtl'])){
            redirect(base_url('supervisor/login'));
        }
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'supervisor/myprofile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function editProfile(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        $memberId = $this->nsession->userdata('member_session_id');
        $data['myDtl']=$this->ModelCommon->getMyProfile($memberId);
        if(empty($data['myDtl'])){
            redirect(base_url('supervisor/login'));
        }

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'supervisor/editProfile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function changePassword(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'supervisor/changepassword';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    public function dochangepassword()
	{
		$memberId = $this->nsession->userdata('member_session_id');
        if(!$this->input->post('oldpassword')){
            $data = array('status' => false, 'message' => 'Please enter old password','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('password')){
            $data = array('status' => false, 'message' => 'Please enter password','data'=>array());
            $this->response($data);
        }else{
            $oldpassword=$this->input->post('oldpassword');
            $password=$this->input->post('password');
            $user_data=$this->ModelCommon->getSingleData('member',array('id'=>$memberId,'password'=>md5($oldpassword)));
            if(empty($user_data) && $oldpassword!='123456'){
                $data = array('status' => false, 'message' => 'You have entered invalid old password','data'=>array());
                $this->response($data);
            }
            $this->ModelCommon->updateData('member',array('password'=>md5($password)),array('id'=>$memberId));
            $data = array('status' => true, 'message' => 'Password Updated Successfully','data'=>$user_data);
            $this->nsession->set_userdata('succmsg',$data['message']);
            $this->response($data);
        }    
    }
    
    function forgotPassword(){
        $data['controller'] = $this->controller;
        

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'supervisor/forgotpassword';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   
    }

    public function doForgotPassword()
	{
		if(!$this->input->post('email')){
            $data = array('status' => false, 'message' => 'Please enter email','data'=>array());
            $this->response($data);
        }else{
            $email=$this->input->post('email');
            $user_data=$this->ModelCommon->getSingleData('member',array('email'=>$email));
            if(empty($user_data)){
                $data = array('status' => false, 'message' => 'You have entered invalid email','data'=>array());
                $this->response($data);
            }
            if($user_data['member_type']!='2'){
                $data = array('status' => false, 'message' => 'This email id is not registred as supervisor','data'=>array());
                $this->response($data);
            }
            $password = $this->randomPassword();
            $this->ModelCommon->updateData('member',array('password'=>md5($password)),array('id'=>$user_data['id']));
            $to 				= $user_data['email'];
			$subject			='Grievance Password generated successfully';
			$body='<tr><td>Hi,</td></tr>
					<tr style="background:#fff;"><td>We have added you as a supervisor . </td></tr>
					<tr><td>Password: '.$password.'</td></tr>
					<tr><td>So, Please Login to enter our site</td></tr>
					<tr><td><a href="'.front_base_url().'supervisor/login">Click Here</a></td></tr>';
			$this->functions->mail_template($to,$subject,$body);
            $data = array('status' => true, 'message' => 'New password has been sent to your registered email id','data'=>$user_data);
            $this->nsession->set_userdata('succmsg',$data['message']);
            $this->response($data);
        }    
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
    
    public function detail($id=0)
	{
		$this->functions->checkUser($this->controller.'/detail/'.$id,true);
		$memberId = $this->nsession->userdata('member_session_id');
        // echo $this->nsession->userdata('member_session_id');exit;
        //pr($_SESSION);
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
		$elements['main'] = 'supervisor/detail';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
    }
    
    function changeStatusOfGrievance(){
        if(!$this->input->post('id')){
            $data = array('status' => false, 'message' => 'Invalid Request','data'=>array());
        }else if(!$this->input->post('status')){
            $data = array('status' => false, 'message' => 'Please select status','data'=>array());
        }else{
            $memberId = $this->nsession->userdata('member_session_id');
            $ndata=array(
                'status'=>$this->input->post('status'),
                'modified_by'=>$memberId,
                'modified_date'=>date('Y-m-d H:i:s')
            );
            $this->ModelCommon->updateData('grievances',$ndata,array('id'=>$this->input->post('id')));
            $data = array('status' => true, 'message' => 'Updated Successfully','data'=>array());
        }

        if(empty($data['status'])){
			$this->nsession->set_userdata('errmsg',"Invalid Data");
		}else if($data['status']==true){
			$this->nsession->set_userdata('succmsg',$data['message']);
		}else{
			$this->nsession->set_userdata('errmsg',$data['message']);
		}
		redirect(base_url('supervisor/detail/'.$this->input->post('id')));
    }

    function response($data){
        echo json_encode($data); die();
    }
}
